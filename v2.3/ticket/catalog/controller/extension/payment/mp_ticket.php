<?php

require_once "mercadopago.php";

class ControllerExtensionPaymentMPTicket extends Controller {

	private $version = "1.0.1";
	private $versionModule = "2.3.2";
	private $error;
	public $sucess = true;
	private $order_info;
	private $message;
	private $sponsors = array('MLB' => 204931135,
		'MLM' => 204962951,
		'MLA' => 204931029,
		'MCO' => 204964815,
		'MLV' => 204964612,
		'MPE' => 217176790,
		'MLC' => 204927454);

	public function index() {
		$this->language->load('extension/payment/mp_ticket');
		$data['payment_button'] = $this->language->get('payment_button');

		error_log("====tradução payment=====".$this->language->get('payment_button'));

		$data['analytics'] = $this->setPreModuleAnalytics();
		$data['payment_button'] = $this->language->get('payment_button');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/extension/payment/mp_ticket.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/extension/payment/mp_ticket.tpl', $data);
		} else {
			return $this->load->view('extension/payment/mp_ticket.tpl', $data);
		}
	}

	public function payment() {
		$this->language->load('extension/payment/mp_ticket');
		try
		{
			$this->load->model('checkout/order');
			$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
			$all_products = $this->cart->getProducts();
			$items = array();
			$site_id = $this->getCountry();

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

			$access_token = $this->config->get('mp_ticket_access_token');
			$mp = new MP($access_token);

			$total_price = round($order_info['total'] * $order_info['currency_value'], 2);
			if($site_id == 'MCO'){
				$total_price = $this->currency->format($order_info['total'], $order_info['currency_code'], false, false);
			}

			$payment_data = array("payer" => $payer,
				"external_reference" => $order_info['order_id'],
				"transaction_amount" => $total_price,
				//"token" => $this->request->post['token'],
				"description" => 'Products',
				"payment_method_id" => $this->request->get['payment_method_id']);

			$url = $order_info['store_url'];
		    if (!strrpos($url, 'localhost')) {
		    	$payment_data['notification_url'] = $url . 'index.php?route=extension/payment/mp_ticket/notifications';
		    }

			// Payer Info
			$payment_data['additional_info']['payer']['first_name'] = $order_info['firstname'];
			$payment_data['additional_info']['payer']['last_name'] = $order_info['lastname'];
			$payment_data['additional_info']['payer']['phone']['number'] = $order_info['telephone'];
			$payment_data['additional_info']['payer']['address']['street_name'] = $order_info['shipping_address_1'];
			$payment_data['additional_info']['payer']['address']['zip_code'] = $order_info['shipping_postcode'];

			// Shipments Info
			$payment_data['additional_info']['items'][] = $items;
			$payment_data['additional_info']['shipments']['receiver_address']['zip_code'] = $order_info['shipping_postcode'];
			$payment_data['additional_info']['shipments']['receiver_address']['street_name'] = $order_info['shipping_address_1'];
			$payment_data['additional_info']['shipments']['receiver_address']['street_number'] = "-";

			$is_test_user = strpos($order_info['email'], '@testuser.com');
			if (!$is_test_user) {
				$payment_data["sponsor_id"] = $this->sponsors[$site_id];
			}

			$payment_response = $mp->create_payment($payment_data);

			$this->model_checkout_order->addOrderHistory($order_info['order_id'], $this->config->get('mp_ticket_order_status_id'), null, false);
			echo json_encode(
				array("status" => $payment_response['status'],
					"url" => $payment_response['response']['transaction_details']['external_resource_url'],
					"token" => $this->_getClientId($this->config->get('mp_ticket_access_token')),
					"paymentId" =>  $payment_response['response']['payment_method_id'],
					"paymentType" => $payment_response['response']['payment_type_id'],
					"checkoutType" => "ticket"
					)
				);
		} catch (Exception $e) {
			error_log('deu erro: ' . $e);
			echo json_encode(array("status" => $e->getCode(), "message" => $e->getMessage()));
		}

	}

	private function getCountry() {
		$access_token = $this->config->get('mp_ticket_access_token');
		$mp = new MP($access_token);
		$result = $mp->get('/users/me?access_token=' . $access_token);
		return $result['response']['site_id'];
	}

	private function getMethods($token) {
		try
		{
			$mp = new MP($token);
			$methods = $mp->get("/v1/payment_methods");
			return $methods;
		} catch (Exception $e) {
			$this->load->language('extension/payment/mp_ticket');
			$error = array('status' => 400, 'message' => $this->language->get('error_access_token'));
			return $error;
		}

	}

	public function getAcceptedMethods() {
		$token = $this->config->get('mp_ticket_access_token');
		$methods = $this->getMethods($token);
		$methods_api = $methods['response'];
		$saved_methods = preg_split("/[\s,]+/", $this->config->get('mp_ticket_methods'));
		$accepted_methods = array();
		foreach ($methods_api as $method) {
			if (in_array($method['id'], $saved_methods)) {
				$accepted_methods[] = array('method' => $method['id'], 'secure_thumbnail' => $method['secure_thumbnail']);
			}
		}
		echo json_encode(array('methods' => $accepted_methods));

	}

	public function getPaymentStatus() {
		$this->load->language('extension/payment/mp_ticket');
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
		case 'rejected':
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

	function _getClientId($at){
		$t = explode ( "-" , $at);
		if(count($t) > 0){
			return $t[1];
		}
		return "";
	}

    function setPreModuleAnalytics() {

		$query = $this->db->query("SELECT code FROM " . DB_PREFIX . "extension WHERE type = 'payment'");

        $resultModules = array();

		foreach ($query->rows as $result) {
			array_push($resultModules, $result['code']);
		}



        $return = array(
            'publicKey'=> "",
            'token'=> $this->_getClientId($this->config->get('mp_ticket_access_token')),
            'platform' => "Opencart",
            'platformVersion' => $this->versionModule,
            'moduleVersion' => $this->version,
            'payerEmail' => $this->customer->getEmail(),
            'userLogged' => $this->customer->isLogged() ? 1 : 0,
            'installedModules' => implode(', ', $resultModules),
            'additionalInfo' => ""
        );

        error_log("===setPreModuleAnalytics====" . json_encode($return));

        return $return;
    }
}
