<?php
/**
 * Edit account form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<h2 class="push-top"><?php the_title(); ?></h2>

<hr class="tall" />

<?php wc_print_notices(); ?>

<form action="" method="post">
    
    <?php do_action( 'woocommerce_edit_account_form_start' ); ?>
    
    <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <label for="account_first_name"><?php _e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label>
                <input type="text" class="form-control input-text" name="account_first_name" id="account_first_name" value="<?php esc_attr_e( $user->first_name ); ?>" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <label for="account_last_name"><?php _e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label>
                <input type="text" class="form-control input-text" name="account_last_name" id="account_last_name" value="<?php esc_attr_e( $user->last_name ); ?>" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <label for="account_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
                <input type="email" class="form-control input-text" name="account_email" id="account_email" value="<?php esc_attr_e( $user->user_email ); ?>" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <label for="password_1"><?php _e( 'Password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
                <input type="password" class="form-control input-text" name="password_1" id="password_1" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <label for="password_2"><?php _e( 'Confirm new password', 'woocommerce' ); ?></label>
                <input type="password" class="form-control input-text" name="password_2" id="password_2" />
            </div>
        </div>
    </div>
    
    <?php do_action( 'woocommerce_edit_account_form' ); ?>
    
    <br />
    <input type="submit" class="btn btn-lg btn-primary push-bottom" name="save_account_details" value="<?php _e( 'Save changes', 'woocommerce' ); ?>" />
    <?php wp_nonce_field( 'save_account_details' ); ?>
	<input type="hidden" name="action" value="save_account_details" />
</form>