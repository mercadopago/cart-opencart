<?php

require_once '../catalog/controller/extension/payment/lib/mercadopago.php';
require_once '../catalog/controller/extension/payment/lib/mp_util.php';

class ControllerExtensionPaymentMPTransparente extends Controller {
	private $_error = array();
	private $payment_types = array('debvisa', 'debmaster', 'credit_card', 'debit_card');
	private static $mp_util;
	private static $mp;

	function get_instance_mp_util() {
		if ($this->mp_util == null) 
			$this->mp_util = new MPOpencartUtil();

		return $this->mp_util;
	}

	function get_instance_mp() {
		if ($this->mp == null) {
			$access_token = $this->config->get('payment_mp_transparente_access_token');
			$this->mp = new MP($access_token);
		}
		return $this->mp;
	}

	public function index() {

		$prefix = 'payment_mp_transparente_';
		$fields = array('public_key', 'access_token', 'status', 'category_id',
			'debug', 'coupon', 'country', 'installments', 'order_status_id',
			'order_status_id_completed', 'order_status_id_pending',
			'order_status_id_canceled', 'order_status_id_in_process',
			'order_status_id_rejected', 'order_status_id_refunded',
			'order_status_id_in_mediation', 'order_status_chargeback');
		// add sponsor

		$this->load->language('extension/payment/mp_transparente');
		$data['heading_title'] = $this->language->get('heading_title');
		$this->document->setTitle($data['heading_title']);
		$this->load->model('setting/setting');

		$text_prefix = 'text_';
		$texts = array('enabled', 'disabled', 'all_zones', 'yes', 'no', 'mercadopago');
		foreach ($texts as $text) {
			$name = $text_prefix . $text;
			$data[$name] = $this->language->get($name);
		}

		$entry_prefix = 'entry_';
		$entries = array('public_key_tooltip', 'access_token_tooltip', 'access_token_tooltip',
			'payments_not_accept_tooltip', 'payments_not_accept_tooltip', 'debug_tooltip', 'coupon_tooltip',
			'category_tooltip', 'order_status_tooltip', 'order_status_completed_tooltip',
			'order_status_pending_tooltip', 'order_status_canceled_tooltip', 'order_status_in_process_tooltip',
			'order_status_rejected_tooltip', 'order_status_refunded_tooltip', 'order_status_in_mediation_tooltip',
			'order_status_chargeback_tooltip', 'order_status_chargeback_tooltip', 'public_key', 'access_token',
			'installments', 'payments_not_accept', 'status', 'geo_zone', 'country', 'sonda_key', 'order_status',
			'ipn_status', 'debug', 'coupon','category', 'order_status_general', 'order_status_completed', 'order_status_pending',
			'order_status_canceled', 'order_status_in_process', 'order_status_rejected', 'order_status_refunded',
			'order_status_in_mediation', 'order_status_chargeback');
		// add sponsor

		foreach ($entries as $entry) {
			$name = $entry_prefix . $entry;
			$data[$name] = $this->language->get($name);
		}

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['tab_general'] = $this->language->get('tab_general');

		$data['error_warning'] = isset($this->_error['warning']) ? $this->_error['warning'] : '';
		$data['error_acc_id'] = isset($this->_error['acc_id']) ? $this->_error['acc_id'] : '';
		$data['error_token'] = isset($this->_error['token']) ? $this->_error['token'] : '';
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true ),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'user_token=' . $this->session->data['user_token'], true ),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/payment/mp_transparente', 'user_token=' . $this->session->data['user_token'], true ),
		);

		$data['action'] = $this->url->link( 'extension/payment/mp_transparente', 'user_token=' . $this->session->data['user_token'], true );
		$data['cancel'] = $this->url->link( 'extension/extension', 'user_token=' . $this->session->data['user_token'], true );
		$data['category_list'] = $this->get_instance_mp_util()->getCategoryList($this->get_instance_mp());
		$data['countries'] = $this->get_instance_mp_util()->getCountries($this->get_instance_mp());
		$data['installments'] = $this->get_instance_mp_util()->getInstallments();
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			foreach ($fields as $field) {
				$fieldname = $prefix . $field;
				$this->request->post[$fieldname] = str_replace(" ", "", $this->request->post[$fieldname]);
				$data[$fieldname] = $this->request->post[$fieldname];
			}

		} else {
			foreach ($fields as $field) {
				$fieldname = $prefix . $field;
				$value = $this->config->get($fieldname);
				$data[$fieldname] = $value;
			}
		}

		$country_id = $this->config->get('payment_mp_transparente_country') == null ?
		'MLA' : $this->config->get('payment_mp_transparente_country');

		$methods_api = $this->get_instance_mp()->getPaymentMethods($country_id);
		$data['methods'] = array();
		$data['payment_mp_transparente_methods'] = preg_split("/[\s,]+/", $this->config->get('payment_mp_transparente_methods'));
		foreach ($methods_api as $method) {
			if (in_array($method['payment_type_id'], $this->payment_types)) {
				$data['methods'][] = $method;
			}
		}
	
		$data['payment_style'] = isset($data['methods']) && count($data['methods']) > 12 ?
		"float:left; margin-left:2%" : "float:left; margin-left:5%";

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load->model('setting/setting');

			if (isset($this->request->post['payment_mp_transparente_methods'])) {
				$names = $this->request->post['payment_mp_transparente_methods'];
				$this->request->post['payment_mp_transparente_methods'] = '';
				foreach ($names as $name) {
					$this->request->post['payment_mp_transparente_methods'] .= $name . ',';
				}
			}
			
			$this->model_setting_setting->editSetting('payment_mp_transparente', $this->request->post);

			$statusReturn = true;
			$this->setSettings();			
			$isPublicKeyInvalid = $this->verifyPublicKey();
			$isAccessTokenInvalid = $this->verifyAccessToken();
			//$isSponsorInvalid = $this->get_instance_mp_util()->verifySponsorIsValid($this->get_instance_mp(), $country_id, $this->request->post['payment_mp_transparente_sponsor']);

			if (!$this->user->hasPermission('modify', 'extension/payment/mp_transparente')) {
				$this->_error['warning'] = $this->language->get('error_permission');
				$statusReturn = false;
			}

			/*if (!$isSponsorInvalid) {
				$data['error_sponsor_spann'] = $this->language->get('error_sponsor_span');
				$data['payment_mp_transparente_sponsor'] = null;
				$statusReturn = false;
			} else {
				$data['payment_mp_transparente_sponsor'] = $this->config->get('payment_mp_transparente_sponsor');
			}*/

			if ($isAccessTokenInvalid) {
				$data['error_access_token_span'] = $this->language->get('error_access_token');
				$statusReturn = false;
			} 

			if ($isPublicKeyInvalid) {
				$data['error_public_key_span'] = $this->language->get('error_public_key');
				$statusReturn = false;
			}

			if ($statusReturn) {
				$this->session->data['success'] = $this->language->get('text_success');
				$this->response->redirect($this->url->link( 'marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true ));
			}
		}

		$this->response->setOutput($this->load->view('extension/payment/mp_transparente', $data));

	}

	public function getPaymentMethodsByCountry() {
		$country_id = $this->request->get['country_id'];
		$payment_methods = $this->get_instance_mp()->getPaymentMethods($country_id);

		foreach ($payment_methods as $method) {
			if (in_array($method['payment_type_id'], $this->payment_types)) {
				$data['methods'][] = $method;
			}
		}

		$methods_excludes = preg_split("/[\s,]+/", $this->config->get('payment_mp_transparente_methods'));
		foreach ($methods_excludes as $exclude) {
			$data['mp_transparente_methods'][] = $exclude;

		}

		if (isset($data['methods'])) {
			$data['payment_style'] = count($data['methods']) > 12 ? "float:left; margin-left:7%" : "float:left; margin-left:5%";
			$this->response->setOutput($this->load->view('extension/payment/mp_transparente_payment_methods_partial', $data));
		}
	}

	private function verifyPublicKey() {
		$uri = "/v1/payment_methods";
 		$params = array(
 			'public_key' => $this->request->post['payment_mp_transparente_public_key']
 		);
			
		$result = $this->get_instance_mp()->get($uri, $params, false);

		if ($result['response'] != null && isset($result['response']['status']) && $result['response']['status'] > 202) {
			return true;

		}
		return false;
	}

	private function verifyAccessToken() {
		$uri = "/users/me";
 		$params = array(
 			'access_token' => $this->request->post['payment_mp_transparente_access_token']
 		);
			
		$result = $this->get_instance_mp()->get($uri, $params, false);

		if ($result != null && isset($result['status']) && $result['status'] > 202) {
			return true;

		}
		return false;
	}

	public function setSettings() {
        $statusCustom = "false";
	    $custom_cupom = "false";
	    $config_email = $this->config->get('config_email');
	    $result = null;

        if ($this->request->post['payment_mp_transparente_coupon'] == "1")
            $custom_cupom = "true";

    	if ($this->request->post['payment_mp_transparente_status'] == "1")
            $statusCustom = "true";

        try {
			$this->get_instance_mp()->setEmailAdmin($config_email);     	           
           	$result = $this->get_instance_mp_util()->setSettings($this->get_instance_mp(), $config_email, $statusCustom, $custom_cupom); 
		} catch (Exception $e) {
        	error_log($e);
        }

		return $result;  
    }
}
