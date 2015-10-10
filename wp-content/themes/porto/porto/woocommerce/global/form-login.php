<?php
/**
 * Login form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( is_user_logged_in() ) 
	return;
?>
<div class="featured-boxes login collapse fade" id="checkout-login-form">
	<div class="featured-box featured-box-secundary default">
		<div class="box-content">
			<h4>I'm a Returning Customer</h4>
			<form method="post" <?php if ( $hidden ) echo 'style="display:none;"'; ?>>
				
                <?php do_action( 'woocommerce_login_form_start' ); ?>
                
                <?php if ( $message ) echo wpautop( wptexturize( $message ) ); ?>
                
                <div class="row">
					<div class="form-group">
						<div class="col-md-12">
							<label for="username"><?php _e( 'Username or email', 'woocommerce' ); ?> <span class="required">*</span></label>
                            <input type="text" class="form-control" name="username" id="username" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<div class="col-md-12">
							<a class="pull-right" href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
							<label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                            <input class="form-control" type="password" name="password" id="password" />
						</div>
					</div>
				</div>
                
                <?php do_action( 'woocommerce_login_form' ); ?>
                
				<div class="row">
					<div class="col-md-6">
						<span class="remember-box checkbox">
							<label for="rememberme">
								<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'woocommerce' ); ?>
							</label>
						</span>
					</div>
					<div class="col-md-6">
                        <?php wp_nonce_field( 'woocommerce-login' ); ?>
						<input type="submit" value="<?php _e( 'Login', 'woocommerce' ); ?>" class="btn btn-primary pull-right push-bottom" data-loading-text="Loading...">
                        <input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />
					</div>
				</div>
                
                <?php do_action( 'woocommerce_login_form_end' ); ?>
                
			</form>
		</div>
	</div>
</div>