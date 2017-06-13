<?php


include_once "mercadopago.php";

class ControllerPaymentMercadopago2 extends Controller {

	private $error;
        public  $sucess = true;
	private $order_info;
        private $message;

	protected function index() {

                $this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');
                    
		if ($this->config->get('mercadopago2_country')) {
		    $this->data['action'] = $this->config->get('mercadopago2_country');
		}

		$this->load->model('checkout/order');

		$this->language->load('payment/mercadopago2');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
	
                $this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('mercadopago2_order_status_id'));
                
		//Cambio el código ISO-3 de la moneda por el que se les ocurrio poner a los de mercadopago2!!!
		                            
               switch($order_info['currency_code']) {
			case"ARS":
				$currency = 'ARS';
				break;
                        case"ARG":
				$currency = 'ARS';
				break;    
                        case"VEF":
				$currency = 'VEF';
				break;  
                        case"BRA":
			case"BRL":
                        case"REA":
				$currency = 'BRL';
				break;
			case"MXN":
				$currency = 'MEX';
				break;
			case"CLP":
				$currency = 'CHI';
				break;
			case"UYU":
				$currency = 'UYU';
				break;
			default:
				$currency = 'USD';
				break;
		}
                
                 
            
		$currencies = array('ARS','BRL','MEX','CHI','VEF', 'UYU');
		if (!in_array($currency, $currencies)) {
			$currency = '';
			$this->data['error'] = $this->language->get('currency_no_support');
		}

		$products = '';
		
		foreach ($this->cart->getProducts() as $product) {
			$products .= $product['quantity'] . ' x ' . $product['name'] . ', ';
                }
                $allproducts = $this->cart->getProducts();
                $firstproduct = reset($allproducts);
                
                // dados 2.0
                
                $totalprice = $order_info['total'] * $order_info['currency_value'];                   
            
