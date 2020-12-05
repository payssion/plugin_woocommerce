<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion-brazil.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Bancodobrasil
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Bancodobrasil extends WC_Gateway_Payssion_Brazil {
	protected $pm_id = 'bancodobrasil_br';
	public $title = 'Banco do Brasil';
	public $description = 'Simplesmente pague pelo seu internet banking. METODO ONLINE.';
}