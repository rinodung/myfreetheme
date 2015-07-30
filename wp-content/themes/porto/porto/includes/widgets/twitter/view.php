<?php 

echo $before_widget;

if ( $title ) echo $before_title . $title . $after_title;
echo '
<div id="tweet_' . $this->id . '" class="latest-tweets twitter" data-plugin-tweets data-plugin-options=\'{"username": "' . $username . '", "count": ' . $post_count . ' }\'>
    <p>Please wait...</p>
</div>';  

echo $after_widget;