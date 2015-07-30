<?php

echo '<aside class="sidebar">';
    spyropress_before_sidebar();
        dynamic_sidebar( $sidebar );
    spyropress_after_sidebar();
echo '</aside>';