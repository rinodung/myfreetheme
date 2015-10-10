<?php

/**
 * Spyropress Core Functions
 * Functions available on both the front-end and admin.
 *
 * @category Core
 * @package SpyroPress
 *
 */

/** Include Utility Functions **************************************************************/
require_once ( 'utilities/wp.php' );
require_once ( 'utilities/string_numbers.php' );
require_once ( 'utilities/array.php' );
require_once ( 'utilities/options_settings.php' );

// Token Replacer
function token_repalce( $tmpl, $values ) {
    $data = $tmpl;
    preg_match_all( '/\{(.*?)\}/i', $tmpl, $matches );

    foreach ( $matches[1] as $token ) {
        $key = "{{$token}}";
        $value = isset( $values[$token] ) ? $values[$token] : '';
        $data = str_replace( $key, $value, $data );
    }

    return $data;
}

/** SpyroPress Panel Methods *****************************************************/

/**
 * Get Setting
 *
 * Get setting value from registered option array and clean it
 */
function get_setting( $item_id = '', $default = '', $is_array = false, $offset = -1 ) {
    return get_option_value( $item_id, $default, false, $is_array, $offset );
}
function get_setting_e( $item_id = '', $default = '', $is_array = false, $offset = -1 ) {
    get_option_value( $item_id, $default, true, $is_array, $offset );
}
function get_setting_array( $item_id = '', $default = '', $echo = false, $offset = -1 ) {
    return get_option_value( $item_id, $default, $echo, true, $offset );
}

/**
 * Get option value
 *
 * Functions get the option value from registered option array() and clean it
 */
function get_option_value( $item_id, $default, $echo, $is_array, $offset ) {
    global $spyropress;

    // Check if no option then get them
    if ( ! $spyropress->options )
        $spyropress->setup_options();

    $value = '';

    // Loop through all registered option head
    foreach ( $spyropress->options as $k => $options ) {
        if ( isset( $options[$item_id] ) && ! empty( $options[$item_id] ) ) {
            $value = $options[$item_id];
            break;
        }
    }

    // no value return
    if ( empty( $value ) ) {
        $content = $default;
    }
    else {
        
        // set content value & strip slashes
        $content = spyropress_stripslashes( $value );
    
        // is an array
        if ( true == $is_array ) {
            // saved as a comma seperated lists of values, explode into an array
            if ( ! is_array( $content ) )
                $content = explode( ',', $content );
    
            // get an array value using an offset
            if ( is_numeric( $offset ) && $offset >= 0 )
                $content = $content[$offset];
        }
        // not an array
        elseif ( false == $is_array ) {
            // saved as array, implode and return a comma seperated lists of values
            if ( is_array( $content ) )
                $content = implode( ',', $content );
        }
        
        $content = ( $content != '' ) ? $content : $default;
    }

    // echo content
    if ( ! $echo ) return $content;

    echo $content;
}

/**
 * Custom Stripslashes
 */
function spyropress_stripslashes( $input ) {

    if ( is_array( $input ) ) {
        foreach ( $input as &$val ) {
            if ( is_array( $val ) ) {
                $val = spyropress_stripslashes( $val );
            }
            else {
                $val = stripslashes( trim( $val ) );
            }
        }
    }
    else {
        $input = stripslashes( trim( $input ) );
    }
    return $input;
}

/** Path and URI Helper Functions *****************************************************/

// Path helper functions
function admin_path() { global $spyropress; return $spyropress->framework_path . 'admin/'; }
function framework_classes() { global $spyropress; return $spyropress->framework_path . 'classes/'; }
function framework_path() { global $spyropress; return $spyropress->framework_path; }
function template_path() { global $spyropress; return $spyropress->template_path; }
function include_path() { global $spyropress; return $spyropress->includes_path; }
function child_path() { global $spyropress; return $spyropress->child_path; }
function dynamic_css_path() {
    
    if( !is_multisite() ) return template_path() . 'assets/css/';
    
    $upload_info = wp_upload_dir();
    return trailingslashit( $upload_info['basedir'] ) . 'css/';
}

// URI helper functions
function child_url() { global $spyropress; return $spyropress->child_url; }
function framework_url() { global $spyropress; return $spyropress->framework_url; }
function template_url() { global $spyropress; return $spyropress->template_url; }
function include_url() { global $spyropress; return $spyropress->includes_url; }
function framework_assets_css() { global $spyropress; return $spyropress->framework_url . 'assets/css/'; }
function framework_assets_img() { global $spyropress; return $spyropress->framework_url . 'assets/img/'; }
function framework_assets_js() { global $spyropress; return $spyropress->framework_url . 'assets/js/'; }
function assets( $file = '' ) { global $spyropress; return $spyropress->template_url . 'assets/' . $file; }
function assets_css( $file = '' ) { global $spyropress; return $spyropress->template_url . 'assets/css/' . $file; }
function assets_img( $file = '' ) { global $spyropress; return $spyropress->template_url . 'assets/img/' . $file; }
function assets_js( $file = '' ) { global $spyropress; return $spyropress->template_url . 'assets/js/' . $file; }
function assets_e( $file = '' ) { echo assets( $file ); }
function assets_css_e( $file = '' ) { echo assets_css( $file ); }
function assets_img_e( $file = '' ) { echo assets_img( $file ); }
function assets_js_e( $file = '' ) { echo assets_js( $file ); }
function get_relative_url( $url ) {
    global $spyropress;

    if ( ! current_theme_supports( 'relative-urls' ) ) return;

    return $spyropress->cleaner->root_relative_url( $url );
}
function dynamic_css_url() {
    
    if( !is_multisite() ) return template_url() . 'assets/css/';
    
    $upload_info = wp_upload_dir();
    return trailingslashit( $upload_info['baseurl'] ) . 'css/';
}

// Misc helper Functions
function spyropress_get_context() { return spyropress_get_query_context(); }
function get_core_version() { global $spyropress; return $spyropress->version; }
function spyropress_get_version() { global $spyropress; return esc_attr( $spyropress->version ); }
function add_body_class( $class ) { global $spyropress; $spyropress->add_body_class( $class ); }
function add_jquery_ready( $code ) { global $spyropress; $spyropress->add_jquery_ready( $code ); }
function add_window_load( $code ) { global $spyropress; $spyropress->add_window_load( $code ); }
function add_inline_js( $code ) { global $spyropress; $spyropress->add_inline_js( $code ); }
function add_footer_html( $code ) { global $spyropress; $spyropress->add_footer_html( $code ); }
function get_panel_img_path( $img = '' ) { if ( $img == '' ) return; return framework_assets_img() . 'panel-ui/' . $img; }
function get_internal_name() { global $spyropress; return $spyropress->internal_name; }

/** Hooks for both Front-end and Back-end ****************************************/

/**
 * New Contact Methods in User profile
 */
function spyropress_contactmethods( $contactmethods ) {

    // this will remove existing contact fields
    unset( $contactmethods['aim'] );
    unset( $contactmethods['yim'] );
    unset( $contactmethods['jabber'] );

    $contactmethods['twitter'] = __( 'Twitter', 'spyropress' );
    $contactmethods['facebook'] = __( 'Facebook', 'spyropress' );
    $contactmethods['linkedin'] = __( 'LinkedIn', 'spyropress' );

    return $contactmethods;
}
add_filter( 'user_contactmethods', 'spyropress_contactmethods', 10, 1 );
?>