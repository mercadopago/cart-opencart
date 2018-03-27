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
			$client_id = $this->config->get( 'payment_mp_standard_client_id' );
			$client_secret = $this->config->get( 'payment_mp_standard_client_secret' );
			$this->mp = new MP( $client_id, $client_secret );
		}
		return $this->mp;
	}

	public function index() {

		$this->load->model( 'checkout/order' );
		$this->language->load( 'extension/payment/mp_standard' );

		// Get the order
		$url_store = HTTP_SERVER;
		$order_info = $this->model_checkout_order->getOrder( $this->session->data['order_id'] );

		// Translations and general variables
		$data['customer_email'] = $this->customer->getEmail();
		//$data['continue'] = $url_store->link( 'checkout/success' );
		$data['button_confirm'] = $this->language->get( 'button_confirm' );
		$data['button_back'] = $this->language->get( 'button_back' );
		$accepted_currencies = array( 'ARS', 'BRL', 'CLP', 'COP', 'MXN', 'UYU', 'VEF', 'PEN' );

		if ( isset( $this->config->get( 'payment_mp_standard_country' ) ) ) {
			$country_id = $this->config->get( 'payment_mp_standard_country' );
		} else {
			$country_id = 'MLA';
		}

		// Obtain the currency
		/*$currency = $order_info['currency_code'];
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
				'category_id'	=> $this->config->get( 'payment_mp_standard_category_id' ),
				'quantity'		=> intval( $product['quantity'] ),
				'unit_price'	=> ( $this->config->get( 'payment_mp_standard_country' ) == 'MCO' ) ? 
									$this->currency->format( $product['price'], $order_info['currency_code'], false, false ) :
									round( $product['price'] * $order_info['currency_value'], 2 ),
				'currency_id'	=> $currency
			) );
		}

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
				'pending' => $url_store . 'index.php?route=extension/payment/mp_standard/callback',
				'success' => $url_store . 'index.php?route=extension/payment/mp_standard/callback',
				'failure' => $url_store . 'index.php?route=extension/payment/mp_standard/callback'
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
		if ( ! strrpos( $url_store, 'localhost' ) ) {
			$pref['notification_url'] = $url_store . 'index.php?route=extension/payment/mp_standard/notifications';
		}

		// Set sponsor ID
		if ( ! strpos( $order_info['email'], '@testuser.com' ) ) {
			$pref['sponsor_id'] = $this->get_instance_mp_util()->sponsors[$this->config->get( 'payment_mp_standard_country' )];
		}

		// Auto return options
		$pref['auto_return'] = $this->config->get( 'payment_mp_standard_enable_return' );

		// Call MP API to create payment url
		$result = $this->get_instance_mp()->create_preference( $pref );
		if ( $result['status'] == 201 || $result['status'] == 200 ) {
			$data['type_checkout'] = $this->config->get( 'payment_mp_standard_type_checkout' );
			$sandbox = (bool) $this->config->get( 'payment_mp_standard_sandbox' );
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
		$data['analytics'] = $this->set_analytics();*/

		// Call view
		return $this->load->view( 'extension/payment/mp_standard', $data );

	}

	public function callback() {
		if ( $this->request->get['collection_status'] == 'null' ) {
			$this->response->redirect( $this->url->link( 'checkout/checkout' ) );
		} elseif ( isset($this->request->get['preference_id'] ) ) {
			$order_id = $this->request->get['collection_id'];
			$this->load->model( 'checkout/order' );
			$order = $this->model_checkout_order->getOrder( $order_id );
			$this->model_checkout_order->addOrderHistory( $order_id, $this->config->get( 'payment_mp_standard_order_status_id' ), date( 'd/m/Y h:i' ) );
			$dados = $this->retorno();
		    $this->response->redirect($this->url->link('checkout/success'));
		}
	}

	public function notifications() {
		if ( isset( $this->request->get['topic'] ) ) {
			$this->request->get['collection_id'] = $this->request->get['id'];
			$this->retorno();
			echo json_encode( 200 );
		}
	}

	public function retorno() {
		if ( isset( $this->request->get['collection_id'] ) ) {
			if ( $this->request->get['collection_id'] == 'null' ) {
				$order_id = $this->request->get['external_reference'];
				$this->load->model( 'checkout/order' );
				$this->model_checkout_order->addOrderHistory(
					$order_id, $this->config->get( 'payment_mp_standard_order_status_id_' . $this->request->get['status'] ), date( 'd/m/Y h:i' )
				);
				return;
			}
			$ids = explode( ',', $this->request->get['collection_id'] );
			$client_id = $this->config->get( 'payment_mp_standard_mp_id' );
			$client_secret = $this->config->get( 'payment_mp_standard_mp_token' );
			$mp = new MP( $client_id, $client_secret );
			$dados = null;
			foreach ( $ids as $id ) {
				$resposta = $mp->get_payment_info( $id );
				$dados = $resposta['response'];
				$order_id = $dados['collection']['external_reference'];
				$order_status = $dados['collection']['status'];
				$this->load->model( 'checkout/order' );
				$order = $this->model_checkout_order->getOrder( $order_id );
				if ( $order['order_status_id'] == '0' ) {
					$this->model_checkout_order->addOrderHistory( $order_id, $this->config->get( 'payment_mp_standard_order_status_id' ) );
				}
				switch ( $order_status ) {
				case 'approved':
					$this->model_checkout_order->addOrderHistory(
						$order_id, $this->config->get( 'payment_mp_standard_order_status_id_completed' ),
						date( 'd/m/Y h:i' ) . ' - ' . $dados['collection']['payment_method_id'] . ' - ' . $dados['collection']['net_received_amount']
					);
					break;
				case 'pending':
					$this->model_checkout_order->addOrderHistory(
						$order_id, $this->config->get( 'payment_mp_standard_order_status_id_pending' ),
						date( 'd/m/Y h:i' ) . ' - ' . $dados['collection']['payment_method_id'] . ' - ' . $dados['collection']['net_received_amount']
					);
					break;
				case 'in_process':
					$this->model_checkout_order->addOrderHistory(
						$order_id, $this->config->get( 'payment_mp_standard_order_status_id_process' ),
						date( 'd/m/Y h:i' ) . ' - ' . $dados['collection']['payment_method_id'] . ' - ' . $dados['collection']['net_received_amount']
					);
					break;
				case 'reject':
					$this->model_checkout_order->addOrderHistory(
						$order_id, $this->config->get( 'payment_mp_standard_order_status_id_rejected' ),
						date( 'd/m/Y h:i' ) . ' - ' . $dados['collection']['payment_method_id'] . ' - ' . $dados['collection']['net_received_amount']
					);
					break;
				case 'refunded':
					$this->model_checkout_order->addOrderHistory(
						$order_id, $this->config->get( 'payment_mp_standard_order_status_id_refunded' ),
						date( 'd/m/Y h:i' ) . ' - ' . $dados['collection']['payment_method_id'] . ' - ' . $dados['collection']['net_received_amount']
					);
					break;
				case 'cancelled':
					$this->model_checkout_order->addOrderHistory(
						$order_id, $this->config->get( 'payment_mp_standard_order_status_id_cancelled'),
						date( 'd/m/Y h:i' ) . ' - ' . $dados['collection']['payment_method_id'] . ' - ' . $dados['collection']['net_received_amount']
					);
					break;
				case 'in_metiation':
					$this->model_checkout_order->addOrderHistory(
						$order_id, $this->config->get('payment_mp_standard_order_status_id_in_mediation' ),
						date( 'd/m/Y h:i' ) . ' - ' . $dados['collection']['payment_method_id'] . ' - ' . $dados['collection']['net_received_amount']
					);
					break;
				default:
					$this->model_checkout_order->addOrderHistory(
						$order_id, $this->config->get( 'payment_mp_standard_order_status_id_pending' ),
						date( 'd/m/Y h:i' ) . ' - ' . $dados['collection']['payment_method_id'] . ' - ' . $dados['collection']['net_received_amount']
					);
					break;
				}
			}
		} else {
			error_log( 'Compra Não Identificada o ID!!!' );
		}

		return $dados;
	}

	private function update_order() {
		$this->load->model( 'checkout/order' );
		$this->get_instance_mp()->sandbox_mode( ( $this->config->get( 'payment_mp_standard_sandbox' ) == 1 ? true : null ) );
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
			$this->config->get( 'payment_mp_standard_client_id' ),
			$this->customer->getEmail(),
			( $this->customer->isLogged() ? 1 : 0 )
		);
    }

}
