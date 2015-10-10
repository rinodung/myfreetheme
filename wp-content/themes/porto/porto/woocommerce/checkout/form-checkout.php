<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo '<hr class="tall" />';

wc_get_template_part( 'checkout/header' );

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>

<div class="row">
    <div class="col-md-9">
        <form name="checkout" method="post" class="checkout" action="<?php echo esc_url( $get_checkout_url ); ?>">
            
            <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
                
            <div class="panel-group" id="accordion">
                
                <?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>
                
                    <?php do_action( 'woocommerce_checkout_billing' ); ?>
                
                    <?php do_action( 'woocommerce_checkout_shipping' ); ?>
        	
           		   <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
            
            	<?php endif; ?>
            
            	<?php do_action( 'woocommerce_checkout_order_review' ); ?>
            
            </div>
            
            <div class="actions-continue">
        
    			<noscript><?php _e( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the <em>Update Totals</em> button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ); ?><br/><input type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php _e( 'Update totals', 'woocommerce' ); ?>" /></noscript>
    
    			<?php wp_nonce_field( 'woocommerce-process_checkout' ); ?>
    
    			<?php do_action( 'woocommerce_review_order_before_submit' ); ?>
    
    			<?php
    			$order_button_text = apply_filters( 'woocommerce_order_button_text', __( 'Place order', 'woocommerce' ) );
    
    			echo apply_filters( 'woocommerce_order_button_html', '<input type="submit" class="btn btn-lg btn-primary push-top alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '" />' );
    			?>
    
    			<?php if ( wc_get_page_id( 'terms' ) > 0 && apply_filters( 'woocommerce_checkout_show_terms', true ) ) { 
    				$terms_is_checked = apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) );
    				?>
    				<p class="form-row terms">
    					<label for="terms" class="checkbox"><?php printf( __( 'I&rsquo;ve read and accept the <a href="%s" target="_blank">terms &amp; conditions</a>', 'woocommerce' ), esc_url( get_permalink( wc_get_page_id( 'terms' ) ) ) ); ?></label>
    					<input type="checkbox" class="input-checkbox" name="terms" <?php checked( $terms_is_checked, true ); ?> id="terms" />
    				</p>
    			<?php } ?>
    
    			<?php do_action( 'woocommerce_review_order_after_submit' ); ?>
    
    		</div>
        
        </form>
    </div>
    <div class="col-md-3">
        
        <?php woocommerce_cart_totals(); ?>
        
	</div>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>