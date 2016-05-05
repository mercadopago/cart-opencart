<?php

require_once "mercadopago.php";

class ControllerPaymentMPTransparente extends Controller {
	private $error;
	public $sucess = true;
	private $order_info;
	private $message;
	private $special_checkouts = array('MLM', 'MLB');
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
		$data['terms'] = '';
		$data['public_key'] = $this->config->get('mp_transparente_public_key');

		if ($this->config->get('mp_transparente_country')) {
			$data['action'] = $this->config->get('mp_transparente_country');
		}

		$this->load->model('checkout/order');

		//populate labels
		$this->language->load('payment/mp_transparente');
		$data['ccnum_placeholder'] = $this->language->get('ccnum_placeholder');
		$data['expiration_month_placeholder'] = $this->language->get('expiration_month_placeholder');
		$data['expiration_year_placeholder'] = $this->language->get('expiration_year_placeholder');
		$data['name_placeholder'] = $this->language->get('name_placeholder');
		$data['doctype_placeholder'] = $this->language->get('doctype_placeholder');
		$data['docnumber_placeholder'] = $this->language->get('docnumber_placeholder');
		$data['installments_placeholder'] = $this->language->get('installments_placeholder');
		$data['cardType_placeholder'] = $this->language->get('cardType_placeholder');
		$data['payment_button'] = $this->language->get('payment_button');
		$data['payment_title'] = $this->language->get('payment_title');
		$data['payment_processing'] = $this->language->get('payment_processing');
		$data['server'] = $_SERVER;
		$data['debug'] = $this->config->get('mp_transparente_debug');
		$data['cards'] = $this->getCards();

		if (strpos($this->config->get('config_url'), 'localhost')) {
			$partial = in_array($data['action'], $this->special_checkouts) ? $data['action'] : 'default';
			//$partial_url = 'payment/partials/mp_transparente_' . $partial . '.tpl';
			//$file_path = DIR_TEMPLATE . $this->config->get('config_template') . $partial_url;
			$data['partial'] = $this->load->view('default/template/payment/partials/mp_transparente_' . $partial . '.tpl', $data);
			$view_uri = 'default/template/payment/mp_transparente.tpl';
		} else {
			$partial = in_array($data['action'], $this->special_checkouts) ? $data['action'] : 'default';
			//$partial_url = 'payment/partials/mp_transparente_' . $partial . '.tpl';
			//$file_path = DIR_TEMPLATE . $this->config->get('config_template') . $partial_url;
			$data['partial'] = $this->load->view('payment/partials/mp_transparente_' . $partial . '.tpl', $data);
			$view_uri = 'payment/mp_transparente.tpl';
		}

		return $this->load->view($view_uri, $data);
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
		try {
			$exclude = $this->config->get('mp_transparente_methods');
			$accepted_methods = preg_split("/[\s,]+/", $exclude);
			$payment_method_id = $this->request->post['payment_method_id'];
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
					"unit_price" => round(floatval($product['price']) * floatval($order_info['currency_value']), 2), //decimal
					"picture_url" => HTTP_SERVER . 'image/' . $product['image'],
					"category_id" => $this->config->get('mp_transparente_category_id'),
				);
			}

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
				"notification_url" => $order_info['store_url'] . 'index.php?route=payment/mp_transparente/notifications',
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
			$accepted_status = array('approved', "in_process");
			$payment_response = $mp->create_payment($payment_json);
			$this->updateOrder($payment_response['response']['id']);
			$json_response = array('status' => null, 'message' => null);

			if (in_array($payment_response['response']['status'], $accepted_status)) {
				$this->createCart($payment_data['token']);
				$json_response['status'] = $payment_response['response']['status'];
			} else {
				$json_response['status'] = $payment_response['response']['status_detail'];
			}

			echo json_encode($json_response);
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
		$request_type = isset($this->request->get['request_type']) ? (string) $this->request->get['request_type'] : "";
		$status = (string) $this->request->get['status'];
		if ($request_type) {
			$status = $request_type == "token" ? 'T' . $status : 'S' . $status;
		}

		$message = $this->language->get($status);
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
	public function getCustomerId() {
		$access_token = $this->config->get('mp_transparente_access_token');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$customer = array('email' => $order_info['email']);
		error_log('email customer:' . $order_info['email']);
		$search_uri = "/v1/customers/search";
		$mp = new MP($access_token);
		$response = $mp->get($search_uri, $customer);

		return array_key_exists("results", $response["response"]) && sizeof($response["response"]["results"]) > 0 ? 
               $response["response"]["results"][0]["id"] : $this->createCustomer()["id"];
	}

	private function createCustomer() {
		$access_token = $this->config->get('mp_transparente_access_token');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$customer = array('email' => $order_info['email']);
		$uri = '/v1/customers/';
		$mp = new MP($access_token);
		$response = $mp->post($uri, $customer);
		return $response;
	}

	private function getCards() {
		$id = $this->getCustomerId();
        $access_token = $this->config->get('mp_transparente_access_token');
        $mp = new MP ($access_token);
        $cards = $mp->get ("/v1/customers/" . $id . "/cards");
        return array_key_exists("response", $cards) && sizeof($cards["response"]["results"]) > 0 ? 
               $cards["response"]["results"][0]["id"] : null;

print_r ($cards["response"]);
	}

	private function createCard($token) {
		$id = $this->getCustomerId();
		$access_token = $this->config->get('mp_transparente_access_token');
		$mp = new MP($access_token);
		$card = $mp->post("/v1/customers/" . $id . "/cards", array("token" => $token);
        error_log('card criado: ' . json_encode($card));
        return $card;
	}

	private function retornoTransparente($token) {
		$id = $this->request->get['data_id'];
		$this->updateOrder($id);
	}

	private function updateOrder($id) {
		$access_token = $this->config->get('mp_transparente_access_token');
		$url = 'https://api.mercadopago.com/v1/payments/' . $id . '?access_token=' . $access_token;
		$payment = $this->callJson($url);
		$order_id = $payment['external_reference'];
		$this->load->model('checkout/order');
		$order = $this->model_checkout_order->getOrder($order_id);
		$order_status = $payment['status'];
		switch ($order_status) {
		case 'approved':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_transparente_order_status_id_completed'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount'] . ' - Payment ID:' . $payment['id']);
			break;
		case 'pending':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_transparente_order_status_id_pending'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount'] . ' - Payment ID:' . $payment['id']);
			break;
		case 'in_process':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_transparente_order_status_id_process'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount'] . ' - Payment ID:' . $payment['id']);
			break;
		case 'reject':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_transparente_order_status_id_rejected'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount'] . ' - Payment ID:' . $payment['id']);
			break;
		case 'refunded':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_transparente_order_status_id_refunded'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount'] . ' - Payment ID:' . $payment['id']);
			break;
		case 'cancelled':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_transparente_order_status_id_cancelled'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount'] . ' - Payment ID:' . $payment['id']);
			break;
		case 'in_mediation':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_transparente_order_status_id_in_mediation'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount'] . ' - Payment ID:' . $payment['id']);
			break;
		default:
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_transparente_order_status_id_pending'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount'] . ' - Payment ID:' . $payment['id']);
			break;
		}
	}
}
