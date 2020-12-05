<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion-brazil.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Itaubr
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Itaubr extends WC_Gateway_Payssion_Brazil {
	public $title = 'Banco Itaú';
	protected $pm_id = 'itau_br';
}