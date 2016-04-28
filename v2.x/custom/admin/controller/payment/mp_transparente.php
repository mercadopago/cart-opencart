<?php

require_once '../catalog/controller/payment/mercadopago.php';

class ControllerPaymentMPTransparente extends Controller {
	private $_error = array();
	private $payment_types = array('debvisa', 'debmaster', 'credit_card', 'debit_card');
	public function index() {
		$prefix = 'mp_transparente_';
		$fields = array('public_key', 'access_token', 'status', 'category_id',
			'debug', 'country', 'installments', 'order_status_id',
			'order_status_id_completed', 'order_status_id_pending',
			'order_status_id_canceled', 'order_status_id_in_process',
			'order_status_id_rejected', 'order_status_id_refunded',
			'order_status_id_in_mediation', 'order_status_chargeback');

		$this->load->language('payment/mp_transparente');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_mercadopago'] = $this->language->get('text_mercadopago');

		//Tooltips
		$data['entry_public_key_tooltip'] = $this->language->get('entry_public_key_tooltip');
		$data['entry_access_token_tooltip'] = $this->language->get('entry_access_token_tooltip');
		$data['entry_payments_not_accept_tooltip'] = $this->language->get('entry_payments_not_accept_tooltip');
		$data['entry_debug_tooltip'] = $this->language->get('entry_debug_tooltip');
		$data['entry_category_tooltip'] = $this->language->get('entry_category_tooltip');
		$data['entry_order_status_tooltip'] = $this->language->get('entry_order_status_tooltip');
		$data['entry_order_status_completed_tooltip'] = $this->language->get('entry_order_status_completed_tooltip');
		$data['entry_order_status_pending_tooltip'] = $this->language->get('entry_order_status_pending_tooltip');
		$data['entry_order_status_canceled_tooltip'] = $this->language->get('entry_order_status_canceled_tooltip');
		$data['entry_order_status_in_process_tooltip'] = $this->language->get('entry_order_status_in_process_tooltip');
		$data['entry_order_status_rejected_tooltip'] = $this->language->get('entry_order_status_rejected_tooltip');
		$data['entry_order_status_refunded_tooltip'] = $this->language->get('entry_order_status_refunded_tooltip');
		$data['entry_order_status_in_mediation_tooltip'] = $this->language->get('entry_order_status_in_mediation_tooltip');
		$data['entry_order_status_chargeback_tooltip'] = $this->language->get('entry_order_status_chargeback_tooltip');

		//end tooltips
		$data['entry_public_key'] = $this->language->get('entry_public_key');
		$data['entry_access_token'] = $this->language->get('entry_access_token');
		$data['entry_installments'] = $this->language->get('entry_installments');
		$data['entry_payments_not_accept'] = $this->language->get('entry_payments_not_accept');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_sonda_key'] = $this->language->get('entry_sonda_key');
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_ipn_status'] = $this->language->get('entry_ipn_status');
		$data['entry_debug'] = $this->language->get('entry_debug');
		$data['entry_category'] = $this->language->get('entry_category');

		$data['entry_order_status_general'] = $this->language->get('entry_order_status_general');
		$data['entry_order_status_completed'] = $this->language->get('entry_order_status_completed');
		$data['entry_order_status_pending'] = $this->language->get('entry_order_status_pending');
		$data['entry_order_status_canceled'] = $this->language->get('entry_order_status_canceled');
		$data['entry_order_status_in_process'] = $this->language->get('entry_order_status_in_process');
		$data['entry_order_status_rejected'] = $this->language->get('entry_order_status_rejected');
		$data['entry_order_status_refunded'] = $this->language->get('entry_order_status_refunded');
		$data['entry_order_status_in_mediation'] = $this->language->get('entry_order_status_in_mediation');
		$data['entry_order_status_chargeback'] = $this->language->get('entry_order_status_chargeback');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['tab_general'] = $this->language->get('tab_general');

		$data['error_warning'] = isset($this->_error['warning']) ? $this->_error['warning'] : '';
		$data['error_acc_id'] = isset($this->_error['acc_id']) ? $this->_error['acc_id'] : '';
		$data['error_token'] = isset($this->_error['token']) ? $this->_error['token'] : '';
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('payment/mp_transparente', 'token=' . $this->session->data['token'], 'SSL'),
		);

