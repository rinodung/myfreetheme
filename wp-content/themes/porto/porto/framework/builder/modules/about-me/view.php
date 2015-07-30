<?php

if( $full_name ) echo '<h2 class="shorter">' . $full_name . '</h2>';

if( $designation ) echo '<h4>' . $designation . '</h4>';

if( !empty( $socials ) ) {
    echo '<span class="thumb-info-social-icons">';
        foreach( $socials as $social )
            echo '<a rel="tooltip" data-placement="bottom" target="_blank" href="' . $social['url'] . '" data-original-title="' . ucwords( $social['network'] ) . '"><i class="fa fa-' . $social['network'] . '"></i><span>' . ucwords( $social['network'] ) . '</span></a></li> ';
    echo '</span>';
}

echo do_shortcode( wpautop( $about ) );