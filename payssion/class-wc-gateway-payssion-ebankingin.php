<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Ebankingin
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Ebankingin extends WC_Gateway_Payssion {
	public $title = 'India Netbanking';
	protected $pm_id = 'ebanking_in';
}