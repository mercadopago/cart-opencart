<?php

class MPOpencartUtil {

	private $plataformVersion = "3.0";
	private $moduleVersion = "4.1";

	public $sponsors = array(
		'MLB' => 204931135,
		'MLM' => 204962951,
		'MLA' => 204931029,
		'MCO' => 204964815,
		'MLV' => 204964612,
		'MPE' => 217176790,
		'MLC' => 204927454
	);

	public $initials = array(
		'MLB' => "BR",
		'MLM' => "MX",
		'MLA' => "AR",
		'MCO' => "CO",
		'MLV' => "VE",
		'MPE' => "PE",
		'MLC' => "CL",
		'MLU' => "UY"
	);

	private $mp_order_status = [
	    "approved" => "completed",
	    "pending" => "pending",
	    "in_process" => "process",
	    "rejected" => "rejected",
	    "refunded" => "refunded",
	    "cancelled" => "cancelled",
		"in_mediation" => " - "
	];

	private $mp_order_status_id = [
		"completed" => 5,
		"pending" => 1,
		"refunded" => 11,
		"cancelled" => 7,
		"rejected" => 10  
	];

	public function createAnalytics($resultModules, $token, $customerEmail, $userLogged) {

        $return = array(
            'publicKey'=> "",
            'token'=> $token,
            'platform' => "Opencart",
            'platformVersion' => $this->plataformVersion,
            'moduleVersion' => $this->moduleVersion,
            'payerEmail' => $customerEmail,
            'userLogged' => $userLogged,
            'installedModules' => implode(', ', $resultModules),
            'additionalInfo' => ""
        );

        return $return;
    }

	public function updateOrder($payment, $model, $config, $db) {

		try {

			$result_order_status = $this->mp_order_status[$payment['response']['status']];
			$actualize = true;

			if(isset($db) && $db != null) {
				
				$status_id = $this->mp_order_status_id[$result_order_status];
				$sql = "SELECT max(order_history_id) as order_history FROM " . DB_PREFIX . "order_history WHERE order_id = ".$payment['response']['external_reference']. " and order_status_id = ".$status_id;

				$query = $db->query($sql);

				if(isset($query->rows) && $query->rows[0]['order_history'] != null)
					$actualize = false;
			}

			if ($actualize) {
				$model->addOrderHistory($payment['response']['external_reference'], $config->get('payment_mp_'.$payment['pay_type_mp'].'_order_status_id_'. 
					$result_order_status), date('d/m/Y h:i') . ' - ' . $payment['response']['payment_method_id'] . ' - ' . $payment['response']['transaction_details']['net_received_amount'] . ' - Payment ID:' . $payment['response']['id']);
			}

		} catch (Exception $e) {
			error_log("error for updateOrder - ".$e);
		}
	}

	public function getCountries($mp) {
		$result = $mp->get("/sites/", null, false);
		return $result['response'];
	}

	public function getCountryByAccessToken($mp, $access_token) {
				
		if ($access_token != null) {
			$result = $mp->get('/users/me?access_token=' . $access_token);
			return $result['response']['site_id'];
		}

		return null;
	}

	public function setSettings($mp, $config_email, $statusCustom = false,  $custom_cupom = false, $standard = false, $checkout_basic = false) {

        $request = array(
            "module_version" => $this->moduleVersion,
            "code_version" => phpversion(),
            "platform" => "OpenCart",
            "platform_version" => $this->plataformVersion
        );

        if($statusCustom)
        	$request['checkout_custom_credit_card'] = $statusCustom;

        if ($custom_cupom)
        	$request['checkout_custom_credit_card_coupon'] = $custom_cupom;

        if ($standard)
        	$request['checkout_basic'] = $standard;

		if ($checkout_basic)
        	$request['checkout_custom_ticket'] = $checkout_basic;

        

    }

	public function getInstallments() {
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

	public function verifySponsorIsValid($mp, $country_id, $input_sponsor){
		
		if (!empty($input_sponsor)) {
			
			$user_info = $mp->getUserInfo($input_sponsor);
			 
			 if(!isset($user_info['site_id']) ||
                $user_info['site_id'] != $country_id ||
                $user_info['status']['site_status'] != "active") {
				return false;
			 }
		}
		return true;
	}

	public function getCategoryList($mp) {
		$uri = "/item_categories";
		$category = $mp->get($uri, null, false);

		return $category['response'];
	}

	public function getMethods( $country_id, $mp ) {
		$uri = '/sites/' . $country_id . '/payment_methods';
		$methods = $mp->get( $uri, null, false );
		return $methods['response'];
	}

  	public function getModuleVersion(){
    	return $this->moduleVersion;
  	}
}