<?php

require_once "mercadopago.php";

class ControllerPaymentMPTransparente extends Controller {

	private $error;
	public $sucess = true;
	private $order_info;
	private $message;
	private $sponsors = array('MLB' => 204931135,
		'MLM' => 204931029,
		'MLA' => 204931029,
		'MCO' => 204964815,
		'MLV' => 204964612,
		'MLC' => 204964815);

	public function index() {
		$data['customer_email'] = $this->customer->getEmail();
		$data['button_confirm'] = $this->language->get('button_confirm');
		$data['button_back'] = $this->language->get('button_back');
		$data['terms'] = 'Teste de termos';
		$data['public_key'] = $this->config->get('mp_transparente_public_key');

		if ($this->config->get('mp_transparente_country')) {
			$data['action'] = $this->config->get('mp_transparente_country');
		}

		$this->load->model('checkout/order');

		$this->language->load('payment/mp_transparente');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		//Cambio el código ISO-3 de la moneda por el que se les ocurrio poner a los de mercadopago2!!!
		$accepted_currencies = array('ARS' => 'ARS', 'ARG' => 'ARS', 'VEF' => 'VEF',
			'BRA' => 'BRL', 'BRL' => 'BRL', 'REA' => 'BRL', 'MXN' => 'MEX',
			'CLP' => 'CHI', 'COP' => 'COP', 'US' => 'US');

		$currency = $accepted_currencies[$order_info['currency_code']];

		$currencies = array('ARS', 'BRL', 'MEX', 'CHI', 'VEF', 'COP');
		if (!in_array($currency, $currencies)) {
			$currency = '';
			$data['error'] = $this->language->get('currency_no_support');
		}

		$totalprice = $order_info['total'] * $order_info['currency_value'];
		$products = '';
		$all_products = $this->cart->getProducts();
		$items = array();
		foreach ($all_products as $product) {
			$products .= $product['quantity'] . ' x ' . $product['name'] . ', ';
			$items[] = array(
				"id" => $product['product_id'],
				"title" => $product['name'],
				"description" => $product['quantity'] . ' x ' . $product['name'], // string
				"quantity" => intval($product['quantity']),
				"unit_price" => round(floatval($product['price']), 2), //decimal
				"currency_id" => $currency,
				"picture_url" => HTTP_SERVER . 'image/' . $product['image'],
				"category_id" => $this->config->get('mp_transparentecategory_id'),
			);
		}

		$this->id = 'payment';

		$data['server'] = $_SERVER;
		$data['debug'] = $this->config->get('mp_transparente_debug');

		// get credentials

		//$client_id = $this->config->get('mp_transparente_client_id');
		//$client_secret = $this->config->get('mp_transparenteclient_secret');
		//$url = $this->config->get('mp_transparenteurl');
		$installments = (int) $this->config->get('mp_transparente_installments');

		$shipments = array(
			"receiver_address" => array(
				"floor" => "-",
				"zip_code" => $order_info['shipping_postcode'],
				"street_name" => $order_info['shipping_address_1'] . " - " .
				$order_info['shipping_address_2'] . " - " .
				$order_info['shipping_city'] . " - " .
				$order_info['shipping_zone'] . " - " .
				$order_info['shipping_country'],
				"apartment" => "-",
				"street_number" => "-",
			),
			// "cost" => round(floatval($this->session->data['shipping_method']['cost']), 2),
			//"mode" => "custom"
		);

		//Force format YYYY-DD-MMTH:i:s
		$cust = $this->db->query("SELECT * FROM `" .
			DB_PREFIX . "customer` WHERE customer_id = " .
			$order_info['customer_id'] . " ");
		if ($cust->num_rows > 0):

			foreach ($cust->rows as $customer):
				$date_created = $customer['date_added'];
			endforeach;

			$date_creation_user = date('Y-m-d', strtotime($date_created)) . "T" . date('H:i:s', strtotime($date_created));
		endif;

		$payer = array(
			"name" => $order_info['payment_firstname'],
			"surname" => $order_info['payment_lastname'],
			"email" => $order_info['email'],
			"phone" => array(
				"area_code" => "-",
				"number" => $order_info['telephone'],
			),
			"address" => array(
				"zip_code" => $order_info['payment_postcode'],
				"street_name" => $order_info['payment_address_1'] . " - " .
				$order_info['payment_address_2'] . " - " .
				$order_info['payment_city'] . " - " .
				$order_info['payment_zone'] . " - " .
				$order_info['payment_country'],
				"street_number" => "-",
			),
			"identification" => array(
				"number" => "null",
				"type" => "null",
			),
		);

		$exclude = $this->config->get('mp_transparente_methods');
		$country_id = $this->config->get('mp_transparente_country') == null ? 'MLA' : $this->config->get('mp_transparente_country');

		$installments = (int) $installments;
		if ($exclude != '') {

			$accepted_methods = preg_split("/[\s,]+/", $exclude);
			$all_payment_methods = $this->getMethods($country_id);
			$excluded_payments = array();
			sleep(3);

			foreach ($all_payment_methods as $method) {
				if (!in_array($method['id'], $accepted_methods) && $method['id'] != 'account_money') {
					$excluded_payments[] = array('id' => $method['id']);
				}
			}

			$payment_methods = array(
				"installments" => $installments,
				"excluded_payment_methods" => $excluded_payments,
			);
		} else {
			//case not exist exclude methods
			$payment_methods = array("installments" => $installments);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/mp_transparente.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/mp_transparente.tpl', $data);
		} else {
			return $this->load->view('payment/mp_transparente.tpl', $data);
		}
	}

