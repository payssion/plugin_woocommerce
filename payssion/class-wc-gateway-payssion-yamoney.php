<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Yamoney
 * @extends		WC_Payment_Gateway
 * @version		1.0.0
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Yamoney extends WC_Gateway_Payssion {
	protected $pm_id = 'yandexmoney';
	protected $curreny_list = array('USD');
	
	public $title = 'Yandex.Money';
}