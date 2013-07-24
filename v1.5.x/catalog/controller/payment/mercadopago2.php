<?php




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
				$currency = 'BRL';
				break;     
			case"BRL":
				$currency = 'BRL';
				break;
                        case"REA":
				$currency = 'BRL';
				break;
			case"MXN":
				$currency = 'MEX';
				break;
			case"CLP":
				$currency = 'CHI';
				break;
			default:
				$currency = 'USD';
				break;
		}
                
                 
            
		$currencies = array('ARS','BRL','MEX','CHI','VEF');
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
                // urls
                
                // array to create preference key
                          
               $carrinho = array(
               "external_reference" => $order_info['order_id'] ,// seu codigo de referencia, i.e. Numero do pedido da sua loja 
               "currency" => $currency ,// string Argentina: ARS (peso argentino) � USD (D�lar estadounidense); Brasil: BRL (Real).
               "title" => $firstproduct['name'],  //string
               "description" => $firstproduct['quantity'] . ' x ' . $firstproduct['name'], // string
               "quantity" =>  1,// int 
               "image" => HTTP_SERVER . 'image/' . $firstproduct['image'],  // Imagem, string
               "amount" => round($totalprice, 2), //decimal
               "payment_firstname" => $order_info['payment_firstname'],// string
               "payment_lastname" =>  $order_info['payment_lastname'],// string
               "email" =>    $order_info['email'],// string
               "pending" =>   $url   . '/index.php?route=payment/mercadopago2/callback', // string
               "approved" =>  $url   . '/index.php?route=payment/mercadopago2/callback',  // string
               "installments" => (int)$installments
               );

               // methods para excluir
               $exclude = $this->config->get('mercadopago2_methods');  // string
                
               
               $mp = new Shop($client_id,$client_secret);
                       
               if($mp->GetCheckout($carrinho,$exclude) != ''){
                   $this->data['link'] = $mp->GetCheckout($carrinho,$exclude);
               } else {
                   $this->data['error'] = $mp->getError();
               }
                   
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

            $checkdata = New Shop($client_id,$client_secret);

            $dados = $checkdata->GetStatus($id);
            
                                 
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
             case 'reject':
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
             }
           
           }
      
        }
        
      
}

class mercadopago {

    
     
        public     $accesstoken;
        protected  $client_id;
        protected  $client_secret;
        public     $erro;
        protected  $date;
        protected  $expired;


        
       ///// function just to debug the code if is needed
        
        function debug($error){
               $this->erro = $error ;
        }
        
       
       
         ///// function to post the datas
         public function DoPost($fields,$url,$heads,$codeexpect,$type,$method){
                    
                    // buld the post data follwing the api needs
                 if($type == 'json'){
                 $posts = json_encode($fields);
                             

                    } else if ($type == 'none') {
                    $posts = $fields;
                    } else {
                    $posts = http_build_query($fields);    
                    }
                    
                                    
                  
                    // change the curl method follwing the api needs
                    switch ($method):
                    case 'get':
                    $options = array(
                               CURLOPT_RETURNTRANSFER => '1',
                               CURLOPT_HTTPHEADER => $heads,
                               CURLOPT_SSL_VERIFYPEER => 'false',
                               CURLOPT_URL => $url,
                               CURLOPT_POSTFIELDS => $posts ,
                               CURLOPT_CUSTOMREQUEST => "GET"
                            );
                    break;
                    case 'put':
                      $options = array(
                                CURLOPT_RETURNTRANSFER => 1,
                                CURLOPT_HTTPHEADER => $heads,
                                CURLOPT_SSL_VERIFYPEER => 'false',
                                CURLOPT_URL => $url,
                                CURLOPT_POSTFIELDS => $posts,    
                                CURLOPT_CUSTOMREQUEST => "PUT",
                                CURLOPT_HEADER => 1
                             );  
                    break;
                    case 'post':
                         $options = array(
                                CURLOPT_RETURNTRANSFER => '1',
                                CURLOPT_HTTPHEADER => $heads,
                                CURLOPT_SSL_VERIFYPEER => 'false',
                                CURLOPT_URL => $url,
                                CURLOPT_POSTFIELDS => $posts,    
                                CURLOPT_CUSTOMREQUEST => "POST",
                             ); 
                    break;
                    case 'delete':
                        $options = array(
                                CURLOPT_RETURNTRANSFER => '1',
                                CURLOPT_HTTPHEADER => $heads,
                                CURLOPT_SSL_VERIFYPEER => 'false',
                                CURLOPT_URL => $url,
                                CURLOPT_POSTFIELDS => $posts,    
                                CURLOPT_CUSTOMREQUEST => "DELETE",
                             ); 
                        
                    break;      
                    default:
                            $options = array(
                               CURLOPT_RETURNTRANSFER => '1',
                               CURLOPT_HTTPHEADER => $heads,
                               CURLOPT_SSL_VERIFYPEER => 'false',
                               CURLOPT_URL => $url,
                               CURLOPT_POSTFIELDS => $posts ,
                               CURLOPT_CUSTOMREQUEST => "GET"
                            );
                    break;
                    endswitch;
  
                // do a curl call
                $call = curl_init();
                curl_setopt_array($call,$options);
                // execute the curl call
                $dados = curl_exec($call);
                // get the curl statys
                $status = curl_getinfo($call);
                // close the call
                curl_close($call);
                // check to see if the call was succesful 
                if ($status['http_code'] != $codeexpect){
                $this->debug($dados);
                return false;
                } else {
               // change the json retur to a php array and return it
                return json_decode($dados,true);        
                } 
        
        }
        
