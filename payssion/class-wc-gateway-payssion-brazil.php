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
                <script src="<?php echo plugins_url( '/assets/js/inputmask.js' , __FILE__ );?>"></script>
                <script src="<?php echo plugins_url( '/assets/js/jquery.inputmask.js' , __FILE__ );?>"></script>
		        <script>
		        jQuery(function () {
		                        jQuery('#payer_ref_<?php echo $this->pm_id;?>').inputmask("mask", {"mask": "999.999.999-99"});
        jQuery('#payer_ref_<?php echo $this->pm_id;?>').bind('keyup', function () {
            var v = jQuery('#payer_ref_<?php echo $this->pm_id;?>').val().replace(/[^0-9]/ig,"");
            if(v.length > 11){
                jQuery('#payer_ref_<?php echo $this->pm_id;?>').inputmask("mask", {"mask": "99.999.999/9999-99"});
            }else{
                jQuery('#payer_ref_<?php echo $this->pm_id;?>').inputmask("mask", {"mask": "999.999.999-99[9]", greedy: false});
            }
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