<?php

$options = get_post_meta( get_the_ID(), '_page_options', true );

if( empty( $options ) ) return;

if( isset( $options['slider'] ) && 'rev' == $options['slider'] ) {
    if( 'full' == $options['rev_slider_skin'] ) {
?>
<div class="slider-container slider-container-fullscreen hidden-xs">
    <?php
    ob_start();
        RevSliderOutput::putSlider( $options['rev_slider'], '' );
    $video = ob_get_clean();
    echo str_replace( '<video class="', '<video class="video-js vjs-default-skin manual', $video );
    ?>
</div>
<?php
    } else {
?>
<div class="slider-container <?php echo $options['rev_slider_skin'] ?>">
    <?php
    ob_start();
        RevSliderOutput::putSlider( $options['rev_slider'], '' );
    $video = ob_get_clean();
    echo str_replace( '<video class="', '<video class="video-js vjs-default-skin manual', $video );
    ?>
</div>
<?php
    }
}
elseif( isset( $options['slider'] ) && 'nivo' == $options['slider'] ) {
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
            <?php echo do_shortcode( '[slider id=' . $options['nivo_slider'] . ']' ) ?>
		</div>
	</div>
</div>
<?php }
$version = isset( $_GET['header'] ) ? $_GET['header'] :  get_setting( 'header_style', false );
if( isset( $options['slider'] ) && !is_page_template('one-page.php') && $version && 'v7' == $version )
    get_template_part( 'templates/header/header', 'v7-fallback' );