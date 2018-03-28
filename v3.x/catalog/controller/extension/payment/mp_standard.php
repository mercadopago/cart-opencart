<?php

require_once 'mercadopago/mercadopago.php';
require_once 'mercadopago/mercadopago_util.php';

class ControllerExtensionPaymentMpStandard extends Controller {

	private static $mp_util;
	private static $mp;

	function get_instance_mp_util() {
		if ( $this->mp_util == null ) {
			$this->mp_util = new MPOpencartUtil();
		}
		return $this->mp_util;
	}

	function get_instance_mp() {
		$client_id = $this->config->get( 'payment_mp_standard_client_id' );
		$client_secret = $this->config->get( 'payment_mp_standard_client_secret' );
		$this->mp = new MP( $client_id, $client_secret );
		return $this->mp;
	}

	public function index() {

		$this->load->model( 'checkout/order' );
		$this->load->language( 'extension/payment/mp_standard' );

		$order_info = $this->model_checkout_order->getOrder( $this->session->data['order_id'] );
		$country_id = $this->config->get( 'payment_mp_standard_country' );
		$data['action'] = $country_id;
		$data['customer_email'] = $this->customer->getEmail();
		$accepted_currencies = array(
			'MLA' => 'ARS', 'MLB' => 'BRL', 'MLC' => 'CLP', 'MCO' => 'COP',
			'MLM' => 'MXN', 'MLU' => 'UYU', 'MLV' => 'VEF', 'MPE' => 'PEN'
		);

		// Obtain the currency and order total
		$currency = $accepted_currencies[$country_id];
		$total = ( $country_id == 'MCO' || $country_id == 'MLC' ) ?
			ceil( $order_info['total'] ) : ceil( $order_info['total'] * 100 )/100;

		// Builds up the array with purchased items
		$picture_of_first = '';
		$order_content = array();
		$all_products = $this->cart->getProducts();
		foreach ( $all_products as $product ) {
			$order_content[] = $product['product_id'] . '-' . $product['name'] . ' x ' . $product['quantity'];
			if ( $picture_of_first == '' ) {
				$picture_of_first = HTTP_SERVER . 'image/' . $product['image'];
			}
		}

		// Build structure of items
		$items = array(
			array(
				'title'			=> implode( ', ', $order_content ),
				'description'	=> implode( ', ', $order_content ),
				'picture_url'	=> $picture_of_first,
				'category_id'	=> $this->config->get( 'payment_mp_standard_category_id' ),
				'quantity'		=> 1,
				'unit_price'	=> $total,
				'currency_id'	=> $currency
			)
		);

		// Create and setup payment options.
		$excluded_payment_methods = array();
		$excludeds = preg_split( '/[\s,]+/', $this->config->get( 'payment_mp_standard_methods' ) );
		foreach ( $excludeds as $em ) {
			if ( isset( $em ) ) {
				$excluded_payment_methods[] = array( 'id' => $em );
			}
		}

		$pref = array(
			'items' => $items,
			'payer' => array(
				'name'				=> $order_info['payment_firstname'],
				'surname'			=> $order_info['payment_lastname'],
				'email'				=> $order_info['email'],
				'phone' => array(
					'area_code' 	=> '-',
					'number'		=> $order_info['telephone'],
				),
				'address' => array(
					'zip_code'		=> $order_info['payment_postcode'],
					'street_name'	=> $order_info['payment_address_1'] . ' - ' .
						$order_info['payment_address_2'] . ' - ' .
						$order_info['payment_city'] . ' - ' .
						$order_info['payment_zone'] . ' - ' .
						$order_info['payment_country'],
					'street_number' => '-'
				),
				'identification' => array(
					'number' => 'null',
					'type' => 'null'
				)
			),
			'back_urls' => array(
				'pending' => HTTP_SERVER . 'index.php?route=extension/payment/mp_standard/callback',
				'success' => HTTP_SERVER . 'index.php?route=extension/payment/mp_standard/callback',
				'failure' => HTTP_SERVER . 'index.php?route=extension/payment/mp_standard/callback'
			),
			//'marketplace' =>
			//'marketplace_fee' =>
			'shipments' => array(
			),
			'payment_methods' => array(
				'installments' => (int) $this->config->get( 'payment_mp_standard_installments' ),
				'default_installments' => 1,
				'excluded_payment_methods' => $excluded_payment_methods
			),
			'external_reference' => $order_info['order_id']
			//'additional_info' =>
			//'expires' =>
			//'expiration_date_from' =>
			//'expiration_date_to' =>
		);

		// Do not set IPN url if it is a localhost
		if ( ! strrpos( HTTP_SERVER, 'localhost' ) ) {
			$pref['notification_url'] = HTTP_SERVER . '/index.php?route=extension/payment/mp_standard/notifications';
		}

		// Set sponsor ID
		if ( ! strpos( $order_info['email'], '@testuser.com' ) ) {
			$pref['sponsor_id'] = $this->get_instance_mp_util()->sponsors[$this->config->get( 'payment_mp_standard_country' )];
		}

		// Auto return options
		$pref['auto_return'] = $this->config->get( 'payment_mp_standard_enable_return' );

		// Call MP API to create payment url
		$data['debug'] = $this->config->get( 'payment_mp_standard_debug' );
		$result = ( $this->get_instance_mp() )->create_preference( $pref );
		if ( $result['status'] == 201 || $result['status'] == 200 ) {
			$data['type_checkout'] = $this->config->get( 'payment_mp_standard_type_checkout' );
			$sandbox = (bool) $this->config->get( 'payment_mp_standard_sandbox' );
			$data['redirect_link'] = $sandbox ? $result['response']['sandbox_init_point'] : $result['response']['init_point'];
		} else {
			$data['error'] = 'Error: ' . json_encode( $result['status'], JSON_PRETTY_PRINT );
		}

		// Update store backoffice
		$this->model_checkout_order->addOrderHistory(
			$this->session->data['order_id'],
			$this->config->get( 'payment_mp_standard_order_status_id_pending'),
			date('d/m/Y h:i' )
		);

		// Build up analytics structure
		$data['analytics'] = $this->set_analytics();

		$data['button_back'] = $this->language->get( 'button_back' );
		$data['button_confirm'] = $this->language->get( 'button_confirm' );
		$data['continue'] = $this->url->link( 'checkout/success' );
		$data['text_loading'] = $this->language->get('text_loading');

		// Call view
		return $this->load->view( 'extension/payment/mp_standard', $data );

	}

