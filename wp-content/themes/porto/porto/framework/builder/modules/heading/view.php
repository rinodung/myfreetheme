<?php

if( is_str_contain( '[rotate_words]', $heading ) )
    $styles[] = 'word-rotator-title';
printf(
    '<h%1$s%3$s class="%4$s">%2$s</h%1$s>',
    $html_tag, do_shortcode( $heading ), spyropress_build_atts( array( 'animation' => $animation ), 'data-appear-' ),
    spyropress_clean_cssclass( $styles )
);