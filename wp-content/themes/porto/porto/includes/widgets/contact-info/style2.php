<?php

echo $before_widget;

if ( '' != $title ) echo '<h5 class="short">' . $title . '</h5>';

if ( $phone )
    echo '<span class="phone">' . $phone . '</span>';

if ( $int_phone )
    echo '<p class="short">'. $inter_phone_title . ' ' . $int_phone . '</p>';

if ( $fax )
    echo '<p class="short">'. $fax_title . ' ' . $fax . '</p>';

echo '<ul class="list icons list-unstyled push-top">';
    if ( $address )
        echo '<li><i class="fa fa-map-marker"></i> <strong>'. $address_title .'</strong> ' . $address . '</li>';
    
    if ( $email )
        echo '<li><i class="fa fa-envelope"></i> <strong>'. $email_title .'</strong> <a href="mailto:' . $email . '">' . $email . '</a></li>';

echo '</ul>';

echo $after_widget;