<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Creditcardza
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Creditcardza extends WC_Gateway_Payssion {
	public $title = 'South Africa Credit Card';
	protected $pm_id = 'creditcard_za';
}