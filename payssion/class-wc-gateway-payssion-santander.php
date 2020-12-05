<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion-brazil.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Santander
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Santander extends WC_Gateway_Payssion_Brazil {
	protected $pm_id = 'santander_br';
	public $title = 'Banco Santander Brasil';
	public $description = 'Siga as instruções apresentadas na tela seguinte.';
}