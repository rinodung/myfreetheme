<?php

/**
 * SpyroPress API
 * Main file for all the api calls.
 *
 * @author 		SpyroSol
 * @category 	Core
 * @package 	Spyropress
 * @todo Requires a complete redo.
 */

class SpyropressThemeUpdater {

    function __construct() {

        add_action( 'admin_head', array( $this, 'update_theme' ) );
    }

    function update_theme() {

        if ( isset( $_REQUEST['page'] ) ) {
            // Sanitize page being requested.
            $_page = esc_attr( $_REQUEST['page'] );

            if ( 'spyropress-update' == $_page ) {
                //Setup Filesystem
                $method = get_filesystem_method();

                if ( isset( $_POST['spyropress_ftp_cred'] ) ) {
                    $cred = spyropress_decode( $_POST['spyropress_ftp_cred'] );
                    $filesystem = WP_Filesystem( $cred );
                }
                else {
                    $filesystem = WP_Filesystem();
                }

                if ( false == $filesystem && 'Proceed' != $_POST['upgrade'] ) {
                    add_error_message( sprintf( __( 'Failed: Filesystem preventing downloads. (%s)', 'spyropress' ), $method ) );
                    return;
                }

                if ( isset( $_REQUEST['spyropress_updater'] ) ) {

                    // Sanitize action being requested.
                    $_action = esc_attr( $_REQUEST['spyropress_updater'] );

                    if ( 'framework' == $_action ) {

                        locate_template( 'framework/utilities/envato/class-envato-wordpress-theme-upgrader.php', true );
                        
                        $envato_api_key = get_option( '_spyropress_envato_api_key_' . get_internal_name() );
                        $envato_username = get_option( '_spyropress_envato_username_' . get_internal_name() );
                        
                        $upgrader = new Envato_WordPress_Theme_Upgrader( $envato_username, $envato_api_key );
                        $result = $upgrader->upgrade_theme();
                        
                        // Successfully Updated
                        if( $result->success ) {
                            $message = __( 'New version successfully downloaded, extracted and updated.', 'spyropress' );
                            $message .= '<script type="text/javascript">
                                //<![CDATA[
                                    window.location.replace("' . admin_url( 'admin.php?page=spyropress-update' ) .
                                '");
                                //]]>
                            </script>';
                            add_success_message( $message );
                        }
                        else {
                            add_error_message( $result->errors[0] );
                        }
                    }
                }

            } // END UPDATE HERE
        }
    }
}

?>