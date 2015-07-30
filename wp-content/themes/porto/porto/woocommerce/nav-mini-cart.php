<li class="dropdown mega-menu-item mega-menu-shop">
	<a class="dropdown-toggle mobile-redirect" href="<?php echo WC()->cart->get_cart_url(); ?>">
		<i class="icon icon-shopping-cart"></i> <?php echo $item->title ?> (<?php echo WC()->cart->get_cart_contents_count(); ?>) - <?php echo WC()->cart->get_cart_total(); ?>
		<i class="icon icon-angle-down"></i>
	</a>
	<ul class="dropdown-menu">
		<li>
			<div class="mega-menu-content">
				<div class="row">
					<div class="col-md-12">

                        <?php do_action( 'woocommerce_before_mini_cart' ); ?>

						<table cellspacing="0" class="cart">
							<tbody>
                                <?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

                                <?php
                        			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                        				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                        				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                        				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

                        					$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
                        					$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'shop_thumbnail' ), $cart_item, $cart_item_key );
                        					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );

                        					?>
                                            <tr>
            									<td class="product-thumbnail">
            										<a href="<?php echo get_permalink( $product_id ); ?>">
            											<?php echo str_replace( 'wp-post-image', 'img-responsive', $thumbnail ); ?>
            										</a>
            									</td>
            									<td class="product-name">
            										<a href="<?php echo get_permalink( $product_id ); ?>"><?php echo $product_name; ?><br><span class="amount"><strong><?php echo $product_price; ?></strong></span></a>
            									</td>
            									<td class="product-actions">
            										<?php
                            							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s"><i class="icon icon-times"></i></a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'spyropress' ) ), $cart_item_key );
                            						?>
            									</td>
            								</tr>
                        					<?php
                        				}
                        			}
                        		?>

                                <?php else : ?>

                                <tr>
                                    <td>
                                        <?php _e( 'No products in the cart.', 'woocommerce' ); ?>
                                    </td>
                                </tr>

                                <?php endif; ?>

                                <?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

                                <tr>
									<td class="actions" colspan="6">

                                        <?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

										<div class="actions-continue">
											<input onclick="javascript:window.location='<?php echo WC()->cart->get_cart_url(); ?>'" type="submit" value="<?php _e( 'View Cart', 'spyropress' ); ?>" class="btn btn-default">
											<input onclick="javascript:window.location='<?php echo WC()->cart->get_checkout_url(); ?>'" type="submit" value="<?php _e( 'Proceed to Checkout &raquo;', 'spyropress' ); ?>" name="proceed" class="btn pull-right btn-primary checkout">
										</div>
                                        
									</td>
								</tr>

                                <?php endif; ?>
							</tbody>
						</table>

                        <?php do_action( 'woocommerce_after_mini_cart' ); ?>

					</div>
				</div>
			</div>
		</li>
	</ul>
</li>