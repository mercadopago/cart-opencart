<?php
class ControllerPaymentMercadopago2 extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/mercadopago2');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');
                        
                        if(isset($this->request->post['mercadopago2_methods'])){
                            $names = $this->request->post['mercadopago2_methods'];
                            $this->request->post['mercadopago2_methods'] = '';
                            foreach ($names as $name){
                                $this->request->post['mercadopago2_methods'] .= $name.',';
                            }            
                        }
			$this->model_setting_setting->editSetting('mercadopago2', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token']);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_mercadopago'] = $this->language->get('text_mercadopago');

		$this->data['entry_client_id'] = $this->language->get('entry_client_id');
		$this->data['entry_client_secret'] = $this->language->get('entry_client_secret');
                $this->data['entry_installments'] = $this->language->get('entry_installments');
                $this->data['entry_payments_not_accept'] = $this->language->get('entry_payments_not_accept');
                $this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_country'] = $this->language->get('entry_country');
		$this->data['entry_sonda_key'] = $this->language->get('entry_sonda_key');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_ipn_status'] = $this->language->get('entry_ipn_status');
                $this->data['entry_url'] = $this->language->get('entry_url');
                $this->data['entry_debug'] = $this->language->get('entry_debug');
                $this->data['entry_ipn'] = $this->language->get('text_ipn');
		$this->data['entry_order_status_completed'] = $this->language->get('entry_order_status_completed');
		$this->data['entry_order_status_pending'] = $this->language->get('entry_order_status_pending');
		$this->data['entry_order_status_canceled'] = $this->language->get('entry_order_status_canceled');
                $this->data['entry_order_status_in_process'] = $this->language->get('entry_order_status_in_process');
		$this->data['entry_order_status_rejected'] = $this->language->get('entry_order_status_rejected');
		$this->data['entry_order_status_refunded'] = $this->language->get('entry_order_status_refunded');
                $this->data['entry_order_status_in_mediation'] = $this->language->get('entry_order_status_in_mediation');
                
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['acc_id'])) {
			$this->data['error_acc_id'] = $this->error['acc_id'];
		} else {
			$this->data['error_acc_id'] = '';
		}

 		if (isset($this->error['token'])) {
			$this->data['error_token'] = $this->error['token'];
		} else {
			$this->data['error_token'] = '';
		}

		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_payment'),
      		'separator' => ' :: '
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=payment/mercadopago2&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = HTTPS_SERVER . 'index.php?route=payment/mercadopago2&token=' . $this->session->data['token'];

		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'];

		if (isset($this->request->post['mercadopago2_client_id'])) {
			$this->data['mercadopago2_client_id'] = $this->request->post['mercadopago2_client_id'];
		} else {
			$this->data['mercadopago2_client_id'] = $this->config->get('mercadopago2_client_id');
		}

		if (isset($this->request->post['mercadopago2_client_secret'])) {
			$this->data['mercadopago2_client_secret'] = $this->request->post['mercadopago2_client_secret'];
		} else {
			$this->data['mercadopago2_client_secret'] = $this->config->get('mercadopago2_client_secret');
		}

		if (isset($this->request->post['mercadopago2_status'])) {
			$this->data['mercadopago2_status'] = $this->request->post['mercadopago2_status'];
		} else {
			$this->data['mercadopago2_status'] = $this->config->get('mercadopago2_status');
		}
                
                if (isset($this->request->post['mercadopago2_url'])) {
			$this->data['mercadopago2_url'] = $this->request->post['mercadopago2_url'];
		} else {
			$this->data['mercadopago2_url'] = $this->config->get('mercadopago2_url');
		}
                
                if (isset($this->request->post['mercadopago2_debug'])) {
			$this->data['mercadopago2_debug'] = $this->request->post['mercadopago2_debug'];
		} else {
			$this->data['mercadopago2_debug'] = $this->config->get('mercadopago2_debug');
		}
                
                
                
                
                

		$this->data['countries'] = $this->getCountries();
                $this->data['installments'] = $this->getInstallments();
              ;

               if ($this->config->get('mercadopago2_country')){
		   $this->data['methods'] = $this->getMethods($this->config->get('mercadopago2_country'));    
               }
              
		if (isset($this->request->post['mercadopago2_methods'])) {
			$this->data['mercadopago2_methods'] = $this->request->post['mercadopago2_methods'];
		} else {
                         $methods_excludes = preg_split("/[\s,]+/",$this->config->get('mercadopago2_methods')); 
                         foreach ($methods_excludes as $exclude ){
                         $this->data['mercadopago2_methods'][] = $exclude;     
                }   
                //    var_dump($this->data['mercadopago2_methods']);die;
                    
			// $this->data['mercadopago2_methods'] = $this->config->get('mercadopago2_methods');
		}
                
                if (isset($this->request->post['mercadopago2_country'])) {
			$this->data['mercadopago2_country'] = $this->request->post['mercadopago2_country'];
		} else {
			$this->data['mercadopago2_country'] = $this->config->get('mercadopago2_country');
		}
                
                
                if (isset($this->request->post['mercadopago2_installments'])) {
			$this->data['mercadopago2_installments'] = $this->request->post['mercadopago2_installments'];
		} else {
			$this->data['mercadopago2_installments'] = $this->config->get('mercadopago2_installments');
		}

		if (isset($this->request->post['mercadopago2_order_status_id'])) {
			$this->data['mercadopago2_order_status_id'] = $this->request->post['mercadopago2_order_status_id'];
		} else {
			$this->data['mercadopago2_order_status_id'] = $this->config->get('mercadopago2_order_status_id');
		}

		if (isset($this->request->post['mercadopago2_sort_order'])) {
			$this->data['mercadopago2_sort_order'] = $this->request->post['mercadopago2_sort_order'];
		} else {
			$this->data['mercadopago2_sort_order'] = $this->config->get('mercadopago2_sort_order');
		}
		if (isset($this->request->post['mercadopago2_order_status_id_completed'])) {
			$this->data['mercadopago2_order_status_id_completed'] = $this->request->post['mercadopago2_order_status_id_completed'];
		} else {
			$this->data['mercadopago2_order_status_id_completed'] = $this->config->get('mercadopago2_order_status_id_completed');
		}

		if (isset($this->request->post['mercadopago2_order_status_id_pending'])) {
			$this->data['mercadopago2_order_status_id_pending'] = $this->request->post['mercadopago2_order_status_id_pending'];
		} else {
			$this->data['mercadopago2_order_status_id_pending'] = $this->config->get('mercadopago2_order_status_id_pending');
		}

		if (isset($this->request->post['mercadopago2_order_status_id_canceled'])) {
			$this->data['mercadopago2_order_status_id_canceled'] = $this->request->post['mercadopago2_order_status_id_canceled'];
		} else {
			$this->data['mercadopago2_order_status_id_canceled'] = $this->config->get('mercadopago2_order_status_id_canceled');
		}
                if (isset($this->request->post['mercadopago2_order_status_id_in_process'])) {
			$this->data['mercadopago2_order_status_id_in_process'] = $this->request->post['mercadopago2_order_status_id_in_process'];
		} else {
			$this->data['mercadopago2_order_status_id_in_process'] = $this->config->get('mercadopago2_order_status_id_in_process');
		}
                if (isset($this->request->post['mercadopago2_order_status_id_rejected'])) {
			$this->data['mercadopago2_order_status_id_rejected'] = $this->request->post['mercadopago2_order_status_id_rejected'];
		} else {
			$this->data['mercadopago2_order_status_id_rejected'] = $this->config->get('mercadopago2_order_status_id_rejected');
		}
                if (isset($this->request->post['mercadopago2_order_status_id_refunded'])) {
			$this->data['mercadopago2_order_status_id_refunded'] = $this->request->post['mercadopago2_order_status_id_refunded'];
		} else {
			$this->data['mercadopago2_order_status_id_refunded'] = $this->config->get('mercadopago2_order_status_id_refunded');
		}
                if (isset($this->request->post['mercadopago2_order_status_id_in_mediation'])) {
			$this->data['mercadopago2_order_status_id_in_mediation'] = $this->request->post['mercadopago2_order_status_id_in_mediation'];
		} else {
			$this->data['mercadopago2_order_status_id_in_mediation'] = $this->config->get('mercadopago2_order_status_id_in_mediation');
		}
		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->template = 'payment/mercadopago2.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function getCountries() {
            
                $url = 'https://api.mercadolibre.com/sites/';
                $countries = $this->callJson($url);
		
   		return $countries;
	}
        
        private function getMethods($country_id) {
            
            $url = "https://api.mercadolibre.com/sites/" . $country_id .  "/payment_methods";
   
            $methods = $this->callJson($url);
            return $methods;
          }
       
       private function callJson($url,$posts = null){

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//returns the transference value like a string
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/x-www-form-urlencoded'));//sets the header
            curl_setopt($ch, CURLOPT_URL, $url); //oauth API
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            if (isset($posts)){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $posts);
            }
            $jsonresult = curl_exec($ch);//execute the conection
            curl_close($ch);
            $result = json_decode($jsonresult,true);
            return  $result;          
       }
	
        
        private function getInstallments (){	
            
                $installments = array();
                
                $installments[] = array(
                    'value' => 'maximum',
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
                    'value' => '9',
                    'id' => '9');
                   
                $installments[] = array(
                    'value' => '6',
                    'id' => '6');
                   
                 $installments[] = array(
                    'value' => '3',
                    'id' => '3');
                   
                 $installments[] = array(
                    'value' => '1',
                    'id' => '1');
            
                 return $installments;
              }
                
                   

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/mercadopago2')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['mercadopago2_client_id']) {
			$this->error['error_client_id'] = $this->language->get('error_client_id');
		}

		if (!$this->request->post['mercadopago2_client_secret']) {
			$this->error['error_client_secret'] = $this->language->get('error_client_secret');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>