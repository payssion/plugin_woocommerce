<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

include_once( 'class-wc-gateway-payssion-order.php' );

/**
 * Handles refunds
 */
abstract class WC_Gateway_Payssion_Response {

	/** @var bool Sandbox mode */
	protected $sandbox = false;

	/**
	 * Get the order from the Payssion 'track_id' variable
	 *
	 * @param  string $track_id, $sub_track_id
	 * @return bool|WC_Order object
	 */
	protected function get_payssion_order($track_id, $sub_track_id) {
		
		if ( ! $order = wc_get_order( $track_id ) ) {
			// We have an invalid $order_id, probably because invoice_prefix has changed
			$order_id 	= wc_get_order_id_by_order_key( $sub_track_id );
			$order 		= wc_get_order( $order_id );
		}

		$order = new WC_Gateway_Payssion_Order($order);
		if ( ! $order || $order->order_key !== $sub_track_id ) {
			WC_Gateway_Payssion::log( 'Error: Order Keys do not match.' );
			return false;
		}
	
		return $order;
	}

	/**
	 * Complete order, add transaction ID and note
	 * @param  WC_Order $order
	 * @param  string $txn_id
	 * @param  string $note
	 */
	protected function payment_complete( $order, $txn_id = '', $note = '' ) {
		$order->add_order_note( $note );
		$order->payment_complete( $txn_id );
	}

	/**
	 * Hold order and add note
	 * @param  WC_Order $order
	 * @param  string $reason
	 */
	protected function payment_on_hold( $order, $reason = '' ) {
		$order->update_status( 'on-hold', $reason );
	}
}
?>