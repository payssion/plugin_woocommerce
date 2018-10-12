<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Webpaycl
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Webpaycl extends WC_Gateway_Payssion {
	public $title = 'WebPay plus';
	protected $pm_id = 'webpay_cl';
}