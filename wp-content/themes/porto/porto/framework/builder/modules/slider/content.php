<?php

if( empty( $slides ) ) return;

$options = array(
    'pagination' => false,
    'navigation' => false,
    'autoPlay' => false,
    'items' => $items
);

if( $items > 1 ) $options['singleItem'] = false;
if( $controlNav ) $options['pagination'] = true;
if( $directionNav ) $options['navigation'] = true;
if( $slideshow ) $options['autoPlay'] = true;
if( $autoheight ) $options['autoHeight'] = true;
if( $animation && 'slide' != $animation ) $options['transitionStyle'] = $animation;

echo $before_widget;
    echo '<div class="row center"><div class="owl-carousel" data-plugin-options=\'' . json_encode( $options ) . '\'>';

    foreach( $slides as $slide ) {
        echo '<div>' . do_shortcode( wpautop( $slide['content'] ) ) . '</div>';
    }

    echo '</div></div>';
echo $after_widget;