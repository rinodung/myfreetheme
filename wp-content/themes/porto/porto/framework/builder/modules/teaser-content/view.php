<div class="center">
<?php

$class = 'short';
if( is_str_contain( '[rotate_words]', $teaser1 ) )
    $class .= ' word-rotator-title';
if( $teaser1 )
    echo '<h2 class="' . $class . '">' . do_shortcode( $teaser1 ) . '</h2>';
if( $teaser2 ) {
    if( 'style1' == $style )
        echo '<p class="featured lead">' . do_shortcode( $teaser2 ) . '</p>';
    elseif( 'style2' == $style )
        echo '<h4 class="lead tall">' . do_shortcode( $teaser2 ) . '</h4>';
}
?>
</div>