	public function getPaymentDataByLanguage() {
		$this->language->load('payment/mp_transparente');
		$payment_data = array();
		$payment_data['ccnum_placeholder'] = $this->language->get('ccnum_placeholder');
		$payment_data['expiration_month_placeholder'] = $this->language->get('expiration_month_placeholder');
		$payment_data['expiration_year_placeholder'] = $this->language->get('expiration_year_placeholder');
		$payment_data['name_placeholder'] = $this->language->get('name_placeholder');
		$payment_data['doctype_placeholder'] = $this->language->get('doctype_placeholder');
		$payment_data['docnumber_placeholder'] = $this->language->get('docnumber_placeholder');
		$payment_data['installments_placeholder'] = $this->language->get('installments_placeholder');
		$payment_data['cardType_placeholder'] = $this->language->get('cardType_placeholder');
		$payment_data['payment_button'] = $this->language->get('payment_button');
		$payment_data['payment_title'] = $this->language->get('payment_title');
		$payment_data['payment_processing'] = $this->language->get('payment_processing');
		echo json_encode($payment_data);
	}

	public function getCardIssuers() {
		$method = $this->request->get['payment_method_id'];
		$token = $this->config->get('mp_transparente_access_token');
		$url = 'https://api.mercadopago.com/v1/payment_methods/card_issuers?payment_method_id=' . $method . '&access_token=' . $token;
		$issuers = $this->callJson($url);
		echo json_encode($issuers);
	}

