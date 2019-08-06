<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Ebankingth
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Ebankingth extends WC_Gateway_Payssion {
	public $title = 'Thailand online banking';
	protected $pm_id = 'ebanking_th';
}