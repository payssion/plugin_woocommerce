<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Ebankingza
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Ebankingza extends WC_Gateway_Payssion {
	public $title = 'South Africa Internet Banking';
	protected $pm_id = 'ebanking_za';
}