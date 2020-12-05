<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion-brazil.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Pixbr
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Pixbr extends WC_Gateway_Payssion_Brazil {
	public $title = 'PIX';
	protected $pm_id = 'pix_br';
}