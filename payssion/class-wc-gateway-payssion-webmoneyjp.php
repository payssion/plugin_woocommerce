<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_WebMoneyjp
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_WebMoneyjp extends WC_Gateway_Payssion {
	public $title = 'Webmoney Japan';
	protected $pm_id = 'webmoney_jp';
}