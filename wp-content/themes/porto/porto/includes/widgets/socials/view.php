<?php

if( empty( $socials ) ) return;

echo $before_widget;

    if ( $title != '' ) echo $before_title . $title . $after_title;
    
    echo '<div class="social-icons"><ul class="social-icons">';
        foreach( $socials as $social )
            echo '<li class="' . $social['network'] . '"><a href="' . $social['url'] . '" target="_blank" data-placement="bottom" rel="tooltip" title="' . ucwords( $social['network'] ) . '">' . ucwords( $social['network'] ) . '</a></li> ';
    echo '</ul></div>';

echo $after_widget;