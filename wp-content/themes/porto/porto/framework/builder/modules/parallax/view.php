<div class="parallax_section center"<?php echo spyropress_build_atts( array( 'background' => $background ), 'data-' ); ?>>
<?php

if( $icon )
    echo '<i class="fa fa-featured ' . $icon . '"' . spyropress_build_atts( array( 'animation' => $icon_animation ), 'data-appear-' ) . '></i>';

if( $title )
    echo '<h1 class="short text-shadow big bold ' . $skin . '"' . spyropress_build_atts( array( 'animation' => $title_animation ), 'data-appear-' ) . '><strong>' . $title . '</strong></h1>';

if( $teaser )
    echo '<h3 class="lead ' . $skin . '"' . spyropress_build_atts( array( 'animation' => $teaser_animation ), 'data-appear-' ) . '>' . $teaser . '</h3>';

?>
</div>