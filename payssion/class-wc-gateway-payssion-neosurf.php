<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_QIWI
 * @extends		WC_Payment_Gateway
 * @version		1.0.0
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Neosurf extends WC_Gateway_Payssion {
	protected $pm_id = 'neosurf';
	protected $curreny_list = array('EUR');
}