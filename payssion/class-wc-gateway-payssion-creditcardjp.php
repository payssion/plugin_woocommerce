<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_CreditCardJP
 * @extends		WC_Payment_Gateway
 * @version		1.0.0
 * @author 		Payssion
 */
class WC_Gateway_Payssion_CreditCardJP extends WC_Gateway_Payssion {
	protected $pm_id = 'creditcard_jp';
}