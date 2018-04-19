<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Santander
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Santander extends WC_Gateway_Payssion {
	protected $pm_id = 'santander_br';
	public $title = 'Banco Santander Brasil';
	public $description = 'Siga as instruções apresentadas na tela seguinte.';
	
	/*
	 * Render the CPF fields on the checkout page
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
			        <?php
	}
}