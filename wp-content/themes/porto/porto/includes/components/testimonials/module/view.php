<?php

// Setup Instance for view
$instance = spyropress_clean_array( $instance );

$auto_play = ( isset( $instance['auto_play'] ) && !empty( $instance['auto_play'] ) )? '", autoPlay": true': '';

if ( $instance['title'] ) echo '<h2>' . $instance['title'] . '</h2>';

echo '<div class="row"><div class="owl-carousel push-bottom" data-plugin-options=\'{"items": 1'.$auto_play.'}\'>';

    // output content
    echo $this->query( $instance, '{content}' );

echo '</div></div>';