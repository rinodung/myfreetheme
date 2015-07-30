<?php

/**
 * Theme Meta Info for internal usage
 *
 * Dont Mess with it.
 */
add_action( 'before_spyropress_core_includes', 'spyropress_setup_theme' );
function spyropress_setup_theme() {
    global $spyropress;

    $spyropress->internal_name = 'porto';
    $spyropress->theme_name = 'Porto';
    $spyropress->theme_version = '1.5.2';
    $spyropress->themekey = 'y8ryfatjhipir9gn4e1nh75gnmvlm33sg';

    $spyropress->framework = 'bs3';
    $spyropress->row_class = 'row';
    $spyropress->grid_columns = 12;
}