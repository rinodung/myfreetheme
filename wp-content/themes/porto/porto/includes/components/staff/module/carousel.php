<?php

// Setup Instance for view
$instance = spyropress_clean_array( $instance );
$instance['callback'] = array( $this, 'generate_item_carousel' );
$instance['row'] = false;
$columns = $instance['columns'];
$instance['columns'] = false;
// tempalte
$tmpl = '{content}';

if( $title )
    echo '<h2' . spyropress_build_atts( array( 'animation' => $instance['animation'] ), 'data-appear-' ) . '>' . $title . '</h2>';

echo '<div class="owl-carousel owl-carousel-spaced" data-plugin-options=\'{"items": ' . $columns . ', "singleItem": false, "autoHeight": true}\'>';

    // output content
    echo $this->query( $instance, $tmpl );

echo '</div></div>';