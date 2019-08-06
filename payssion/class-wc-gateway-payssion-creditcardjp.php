<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_CreditCardjp
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_CreditCardjp extends WC_Gateway_Payssion {
	public $title = 'Japan Visa/Mastercard';
	protected $pm_id = 'creditcard_jp';
}