<?php

require_once '../catalog/controller/extension/payment/lib/mercadopago.php';
require_once '../catalog/controller/extension/payment/lib/mp_util.php';

class ControllerExtensionPaymentMpStandard extends Controller {

	private static $mp_util;
	private static $mp;

	function get_instance_mp_util() {
		if ($this->mp_util == null) 
			$this->mp_util = new MPOpencartUtil();

		return $this->mp_util;
	}

	function get_instance_mp() {
		if ( $this->mp == null ) {
			$client_id = isset( $this->request->post['payment_mp_standard_client_id'] ) ?
				$this->request->post['payment_mp_standard_client_id'] :
				$this->config->get( 'payment_mp_standard_client_id' );
			$client_secret = isset( $this->request->post['payment_mp_standard_client_secret'] ) ?
				$this->request->post['payment_mp_standard_client_secret'] :
				$this->config->get( 'payment_mp_standard_client_secret' );
			$this->mp = new MP( $client_id, $client_secret );
		}
		return $this->mp;
	}

	public function index() {

		$this->load->language( 'extension/payment/mp_standard' );
		$this->document->setTitle( $this->language->get( 'heading_title' ) );
		$this->load->model( 'setting/setting' );

		$valid_credentials = true;
		$has_payments_available = true;
		$isSponsorInvalid = true;
		$country_id = $this->config->get( 'payment_mp_standard_country' ) != null ?
			$this->config->get( 'payment_mp_standard_country' ) : 'MLA';

		if ( ( $this->request->server['REQUEST_METHOD'] == 'POST' ) ) {

			if ( $this->request->post['payment_nro_count_payment_methods'] > 0 ) {

				if ( isset( $this->request->post['payment_mp_standard_methods'] ) ) {
					$names = $this->request->post['payment_mp_standard_methods'];
					$this->request->post['payment_mp_standard_methods'] = implode( ',', $names );
					if ( $this->request->post['payment_nro_count_payment_methods'] <= count( $names ) ) {
						$has_payments_available = false;
					}
				}
			} else {
				$has_payments_available = false;
			}

			if ( ! $this->validate_credentials() ) {
				$valid_credentials = false;
			}

			if (isset($this->request->post['payment_mp_standard_sponsor']))
				$isSponsorInvalid = $this->get_instance_mp_util()->verifySponsorIsValid($this->get_instance_mp(), $country_id, $this->request->post['payment_mp_standard_sponsor']);

			$this->model_setting_setting->editSetting( 'payment_mp_standard', $this->request->post );
			$this->session->data['success'] = $this->language->get( 'text_success' );
			$this->set_settings();
			if ( $has_payments_available && $valid_credentials && $isSponsorInvalid ) {
				$this->response->redirect( $this->url->link( 'marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true ) );
			}
		}
		
		$data = array(

			'text_edit' => $this->language->get( 'text_edit' ),
			'text_enabled' => $this->language->get( 'text_enabled' ),
			'text_disabled' => $this->language->get( 'text_disabled' ),
			'text_all_zones' => $this->language->get( 'text_all_zones' ),
			'button_save' => $this->language->get( 'button_save' ),
			'button_cancel' => $this->language->get( 'button_cancel' ),
			'header' => $this->load->controller( 'common/header' ),
			'heading_title' => $this->language->get( 'heading_title' ),
			'column_left' => $this->load->controller( 'common/column_left' ),
			'footer' => $this->load->controller( 'common/footer' ),
			'breadcrumbs' => array(
				array(
					'text' => $this->language->get( 'text_home' ),
					'href' => $this->url->link( 'common/dashboard', 'user_token=' . $this->session->data['user_token'], true )
				),
				array(
					'text' => $this->language->get( 'text_extension' ),
					'href' => $this->url->link( 'marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true )
				),
				array(
					'text' => $this->language->get( 'heading_title' ),
					'href' => $this->url->link( 'extension/payment/mp_standard', 'user_token=' . $this->session->data['user_token'], true )
				)
			),
			'action' => $this->url->link( 'extension/payment/mp_standard', 'user_token=' . $this->session->data['user_token'], true ),
			'cancel' => $this->url->link( 'marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true ),
			// Mercado Pago fields
			'payment_mp_standard_status' => ( isset( $this->request->post['payment_mp_standard_status'] ) ) ?
		 		$this->request->post['payment_mp_standard_status'] :
		 		$this->config->get( 'payment_mp_standard_status' ),
			'payment_mp_standard_client_id' => ( isset( $this->request->post['payment_mp_standard_client_id'] ) ) ?
		 		$this->request->post['payment_mp_standard_client_id'] :
		 		$this->config->get( 'payment_mp_standard_client_id' ),
		 	'payment_mp_standard_client_secret' => ( isset( $this->request->post['payment_mp_standard_client_secret'] ) ) ?
				$this->request->post['payment_mp_standard_client_secret'] :
				$this->config->get( 'payment_mp_standard_client_secret' ),
			'error_entry_credentials_basic' => $valid_credentials ? '' : $this->language->get( 'error_entry_credentials_basic' ),
			'payment_mp_standard_country' => ( isset( $this->request->post['payment_mp_standard_country'] ) ) ?
				$this->request->post['payment_mp_standard_country'] :
				$this->config->get( 'payment_mp_standard_country' ),
			'type_checkout' => array( 'Redirect', 'Lightbox', 'Iframe' ),
			'payment_mp_standard_type_checkout' => ( isset( $this->request->post['payment_mp_standard_type_checkout'] ) ) ?
				$this->request->post['payment_mp_standard_type_checkout'] :
				$this->config->get( 'payment_mp_standard_type_checkout' ),
			'category_list' => $this->get_instance_mp_util()->getCategoryList( $this->get_instance_mp() ),
			'payment_mp_standard_category_id' => ( isset( $this->request->post['payment_mp_standard_category_id'] ) ?
				$this->request->post['payment_mp_standard_category_id'] :
				$this->config->get( 'payment_mp_standard_category_id' ) ),
			'payment_mp_standard_debug' => ( isset( $this->request->post['payment_mp_standard_debug'] ) ?
				$this->request->post['payment_mp_standard_debug'] :
				$this->config->get( 'payment_mp_standard_debug' ) ),
			'payment_mp_standard_enable_return' => ( isset( $this->request->post['payment_mp_standard_enable_return'] ) ?
				$this->request->post['payment_mp_standard_enable_return'] :
				$this->config->get( 'payment_mp_standard_enable_return' ) ),
			'payment_mp_standard_sandbox' => ( isset( $this->request->post['payment_mp_standard_sandbox'] ) ?
				$this->request->post['payment_mp_standard_sandbox'] :
				$this->config->get( 'payment_mp_standard_sandbox' ) ),
			'installments' => $this->get_instance_mp_util()->getInstallments(),
			'payment_mp_standard_installments' => ( isset( $this->request->post['payment_mp_standard_installments'] ) ?
				$this->request->post['payment_mp_standard_installments'] :
				$this->config->get( 'payment_mp_standard_installments' ) ),
			'payment_mp_standard_order_status_id_completed' => ( isset( $this->request->post['payment_mp_standard_order_status_id_completed'] ) ?
				$this->request->post['payment_mp_standard_order_status_id_completed'] :
				$this->config->get( 'payment_mp_standard_order_status_id_completed' ) ),
			'payment_mp_standard_order_status_id_pending' => ( isset( $this->request->post['payment_mp_standard_order_status_id_pending'] ) ?
				$this->request->post['payment_mp_standard_order_status_id_pending'] :
				$this->config->get( 'payment_mp_standard_order_status_id_pending' ) ),
			'payment_mp_standard_order_status_id_canceled' => ( isset( $this->request->post['payment_mp_standard_order_status_id_canceled'] ) ?
				$this->request->post['payment_mp_standard_order_status_id_canceled'] :
				$this->config->get( 'payment_mp_standard_order_status_id_canceled' ) ),
			'payment_mp_standard_order_status_id_in_process' => ( isset( $this->request->post['payment_mp_standard_order_status_id_in_process'] ) ?
				$this->request->post['payment_mp_standard_order_status_id_in_process'] :
				$this->config->get( 'payment_mp_standard_order_status_id_in_process' ) ),
			'payment_mp_standard_order_status_id_rejected' => ( isset( $this->request->post['payment_mp_standard_order_status_id_rejected'] ) ?
				$this->request->post['payment_mp_standard_order_status_id_rejected'] :
				$this->config->get( 'payment_mp_standard_order_status_id_rejected' ) ),
			'payment_mp_standard_order_status_id_refunded' => ( isset( $this->request->post['payment_mp_standard_order_status_id_refunded'] ) ?
				$this->request->post['payment_mp_standard_order_status_id_refunded'] :
				$this->config->get( 'payment_mp_standard_order_status_id_refunded' ) ),
			'payment_mp_standard_order_status_id_in_mediation' => ( isset( $this->request->post['payment_mp_standard_order_status_id_in_mediation'] ) ?
				$this->request->post['payment_mp_standard_order_status_id_in_mediation'] :
				$this->config->get( 'payment_mp_standard_order_status_id_in_mediation' ) ),
			'payment_mp_standard_order_status_id_chargeback' => ( isset( $this->request->post['payment_mp_standard_order_status_id_chargeback'] ) ?
				$this->request->post['payment_mp_standard_order_status_id_chargeback'] :
				$this->config->get( 'payment_mp_standard_order_status_id_chargeback' ) )
		);

		$methods_api = $this->get_instance_mp_util()->getMethods( $country_id, $this->get_instance_mp() );
		$data['methods'] = array();
		$data['payment_mp_standard_methods'] = ( isset( $this->request->post['payment_mp_standard_methods'] ) ) ?
			$this->request->post['payment_mp_standard_methods'] :
			preg_split( '/[\s,]+/', $this->config->get( 'payment_mp_standard_methods' ) );
		foreach ( $methods_api as $method ) {
			if ( $method['id'] != 'account_money' ) {
				$data['methods'][] = $method;
			}
		}
		$data['count_payment_methods'] = count( $data['methods'] );
		$data['error_has_no_payments'] = $has_payments_available ? false : true;
		$data['payment_style'] = isset( $data['methods'] ) && count( $data['methods'] ) > 12 ?
			'float:left; margin:8px;' : 'float:left; margin:12px;';

		if (!$isSponsorInvalid) {
			$data['error_sponsor_spann'] = $this->language->get('error_sponsor_span');
			$data['payment_mp_standard_sponsor'] = null;
		} else {
			$data['payment_mp_standard_sponsor'] = $this->config->get('payment_mp_standard_sponsor');
		}

		$this->load->model( 'localisation/order_status' );
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		$this->load->model( 'localisation/geo_zone' );
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$this->response->setOutput( $this->load->view( 'extension/payment/mp_standard', $data ) );
	}

	protected function validate_credentials() {
		return ( $this->request->post['payment_mp_standard_client_id'] && $this->request->post['payment_mp_standard_client_secret'] );
	}

	public function set_settings() {
		$result = $this->get_instance_mp_util()->setSettings(
			$this->get_instance_mp(),
			$this->config->get( 'config_email' ), false, false,
				( $this->request->post['payment_mp_standard_status'] == '1' ? 'true' : 'false' )
			);
		return $result;  
	}

	public function get_payment_methods_by_country() {
		$country_id = $this->request->get['country_id'];
		$payment_methods = $this->get_instance_mp_util()->getMethods( $country_id, $this->get_instance_mp() );
		$data['methods'] = array();
		foreach ( $payment_methods as $method ) {
			if ( $method['id'] != 'account_money' ) {
				$data['methods'][] = $method;
			}
		}
		$data['count_payment_methods'] = count( $data['methods'] );
		$data['payment_nro_count_payment_methods'] = $data['count_payment_methods'];
		$data['error_has_no_payments'] = false;
		$methods_excludes = preg_split( '/[\s,]+/', $this->config->get( 'payment_mp_standard_methods' ) );
		foreach ( $methods_excludes as $exclude ) {
			$data['payment_mp_standard_methods'][] = $exclude;
		}
		if ( isset( $data['methods'] ) ) {
			$data['payment_style'] = isset( $data['methods'] ) && count( $data['methods'] ) > 12 ?
				'float:left; margin:8px;' : 'float:left; margin:12px;';
			$this->response->setOutput(
				$this->load->view( 'extension/payment/mp_standard_methods_partial', $data )
			);
		}
	}
}
