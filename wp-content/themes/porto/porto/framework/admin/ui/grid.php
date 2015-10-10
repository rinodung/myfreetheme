<?php

/**
 * Toggle Set OptionType
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

function spyropress_ui_row( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    $ui_content = '<div class="row-fluid">';
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function spyropress_ui_row_end( $item, $id, $value, $is_widget = false, $is_builder = false ) {
    
    $ui_content = '</div>';
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function spyropress_widget_row( $item, $id, $value, $is_builder = false ) {
    
    if ( $is_builder ) return spyropress_ui_row( $item, $id, $value, true, $is_builder );
    return '';
}

function spyropress_widget_row_end( $item, $id, $value, $is_builder = false ) {
    
    if ( $is_builder ) return spyropress_ui_row_end( $item, $id, $value, true );
    return '';
}

function spyropress_ui_col( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    // collecting section classes
    if ( $item['class'] )
        $section_class[] = $item['class'];
    $section_class[] = 'span' . $item['size'];

    $ui_content = '<div class="'. implode( ' ', $section_class ) . '">';
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function spyropress_ui_col_end( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    $ui_content = '</div>';
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function spyropress_widget_col( $item, $id, $value, $is_builder = false ) {
    
    if ( $is_builder ) return spyropress_ui_col( $item, $id, $value, true );
    return '';
}

function spyropress_widget_col_end( $item, $id, $value, $is_builder = false ) {
    
    if ( $is_builder ) return spyropress_ui_col_end( $item, $id, $value, true );
    return '';
}
?>