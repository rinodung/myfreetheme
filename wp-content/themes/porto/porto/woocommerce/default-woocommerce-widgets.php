<?php
/**
 * Override WooCommerce default widgets for the markup
 */
class Spyropress_WC_Widget_Product_Tag_Cloud extends WC_Widget_Product_Tag_Cloud {

    public function widget( $args, $instance ) {

  		extract( $args );

		$current_taxonomy = $this->_get_current_taxonomy($instance);

		if ( empty( $instance['title'] ) ) {
			$tax   = get_taxonomy( $current_taxonomy );
			$title = apply_filters( 'widget_title', $tax->labels->name, $instance, $this->id_base );
		} else {
			$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		}

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;

		$cloud = wp_tag_cloud( apply_filters( 'woocommerce_product_tag_cloud_widget_args', array(
            'taxonomy' => $current_taxonomy,
            'unit' => 'px',
            'echo' => false
        ) ) );

        echo str_replace( "class='","class='label label-dark ", $cloud );

        echo $after_widget;

	}
}
register_widget( 'Spyropress_WC_Widget_Product_Tag_Cloud' );

class Spyropress_WC_Widget_Top_Rated_Products extends WC_Widget_Top_Rated_Products {

	public function widget($args, $instance) {

		if ( $this->get_cached_widget( $args ) )
			return;

		ob_start();
		extract( $args );

		$title  = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$number = absint( $instance['number'] );

		add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );

		$query_args = array('posts_per_page' => $number, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product' );

		$query_args['meta_query'] = WC()->query->get_meta_query();

		$r = new WP_Query( $query_args );

		if ( $r->have_posts() ) {

			echo $before_widget;

			if ( $title )
				echo $before_title . $title . $after_title;

			echo '<ul class="product_list_widget simple-post-list">';

			while ( $r->have_posts() ) {
				$r->the_post();
				wc_get_template( 'content-widget-product.php', array( 'show_rating' => true ) );
			}

			echo '</ul>';

			echo $after_widget;
		}

		remove_filter( 'posts_clauses', array( WC()->query, 'order_by_rating_post_clauses' ) );

		wp_reset_postdata();

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}
register_widget( 'Spyropress_WC_Widget_Top_Rated_Products' );

class Spyropress_Widget_Products extends WC_Widget_Products {

    public function widget( $args, $instance ) {

		if ( $this->get_cached_widget( $args ) )
			return;

		ob_start();
		extract( $args );

		$title       = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$number      = absint( $instance['number'] );
		$show        = sanitize_title( $instance['show'] );
		$orderby     = sanitize_title( $instance['orderby'] );
		$order       = sanitize_title( $instance['order'] );
		$show_rating = false;

    	$query_args = array(
    		'posts_per_page' => $number,
    		'post_status' 	 => 'publish',
    		'post_type' 	 => 'product',
    		'no_found_rows'  => 1,
    		'order'          => $order == 'asc' ? 'asc' : 'desc'
    	);

    	$query_args['meta_query'] = array();

    	if ( empty( $instance['show_hidden'] ) ) {
			$query_args['meta_query'][] = WC()->query->visibility_meta_query();
			$query_args['post_parent']  = 0;
		}

		if ( ! empty( $instance['hide_free'] ) ) {
    		$query_args['meta_query'][] = array(
			    'key'     => '_price',
			    'value'   => 0,
			    'compare' => '>',
			    'type'    => 'DECIMAL',
			);
    	}

	    $query_args['meta_query'][] = WC()->query->stock_status_meta_query();
	    $query_args['meta_query']   = array_filter( $query_args['meta_query'] );

    	switch ( $show ) {
    		case 'featured' :
    			$query_args['meta_query'][] = array(
					'key'   => '_featured',
					'value' => 'yes'
				);
    			break;
    		case 'onsale' :
    			$product_ids_on_sale = wc_get_product_ids_on_sale();
				$product_ids_on_sale[] = 0;
				$query_args['post__in'] = $product_ids_on_sale;
    			break;
    	}

    	switch ( $orderby ) {
			case 'price' :
				$query_args['meta_key'] = '_price';
    			$query_args['orderby']  = 'meta_value_num';
				break;
			case 'rand' :
    			$query_args['orderby']  = 'rand';
				break;
			case 'sales' :
				$query_args['meta_key'] = 'total_sales';
    			$query_args['orderby']  = 'meta_value_num';
				break;
			default :
				$query_args['orderby']  = 'date';
    	}

		$r = new WP_Query( $query_args );

		if ( $r->have_posts() ) {

			echo $before_widget;

			if ( $title )
				echo $before_title . $title . $after_title;

			echo '<ul class="product_list_widget simple-post-list">';

			while ( $r->have_posts()) {
				$r->the_post();
				wc_get_template( 'content-widget-product.php', array( 'show_rating' => $show_rating ) );
			}

			echo '</ul>';

			echo $after_widget;
		}

		wp_reset_postdata();

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}
register_widget( 'Spyropress_Widget_Products' );

class Spyropress_WC_Widget_Recently_Viewed extends WC_Widget_Recently_Viewed {

