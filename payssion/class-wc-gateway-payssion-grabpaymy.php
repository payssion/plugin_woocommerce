<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Grabpaymy
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Grabpaymy extends WC_Gateway_Payssion {
	public $title = 'GrabPay Malaysia';
	protected $pm_id = 'grabpay_my';
}