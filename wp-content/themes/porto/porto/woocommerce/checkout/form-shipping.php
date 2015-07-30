<?php
/**
 * Checkout shipping information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php if ( WC()->cart->needs_shipping_address() === true ) : ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                Shipping Address
    		</a>
        </h4>
    </div>
    <div id="collapseTwo" class="accordion-body collapse">
        <div class="panel-body woocommerce-shipping-fields cts-wrapper">

            <?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

      		<?php
    			if ( empty( $_POST ) ) {

    				$ship_to_different_address = get_option( 'woocommerce_ship_to_billing' ) === 'no' ? 1 : 0;
    				$ship_to_different_address = apply_filters( 'woocommerce_ship_to_different_address_checked', $ship_to_different_address );

    			} else {

    				$ship_to_different_address = $checkout->get_value( 'ship_to_different_address' );

    			}
    		?>

            <div class="row">
                <div class="col-md-12">
				    <span class="remember-box checkbox">
                        <label for="ship-to-different-address-checkbox" class="checkbox">
                            <input id="ship-to-different-address-checkbox" class="input-checkbox" <?php checked( $ship_to_different_address, 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /><?php _e( 'Ship to a different address?', 'woocommerce' ); ?>
						</label>
				    </span>
				</div>
            </div>

            <?php
                foreach ( $checkout->checkout_fields['shipping'] as $key => $field ) :

                    if( is_str_contain( 'first_name', $key ) ) {
                        $field['return'] = true;
                        $output = woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                        $output = str_replace( 'col-md-12', 'col-md-6', $output );
                        echo str_replace( '</div></div></div>', '</div>', $output );
                    }
                    if( is_str_contain( 'last_name', $key ) ) {
                        $field['return'] = true;

                        $output = woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                        echo str_replace( '<div class="row form-row-last validate-required" id="shipping_last_name_field"><div class="form-group"><div class="col-md-12">', '<div class="col-md-6 validate-required" id="billing_last_name_field">', $output );
                    }
                    else {
                        woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                    }

        	   endforeach;
            ?>

            <?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>
        </div>
    </div>
</div>

<?php endif; ?>

<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', get_option( 'woocommerce_enable_order_comments', 'yes' ) === 'yes' ) ) : ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                <?php _e( 'Additional Information', 'woocommerce' ); ?>
    		</a>
        </h4>
    </div>
    <div id="collapseThree" class="accordion-body collapse">
        <div class="panel-body woocommerce-additional-fields">

		<?php foreach ( $checkout->checkout_fields['order'] as $key => $field ) : ?>

			<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

		<?php endforeach; ?>
        </div>
    </div>
</div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
