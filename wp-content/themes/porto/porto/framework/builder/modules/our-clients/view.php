<?php

if( empty( $clients ) ) return;

echo '<div class="row center"><div class="owl-carousel" data-plugin-options=\'{"items": 6, "autoPlay": true, "autoplayTimeout": 3000}\'>';
    
    foreach( $clients as $client ) {
        $url = isset( $client['url'] ) && !empty( $client['url'] ) ? $url : '';
        
        if( $url ) {
            echo '<div><a href="' . $url . '"><img class="img-responsive" alt="" src="' . $client['logo'] . '"></a></div>';
        }
        else {
            echo '<div><img class="img-responsive" alt="" src="' . $client['logo'] . '"></div>';
        }
    }

echo '</div></div>';