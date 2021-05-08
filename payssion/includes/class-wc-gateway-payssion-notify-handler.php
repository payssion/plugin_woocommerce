<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

include_once( 'class-wc-gateway-payssion-response.php' );

/**
 * Handles responses from Payssion Notify
 */
class WC_Gateway_Payssion_Notify_Handler extends WC_Gateway_Payssion_Response {

	/**
	 * Constructor
	 */
	public function __construct( $sandbox = false) {
		add_action( 'woocommerce_api_wc_gateway_payssion', array( $this, 'check_response' ) );
		add_action( 'valid-payssion-notify', array( $this, 'valid_response' ) );

		$this->sandbox        = $sandbox;
	}

	/**
	 * Check for Payssion Notify Response
	 */
	public function check_response() {
		if ( ! empty( $_POST ) && $this->validate_notify() ) {
			$posted = wp_unslash( $_POST );

			do_action( "valid-payssion-notify", $posted );
			exit;
		}

		wp_die( "Payssion Notify failed", "Payssion Notify", array( 'response' => 400 ) );
	}

	/**
	 * There was a valid response
	 * @param  array $posted Post data after wp_unslash
	 */
	public function valid_response( $posted ) {
		if ( ! empty( $posted['track_id'] ) && ( $order = $this->get_payssion_order($posted['track_id'], $posted['sub_track_id']) ) ) {

// 			// Lowercase returned variables
// 			$posted['payment_status'] = strtolower( $posted['payment_status'] );

// 			// Sandbox fix
// 			if ( isset( $posted['test_Notify'] ) && 1 == $posted['test_Notify'] && 'pending' == $posted['payment_status'] ) {
// 				$posted['payment_status'] = 'completed';
// 			}

			if (!$this->isPayssion($order->payment_method)) {
				if ($posted['state'] != 'completed') {
					die ("payment method changed");
				}
			}
			
			WC_Gateway_Payssion::log( 'Found order #' . $order->id );
			WC_Gateway_Payssion::log( 'Payment status: ' . $posted['state'] );

			if ( method_exists( __CLASS__, 'payment_status_' . $posted['state'] ) ) {
				call_user_func( array( __CLASS__, 'payment_status_' . $posted['state'] ), $order, $posted );
				die ("OK");
			}
		} else {
			die ("order not found ");
		}
	}
	
	protected function isPayssion($payment_method) {
		return substr($payment_method, 0, strlen('payssion')) === 'payssion';
	}

