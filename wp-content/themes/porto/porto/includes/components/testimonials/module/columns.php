<?php

// Setup Instance for view
$instance = spyropress_clean_array( $instance );
$instance['callback'] = array( $this, 'generate_column_item' );

// tempalte
$tmpl = '{content}';
  
if ( $instance['title'] ) echo '<h2>' . $instance['title'] . '</h2>';

echo '<div class="row">';
    
    // output content
    echo $this->query( $instance, $tmpl );

echo '</div>';