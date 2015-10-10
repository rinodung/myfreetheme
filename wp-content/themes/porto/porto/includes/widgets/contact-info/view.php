<?php

echo $before_widget;

if ( '' != $title ) echo $before_title . $title . $after_title;
    
echo '<ul class="contact list-unstyled">';

    if ( $address )
        echo '<li><p><i class="fa fa-map-marker"></i> <strong>'. $address_title .'</strong> ' . $address . '</p></li>';

    if ( $phone )
        echo '<li><p><i class="fa fa-phone"></i> <strong>'. $phone_title .'</strong> ' . $phone . '</p></li>';
    
    if ( $email )
        echo '<li><p><i class="fa fa-envelope"></i> <strong>'. $email_title .'</strong> <a href="mailto:' . $email . '">' . $email . '</a></p></li>';

echo '</ul>';

echo $after_widget;