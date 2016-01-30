<?php

include_once '../catalog/controller/payment/mercadopago.php';

    class ControllerPaymentMercadopago2 extends Controller {
    	private $error = array();
        
    	public function index() {
            $prefix = 'mercadopago2_';
            $fields = array('public_key', 'access_token', 'client_id', 'client_secret', 'status', 'category_id', 'url', 'debug', 'sandbox', 'type_checkout',// 'methods',
                    'country', 'installments', 'order_status_id', 'sort_order', 'order_status_id_completed', 'order_status_id_pending', 'order_status_id_canceled',
                    'order_status_id_in_process', 'order_status_id_rejected', 'order_status_id_refunded', 'order_status_id_in_mediation'); 

    		$this->load->language('payment/mercadopago2');

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
            $data['entry_autoreturn_tooltip'] = $this->language->get('entry_autoreturn_tooltip'); 
            $data['entry_public_key_tooltip'] = $this->language->get('entry_public_key_tooltip'); 
            $data['entry_access_token_tooltip'] = $this->language->get('entry_access_token_tooltip'); 
    		$data['entry_client_id_tooltip'] = $this->language->get('entry_client_id_tooltip');	
    		$data['entry_client_secret_tooltip'] = $this->language->get('entry_client_secret_tooltip');
    		$data['entry_url_tooltip'] = $this->language->get('entry_url_tooltip');
    		$data['entry_payments_not_accept_tooltip'] = $this->language->get('entry_payments_not_accept_tooltip');
    		$data['entry_debug_tooltip'] = $this->language->get('entry_debug_tooltip');
    		$data['entry_sandbox_tooltip'] = $this->language->get('entry_sandbox_tooltip');
    		$data['entry_category_tooltip'] = $this->language->get('entry_category_tooltip');
    		$data['entry_order_status_tooltip'] = $this->language->get('entry_order_status_tooltip');
    		$data['entry_order_status_completed_tooltip'] = $this->language->get('entry_order_status_completed_tooltip');
    		$data['entry_order_status_pending_tooltip'] = $this->language->get('entry_order_status_pending_tooltip');
    		$data['entry_order_status_canceled_tooltip'] = $this->language->get('entry_order_status_canceled_tooltip');
    		$data['entry_order_status_in_process_tooltip'] = $this->language->get('entry_order_status_in_process_tooltip');
    		$data['entry_order_status_rejected_tooltip'] = $this->language->get('entry_order_status_rejected_tooltip');
    		$data['entry_order_status_refunded_tooltip'] = $this->language->get('entry_order_status_refunded_tooltip');
            $data['entry_order_status_in_mediation_tooltip'] = $this->language->get('entry_order_status_in_mediation_tooltip');
    		$data['entry_notification_url_tooltip'] = $this->language->get('entry_notification_url_tooltip');
    		//end tooltips
            $data['entry_public_key'] = $this->language->get('entry_public_key'); 
            $data['entry_access_token'] = $this->language->get('entry_access_token'); 
            $data['entry_notification_url'] = $this->language->get('entry_notification_url');
            $data['entry_autoreturn'] = $this->language->get('entry_autoreturn');
    		$data['entry_client_id'] = $this->language->get('entry_client_id');
    		$data['entry_client_secret'] = $this->language->get('entry_client_secret');
            $data['entry_installments'] = $this->language->get('entry_installments');
            $data['entry_payments_not_accept'] = $this->language->get('entry_payments_not_accept');
            $data['entry_status'] = $this->language->get('entry_status');
    		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
    		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
    		$data['entry_country'] = $this->language->get('entry_country');
    		$data['entry_sonda_key'] = $this->language->get('entry_sonda_key');
    		$data['entry_order_status'] = $this->language->get('entry_order_status');
    		$data['entry_ipn_status'] = $this->language->get('entry_ipn_status');
                    $data['entry_url'] = $this->language->get('entry_url');
                    $data['entry_debug'] = $this->language->get('entry_debug');
    		
    		$data['entry_sandbox'] = $this->language->get('entry_sandbox');
    		$data['entry_type_checkout'] = $this->language->get('entry_type_checkout');
    		$data['entry_category'] = $this->language->get('entry_category');
    		
            $data['entry_ipn'] = $this->language->get('text_ipn');
            $data['entry_order_status_general'] = $this->language->get('entry_order_status_general');
    		$data['entry_order_status_completed'] = $this->language->get('entry_order_status_completed');
    		$data['entry_order_status_pending'] = $this->language->get('entry_order_status_pending');
    		$data['entry_order_status_canceled'] = $this->language->get('entry_order_status_canceled');
            $data['entry_order_status_in_process'] = $this->language->get('entry_order_status_in_process');
    		$data['entry_order_status_rejected'] = $this->language->get('entry_order_status_rejected');
    		$data['entry_order_status_refunded'] = $this->language->get('entry_order_status_refunded');
            $data['entry_order_status_in_mediation'] = $this->language->get('entry_order_status_in_mediation');
                    
    		$data['button_save'] = $this->language->get('button_save');
    		$data['button_cancel'] = $this->language->get('button_cancel');

    		$data['tab_general'] = $this->language->get('tab_general');
            
            $data['mercadopago2_enable_return'] = isset($this->request->post['mercadopago2_enable_return']) ? 
            $this->request->post['mercadopago2_enable_return']: $this->config->get('mercadopago2_enable_return');
                  
            $data['error_warning'] = isset($this->error['warning'])? $this->error['warning'] : '';
     		$data['error_acc_id'] = isset($this->error['acc_id']) ? $this->error['acc_id'] : '';
            $data['error_token'] = isset($this->error['token'])? $this->error['token'] : '';
     		$data['breadcrumbs'] = array();

    		$data['breadcrumbs'][] = array(
    			'text' => $this->language->get('text_home'),
    			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
    		);
 
    		$data['breadcrumbs'][] = array(
    			'text' => $this->language->get('text_payment'),
    			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
    		);

    		$data['breadcrumbs'][] = array(
    			'text' => $this->language->get('heading_title'),
    			'href' => $this->url->link('payment/mercadopago2', 'token=' . $this->session->data['token'], 'SSL')
    		);
    		$data['action'] = HTTPS_SERVER . 'index.php?route=payment/mercadopago2&token=' . $this->session->data['token'];
    		$data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'];
            $data['category_list'] = $this->getCategoryList();
            $data['type_checkout'] = $this->getTypeCheckout();
            $data['countries'] = $this->getCountries();
            $data['installments'] = $this->getInstallments();
            $data['header'] = $this->load->controller('common/header');
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['footer'] = $this->load->controller('common/footer');
            $this->load->model('localisation/order_status');
            $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
            
            if($_SERVER['REQUEST_METHOD'] == "POST")
            {
                foreach ($fields as $field) 
                {
                    $fieldname = $prefix . $field;
                    $data[$fieldname] = $this->request->post[$fieldname];
                }
                
            }
            else
            {
                foreach ($fields as $field) 
                {
                    $fieldname = $prefix . $field;
                    $value = $this->config->get($fieldname);
                    $data[$fieldname] =  $value;
                }
            }
           $country_id = $this->config->get('mercadopago2_country') == null? 
                              'MLA': $this->config->get('mercadopago2_country');  
            $methods_api = $this->getMethods($country_id);
            $data['mercadopago2_methods'] = preg_split("/[\s,]+/", $this->config->get('mercadopago2_methods')); 
            foreach ($methods_api as $method) 
            {
                $data['methods'][] = $method;             
            }
            
            $data['payment_style'] = count($data['methods']) > 12? "float:left; margin-left:2%": "float:left; margin-left:5%";
            
    		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
               $this->load->model('setting/setting');
                            
                            if(isset($this->request->post['mercadopago2_methods'])){
                                error_log('mp2_methods');
                                error_log(json_encode($this->request->post['mercadopago2_methods']));
                                $names = $this->request->post['mercadopago2_methods'];
                                $this->request->post['mercadopago2_methods'] = '';
                                foreach ($names as $name){
                                    $this->request->post['mercadopago2_methods'] .= $name.',';
                                }            
                            }
               $this->model_setting_setting->editSetting('mercadopago2', $this->request->post);

    			$this->session->data['success'] = $this->language->get('text_success');
    			$this->response->redirect(HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token']);
    			
    		}
            
            $this->response->setOutput($this->load->view('payment/mercadopago2.tpl', $data));	

    	}


        public function getPaymentMethodsByCountry()
        {
            $country_id = $this->request->get['country_id'];
            $data['methods'] = $this->getMethods($country_id);
            $methods_excludes = preg_split("/[\s,]+/",$this->config->get('mercadopago2_methods')); 
            foreach ($methods_excludes as $exclude )
            {
                $data['mercadopago2_methods'][] = $exclude;
            }

            if(isset($data['methods']))
            {
                $data['payment_style'] = count($data['methods']) > 12? "float:left; margin-left:7%": "float:left; margin-left:5%";
                $this->response->setOutput($this->load->view('payment/mercadopago2_payment_methods_partial.tpl', $data));   
            }                
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
                if (isset($posts))
                {
    		      curl_setopt($ch, CURLOPT_POSTFIELDS, $posts);
                }
                $jsonresult = curl_exec($ch);//execute the conection
                curl_close($ch);
                $result = json_decode($jsonresult,true);
                return  $result;          
           }
    	
            private function getCategoryList(){
    		$url = "https://api.mercadolibre.com/item_categories";
    		$category = $this->callJson($url);
    		return $category;
    	}
    	
    	private function getTypeCheckout(){
    		
            //$type_checkout = array("Redirect","Lightbox", "Iframe", "Transparente");
    		$type_checkout = array("Redirect","Lightbox", "Iframe");
    		
    		return $type_checkout;
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
            if ($this->request->post['mercadopago2_ch']) {
                # code...
            }
    		if (!$this->request->post['mercadopago2_client_id']) {
            	$this->error['error_client_id'] = $this->language->get('error_client_id');
    		}

    		if (!$this->request->post['mercadopago2_client_secret']) {
            	$this->error['error_client_secret'] = $this->language->get('error_client_secret');
    		}
         
            return count($this->error) < 1;
    		
    	}
    }
?>