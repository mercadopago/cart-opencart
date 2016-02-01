<?php


include_once "mercadopago.php";

class ControllerPaymentMercadopago2 extends Controller {

	private $error;
	public  $sucess = true;
	private $order_info;
	private $message;

	public function index() {

		$data['button_confirm'] = $this->language->get('button_confirm');
		$data['button_back'] = $this->language->get('button_back');
		$data['terms'] = 'Teste de termos';
        $data['public_key'] =  $this->config->get('mercadopago2_public_key');

		if ($this->config->get('mercadopago2_country')) {
			$data['action'] = $this->config->get('mercadopago2_country');
		}

		$this->load->model('checkout/order');

		$this->language->load('payment/mercadopago2');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

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
			default:
			$currency = 'USD';
			break;
		}



		$currencies = array('ARS','BRL','MEX','CHI','VEF');
		if (!in_array($currency, $currencies)) {
			$currency = '';
			$data['error'] = $this->language->get('currency_no_support');
		}
/*CHAVES do array de produto
cart_id, product_id, name, model, shipping, image, option, download, quantity, minimum, subtract, stock, price, 
total, reward, points, tax_class_id, weight, weight_class_id, length, width, height, length_class_id, recurring
*/

$totalprice = $order_info['total'] * $order_info['currency_value']; 
$products = '';
$all_products = $this->cart->getProducts();
$items = array();
foreach ($all_products as $product) {
	$products .= $product['quantity'] . ' x ' . $product['name'] . ', ';
	$items[] = array(
		"id" => $product['product_id'],
		"title" => $product['name'],
		    "description" => $product['quantity'] . ' x ' . $product['name'], // string
		    "quantity" => intval($product['quantity']),
		    "unit_price" => round(floatval($product['price']), 2), //decimal
		    "currency_id" => $currency ,// string Argentina: ARS (peso argentino) � USD (D�lar estadounidense); Brasil: BRL (Real).,
		    "picture_url"=> HTTP_SERVER . 'image/' . $product['image'],
		    "category_id"=> $this->config->get('mercadopago2_category_id')
		    );
}


		//$firstproduct = reset($allproducts);

                // dados 2.0


$this->id = 'payment';

$data['server'] = $_SERVER;
$data['debug'] = $this->config->get('mercadopago2_debug');

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
		"street_number" => "-",
		),
    "cost" => round(floatval($this->session->data['shipping_method']['cost']), 2),
    "mode" => "custom"
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


/*
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
*/
		//excludes_payment_methods

$exclude = $this->config->get('mercadopago2_methods');
$installments = (int)$installments;
    if($exclude != '')
    {
        $country_id = $this->config->get('mercadopago2_country') == null? 'MLA': $this->config->get('mercadopago2_country');
        $accepted_methods = preg_split("/[\s,]+/", $exclude);
        $all_payment_methods = $this->getMethods($country_id);
        $excluded_payments = array();
        
        foreach ($all_payment_methods as $method) {
        	if(!in_array($method['id'], $accepted_methods) && $method['id'] != 'account_money')
        	{
        	   $excluded_payments[] = array('id' => $method['id']);  
        	}
        }
        
        $payment_methods = array(
        	"installments" => $installments,
        	"excluded_payment_methods" => $excluded_payments
        	);
    }
    else
    {
    		    //case not exist exclude methods
    	$payment_methods = array("installments" => $installments);
    }


		//set back url
$back_urls = array(
	"pending" => $url . '/index.php?route=payment/mercadopago2/callback',
	"success" => $url . '/index.php?route=payment/mercadopago2/callback'
	);
