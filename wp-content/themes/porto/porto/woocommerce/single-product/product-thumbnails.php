<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) {
	?>
    <div class="owl-carousel" data-plugin-options='{"items": 1, "autoHeight": true}'>
    <?php

		$loop = 0;
		$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

		foreach ( $attachment_ids as $attachment_id ) {

			$image_link = wp_get_attachment_url( $attachment_id );

			if ( ! $image_link )
				continue;

            $image       = str_replace( 'class="', 'class="img-responsive img-rounded ', wp_get_attachment_image( $attachment_id, 'large' ) );
			$image_class = esc_attr( 'zoom' );
			$image_title = esc_attr( get_the_title( $attachment_id ) );

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<div><div class="thumbnail"><a href="%s" class="%s" title="%s" data-rel="prettyPhoto[product-gallery]">%s</a></div></div>', $image_link, $image_class, $image_title, $image ), $attachment_id, $post->ID, $image_class );

			$loop++;
		}

	?></div>
	<?php
}