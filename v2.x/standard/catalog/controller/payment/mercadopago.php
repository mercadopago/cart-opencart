<?php

/**
 * MercadoPago Integration Library
 * Access MercadoPago for payments integration
 * 
 * @author hcasatti
 *
 */

class MP {

    const version = "0.3.3";

    private $client_id;
    private $client_secret;
    private $ll_access_token;
    private $access_data;
    private $sandbox = FALSE;

    function __construct() {
        $i = func_num_args(); 

        if ($i > 2 || $i < 1) {
            throw new Exception("Invalid arguments. Use CLIENT_ID and CLIENT SECRET, or ACCESS_TOKEN");
        }

        if ($i == 1) {
            $this->ll_access_token = func_get_arg(0);
        }

        if ($i == 2) {
            $this->client_id = func_get_arg(0);
            $this->client_secret = func_get_arg(1);
        }
    }

    public function sandbox_mode($enable = NULL) {
        if (!is_null($enable)) {
            $this->sandbox = $enable === TRUE;
        }

        return $this->sandbox;
    }

    /**
     * Get Access Token for API use
     */
    public function get_access_token() {
        if (isset ($this->ll_access_token) && !is_null($this->ll_access_token)) {
            return $this->ll_access_token;
        }

        $app_client_values = $this->build_query(array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type' => 'client_credentials'
        ));

        $access_data = MPRestClient::post("/oauth/token", $app_client_values, "application/x-www-form-urlencoded");

        if ($access_data["status"] != 200) {
            throw new Exception ($access_data['response']['message'], $access_data['status']);
        }

        $this->access_data = $access_data['response'];

