<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Tenpay
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Tenpay extends WC_Gateway_Payssion {
	public $title = 'Wechat Pay';
	protected $pm_id = 'tenpay_cn';
}