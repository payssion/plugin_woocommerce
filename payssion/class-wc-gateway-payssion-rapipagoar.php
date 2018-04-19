<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Rapipagoar
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Rapipagoar extends WC_Gateway_Payssion {
	public $title = 'Rapi Pago';
	protected $pm_id = 'rapipago_ar';
}