<?php

/**
 * Checkbox and Multi Checkbox OptionType
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

function spyropress_ui_checkbox( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    ob_start();

    echo '<div ' . build_section_class( 'section-checkbox', $item ) . '>';
        build_heading( $item, $is_widget );
        build_description( $item );
        echo '<div class="controls">';
            // build checkboxes
            $count = 0;
            foreach ( (array) $item['options'] as $choice_value => $choice_label ) {

                $choice_id = esc_attr( $id ) . '-' . $count;

                // collecting attributes
                $atts = array();
                $atts['type'] = 'checkbox';
                $atts['id'] = $choice_id;
                $atts['name'] = esc_attr( $item['name'] ) .'[' . $count . ']';
                $atts['value'] = esc_attr( $choice_value );

                if( isset( $value[$count] ) && (string) $value[$count] === (string) $choice_value )
                    $atts['checked'] = 'checked';

                printf(
                    '<label class="checkbox" for="%1$s"><input%2$s /> %3$s</label>',
                    $choice_id, spyropress_build_atts( $atts ), htmlspecialchars_decode( $choice_label )
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

function spyropress_widget_checkbox( $item, $id, $value ) {
    return spyropress_ui_checkbox( $item, $id, $value, true );
}
?>