<?php

/**
 * SpyroPress Theme Verifier
 * Verify theme against spyropress database and themeforest and install SpyroBuilder and SpyroTempalteBuilder.
 *
 * @author 		SpyroSol
 * @category 	Admin
 * @package 	Spyropress
 */

class SpyropressThemeVerifier {

    function __construct() {
        add_action( 'admin_head', array( $this, 'verify_theme' ) );
    }

    function verify_theme() {

        if ( isset( $_REQUEST['page'] ) ) {

            // Sanitize page being requested.
            $_page = esc_attr( $_REQUEST['page'] );
            
            if ( 'spyropress' == $_page && isset( $_REQUEST['security'] ) &&
                check_admin_referer( 'spyropress-verification', 'security' ) )
            {
                global $spyropress;
                
                $step = ( isset( $_GET['step'] ) ) ? $_GET['step'] : '';
                $step = ( $step ) ? $step : 1;
                if ( !isset( $_GET['force'] ) && $spyropress->is_builder_verified ) $step = 2;
                
                $field_method = 'verify_theme_step' . $step;
                call_user_func( array( $this, $field_method ) );
            }
        }
    }

    function verify_theme_step1() {
        $_username = esc_attr( $_REQUEST['envato_username'] );
        $_code = esc_attr( $_REQUEST['envato_item_code'] );
        $_api_key = esc_attr( $_REQUEST['envato_api_key'] );
        
        $error = false;
        
        // Check for error
        if ( empty( $_username ) || empty( $_code ) ) {
            add_error_section( __( 'Enter envato marketplace username and item purchase code to verify.', 'spyropress' ) );
            $error = true;
        }

        if ( empty( $_username ) ) {
            add_error_message( __( 'Enter envato marketplace username to verify.', 'spyropress' ) );
            $error = true;
        }

        if ( empty( $_code ) ) {
            add_error_message( __( 'Enter item purchase code to verify.', 'spyropress' ) );
            $error = true;
        }

        if ( $error ) return;
            
        update_option( '_spyropress_site_key_' . get_internal_name(), md5( home_url() . $_code ) );
        update_option( '_spyropress_envato_verification_' . get_internal_name(), $_code );
        update_option( '_spyropress_envato_username_' . get_internal_name(), $_username );
        update_option( '_spyropress_envato_api_key_' . get_internal_name(), $_api_key );

        add_notice_message( __( 'Redirecting...', 'spyropress' ) .
        '<script type="text/javascript">
        //<![CDATA[
            window.location.replace("' . admin_url( 'admin.php?page=spyropress&step=4' ) .
            '");
        //]]>
        </script>' );
    }
}
?>