    function widget($args, $instance) {

		$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
		$viewed_products = array_filter( array_map( 'absint', $viewed_products ) );

		if ( empty( $viewed_products ) )
			return;

		ob_start();
		extract( $args );

		$title  = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$number = absint( $instance['number'] );

	    $query_args = array( 'posts_per_page' => $number, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product', 'post__in' => $viewed_products, 'orderby' => 'rand' );

		$query_args['meta_query'] = array();
	    $query_args['meta_query'][] = WC()->query->stock_status_meta_query();
	    $query_args['meta_query'] = array_filter( $query_args['meta_query'] );

		$r = new WP_Query($query_args);

		if ( $r->have_posts() ) {

			echo $before_widget;

			if ( $title )
				echo $before_title . $title . $after_title;

			echo '<ul class="product_list_widget simple-post-list">';

			while ( $r->have_posts()) {
				$r->the_post();
				wc_get_template( 'content-widget-product.php' );
			}

			echo '</ul>';

			echo $after_widget;
		}

		wp_reset_postdata();

		$content = ob_get_clean();

		echo $content;
	}

    function widgets($args, $instance) {

		$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
		$viewed_products = array_filter( array_map( 'absint', $viewed_products ) );

		if ( empty( $viewed_products ) )
			return;

		ob_start();
		extract( $args );

		$title  = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$number = absint( $instance['number'] );

	    $query_args = array( 'posts_per_page' => $number, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product', 'post__in' => $viewed_products, 'orderby' => 'rand' );

		$query_args['meta_query'] = array();
	    $query_args['meta_query'][] = WC()->query->stock_status_meta_query();
	    $query_args['meta_query'] = array_filter( $query_args['meta_query'] );

		$r = new WP_Query($query_args);

		if ( $r->have_posts() ) {

			echo $before_widget;

			if ( $title )
				echo $before_title . $title . $after_title;

			echo '<ul class="simple-post-list">';
            global $woocommerce;
            $product = new WC_Product(get_the_ID());

			while ( $r->have_posts()) {
				$r->the_post();
				$image_tag = get_image(array('width' => 60 , 'echo'=> false , 'type' => 'src'));
                    echo '<li>
				            <div class="post-image">
								<div class="img-thumbnail">
									<a href="'. get_permalink() .'">
										<img alt="" class="img-responsive" src="'. $image_tag .'">
									</a>
								</div>
							</div>
                            <div class="post-info">
								<a href="'. get_permalink() .'">'.get_the_title() .'</a>
								<div class="post-meta">
									'. $product->get_price_html() .'
								</div>
							</div>
				          </li>';
			}

			echo '</ul>';

			echo $after_widget;
		}
    }

}
register_widget( 'Spyropress_WC_Widget_Recently_Viewed' );


class Spyropress_WC_Widget_Recent_Reviews extends WC_Widget_Recent_Reviews {

    public function widget( $args, $instance ) {
		global $comments, $comment, $woocommerce;

		if ( $this->get_cached_widget( $args ) )
			return;

		ob_start();
		extract( $args );

		$title    = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$number   = absint( $instance['number'] );
		$comments = get_comments( array( 'number' => $number, 'status' => 'approve', 'post_status' => 'publish', 'post_type' => 'product' ) );

		if ( $comments ) {
			echo $before_widget;
			if ( $title ) echo $before_title . $title . $after_title;
			echo '<ul class="product_list_widget simple-post-list">';

			foreach ( (array) $comments as $comment ) {

				$_product = get_product( $comment->comment_post_ID );

				$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

				$rating_html = $_product->get_rating_html( $rating );

                echo '
                <li>
                	<div class="post-image">
                		<div class="img-thumbnail">
                			<a href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '">
                                ' . str_replace( 'wp-post-image', 'img-responsive', $_product->get_image() ) . '
                			</a>
                		</div>
                	</div>
                	<div class="post-info">
                		<a href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '">' . $_product->get_title() . '</a>
                		<div class="post-meta">
                			' . $rating_html . '
                            ' . sprintf( '<span class="reviewer">' . _x( 'by %1$s', 'by comment author', 'woocommerce' ) . '</span>', get_comment_author() ) . '
                		</div>
                	</div>
                    <div class="clear"></div>
                </li>';
			}

			echo '</ul>';
			echo $after_widget;
		}

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}
register_widget( 'Spyropress_WC_Widget_Recent_Reviews' );

class Spyropress_WC_Widget_Layered_Nav extends WC_Widget_Layered_Nav {

    public function widget( $args, $instance ) {
		global $_chosen_attributes;

		extract( $args );

		if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) )
			return;

		$current_term 	= is_tax() ? get_queried_object()->term_id : '';
		$current_tax 	= is_tax() ? get_queried_object()->taxonomy : '';
		$title 			= apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
		$taxonomy 		= isset( $instance['attribute'] ) ? wc_attribute_taxonomy_name($instance['attribute']) : '';
		$query_type 	= isset( $instance['query_type'] ) ? $instance['query_type'] : 'and';
		$display_type 	= isset( $instance['display_type'] ) ? $instance['display_type'] : 'list';

		if ( ! taxonomy_exists( $taxonomy ) )
			return;

	    $get_terms_args = array( 'hide_empty' => '1' );

		$orderby = wc_attribute_orderby( $taxonomy );

		switch ( $orderby ) {
			case 'name' :
				$get_terms_args['orderby']    = 'name';
				$get_terms_args['menu_order'] = false;
			break;
			case 'id' :
				$get_terms_args['orderby']    = 'id';
				$get_terms_args['order']      = 'ASC';
				$get_terms_args['menu_order'] = false;
			break;
			case 'menu_order' :
				$get_terms_args['menu_order'] = 'ASC';
			break;
		}

		$terms = get_terms( $taxonomy, $get_terms_args );

		if ( count( $terms ) > 0 ) {

			ob_start();

			$found = false;

			echo $before_widget . $before_title . $title . $after_title;

			// Force found when option is selected - do not force found on taxonomy attributes
			if ( ! is_tax() && is_array( $_chosen_attributes ) && array_key_exists( $taxonomy, $_chosen_attributes ) )
				$found = true;

			if ( $display_type == 'dropdown' ) {

				// skip when viewing the taxonomy
				if ( $current_tax && $taxonomy == $current_tax ) {

					$found = false;

				} else {

					$taxonomy_filter = str_replace( 'pa_', '', $taxonomy );

					$found = false;

					echo '<select id="dropdown_layered_nav_' . $taxonomy_filter . '">';

					echo '<option value="">' . sprintf( __( 'Any %s', 'woocommerce' ), wc_attribute_label( $taxonomy ) ) .'</option>';

					foreach ( $terms as $term ) {

						// If on a term page, skip that term in widget list
						if ( $term->term_id == $current_term )
							continue;

						// Get count based on current view - uses transients
						$transient_name = 'wc_ln_count_' . md5( sanitize_key( $taxonomy ) . sanitize_key( $term->term_id ) );

						if ( false === ( $_products_in_term = get_transient( $transient_name ) ) ) {

							$_products_in_term = get_objects_in_term( $term->term_id, $taxonomy );

							set_transient( $transient_name, $_products_in_term, YEAR_IN_SECONDS );
						}

						$option_is_set = ( isset( $_chosen_attributes[ $taxonomy ] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) );

						// If this is an AND query, only show options with count > 0
						if ( $query_type == 'and' ) {

							$count = sizeof( array_intersect( $_products_in_term, WC()->query->filtered_product_ids ) );

							if ( $count > 0 )
								$found = true;

							if ( $count == 0 && ! $option_is_set )
								continue;

						// If this is an OR query, show all options so search can be expanded
						} else {

							$count = sizeof( array_intersect( $_products_in_term, WC()->query->unfiltered_product_ids ) );

							if ( $count > 0 )
								$found = true;

						}

						echo '<option value="' . esc_attr( $term->term_id ) . '" '.selected( isset( $_GET[ 'filter_' . $taxonomy_filter ] ) ? $_GET[ 'filter_' .$taxonomy_filter ] : '' , $term->term_id, false ) . '>' . $term->name . '</option>';
					}

					echo '</select>';

					wc_enqueue_js("

						jQuery('#dropdown_layered_nav_$taxonomy_filter').change(function(){

							location.href = '" . esc_url_raw( preg_replace( '%\/page/[0-9]+%', '', add_query_arg('filtering', '1', remove_query_arg( array( 'page', 'filter_' . $taxonomy_filter ) ) ) ) ) . "&filter_$taxonomy_filter=' + jQuery('#dropdown_layered_nav_$taxonomy_filter').val();

						});

					");

				}

			} else {

				// List display
				echo "<ul class='nav nav-list primary push-bottom'>";

				foreach ( $terms as $term ) {

					// Get count based on current view - uses transients
					$transient_name = 'wc_ln_count_' . md5( sanitize_key( $taxonomy ) . sanitize_key( $term->term_id ) );

					if ( false === ( $_products_in_term = get_transient( $transient_name ) ) ) {

						$_products_in_term = get_objects_in_term( $term->term_id, $taxonomy );

						set_transient( $transient_name, $_products_in_term );
					}

					$option_is_set = ( isset( $_chosen_attributes[ $taxonomy ] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) );

					// skip the term for the current archive
					if ( $current_term == $term->term_id )
						continue;

					// If this is an AND query, only show options with count > 0
					if ( $query_type == 'and' ) {

						$count = sizeof( array_intersect( $_products_in_term, WC()->query->filtered_product_ids ) );

						if ( $count > 0 && $current_term !== $term->term_id )
							$found = true;

						if ( $count == 0 && ! $option_is_set )
							continue;

					// If this is an OR query, show all options so search can be expanded
					} else {

							$count = sizeof( array_intersect( $_products_in_term, WC()->query->unfiltered_product_ids ) );

							if ( $count > 0 )
								$found = true;

					}

					$arg = 'filter_' . sanitize_title( $instance['attribute'] );

					$current_filter = ( isset( $_GET[ $arg ] ) ) ? explode( ',', $_GET[ $arg ] ) : array();

					if ( ! is_array( $current_filter ) )
						$current_filter = array();

					$current_filter = array_map( 'esc_attr', $current_filter );

					if ( ! in_array( $term->term_id, $current_filter ) )
						$current_filter[] = $term->term_id;

					// Base Link decided by current page
					if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
						$link = home_url();
					} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id('shop') ) ) {
						$link = get_post_type_archive_link( 'product' );
					} else {
						$link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
					}

					// All current filters
					if ( $_chosen_attributes ) {
						foreach ( $_chosen_attributes as $name => $data ) {
							if ( $name !== $taxonomy ) {

								// Exclude query arg for current term archive term
								while ( in_array( $current_term, $data['terms'] ) ) {
									$key = array_search( $current_term, $data );
									unset( $data['terms'][$key] );
								}

								// Remove pa_ and sanitize
								$filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );

								if ( ! empty( $data['terms'] ) )
									$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );

								if ( $data['query_type'] == 'or' )
									$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
							}
						}
					}

					// Min/Max
					if ( isset( $_GET['min_price'] ) )
						$link = add_query_arg( 'min_price', $_GET['min_price'], $link );

					if ( isset( $_GET['max_price'] ) )
						$link = add_query_arg( 'max_price', $_GET['max_price'], $link );

					// Orderby
					if ( isset( $_GET['orderby'] ) )
						$link = add_query_arg( 'orderby', $_GET['orderby'], $link );

					// Current Filter = this widget
					if ( isset( $_chosen_attributes[ $taxonomy ] ) && is_array( $_chosen_attributes[ $taxonomy ]['terms'] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) ) {

						$class = 'class="chosen"';

						// Remove this term is $current_filter has more than 1 term filtered
						if ( sizeof( $current_filter ) > 1 ) {
							$current_filter_without_this = array_diff( $current_filter, array( $term->term_id ) );
							$link = add_query_arg( $arg, implode( ',', $current_filter_without_this ), $link );
						}

					} else {

						$class = '';
						$link = add_query_arg( $arg, implode( ',', $current_filter ), $link );

					}

					// Search Arg
					if ( get_search_query() )
						$link = add_query_arg( 's', get_search_query(), $link );

					// Post Type Arg
					if ( isset( $_GET['post_type'] ) )
						$link = add_query_arg( 'post_type', $_GET['post_type'], $link );

					// Query type Arg
					if ( $query_type == 'or' && ! ( sizeof( $current_filter ) == 1 && isset( $_chosen_attributes[ $taxonomy ]['terms'] ) && is_array( $_chosen_attributes[ $taxonomy ]['terms'] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) ) )
						$link = add_query_arg( 'query_type_' . sanitize_title( $instance['attribute'] ), 'or', $link );

					echo '<li ' . $class . '>';

					echo ( $count > 0 || $option_is_set ) ? '<a href="' . esc_url( apply_filters( 'woocommerce_layered_nav_link', $link ) ) . '">' : '<span>';

					echo $term->name;

                    echo ' <small class="count">(' . $count . ')</small>';

					echo ( $count > 0 || $option_is_set ) ? '</a>' : '</span>';

					echo '</li>';

				}