	/**
	 * Check Payssion notify validity
	 */
	public function validate_notify() {
		WC_Gateway_Payssion::log( 'Checking Notify response is valid' );
		$payssion = new WC_Gateway_Payssion();
		$apiKey = $payssion->get_option('api_key');
		$secretKey = $payssion->get_option('secret_key');
		
		// Assign payment notification values to local variables
		$pm_id = $_POST['pm_id'];
		$amount = $_POST['amount'];
		$currency = $_POST['currency'];
		$track_id = $_POST['track_id'];
		$sub_track_id = $_POST['sub_track_id'];
		$state = $_POST['state'];
		
		$check_array = array(
				$apiKey,
				$pm_id,
				$amount,
				$currency,
				$track_id,
				$sub_track_id,
				$state,
				$secretKey
		);
		$check_msg = implode('|', $check_array);
		$check_sig = md5($check_msg);
		$notify_sig = $_POST['notify_sig'];
		if ($notify_sig == $check_sig) {
			WC_Gateway_Payssion::log( 'Received valid response from Payssion' );
			return true;
		} else {
			WC_Gateway_Payssion::log( 'Received invalid response from Payssion' );
		}
		
		return false;
	}
	
	
	private function validate_amount_currency( $order, $posted ) {
		// Validate currency
		$order_amount = number_format( $order->get_total(), 2, '.', '' );
		$order_currency = $order->get_order_currency();
		$currency = $posted['currency'];
		$amount = $posted['paid'];
		$error = false;
		$error_amount = null;
		$error_currency = null;
		if ($order_currency == $currency) {
			$error_currency = $currency;
			if ($order_amount != $amount) {
				$error = 1;
				$error_amount = $amount;
			}
		} else {
			$currency_local = @$posted['currency_local'];
			if ($currency_local) {
				$error_currency = $currency_local;
				if ($order_currency == $currency_local) {
					$amount_local = @$posted['amount_local'];
					if ($order_amount != $amount_local) {
						$error = 1;
						$error_amount = $amount_local;
			        }
				} else {
					$error = 2;
				}
			} else {
				$error = 2;
				$error_currency = $currency;
			}
		}
		
		if (1 == $error) {
			if ($error_amount > 0 && $error_amount < $order_amount) {
				$order->update_status( 'paid-partial', sprintf( __( 'Partial Paid %s.', 'woocommerce' ), "$error_amount $error_currency") );
			} else {
				WC_Gateway_Payssion::log( 'Payment error: Amounts do not match (gross ' . $error_amount . ')' );
					
				// Put this order on-hold for manual checking
				$order->update_status( 'on-hold', sprintf( __( 'Validation error: Payssion amounts do not match (gross %s).', 'woocommerce' ), $error_amount ) );
			}

			exit;
		} else if (2 == $error) {
			WC_Gateway_Payssion::log( 'Payment error: Currencies do not match (sent "' . $order->get_order_currency() . '" | returned "' . $error_currency . '")' );
			
			// Put this order on-hold for manual checking
			$order->update_status( 'on-hold', sprintf( __( 'Validation error: Payssion currencies do not match (code %s).', 'woocommerce' ), $error_currency ) );
			exit;
		}
	}
	
	/**
	 * Check currency from Notify matches the order
	 * @param  WC_Order $order
	 * @param  string $currency
	 */
	private function validate_currency( $order, $currency ) {
		// Validate currency
		if ( $order->get_order_currency() != $currency ) {
			WC_Gateway_Payssion::log( 'Payment error: Currencies do not match (sent "' . $order->get_order_currency() . '" | returned "' . $currency . '")' );

			// Put this order on-hold for manual checking
			$order->update_status( 'on-hold', sprintf( __( 'Validation error: Payssion currencies do not match (code %s).', 'woocommerce' ), $currency ) );
			exit;
		}
	}

	/**
	 * Check payment amount from Notify matches the order
	 * @param  WC_Order $order
	 */
	private function validate_amount( $order, $amount ) {
		if ( number_format( $order->get_total(), 2, '.', '' ) != number_format( $amount, 2, '.', '' ) ) {
			WC_Gateway_Payssion::log( 'Payment error: Amounts do not match (gross ' . $amount . ')' );

			// Put this order on-hold for manual checking
			$order->update_status( 'on-hold', sprintf( __( 'Validation error: Payssion amounts do not match (gross %s).', 'woocommerce' ), $amount ) );
			exit;
		}
	}

	/**
	 * Handle a completed payment
	 * @param  WC_Order $order
	 */
	private function payment_status_completed( $order, $posted ) {
		if ( $order->has_status( 'completed' ) ) {
			WC_Gateway_Payssion::log( 'Aborting, Order #' . $order->id . ' is already complete.' );
			exit;
		}
		
		$this->validate_amount_currency( $order, $posted );
		//$this->validate_currency( $order, $posted['currency'] );
		//$this->validate_amount( $order, $posted['amount'] );

		if ( 'completed' === $posted['state'] ) {
			$this->payment_complete( $order, ( ! empty( $posted['transaction_id'] ) ? wc_clean( $posted['transaction_id'] ) : '' ), __( 'Payssion Notify payment completed', 'woocommerce' ) );
		} else {
			$this->payment_on_hold( $order, sprintf( __( 'Payment pending', 'woocommerce' )) );
		}
	}
	

