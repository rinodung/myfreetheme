<?php
/**
 * Review order form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.8
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<div class="panel panel-default" id="order_review">
	<div class="panel-heading">
		<h4 class="panel-title" id="order_review_heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
				<?php _e( 'Your order', 'woocommerce' ); ?>
			</a>
		</h4>
	</div>
	<div id="collapseFour" class="accordion-body collapse">
		<div class="panel-body">
            <table class="shop_table cart" cellspacing="0">
            	<thead>
            		<tr>
            			<th class="product-thumbnail">&nbsp;</th>
            			<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
            			<th class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></th>
            			<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
            			<th class="product-subtotal"><?php _e( 'Total', 'woocommerce' ); ?></th>
            		</tr>
            	</thead>
            	<tbody>
            		<?php do_action( 'woocommerce_before_cart_contents' ); ?>
            
            		<?php
            		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
            			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
            
            			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
            				?>
            				<tr class="cart_table_item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
            
            					<td class="product-thumbnail">
            						<?php
            							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                                        $thumbnail = str_replace( 'wp-post-image', 'img-responsive', $thumbnail );
            
            							if ( ! $_product->is_visible() )
            								echo $thumbnail;
            							else
            								printf( '<a href="%s">%s</a>', $_product->get_permalink(), $thumbnail );
            						?>
            					</td>
            
            					<td class="product-name">
            						<?php
            							if ( ! $_product->is_visible() )
            								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
            							else
            								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', $_product->get_permalink(), $_product->get_title() ), $cart_item, $cart_item_key );
            
            							// Meta data
            							echo WC()->cart->get_item_data( $cart_item );
            
                           				// Backorder notification
                           				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
                           					echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';
            						?>
            					</td>
            
            					<td class="product-price">
            						<?php
            							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
            						?>
            					</td>
            
            					<td class="product-quantity">
            						<?php echo $cart_item['quantity']; ?>
            					</td>
            
            					<td class="product-subtotal">
            						<?php
            							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
            						?>
            					</td>
            				</tr>
            				<?php
            			}
            		}
            
            		do_action( 'woocommerce_cart_contents' );
            		?>
            
            		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
            	</tbody>
            </table>
            
            <hr class="taller" >
        	
            <?php woocommerce_cart_totals(); ?>
            
            <hr class="taller" >

	       <?php do_action( 'woocommerce_review_order_before_payment' ); ?>

        	<div id="payment">
        		<?php if ( WC()->cart->needs_payment() ) : ?>
                
                <h4>Payment</h4>
                
        		<ul class="payment_methods methods list-unstyled">
        			<?php
        				$available_gateways = WC()->payment_gateways->get_available_payment_gateways();
        				if ( ! empty( $available_gateways ) ) {
        
        					// Chosen Method
        					if ( isset( WC()->session->chosen_payment_method ) && isset( $available_gateways[ WC()->session->chosen_payment_method ] ) ) {
        						$available_gateways[ WC()->session->chosen_payment_method ]->set_current();
        					} elseif ( isset( $available_gateways[ get_option( 'woocommerce_default_gateway' ) ] ) ) {
        						$available_gateways[ get_option( 'woocommerce_default_gateway' ) ]->set_current();
        					} else {
        						current( $available_gateways )->set_current();
        					}
        
        					foreach ( $available_gateways as $gateway ) {
        						?>
        						<li class="payment_method_<?php echo $gateway->id; ?>">
        							<input id="payment_method_<?php echo $gateway->id; ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />
        							<label for="payment_method_<?php echo $gateway->id; ?>"><?php echo $gateway->get_title(); ?> <?php echo $gateway->get_icon(); ?></label>
        							<?php
        								if ( $gateway->has_fields() || $gateway->get_description() ) :
        									echo '<div class="payment_box payment_method_' . $gateway->id . '" ' . ( $gateway->chosen ? '' : 'style="display:none;"' ) . '>';
        									$gateway->payment_fields();
        									echo '</div>';
        								endif;
        							?>
        						</li>
        						<?php
        					}
        				} else {
        
        					if ( ! WC()->customer->get_country() )
        						$no_gateways_message = __( 'Please fill in your details above to see available payment methods.', 'woocommerce' );
        					else
        						$no_gateways_message = __( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' );
        
        					echo '<p>' . apply_filters( 'woocommerce_no_available_payment_methods_message', $no_gateways_message ) . '</p>';
        
        				}
        			?>
        		</ul>
        		<?php endif; ?>
        
        		<div class="clear"></div>
        
        	</div>
        
        	<?php do_action( 'woocommerce_review_order_after_payment' ); ?>
        </div>
    </div>
</div>