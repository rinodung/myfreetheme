<?php

/**
 * Theme Updater Page
 */
global $spyropress;

// Clear transients
delete_transient( '_spyropress_api_theme_updater' );
delete_transient( '_spyropress_api_framework_updater' );

// Theme Log    
$theme_log = spyropress_get_theme_changelog();
$is_theme_updateable = is_theme_updateable();
$theme_name = $spyropress->theme_name;
$theme_version = $spyropress->theme_version;

// Framework Log
$framework_log = spyropress_get_framework_changelog();

// Getting Filesystem intact
$method = get_filesystem_method();
$to = ABSPATH . 'wp-content/themes/' . get_option( 'template');

if ( isset( $_POST['password'] ) ) {
    $cred = $_POST;
    $filesystem = WP_Filesystem( $cred );
}
elseif ( isset( $_POST['spyropress_ftp_cred'] ) ) {
    $cred = spyropress_decode( $_POST['spyropress_ftp_cred'] );
    $filesystem = WP_Filesystem( $cred );
}
else
    $filesystem = WP_Filesystem();

$url = admin_url( 'admin.php?page=spyropress-update' );        
?>

<div class="wrap spyropress-wrap abs-badge">
<?php 
if ( false == $filesystem ) {
    request_filesystem_credentials( $url );
}
else {
    if( !$is_theme_updateable )
        get_spyropress_badge();
?>
    <div id="icon-themes" class="icon32"></div>
	<h1><?php _e( 'Theme Updates', 'spyropress' ); ?></h1>
    <h2 style="padding: 0;"></h2>
    <?php
        if( $is_theme_updateable )
            spyropress_get_theme_update_notice( $theme_name, $theme_version, $theme_log->latest );
        if( !$is_theme_updateable ) {
    ?>
        <h2><?php printf( __( 'The %1$s theme is currently up to date at version %2$s', 'spyropress' ), $theme_name, $theme_version ); ?></h2>
    <?php } else { // END IF ?>
        <img class="theme-update-screenshot" src="<?php echo get_template_directory_uri() .'/screenshot.png'; ?>" alt="" />
        <h3><?php _e( 'Update Download and Instructions', 'spyropress' ) ?></h3>
        <?php printf( __( '<p><strong>Important:</strong> make a backup of the %1$s theme inside your WordPress installation folder <code>%2$s </code> before attempting to update.</p>
        <p>If you didn`t make any changes to the theme files, you are free to overwrite them with the new files without risk of losing theme settings, pages, posts, etc, and backwards compatibility is guaranteed.</p>
        <p>If you have made changes to the theme files, you will need to compare your changed files to the new files and merge them together.</p>', 'spyropress' ), $theme_name, str_replace( site_url(), '', get_template_directory_uri() ) ); ?>
        
        <form method="post" enctype="multipart/form-data" id="spyropress_form">
            <?php wp_nonce_field( 'spyropress-update' ); ?>
            <input type="submit" class="button-large button-green" value="<?php esc_attr_e( 'Update Now', 'spyropress' ); ?>" />
            <input type="hidden" name="spyropress_updater" value="framework" />
            <input type="hidden" name="spyropress_ftp_cred" value="<?php echo esc_attr( spyropress_encode( $_POST ) ); ?>" />
        </form>
    <?php } // END ELSE ?>
    <br />
    <div class="spyropress-changelog clear">
        <div class="row-fluid">
            <div class="span6">
                <h2><strong><?php _e( 'Theme Changelog', 'spyropress' ); ?></strong></h2>
                <?php if ( !empty( $theme_log ) ) echo $theme_log->changelog; ?>
            </div>
            <div class="span6">
                <h2><strong><?php _e( 'Framework Changelog', 'spyropress' ); ?></strong></h2>
                <?php if ( !empty( $framework_log ) ) echo $framework_log->changelog; ?>
            </div>
        </div>
    </div>
<?php } ?>
</div>