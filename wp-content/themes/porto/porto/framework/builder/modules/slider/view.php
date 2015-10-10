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
    echo '<div class="owl-carousel" data-plugin-options=\'' . json_encode( $options ) . '\'>';
    
    foreach( $slides as $slide ) {
        echo 'image2' == $template ? '<div class="thumbnail"><div><img class="img-responsive" src="' . $slide['image'] . '" alt=""></div></div>' : '<div><img class="img-responsive" src="' . $slide['image'] . '" alt=""></div>';
    }
    
    echo '</div>';
echo $after_widget;