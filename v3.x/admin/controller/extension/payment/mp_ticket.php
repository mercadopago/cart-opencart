<?php

require_once '../catalog/controller/extension/payment/lib/mercadopago.php';
require_once '../catalog/controller/extension/payment/lib/mp_util.php';

class ControllerExtensionPaymentMPTicket extends Controller {
	private $_error = array();
	private static $mp_util;
	private static $mp;

	function get_instance_mp_util() {
		if ($this->mp_util == null) 
			$this->mp_util = new MPOpencartUtil();

		return $this->mp_util;
	}

	function get_instance_mp() {

		$access_token = $this->config->get('payment_mp_ticket_access_token');

		if(isset($this->request->get['access_token']))
			$access_token = $this->request->get['access_token'];

		$this->mp = new MP($access_token);  

		return $this->mp;
	}

	public function index() {
		$prefix = 'payment_mp_ticket_';
		$fields = array('access_token', 'status', 'category_id',
			'debug', 'order_status_id',
			'order_status_id_completed', 'order_status_id_pending',
			'order_status_id_canceled', 'order_status_id_in_process',
			'order_status_id_rejected', 'order_status_id_refunded',
			'order_status_id_in_mediation', 'order_status_chargeback');
		$this->load->language('extension/payment/mp_ticket');
		$this->load->model('setting/setting');
		$data['heading_title'] = $this->language->get('heading_title');
		$this->document->setTitle($data['heading_title']);

		$text_prefix = 'text_';
		$texts = array('enabled', 'disabled', 'all_zones', 'yes', 'no', 'mercadopago');

		foreach ($texts as $text) {
			$name = $text_prefix . $text;
			$data[$name] = $this->language->get($name);
		}

		$entry_prefix = 'entry_';
		$entries = array('public_key_tooltip', 'access_token_tooltip', 'payments_not_accept_tooltip', 'debug_tooltip',
			'category_tooltip', 'order_status_tooltip', 'order_status_completed_tooltip', 'order_status_pending_tooltip',
			'order_status_canceled_tooltip', 'order_status_in_process_tooltip', 'order_status_rejected_tooltip',
			'order_status_refunded_tooltip', 'order_status_in_mediation_tooltip', 'order_status_chargeback_tooltip',
			'public_key', 'access_token', 'installments', 'payments_not_accept', 'status', 'geo_zone', 'sonda_key',
			'order_status', 'ipn_status', 'debug', 'category', 'order_status_general', 'order_status_completed',
			'order_status_pending', 'order_status_canceled', 'order_status_in_process', 'order_status_rejected',
			'order_status_refunded', 'order_status_in_mediation', 'order_status_chargeback', 'sponsor');

		foreach ($entries as $entry) {
			$name = $entry_prefix . $entry;
			$data[$name] = $this->language->get($name);
		}

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['tab_general'] = $this->language->get('tab_general');

		$data['error_warning'] = isset($this->_error['warning']) ? $this->_error['warning'] : '';
		$data['error_acc_id'] = isset($this->_error['acc_id']) ? $this->_error['acc_id'] : '';
		$data['error_token'] = isset($this->_error['token']) ? $this->_error['token'] : '';
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true ),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'user_token=' . $this->session->data['user_token'], true ),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/payment/mp_ticket', 'user_token=' . $this->session->data['user_token'], true ),
		);

		$data['action'] = $this->url->link( 'extension/payment/mp_ticket', 'user_token=' . $this->session->data['user_token'], true );
		$data['cancel'] = $this->url->link( 'extension/extension', 'user_token=' . $this->session->data['user_token'], true );
		$data['category_list'] = $this->get_instance_mp_util()->getCategoryList($this->get_instance_mp());
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

		$data['methods'] = array();
		$methods_api = $this->getMethods();

		$data['methods'] = array();
		if (in_array('response', $methods_api)) {
			$response_methods = $methods_api['response'];
			$data['payment_style'] = "float:left; margin-left:5%";
			$data['mp_ticket_methods'] = preg_split("/[\s,]+/", $this->config->get('payment_mp_ticket_methods'));
			foreach ($response_methods as $method) {
				if ($method['payment_type_id'] == 'ticket') {
					$data['methods'][] = $method;
				}
			}
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			
			if ($this->isSponsorIsValid()) {
				$this->load->model('setting/setting');

				if (isset($this->request->post['payment_mp_ticket_methods'])) {
					$names = $this->request->post['payment_mp_ticket_methods'];
					$this->request->post['payment_mp_ticket_methods'] = '';
					foreach ($names as $name) {
						$this->request->post['payment_mp_ticket_methods'] .= $name . ',';
					}
				}
				$this->model_setting_setting->editSetting('payment_mp_ticket', $this->request->post);

				$this->session->data['success'] = $this->language->get('text_success');
				$this->setSettings($data);
				$this->response->redirect($this->url->link( 'marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true ));
			} else {
				$data['error_sponsor_spann'] = $this->language->get('error_sponsor_span');
			}
		}

		$this->response->setOutput($this->load->view('extension/payment/mp_ticket', $data));

	}

	private function verifyAccessToken() {
		$uri = "/users/me";
 		$params = array(
 			'access_token' => $this->request->post['payment_mp_ticket_access_token']
 		);
			
		$result = $this->get_instance_mp()->get($uri, $params, false);

		if ($result != null && isset($result['status']) && $result['status'] > 202) {
			return true;

		}
		return false;
	}

	public function getPaymentMethods() {
		$access_token = $this->request->get['access_token'];
		if ($access_token != "") {
			$this->load->model('setting/setting');
			$this->model_setting_setting->editSetting('payment_mp_ticket', array('payment_mp_ticket_access_token' => $access_token));
		}

		$payment_methods = $this->getMethods();
		if (isset($payment_methods['status']) && $payment_methods['status'] == 400) {
			echo json_encode($payment_methods);
			return;
		}

		foreach ($payment_methods['response'] as $method) {
			if ($method['payment_type_id'] == "ticket") {
				$data['methods'][] = $method;
			}
		}

		$methods_excludes = preg_split("/[\s,]+/", $this->config->get('payment_mp_ticket_methods'));
		foreach ($methods_excludes as $exclude) {
			$data['mp_ticket_methods'][] = $exclude;

		}
		if (isset($data['methods'])) {
			$data['payment_style'] = "float:left; margin-left:5%";
			$this->response->setOutput($this->load->view('extension/payment/mp_ticket_payment_methods_partial', $data));
		}
	}

	private function getMethods() {
		$this->load->language('extension/payment/mp_ticket');
		$error = array('status' => 400, 'message' => $this->language->get('error_access_token'));
		try {

			$methods = $this->get_instance_mp()->get("/v1/payment_methods", null, true);
			if($methods["status"] > 202) {		
				return $error;	
			}

			return $methods;
		} catch (Exception $e) {
			return $error;
		}
	}

	private function validate() {

		if (!$this->user->hasPermission('modify', 'extension/payment/mp_ticket')) {
			$this->_error['warning'] = $this->language->get('error_permission');
		}
		return count($this->_error) < 1;

	}

	private function isSponsorIsValid() {
		
		if (isset($this->request->post['payment_mp_ticket_sponsor'])) {
			$country_id = $this->get_instance_mp_util()->getCountryByAccessToken($this->get_instance_mp(), $this->config->get('payment_mp_ticket_access_token'));

			if($country_id != null  && !$this->get_instance_mp_util()->verifySponsorIsValid($this->get_instance_mp(), $country_id, $this->request->post['payment_mp_ticket_sponsor'])){

				return false;
			}
		}
		return true;
	}

	public function setSettings($data) {
        $basic = "false";

        if ($data['payment_mp_ticket_status'] == "1") {
			$basic = "true";        	
        }

        $result = $this->get_instance_mp_util()->setSettings($this->get_instance_mp(), $this->config->get('config_email'), false, false, false, $basic); 

		return $result;  
    }
}