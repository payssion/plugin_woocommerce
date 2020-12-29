<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once( 'class-wc-gateway-payssion-brazil.php' );

/**
 * Payssion
 *
 * @class 		WC_Gateway_Payssion_Caixabr
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Caixabr extends WC_Gateway_Payssion_Brazil {
    public $title = 'Caixa Brasil';
    protected $pm_id = 'caixa_br';
}