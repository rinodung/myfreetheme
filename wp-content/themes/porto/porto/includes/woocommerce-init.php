<?php

/** Check if WooCommerce is enabled? */
if( !class_exists( 'WooCommerce' ) ) return;


/**
 * Disable WooCommerce Style
 */
if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
	// WooCommerce 2.1 or above is active
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
} else {
	// WooCommerce is less than 2.1
	define( 'WOOCOMMERCE_USE_CSS', false );
}

/** Remove Page Title. */
add_filter( 'woocommerce_show_page_title', '__return_false' );

/** Remove Breadcrumb */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

/** Remove Loop Result Count and Ordering */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

/** Add Shop Header */
function spyropress_wc_shop_header() {
    
    if( is_single() ) return;
    
    wc_get_template_part( 'global/shop', 'header' );   
}
add_action( 'woocommerce_before_main_content', 'spyropress_wc_shop_header' );

/** Remove Sidebar */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/** Set Products Per Page */
function spyropress_wc_products_per_page( $limit ) {
    
    return get_setting( 'shop_loop_product_per_page', $limit );
}
add_filter( 'loop_shop_per_page', 'spyropress_wc_products_per_page' );

/** Set Number of Columns */
function spyropress_wc_loop_columns( $cols ) {
    
    return get_setting( 'shop_loop_product_columns', $cols );
}
add_filter( 'loop_shop_columns', 'spyropress_wc_loop_columns' );

/** Remove and Re-position Sale-Flash */
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_show_product_loop_sale_flash', 10 );

/** Remove and Re-position Add-to-Cart button */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );

/** Remove and Re-position Thumbnail */
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

function spyropress_wc_product_thumbnail() {
    
    $image = '';
    
    if ( has_post_thumbnail() ) {
        $image = get_image( array( 'echo' => false, 'class' => 'img-responsive' ) );
    }
    elseif ( wc_placeholder_img_src() ) {
        $image = wc_placeholder_img( 'shop_single' );
    }
        
    echo '
    <a href="'. get_permalink().'">
		<span class="product-thumb-info-image">
			<span class="product-thumb-info-act">
				<span class="product-thumb-info-act-left"><em>' . __( 'View' , 'spyropress' ) . '</em></span>
				<span class="product-thumb-info-act-right"><em><i class="icon icon-plus"></i> ' . __( 'Details' , 'spyropress' ) . '</em></span>
			</span>
			' . str_replace( 'wp-post-image', 'img-responsive', $image ) . '
		</span>
	</a>';      
}
add_action( 'woocommerce_before_shop_loop_item_title', 'spyropress_wc_product_thumbnail', 10 );

/** Remove rating and price form shop page. */
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

/** Remove and Re-position pagination */
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

function woocommerceframework_pagination() {
    
    $features = get_setting_array( 'shop_loop_top_bar', array() );
    
    $pagination_pos = get_setting( 'shop_pagination_pos', 'bottom' );
    
    if( in_array( 'pagination', $features ) && $pagination_pos && ( 'bottom' == $pagination_pos || 'both' == $pagination_pos )  ) {
        $args = array(
            'container_class' => 'pagination pagination-lg pull-right',
            'echo' => false  
        );
        
        echo '<div class="row"><div class="col-md-12">'. wp_pagenavi( $args ) .'</div></div>';
    }
}
add_action( 'woocommerce_after_shop_loop', 'woocommerceframework_pagination' );

/**
 * Init Default widgets Override
 */

function spyropress_woocommerce_widget() {
    get_template_part( 'woocommerce/default-woocommerce', 'widgets' );
}
add_action( 'widgets_init', 'spyropress_woocommerce_widget', 15 );

/** Enable/Disable Features */
function spyropress_wc_disable_enable_features() {
    
	/** Display product tabs? */
    if ( get_setting( 'shop_single_tabs', false ) )
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
    
    /** Display related products? */
    if ( get_setting( 'shop_related_items', false ) )
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
    
    /** Display cross-sell products? */
    if ( get_setting( 'shop_related_items', false ) )
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
}
add_action( 'wp_head','spyropress_wc_disable_enable_features' );

/**
 * Single Product
 */


/** Remove and Re-position Sale-Flash */
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

/** Gallery */
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_thumbnails', 20 );

