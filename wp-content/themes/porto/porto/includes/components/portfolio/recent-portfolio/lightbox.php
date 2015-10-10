<?php

// Setup Instance for view
$instance = spyropress_clean_array( $instance );
$instance['row'] = false;

// title
if ( $title ) echo '<h2>' . $title . '</h2>';

// filter
$filter = isset( $instance['filters'] );
if( $filter ) {
    $terms = get_terms( 'portfolio_category' );
    if( !empty( $terms ) && !is_wp_error( $terms ) ) {
        wp_enqueue_script( 'jquery-isotope' );
        
        echo '<ul class="nav nav-pills sort-source" data-sort-id="portfolio" data-option-key="filter"><li data-option-value="*" class="active"><a href="#">' . $show_all . '</a></li>';
        
        foreach( $terms as $item )
            echo '<li data-option-value=".' . $item->slug . '"><a href="#">' . $item->name . '</a></li>';
        
        echo '</ul><hr />';
    }
}

$output = $this->query( $instance );

if( $filter ) echo '<div class="row"><ul class="portfolio-list sort-destination lightbox" data-sort-id="portfolio" data-plugin-options=\'{"delegate": "a", "type": "image", "gallery": {"enabled": true}}\'>';
else echo '<div class="row"><ul class="portfolio-list lightbox" data-plugin-options=\'{"delegate": "a", "type": "image", "gallery": {"enabled": true}}\'>';
    
    // output content
    echo $output['content'];
    
echo '</ul></div>';
echo $output['pagination'];