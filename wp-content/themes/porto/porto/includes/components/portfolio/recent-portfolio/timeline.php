<?php

// Setup Instance for view
$instance = spyropress_clean_array( $instance );
$instance['callback'] = array( $this, 'generate_item_timeline' );
$instance['row'] = false;
$instance['columns'] = false;
    
echo '<h1>' . $title . '</h1>';

echo '<section class="timeline" id="timeline"><div class="timeline-body" id="timeline-body">';
    
    // output content
    $replace = '';
    $content = $this->query( $instance );
    
    $pagination = '';
    if( isset( $content['pagination'] ) && !empty( $content['pagination'] ) ) {
        $pagination = '<div class="timeline-date load-more-posts"><h3><a href="#" data-target="#timeline-body" data-loading="Loading...">Load More...</a></h3>' . str_replace( 'pagination', 'hidden', $content['pagination'] ) . '</div>';
    }
    
    echo $content['content'] . $pagination;

echo '</div></section>';