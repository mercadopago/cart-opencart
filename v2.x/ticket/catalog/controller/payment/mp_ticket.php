<?php

require_once "mercadopago.php";

class ControllerPaymentMPTicket extends Controller {

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
		$this->language->load('payment/mp_ticket');
		$data['public_key'] = $this->config->get('mp_ticket_public_key');
		$data['payment_button'] = $this->language->get('payment_button');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/mp_ticket.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/mp_ticket.tpl', $data);
		} else {
			return $this->load->view('payment/mp_ticket.tpl', $data);
		}
	}

	public function payment() {
		$this->language->load('payment/mp_ticket');
		try
		{
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
					"category_id" => $this->config->get('mp_ticket_category_id'),
				);
			}

			$payer = array("email" => $order_info['email']);

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
			$access_token = $this->config->get('mp_ticket_access_token');
			$mp = new MP($access_token);
			$payment_data = array("payer" => $payer,
				"external_reference" => $order_info['order_id'],
				"transaction_amount" => $value,
				//"notification_url" => $order_info['store_url'] . 'index.php?route=payment/mp_ticket/notifications',
				"notification_url" => 'http://www.google.com',
				//"token" => $this->request->post['token'],
				"description" => 'Products',
				//"payment_method_id" => $this->request->post['payment_method_id']);
				"payment_method_id" => 'bolbradesco');
			$payment_data['additional_info'] = array('shipments' => $shipments, 'items' => $items);

			if (strpos($order_info['email'], '@testuser.com') === false) {
				$payment_data["sponsor_id"] = $this->sponsors[$this->config->get('mp_ticket_country')];
			}

			/*
			$payment_json = json_encode($payment_data);
			error_log('$payment_json');
			error_log($payment_json);
			*/
			$payment_response = $mp->post("/v1/payments", $payment_data);
			error_log("payment_response");
			error_log(json_encode($payment_response));
			echo json_encode(array("status" => $payment_response['status'], "url" => $payment_response['response']['transaction_details']['external_resource_url']));
			//json_encode($payment);
		} catch (Exception $e) {
			error_log('deu erro: ' . $e);
			echo json_encode(array("status" => $e->getCode(), "message" => $e->getMessage()));
		}

	}

	private function getMethods($token) {
		try
		{
			$mp = new MP($token);
			$methods = $mp->get("/v1/payment_methods");
			return $methods;
		} catch (Exception $e) {
			$this->load->language('payment/mp_ticket');
			$error = array('status' => 400, 'message' => $this->language->get('error_access_token'));
			return $error;
		}

	}

	public function getPaymentStatus() {
		$this->load->language('payment/mp_ticket');
		$request_type = (string) $this->request->get['request_type'];
		$status = (string) $this->request->get['status'];
		$status = $request_type == "token" ? 'T' . $status : 'S' . $status;
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
		$access_token = $this->config->get('mp_ticket_access_token');
		$id = $this->request->get['data_id'];
		$url = 'https://api.mercadopago.com/v1/payments/' . $id . '?access_token=' . $access_token;
		$payment = $this->callJson($url);
		$order_id = $payment['external_reference'];
		$order_status = $payment['status'];
		$this->load->model('checkout/order');
		$order = $this->model_checkout_order->getOrder($order_id);

		switch ($order_status) {
		case 'approved':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_ticket_order_status_id_completed'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount']);
			break;
		case 'pending':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_ticket_order_status_id_pending'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount']);
			break;
		case 'in_process':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_ticket_order_status_id_process'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount']);
			break;
		case 'reject':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_ticket_order_status_id_rejected'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount']);
			break;
		case 'refunded':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_ticket_order_status_id_refunded'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount']);
			break;
		case 'cancelled':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_ticket_order_status_id_cancelled'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount']);
			break;
		case 'in_metiation':
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_ticket_order_status_id_in_mediation'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount']);
			break;
		default:
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mp_ticket_order_status_id_pending'), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount']);
			break;
		}

	}
}