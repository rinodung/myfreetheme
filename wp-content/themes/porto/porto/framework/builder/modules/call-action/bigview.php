<?php

$class = is_str_contain( '[rotate_words]', $title ) ? 'word-rotator-title' : '';
if( $title )
    echo '<h2 class="' . $class . '">' . do_shortcode( $title ) . '</h2>';

?>
<div class="<?php get_row_class(); ?>">
	<div class="col-md-10">
		<p class="lead">
		  <?php echo do_shortcode( $sub_title ); ?>
		</p>
	</div>
	<div class="col-md-2">
		<?php
            $btn_url_text = ( $btn_url_text ) ? $btn_url_text : 'Button Text';
            $btn_url = ( $btn_link_url ) ? get_permalink( $btn_link_url ) : $btn_url;
            if ( $btn_url )
                echo '<a href="' . $btn_url . '" class="btn btn-lg btn-primary push-top">' . $btn_url_text . '</a>';
        ?>
	</div>
</div>