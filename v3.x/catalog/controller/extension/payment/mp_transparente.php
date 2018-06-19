<?php

require_once "lib/mercadopago.php";
require_once "lib/mp_util.php";

class ControllerExtensionPaymentMPTransparente extends Controller {

	private $error;
	private $order_info;
	private $message;
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

		$data['customer_email'] = $this->customer->getEmail();
		$data['button_confirm'] = $this->language->get('button_confirm');
		$data['button_back'] = $this->language->get('button_back');
		$data['terms'] = '';
		$data['public_key'] = $this->config->get('payment_mp_transparente_public_key');
		$data['site_id'] = $this->config->get('payment_mp_transparente_country');

		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$transaction_amount = floatval($order_info['total']) * floatval($order_info['currency_value']);
		$data['amount'] = $transaction_amount;
		$data['actionForm'] = $order_info['store_url'] . 'index.php?route=extension/payment/mp_transparente/payment';
		$data['payment_mp_transparente_coupon'] = $this->config->get('payment_mp_transparente_coupon');

		if ($this->config->get('payment_mp_transparente_coupon')) {
			$data['mercadopago_coupon'] = $this->language->get('mercadopago_coupon');
			$data['cupom_obrigatorio'] = $this->language->get('cupom_obrigatorio');
			$data['campanha_nao_encontrado'] = $this->language->get('campanha_nao_encontrado');
			$data['cupom_nao_pode_ser_aplicado'] = $this->language->get('cupom_nao_pode_ser_aplicado');

			$data['cupom_invalido'] = $this->language->get('cupom_invalido');
			$data['valor_minimo_invalido'] = $this->language->get('valor_minimo_invalido');
			$data['erro_validacao_cupom'] = $this->language->get('erro_validacao_cupom');
			$data['aguarde'] = $this->language->get('aguarde');
			$data['you_save'] = $this->language->get('you_save');
			$data['desconto_exclusivo'] = $this->language->get('desconto_exclusivo');
			$data['total_compra'] = $this->language->get('total_compra');
			$data['total_desconto'] = $this->language->get('total_desconto');
			$data['upon_aproval'] = $this->language->get('upon_aproval');
			$data['see_conditions'] = $this->language->get('see_conditions');
			$data['aplicar'] = $this->language->get('aplicar');
			$data['remover'] = $this->language->get('remover');

		}

		if ($this->config->get('payment_mp_transparente_country')) {
			$data['action'] = $this->config->get('payment_mp_transparente_country');
		}

		$this->load->model('checkout/order');
		$this->language->load('extension/payment/mp_transparente');

		//populate labels
		$labels = array('cucoupon_empty','cuapply','curemove','cudiscount_info1','cudiscount_info2','cudiscount_info3','cudiscount_info4','cudiscount_info5',
			'cudiscount_info6','cucoupon_of_discounts','culabel_other_bank','culabel_choose','cupayment_method','cucredit_card_number','cuexpiration_month',
			'cuexpiration_year','cuyear','cumonth','cucard_holder_name','cusecurity_code','cudocument_type','cudocument_number','cuissuer','cucard_holder_name',
			'cucard_holder_name','cuinstallments','cuyour_card','cuother_cards','cuother_card','cuended_in','cubtn_pay', 'cue205','cueE301','cue208','cue209','cue325',
			'cue326','cue221','cue316','cue224','cueE302','cueE203','cue212','cue322','cue214','cue324','cue213','cue323','cue220','cueEMPTY');

		foreach ($labels as $label) {
			$data[$label] = $this->language->get($label);
		}

		if ($this->config->get('payment_mp_transparente_coupon')) {
			$data['mercadopago_coupon'] = $this->language->get('mercadopago_coupon');
		}

		$data['server'] = $_SERVER;
		$data['debug'] = $this->config->get('payment_mp_transparente_debug');
		$data['cards'] = $this->getCards();
		$data['user_logged'] = $this->customer->isLogged();
		$view = floatval(VERSION) < 2.2 ? 'default/template/payment/' : 'extension/payment/';

		$data['analytics'] = $this->setPreModuleAnalytics();

		$view_uri = $view . 'mp_transparente';

