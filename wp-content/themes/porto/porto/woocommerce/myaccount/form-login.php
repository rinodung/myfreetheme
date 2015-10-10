<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.6
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<hr class="tall" />

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="row featured-boxes shop">
	<div class="col-md-6">
		<div class="featured-box default text-left">
			<div class="box-content">
        		<h4><?php _e( 'I\'m a Returning Customer', 'woocommerce' ); ?></h4>

        		<form method="post" class="login">

        			<?php do_action( 'woocommerce_login_form_start' ); ?>

        			<div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="username"><?php _e( 'Username or email address', 'woocommerce' ); ?> <span class="required">*</span></label>
                                <input type="text" class="form-control input-lg" name="username" id="username" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <a class="pull-right" href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
                                <label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                				<input class="form-control input-lg" type="password" name="password" id="password" />
                            </div>
                        </div>
                    </div>

        			<?php do_action( 'woocommerce_login_form' ); ?>

        			<div class="row">
						<div class="col-md-6">
							<span class="remember-box checkbox">
								<label for="rememberme">
									<label for="rememberme" class="inline">
                    					<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'woocommerce' ); ?>
                    				</label>
								</label>
							</span>
						</div>
						<div class="col-md-6">
							<input type="submit" class="btn btn-primary pull-right push-bottom" name="login" value="<?php _e( 'Login', 'woocommerce' ); ?>" />
						</div>
					</div>
                    
                    <?php wp_nonce_field( 'woocommerce-login' ); ?>

        			<?php do_action( 'woocommerce_login_form_end' ); ?>

        		</form>
            </div>
        </div>
    </div>

    <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	<div class="col-md-6">
		<div class="featured-box default text-left">
			<div class="box-content">

        		<h4><?php _e( 'Register An Account', 'woocommerce' ); ?></h4>

        		<form method="post" class="register">

        			<?php do_action( 'woocommerce_register_form_start' ); ?>

        			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

    				<div class="row">
						<div class="form-group">
							<div class="col-md-12">
                                <label for="reg_username"><?php _e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
                                <input type="text" class="form-control input-lg" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
							</div>
						</div>
					</div>
        			
                    <?php endif; ?>

        			<div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="reg_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
                                <input type="email" class="form-control input-lg" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
                            </div>
                        </div>
                    </div>

        			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

        				<div class="row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label for="reg_password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                                    <input type="password" class="form-control input-lg" name="password" id="reg_password" value="<?php if ( ! empty( $_POST['password'] ) ) echo esc_attr( $_POST['password'] ); ?>" />
                                </div>
                            </div>
                        </div>

        			<?php endif; ?>

        			<!-- Spam Trap -->
        			<div style="left:-999em; position:absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

        			<?php do_action( 'woocommerce_register_form' ); ?>
        			<?php do_action( 'register_form' ); ?>

        			<div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-primary pull-right push-bottom" name="register" value="<?php _e( 'Register', 'woocommerce' ); ?>" />
                            </div>
                        </div>
                    </div>
                    
                    <?php wp_nonce_field( 'woocommerce-register', 'register' ); ?>

        			<?php do_action( 'woocommerce_register_form_end' ); ?>

                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
