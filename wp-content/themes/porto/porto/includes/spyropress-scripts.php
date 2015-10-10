<?php

/**
 * Enqueue scripts and stylesheets
 *
 * @category Core
 * @package SpyroPress
 *
 */
add_action( 'init', 'spyropress_register_cf7', 11 );
function spyropress_register_cf7() {
    
    if( defined( 'WPCF7_VERSION' ) )
        wp_register_script( 'contact-form-7', assets_js() . 'contactform-script.js', array( 'jquery', 'jquery-form' ), WPCF7_VERSION, true );
    
    if( defined( 'WC_VERSION' ) )
        wp_register_script( 'wc-country-select', assets_js() . 'country-select' . '.js', array( 'jquery' ), WC_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'spyropress_deregister_cf7' );
function spyropress_deregister_cf7() {
    wp_dequeue_style( 'contact-form-7' );

	if ( function_exists( 'wpcf7_is_rtl' ) && wpcf7_is_rtl() ) {
		wp_dequeue_style( 'contact-form-7-rtl' );
	}
}

/**
 * Register StyleSheets
 */
function spyropress_register_stylesheets() {

    $options = get_post_meta( get_the_ID(), '_page_options', true );
    
    // Web Fonts
    $gurl = 'http' . ( is_ssl() ? 's' : '' ) . '://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light';
    wp_enqueue_style( 'google-fonts', $gurl );

    // Libs CSS
    wp_enqueue_style( 'bootstrap', assets() . 'vendor/bootstrap/bootstrap.css' );
    wp_enqueue_style( 'font-awesome', assets() . 'vendor/fontawesome/css/font-awesome.css' );
    wp_enqueue_style( 'owl-carousel', assets() . 'vendor/owlcarousel/owl.carousel.min.css' );
    wp_enqueue_style( 'owl-carousel-theme', assets() . 'vendor/owlcarousel/owl.theme.default.min.css' );
    wp_enqueue_style( 'magnific-popup', assets() . 'vendor/magnific-popup/magnific-popup.css' );
    wp_enqueue_style( 'jquery-isotope', assets() . 'vendor/isotope/jquery.isotope.css' );
    wp_enqueue_style( 'nivoslider', assets() . 'vendor/nivo-slider/nivo-slider.css' );
    wp_enqueue_style( 'nivo-theme', assets() . 'vendor/nivo-slider/themes/default/default.css' );
    wp_enqueue_style( 'circle-flip-slideshow', assets() . 'vendor/circle-flip-slideshow/css/component.css' );
    
    //if( isset( $options['rev_slider_skin'] ) && !is_str_contain( 'video', $options['rev_slider_skin'] ) ) {
        wp_enqueue_style( 'mediaelementplayer', assets() . 'vendor/mediaelement/mediaelementplayer.css' );
    //}
    
    // Theme CSS
    wp_enqueue_style( 'theme', assets_css() . 'theme.css' );
    wp_enqueue_style( 'theme-elements', assets_css() . 'theme-elements.css' );
    wp_enqueue_style( 'theme-blog', assets_css() . 'theme-blog.css' );
    
    if( current_theme_supports( 'woocommerce' ) )
        wp_enqueue_style( 'theme-shop', assets_css() . 'theme-shop.css' );
    
    wp_enqueue_style( 'theme-spyropress', assets_css() . 'theme-spyropress.css' );
    wp_enqueue_style( 'theme-animate', assets_css() . 'theme-animate.css' );
    
    // Skin
    if( !current_theme_supports( 'theme-demo' ) ) {
        wp_enqueue_style( 'skin', assets_css() . 'skins/' . get_setting( 'theme_skin', 'blue' ) . '.css' );
    }
    
    wp_enqueue_style( 'main', child_url() . 'style.css' );
    
    // Custom CSS
    wp_enqueue_style( 'custom-theme', child_url() . 'assets/css/custom.css', false );
    
    // Dynamic StyleSheet
    if ( file_exists( dynamic_css_path() . 'dynamic.css' ) )
        wp_enqueue_style( 'dynamic', dynamic_css_url() . 'dynamic.css', false, '2.0.0' );

    // Builder StyleSheet
    if ( file_exists( dynamic_css_path() . 'builder.css' ) )
        wp_enqueue_style( 'builder', dynamic_css_url() . 'builder.css', false, '2.0.0' );

    // modernizr
    wp_enqueue_script( 'modernizr', assets() . 'vendor/modernizr/modernizr.js', array( 'jquery' ), '2.8.3', false );
}

/**
 * Enqueque Scripts
 */
function spyropress_register_scripts() {

    $options = get_post_meta( get_the_ID(), '_page_options', true );
    
    /**
     * Register Scripts
     */
    // threaded comments
    if ( is_single() && comments_open() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

    // Plugins
    wp_register_script( 'bootstrap', assets() . 'vendor/bootstrap/bootstrap.js', false, false, true );
    wp_register_script( 'theme-common', assets() . 'vendor/common/common.js', false, false, true );
    wp_register_script( 'jquery-appear', assets() . 'vendor/jquery.appear/jquery.appear.js', false, false, true );
    wp_register_script( 'jquery-cookie', assets() . 'vendor/jquery-cookie/jquery-cookie.js', false, false, true );
    wp_register_script( 'jquery-easing', assets() . 'vendor/jquery.easing/jquery.easing.js', false, false, true );
    wp_register_script( 'jquery-easy-pie-chart', assets() . 'vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.js', false, false, true );
    wp_register_script( 'jquery-flipshow', assets() . 'vendor/circle-flip-slideshow/js/jquery.flipshow.js', false, false, true );
    wp_register_script( 'jquery-isotope', assets() . 'vendor/isotope/jquery.isotope.js', false, false, true );
    wp_register_script( 'jquery-jflickrfeed', assets() . 'vendor/jflickrfeed/jflickrfeed.js', false, false, true );
    wp_register_script( 'jquery-magnific', assets() . 'vendor/magnific-popup/jquery.magnific-popup.js', false, false, true );
    wp_register_script( 'jquery-owl-carousel', assets() . 'vendor/owlcarousel/owl.carousel.js', false, false, true );
    wp_register_script( 'jquery-stellar', assets() . 'vendor/jquery.stellar/jquery.stellar.js', false, false, true );
    wp_register_script( 'jquery-validate', assets() . 'vendor/jquery.validation/jquery.validation.js', false, false, true );
    wp_register_script( 'jquery-vide', assets() . 'vendor/vide/jquery.vide.js', false, false, true );
    wp_register_script( 'nivoslider', assets() . 'vendor/nivo-slider/jquery.nivo.slider.js', false, false, true );
    wp_register_script( 'style-switcher', assets() . 'master/style-switcher/style.switcher.js', false, false, true );
    wp_register_script( 'theme', assets() . 'js/theme.js', false, false, true );
    wp_register_script( 'theme-init', assets() . 'js/theme.init.js', false, false, true );
    //wp_register_script( 'twitterjs', assets() . 'vendor/twitterjs/twitter.js', false, false, true );    
    
    
    $deps = array(
        'jquery-appear',
        'jquery-easing',
        'jquery-cookie'
    );
    
    if( current_theme_supports( 'theme-demo' ) ) {
        $deps[] = 'style-switcher';
    }
    
    $deps = array_merge( $deps, array(
        'bootstrap',
        'theme-common',
        'jquery-validate',
        'jquery-stellar',
        'jquery-easy-pie-chart',
        'jquery-owl-carousel',
        'jquery-jflickrfeed',
        'jquery-flipshow',
        'jquery-magnific',
        'nivoslider',
        'jquery-vide'
    ));
    
    // contact form 7
    if( defined( 'WPCF7_VERSION' ) ) {
        $deps[] = 'contact-form-7';
    }
    
    $deps[] = 'theme';
    $deps[] = 'theme-init';
    
    // custom scripts
    wp_register_script( 'custom-script', assets_js() . 'custom.js', $deps, '2.8', true );

    /**
     * Enqueue All
     */
    wp_enqueue_script( 'custom-script' );
    
    $ajax_loader = function_exists( 'wpcf7_ajax_loader' ) ? wpcf7_ajax_loader() : '';
    $theme_settings = array(
        'ajaxURL' => admin_url( 'admin-ajax.php' ),
        'twitter_feed' => admin_url( 'admin-ajax.php?action=spyropress_twitter_tweets' ),
		'sending' => __( 'Sending ...', 'wpcf7' ),
        'assets' => assets(),
        'is_sticky' => get_setting( 'sticky_header', '' )
    );
    
    wp_localize_script( 'jquery-easing', 'theme_settings', $theme_settings );
}

function spyropress_conditional_scripts() {

    $content = '
  		<!--[if IE]>
			<link rel="stylesheet" href="' . assets_css() . 'ie.css">
		<![endif]-->

		<!--[if lte IE 8]>
			<script src="' . assets() . 'vendor/respond/respond.js"></script>
            <script src="' . assets() . 'vendor/excanvas/excanvas.js"></script>
		<![endif]-->';

    echo get_relative_url( $content );
}