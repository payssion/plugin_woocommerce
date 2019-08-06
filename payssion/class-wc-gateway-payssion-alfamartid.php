<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Alfamartid
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Alfamartid extends WC_Gateway_Payssion {
	public $title = 'Alfamart';
	protected $pm_id = 'alfamart_id';
}