        return $this->access_data['access_token'];
    }

    /**
     * Get information for specific payment
     * @param int $id
     * @return array(json)
     */
    public function get_payment($id) {
        $access_token = $this->get_access_token();
        $uri_prefix = $this->sandbox ? "/sandbox" : "";
        $payment_info = MPRestClient::get($uri_prefix."/collections/notifications/" . $id . "?access_token=" . $access_token);
        return $payment_info;
    }
    public function get_payment_info($id) {
        return $this->get_payment($id);
    }

    /**
     * Get information for specific authorized payment
     * @param id
     * @return array(json)
    */    
    public function get_authorized_payment($id) {
        $access_token = $this->get_access_token();

        $authorized_payment_info = MPRestClient::get("/authorized_payments/" . $id . "?access_token=" . $access_token);
        return $authorized_payment_info;
    }

    /**
     * Refund accredited payment
     * @param int $id
     * @return array(json)
     */
    public function refund_payment($id) {
        $access_token = $this->get_access_token();

        $refund_status = array(
            "status" => "refunded"
        );

        $response = MPRestClient::put("/collections/" . $id . "?access_token=" . $access_token, $refund_status);
        return $response;
    }

    /**
     * Cancel pending payment
     * @param int $id
     * @return array(json)
     */
    public function cancel_payment($id) {
        $access_token = $this->get_access_token();

        $cancel_status = array(
            "status" => "cancelled"
        );

        $response = MPRestClient::put("/collections/" . $id . "?access_token=" . $access_token, $cancel_status);
        return $response;
    }

    /**
     * Cancel preapproval payment
     * @param int $id
     * @return array(json)
     */
    public function cancel_preapproval_payment($id) {
        $access_token = $this->get_access_token();

        $cancel_status = array(
            "status" => "cancelled"
        );

        $response = MPRestClient::put("/preapproval/" . $id . "?access_token=" . $access_token, $cancel_status);
        return $response;
    }

    /**
     * Search payments according to filters, with pagination
     * @param array $filters
     * @param int $offset
     * @param int $limit
     * @return array(json)
     */
    public function search_payment($filters, $offset = 0, $limit = 0) {
        $access_token = $this->get_access_token();

        $filters["offset"] = $offset;
        $filters["limit"] = $limit;

        $filters = $this->build_query($filters);

        $uri_prefix = $this->sandbox ? "/sandbox" : "";
            
        $collection_result = MPRestClient::get($uri_prefix."/collections/search?" . $filters . "&access_token=" . $access_token);
        return $collection_result;
    }

    /**
     * Create a checkout preference
     * @param array $preference
     * @return array(json)
     */
    public function create_preference($preference) {
        $access_token = $this->get_access_token();
        $header = "application/json;X-Tracking-Id: platform: openplatform,so:1.0,type:OpenCart2Standard";
        $preference_result = MPRestClient::post("/checkout/preferences?access_token=" . $access_token, $preference, $header);
        return $preference_result;
    }

    /**
     * Update a checkout preference
     * @param string $id
     * @param array $preference
     * @return array(json)
     */
    public function update_preference($id, $preference) {
        $access_token = $this->get_access_token();

        $preference_result = MPRestClient::put("/checkout/preferences/{$id}?access_token=" . $access_token, $preference);
        return $preference_result;
    }

    /**
     * Get a checkout preference
     * @param string $id
     * @return array(json)
     */
    public function get_preference($id) {
        $access_token = $this->get_access_token();

        $preference_result = MPRestClient::get("/checkout/preferences/{$id}?access_token=" . $access_token);
        return $preference_result;
    }

    /**
     * Create a preapproval payment
     * @param array $preapproval_payment
     * @return array(json)
     */
    public function create_preapproval_payment($preapproval_payment) {
        $access_token = $this->get_access_token();

        $preapproval_payment_result = MPRestClient::post("/preapproval?access_token=" . $access_token, $preapproval_payment);
        return $preapproval_payment_result;
    }    
    /**
     * Create a payment
     * @param array $payment
     * @return array(json)
     */
    public function create_payment($payment) {
        $access_token = $this->get_access_token();
        //$params = is_array ($params) ? $params : array();
        //$params["access_token"] = $access_token;
        $header = "application/json;X-Tracking-Id: platform: openplatform,so:1.0,type:OpenCart2v1";
        $result = MPRestClient::post('/v1/payments?access_token=' . $access_token, $payment, $header);
        //$payment_result = MPRestClient::post("/preapproval?access_token=" . $access_token, $preapproval_payment);
        return $result;
    }

    /**
     * Get a preapproval payment
     * @param string $id
     * @return array(json)
     */
    public function get_preapproval_payment($id) {
        $access_token = $this->get_access_token();

        $preapproval_payment_result = MPRestClient::get("/preapproval/{$id}?access_token=" . $access_token);
        return $preapproval_payment_result;
    }

    /**
     * Update a preapproval payment
     * @param string $preapproval_payment, $id
     * @return array(json)
     */ 
    
    public function update_preapproval_payment($id, $preapproval_payment) {
        $access_token = $this->get_access_token();

        $preapproval_payment_result = MPRestClient::put("/preapproval/" . $id . "?access_token=" . $access_token, $preapproval_payment);
        return $preapproval_payment_result;
    }

    /* Generic resource call methods */

    /**
    * Generic resource get
    * @param uri
    * @param params
    * @param authenticate = true
    */
    public function get($uri, $params = null, $authenticate = true) {
        $params = is_array ($params) ? $params : array();

        if ($authenticate !== false) {
            $access_token = $this->get_access_token();

            $params["access_token"] = $access_token;
        }

        if (count($params) > 0) {
            $uri .= (strpos($uri, "?") === false) ? "?" : "&";
            $uri .= $this->build_query($params);            
        }

        $result = MPRestClient::get($uri);
        return $result;
    }

    /**
    * Generic resource post
    * @param uri
    * @param data
    * @param params
    */
    public function post($uri, $data, $params = null) {
        $params = is_array ($params) ? $params : array();

        $access_token = $this->get_access_token();
        $params["access_token"] = $access_token;

        if (count($params) > 0) {
            $uri .= (strpos($uri, "?") === false) ? "?" : "&";
            $uri .= $this->build_query($params);            
        }
        $result = MPRestClient::post($uri, $data);
        return $result;
    }

    /**
    * Generic resource put
    * @param uri
    * @param data
    * @param params
    */
    public function put($uri, $data, $params = null) {
        $params = is_array ($params) ? $params : array();

        $access_token = $this->get_access_token();
        $params["access_token"] = $access_token;

        if (count($params) > 0) {
            $uri .= (strpos($uri, "?") === false) ? "?" : "&";
            $uri .= $this->build_query($params);            
        }

        $result = MPRestClient::put($uri, $data);
        return $result;
    }

    /**
    * Generic resource delete
    * @param uri
    * @param data
    * @param params
    */
    public function delete($uri, $params = null) {
        $params = is_array ($params) ? $params : array();

        $access_token = $this->get_access_token();
        $params["access_token"] = $access_token;

        if (count($params) > 0) {
            $uri .= (strpos($uri, "?") === false) ? "?" : "&";
            $uri .= $this->build_query($params);
        }

        $result = MPRestClient::delete($uri);
        return $result;
    }

    /**
    * Get Access Token for API use
    */
    public function getAccessToken()
    {
        $app_client_values = $this->build_query(array(
        'client_id' => $this->client_id,
        'client_secret' => $this->client_secret,
        'grant_type' => 'client_credentials'
    ));

        $access_data = MPRestClient::post('/oauth/token', $app_client_values, 'application/x-www-form-urlencoded');
        return $this->access_data['response']['access_token'];
    }


    /* **************************************************************************************** */

    private function build_query($params) {
        if (function_exists("http_build_query")) {
            return http_build_query($params, "", "&");
        } else {
            foreach ($params as $name => $value) {
                $elements[] = "{$name}=" . urlencode($value);
            }

            return implode("&", $elements);
        }
    }

}

