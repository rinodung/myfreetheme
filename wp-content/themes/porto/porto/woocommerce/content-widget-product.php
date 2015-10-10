<?php global $product; ?>
<li>
	<div class="post-image">
		<div class="img-thumbnail">
			<a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
                <?php echo str_replace( 'wp-post-image', 'img-responsive', $product->get_image() ); ?>
			</a>
		</div>
	</div>
	<div class="post-info">
		<a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>"><?php echo $product->get_title(); ?></a>
		<div class="post-meta">
			<?php echo $product->get_price_html(); ?>
            <?php if ( ! empty( $show_rating ) ) echo $product->get_rating_html(); ?>
		</div>
	</div>
    <div class="clear"></div>
</li>