<?php

// Setup Instance for view
$instance = spyropress_clean_array( $instance );
$auto_play = isset( $instance['auto_play'] ) && ! empty( $instance['auto_play'] ) ? ', ", autoPlay": true': '';

echo $before_widget;

    if ( $instance['title'] ) echo  '<h2>' . $instance['title'] . '</h2>'; 
        
        echo '<div class="row"><div class="owl-carousel owl-carousel-spaced" data-plugin-options=\'{"items": 1'. $auto_play .' }\'>';

        // output content
        echo $this->query( $instance, '{content}' );

    echo '</div></div>';

    if( isset( $instance['url_enable'] ) && $instance['url_enable'] )
        echo '<div class="row"><div class="col-md-12"><a href="' . get_permalink( get_option( 'page_for_posts') ) . '" class="btn btn-xs btn-primary pull-right">' . $instance['url_text'] . ' <i class="fa fa-arrow-right"></i></a></div></div>';

echo $after_widget;