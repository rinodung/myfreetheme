<?php

// Setup Instance for view
$instance = spyropress_clean_array( $instance );
$instance['row'] = false;
$instance['columns'] = false;

// filter
$filter = isset( $instance['filters'] );
if( $filter ) {
    $terms = get_terms( 'portfolio_category' );
    if( !empty( $terms ) && !is_wp_error( $terms ) ) {
        wp_enqueue_script( 'jquery-isotope' );
        
        echo '<div class="sort-source-wrapper hidden"><div class="container"><ul class="nav nav-pills sort-source secundary pull-right" data-sort-id="portfolio" data-option-key="filter"><li data-option-value="*" class="active"><a href="#">' . $show_all . '</a></li>';
        
        foreach( $terms as $item )
            echo '<li data-option-value=".' . $item->slug . '"><a href="#">' . $item->name . '</a></li>';
        
        echo '</ul></div></div>';
    }
}					

$output = $this->query( $instance );

if( $filter ) echo '<ul class="portfolio-list sort-destination full-width hidden" data-sort-id="portfolio">';
else echo '<ul class="portfolio-list full-width hidden">';
    
    // output content
    echo $output['content'];
    
echo '</ul>';
echo $output['pagination'];