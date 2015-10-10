<?php

/**
 * Sub-Heading OptionType
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

function spyropress_ui_sub_heading( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    ob_start();

    // collecting section classes
    $section_class[] = 'section section-subheading';
    if ( isset( $item['class'] ) && $item['class'] )
        $section_class[] = $item['class'];

    echo '<div ' . build_section_class( 'section-subheading', $item ) . '>';
        build_heading( $item, $is_widget );
        build_description( $item );
    echo '</div>';

    $ui_content = ob_get_clean();
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function spyropress_widget_sub_heading( $item, $id, $value, $is_builder ) {
    return spyropress_ui_sub_heading( $item, $id, $value, true, $is_builder );
}
?>