/**
 * MercadoPago cURL RestClient
 */
class MPRestClient {

    const API_BASE_URL = "https://api.mercadopago.com";

    private static function get_connect($uri, $method, $content_type) {
        if (!extension_loaded ("curl")) {
            throw new Exception("cURL extension not found. You need to enable cURL in your php.ini or another configuration you have.");
        }

        $connect = curl_init(self::API_BASE_URL . $uri);

        curl_setopt($connect, CURLOPT_USERAGENT, "MercadoPago PHP SDK v" . MP::version);
        curl_setopt($connect, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($connect, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($connect, CURLOPT_HTTPHEADER, array("Accept: application/json", "Content-Type: " . $content_type));

        return $connect;
    }

    private static function set_data(&$connect, $data, $content_type) {
        if (strpos($content_type, 'application/json') !== false) {
            if (gettype($data) == "string") {
                json_decode($data, true);
            } else {
                $data = json_encode($data);
            }

            if(function_exists('json_last_error')) {
                $json_error = json_last_error();
                if ($json_error != JSON_ERROR_NONE) {
                    throw new Exception("JSON Error [{$json_error}] - Data: {$data}");
                }
            }
        }
        curl_setopt($connect, CURLOPT_POSTFIELDS, $data);
    }

    private static function exec($method, $uri, $data, $content_type) {
        $connect = self::get_connect($uri, $method, $content_type);
        if ($data) {
            self::set_data($connect, $data, $content_type);
        }
        $api_result = curl_exec($connect);
        $api_http_code = curl_getinfo($connect, CURLINFO_HTTP_CODE);

        if ($api_result === FALSE) {
            throw new Exception (curl_error ($connect));
        }

        $response = array(
            "status" => $api_http_code,
            "response" => json_decode($api_result, true)
        );

        //var_dump($response);
        if ($response['status'] >= 400) {
            $message = $response['response']['message'];
            if (isset ($response['response']['cause'])) {
                if (isset ($response['response']['cause']['code']) && isset ($response['response']['cause']['description'])) {
                    $message .= " - ".$response['response']['cause']['code'].': '.$response['response']['cause']['description'];
                } else if (is_array ($response['response']['cause'])) {
                    foreach ($response['response']['cause'] as $cause) {
                        $message .= " - ".$cause['code'].': '.$cause['description'];
                    }
                }
            }
            
            throw new Exception ($message, $response['status']);
        }

        curl_close($connect);

        return $response;
    }

    public static function get($uri, $content_type = "application/json") {
        return self::exec("GET", $uri, null, $content_type);
    }

    public static function post($uri, $data, $content_type = "application/json") {
        return self::exec("POST", $uri, $data, $content_type);
    }

    public static function put($uri, $data, $content_type = "application/json") {
        return self::exec("PUT", $uri, $data, $content_type);
    }

    public static function delete($uri, $content_type = "application/json") {
        return self::exec("DELETE", $uri, $null, $content_type);
    }
}