				echo "</ul>";

			} // End display type conditional

			echo $after_widget;

			if ( ! $found )
				ob_end_clean();
			else
				echo ob_get_clean();
		}
	}
}
register_widget( 'Spyropress_WC_Widget_Layered_Nav' );

class Spyropress_Widget_Price_Filter extends WC_Widget_Price_Filter {
    
    public function widget( $args, $instance ) {
		global $_chosen_attributes, $wpdb, $woocommerce, $wp_query, $wp;

		extract( $args );

		if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) )
			return;

		if ( sizeof( WC()->query->unfiltered_product_ids ) == 0 )
			return; // None shown - return

		$min_price = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '';
		$max_price = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : '';

		wp_enqueue_script( 'wc-price-slider' );

		$title  = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		// Remember current filters/search
		$fields = '';

		if ( get_search_query() )
			$fields .= '<input type="hidden" name="s" value="' . get_search_query() . '" />';

		if ( ! empty( $_GET['post_type'] ) )
			$fields .= '<input type="hidden" name="post_type" value="' . esc_attr( $_GET['post_type'] ) . '" />';

		if ( ! empty ( $_GET['product_cat'] ) )
			$fields .= '<input type="hidden" name="product_cat" value="' . esc_attr( $_GET['product_cat'] ) . '" />';

		if ( ! empty( $_GET['product_tag'] ) )
			$fields .= '<input type="hidden" name="product_tag" value="' . esc_attr( $_GET['product_tag'] ) . '" />';

		if ( ! empty( $_GET['orderby'] ) )
			$fields .= '<input type="hidden" name="orderby" value="' . esc_attr( $_GET['orderby'] ) . '" />';

		if ( $_chosen_attributes ) foreach ( $_chosen_attributes as $attribute => $data ) {

			$taxonomy_filter = 'filter_' . str_replace( 'pa_', '', $attribute );

			$fields .= '<input type="hidden" name="' . esc_attr( $taxonomy_filter ) . '" value="' . esc_attr( implode( ',', $data['terms'] ) ) . '" />';

			if ( $data['query_type'] == 'or' )
				$fields .= '<input type="hidden" name="' . esc_attr( str_replace( 'pa_', 'query_type_', $attribute ) ) . '" value="or" />';
		}

		$min = $max = 0;
		$post_min = $post_max = '';

		if ( sizeof( WC()->query->layered_nav_product_ids ) === 0 ) {
			$min = floor( $wpdb->get_var(
				$wpdb->prepare('
					SELECT min(meta_value + 0)
					FROM %1$s
					LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
					WHERE ( meta_key = \'%3$s\' OR meta_key = \'%4$s\' ) 
					AND meta_value != ""
				', $wpdb->posts, $wpdb->postmeta, '_price', '_min_variation_price' )
			) );
			$max = ceil( $wpdb->get_var(
				$wpdb->prepare('
					SELECT max(meta_value + 0)
					FROM %1$s
					LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
					WHERE meta_key = \'%3$s\'
				', $wpdb->posts, $wpdb->postmeta, '_price' )
			) );
		} else {
			$min = floor( $wpdb->get_var(
				$wpdb->prepare('
					SELECT min(meta_value + 0)
					FROM %1$s
					LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
					WHERE ( meta_key =\'%3$s\' OR meta_key =\'%4$s\' ) 
					AND meta_value != ""
					AND (
						%1$s.ID IN (' . implode( ',', array_map( 'absint', WC()->query->layered_nav_product_ids ) ) . ')
						OR (
							%1$s.post_parent IN (' . implode( ',', array_map( 'absint', WC()->query->layered_nav_product_ids ) ) . ')
							AND %1$s.post_parent != 0
						)
					)
				', $wpdb->posts, $wpdb->postmeta, '_price', '_min_variation_price'
			) ) );
			$max = ceil( $wpdb->get_var(
				$wpdb->prepare('
					SELECT max(meta_value + 0)
					FROM %1$s
					LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
					WHERE meta_key =\'%3$s\'
					AND (
						%1$s.ID IN (' . implode( ',', array_map( 'absint', WC()->query->layered_nav_product_ids ) ) . ')
						OR (
							%1$s.post_parent IN (' . implode( ',', array_map( 'absint', WC()->query->layered_nav_product_ids ) ) . ')
							AND %1$s.post_parent != 0
						)
					)
				', $wpdb->posts, $wpdb->postmeta, '_price'
			) ) );
		}

		if ( $min == $max )
			return;

		echo $before_widget . $before_title . $title . $after_title;

		if ( get_option( 'permalink_structure' ) == '' )
			$form_action = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
		else
			$form_action = preg_replace( '%\/page/[0-9]+%', '', home_url( $wp->request ) );

		echo '<form method="get" action="' . esc_attr( $form_action ) . '">
			<div class="price_slider_wrapper">
				<div class="price_slider" style="display:none;"></div>
				<div class="price_slider_amount">
					<input type="text" id="min_price" name="min_price" value="' . esc_attr( $min_price ) . '" data-min="'.esc_attr( $min ).'" placeholder="'.__('Min price', 'woocommerce' ).'" />
					<input type="text" id="max_price" name="max_price" value="' . esc_attr( $max_price ) . '" data-max="'.esc_attr( $max ).'" placeholder="'.__( 'Max price', 'woocommerce' ).'" />
					<div class="price_label pull-right" style="display:none;">
						'.__( 'Price:', 'woocommerce' ).' <span class="from"></span> &mdash; <span class="to"></span>
					</div>
                    <button type="submit" class="btn btn-primary">'.__( 'Filter', 'woocommerce' ).'</button>
					' . $fields . '
					<div class="clear"></div>
				</div>
			</div>
		</form>';

		echo $after_widget;
	}
}
register_widget( 'Spyropress_Widget_Price_Filter' );

class Spyropress_WC_Widget_Layered_Nav_Filters extends WC_Widget_Layered_Nav_Filters {


	public function widget( $args, $instance ) {
		global $_chosen_attributes, $woocommerce;

		extract( $args );

		if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) )
			return;

		$current_term 	= is_tax() ? get_queried_object()->term_id : '';
		$current_tax 	= is_tax() ? get_queried_object()->taxonomy : '';
		$title          = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		// Price
		$min_price = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : 0;
		$max_price = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : 0;

		if ( count( $_chosen_attributes ) > 0 || $min_price > 0 || $max_price > 0 ) {

			echo $before_widget;
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}

			echo '<ul class="nav nav-list primary push-bottom">';

			// Attributes
			if (!is_null($_chosen_attributes)){
				foreach ( $_chosen_attributes as $taxonomy => $data ) {

					foreach ( $data['terms'] as $term_id ) {
						$term 				= get_term( $term_id, $taxonomy );
						$taxonomy_filter 	= str_replace( 'pa_', '', $taxonomy );
						$current_filter 	= ! empty( $_GET[ 'filter_' . $taxonomy_filter ] ) ? $_GET[ 'filter_' . $taxonomy_filter ] : '';
						$new_filter			= array_map( 'absint', explode( ',', $current_filter ) );
						$new_filter			= array_diff( $new_filter, array( $term_id ) );

						$link = remove_query_arg( 'filter_' . $taxonomy_filter );

						if ( sizeof( $new_filter ) > 0 )
							$link = add_query_arg( 'filter_' . $taxonomy_filter, implode( ',', $new_filter ), $link );

						echo '<li class="chosen"><a title="' . __( 'Remove filter', 'woocommerce' ) . '" href="' . esc_url( $link ) . '">' . $term->name . '</a></li>';
					}
				}
			}

			if ( $min_price ) {
				$link = remove_query_arg( 'min_price' );
				echo '<li class="chosen"><a title="' . __( 'Remove filter', 'woocommerce' ) . '" href="' . esc_url( $link ) . '">' . __( 'Min', 'woocommerce' ) . ' ' . wc_price( $min_price ) . '</a></li>';
			}

			if ( $max_price ) {
				$link = remove_query_arg( 'max_price' );
				echo '<li class="chosen"><a title="' . __( 'Remove filter', 'woocommerce' ) . '" href="' . esc_url( $link ) . '">' . __( 'Max', 'woocommerce' ) . ' ' . wc_price( $max_price ) . '</a></li>';
			}

			echo "</ul>";

			echo $after_widget;
		}
	}
}

register_widget( 'Spyropress_WC_Widget_Layered_Nav_Filters' );