              	$this->id = 'payment';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/mercadopago2.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/mercadopago2.tpl';
		} else {
			$this->template = 'default/template/payment/mercadopago2.tpl';
		}
                
                $this->data['server'] = $_SERVER;
                $this->data['debug'] = $this->config->get('mercadopago2_debug');
                
                // get credentials 
                
                $client_id     = $this->config->get('mercadopago2_client_id');
		$client_secret = $this->config->get('mercadopago2_client_secret');
                $url           = $this->config->get('mercadopago2_url');
                $installments  = (int) $this->config->get('mercadopago2_installments');

               

		$shipments = array(
			"receiver_address" => array(
				"floor" => "-",
				"zip_code" => $order_info['shipping_postcode'],
				"street_name" => $order_info['shipping_address_1'] . " - " . $order_info['shipping_address_2'] . " - " . $order_info['shipping_city'] . " - " . $order_info['shipping_zone'] . " - " . $order_info['shipping_country'],
				"apartment" => "-",
				"street_number" => "-"
			)
		);
		   
		//Force format YYYY-DD-MMTH:i:s
		$cust = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer` WHERE customer_id = " . $order_info['customer_id'] . " ");
		$date_created = "";
		$date_creation_user = "";
		
		if($cust->num_rows > 0):
			
			foreach($cust->rows as $customer):
				$date_created = $customer['date_added'];
			endforeach;
			
			$date_creation_user = date('Y-m-d', strtotime($date_created)) . "T" . date('H:i:s',strtotime($date_created));
		endif;
		
		
		
		
		$payer = array(
		    "name" => $order_info['payment_firstname'],
		    "surname" => $order_info['payment_lastname'],
		    "email" => $order_info['email'],
		    "date_created" => $date_creation_user,
		    "phone" => array(
			"area_code" => "-",
			"number" => $order_info['telephone']
		    ),
		    "address" => array(
			"zip_code" => $order_info['payment_postcode'],
			"street_name" => $order_info['payment_address_1'] . " - " . $order_info['payment_address_2'] . " - " . $order_info['payment_city'] . " - " . $order_info['payment_zone'] . " - " . $order_info['payment_country'],
			"street_number" => "-"
		    ),
		    "identification" => array(
			"number" => "null",
			"type" => "null"
		    )
		);
		

	       
		$items = array(
		    array (
		    "id" => $order_info['order_id'],
		    "title" => $firstproduct['name'],
		    "description" => $firstproduct['quantity'] . ' x ' . $firstproduct['name'], // string
		    "quantity" => 1,
		    "unit_price" => round($totalprice, 2), //decimal
		    "currency_id" => $currency ,// string Argentina: ARS (peso argentino) � USD (D�lar estadounidense); Brasil: BRL (Real).,
		    "picture_url"=> HTTP_SERVER . 'image/' . $firstproduct['image'],
		    "category_id"=> $this->config->get('mercadopago2_category_id')
		    )
		);
		
		//excludes_payment_methods
		$exclude = $this->config->get('mercadopago2_methods');
		$installments = (int)$installments;
		
		if($exclude != ''):
		
		    //case exist exclude methods
		    $methods_excludes = preg_split("/[\s,]+/", $exclude);
		    $excludemethods = array();
		    foreach ($methods_excludes as $exclude ){
			if($exclude != "")
			   $excludemethods[] = array('id' => $exclude);     
		    }
		
		    $payment_methods = array(
			"installments" => $installments,
			"excluded_payment_methods" => $excludemethods
		    );
		else:
		    //case not exist exclude methods
		    $payment_methods = array(
			"installments" => $installments
		    );
		endif;
		
		
		//set back url
		$back_urls = array(
		    "pending" => $url . '/index.php?route=payment/mercadopago2/callback',
		    "success" => $url . '/index.php?route=payment/mercadopago2/callback'
		);

		//mount array pref
		$pref = array();
		$pref['external_reference'] = $order_info['order_id'];
		$pref['payer'] = $payer;
		$pref['shipments'] = $shipments;
		$pref['items'] = $items;
		$pref['back_urls'] = $back_urls;
		$pref['payment_methods'] = $payment_methods;
		    

		$mp = new MP ($client_id, $client_secret);
		$preferenceResult = $mp->create_preference($pref);
		
		
		$sandbox = $this->config->get('mercadopago2_sandbox') == 1 ? true:false;
		if($preferenceResult['status'] == 201):
			$this->data['type_checkout'] = $this->config->get('mercadopago2_type_checkout');
			
			if ($sandbox):
				$this->data['link'] = $preferenceResult['response']['sandbox_init_point'];
			else:
				$this->data['link'] = $preferenceResult['response']['init_point'];
			endif;
		else:
			$this->data['error'] = "Error: " . $preferenceResult['status'];
		endif;
		
		$this->render();
            
       }
     
   

	public function callback() {
	      $this->redirect(HTTP_SERVER . 'index.php?route=checkout/success');
	}
        
	public function retorno() {
		
		
		if (isset($_REQUEST['id'])) {
			$id = $_REQUEST['id'];
			
			
			$client_id     = $this->config->get('mercadopago2_client_id');
			$client_secret = $this->config->get('mercadopago2_client_secret');
			$sandbox = $this->config->get('mercadopago2_sandbox') == 1 ? true:null;
			
			//$checkdata = New Shop($client_id,$client_secret);
			$mp = new MP ($client_id, $client_secret);
			$mp->sandbox_mode($sandbox);
			
			//$dados = $checkdata->GetStatus($id);
			$dados = $mp->get_payment_info ($id);
			$dados = $dados['response'];
			
			$order_id = $dados['collection']['external_reference'];
			$order_status = $dados['collection']['status'];
			
			$this->load->model('checkout/order');
			$order = $this->model_checkout_order->getOrder($order_id);
			
			
			
			if ($order['order_status_id'] == '0') {
				$this->model_checkout_order->confirm($order_id, $this->config->get('mercadopago_order_status_id'));
			}
			
			switch ($order_status) {
				case 'approved':
					$this->model_checkout_order->update($order_id, $this->config->get('mercadopago2_order_status_id_completed'));   
					break;
				case 'pending':
					$this->model_checkout_order->update($order_id, $this->config->get('mercadopago2_order_status_id_pending'));    
					break;    
				case 'in_process':
					$this->model_checkout_order->update($order_id, $this->config->get('mercadopago2_order_status_id_process'));       
					break;    
				case 'rejected':
					$this->model_checkout_order->update($order_id, $this->config->get('mercadopago2_order_status_id_rejected'));      
					break;    
				case 'refunded':
					$this->model_checkout_order->update($order_id, $this->config->get('mercadopago2_order_status_id_refunded'));      
					break;    
				case 'cancelled':
					$this->model_checkout_order->update($order_id, $this->config->get('mercadopago2_order_status_id_cancelled'));      
					break;    
				case 'in_metiation':
					$this->model_checkout_order->update($order_id, $this->config->get('mercadopago2_order_status_id_in_mediation'));    
					break;
				default:
					$this->model_checkout_order->update($order_id, $this->config->get('mercadopago2_order_status_id_pending'));
					break;
			}
			
			echo "ID: " . $id . " - Status: " . $order_status;
		
		}
	
	}
        
      
}



   
?>
