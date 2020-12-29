<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once( 'class-wc-gateway-payssion-brazil.php' );

/**
 * Payssion
 *
 * @class 		WC_Gateway_Payssion_Creditcardbr
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Creditcardbr extends WC_Gateway_Payssion_Brazil {
    public $title = 'Brasil Credit Card';
    protected $pm_id = 'creditcard_br';
}