<?php
/**
 * Form for Menus
 */
if ( ! is_user_logged_in() ) :
?>

<li class="dropdown mega-menu-item mega-menu-signin signin" id="headerAccount">
	<a class="dropdown-toggle" href="<?php echo $item->url;?>">
		<i class="icon icon-user"></i>  <?php echo apply_filters( 'the_title', $item->title, $item->ID ); ?>
		<i class="icon icon-angle-down"></i>
	</a>
    <ul class="dropdown-menu">
        	<li>
        	   <div class="mega-menu-content">
				    <div class="row">
					   <div class="col-md-12">
                            <div class="signin-form">
							<span class="mega-menu-sub-title"><?php _e( 'Sign In', 'spyropress' ) ?></span>
                            <form name="loginform" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ) ?>" method="post">
                                <?php apply_filters( 'login_form_top', '', $args ); ?>
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label for="user_login"><?php _e( 'Username or E-mail Address' , 'spyropress' ) ?></label>
											<input type="text" name="log" id="user_login" value="" class="form-control input-lg">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<a class="pull-right" id="headerRecover" href="<?php echo esc_url( wp_lostpassword_url() ) ?>"><?php _e( '(Lost Password?)', 'spyropress' ) ?></a>
											<label for="user_pass"><?php _e( 'Password', 'spyropress' ) ?></label>
											<input type="password" name="pwd" id="user_pass" value="" class="form-control input-lg">
										</div>
									</div>
								</div>
                                <?php apply_filters( 'login_form_middle', '', $args ) ?>
								<div class="row">
									<div class="col-md-6">
										<span class="remember-box checkbox">
											<label for="rememberme">
												<input type="checkbox" id="rememberme" name="rememberme"><?php _e( 'Remember Me', 'spyropress' ) ?>
											</label>
										</span>
									</div>
									<div class="col-md-6">
										<input type="submit" name="wp-submit" id="wp-submit" value="<?php esc_attr_e( 'Login', 'spyropress') ?>" class="btn btn-primary pull-right push-bottom" data-loading-text="<?php _e( 'Loading...', 'spyropress' ) ?>">
									   <input type="hidden" name="redirect_to" value="<?php echo ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
                                    </div>
								</div>
                                <?php apply_filters( 'login_form_bottom', '', $args ) ?>
							</form>
							<p class="sign-up-info"><?php _e( 'Don\' t have an account yet?', 'spyropress' ) ?> <a href="#" id="headerSignUp"><?php _e( 'Sign Up!', 'spyropress' ) ?></a></p>
						</div>
                        <!---Sign up form----->
                        <?php
                        
                        $registration_redirect = ! empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';
                        $redirect_to = apply_filters( 'registration_redirect', $registration_redirect );
                        ?>
                        <div class="signup-form">
							<span class="mega-menu-sub-title"><?php _e( 'Create Account', 'spyropress' ) ?></span>
							<form name="registerform" id="registerform" action="<?php echo esc_url( site_url('wp-login.php?action=register', 'login_post') ); ?>"  method="post">
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label for="user_login"><?php _e( 'Username', 'spyropress' ) ?></label>
											<input name="user_login" id="user_login" type="text" value="" class="form-control input-lg">
										</div>
									</div>
								</div>
                                <div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label for="user_email"><?php _e( 'E-mail Address', 'spyropress' ) ?></label>
											<input name="user_email" id="user_email" type="text" value="" class="form-control input-lg">
										</div>
									</div>
								</div>
                                <?php do_action( 'register_form' ); ?>
								<div class="row">
									<div class="col-md-12">
										<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
                                        <input type="submit" value="<?php esc_attr_e( 'Create Account', 'spyropress' ) ?>" class="btn btn-primary pull-right push-bottom" data-loading-text="<?php esc_attr_e( 'Loading...', 'spyropress' ) ?>">
									</div>
								</div>
							</form>
							<p class="log-in-info"><?php _e( 'Already have an account?' , 'spyropress' ) ?> <a href="#" id="headerSignIn"><?php _e( 'Log In!' , 'spyropress' ) ?></a></p>
						</div>
                        <!-- Lost Password -->
                        <?php
                        $lostpassword_redirect = ! empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';
                        $redirect_to = apply_filters( 'lostpassword_redirect', $lostpassword_redirect );
                        ?>
                        <div class="recover-form">
    						<span class="mega-menu-sub-title"><?php _e( 'Reset My Password' ,'spyropress' ) ?></span>
    						<p><?php _e( 'Complete the form below to receive an email with the authorization code needed to reset your password.' ,'spyropress' ) ?></p>
                            <form name="lostpasswordform" id="lostpasswordform" action="<?php echo esc_url( site_url( 'wp-login.php?action=lostpassword', 'login_post' ) ); ?>" method="post">
    							<div class="row">
    								<div class="form-group">
    									<div class="col-md-12">
    										<label for="user_login"><?php _e( 'Username or E-mail' ,'spyropress' ) ?></label>
    										<input name="user_login" type="text" value="" id="user_login" class="form-control input-lg">
    									</div>
    								</div>
    							</div>
                                <?php do_action( 'lostpassword_form' ); ?>
    							<div class="row">
    								<div class="col-md-12">
                                        <input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
    									<input type="submit" name="wp-submit" value="<?php esc_attr_e( 'Submit', 'spyropress' ) ?>" class="btn btn-primary pull-right push-bottom" data-loading-text="<?php esc_attr_e( 'Loading...', 'spyropress' ) ?>">
    								</div>
    							</div>
    						</form>
    						<p class="log-in-info"><?php _e( 'Already have an account?' ,'spyropress' ) ?> <a href="#" id="headerRecoverCancel"><?php _e( 'Log In!' ,'spyropress' ) ?></a></p>
					   </div>
                    </div>
				</div>
			</div>
		</li>
	</ul>
</li>
<?php
else :
    global $current_user;
    get_currentuserinfo();
    $roles = array();
    foreach ( $current_user->roles as $role ) {
        $roles [] = $role;
    }
    
    // WooCommerce Overrides
    if ( class_exists( 'WooCommerce' ) ) {
        $url = get_permalink( get_option('woocommerce_myaccount_page_id') );
    }
    else {
        $url = get_edit_user_link( $current_user->user_id );
    }
?>
<li class="dropdown mega-menu-item mega-menu-signin signin logged" id="headerAccount">
	<a class="dropdown-toggle" href="<?php echo $item->url; ?>">
		<i class="icon icon-user"></i> <?php echo $current_user->display_name ?>
		<i class="icon icon-angle-down"></i>
	</a>
	<ul class="dropdown-menu">
		<li>
			<div class="mega-menu-content">
				<div class="row">
					<div class="col-md-8">
						<div class="user-avatar">
							<div class="img-thumbnail">
                                <?php echo get_avatar( get_the_author_meta( $current_user->user_email ), '55' ) ?>
							</div>
							<p><strong><?php echo $current_user->display_name ?></strong><span><?php echo join( ',' , $roles ) ?></span></p>
						</div>
					</div>
					<div class="col-md-4">
						<ul class="list-account-options">
							<li>
								<a href="<?php echo $url ?>"><?php _e( 'My Account', 'spyropress' ) ?></a>
							</li>
							<li>
								<a href="<?php echo esc_url( wp_logout_url( get_home_url() ) ) ?>"><?php _e( 'Log Out', 'spyropress' ) ?></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</li>
	</ul>
</li>
<?php endif; ?>