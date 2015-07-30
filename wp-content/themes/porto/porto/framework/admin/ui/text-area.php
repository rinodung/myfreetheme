<?php

/**
 * Textarea OptionType
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

function spyropress_ui_textarea( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    ob_start();

    // collecting attributes
    $atts = array();
    $atts['class'] = 'field';
    $atts['id'] = esc_attr( $id );
    $atts['name'] = esc_attr( $item['name'] );
    $atts['rows'] = esc_attr( $item['rows'] );

    if ( isset( $item['placeholder'] ) && $item['placeholder'] )
        $atts['placeholder'] = esc_attr( $item['placeholder'] );

    echo '<div ' . build_section_class( 'section-textarea', $item ) . '>';
        build_heading( $item, $is_widget );
        build_description( $item );
        echo '<div class="controls">';
            printf( '<textarea%s>%s</textarea>', spyropress_build_atts( $atts ), esc_textarea( $value ) );
        echo '</div>';
    echo '</div>';

    $ui_content = ob_get_clean();
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function spyropress_widget_textarea( $item, $id, $value, $is_builder ) {
    return spyropress_ui_textarea( $item, $id, $value, true, $is_builder );
}
?>