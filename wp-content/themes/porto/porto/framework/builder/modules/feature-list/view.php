<?php

if( empty( $features ) ) return;

if( $title )
    echo '<h2' . spyropress_build_atts( array( 'animation' => $animation ), 'data-appear-' ) . '>' . $title . '</h2>';

$atts = array(
    'callback' => array( $this, 'generate_item' ),
    'columns' => $columns,
    'box_class' => ''
);
if( 'list2' == $style )
    $atts['box_class'] = ' secundary';

echo spyropress_column_generator( $atts, $features );