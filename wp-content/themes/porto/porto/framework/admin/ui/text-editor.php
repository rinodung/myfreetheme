<?php

/**
 * Editor OptionType
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

function spyropress_ui_editor( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    ob_start();

    // Defaults
    $defaults = array(
        'wpautop' => false,
        'media_buttons' => true,
        'textarea_name' => esc_attr( $item['name'] ),
        'textarea_rows' => esc_attr( $item['rows'] )
    );

    $settings = ( isset( $item['settings'] ) ) ? $item['settings'] : array();
    $settings = wp_parse_args( $settings, $defaults );

    echo '<div ' . build_section_class( 'section-editor section-full', $item ) . '>';
        build_heading( $item, $is_widget );
        build_description( $item );
        echo '<div class="controls">';
            wp_editor( $value, esc_attr( $id ), $settings );
        echo '</div>';
    echo '</div>';

    $ui_content = ob_get_clean();
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function spyropress_widget_editor( $item, $id, $value, $is_builder = false ) {

    ob_start();

    // collecting attributes
    $atts = array();
    $atts['class'] = 'field builder-rich-text';
    $atts['id'] = esc_attr( $id );
    $atts['name'] = esc_attr( $item['name'] );
    $atts['rows'] = esc_attr( $item['rows'] );

    echo '<div ' . build_section_class( 'section-editor section-full', $item ) . '>';
        build_heading( $item, true );
        build_description( $item );
        echo '<div class="controls">';
            printf( '<textarea %s>%s</textarea>', spyropress_build_atts( $atts ), wp_richedit_pre( $value ) );
        echo '</div>';
    echo '</div>';

    $ui_content = ob_get_clean();

    return $ui_content;
}