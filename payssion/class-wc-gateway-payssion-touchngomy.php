<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Touchngomy
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Touchngomy extends WC_Gateway_Payssion {
	public $title = "Touch N' Go";
	protected $pm_id = 'touchngo_my';
}