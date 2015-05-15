<?php
/*
Plugin Name: WooCommerce Payssion
Plugin URI: http://www.payssion.com
Description: Integrates your Payssion payment getway into your WooCommerce installation.
Version: 1.0.0
Author: Payssion Limited
Text Domain: payssion
Author URI: http://www.payssion.com
*/
add_action('plugins_loaded', 'init_payssion_gateway', 0);

function init_payssion_gateway() {
	if( !class_exists('WC_Payment_Gateway') )  return;
	
	require_once('class-wc-gateway-payssion.php');
	require_once('class-wc-gateway-payssion-boleto.php');
	require_once('class-wc-gateway-payssion-cashu.php');
	require_once('class-wc-gateway-payssion-onecard.php');
	require_once('class-wc-gateway-payssion-paysafecard.php');
	require_once('class-wc-gateway-payssion-qiwi.php');
	require_once('class-wc-gateway-payssion-sofort.php');
	
	// Add the gateway to WooCommerce
	function add_payssion_gateway( $methods )
	{
		return array_merge($methods, 
				array(
						'WC_Gateway_Payssion', 
						'WC_Gateway_Payssion_Boleto',
						'WC_Gateway_Payssion_CashU',
						'WC_Gateway_Payssion_OneCard',
						'WC_Gateway_Payssion_Paysafecard',
						'WC_Gateway_Payssion_QIWI',
						'WC_Gateway_Payssion_SOFORT'));
	}
	add_filter('woocommerce_payment_gateways', 'add_payssion_gateway' );
	
	function wc_payssion_plugin_edit_link( $links ){
		return array_merge(
				array(
						'settings' => '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=checkout&section=wc_gateway_payssion') . '">'.__( 'Settings', 'alipay' ).'</a>'
				),
				$links
		);
	}
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wc_payssion_plugin_edit_link' );
}
?>
