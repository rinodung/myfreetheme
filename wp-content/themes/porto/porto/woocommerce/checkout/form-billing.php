<?php
/**
 * Checkout billing information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
            <?php if ( WC()->cart->ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>
        
        		<?php _e( 'Billing &amp; Shipping', 'woocommerce' ); ?>
        
        	<?php else : ?>
        
        		<?php _e( 'Billing Details', 'woocommerce' ); ?>
        
        	<?php endif; ?>
            </a>
        </h4>
    </div>
    <div id="collapseOne" class="accordion-body collapse in">
        <div class="panel-body woocommerce-billing-fields cts-wrapper">
        
        	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>
        
        	<?php
                foreach ( $checkout->checkout_fields['billing'] as $key => $field ) :
                    
                    if( is_str_contain( 'first_name', $key ) ) {
                        $field['return'] = true;
                        $output = woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                        $output = str_replace( 'col-md-12', 'col-md-6', $output );
                        echo str_replace( '</div></div></div>', '</div>', $output );
                    }
                    if( is_str_contain( 'last_name', $key ) ) {
                        $field['return'] = true;
                        
                        $output = woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                        echo str_replace( '<div class="row form-row-last validate-required" id="billing_last_name_field"><div class="form-group"><div class="col-md-12">', '<div class="col-md-6 validate-required" id="billing_last_name_field">', $output );
                    }
                    else {
                        woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                    }
        
        	   endforeach;
            ?>
        
        	<?php do_action('woocommerce_after_checkout_billing_form', $checkout ); ?>
        
        	<?php if ( ! is_user_logged_in() && $checkout->enable_signup ) : ?>
        
        		<?php if ( $checkout->enable_guest_checkout ) : ?>
        
        			<p class="form-row form-row-wide create-account">
        				<input class="input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true) ?> type="checkbox" name="createaccount" value="1" /> <label for="createaccount" class="checkbox"><?php _e( 'Create an account?', 'woocommerce' ); ?></label>
        			</p>
        
        		<?php endif; ?>
        
        		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>
        
        		<?php if ( ! empty( $checkout->checkout_fields['account'] ) ) : ?>
        
        			<div class="create-account">
        
        				<p><?php _e( 'Create an account by entering the information below. If you are a returning customer please login at the top of the page.', 'woocommerce' ); ?></p>
        
        				<?php foreach ( $checkout->checkout_fields['account'] as $key => $field ) : ?>
        
        					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
        
        				<?php endforeach; ?>
        
        				<div class="clear"></div>
        
        			</div>
        
        		<?php endif; ?>
        
        		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
        
        	<?php endif; ?>

        </div>
    </div>
</div>