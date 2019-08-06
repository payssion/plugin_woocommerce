<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Gcashph
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Gcashph extends WC_Gateway_Payssion {
	public $title = 'Globe Gcash';
	protected $pm_id = 'gcash_ph';
}