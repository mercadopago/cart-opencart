<?php

require_once "lib/mercadopago.php";

class MPOpencartUtil {

	$mp_order_status = [
	    "approved" => "completed",
	    "pending" => "pending",
	    "in_process" => "process",
	    "rejected" => "rejected",
	    "refunded" => "refunded",
	    "refunded" => "refunded",
	    "cancelled" => "cancelled",
		"in_mediation" => " - "
	];

	public function updateOrder($mp, $order_id, $order_status, $payment_id, $model) {

		try {

			$payment = $mp->getPayment($payment_id);
			$result_order_status = $this->mp_order_status[$order_status];

			$model->addOrderHistory($order_id, $this->config->get('mp_transparente_order_status_id_'. 
				$result_order_status), date('d/m/Y h:i') . ' - ' . $payment['payment_method_id'] . ' - ' . $payment['transaction_details']['net_received_amount'] . ' - Payment ID:' . $payment['payment_id']);

			return $payment;

		} catch (Exception $e) {
			error_log("error for updateOrder - ".$e);
		}
	}
}