<?php

/**
 * Text OptionType
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

function spyropress_ui_text( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    ob_start();

    // collecting attributes
    $atts = array();
    $atts['class'] = 'field';
    $atts['type'] = 'text';
    $atts['id'] = esc_attr( $id );
    $atts['name'] = esc_attr( $item['name'] );
    if ( isset( $item['placeholder'] ) && $item['placeholder'] )
        $atts['placeholder'] = esc_attr( $item['placeholder'] );

    $atts['value'] = esc_attr( $value );

    echo '<div ' . build_section_class( 'section-text', $item ) . '>';
        build_heading( $item, $is_widget );
        build_description( $item );
        echo '<div class="controls">';
            printf( '<input%s />', spyropress_build_atts( $atts ) );
        echo '</div>';
    echo '</div>';

    $ui_content = ob_get_clean();
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function spyropress_widget_text( $item, $id, $value, $is_builder ) {  
    return spyropress_ui_text( $item, $id, $value, true, $is_builder );
}
?>