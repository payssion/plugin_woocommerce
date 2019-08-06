<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Atmid
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Atmid extends WC_Gateway_Payssion {
	public $title = 'Indonesia ATM Transfer';
	protected $pm_id = 'atm_id';
}