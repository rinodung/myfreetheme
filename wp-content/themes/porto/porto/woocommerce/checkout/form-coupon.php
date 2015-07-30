<?php
/**
 * Checkout coupon form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! WC()->cart->coupons_enabled() ) {
	return;
}

$info_message = apply_filters( 'woocommerce_checkout_coupon_message', __( 'Have a coupon?', 'woocommerce' ) . ' <a href="#" class="showcoupon">' . __( 'Click here to enter your code', 'woocommerce' ) . '</a>' );
wc_print_notice( $info_message, 'notice' );
?>

<form class="checkout_coupon row" method="post" style="display:none">
    <div class="form-group">
        <div class="col-md-6">
            <input type="text" name="coupon_code" class="form-control" placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
        </div>
        <div class="col-md-6">
            <input type="submit" class="btn btn-lg btn-default" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'woocommerce' ); ?>" />
        </div>
    </div>
</form>
<div class="clear"></div>