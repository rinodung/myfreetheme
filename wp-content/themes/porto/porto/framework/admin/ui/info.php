<?php

/**
 * Info OptionType
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

function spyropress_ui_info( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    // check for null
    if ( '' == $item['desc'] ) return;

    ob_start();

    echo '<div ' . build_section_class( 'section-info', $item ) . '>';
        build_heading( $item, $is_widget );
        printf( '<div class="description"><div class="pad">%s</div></div>', htmlspecialchars_decode( $item['desc'] ) );
    echo '</div>';

    $ui_content = ob_get_clean();
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function spyropress_widget_info( $item, $id, $value ) {
    return spyropress_ui_info( $item, $id, $value, true );
}

function spyropress_ui_raw_info( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    // check for null
    if ( '' == $item['desc'] ) return;

    ob_start();

    $raw = $item['desc'];

    // Allow developer to make custom callback
    if ( isset( $item['function'] ) && $item['function'] )
        $raw = call_user_func( $item['function'], $raw );

    echo '<div class="section-raw-html">';
        echo htmlspecialchars_decode( $raw );
    echo '</div>';

    $ui_content = ob_get_clean();
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function spyropress_widget_raw_info( $item, $id, $value ) {
    return spyropress_ui_raw_info( $item, $id, $value, true );
}

function spyropress_ui_include( $item, $id, $value, $is_widget = false, $is_builder = false ) {
    include framework_path() . $id;
}
?>