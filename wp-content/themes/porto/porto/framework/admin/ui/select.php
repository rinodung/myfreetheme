<?php

/**
 * Select and Multi-Select OptionType
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

function spyropress_ui_select( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    if ( empty( $item['options'] ) && isset( $item['ajax'] ) && ! $item['ajax'] )
        return;

    ob_start();

    // collecting attributes
    $atts = array();
    $atts['class'] = ( isset( $item['ajax'] ) && $item['ajax'] ) ? 'chosen-ajax' : 'chosen';
    $atts['id'] = esc_attr( $id );
    $atts['name'] = esc_attr( $item['name'] );

    // adding ajax attributes
    if( isset( $item['ajax'] ) && $item['ajax'] ) {
        $atts['data-type'] = 'custom_post';
        $atts['data-wp_type'] = implode( ',', (array) $item['post_type'] );
    }

    echo '<div ' . build_section_class( 'section-select', $item ) . '>';
        build_heading( $item, $is_widget );
        build_description( $item );
        echo '<div class="controls">';
            printf( '<select%s><option value=""></option>', spyropress_build_atts( $atts ) );
                foreach ( $item['options'] as $k => $v ) {
                    render_option( $k, $v, $value );
                }
            echo '</select>';
        echo '</div>';
    echo '</div>';

    $ui_content = ob_get_clean();
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function spyropress_ui_multi_select( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    ob_start();

    // collecting attributes
    $atts = array();
    $atts['class'] = ( isset( $item['ajax'] ) && $item['ajax'] ) ? 'chosen-ajax' : 'chosen';
    $atts['id'] = esc_attr( $id );
    $atts['name'] = esc_attr( $item['name'].'[]' );
    $atts['multiple'] = 'multiple';

    // adding ajax attributes
    if( isset( $item['ajax'] ) && $item['ajax'] ) {
        $atts['data-type'] = 'custom_post';
        $atts['data-wp_type'] = implode( ',', (array) $item['post_type'] );
    }

    $value = ( empty( $value ) ) ? array() : $value;

    echo '<div ' . build_section_class( 'section-multi-select', $item ) . '>';
        build_heading( $item, $is_widget );
        build_description( $item );
        echo '<div class="controls">';
            printf( '<select%s><option value=""></option>', spyropress_build_atts( $atts ) );
                foreach ( $item['options'] as $k => $v ) {
                    render_option( $k, $v, $value );
                }
            echo '</select>';
        echo '</div>';
    echo '</div>';

    $ui_content = ob_get_clean();
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function spyropress_widget_select( $item, $id, $value, $is_builder ) {
    return spyropress_ui_select( $item, $id, $value, true, $is_builder );
}

function spyropress_widget_multi_select( $item, $id, $value, $is_builder ) {
    return spyropress_ui_multi_select( $item, $id, $value, true, $is_builder );
}

function render_option( $k, $v, $selected ) {

    if ( is_array( $v ) && $v['name'] != '' ) {
        printf( '<optgroup label="%s">', esc_attr( $v['name'] ) );
        if ( ! empty( $v['options'] ) ) {
            foreach ( $v['options'] as $ok => $ov ) {
                render_option( $ok, $ov, $selected );
            }
        }
        printf( '</optgroup>' );
    }
    else {
        printf( '<option value="%s"%s>%s</option>', esc_attr( $k ), ( in_array( $k, (array) $selected ) ) ? ' selected="selected"' : '', esc_attr( $v ) );
    }
}

?>