		$data['action'] = HTTPS_SERVER . 'index.php?route=payment/mp_transparente&token=' . $this->session->data['token'];
		$data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'];
		$data['category_list'] = $this->getCategoryList();
		$data['countries'] = $this->getCountries();
		$data['installments'] = $this->getInstallments();
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

		$country_id = $this->config->get('mp_transparente_country') == null ?
		'MLA' : $this->config->get('mp_transparente_country');

		$methods_api = $this->getMethods($country_id);
		$data['methods'] = array();
		$data['mp_transparente_methods'] = preg_split("/[\s,]+/", $this->config->get('mp_transparente_methods'));
		foreach ($methods_api as $method) {
			if (in_array($method['payment_type_id'], $this->payment_types)) {
				$data['methods'][] = $method;
			}
		}

		$data['payment_style'] = isset($data['methods']) && count($data['methods']) > 12 ?
		"float:left; margin-left:2%" : "float:left; margin-left:5%";

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');

			if (isset($this->request->post['mp_transparente_methods'])) {
				$names = $this->request->post['mp_transparente_methods'];
				$this->request->post['mp_transparente_methods'] = '';
				foreach ($names as $name) {
					$this->request->post['mp_transparente_methods'] .= $name . ',';
				}
			}
			$this->model_setting_setting->editSetting('mp_transparente', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect(HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token']);

		}

		$this->response->setOutput($this->load->view('payment/mp_transparente.tpl', $data));

	}

	public function getPaymentMethodsByCountry() {
		$country_id = $this->request->get['country_id'];
		$payment_methods = $this->getMethods($country_id);

		foreach ($payment_methods as $method) {
			if (in_array($method['payment_type_id'], $this->payment_types)) {
				$data['methods'][] = $method;
			}
		}

		$methods_excludes = preg_split("/[\s,]+/", $this->config->get('mp_transparente_methods'));
		foreach ($methods_excludes as $exclude) {
			$data['mp_transparente_methods'][] = $exclude;

		}

		if (isset($data['methods'])) {
			$data['payment_style'] = count($data['methods']) > 12 ? "float:left; margin-left:7%" : "float:left; margin-left:5%";
			$this->response->setOutput($this->load->view('payment/mp_transparente_payment_methods_partial.tpl', $data));
		}
	}

	private function getCountries() {
		$url = 'https://api.mercadolibre.com/sites/';
		$countries = $this->callJson($url);
		return $countries;
	}

	private function getMethods($country_id) {
		$url = "https://api.mercadolibre.com/sites/" . $country_id . "/payment_methods";
		$methods = $this->callJson($url);
		return $methods;
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

	private function getCategoryList() {
		$url = "https://api.mercadolibre.com/item_categories";
		$category = $this->callJson($url);
		return $category;
	}

	private function getInstallments() {
		$installments = array();

		$installments[] = array(
			'value' => '24',
			'id' => '24');

		$installments[] = array(
			'value' => '18',
			'id' => '18');
		$installments[] = array(
			'value' => '15',
			'id' => '15');

		$installments[] = array(
			'value' => '12',
			'id' => '12');

		$installments[] = array(
			'value' => '11',
			'id' => '11');

		$installments[] = array(
			'value' => '10',
			'id' => '10');

		$installments[] = array(
			'value' => '9',
			'id' => '9');

		$installments[] = array(
			'value' => '7',
			'id' => '7');

		$installments[] = array(
			'value' => '6',
			'id' => '6');

		$installments[] = array(
			'value' => '5',
			'id' => '5');

		$installments[] = array(
			'value' => '4',
			'id' => '4');

		$installments[] = array(
			'value' => '3',
			'id' => '3');
		$installments[] = array(
			'value' => '2',
			'id' => '2');

		$installments[] = array(
			'value' => '1',
			'id' => '1');

		return $installments;
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/mp_transparente')) {
			$this->_error['warning'] = $this->language->get('error_permission');
		}
		return count($this->_error) < 1;

	}
}