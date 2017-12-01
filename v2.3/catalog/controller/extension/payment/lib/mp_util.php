<?php

class MPOpencartUtil {

	private $plataformVersion = "2.3";
	private $moduleVersion = "3.0";

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
	    "refunded" => "refunded",
	    "cancelled" => "cancelled",
		"in_mediation" => " - "
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

	public function updateOrder($payment, $model, $config) {

		try {
			$result_order_status = $this->mp_order_status[$payment['response']['status']];

			$model->addOrderHistory($payment['response']['external_reference'], $config->get('mp_transparente_order_status_id_'. 
				$result_order_status), date('d/m/Y h:i') . ' - ' . $payment['response']['payment_method_id'] . ' - ' . $payment['response']['transaction_details']['net_received_amount'] . ' - Payment ID:' . $payment['response']['id']);

		} catch (Exception $e) {
			error_log("error for updateOrder - ".$e);
		}
	}

	public function getCountries($mp) {
		$result = $mp->get("/sites/", null, false);
		return $result['response'];
	}

	public function setSettings($mp, $config_email, $statusCustom = false,  $custom_cupom = false, $checkout_basic = false) {

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

        if ($custom_cupom)
        	$request['checkout_basic'] = $checkout_basic;

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

	public function getCategoryList($mp) {
		$uri = "/item_categories";
		$category = $mp->get($uri, null, false);

		return $category['response'];
	}

}