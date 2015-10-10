<?php

// Setup Instance for view
$instance = spyropress_clean_array( $instance );

// tempalte
$tmpl = '{content}{pagination}';

echo $before_widget;

    if ( $instance['title'] ) echo $before_title . $instance['title'] . $after_title;

    echo '<ul class="list-unstyled recent-work">';

        // output content
        echo $this->query( $instance, $tmpl );

    echo '</ul>';

    if( isset( $instance['url_enable'] ) && $instance['url_enable'] )
        echo '<a href="' . home_url( '/portfolio/' ) . '" class="btn-flat pull-right btn-xs view-more-recent-work">' . $instance['url_text'] . ' <i class="fa fa-arrow-right"></i></a>';

echo $after_widget;
?>