if ($this->config->get('mercadopago2_type_checkout') != 'Transparente') {
    $pref = array();
    $pref['external_reference'] = $order_info['order_id'];
    $pref['payer'] = $payer;
    $pref['shipments'] = $shipments;
    $pref['items'] = $items;
    $pref['back_urls'] = $back_urls;
    $pref['payment_methods'] = $payment_methods;

    $pref['auto_return'] = $this->config->get('mercadopago2_enable_return');
 
    $mp = new MP ($client_id, $client_secret);
    $preferenceResult = $mp->create_preference($pref);
    //$sandbox = $this->config->get('mercadopago2_sandbox') == 1 ? true:false;
    $sandbox = (bool)$this->config->get('mercadopago2_sandbox');
    if($preferenceResult['status'] == 201):
        $data['type_checkout'] = $this->config->get('mercadopago2_type_checkout');
    if ($sandbox):
        $data['redirect_link'] = $preferenceResult['response']['sandbox_init_point'];
    else:
        $data['redirect_link'] = $preferenceResult['response']['init_point'];
    endif;
    else:
        $data['error'] = "Error: " . $preferenceResult['status'];
    endif;
}
else
{
    $data['type_checkout'] = 'Transparente';
}
			//botão deve ser exibido aqui
if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/mercadopago2.tpl')) 
{
	return $this->load->view($this->config->get('config_template') . '/template/payment/mercadopago2.tpl', $data);
} 
else 
{
	return $this->load->view('default/template/payment/mercadopago2.tpl', $data);
}   


}

public function getPaymentDataByLanguage()
{
    //TODO: Pegar o email do usuário neste método também.
    $this->language->load('payment/mercadopago2');
    $payment_data = array();
    $payment_data['ccnum_placeholder'] = $this->language->get('ccnum_placeholder');
    $payment_data['expiration_month_placeholder'] = $this->language->get('expiration_month_placeholder');
    $payment_data['expiration_year_placeholder'] = $this->language->get('expiration_year_placeholder');
    $payment_data['name_placeholder'] = $this->language->get('name_placeholder');
    $payment_data['doctype_placeholder'] = $this->language->get('doctype_placeholder');
    $payment_data['docnumber_placeholder'] = $this->language->get('docnumber_placeholder');
    echo json_encode($payment_data);
}


public function payment()
{
    try 
    {
        $exclude = $this->config->get('mercadopago2_methods');
        $accepted_methods = preg_split("/[\s,]+/", $exclude);
        $payment_method_id = $this->request->post['payment_method_id'];

        if (!in_array($payment_method_id, $accepted_methods)) 
        {
            echo json_encode(array("status" => 400, "message" => $this->language->get('error_invalid_payment_type')));
        }

        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        
        $all_products = $this->cart->getProducts();
        $items = array();
        foreach ($all_products as $product) 
        {
            $items[] = array(
                "id" => $product['product_id'],
                "title" => $product['name'],
                    "description" => $product['quantity'] . ' x ' . $product['name'], // string
                    "quantity" => intval($product['quantity']),
                    "unit_price" => round(floatval($product['price']), 2), //decimal
                    "currency_id" => $order_info['currency_code'],
                    "picture_url"=> HTTP_SERVER . 'image/' . $product['image'],
                    "category_id"=> $this->config->get('mercadopago2_category_id')
                    );
        }
        $payer = array(
            "email" => $order_info['email'],
            "identification" => array(
                "number" => "null",
                "type" => "null"
                )
            );
        $value = floatval($order_info['total']);
        $pref['payer'] = $payer;
        $pref['items'] = $items;
        $access_token = $this->config->get('mercadopago2_access_token');
        $mp = new MP($access_token);
        $payment_data = array( "payer" => $payer,
        "external_reference" => $order_info['order_id'],
        "transaction_amount" => $value,
        "token" => $this->request->post['token'],
        "description" => 'Products',//$this->request->post['description'],
        "installments" => 1,
        "payment_method_id" => $this->request->post['payment_method_id']);
    //TODO: Configurar de-para dos  status codes nos arquivos de idiomas
        $payment_json = json_encode($payment_data);
        $payment = $mp->create_payment($payment_json);
        echo json_encode(array("status"=> $payment['status'],"message"=> $payment['response']['status']));
        //json_encode($payment);    
    } 
    catch (Exception $e) 
    {
        echo json_encode(array("status"=> $e->getCode(),"message"=> $e->getMessage()));
    }
   
}

    private function getMethods($country_id) 
    {
        $url = "https://api.mercadolibre.com/sites/" . $country_id .  "/payment_methods";
        $methods = $this->callJson($url);
        return $methods;
    }