	public function callback() {
		
		if ( $this->request->get['collection_status'] == 'null' ) {
			
			$this->response->redirect( $this->url->link( 'checkout/checkout' ) );

		} elseif ( isset( $this->request->get['preference_id'] ) ) {
			
			$this->load->model('checkout/order');
			$payment_type = $this->update_order();
			$data = array(
				'header' => $this->load->controller( 'common/header' ),
				'footer' => $this->load->controller( 'common/footer' ),
				'column_left' => $this->load->controller( 'common/column_left' ),
				'column_right' => $this->load->controller( 'common/column_right' ),
				'content_top' => $this->load->controller( 'common/content_top' ),
				'content_bottom' => $this->load->controller( 'common/content_bottom' ),
				'continue' => $this->url->link( 'checkout/success' ),
				'token' => $this->config->get( 'payment_mp_standard_client_id' ),
				'paymentId' =>  $payment_type['collection']['payment_type'],
				'checkoutType' => 'standard'
			);

			$this->response->setOutput( $this->load->view( 'extension/payment/mp_standard_success', $data ) );

		}

	}

	public function notifications() {
		if ( isset( $this->request->get['topic'] ) ) {
			$this->request->get['collection_id'] = $this->request->get['id'];
			$this->update_order();
			echo json_encode( 200 );
		}
	}

	public function update_order() {

		// TODO: check why this function is causing error!!!
		
		// If collection ID is unset, it means that we haven't received updates yet
		if ( ! isset( $this->request->get['collection_id'] ) ) {
			return null;
		}
			
		// If collection ID is null, it means that we haven't received updates yet
		if ( $this->request->get['collection_id'] == 'null' ) {
			return null;
		}

		$this->load->model( 'checkout/order' );

		$client_id = $this->config->get( 'payment_mp_standard_mp_id' );
		$client_secret = $this->config->get( 'payment_mp_standard_mp_token' );
		$mp = new MP( $client_id, $client_secret );
		$ids = explode( ',', $this->request->get['collection_id'] );
		$payment_types = '';

		foreach ( $ids as $id ) {

			// Retrieve payment information from API call
			$response = $mp->get_payment_info( $id );
			$payment_info = $response['response'];
			if ( $payment_types == '' ) {
				$payment_types .= $payment_info['collection']['payment_type'];
			} else {
				$payment_types .= ',' . $payment_info['collection']['payment_type'];
			}

			// Get order based on external reference
			$order_id = $payment_info['collection']['external_reference'];
			$order = $this->model_checkout_order->getOrder( $order_id );

			// Get payment status from Mercado Pago
			$payment_status = $payment_info['collection']['status'];
			$order_payment_map = array(
				'approved'		=> $this->config->get( 'payment_mp_standard_order_status_id_completed' ),
				'pending'		=> $this->config->get( 'payment_mp_standard_order_status_id_pending' ),
				'in_process'	=> $this->config->get( 'payment_mp_standard_order_status_id_process' ),
				'reject'		=> $this->config->get( 'payment_mp_standard_order_status_id_rejected' ),
				'refunded'		=> $this->config->get( 'payment_mp_standard_order_status_id_refunded' ),
				'cancelled'		=> $this->config->get( 'payment_mp_standard_order_status_id_cancelled'),
				'in_mediation'	=> $this->config->get( 'payment_mp_standard_order_status_id_in_mediation' ),
				'charged-back'	=> $this->config->get( 'payment_mp_standard_order_status_id_chargeback' )
			);

			if ( in_array( $payment_status, $order_payment_map ) ) {
				// Update order status
				$this->model_checkout_order->addOrderHistory(
					$order_id, $order_payment_map[$payment_status], date( 'd/m/Y h:i' ) . ' - ' .
					$payment_info['collection']['payment_method_id'] . ' - ' . $payment_info['collection']['net_received_amount']
				);
			} else {
				// Default value is pending
				$this->model_checkout_order->addOrderHistory(
					$order_id, $order_payment_map['pending'], date( 'd/m/Y h:i' ) . ' - ' .
					$payment_info['collection']['payment_method_id'] . ' - ' . $payment_info['collection']['net_received_amount']
				);
			}
		}

		return $payment_types;
	}

	private function set_analytics() {
		$result_modules = array();
		$query = $this->db->query( 'SELECT code FROM ' . DB_PREFIX . 'extension WHERE type = "payment"' );
		foreach ( $query->rows as $result ) {
			array_push( $result_modules, $result['code'] );
		}
		return $this->get_instance_mp_util()->create_analytics(
			$result_modules,
			$this->config->get( 'payment_mp_standard_client_id' ),
			$this->customer->getEmail(),
			( $this->customer->isLogged() ? 1 : 0 )
		);
    }

}
