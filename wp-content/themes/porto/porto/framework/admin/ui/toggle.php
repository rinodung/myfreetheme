<?php

/**
 * Toggle Set OptionType
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

function spyropress_ui_toggle( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    ob_start();

    printf( '<div class="toggle_set%1$s">', ( isset( $item['toggle_class'] ) ) ? ' ' . $item['toggle_class'] : '' );
        echo '<div ' . build_section_class( 'section-subheading toggle_trigger', $item ) . '>';
            build_heading( $item, $is_widget );
            build_description( $item );
            printf( '<span class="toggle_icon">%1$s</span>', ( isset( $item['show'] ) && $item['show'] ) ? '[-]' : '[+]' );
        echo '</div>';
        printf( '<div class="toggle_container%1$s">', ( isset( $item['show'] ) && $item['show'] ) ? ' active' : '' );

    $ui_content = ob_get_clean();
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function spyropress_ui_toggle_end( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    ob_start();

    echo '</div></div>';

    $ui_content = ob_get_clean();
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function spyropress_widget_toggle( $item, $id, $value, $is_builder ) {
    return spyropress_ui_toggle( $item, $id, $value, true, $is_builder );
}

function spyropress_widget_toggle_end( $item, $id, $value, $is_builder ) {
    return spyropress_ui_toggle_end( $item, $id, $value, true, $is_builder );
}

?>