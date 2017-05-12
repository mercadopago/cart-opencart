<?php

require_once '../catalog/controller/extension/payment/mercadopago.php';

class ControllerExtensionPaymentMPStandard extends Controller {
	private $_error = array();
	private $version = "2.3";
	private $versionModule = "2.3.1";

	public function index() {
		$prefix = 'mp_standard_';
		$fields = array('client_id', 'client_secret', 'status', 'category_id',
			'debug', 'sandbox', 'country', 'installments', 'order_status_id',
			'order_status_id_completed', 'order_status_id_pending', 'order_status_id_canceled', 'type_checkout',
			'order_status_id_in_process', 'order_status_id_rejected', 'order_status_id_refunded',
			'order_status_id_in_mediation', 'order_status_chargeback');

		$entries_prefix = 'entry_';
		$entries = array('autoreturn_tooltip', 'public_key_tooltip', 'access_token_tooltip',
			'client_id_tooltip', 'client_secret_tooltip', 'url_tooltip',
			'payments_not_accept_tooltip', 'debug_tooltip', 'sandbox_tooltip',
			'category_tooltip', 'order_status_tooltip', 'order_status_completed_tooltip',
			'order_status_pending_tooltip', 'order_status_canceled_tooltip',
			'order_status_in_process_tooltip', 'order_status_rejected_tooltip',
			'order_status_refunded_tooltip', 'order_status_in_mediation_tooltip',
			'order_status_chargeback_tooltip', 'notification_url_tooltip', 'public_key',
			'access_token', 'notification_url', 'autoreturn', 'client_id', 'client_secret',
			'installments', 'payments_not_accept', 'status', 'geo_zone', 'country', 'sonda_key',
			'order_status', 'ipn_status', 'url', 'debug', 'ipn', 'sandbox', 'type_checkout', 'category',
			'order_status_general', 'order_status_completed', 'order_status_pending', 'order_status_canceled',
			'order_status_in_process', 'order_status_rejected', 'order_status_refunded', 'order_status_in_mediation',
			'order_status_chargeback');
		$this->load->language('extension/payment/mp_standard');

		foreach ($entries as $entry) {
			$name = $entries_prefix . $entry;
			$data[$name] = $this->language->get($name);
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$this->document->setTitle($data['heading_title']);
		$this->load->model('setting/setting');

		$text_prefix = 'text_';
		$texts = array('enabled', 'disabled', 'all_zones', 'yes', 'no', 'mercadopago');

		foreach ($texts as $text) {
			$name = $text_prefix . $text;
			$data[$name] = $this->language->get($name);
		}
		error_log("=====setSettings 1======");
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['tab_general'] = $this->language->get('tab_general');

		$data['mp_standard_enable_return'] = isset($this->request->post['mp_standard_enable_return']) ?
		$this->request->post['mp_standard_enable_return'] :
		$this->config->get('mp_standard_enable_return');

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
			'href' => $this->url->link('extension/payment/mp_standard', 'token=' . $this->session->data['token'], 'SSL'),
		);

		$data['action'] = HTTPS_SERVER . 'index.php?route=extension/payment/mp_standard&token=' . $this->session->data['token'];
		$data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/extension&token=' . $this->session->data['token'];
		$data['category_list'] = $this->getCategoryList();
		$data['type_checkout'] = array("Redirect", "Lightbox", "Iframe");
		$data['countries'] = $this->getCountries();
		$data['installments'] = $this->getInstallments();
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			error_log("=====setSettings 1======");
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

		$country_id = $this->config->get('mp_standard_country') == null ?
		'MLA' : $this->config->get('mp_standard_country');

		$methods_api = $this->getMethods($country_id);
		$data['methods'] = array();
		$data['mp_standard_methods'] = preg_split("/[\s,]+/", $this->config->get('mp_standard_methods'));
		foreach ($methods_api as $method) {
			$data['methods'][] = $method;
		}

		$data['payment_style'] = isset($data['methods']) && count($data['methods']) > 12 ?
		"float:left; margin-left:2%" : "float:left; margin-left:5%";

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');

			if (isset($this->request->post['mp_standard_methods'])) {
				$names = $this->request->post['mp_standard_methods'];
				$this->request->post['mp_standard_methods'] = '';
				foreach ($names as $name) {
					$this->request->post['mp_standard_methods'] .= $name . ',';
				}
			}
			$this->model_setting_setting->editSetting('mp_standard', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			$this->setSettings();
			$this->response->redirect(HTTPS_SERVER . 'index.php?route=extension/extension&token=' . $this->session->data['token']);
		}

		$this->response->setOutput($this->load->view('extension/payment/mp_standard.tpl', $data));

	}

	public function getPaymentMethodsByCountry() {
		$country_id = $this->request->get['country_id'];
		$payment_methods = $this->getMethods($country_id);

		foreach ($payment_methods as $method) {
			$data['methods'][] = $method;
		}

		$methods_excludes = preg_split("/[\s,]+/", $this->config->get('mp_standard_methods'));
		foreach ($methods_excludes as $exclude) {
			$data['mp_standard_methods'][] = $exclude;

		}

		if (isset($data['methods'])) {
			$data['payment_style'] = count($data['methods']) > 12 ? "float:left; margin-left:7%" : "float:left; margin-left:5%";
			$this->response->setOutput($this->load->view('extension/payment/mp_standard_payment_methods_partial.tpl', $data));
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
		try {
			if (isset($posts)) {
				curl_setopt($ch, CURLOPT_POSTFIELDS, $posts);
			}
			$jsonresult = curl_exec($ch); //execute the conection
			curl_close($ch);
			$result = json_decode($jsonresult, true);
			return $result;
		} catch (Exception $e) {
			$error = curl_error($ch);
			error_log($error);
			$this->_error['warning'] = $error;
		}

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

    public function setSettings()
    {
		error_log("=====setSettings 1======");
		$client_id = $this->config->get('mp_standard_client_id');
		$client_secret = $this->config->get('mp_standard_client_secret');
		$mp = new MP($client_id, $client_secret);

        $moduleVersion = $this->version;
        $siteId = $this->config->get('mp_standard_country');
        $dataCreated = date('Y-m-d H:i:s');

        $phpVersion = phpversion();
        $soServer = PHP_OS;
        $modulesId = "OPENCART " . "2.0";

        $standardStatus = "false";

        if ($this->request->post['mp_standard_status'] == "1") {
			$standardStatus = "true";
        }

        $request = array(
            "module_version" => $this->versionModule,
            "checkout_basic" => $standardStatus,
            "code_version" => phpversion(),
            "platform" => "OpenCart",
            "platform_version" => $this->version
    	);

        try {
			$mp->saveSettings($request);
        } catch (Exception $e) {
        	error_log($e);
        }
    }

	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/payment/mp_standard')) {
			$this->_error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->request->post['mp_standard_client_id']) {
			$this->_error['error_client_id'] = $this->language->get('error_client_id');
		}

		if (!$this->request->post['mp_standard_client_secret']) {
			$this->_error['error_client_secret'] = $this->language->get('error_client_secret');
		}

		return count($this->_error) < 1;

	}
}