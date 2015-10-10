<?php

$instance = spyropress_clean_array( $instance );

$out = $this->query( $instance, '{content}' );
echo str_replace( '>', ' data-plugin-toggle>', $before_widget ) . $out . $after_widget;