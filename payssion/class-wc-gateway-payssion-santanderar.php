<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Santanderar
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Santanderar extends WC_Gateway_Payssion {
	protected $pm_id = 'santander_ar';
	public $title = 'Santander Rio Argentina';
}