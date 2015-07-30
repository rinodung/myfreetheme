<?php

/**
 * SpyroPress is a theme framework for professional WordPress theme designing developed by SpyroSol.
 *
 * DON'T HACK ME!! You should NOT modify the SpyroPress theme framework to avoid issues with updates in the future.
 * It's designed to offer cutting edge flexibility - with lots of ways to manipulate output!
 *
 * @package SpyroPress
 */

//set_time_limit( 600 );

/**
 * Set Max Content Width
 */
if ( ! isset( $content_width ) )
    $content_width = 780;

if( !function_exists( 'spyropress_content_width' ) ) {
    function spyropress_content_width() {
        if( is_page_template( 'template-full-width.php' ) || is_attachment() ) {
            global $content_width;
            $content_width = 960;
        }
    }
}
add_action( 'template_redirect', 'spyropress_content_width' );

/**
 * Starting SpyroPress Engine
 */
load_template( get_template_directory() . '/framework/spyropress.php', true );
load_template( get_template_directory() . '/includes/init.php', true ); // Extending theme
load_template( get_template_directory() . '/includes/woocommerce-init.php', true ); // Extending WooCommerce

/**
 * Add theme support for spyropress framework features
 */
add_action( 'after_setup_theme', 'spyropress_theme_setup', 4 );
function spyropress_theme_setup() {

    // Add wordpress features
    add_theme_support( 'automatic-feed-links' );

    // Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
    add_theme_support( 'post-thumbnails' );
    
    // Tell the TinyMCE editor to use a custom stylesheet
    add_editor_style( assets_css() . 'editor-style.css' );
    
    // Root Relative Urls Support
    add_theme_support( 'relative-urls' );

    // SpyroPress Builder
    add_theme_support( 'spyropress-builder' );
    
    //Shortcode Generator
    add_theme_support( 'spyropress-shortcode-generator' );
	
	// Custom CSS Editor
    add_theme_support( 'spyropress-ace' );
    
    // Post Formats
    add_theme_support( 'post-formats', array(
        'gallery',
        'image',
        'quote',
        'video',
        'audio'
    ) );

    // WooCommerce
    add_theme_support( 'woocommerce' );

    // Add Components
    add_theme_support( 'spyropress-components', array(
        'bucket',
        'faqs',
        'portfolio',
        'pricing-table',
        'slider',
        'staff',
        'testimonials',
        'page',
        'post',
        'mega-menu',
		'bootstrap-nav',
        'pagination'
    ) );

    // Add Sliders
    $sliders = array(
        'nivo' => __( 'Nivo Slider', 'spyropress' ),
    );
    add_theme_support( 'spyropress-sliders', $sliders );

    // Add Menus
    add_theme_support( 'spyropress-core-menus', array(
        'primary' => 'MainMenu',
        'secondary' => 'TopMenu',
        'footer' => 'Footer',
        'page-404' => 'Useful',
        'sitemap' => 'MainMenu'
    ) );

    // Add Sidebars
    $sidebars = array(
        'page' => array(
            'name' => __( 'Page', 'spyropress' ),
            'description' => __( 'Sidebar loads on pages.', 'spyropress' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div><hr />',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>'
        ),
        'blog' => array(
            'name' => __( 'Blog', 'spyropress' ),
            'description' => __( 'Sidebar loads on blog page.','spyropress' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div><hr />',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>'
        ),
        'woocomerce' => array(
            'name' => __( 'WooCommerce', 'spyropress' ),
            'description' => __( 'Sidebar loads on WooCommerce pages.','spyropress' ),
            'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget' => '</div><hr />',
            'before_title' => '<h5>',
            'after_title' => '</h5>'
        ),
        'footer-1' => array(
            'name' => __( 'Footer 1', 'spyropress' ),
            'description' => __( 'A widget area loaded in the footer of the site.', 'spyropress' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>'
        ),
        'footer-2' => array(
            'name' => __( 'Footer 2', 'spyropress' ),
            'description' => __( 'A widget area loaded in the footer of the site.', 'spyropress' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>'
        ),
        'footer-3' => array(
            'name' => __( 'Footer 3', 'spyropress' ),
            'description' => __( 'A widget area loaded in the footer of the site.', 'spyropress' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>'
        ),
        'footer-4' => array(
            'name' => __( 'Footer 4', 'spyropress' ),
            'description' => __( 'A widget area loaded in the footer of the site.', 'spyropress' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>'
        ),
        'footer-5' => array(
            'name' => __( 'Footer 5', 'spyropress' ),
            'description' => __( 'A widget area loaded in the footer of the site.', 'spyropress' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h5 class="widget-title">',
            'after_title' => '</h5>'
        ),
    );
    add_theme_support( 'spyropress-core-sidebars', $sidebars );

    // Options
    $options = array(
        'theme' => array(
            'page_title' => __( 'Theme Options', 'spyropress' ),
            'menu_title' => __( 'Theme Options', 'spyropress' ),
            'isactive' => true,
            'hidden' => false
        )
    );
    add_theme_support( 'spyropress-options', $options );
}
