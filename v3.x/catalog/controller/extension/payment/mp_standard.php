<?php

require_once 'mercadopago/mercadopago.php';
require_once 'mercadopago/mercadopago_util.php';

class ControllerExtensionPaymentMpStandard extends Controller {

	private $error;
	public $sucess = true;
	private $order_info;
	private $message;
	private static $mp_util;
	private static $mp;

	function get_instance_mp_util() {
		if ( $this->mp_util == null ) {
			$this->mp_util = new MPOpencartUtil();
		}
		return $this->mp_util;
	}

	function get_instance_mp() {
		if ( $this->mp == null ) {
			$client_id = $this->config->get( 'mp_standard_client_id' );
			$client_secret = $this->config->get( 'mp_standard_client_secret' );
			$this->mp = new MP( $client_id, $client_secret );
		}
		return $this->mp;
	}

	public function index() {

		$this->load->model( 'checkout/order' );
		$this->language->load( 'extension/payment/mp_standard' );

		// Get the order
		$order_info = $this->model_checkout_order->getOrder( $this->session->data['order_id'] );

		// Translations and general variables
		$data['customer_email'] = $this->customer->getEmail();
		$data['button_confirm'] = $this->language->get( 'button_confirm' );
		$data['button_back'] = $this->language->get( 'button_back' );
		$accepted_currencies = array( 'ARS', 'BRL', 'CLP', 'COP', 'MXN', 'UYU', 'VEF', 'PEN' );
		$country_id = isset( $this->config->get( 'mp_standard_country' ) ) ?
			$this->config->get( 'mp_standard_country' ) : 'MLA';
		
		$client_id = $this->config->get( 'mp_standard_client_id' );
		$client_secret = $this->config->get( 'mp_standard_client_secret' );

		// Obtain the currency
		$currency = $order_info['currency_code'];
		if ( $currency == 'ARG' ) $currency = 'ARS';
		if ( $currency == 'BRA' || $currency == 'REA' ) $currency = 'BRL';
		if ( ! in_array( $currency, $accepted_currencies ) ) {
			$currency = '';
			$data['error'] = $this->language->get( 'currency_no_support' );
		}

		// Builds up the array with purchased items
		$items = array();
		$order_content = array();
		$all_products = $this->cart->getProducts();
		foreach ( $all_products as $product ) {
			array_push( $items, array(
				'id'			=> $product['product_id'],
				'title'			=> $product['name'] . ' x ' . $product['quantity'],
				'description'	=> $product['name'] . ' x ' . $product['quantity'],
				'picture_url'	=> HTTP_SERVER . 'image/' . $product['image'],
				'category_id'	=> $this->config->get( 'mp_standard_category_id' ),
				'quantity'		=> intval( $product['quantity'] ),
				'unit_price'	=> ( $this->config->get( 'mp_standard_country' ) == 'MCO' ) ? 
									$this->currency->format( $product['price'], $order_info['currency_code'], false, false ) :
									round( $product['price'] * $order_info['currency_value'], 2 ),
				'currency_id'	=> $currency
			) );
		}

		// Create and setup payment options.
		$excluded_payment_methods = array();
		$excludeds = preg_split( '/[\s,]+/', $this->config->get( 'mp_standard_methods' ) );
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
				'pending' => $order_info['store_url'] . 'index.php?route=extension/payment/mp_standard/callback',
				'success' => $order_info['store_url'] . 'index.php?route=extension/payment/mp_standard/callback',
				'failure' => $order_info['store_url'] . 'index.php?route=extension/payment/mp_standard/callback'
			),
			//'marketplace' =>
			//'marketplace_fee' =>
			'shipments' => array(
			),
			'payment_methods' => array(
				'installments' => (int) $this->config->get( 'mp_standard_installments' ),
				'default_installments' => 1,
				'excluded_payment_methods' => $excluded_payment_methods
			),
			'external_reference' => $order_info['order_id'],
			//'additional_info' =>
			//'expires' =>
			//'expiration_date_from' =>
			//'expiration_date_to' =>
		);

		// Do not set IPN url if it is a localhost
		if ( ! strrpos( $order_info['store_url'], 'localhost' ) ) {
			$pref['notification_url'] = $order_info['store_url'] . 'index.php?route=extension/payment/mp_standard/notifications';
		}

		// Set sponsor ID
		if ( ! strpos( $order_info['email'], '@testuser.com' ) ) {
			$pref['sponsor_id'] = $this->get_instance_mp_util()->sponsors[$this->config->get( 'mp_standard_country' )];
		}

		// Auto return options
		$pref['auto_return'] = $this->config->get( 'mp_standard_enable_return' );

		// Call MP API to create payment url
		$result = $this->get_instance_mp()->create_preference( $pref );
		if ( $result['status'] == 201 || $result['status'] == 200 ) {
			$data['type_checkout'] = $this->config->get( 'mp_standard_type_checkout' );
			$sandbox = (bool) $this->config->get( 'mp_standard_sandbox' );
			$data['redirect_link'] = $sandbox ? $result['response']['sandbox_init_point'] : $result['response']['init_point'];
		} else {
			$data['error'] = 'Error: ' . $result['status'];
		}

		// Update store backoffice
		$this->model_checkout_order->addOrderHistory(
			$this->session->data['order_id'],
			$this->config->get( 'order_status_id_pending'),
			date('d/m/Y h:i' )
		);

		// Build up analytics structure
		$data['analytics'] = $this->set_analytics();

		// Call view
		return $this->load->view( 'extension/payment/mp_standard', $data );

	}

	public function callback() {

		$this->load->model( 'checkout/order' );

		if ( $this->request->get['collection_status'] == 'null' ) {
			$this->response->redirect( $this->url->link( 'checkout/checkout' ) );
		} elseif ( isset( $this->request->get['preference_id'] ) ) {
			$order = $this->model_checkout_order->getOrder( $this->request->get['collection_id'] );
			$this->model_checkout_order->addOrderHistory(
				$this->request->get['collection_id'],
				$this->config->get( 'mercadopago_order_status_id' ),
				date( 'd/m/Y h:i' )
			);
			$order_data = $this->update_order();
			$data['footer']			= array();
			$data['checkoutType']	= 'standard';
			$data['paymentId']		= $order_data['collection']['payment_type'];
			$data['continue']		= $this->url->link( 'checkout/success' );
			$data['column_left']	= $this->load->controller( 'common/column_left' );
			$data['column_right']	= $this->load->controller( 'common/column_right' );
			$data['content_top']	= $this->load->controller( 'common/content_top' );
			$data['content_bottom']	= $this->load->controller( 'common/content_bottom' );
			$data['footer']			= $this->load->controller( 'common/footer' );
			$data['header']			= $this->load->controller( 'common/header' );
			$data['token']			= $this->config->get( 'mp_standard_client_id' );
			$this->response->setOutput( $this->load->view( 'extension/payment/mp_standard_success', $data ) );
		}

	}

	public function notifications() {
		if ( isset( $this->request->get['topic'] ) ) {
			$this->request->get['collection_id'] = $this->request->get['id'];
			$this->update_order();
			echo json_encode( 200, JSON_PRETTY_PRINT );
		}
	}

	private function update_order() {
		$this->load->model( 'checkout/order' );
		$this->get_instance_mp()->sandbox_mode( ( $this->config->get( 'mp_standard_sandbox' ) == 1 ? true : null ) );
		$ids = explode( ',', $this->request->get['collection_id'] );
		foreach ( $ids as $id ) {
			$this->get_instance_mp_util()->update_order(
				$this->get_instance_mp()->get_payment( $id ),
				$this->model_checkout_order,
				$this->config,
				$this->db
			);
		}
	}

	private function set_analytics() {
		$result_modules = array();
		$query = $this->db->query( 'SELECT code FROM ' . DB_PREFIX . 'extension WHERE type = "payment"' );
		foreach ( $query->rows as $result ) {
			array_push( $result_modules, $result['code'] );
		}
		return $this->get_instance_mp_util()->create_analytics(
			$result_modules,
			$this->config->get( 'mp_standard_client_id' ),
			$this->customer->getEmail(),
			( $this->customer->isLogged() ? 1 : 0 )
		);
    }

}
