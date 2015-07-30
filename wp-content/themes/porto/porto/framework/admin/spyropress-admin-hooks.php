<?php

/**
 * SpyroPress Admin Hooks
 *
 * Action/filter hooks used for SpyroPress functions
 *
 * @author 		SpyroSol
 * @category 	Admin
 * @package 	Spyropress
 *
 */
global $spyropress;

/** Email From and Name Filter ********************************************/
add_filter( 'wp_mail_from', 'spyropress_mail_from' );
add_filter( 'wp_mail_from_name', 'spyropress_mail_from_name' );

/** Hooks/Events **********************************************************/

// Theme Option Export
add_action( 'admin_init', 'spyropress_install_dummy_data', 1 );

// Theme Option Export
add_action( 'admin_init', 'spyropress_export_options', 4 );

// Skin Generator
add_action( 'init', 'spyropress_skin_generator', 1 );

// make custom fields and excerpt meta boxes show by default
add_filter( 'default_hidden_meta_boxes', 'spyropress_remove_default_metaboxes', 10, 2 );

// Media Uploader
add_filter( 'get_media_item_args', 'allow_img_insertion' );

// Add Wp-Editor to Widget Page
add_action( 'sidebar_admin_page', 'dummy_editor' );

// Setup Theme Options
add_action( 'spyropress_theme_activated', 'spyropress_setup_options', 5 );
add_action( 'spyropress_after_options_saved', 'spyropress_save_css', 10, 2 );

/** tiny_mce Options *****************************************************/

add_filter( 'tiny_mce_before_init', 'spyropress_change_mce_options' );
add_filter( 'mce_buttons_2', 'spyropress_enable_more_buttons' );
add_action( 'init', 'spyropress_init_tinymce_plugins' );

/** Custom Post Type Hooks *****************************************/

add_action( 'dashboard_glance_items', 'spyropress_right_now_content', 10 );