<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Creditcardkr
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Creditcardkr extends WC_Gateway_Payssion {
	public $title = 'South Korea Credit Card';
	protected $pm_id = 'creditcard_kr';
}