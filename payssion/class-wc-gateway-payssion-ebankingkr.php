<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Ebankingkr
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Ebankingkr extends WC_Gateway_Payssion {
	public $title = 'South Korea Internet Banking';
	protected $pm_id = 'ebanking_kr';
}