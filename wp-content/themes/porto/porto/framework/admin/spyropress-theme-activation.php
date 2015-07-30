<?php

/**
 * SpyroPress Theme Activation
 *
 * Theme activation script which adds default data
 *
 * @author 		SpyroSol
 * @category 	Admin
 * @package 	Spyropress
 */

/**
 * Install Spyropress
 */
function do_install_spyropress() {
    global $spyropress;

    // init custom taxonomies
    $spyropress->init_taxonomy();

    // flush rules
    flush_rewrite_rules();

    // Set already installed
    add_option( 'spyropress_installed_' . get_internal_name(), true );

    // Do developers hook there activation fucntions
    do_action( 'spyropress_theme_activated' );

    // Redirect
    wp_redirect( admin_url( 'admin.php?installed=true&page=spyropress' ) );
}

/**
 * Run the checker
 */
do_install_spyropress();

?>