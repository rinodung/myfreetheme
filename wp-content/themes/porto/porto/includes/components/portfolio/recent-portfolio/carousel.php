<?php

// Setup Instance for view
$instance = spyropress_clean_array( $instance );
$instance['callback'] = array( $this, 'generate_item_carousel' );
$instance['row'] = false;
$instance['columns'] = false;
$instance['row_class'] = '';

// tempalte
$tmpl = '{content}';
    
echo '<h1>' . $title . '</h1>';

echo '<div class="owl-carousel owl-carousel-spaced" data-plugin-options=\'{"items": 4}\'>';
    
    // output content
    echo $this->query( $instance, $tmpl );

echo '</div>';