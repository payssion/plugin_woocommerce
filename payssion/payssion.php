<?php
/*
Plugin Name: WooCommerce Payssion
Plugin URI: http://www.payssion.com
Description: Integrates your Payssion payment getway into your WooCommerce installation.
Version: 1.0.1
Author: Payssion
Text Domain: payssion
Author URI: http://www.payssion.com
*/
add_action('plugins_loaded', 'init_payssion_gateway', 0);

function init_payssion_gateway() {
	if( !class_exists('WC_Payment_Gateway') )  return;
	
	require_once('class-wc-gateway-payssion.php');
	
	require_once('class-wc-gateway-payssion-alipay.php');
	require_once('class-wc-gateway-payssion-banamex.php');
	require_once('class-wc-gateway-payssion-bancochile.php');
	require_once('class-wc-gateway-payssion-bancodobrasil.php');
	require_once('class-wc-gateway-payssion-bancomer.php');
	require_once('class-wc-gateway-payssion-bitcashjp.php');
	require_once('class-wc-gateway-payssion-bitcoin.php');
	require_once('class-wc-gateway-payssion-boleto.php');
	require_once('class-wc-gateway-payssion-cashu.php');
	require_once('class-wc-gateway-payssion-creditcardjp.php');
	require_once('class-wc-gateway-payssion-docomojp.php');
	require_once('class-wc-gateway-payssion-dragonpay.php');
	require_once('class-wc-gateway-payssion-enets.php');
	require_once('class-wc-gateway-payssion-mercadopago.php');
	require_once('class-wc-gateway-payssion-molpay.php');
	require_once('class-wc-gateway-payssion-neosurf.php');
	require_once('class-wc-gateway-payssion-netcashjp.php');
	require_once('class-wc-gateway-payssion-nganluong.php');
	require_once('class-wc-gateway-payssion-onecard.php');
	require_once('class-wc-gateway-payssion-openbucks.php');
	require_once('class-wc-gateway-payssion-oxxo.php');
	require_once('class-wc-gateway-payssion-paysafecard.php');
	require_once('class-wc-gateway-payssion-poli.php');
	require_once('class-wc-gateway-payssion-qiwi.php');
	require_once('class-wc-gateway-payssion-redcompra.php');
	require_once('class-wc-gateway-payssion-santander.php');
	require_once('class-wc-gateway-payssion-santandermx.php');
	require_once('class-wc-gateway-payssion-sofort.php');
	require_once('class-wc-gateway-payssion-tenpay.php');
	require_once('class-wc-gateway-payssion-trustpay.php');
	require_once('class-wc-gateway-payssion-unionpay.php');
	require_once('class-wc-gateway-payssion-webmoney.php');
	require_once('class-wc-gateway-payssion-webmoneyjp.php');
	require_once('class-wc-gateway-payssion-yamoney.php');
	
	// Add the gateway to WooCommerce
	function add_payssion_gateway( $methods )
	{
		return array_merge($methods, 
				array(
						'WC_Gateway_Payssion', 
						'WC_Gateway_Payssion_Alipay',
						'WC_Gateway_Payssion_Banamex',
						'WC_Gateway_Payssion_Bancochile',
						'WC_Gateway_Payssion_Bancodobrasil',
						'WC_Gateway_Payssion_Bancomer',
						'WC_Gateway_Payssion_BitCashJP',
						'WC_Gateway_Payssion_Bitcoin',
						'WC_Gateway_Payssion_Boleto',
						'WC_Gateway_Payssion_CashU',
						'WC_Gateway_Payssion_CreditCardJP',
						'WC_Gateway_Payssion_Dragonpay',
						'WC_Gateway_Payssion_Enets',
						'WC_Gateway_Payssion_MercadoPago',
						'WC_Gateway_Payssion_Molpay',
						'WC_Gateway_Payssion_Neosurf',
						'WC_Gateway_Payssion_NetCashJP',
						'WC_Gateway_Payssion_Nganluong',
						'WC_Gateway_Payssion_OneCard',
						'WC_Gateway_Payssion_Openbucks',
						'WC_Gateway_Payssion_OXXO',
						'WC_Gateway_Payssion_Paysafecard',
						'WC_Gateway_Payssion_POLi',
						'WC_Gateway_Payssion_QIWI',
						'WC_Gateway_Payssion_Redcompra',
						'WC_Gateway_Payssion_Santander',
						'WC_Gateway_Payssion_Santandermx',
						'WC_Gateway_Payssion_SOFORT',
						'WC_Gateway_Payssion_Tenpay',
						'WC_Gateway_Payssion_Trustpay',
						'WC_Gateway_Payssion_Unionpay',
						'WC_Gateway_Payssion_WebMoney',
						'WC_Gateway_Payssion_WebMoneyJP',
						'WC_Gateway_Payssion_Yamoney'));
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