        public function getAccessToken(){
            
            $data = getdate();
            $time = $data[0];
             
            
            // verifica se j� existe accesstoken valido, caso exista, retorna o accesstoken
            if(isset($this->accesstoken) && isset($this->date)){          
                $timedifference = $time - $this->date;
                if($timedifference < $this->expired){
                return $this->accesstoken;
                }
           }
            // get the clients variables
                $post = array(
                    'client_id' => $this->client_id,
                    'client_secret' => $this->client_secret,
                    'grant_type' => 'client_credentials'
                 );
                // set the header
                $header = array('Accept: application/json','Content-Type: application/x-www-form-urlencoded');
                // set the url to get the access token
                $url = 'https://api.mercadolibre.com/oauth/token';
                // call the post function. expection 200 as return
                $dados = $this->DoPost($post,$url,$header,'200','post','post');
                // set the access token
                if($dados['access_token']){
                $this->accesstoken = $dados['access_token'];
                }
                 // guarta o hoarario, prazo de expira�?o e returna o access token
                $this->date = $time;
                $this->expired = $dados['expires_in'];
                return $dados['access_token'];
       }
     
       
    
}
Class Shop extends MercadoPago {
        
       // do the client authentication
      public function __construct($client,$secret){
                   $this->client_id = $client;
                   $this->client_secret = $secret; 
       }
       
       
       
     public function GetMethods($country_id) {
       
        $url = "https://api.mercadolibre.com/sites/" . $country_id .  "/payment_methods";
        $header = null;   
        $methods = $this->DoPost(null,$url,$header,'200','none','get');
        return $methods;
    
          }

      // Generate the botton
      public function GetCheckout($data,$excludes){
                
            if($excludes != ''){
                
                 $methods_excludes = preg_split("/[\s,]+/", $excludes); 
                 foreach ($methods_excludes as $exclude ){
                 $excludemethods[] = array('id' => $exclude);     
                 }
                
                 
                $opt = array(
                "external_reference" => $data['external_reference'],
                "items" => array(
                    array ("id" => $data['external_reference'], // updated
                    "title" => $data['title'],
                    "description" => $data['quantity'] . ' x ' . $data['title'],
                    "quantity" => 1,
                    "unit_price" => round($data['amount'], 2),
                    "currency_id" => $data['currency'],
                    "picture_url"=> $data['image'],
                    )),
                    "payer" => array(
                     "name" => $data['payment_firstname'],
                     "surname" => $data['payment_lastname'],
                     "email" => $data['email']
                    ),
                   "back_urls" => array(
                   "pending" => $data['pending'],
                   "success" => $data['approved']
                   ),           
                   "payment_methods" => array(
                   "excluded_payment_methods" => $excludemethods,
                   "installments" => (int) $data['installments']    
                   )
                );
            }else{
                $opt = array(
                "external_reference" => $data['external_reference'],
                "items" => array(
                    array ("id" => $data['external_reference'], // updated
                    "title" => $data['title'],
                    "description" => $data['quantity'] . ' x ' . $data['title'],
                    "quantity" => 1,
                    "unit_price" => round($data['amount'], 2),
                    "currency_id" => $data['currency'],
                    "picture_url"=> $data['image'],
                    )),
                    "payer" => array(
                     "name" => $data['payment_firstname'],
                     "surname" => $data['payment_lastname'],
                     "email" => $data['email']
                    ),
                   "back_urls" => array(
                   "pending" => $data['pending'],
                   "success" => $data['approved']
                   ),
                   "payment_methods" => array(
                   "installments" => (int)$data['installments']      
                   )
                );
                
            }
            
             

            $this->getAccessToken(); 
            if(isset($this->accesstoken)){
            $url = 'https://api.mercadolibre.com/checkout/preferences?access_token=' . $this->accesstoken;
            $header = array('Content-Type:application/json', 'User-Agent:MercadoPago OpenCart-1.5.x Cart v1.0.1', 'Accept: application/json');
            $dados = $this->DoPost($opt,$url,$header,'201','json','post');
            if(isset($dados['init_point'])){
            $link = $dados['init_point'];
            return $link;
            }
            return false;
            }
            return false;
      }
      
           

      public function GetStatus($id){
          
            $this->getAccessToken(); 
            $url = "https://api.mercadolibre.com/collections/notifications/" . $id . "?access_token=" . $this->accesstoken;
            $header = array('Accept: application/json', 'Content-Type: application/x-www-form-urlencoded');
            $retorno = $this->DoPost($opt=null,$url,$header,'200','none','post');
            return $retorno;
                   
      }
      
      public function getError(){
          if ($this->erro != '' && $this->erro != null){
             return $this->erro;
          }
      }
      

} 


   
?>
