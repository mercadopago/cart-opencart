<?php

require_once "mercadopago.php";

class MPOpencartUtil {

	//$GLOBALS["LIB_LOCATION"] = dirname(__FILE__);

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

    /*public static function logArchiveError($msg, $exceptionMessage) {
        $date = date('d.m.Y h:i:s');
        $log = "Date:  ".$date."  | ".$msg.
        "|  Exception:  " . $exceptionMessage . "\n";
        error_log($log, 3, $GLOBALS["LIB_LOCATION"]  . '/modules/mercadopago/logs/mercadopago.log');
    }*/

}