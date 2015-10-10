<?php

/**
 * Custom Taxonomy, Tags and Categories OptionType
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

function spyropress_ui_custom_taxonomy( $item, $id, $value, $is_widget = false, $is_builder = false ) {
    
    if ( isset( $item['class'] ) && $item['class'] )
        $item['class'] = 'section-custom-taxonomy ' . $item['class'];
    else
        $item['class'] = 'section-custom-taxonomy';

    $taxonomies = get_categories( array(
        'taxonomy' => trim( $item['taxonomy'] ),
        'hide_empty' => false
    ) );
    
    $tax_arr = array();
    if ( ! empty( $taxonomies ) ) {
        foreach ( $taxonomies as $tax )
            $tax_arr[ esc_attr( $tax->term_id ) ] = esc_attr( $tax->name );
    }

    $item['options'] = $tax_arr;
    return spyropress_ui_select( $item, $id, $value, $is_widget, $is_builder );
}

function spyropress_ui_custom_taxonomies( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    if ( isset( $item['class'] ) && $item['class'] )
        $item['class'] = 'section-custom-taxonomies ' . $item['class'];
    else
        $item['class'] = 'section-custom-taxonomies';

    $taxonomies = get_categories( array(
        'taxonomy' => trim( $item['taxonomy'] ),
        'hide_empty' => false
    ) );
    
    $tax_arr = array();
    if ( ! empty( $taxonomies ) ) {
        foreach ( $taxonomies as $tax )
            $tax_arr[ esc_attr( $tax->term_id ) ] = esc_attr( $tax->name );
    }

    $item['options'] = $tax_arr;
    return spyropress_ui_multi_select( $item, $id, $value, $is_widget, $is_builder );
}

function spyropress_widget_custom_taxonomy( $item, $id, $value, $is_builder ) {
    return spyropress_ui_custom_taxonomy( $item, $id, $value, true, $is_builder );
}

function spyropress_widget_custom_taxonomies( $item, $id, $value, $is_builder ) {
    return spyropress_ui_custom_taxonomies( $item, $id, $value, true, $is_builder );
}

/**
 * Category OptionType
 */
function spyropress_ui_category( $item, $id, $value, $is_widget = false, $is_builder = false ) {
    $item['taxonomy'] = 'category';
    spyropress_ui_custom_taxonomy( $item, $id, $value, $is_widget, $is_builder );
}

function spyropress_ui_categories( $item, $id, $value, $is_widget = false, $is_builder = false ) {
    $item['taxonomy'] = 'category';
    spyropress_ui_custom_taxonomies( $item, $id, $value, $is_widget, $is_builder );
}

function spyropress_widget_category( $item, $id, $value, $is_builder ) {
    $item['taxonomy'] = 'category';
    return spyropress_widget_custom_taxonomy( $item, $id, $value, true, $is_builder );
}

function spyropress_widget_categories( $item, $id, $value, $is_builder ) {
    $item['taxonomy'] = 'category';
    return spyropress_widget_custom_taxonomies( $item, $id, $value, true, $is_builder );
}

/**
 * Tag OptionType
 */
function spyropress_ui_tag( $item, $id, $value, $is_widget = false, $is_builder = false ) {
    $item['taxonomy'] = 'post_tag';
    spyropress_ui_custom_taxonomy( $item, $id, $value, $is_widget, $is_builder );
}

function spyropress_ui_tags( $item, $id, $value, $is_widget = false, $is_builder = false ) {
    $item['taxonomy'] = 'post_tag';
    spyropress_ui_custom_taxonomies( $item, $id, $value, $is_widget, $is_builder );
}

function spyropress_widget_tag( $item, $id, $value, $is_builder ) {
    $item['taxonomy'] = 'post_tag';
    return spyropress_widget_custom_taxonomy( $item, $id, $value, true, $is_builder );
}

function spyropress_widget_tags( $item, $id, $value, $is_builder ) {
    $item['taxonomy'] = 'post_tag';
    return spyropress_widget_custom_taxonomies( $item, $id, $value, true, $is_builder );
}

?>