<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion
 * @extends		WC_Payment_Gateway
 * @version		1.1.1
 * @package		WooCommerce/Classes/Payment
 * @author 		Payssion
 */
class WC_Gateway_Payssion extends WC_Payment_Gateway {

	/** @var boolean Whether or not logging is enabled */
	public static $log_enabled = false;

	/** @var WC_Logger Logger instance */
	public static $log = false;
	
	protected $pm_id = '';
	protected $pm = '';
	protected $is_channel = true;
	public $title = '';
	public $description = '';

	/**
	 * Constructor for the gateway.
	 */
	public function __construct() {
		$class_name = get_class($this);
		if (strlen($class_name) == strlen('WC_Gateway_Payssion')) {
			$this->is_channel = false;
		}
		$index = strrpos($class_name, '_');
		$this->pm = substr($class_name, $index + 1);
		
		$this->id                 = strtolower($this->is_channel ? 'payssion-' . $this->pm : $this->pm);
		$this->icon               = apply_filters( 'woocommerce_' . $this->pm . '_icon', plugins_url( 'assets/images/' . ($this->pm_id ? $this->pm_id : $this->pm) . '.png', __FILE__ ) );
		$this->has_fields         = false;
		
		$method_title = $this->getMethodTitle();
		$this->order_button_text  = __( 'Proceed to ' . $method_title, 'woocommerce' );
		$this->method_title       = ($this->pm_id ? 'Payssion ' : '') . $method_title;
		$this->method_description = __( $this->is_channel ? '' : 'Payssion provides a global payment solution.', 'woocommerce' );
		$this->supports           = array(
			'products'
		);

		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();
		
		$this->init_payssion_setting();

		// Define user set variables
		$this->title          = $this->get_option( 'title' );
		if ($this->testmode) {
			$this->title .= ' Sandbox';
		}
		$this->description    = $this->get_option( 'description' );
		$this->enabled        = $this->get_option( 'enabled' );
		self::$log_enabled    = $this->debug;

		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
		add_action( 'woocommerce_receipt_' . $this->id, array( $this, 'receipt_page' ) );
		
		if ( ! $this->is_valid_for_use() ) {
			$this->enabled = 'no';
		} else {
			include_once( 'includes/class-wc-gateway-payssion-notify-handler.php' );
			new WC_Gateway_Payssion_Notify_Handler( $this->testmode);
		}
	}
	
	protected function getMethodTitle() {
		$method_title = '';
		if ($this->title) {
			$method_title = $this->title;
		} else {
			$method_title = __( $this->pm, 'woocommerce' );
			$index = strrpos($this->pm_id, '_');
			if ($index && substr($this->pm_id, $index + 1) == substr($method_title, strlen($method_title) - 2)) {
				$method_title = substr($method_title, 0, strlen($method_title) - 2);
			}
		}
		
		return $method_title;
	}
	
	protected $api_key;
	protected $secret_key;
	protected function init_payssion_setting() {
		if ($this->is_channel) {
			$payssion = new WC_Gateway_Payssion();
			$this->api_key = $payssion->get_option('api_key');
			$this->secret_key = $payssion->get_option('secret_key');
			$this->testmode = 'yes' === $payssion->get_option( 'testmode', 'no' );
		    $this->debug = 'yes' === $payssion->get_option( 'debug', 'no' );
		} else {
			$this->api_key = $this->get_option('api_key');
			$this->secret_key = $this->get_option('secret_key');
			$this->testmode = 'yes' === $this->get_option( 'testmode', 'no' );
			$this->debug = 'yes' === $this->get_option( 'debug', 'no' );
		}
	}
	
	public function get_apikey() {
		return $this->api_key;
	}
	
	public function get_secretkey() {
		return $this->secret_key;
	}

	/**
	 * Logging method
	 * @param  string $message
	 */
	public static function log( $message ) {
		if ( self::$log_enabled ) {
			if ( empty( self::$log ) ) {
				self::$log = new WC_Logger();
			}
			self::$log->add( 'Payssion', $message );
		}
	}

