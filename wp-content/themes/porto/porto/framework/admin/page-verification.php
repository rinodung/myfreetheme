<?php

/**
 * Theme Vrifer
 *
 * This is theme verifeir admin page.
 *
 */

global $spyropress;

$values = wp_parse_args( $_REQUEST, array(
    'step'              => '',
    'envato_username'   => '',
    'envato_api_key'    => '',
    'envato_item_code'  => ''
) );
extract( $values );
$step = ( $step ) ? $step : 1;

if ( $spyropress->is_builder_verified ) {
    if ( !isset( $_GET['step'] ) && !isset( $_GET['force'] ) ) {
        return;
    }
}

if ( !isset( $_GET['force'] ) && $spyropress->is_builder_verified ) $step = 2;

if( isset( $_GET['force'] ) && 'reset' == $_GET['force'] ) {
    delete_option( '_spyropress_site_key_' . get_internal_name() );
    delete_option( '_spyropress_envato_verification_' . get_internal_name() );
    delete_option( '_spyropress_envato_username_' . get_internal_name() );
    delete_option( '_spyropress_envato_api_key_' . get_internal_name() );
}

/** Step 1 **/
if ( 1 == $step ) {
?>
<div id="welcome-panel" class="welcome-panel">
	<div class="welcome-panel-content">
		<h3>
			<?php _e( 'Welcome to SpyroPress! Update your Theme from the WordPress Dashboard', 'spyropress' ); ?>
		</h3>
		<p class="about-description">	
            <?php _e( 'If you want to get update notifications for your themes and if you want to be able to update your theme from your WordPress backend you need to enter your item purchase code, themeforest account name and themeforest secret API Key below:', 'spyropress' ); ?><br />
		</p>
        <br />
        <?php 
        if( !wp_is_writable( framework_path() ) ) {
            include_once 'page-status.php';
        }
        else {
        ?>
        <form method="post" style="width:80%" enctype="multipart/form-data" id="spyropress_form">
            <div class="section">
                <h3 class="heading"><?php _e( 'Themeforest Username', 'spyropress' ); ?></h4>
                <div class="controls">
                    <input class="field" type="text" value="<?php echo $envato_username; ?>" name="envato_username" placeholder="<?php esc_attr_e( 'Enter your marketplace username here', 'spyropress' ); ?>" />
                </div>
                <div class="description"><?php _e( 'Enter the Name of the User you used to purchase this theme', 'spyropress' ) ?></div>
            </div>
            <div class="section">
                <h3 class="heading"><?php _e( 'Themeforest API Key', 'spyropress' ); ?></h4>
                <div class="controls">
                    <input class="field" type="text" value="<?php echo $envato_api_key; ?>" name="envato_api_key" placeholder="<?php esc_attr_e( 'Enter your purchase code here', 'spyropress' ); ?>" />
                </div>
                <div class="description"><?php _e( 'Enter the API Key of your Account here.', 'spyropress' ) ?> <a target="_blank" href="http://cl.ly/TELt"><?php _e( 'You can find your it here', 'spyropress' ) ?></a></div>
            </div>
            <div class="section">
                <h3 class="heading"><?php _e( 'Item Purchase Code', 'spyropress' ); ?></h4>
                <div class="controls">
                    <input class="field" type="text" value="<?php echo $envato_item_code; ?>" name="envato_item_code" placeholder="<?php esc_attr_e( 'Enter your purchase code here', 'spyropress' ); ?>" />
                </div>
                <div class="description"><a target="_blank" href="http://cl.ly/TDtS"><?php _e('Where do I get my Item purchase Code?', 'spyropress') ?></a></div>
            </div>
            <div style="margin: 20px 0;">
                <?php wp_nonce_field( 'spyropress-verification', 'security' ); ?>
                <input class="button-xlarge button-green" value="<?php esc_attr_e('Verify', 'spyropress'); ?>" type="submit" />  
            </div>
        </form>
        <div class="clear"></div>
        <?php
        } ?>
	</div>
</div>
<?php
}
elseif( 2 == $step ) {
    echo '<div class="updated"><p>'.__( 'You are all set to go !.', 'spyropress' ).'</p></div>';
}