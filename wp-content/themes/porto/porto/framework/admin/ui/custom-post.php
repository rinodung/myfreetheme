<?php

/**
 * Custom Post Type, Post and Pages OptionType
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

function spyropress_ui_custom_post( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    if ( isset( $item['class'] ) && $item['class'] )
        $item['class'] = 'section-custom-post ' . $item['class'];
    else
        $item['class'] = 'section-custom-post';

    if ( $value != '' && $value > 0 ) {
        $posts_arr = array();
        $cur = get_post( $value );
        $posts_arr[ esc_attr( $cur->ID ) ] = esc_attr( $cur->post_title );
        $item['options'] = $posts_arr;
    }

    $item['ajax'] = true;
    
    return spyropress_ui_select( $item, $id, $value, $is_widget, $is_builder );
}

function spyropress_ui_custom_posts( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    if ( isset( $item['class'] ) && $item['class'] )
        $item['class'] = 'section-custom-posts ' . $item['class'];
    else
        $item['class'] = 'section-custom-posts';

    if ( $value != '' && is_array( $value ) ) {
        $posts_arr = array();
        foreach ( $value as $post_id ) {
            $cur = get_post( $post_id );
            $posts_arr[ esc_attr( $cur->ID ) ] = esc_attr( $cur->post_title );
        }

        $item['options'] = $posts_arr;
    }

    $item['ajax'] = true;
    
    return spyropress_ui_multi_select( $item, $id, $value, $is_widget, $is_builder );
}

function spyropress_widget_custom_post( $item, $id, $value ) {
    return spyropress_ui_custom_post( $item, $id, $value, true );
}

function spyropress_widget_custom_posts( $item, $id, $value ) {
    return spyropress_ui_custom_posts( $item, $id, $value, true );
}

/**
 * Post OptionType
 */
function spyropress_ui_post( $item, $id, $value, $is_widget = false, $is_builder = false ) {
    $item['post_type'] = array( 'post' );
    spyropress_ui_custom_post( $item, $id, $value, $is_widget, $is_builder );
}

function spyropress_ui_posts( $item, $id, $value, $is_widget = false, $is_builder = false ) {
    $item['post_type'] = array( 'post' );
    spyropress_ui_custom_posts( $item, $id, $value, $is_widget, $is_builder );
}

function spyropress_widget_post( $item, $id, $value ) {
    $item['post_type'] = array( 'post' );
    return spyropress_widget_custom_post( $item, $id, $value, true );
}

function spyropress_widget_posts( $item, $id, $value ) {
    $item['post_type'] = array( 'post' );
    return spyropress_widget_custom_posts( $item, $id, $value, true );
}

/**
 * Page OptionType
 */
function spyropress_ui_page( $item, $id, $value, $is_widget = false, $is_builder = false ) {
    $item['post_type'] = array( 'page' );
    spyropress_ui_custom_post( $item, $id, $value, $is_widget, $is_builder );
}

function spyropress_ui_pages( $item, $id, $value, $is_widget = false, $is_builder = false ) {
    $item['post_type'] = array( 'page' );
    spyropress_ui_custom_posts( $item, $id, $value, $is_widget, $is_builder );
}

function spyropress_widget_page( $item, $id, $value ) {
    $item['post_type'] = array( 'page' );
    return spyropress_widget_custom_post( $item, $id, $value, true );
}

function spyropress_widget_pages( $item, $id, $value ) {
    $item['post_type'] = array( 'page' );
    return spyropress_widget_custom_posts( $item, $id, $value, true );
}

?>