		return $this->load->view($view_uri, $data);
	}

	public function getCardIssuers() {

		$uri = "/v1/payment_methods/card_issuers";
 		$params = array(
 			'payment_method_id' => $this->request->get['payment_method_id'],
 			'access_token' => $this->config->get('mp_transparente_access_token')
 		);
				
		$issuers = $this->get_instance_mp()->get($uri, $params);
		echo json_encode($issuers['response']);
	}

	public function coupon() {
		$coupon_id = $this->request->get['coupon_id'];

		if ($coupon_id != '') {
			$coupon_id = $coupon_id;
			$response = $this->validCoupon($coupon_id);
		} else {
			$response = array(
				'status' => 400,
				'response' => array(
					'error' => 'invalid_id',
					'message' => 'invalid id'
					)
				);
			header('Content-Type: application/json');
			echo json_encode($response);
			exit();
		}
	}

	public function validCoupon($coupon_id) {
		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$transaction_amount = floatval($order_info['total']) * floatval($order_info['currency_value']);
		$transaction_amount = round($transaction_amount, 2);
		$payer_email =  $order_info['email'];

		if ($coupon_id != '') {
			$response = $this->get_instance_mp()->check_discount_campaigns(
				$transaction_amount,
				$payer_email,
				$coupon_id
				);
			header( 'HTTP/1.1 200 OK' );
			header( 'Content-Type: application/json' );
			echo json_encode( $response );
		} else {
			$obj = new stdClass();
			$obj->status = 404;
			$obj->response = array(
				'message' => 'a problem has occurred',
				'error' => 'a problem has occurred',
				'status' => 404,
				'cause' => array()
				);
			header( 'HTTP/1.1 200 OK' );
			header( 'Content-Type: application/json' );
			echo json_encode( $obj );
		}
	}

	public function payment() {

		$params_mercadopago = $_REQUEST['mercadopago_custom'];
		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		if($params_mercadopago['paymentMethodId'] == ""){
			$params_mercadopago['paymentMethodId'] = $params_mercadopago['paymentMethodSelector'];
		}

		$total_price = round($order_info['total'] * $order_info['currency_value'], 2);
		if($this->config->get('payment_mp_transparente_country') == 'MCO'){
			$total_price = $this->currency->format($order_info['total'], $order_info['currency_code'], false, false);
		}

		$payment = array();
		$payment['transaction_amount'] = $total_price;
		$payment['token'] = $params_mercadopago['token'];
		$payment['installments'] = (int) $params_mercadopago['installments'];
		$payment['payment_method_id'] = $params_mercadopago['paymentMethodId'];
		$payment['payer']['email'] = $order_info['email'];
		$payment['external_reference'] = $this->session->data['order_id'];
		$payment['description'] = $order_info['store_name'].' - '.$order_info['order_id'];
		$notification_url = $order_info['store_url'] . 'index.php?route=extension/payment/mp_transparente/notifications';
		$domain = $_SERVER['HTTP_HOST'];
		if (strpos($domain, "localhost") === false) {
			$payment['notification_url'] = $notification_url;
		}

		if(isset($params_mercadopago['issuer']) && $params_mercadopago['issuer'] != "" && $params_mercadopago['issuer'] > -1){
			$payment['issuer_id'] = $params_mercadopago['issuer'];
		}

		$all_products = $this->cart->getProducts();
		$items = array();
		foreach ($all_products as $product) {
			$product_price = floatval(number_format(floatval($product['price']) * floatval($order_info['currency_value']), 2));
			$items[] = array(
				"id" => $product['product_id'],
				"title" => $product['name'],
				"description" => $product['quantity'] . ' x ' . $product['name'], // string
				"quantity" => intval($product['quantity']),
				"unit_price" => $product_price, //decimal
				"picture_url" => HTTP_SERVER . 'image/' . $product['image'],
				"category_id" => $this->config->get('payment_mp_transparente_category_id'),
				);
		}

		$is_test_user = strpos($order_info['email'], '@testuser.com');
		if (!$is_test_user) {

			$sponsor_id = $this->get_instance_mp_util()->sponsors[$this->config->get('payment_mp_transparente_country')];
		
			if(!empty($this->config->get('payment_mp_transparente_sponsor'))) {
				$sponsor_id = $this->config->get('payment_mp_transparente_sponsor');
			}
					
			$payment["sponsor_id"] = $sponsor_id;
		} 

		// Payer Info
		$payment['additional_info']['payer']['first_name'] = $order_info['firstname'];
		$payment['additional_info']['payer']['last_name'] = $order_info['lastname'];
		$payment['additional_info']['payer']['phone']['number'] = $order_info['telephone'];
		$payment['additional_info']['payer']['address']['street_name'] = $order_info['shipping_address_1'];
		$payment['additional_info']['payer']['address']['zip_code'] = $order_info['shipping_postcode'];

		// Shipments Info
		$payment['additional_info']['items'][] = $items;
		$payment['additional_info']['shipments']['receiver_address']['zip_code'] = $order_info['shipping_postcode'];
		$payment['additional_info']['shipments']['receiver_address']['street_name'] = $order_info['shipping_address_1'];
		$payment['additional_info']['shipments']['receiver_address']['street_number'] = "-";

		$customerAndCard = false;
		if($params_mercadopago['CustomerAndCard'] == 'true'){
			$customerAndCard = true;
			$payment['payer']['id'] = $this->getCustomerId();
		}

		$payment_method = $payment['payment_method_id'];
		$payment['metadata']['token'] = $params_mercadopago['token'];
		$payment['metadata']['customer_id'] = $this->getCustomerId();

		if(isset($params_mercadopago['campaign_id']) && $params_mercadopago['campaign_id'] != ""){
			$payment['coupon_amount'] = round($params_mercadopago['discount'],2);
			$payment['coupon_code'] = $params_mercadopago['coupon_code'];
			$payment['campaign_id'] = (int) $params_mercadopago['campaign_id'];
		}

		$this->get_instance_mp()->setEmailAdmin($this->config->get('config_email'));

		$this->get_instance_mp()->setCountryInitial($this->get_instance_mp_util()->initials[$this->config->get('payment_mp_transparente_country')]);
		$payment = $this->get_instance_mp()->create_payment($payment);

		if ($payment["status"] == 200 || $payment["status"] == 201) {
			$this->model_checkout_order->addOrderHistory($order_info['order_id'], $this->config->get('payment_mp_transparente_order_status_id_pending'), date('d/m/Y h:i') . ' - ' .
			$payment_method);
		
			$this->updateOrder($payment['response']['id']);
			$this->response->redirect($this->url->link('checkout/success', '', true));
		} else {
			$this->response->redirect($this->url->link('checkout/checkout', '', true));

		}
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

	public function callback() {

		$this->response->redirect($this->url->link('checkout/success'));
	}

	public function notifications() {
		// $this->log->write();

		if (isset($this->request->get['topic']) && $this->request->get['topic'] == 'payment') {
			$this->request->get['collection_id'] = $this->request->get['id'];

			$id = $this->request->get['id'];
			$this->updateOrder($id);

			echo json_encode(200);
		} elseif(isset($this->request->get['type']) && $this->request->get['type'] == 'payment') {

			$id = $this->request->get['data_id'];
			$this->updateOrder($id);

			echo json_encode(200);
		}
	}

	public function getCustomerId() {

		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$customer = array('email' => $order_info['email']);

		$search_uri = "/v1/customers/search";
		$response = $this->get_instance_mp()->get($search_uri, $customer);
		$response_has_results_key = array_key_exists("results", $response["response"]);
		$response_has_at_least_one_item = sizeof($response["response"]["results"]) > 0;

		if ($response_has_results_key && $response_has_at_least_one_item) {
			$customer_id = $response["response"]["results"][0]["id"];

		} else {

			$new_customer = $this->createCustomer();
			$customer_id = $new_customer["response"]["id"];

		}
		return $customer_id;
	}

	private function createCustomer() {
		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$customer = array('email' => $order_info['email']);
		$uri = '/v1/customers/';
		$response = $this->get_instance_mp()->post($uri, $customer);
		return $response;
	}

	private function getCards() {
		$id = $this->getCustomerId();
		$retorno = null;
		$cards = $this->get_instance_mp()->get("/v1/customers/" . $id . "/cards");
		if (array_key_exists("response", $cards) && sizeof($cards["response"]) > 0) {
			$this->session->data['cards'] = $cards["response"];
			$retorno = $cards["response"];
		}
		return $retorno;
	}

	private function createCard($payment) {
		$country = $this->config->get('payment_mp_transparente_country');
		if ($country != "MPE") {
			$id = $this->getCustomerId();

			$issuerId = isset($payment['issuer_id']) ? intval($payment['issuer_id']) : "";
			$paymentMethodId = isset($payment['payment_method_id']) ? $payment['payment_method_id'] : "";

			$card = $this->get_instance_mp()->post("/v1/customers/" . $id . "/cards",
				array(
					"token" => $payment['metadata']['token'],
					"issuer_id" => $issuerId,
					"payment_method_id" => $paymentMethodId
				)
			);
			return $card;
		}
	}

	private function updateOrder($payment_id) {
		$payment = $this->get_instance_mp()->getPayment($payment_id);
		$payment["pay_type_mp"] = "transparente";
		$this->load->model('checkout/order');
		$this->get_instance_mp_util()->updateOrder($payment, $this->model_checkout_order, $this->config, $this->db);

		if(isset($payment['response']['status']) && isset($payment['response']['status']) == "approved" && isset($payment['response']['card']) && $payment['response']['card']['id'] == null){
			$this->createCard($payment['response']);
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
		$token = $this->_getClientId($this->config->get('payment_mp_transparente_access_token'));
		$customerEmail = $this->customer->getEmail();
		$userLogged = $this->customer->isLogged() ? 1 : 0;

		foreach ($query->rows as $result) {
			array_push($resultModules, $result['code']);
		}

		return $this->get_instance_mp_util()->createAnalytics($resultModules, $token, $customerEmail, $userLogged); 
    }
}