	/**
	 * Handle a paid_partial payment
	 * @param  WC_Order $order
	 */
	private function payment_status_paid_partial( $order, $posted ) {
		if ( $order->has_status( 'paid_partial' ) ) {
			die ('paid_partial handled before');
			WC_Gateway_Payssion::log( 'Aborting, Order #' . $order->id . ' is already handled before.' );
			exit;
		}
	
		$this->validate_amount_currency( $order, $posted );
	}

	/**
	 * Handle a pending payment
	 * @param  WC_Order $order
	 */
	private function payment_status_pending( $order, $posted ) {
		$this->payment_status_completed( $order, $posted );
	}

	/**
	 * Handle a failed payment
	 * @param  WC_Order $order
	 */
	private function payment_status_failed( $order, $posted ) {
	    if ( $order->has_status( 'completed' ) || $order->has_status( 'paid_partial' ) ) {
	        die ('handled before');
	        WC_Gateway_Payssion::log( 'Aborting, Order #' . $order->id . ' is already handled before.' );
	        exit;
	    }
	    
		$order->update_status( 'failed', sprintf( __( 'Payment %s via Payssion Notify.', 'woocommerce' ), wc_clean( $posted['state'] ) ) );
	}

	/**
	 * Handle a cancelled by user payment
	 * @param  WC_Order $order
	 */
	private function payment_status_cancelled_by_user( $order, $posted ) {
		$this->payment_status_failed( $order, $posted );
	}
	
	/**
	 * Handle a cancelled payment
	 * @param  WC_Order $order
	 */
	private function payment_status_cancelled( $order, $posted ) {
		$this->payment_status_failed( $order, $posted );
	}

	
	/**
	 * Handle an expired payment
	 * @param  WC_Order $order
	 */
	private function payment_status_expired( $order, $posted ) {
		$this->payment_status_failed( $order, $posted );
	}

	/**
	 * Handle a rejected payment
	 * @param  WC_Order $order
	 */
	private function payment_status_rejected_by_bank( $order, $posted ) {
		$this->payment_status_failed( $order, $posted );
	}
	
	/**
	 * Handle a error payment
	 * @param  WC_Order $order
	 */
	private function payment_status_error( $order, $posted ) {
		$this->payment_status_failed( $order, $posted );
	}
	

	/**
	 * Handle a refunded order
	 * @param  WC_Order $order
	 */
	private function payment_status_refunded( $order, $posted ) {
		// Only handle full refunds, not partial
		if ( $order->get_total() == ( $posted['mc_gross'] * -1 ) ) {

			// Mark order as refunded
			$order->update_status( 'refunded', sprintf( __( 'Payment %s via Payssion Notify.', 'woocommerce' ), strtolower( $posted['state'] ) ) );

			$this->send_email_notification(
				sprintf( __( 'Payment for order #%s refunded/reversed', 'woocommerce' ), $order->get_order_number() ),
				sprintf( __( 'Order %s has been marked as refunded', 'woocommerce' ), $order->get_order_number())
			);
		}
	}

	/**
	 * Handle a chargeback
	 * @param  WC_Order $order
	 */
	private function payment_status_chargeback( $order, $posted ) {
		$order->update_status( 'on-hold', sprintf( __( 'Payment %s via Payssion Notify.', 'woocommerce' ), wc_clean( $posted['state'] ) ) );

		$this->send_email_notification(
			sprintf( __( 'Payment for order #%s reversed', 'woocommerce' ), $order->get_order_number() ),
			sprintf( __( 'Order %s has been marked on-hold due to a chargeback', 'woocommerce' ), $order->get_order_number() )
		);
	}

	/**
	 * Send a notification to the user handling orders.
	 * @param  string $subject
	 * @param  string $message
	 */
	private function send_email_notification( $subject, $message ) {
		$new_order_settings = get_option( 'woocommerce_new_order_settings', array() );
		$mailer             = WC()->mailer();
		$message            = $mailer->wrap_message( $subject, $message );

		$mailer->send( ! empty( $new_order_settings['recipient'] ) ? $new_order_settings['recipient'] : get_option( 'admin_email' ), $subject, $message );
	}
}
?>
