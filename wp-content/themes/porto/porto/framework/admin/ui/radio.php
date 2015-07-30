<?php

/**
 * Radio and Radio Image OptionType
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

function spyropress_ui_radio( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    ob_start();

    echo '<div ' . build_section_class( 'section-radiolist', $item ) . '>';
        build_heading( $item, $is_widget );
        build_description( $item );
        echo '<div class="controls">';
            // build checkboxes
            $count = 0;
            foreach ( (array) $item['options'] as $choice_value => $choice_label ) {

                $choice_id = esc_attr( $id ) . '-' . $count;
                $class = 'checkbox';

                // collecting attributes
                $atts = array();
                $atts['type'] = 'radio';
                $atts['id'] = $choice_id;
                $atts['name'] = esc_attr( $item['name'] );
                $atts['value'] = esc_attr( $choice_value );

                if( (string) $value === (string) $choice_value ) {
                    $atts['checked'] = 'checked';
                    $class .= ' selected';
                }

                printf(
                    '<label class="' . $class . '" for="%1$s"><input%2$s /> %3$s</label>',
                    $choice_id, spyropress_build_atts( $atts ), $choice_label
                );

                $count++;
            }
        echo '</div>';
    echo '</div>';

    $ui_content = ob_get_clean();
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function spyropress_ui_radio_img( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    ob_start();

    echo '<div ' . build_section_class( 'section-radio-img section-full', $item ) . '>';
        build_heading( $item, $is_widget );
        build_description( $item );
        echo '<div class="controls">';
            // build checkboxes
            $count = 0;
            foreach ( (array) $item['options'] as $choice_value => $choice ) {

                $choice_id = esc_attr( $id ) . '-' . $count;

                // collecting attributes
                $atts = array();
                $atts['type'] = 'radio';
                $atts['id'] = $choice_id;
                $atts['name'] = esc_attr( $item['name'] );
                $atts['value'] = esc_attr( $choice_value );

                if( (string) $value === (string) $choice_value )
                    $atts['checked'] = 'checked';
                
                $choice_title = isset( $choice['title'] ) ? '<span>' . esc_attr( $choice['title'] ) . '</span>' : '';

                printf(
                    '<label class="radio-img%5$s" for="%1$s"><input%2$s /><img src="%4$s" alt="" title="%3$s" />%3$s</label>',
                    $choice_id, spyropress_build_atts( $atts ), $choice_title,
                    esc_url( $choice['img'] ), ( $value == $choice_value ) ? ' selected' : ''
                );

                $count++;
            }
        echo '</div>';
    echo '</div>';


    $ui_content = ob_get_clean();
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function spyropress_widget_radio( $item, $id, $value ) {
    return spyropress_ui_radio( $item, $id, $value, true );
}

function spyropress_widget_radio_img( $item, $id, $value ) {
    return spyropress_ui_radio_img( $item, $id, $value, true );
}
?>