	/**
	 * get_icon function.
	 *
	 * @return string
	 */
// 	public function get_icon() {
// 		return apply_filters('woocommerce_payssion_icon',  plugins_url('assets/images/payssion.png', __FILE__));
// 	}

	/**
	 * Check if this gateway is enabled and available in the user's country
	 *
	 * @return bool
	 */
	public function is_valid_for_use() {
		return $this->is_channel;
	}

	/**
	 * Admin Panel Options
	 * - Options for bits like 'title' and availability on a country-by-country basis
	 *
	 * @since 1.0.0
	 */
	public function admin_options() {
		if (true) {
			parent::admin_options();
		} else {
			?>
			<div class="inline error"><p><strong><?php _e( 'Gateway Disabled', 'woocommerce' ); ?></strong>: <?php _e( 'Payssion does not support your store currency.', 'woocommerce' ); ?></p></div>
			<?php
		}
	}

	/**
	 * Initialise Gateway Settings Form Fields
	 */
	public function init_form_fields() {
		$method_title = $this->getMethodTitle();
		if ($this->is_channel) {
			$this->form_fields = array(
					'enabled' => array(
							'title'   => __( 'Enable/Disable', 'woocommerce' ),
							'type'    => 'checkbox',
							'label'   => __( 'Enable ' . $method_title, 'woocommerce' ),
							'default' => 'no'
					),
					'title' => array(
							'title'       => __( 'Title', 'woocommerce' ),
							'type'        => 'text',
							'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
							'default'     => $method_title,
							'desc_tip'    => true,
					),
					'description' => array(
							'title'       => __( 'Description', 'woocommerce' ),
							'type'        => 'text',
							'desc_tip'    => true,
							'description' => __( 'This controls the description which the user sees during checkout.', 'woocommerce' ),
							'default'     => __( $this->description ? $this->description : ('Pay via ' . $method_title), 'woocommerce' )
					)
			);
		} else {
			$this->form_fields = array(
					'testmode' => array(
							'title'       => __( 'Payssion Sandbox', 'woocommerce' ),
							'type'        => 'checkbox',
							'label'       => __( 'Enable Payssion sandbox', 'woocommerce' ),
							'default'     => 'no',
							'description' => sprintf( __( 'Payssion sandbox can be used to test payments. Sign up for a developer account <a href="%s">here</a>.', 'woocommerce' ), 'https://sandbox.Payssion.com/' ),
					),
					'debug' => array(
							'title'       => __( 'Debug Log', 'woocommerce' ),
							'type'        => 'checkbox',
							'label'       => __( 'Enable logging', 'woocommerce' ),
							'default'     => 'no',
							'description' => sprintf( __( 'Log Payssion events, inside <code>%s</code>', 'woocommerce' ), wc_get_log_file_path( 'Payssion' ) )
					),
					'invoice_prefix' => array(
							'title'       => __( 'Invoice Prefix', 'woocommerce' ),
							'type'        => 'text',
							'description' => __( 'Please enter a prefix for your invoice numbers. If you use your Payssion account for multiple stores ensure this prefix is unique as Payssion will not allow orders with the same invoice number.', 'woocommerce' ),
							'default'     => 'WC-',
							'desc_tip'    => true,
					),
					'api_details' => array(
							'title'       => __( 'API Credentials', 'woocommerce' ),
							'type'        => 'title',
							'description' => __( 'Enter your Payssion API credentials which you can find at your app settings after logging in at your payssion account.', 'woocommerce' ),
					),
					'api_key' => array(
							'title'       => __( 'API Key', 'woocommerce' ),
							'type'        => 'text',
							'description' => __( 'Get your API credentials from Payssion.', 'woocommerce' ),
							'default'     => '',
							'desc_tip'    => true,
							'placeholder' => __( 'Required', 'woocommerce' )
					),
					'secret_key' => array(
							'title'       => __( 'Secret Key', 'woocommerce' ),
							'type'        => 'text',
							'description' => __( 'Get your API credentials from Payssion.', 'woocommerce' ),
							'default'     => '',
							'desc_tip'    => true,
							'placeholder' => __( 'Required', 'woocommerce' )
					));
		}
	}

