<?php

/**
 * Array Helper Functions
 *
 * @author SpyroSol
 * @category Utilities
 * @package Spyropress
 *
 */

/** Array Cleaner ********************************************/

/**
 * Remove empty values from array passed
 */
function spyropress_clean_array( $array ) {

    // Check for null
    if ( empty( $array ) )
        return false;

    // Clean it
    return array_filter( $array );
}

/**
 * Build html attributes from array
 */
function spyropress_build_atts( $atts, $prefix = '', $quote = '"' ) {

    // check for null
    $atts = spyropress_clean_array( $atts );
    if ( empty( $atts ) ) return;

    $string = '';
    foreach ( $atts as $k => $v )
        $string .= ' ' . $prefix . $k . '=' . $quote . $v . $quote;

    return $string;
}

/**
 * Clean Css Classes for Class Attribute
 */
function spyropress_clean_cssclass( $classes = array() ) {
    if ( empty( $classes ) ) return false;

    //$classes = array_filter( $classes, 'remove_these_classes' );
    return implode( ' ', spyropress_clean_array( $classes ) );
}

/**
 * Reset array indexes while keep string indexes intact
 */
function array_reindex( &$array ) {
    // if this is a
    if ( ! is_array_assoc( $array ) ) {
        $array = array_values( $array );
    }

    if ( is_array_deeper( $array, 1 ) ) {
        foreach ( $array as $key => $value ) {
            if ( is_array( $value ) )
                array_reindex( $array[$key] );
        }
    }
}
function is_array_assoc( $arr ) {
    foreach ( array_keys( $arr ) as $key )
        if ( ! is_integer( $key ) )
            return true;
    return false;
}
function is_array_deeper( $array, $level = 1 ) {
    $current_depth = 1;
    foreach ( $array as $value )
        if ( is_array( $value ) ) {
            $current_depth++;
            if ( $current_depth > $level )
                return true;
            else
                return is_array_deeper( $value, $level - 1 );
        }
    return false;
}

/**
 * Sort array by keys passed in second arrays
 */
function sort_array_by_array( $array, $orderArray ) {
    $ordered = array();
    foreach ( $orderArray as $key ) {
        if ( array_key_exists( $key, $array ) ) {
            $ordered[$key] = $array[$key];
            unset( $array[$key] );
        }
    }
    return $ordered + $array;
}

/**
 * Make Array Flat
 */
function array_flat( $array ) {
    $out = array();
    foreach ( $array as $k=>$v ) {
        if ( is_array( $array[$k] ) ){
            $out = array_merge( $out, array_flat( $array[$k] ) );
        }
        else {
            $out[]=$v;
        }
    }
    
    return $out;
}

function is_element_empty( $element ) {
    $element = trim($element);
    return empty($element) ? false : true;
}
?>