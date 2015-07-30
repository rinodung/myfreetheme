<?php

/**
 * Hidden OptionType
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

function spyropress_ui_hidden( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    ob_start();

    // collecting attributes
    $atts = array();
    $atts['type'] = 'hidden';
    $atts['id'] = esc_attr( $id );
    $atts['name'] = esc_attr( $item['name'] );
    $atts['value'] = esc_attr( $value );

    printf( '<input%s />', spyropress_build_atts( $atts ) );

    $ui_content = ob_get_clean();
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function spyropress_widget_hidden( $item, $id, $value, $is_builder = false ) {
    return spyropress_ui_hidden( $item, $id, $value, true, $is_builder );
}
?>