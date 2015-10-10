<?php
/**
 * Reapter OptionType
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

function spyropress_ui_repeater( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    ob_start();

    $count = ( !empty( $value ) ) ? ( count( $value ) ) : 0;

    // Getting field for title
    $title_field = '';
    if( isset( $item['item_title'] ) ) {
        foreach( $item['fields'] as $field ) {
            if( isset( $field['id'] ) && $field['id'] == $item['item_title'] ) {
                $title_field = $field;
                break;
            }
        }
    }

    echo '<div ' . build_section_class( 'section-repeater section-full', $item ) . '>';
        if ( !isset( $item['hide_label'] ) )
            build_heading( $item, $is_widget );
        else
            echo '<br/>';
        build_description( $item );
        echo '<input type="hidden" class="control_id" value="' . $item['name'] . '" />';
        echo '<div class="controls">';
            for( $i = 0; $i <= $count; $i++) {

                // group start
                $tocopy = ( $i == $count ) ? ' tocopy' : '';
                $settings = ( isset( $value[ $i] ) ) ? $value[ $i ] : array();

                echo '<div class="repeater-group' . $tocopy . '">';

                    // Header
                    echo '<div class="repeater-group-header">';
                        
                        $title_value = '';
                        if( isset( $item['item_title'] ) && $title_field ) {
                            $title_value = ( !empty( $settings ) && isset( $settings[ $item['item_title'] ] ) ) ? $settings[ $item['item_title'] ] : '';
                        }
                        if( $title_value ) {
                            if( 'select' == $title_field['type'] )
                                echo ucwords( $title_field['options'][$title_value] );
                            else
                                echo ucwords( $title_value );
                        }
                        else {
                            echo $item['label'];
                        }
    				echo '</div>';

                    // Loop fields
                    echo '<div class="repeater-sections">';

                    foreach( $item['fields'] as $field ) {
                        // Parent Name
                        if( isset( $item['parent_name'] ) )
                            $field['parent_name'] = sprintf( '%1$s[%2$s]', $item['name'], $i );
                        if( $is_widget )
                            $field['widget_name'] = $item['name'];
                        parse_repeater_field( $field, $id, $settings, $i, $is_widget, $is_builder );
                    }

                    // Actions
                    echo '<div class="repeater-group-actions pb10">';
                        echo '<a href="#" class="repeater-delete">' . __( 'Remove', 'spyropress' ) . '</a>';
  						echo '<span class="meta-sep">|</span>';
  						echo '<a href="#" class="repeater-close">' . __( 'Close', 'spyropress' ) . '</a>';
                        echo '<div class="clear"></div>';
                    echo '</div>'; // group_actions

                    echo '</div>'; // group_sections

                echo '</div>'; // group_end
            }

            // add button
            echo '<button class="repeater-add button">' . __( 'Add New', 'spyropress' ) . ' ' . $item['label'] . '</button>';
        echo '</div>';
    echo '</div>';

    $ui_content = ob_get_clean();
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function parse_repeater_field( $section, $parent_id, $settings, $count, $is_widget = false, $is_builder = false ) {
    // Defaults
    $defaults = array(
        'id' => '',
        'label' => '',
        'type' => 'text',
        'desc' => '',
        'std' => '',
        'class' => '',

        'placeholder' => '',
        'rows' => '15',
        'post_type' => 'post',
        'taxonomy' => 'category',
        'options' => array()
    );
    $section = wp_parse_args( $section, $defaults );

    // id
    $id = sprintf( '%1$s-%2$s-%3$s', $parent_id, $section['id'], $count );
    // name
    if( !isset( $section['parent_name'] ) ) {
        if( $is_widget )
            $section['parent_name'] = sprintf( '%1$s[%2$s]', $section['widget_name'], $count );
        else
            $section['parent_name'] = sprintf( '%1$s[%2$s]', $parent_id, $count );
    }
    $section['name'] = sprintf( '%1$s[%2$s]', $section['parent_name'], $section['id'] );
    
    // set to default
    if ( ! isset( $settings[$section['id']] ) && isset( $section['std'] ) && $section['std'] )
        $settings[$section['id']] = $section['std'];
    // value
    $value = isset( $settings[ $section['id'] ] ) ? $settings[ $section['id'] ] : '';

    // Prefix method
    $field_method = 'spyropress_ui_' . $section['type'];

    // Run method
    if ( function_exists( $field_method ) ) {
        echo call_user_func_array( $field_method, array(
            $section,
            $id,
            $value,
            $is_widget,
            $is_builder
        ) );
    }
}

function spyropress_widget_repeater( $item, $id, $value, $is_builder = false ) {
    return spyropress_ui_repeater( $item, $id, $value, true, $is_builder );
}
?>