/** Enable Social Sharing */
function spyropress_wc_social_sharing() {
    if( !get_setting( 'shop_single_sharing', false ) ) return;
    
    get_template_part( 'templates/add', 'this' );
}
add_action( 'woocommerce_share', 'spyropress_wc_social_sharing', 10 );

/** Set limit and column on related products */
function spyropress_wc_related_products_args( $args ) {
    
    $args['posts_per_page'] = get_setting( 'shop_related_items_limit', $args['posts_per_page'] );
    $args['columns'] = get_setting( 'shop_related_columns', $args['columns'] );
    
    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'spyropress_wc_related_products_args' );


/** Remove UpSell */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

/** Set limit and column on upsell products */
function spyropress_wc_upsell_display( $args ) {
    
    if ( get_setting( 'shop_upsell', false ) ) return;
    
    $limit = get_setting( 'shop_upsell_limit' , 4 );
    $columns = get_setting( 'shop_upsell_columns' , 4 );
    
    woocommerce_upsell_display( $limit, $columns );
}
add_action ( 'woocommerce_after_single_product_summary', 'spyropress_wc_upsell_display', 15 );

/** Remove Cross Sell */
remove_action ( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

/** Set limit and column on cross-sell products */
function spyropress_wc_cross_sell_display( $args ) {
    
    if ( get_setting( 'shop_cross_sell', false ) ) return;
    
    $limit = get_setting( 'shop_cross_sell_limit' , 4 );
    $columns = get_setting( 'shop_cross_sell_columns' , 4 );
    
    woocommerce_cross_sell_display( $limit, $columns );
}
add_action ( 'woocommerce_cart_collaterals', 'spyropress_wc_cross_sell_display', 15 );

/**
 * Checkout Page
 */
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

function spyropress_wc_override_checkout_fields( $fields ) {
    
    print_r($fields);exit;
    return $fields;
    
}
//add_filter( 'woocommerce_checkout_fields' , 'spyropress_wc_override_checkout_fields' );

if ( ! function_exists( 'woocommerce_form_field' ) ) {

	/**
	 * Outputs a checkout/address form field.
	 *
	 * @access public
	 * @subpackage	Forms
	 * @param mixed $key
	 * @param mixed $args
	 * @param string $value (default: null)
	 * @return void
	 * @todo This function needs to be broken up in smaller pieces 
	 */
	function woocommerce_form_field( $key, $args, $value = null ) {
		$defaults = array(
			'type'              => 'text',
			'label'             => '',
			'placeholder'       => '',
			'maxlength'         => false,
			'required'          => false,
			'class'             => array(),
			'label_class'       => array(),
			'input_class'       => array(),
			'return'            => false,
			'options'           => array(),
			'custom_attributes' => array(),
			'validate'          => array(),
			'default'		    => '',
		);

		$args = wp_parse_args( $args, $defaults  );

		if ( ( ! empty( $args['clear'] ) ) ) $after = '<div class="clear"></div>'; else $after = '';

		if ( $args['required'] ) {
			$args['class'][] = 'validate-required';
			$required = ' <small class="required">*</small>';
		} else {
			$required = '';
		}

		$args['maxlength'] = ( $args['maxlength'] ) ? 'maxlength="' . absint( $args['maxlength'] ) . '"' : '';

		if ( is_string( $args['label_class'] ) )
			$args['label_class'] = array( $args['label_class'] );

		if ( is_null( $value ) )
			$value = $args['default'];

		// Custom attribute handling
		$custom_attributes = array();

		if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) )
			foreach ( $args['custom_attributes'] as $attribute => $attribute_value )
				$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';

		if ( ! empty( $args['validate'] ) )
			foreach( $args['validate'] as $validate )
				$args['class'][] = 'validate-' . $validate;

        switch ( $args['type'] ) {
		case "country" :

			$countries = $key == 'shipping_country' ? WC()->countries->get_shipping_countries() : WC()->countries->get_allowed_countries();

			if ( sizeof( $countries ) == 1 ) {

				$field = '<div class="row ' . esc_attr( implode( ' ', $args['class'] ) ) .'" id="' . esc_attr( $key ) . '_field"><div class="form-group"><div class="col-md-12">';

				if ( $args['label'] )
					$field .= '<label class="' . implode( ' ', $args['label_class'] ) .'">' . $args['label']  . '</label>';

				$field .= '<strong>' . current( array_values( $countries ) ) . '</strong>';

				$field .= '<input type="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" value="' . current( array_keys($countries ) ) . '" ' . implode( ' ', $custom_attributes ) . ' class="country_to_state" />';

				$field .= '</div></div></div>' . $after;

			} else {

				$field = '<div class="row ' . esc_attr( implode( ' ', $args['class'] ) ) .'" id="' . esc_attr( $key ) . '_field"><div class="form-group"><div class="col-md-12">'
						. '<label for="' . esc_attr( $key ) . '" class="' . implode( ' ', $args['label_class'] ) .'">' . $args['label'] . $required  . '</label>'
						. '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" class="country_to_state form-control country_select" ' . implode( ' ', $custom_attributes ) . '>'
						. '<option value="">'.__( 'Select a country&hellip;', 'woocommerce' ) .'</option>';

				foreach ( $countries as $ckey => $cvalue )
					$field .= '<option value="' . esc_attr( $ckey ) . '" '.selected( $value, $ckey, false ) .'>'.__( $cvalue, 'woocommerce' ) .'</option>';

				$field .= '</select>';

				$field .= '<noscript><input type="submit" name="woocommerce_checkout_update_totals" value="' . __( 'Update country', 'woocommerce' ) . '" /></noscript>';

				$field .= '</div></div></div>' . $after;

			}

			break;
		case "state" :

			/* Get Country */
			$country_key = $key == 'billing_state'? 'billing_country' : 'shipping_country';

			if ( isset( $_POST[ $country_key ] ) ) {
				$current_cc = wc_clean( $_POST[ $country_key ] );
			} elseif ( is_user_logged_in() ) {
				$current_cc = get_user_meta( get_current_user_id() , $country_key, true );
				if ( ! $current_cc) {
					$current_cc = apply_filters('default_checkout_country', (WC()->customer->get_country()) ? WC()->customer->get_country() : WC()->countries->get_base_country());
				}
			} elseif ( $country_key == 'billing_country' ) {
				$current_cc = apply_filters('default_checkout_country', (WC()->customer->get_country()) ? WC()->customer->get_country() : WC()->countries->get_base_country());
			} else {
				$current_cc = apply_filters('default_checkout_country', (WC()->customer->get_shipping_country()) ? WC()->customer->get_shipping_country() : WC()->countries->get_base_country());
			}

			$states = WC()->countries->get_states( $current_cc );

			if ( is_array( $states ) && empty( $states ) ) {

				$field  = '<div class="row ' . esc_attr( implode( ' ', $args['class'] ) ) .'" id="' . esc_attr( $key ) . '_field" style="display: none"><div class="form-group"><div class="col-md-12">';

				if ( $args['label'] )
					$field .= '<label for="' . esc_attr( $key ) . '" class="' . implode( ' ', $args['label_class'] ) .'">' . $args['label'] . $required . '</label>';
				$field .= '<input type="hidden" class="hidden" name="' . esc_attr( $key )  . '" id="' . esc_attr( $key ) . '" value="" ' . implode( ' ', $custom_attributes ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '" />';
				$field .= '</div></div></div>' . $after;

			} elseif ( is_array( $states ) ) {

				$field  = '<div class="row ' . esc_attr( implode( ' ', $args['class'] ) ) .'" id="' . esc_attr( $key ) . '_field"><div class="form-group"><div class="col-md-12">';

				if ( $args['label'] )
					$field .= '<label for="' . esc_attr( $key ) . '" class="' . implode( ' ', $args['label_class'] ) .'">' . $args['label']. $required . '</label>';
				$field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" class="form-control state_select" ' . implode( ' ', $custom_attributes ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '">
					<option value="">'.__( 'Select a state&hellip;', 'woocommerce' ) .'</option>';

				foreach ( $states as $ckey => $cvalue )
					$field .= '<option value="' . esc_attr( $ckey ) . '" '.selected( $value, $ckey, false ) .'>'.__( $cvalue, 'woocommerce' ) .'</option>';

				$field .= '</select>';
				$field .= '</div></div></div>' . $after;

			} else {

				$field  = '<div class="row ' . esc_attr( implode( ' ', $args['class'] ) ) .'" id="' . esc_attr( $key ) . '_field"><div class="form-group"><div class="col-md-12">';

				if ( $args['label'] )
					$field .= '<label for="' . esc_attr( $key ) . '" class="' . implode( ' ', $args['label_class'] ) .'">' . $args['label']. $required . '</label>';
				$field .= '<input type="text" class="form-control ' . implode( ' ', $args['input_class'] ) .'" value="' . esc_attr( $value ) . '"  placeholder="' . esc_attr( $args['placeholder'] ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" ' . implode( ' ', $custom_attributes ) . ' />';
				$field .= '</div></div></div>' . $after;

			}

			break;
		case "textarea" :

			$field = '<div class="row ' . esc_attr( implode( ' ', $args['class'] ) ) .'" id="' . esc_attr( $key ) . '_field"><div class="form-group"><div class="col-md-12">';

			if ( $args['label'] )
				$field .= '<label for="' . esc_attr( $key ) . '" class="' . implode( ' ', $args['label_class'] ) .'">' . $args['label']. $required  . '</label>';

			$field .= '<textarea name="' . esc_attr( $key ) . '" class="form-control ' . implode( ' ', $args['input_class'] ) .'" id="' . esc_attr( $key ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '"' . ( empty( $args['custom_attributes']['rows'] ) ? ' rows="2"' : '' ) . ( empty( $args['custom_attributes']['cols'] ) ? ' cols="5"' : '' ) . implode( ' ', $custom_attributes ) . '>'. esc_textarea( $value  ) .'</textarea>
				</div></div></div>' . $after;

			break;
		case "checkbox" :

			$field = '<div class="row ' . esc_attr( implode( ' ', $args['class'] ) ) .'" id="' . esc_attr( $key ) . '_field"><div class="form-group"><div class="col-md-12">
					<input type="' . esc_attr( $args['type'] ) . '" class="input-checkbox" name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" value="1" '.checked( $value, 1, false ) .' />
					<label for="' . esc_attr( $key ) . '" class="checkbox ' . implode( ' ', $args['label_class'] ) .'" ' . implode( ' ', $custom_attributes ) . '>' . $args['label'] . $required . '</label>
				</div></div></div>' . $after;

			break;
		case "password" :

			$field = '<div class="row ' . esc_attr( implode( ' ', $args['class'] ) ) .'" id="' . esc_attr( $key ) . '_field"><div class="form-group"><div class="col-md-12">';

			if ( $args['label'] )
				$field .= '<label for="' . esc_attr( $key ) . '" class="' . implode( ' ', $args['label_class'] ) .'">' . $args['label']. $required . '</label>';

			$field .= '<input type="password" class="form-control ' . implode( ' ', $args['input_class'] ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />
				</div></div></div>' . $after;

			break;
		case "text" :

			$field = '<div class="row ' . esc_attr( implode( ' ', $args['class'] ) ) .'" id="' . esc_attr( $key ) . '_field"><div class="form-group"><div class="col-md-12">';

			if ( $args['label'] )
				$field .= '<label for="' . esc_attr( $key ) . '" class="' . implode( ' ', $args['label_class'] ) .'">' . $args['label'] . $required . '</label>';

			$field .= '<input type="text" class="form-control ' . implode( ' ', $args['input_class'] ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" '.$args['maxlength'].' value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />
				</div></div></div>' . $after;

			break;
		case "select" :

			$options = '';

			if ( ! empty( $args['options'] ) )
				foreach ( $args['options'] as $option_key => $option_text )
					$options .= '<option value="' . esc_attr( $option_key ) . '" '. selected( $value, $option_key, false ) . '>' . esc_attr( $option_text ) .'</option>';

				$field = '<div class="row ' . esc_attr( implode( ' ', $args['class'] ) ) .'" id="' . esc_attr( $key ) . '_field"><div class="form-group"><div class="col-md-12">';

				if ( $args['label'] )
					$field .= '<label for="' . esc_attr( $key ) . '" class="' . implode( ' ', $args['label_class'] ) .'">' . $args['label']. $required . '</label>';

				$field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" class="form-control select" ' . implode( ' ', $custom_attributes ) . '>
						' . $options . '
					</select>
				</div></div></div>' . $after;

			break;
		default :

			$field = apply_filters( 'woocommerce_form_field_' . $args['type'], '', $key, $args, $value );

			break;
		}

		if ( $args['return'] ) return $field; else echo $field;
	}
}

function spyropress_wc_add_to_cart_message( $message ) {
    
    return str_replace( 'class="button', 'class="', $message );
}
add_filter( 'wc_add_to_cart_message', 'spyropress_wc_add_to_cart_message' );