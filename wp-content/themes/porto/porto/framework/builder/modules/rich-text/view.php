<?php
echo $before_widget;
    echo apply_filters( 'the_content', $rich_text );
echo $after_widget;