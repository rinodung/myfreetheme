<?php

/**
 * Range Slider OptionType
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

function spyropress_ui_range_slider( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    ob_start();

    // collecting attributes
    $atts = array();
    $atts['class'] = 'field';
    $atts['type'] = 'text';
    $atts['name'] = esc_attr( $item['name'] );
    $atts['value'] = esc_attr( $value );

    echo '<div ' . build_section_class( 'section-slider', $item ) . '>';
        build_heading( $item, $is_widget );
        build_description( $item );
        echo '<div class="controls">';
            echo '<div class="range-slider clearfix">';
                printf( '<div id="%s" class="slider"></div>', $id );
                printf( '<input%s />', spyropress_build_atts( $atts ) );
            echo '</div>';
        echo '</div>';
    echo '</div>';

    // content
    $ui_content = ob_get_clean();

    // js
    if ( isset( $item['max'] ) && $item['max'] != '' )
        $range_slider['max'] = $item['max'];
    if ( isset( $item['min'] ) && $item['min'] != '' )
        $range_slider['min'] = $item['min'];
    if ( isset( $item['step'] ) && $item['step'] != '' )
        $range_slider['step'] = $item['step'];
    $range_slider['value'] = ( int )$value;
    $range_slider['range'] = ( isset( $item['range'] ) && $item['range'] != '' ) ? $item['range'] : 'min';

    $js = "panelUi.bind_range_slider( '{$id}', " . json_encode( $range_slider ) . ");";

    if ( $is_widget ) {
        $ui_content .= sprintf( '<script type="text/javascript">%2$s//<![CDATA[%2$s %1$s %2$s//]]>%2$s</script>', $js, "\n" );
        return $ui_content;
    }
    else {
        echo $ui_content;
        add_jquery_ready( $js );
    }
}

function spyropress_widget_range_slider( $item, $id, $value, $is_builder = false ) {
    return spyropress_ui_range_slider( $item, $id, $value, true, $is_builder );
}
?>