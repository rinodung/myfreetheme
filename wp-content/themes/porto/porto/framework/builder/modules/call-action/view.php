<?php
if( isset( $instance['template'] ) )
    echo $before_widget;
?>
<div class="<?php get_row_class(); ?>">
	<div class="col-md-8">
		<p>
		<?php
            echo do_shortcode( $title );
            
            if( $sub_title ) echo '<span>' . do_shortcode( $sub_title ) . '</span>';
        ?>
		</p>
	</div>
	<div class="col-md-4">
		<div class="get-started">
		<?php
            $btn_url_text = ( $btn_url_text ) ? $btn_url_text : 'Button Text';
            $btn_url = ( $btn_link_url ) ? get_permalink( $btn_link_url ) : $btn_url;
            if ( $btn_url )
                echo '<a href="' . $btn_url . '" class="btn btn-lg btn-primary">' . $btn_url_text . '</a>';
            
            $url_text = ( $url_text ) ? $url_text : 'link text';
            $url = ( $link_url ) ? get_permalink( $link_url ) : $url;
            if ( $url )
                echo '<div class="learn-more"><a href="' . $url . '">' . $url_text . '</a></div>';
        ?>
		</div>
	</div>
</div>
<?php

if( isset( $instance['template'] ) )
    echo $after_widget;
?>