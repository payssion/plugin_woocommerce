<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Grabpayph
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Grabpayph extends WC_Gateway_Payssion {
	public $title = 'GrabPay Philippines';
	protected $pm_id = 'grabpay_ph';
}