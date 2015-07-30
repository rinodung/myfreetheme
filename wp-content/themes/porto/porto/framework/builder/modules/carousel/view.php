<?php

if( empty( $slides ) ) return;

echo '<div class="flexslider flexslider-center-mobile flexslider-simple flexslider-no-margin-bottom" data-plugin-options=\'{"controlNav":false, "animation":"slide", "slideshow": false, "maxVisibleItems": 1}\'><ul class="slides">';
    foreach( $slides as $slide ) {
        echo '<li><img class="img-rounded" src="' . $slide['image'] . '" alt=""></li>';
    }
echo '</ul></div>';