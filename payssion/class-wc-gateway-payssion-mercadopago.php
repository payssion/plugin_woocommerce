<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_CashU
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_MercadoPago extends WC_Gateway_Payssion {
	protected $pm_id = 'mercadopago';
	public $title = 'MercadoPago Brasil';
	public $description = 'Pay with credit card via MercadoPago';
	static $pm_id_list = array('');

	/*
	 * Render the credit card fields on the checkout page
	*/
	public function payment_fields() {
		?>
        <script src="<?php echo plugins_url( '/assets/js/jquery.cadmask.js' , __FILE__ );?>"></script>
        <script>
        jQuery(function () {
            	jQuery('#payer_ref').cadMask({
                    showError: true
                });
            });
        </script>
		    <p class="form-row form-row-first">
                <label>CPF / CNPJ <span class="required">*</span></label>
                <input class="input-text" type="text" size="14" maxlength="14" name="payer_ref" id="payer_ref" />
            </p>  
            <div class="clear"></div> 
	        <p class="form-row form-row-first">
	            <label>Card Type <span class="required">*</span></label>
	            <select name="payssion_cardtype" >
	                <option value="visa_br" selected="selected">Visa</option>
	                <option value="mastercard_br">MasterCard</option>
	                <option value="elo_br">Elo</option>
	                <option value="dinersclub_br">Diners club</option>
	                <option value="hipercard_br">Hipercard</option>
	                <option value="americanexpress_br">American Express</option>
	            </select>
	        </p>       
	        <div class="clear"></div>
	        <?php
	}
	
	/**
	 * Process the payment and return the result
	 *
	 * @param int $order_id
	 * @return array
	 */
	public function process_payment( $order_id ) {
		$this->pm_id = $_POST['payssion_cardtype'];
		return parent::process_payment($order_id);
	}
}