<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Bancodobrasil
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Brazil extends WC_Gateway_Payssion {
	
	/*
	 * Render the CPF fields on the checkout page
	*/
	public function payment_fields() {
		?>
		        <script src="<?php echo plugins_url( '/assets/js/jquery.cadmask.js' , __FILE__ );?>"></script>
		        <script>
		        jQuery(function () {
		            	jQuery('#payer_ref_<?php echo $this->pm_id;?>').cadMask({
		                    showError: true
		                });
		            });
		        </script>
				    <p class="form-row form-row-first">
		                <label>CPF / CNPJ <span class="required">*</span></label>
		                <input class="input-text" type="text" size="14" maxlength="14" name="payer_ref_<?php echo $this->pm_id;?>" id="payer_ref_<?php echo $this->pm_id;?>" />
		            </p>  
		            <div class="clear"></div> 
			        <?php
	}
}