private function callJson($url,$posts = null)
{

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
    $result = json_decode($jsonresult, true);
    return  $result;          
}

            public function callback() {
            	//$this->retorno();
            	$this->response->redirect($this->url->link('checkout/success'));

            }

            public function notifications()
            {
            	if($this->request->get['topic'] == 'payment')
            	{
            		$this->request->get['collection_id'] = $this->request->get['id'];
            		$this->retorno();
            		echo json_encode(200);
            	}
            	else
            	{
            		error_log('merchant_order_notification');
            	}

            }

            public function retorno() {
		           	if (isset($this->request->get['collection_id'])) {
            		$ids = explode(',', $this->request->get['collection_id']);
            		$client_id     = $this->config->get('mercadopago2_client_id');
            		$client_secret = $this->config->get('mercadopago2_client_secret');
            		$sandbox = $this->config->get('mercadopago2_sandbox') == 1 ? true:null;
            		$mp = new MP ($client_id, $client_secret);
            		$mp->sandbox_mode($sandbox);

            		foreach ($ids as $id) {
            			$resposta = $mp->get_payment_info($id);
            			$dados = $resposta['response'];

            			$order_id = $dados['collection']['external_reference'];
            			$order_status = $dados['collection']['status'];

            			$this->load->model('checkout/order');
            			$order = $this->model_checkout_order->getOrder($order_id);

            			if ($order['order_status_id'] == '0') 
            			{
            				$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mercadopago_order_status_id'));
            			}

            			switch ($order_status) {
            				case 'approved':
            				$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mercadopago2_order_status_id_completed'), date('d/m/Y h:i') . ' - ' . $dados['collection']['payment_method_id'] . ' - ' . $dados['collection']['net_received_amount']);
            				break;
            				case 'pending':
            				$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mercadopago2_order_status_id_pending'), date('d/m/Y h:i') . ' - ' . $dados['collection']['payment_method_id'] . ' - ' . $dados['collection']['net_received_amount']);
            				break;    
            				case 'in_process':
            				$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mercadopago2_order_status_id_process'), date('d/m/Y h:i') . ' - ' . $dados['collection']['payment_method_id'] . ' - ' . $dados['collection']['net_received_amount']);    
            				break;    
            				case 'reject':
            				$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mercadopago2_order_status_id_rejected'), date('d/m/Y h:i') . ' - ' . $dados['collection']['payment_method_id'] . ' - ' . $dados['collection']['net_received_amount']);  
            				break;    
            				case 'refunded':
            				$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mercadopago2_order_status_id_refunded'), date('d/m/Y h:i') . ' - ' . $dados['collection']['payment_method_id'] . ' - ' . $dados['collection']['net_received_amount']);
            				break;    
            				case 'cancelled':
            				$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mercadopago2_order_status_id_cancelled'), date('d/m/Y h:i') . ' - ' . $dados['collection']['payment_method_id'] . ' - ' . $dados['collection']['net_received_amount']);
            				break;    
            				case 'in_metiation':
            				$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mercadopago2_order_status_id_in_mediation'), date('d/m/Y h:i') . ' - ' . $dados['collection']['payment_method_id'] . ' - ' . $dados['collection']['net_received_amount']);
            				break;
            				default:
            				$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('mercadopago2_order_status_id_pending'), date('d/m/Y h:i') . ' - ' . $dados['collection']['payment_method_id'] . ' - ' . $dados['collection']['net_received_amount']);
            				break;
            			}
            			echo "ID: " . $id . " - Status: " . $order_status;

            		}
            	}
            	else{
            		error_log('id não setado na compra!!!');
            	}

            }
        }
        ?>
