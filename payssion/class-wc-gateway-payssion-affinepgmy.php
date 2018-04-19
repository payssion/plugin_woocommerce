<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Affinepgmy
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Affinepgmy extends WC_Gateway_Payssion {
	public $title = 'Affin Bank';
	protected $pm_id = 'affinepg_my';
}