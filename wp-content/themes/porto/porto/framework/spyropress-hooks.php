<?php

/**
 * SpyroPress Hooks
 * Action/filter hooks used for SpyroPress functions/templates
 *
 * @category Core
 * @package SpyroPress
 *
 */

/** WordPress Hooks ********************************************************/

/** Improved Excerpt **/
remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
add_filter( 'get_the_excerpt', 'spyropress_get_excerpt' );

/** Post Hooks **/
add_filter( 'post_class', 'spyropress_entry_class' );
add_action( 'wp_head', 'spyropress_set_post_views', 25 );
add_action( 'get_header', 'spyropress_set_post_views_cookies' );

/** SpyroPress Hooks ********************************************************/

/** Add elements and meta to <head> area **/
add_action( 'spyropress_head', 'display_meta_title', 1 );
add_action( 'spyropress_head', 'display_meta_tags', 2 );
add_action( 'spyropress_head', 'spyropress_register_stylesheets', 11 );
add_action( 'spyropress_head', 'spyropress_register_scripts', 11 );

add_action( 'wp_head', 'spyropress_head', 0 );
add_action( 'wp_head', 'spyropress_fav_touch_icons' );
add_action( 'wp_head', 'spyropress_output_dynamic_css' );
add_action( 'wp_head', 'spyropress_conditional_scripts', 11 );

/** Content Wrapper **/
add_action( 'spyropress_wrapper', 'spyropress_page_wrapper', 1 );
add_action( 'spyropress_wrapper_end', 'spyropress_page_wrapper_end', 1 );

/** Header Hooks **/
add_action( 'spyropress_before_header', 'display_browser_happy', 1 );

/** Footer Hooks **/
add_action( 'spyropress_footer', 'output_credit', 99 );
add_action( 'wp_footer', 'output_tracking_code', 99 );

add_filter( 'wp_link_pages_link', 'wp_link_pages_link_active' );
?>