	/**
	 * Get the transaction URL.
	 *
	 * @param  WC_Order $order
	 *
	 * @return string
	 */
	public function get_transaction_url( $order ) {
		if (!$this->testmode) {
			$this->view_transaction_url = 'https://www.payssion.com/payment/create.html';
		} else {
			$this->view_transaction_url = 'http://sandbox.payssion.com/payment/create.html';
		}
		return parent::get_transaction_url( $order );
	}
	
	public function get_pmid() {
		return $this->pm_id;
	}

	/**
	 * Process the payment and return the result
	 *
	 * @param int $order_id
	 * @return array
	 */
	public function process_payment( $order_id ) {
	    include_once('includes/class-wc-gateway-payssion-request.php');

		$order = wc_get_order( $order_id );
		$payssion_request = new WC_Gateway_Payssion_Request( $this ); 
		return array(
			'result'   => 'success',
		    'redirect' => $payssion_request->get_request_url( $order, $this->testmode ),
		);
		
// 		return array(
// 		    'result' 	=> 'success',
// 		    'redirect'	=> $order->get_checkout_payment_url( true )
// 		);
	}
	
	/**
	 * Output for the order received page.
	 *
	 * @access public
	 * @return void
	 */
	function receipt_page( $order ) {
	
	    echo '<p>' . "Thank you for your order, please click the button below to pay with {$this->title}." . '</p>';
	
		echo $this->generate_payssion_form( $order );
	}
	
	/**
	 * Generate the payssion button link (POST method)
	 *
	 * @access public
	 * @param mixed $order_id
	 * @return string
	 */
	function generate_payssion_form( $order_id ) {
	    include_once('includes/class-wc-gateway-payssion-request.php');
	    $request = new WC_Gateway_Payssion_Request($this);
	    $order = wc_get_order( $order_id );
	    $request_data = $request->get_payssion_args($order);
	    $payssion_args_array = [];
	    foreach ($request_data as $key => $value) {
	        $payssion_args_array[] = '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
	    }
		
		wc_enqueue_js( '
				$.blockUI({
				message: "' . esc_js( __( 'Thank you for your order. We are now redirecting you to payssion to make payment.', 'payssion' ) ) . '",
				baseZ: 99999,
				overlayCSS:
				{
				background: "#fff",
				opacity: 0.6
	},
				css: {
				padding:        "20px",
				zindex:         "9999999",
				textAlign:      "center",
				color:          "#555",
				border:         "3px solid #aaa",
				backgroundColor:"#fff",
				cursor:         "wait",
				lineHeight:     "24px",
	}
	});
				jQuery("#submit_payssion_payment_form").click();
				' );
	
		
		$url = $request->get_request_url(null, $this->testmode );
		return '<form id="payssionsubmit" name="payssionsubmit" action="' . $url . '" method="post" target="_top">' . implode('', $payssion_args_array) . '
		<!-- Button Fallback -->
		<div class="payment_buttons">
		<input type="submit" class="button-alt" id="submit_payssion_payment_form" value="' . __('Pay via payssion', 'payssion') . '" /> <a class="button cancel" href="' . esc_url($order->get_cancel_order_url()) . '">' . __('Cancel order &amp; restore cart', 'payssion') . '</a>
		</div>
		<script type="text/javascript">
		jQuery(".payment_buttons").hide();
		</script>
		</form>';
	}

	/**
	 * Process a refund if supported
	 * @param  int $order_id
	 * @param  float $amount
	 * @param  string $reason
	 * @return  boolean True or false based on success, or a WP_Error object
	 */
	public function process_refund( $order_id, $amount = null, $reason = '' ) {
		$this->log( 'Refund Failed: You have to log in at payssion in order to process refund' );
		return false;
	}
}
?>
