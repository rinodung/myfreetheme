<?php

echo $before_widget;
    echo $apply ? apply_filters( 'the_content', $html_text ) : $html_text;
    echo '<div class="clear"></div>';
echo $after_widget;
?>