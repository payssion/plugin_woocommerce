<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_POLi
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_POLi extends WC_Gateway_Payssion {
	public $title = 'Australia/New Zealand Bank Transfer';
	protected $pm_id = 'polipayment';
}