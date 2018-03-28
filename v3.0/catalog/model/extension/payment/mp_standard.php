<?php

class ModelExtensionPaymentMpStandard extends Model {
	public function getMethod( $address ) {
		$this->load->language( 'extension/payment/mp_standard' );
		if ( $this->config->get( 'payment_mp_standard_status' ) ) {
			$query = $this->db->query(
				'SELECT * FROM ' . DB_PREFIX . 'zone_to_geo_zone WHERE ' .
				'geo_zone_id = "' . (int) $this->config->get( 'payment_mp_standard_geo_zone_id' ) . '" AND ' .
				'country_id = "' . (int) $address['country_id'] . '" AND ' .
				'(zone_id = "' . (int) $address['zone_id'] . '" OR zone_id = "0")'
			);
			if ( ! $this->config->get( 'payment_mp_standard_geo_zone_id' ) ) {
				$status = true;
			} elseif ( $query->num_rows ) {
				$status = true;
			} else {
				$status = false;
			}
		} else {
			$status = false;
		}
		$method_data = array();
		if ( $status ) {
			$method_data = array(
				'code'       => 'mp_standard',
				'title'      => $this->language->get( 'text_title' ),
				'terms'      => '',//$this->language->get( 'text_terms' ),
				'sort_order' => $this->config->get( 'payment_mp_standard_sort_order' )
			);
		}
		return $method_data;
	}
}

?>