	public function payment() {
		$this->language->load('payment/mp_transparente');
		try
		{
			$exclude = $this->config->get('mp_transparente_methods');
			$accepted_methods = preg_split("/[\s,]+/", $exclude);
			$payment_method_id = $this->request->post['payment_method_id'];

			/*  if (!in_array($payment_method_id, $accepted_methods)) {
				                $message = $this->language->get('error_invalid_payment_type');
				                error_log('$message: ' . $message);
				                echo json_encode(array("status" => 400, "message" => $message));
				                return;
			*/

			$this->load->model('checkout/order');
			$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

			$all_products = $this->cart->getProducts();
			$items = array();
			foreach ($all_products as $product) {
				$items[] = array(
					"id" => $product['product_id'],
					"title" => $product['name'],
					"description" => $product['quantity'] . ' x ' . $product['name'], // string
					"quantity" => intval($product['quantity']),
					"unit_price" => round(floatval($product['price']), 2), //decimal
					"picture_url" => HTTP_SERVER . 'image/' . $product['image'],
					"category_id" => $this->config->get('mp_transparente_category_id'),
				);
			}
			error_log(json_encode($order_info));
			$payer = array("email" => $order_info['email']);
			if ($this->config->get("mp_transparente_country") != "MLM") {
				$payer['identification'] = array();
				$payer['identification']['type'] = $this->request->post['docType'];
				$payer['identification']["number"] = $this->request->post['docNumber'];
			}

			$shipments = array(
				"receiver_address" => array(
					"floor" => "-",
					"zip_code" => $order_info['shipping_postcode'],
					"street_name" => $order_info['shipping_address_1'] . " - " .
					$order_info['shipping_address_2'] . " - " .
					$order_info['shipping_city'] . " - " .
					$order_info['shipping_zone'] . " - " .
					$order_info['shipping_country'],
					"apartment" => "-",
					"street_number" => "-"));

			$value = floatval($order_info['total']) * floatval($order_info['currency_value']);
			$access_token = $this->config->get('mp_transparente_access_token');
			$mp = new MP($access_token);
			$payment_data = array("payer" => $payer,
				"external_reference" => $order_info['order_id'],
				"transaction_amount" => $value,
				//"notification_url" => $order_info['store_url'] . 'index.php?route=payment/mp_transparente/notifications',
				"notification_url" => 'http://www.google.com',
				"token" => $this->request->post['token'],
				"description" => 'Products',
				"installments" => (int) $this->request->post['installments'],
				"payment_method_id" => $this->request->post['payment_method_id']);
			$payment_data['additional_info'] = array('shipments' => $shipments, 'items' => $items);
			if (isset($this->request->post['issuer_id'])) {
				$payment_data['issuer_id'] = $this->request->post['issuer_id'];
			}

			if (strpos($order_info['email'], '@testuser.com') === false) {
				$payment_data["sponsor_id"] = $this->sponsors[$this->config->get('mp_transparente_country')];
			}

			$payment_json = json_encode($payment_data);
			error_log('$payment_json');
			error_log($payment_json);
			$payment_response = $mp->create_payment($payment_json);
			error_log("payment_response");
			error_log(json_encode($payment_response));
			error_log('payment response: ' . json_encode($payment_response));
			$this->model_checkout_order->addOrderHistory($order_info['order_id'], $this->config->get('mp_ticket_order_status_id'), null, false);
			echo json_encode(array("status" => $payment_response['status'], "message" => $payment_response['response']['status']));
			//json_encode($payment);
		} catch (Exception $e) {
			error_log('deu erro: ' . $e);
			echo json_encode(array("status" => $e->getCode(), "message" => $e->getMessage()));
		}

	}

	private function getMethods($country_id) {
		$url = "https://api.mercadolibre.com/sites/" . $country_id . "/payment_methods";
		$methods = $this->callJson($url);
		return $methods;
	}

	public function getPaymentStatus() {
		$this->load->language('payment/mp_transparente');
		$request_type = (string) $this->request->get['request_type'];
		$status = (string) $this->request->get['status'];
		$status = $request_type == "token" ? 'T' . $status : 'S' . $status;
		error_log('$status: ' . $status);
		$message = $this->language->get($status);
		error_log('$message: ' . $message);
		echo json_encode(array('message' => $message));
	}

	private function callJson($url, $posts = null) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //returns the transference value like a string
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/x-www-form-urlencoded')); //sets the header
		curl_setopt($ch, CURLOPT_URL, $url); //oauth API
		if (isset($posts)) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $posts);
		}
		$jsonresult = curl_exec($ch); //execute the conection
		curl_close($ch);
		$result = json_decode($jsonresult, true);
		return $result;
	}

	public function callback() {
		//$this->retorno();
		$this->response->redirect($this->url->link('checkout/success'));

	}

	public function notifications() {
		if (isset($this->request->get['topic'])) {
			$this->request->get['collection_id'] = $this->request->get['id'];
			$this->retorno();
			echo json_encode(200);
		} else {
			$this->retornoTransparente();
			echo json_encode(200);

		}
	}

	private function retornoTransparente() {
		$access_token = $this->config->get('mp_transparente_access_token');
		$id = $this->request->get['data_id'];
		$url = 'https://api.mercadopago.com/v1/payments/' . $id . '?access_token=' . $access_token;
		$payment = $this->callJson($url);
		$order_id = $payment['external_reference'];
		$order_status = $payment['status'];
		$this->load->model('checkout/order');
		$order = $this->model_checkout_order->getOrder($order_id);

		switch ($order_status) {
		case 'approved':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_transparente_order_status_id_completed'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount']);
			break;
		case 'pending':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_transparente_order_status_id_pending'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount']);
			break;
		case 'in_process':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_transparente_order_status_id_process'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount']);
			break;
		case 'reject':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_transparente_order_status_id_rejected'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount']);
			break;
		case 'refunded':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_transparente_order_status_id_refunded'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount']);
			break;
		case 'cancelled':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_transparente_order_status_id_cancelled'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount']);
			break;
		case 'in_metiation':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_transparente_order_status_id_in_mediation'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount']);
			break;
		default:
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_transparente_order_status_id_pending'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount']);
			break;
		}

	}
}