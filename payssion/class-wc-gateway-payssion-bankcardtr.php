<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Bankcardtr
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Bankcardtr extends WC_Gateway_Payssion {
	public $title = 'Turkish Credit/Bank Card';
	protected $pm_id = 'bankcard_tr';
}