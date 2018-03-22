<?php

/**
 * This class owns all common static Mercado Pago variables and functions used by Opencart.
 */

class MPOpencartUtil {

	private $plataformVersion = '3.x';
	private $moduleVersion = '4.0';

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
		'MLB' => 'BR',
		'MLM' => 'MX',
		'MLA' => 'AR',
		'MCO' => 'CO',
		'MLV' => 'VE',
		'MPE' => 'PE',
		'MLC' => 'CL',
		'MLU' => 'UY'
	);

	private $mp_order_status = [
		'approved'		=> 'completed',
		'pending'		=> 'pending',
		'in_process'	=> 'process',
		'rejected'		=> 'rejected',
	    'refunded'		=> 'refunded',
		'cancelled'		=> 'cancelled',
		'in_mediation'	=> ' - '
	];

	private $mp_order_status_id = [
		'completed' => 5,
		'pending'	=> 1,
		'refunded'	=> 11,
		'cancelled' => 7,
		'rejected'	=> 10  
	];

	public function create_analytics( $resultModules, $token, $customerEmail, $userLogged ) {
        $return = array(
            'publicKey'			=> '',
            'token'				=> $token,
            'platform'			=> 'Opencart',
            'platformVersion'	=> $this->plataformVersion,
            'moduleVersion'		=> $this->moduleVersion,
            'payerEmail'		=> $customerEmail,
            'userLogged'		=> $userLogged,
            'installedModules'	=> implode( ', ', $resultModules ),
            'additionalInfo'	=> ''
        );
        return $return;
    }

	public function update_order( $payment, $model, $config, $db ) {
		try {
			$result_order_status = $this->mp_order_status[$payment['response']['status']];
			$actualize = true;
			if ( isset( $db ) && $db != null ) {
				$status_id = $this->mp_order_status_id[$result_order_status];
				$sql = 'SELECT max(order_history_id) as order_history FROM ' . DB_PREFIX .
					'order_history WHERE order_id = ' . $payment['response']['external_reference'] .
					' and order_status_id = ' . $status_id;
				$query = $db->query( $sql );
				if ( isset( $query->rows ) && $query->rows[0]['order_history'] != null ) {
					$actualize = false;
				}
			}
			if ( $actualize ) {
				$model->addOrderHistory(
					$payment['response']['external_reference'],
					$config->get( 'mp_transparente_order_status_id_'. $result_order_status),
					date( 'd/m/Y h:i' ) . ' - ' .
					$payment['response']['payment_method_id'] . ' - ' .
					$payment['response']['transaction_details']['net_received_amount'] . ' - ' .
					'Payment ID:' . $payment['response']['id']
				);
			}
		} catch ( Exception $e ) {
			error_log( 'error for update_order - ' . $e );
		}
	}

	public function get_countries( $mp ) {
		$result = $mp->get( '/sites/', null, false );
		return $result['response'];
	}

	public function set_settings( $mp, $config_email, $statusCustom = false,  $custom_cupom = false, $standard = false, $checkout_basic = false ) {
        $request = array(
            'module_version'	=> $this->moduleVersion,
            'code_version'		=> phpversion(),
            'platform'			=> 'OpenCart',
            'platform_version'	=> $this->plataformVersion
        );
        if ( $statusCustom ) {
        	$request['checkout_custom_credit_card'] = $statusCustom;
        }
        if ( $custom_cupom ) {
        	$request['checkout_custom_credit_card_coupon'] = $custom_cupom;
        }
        if ( $standard ) {
        	$request['checkout_basic'] = $standard;
        }
		if ( $checkout_basic ) {
        	$request['checkout_custom_ticket'] = $checkout_basic;
		}
    }

	public function get_installments() {
		$installments = array(
			array( 'value' => '24', 'id' => '24' ),
			array( 'value' => '18', 'id' => '18' ),
			array( 'value' => '15', 'id' => '15' ),
			array( 'value' => '12', 'id' => '12' ),
			array( 'value' => '11', 'id' => '11' ),
			array( 'value' => '10', 'id' => '10' ),
			array( 'value' => '9', 'id' => '9' ),
			array( 'value' => '7', 'id' => '7' ),
			array( 'value' => '6', 'id' => '6' ),
			array( 'value' => '5', 'id' => '5' ),
			array( 'value' => '4', 'id' => '4' ),
			array( 'value' => '3', 'id' => '3' ),
			array( 'value' => '2', 'id' => '2' ),
			array( 'value' => '1', 'id' => '1' )
		);
		return $installments;
	}

	public function get_category_list( $mp ) {
		$uri = '/item_categories';
		$category = $mp->get( $uri, null, false );
		return $category['response'];
	}

	public function get_methods( $country_id, $mp ) {
		$uri = '/sites/' . $country_id . '/payment_methods';
		$methods = $mp->get( $uri, null, false );
		return $methods['response'];
	}

}