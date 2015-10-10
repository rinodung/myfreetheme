<?php

if( empty( $features ) ) return;

if( $title )
    echo '<h2' . spyropress_build_atts( array( 'animation' => $animation ), 'data-appear-' ) . '>' . $title . '</h2>';
    
$atts = array(
    'callback' => array( $this, 'generate_box_item' ),
    'row_class' => get_row_class( true ) . ' featured-boxes',
    'columns' => $columns,
    'box_class' => ''
);
echo spyropress_column_generator( $atts, $features );