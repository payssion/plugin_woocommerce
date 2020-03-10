<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_MercadoPagomx
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_MercadoPagomx extends WC_Gateway_Payssion {
	protected $pm_id = 'mercadopago_mx';
	public $title = 'MercadoPago Mexico';
	public $description = 'Pay via MercadoPago Mexico';
}