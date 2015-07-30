<?php
/**
 * Template tag: Boxed Style Paging
 * @version 2.83
 */
function wp_pagenavi( $args = array() ) {
    
    $defaults = array(
		'before' => '',
		'after' => '',
        'class_active' => 'current',
        'container' => 'div',
        'container_class' => 'pagination-container',
        'menu_class' => 'pagination-menu',
        'style' => 'list',
		'options' => array(
            'pages_text'    => get_setting('pagination_pages_text', __( 'Page %CURRENT_PAGE% of %TOTAL_PAGES%', 'spyropress' )),
            'current_text'  => get_setting('pagination_current_text', '%PAGE_NUMBER%'),
            'page_text'     => get_setting('pagination_page_text', '%PAGE_NUMBER%'),
            'first_text'    => get_setting('pagination_first_text', __( '&laquo; First', 'spyropress' )),
            'last_text'     => get_setting('pagination_last_text', __( 'Last &raquo;', 'spyropress' )),
            'prev_text'     => get_setting('pagination_prev_text', __( '&laquo;', 'spyropress' )),
            'next_text'     => get_setting('pagination_next_text', __( '&raquo;', 'spyropress' )),
            'dotleft_text'  => get_setting('pagination_dotleft_text', __( '&hellip;', 'spyropress' )),
            'dotright_text' => get_setting('pagination_dotright_text', __( '&hellip;', 'spyropress' )),
            'num_pages'     => get_setting('pagination_num_pages', 5),
            'num_larger_page_numbers'   => get_setting('pagination_num_larger_page_numbers', 3),
            'larger_page_numbers_multiple'  => get_setting('pagination_larger_page_numbers_multiple', 10),
            'always_show'   => get_setting('pagination_always_show', false)
        ),
		'query' => $GLOBALS['wp_query'],
		'type' => 'posts',
		'echo' => true
	);
	$args = wp_parse_args( $args, apply_filters( 'spyropress_pagination_defaults', $defaults ) );
	extract( $args, EXTR_SKIP );

	$instance = new PageNavi_Call( $args );

	list( $posts_per_page, $paged, $total_pages ) = $instance->get_pagination_args();

	if ( 1 == $total_pages && !$options['always_show'] ) return;

	$pages_to_show = absint( $options['num_pages'] );
	$larger_page_to_show = absint( $options['num_larger_page_numbers'] );
	$larger_page_multiple = absint( $options['larger_page_numbers_multiple'] );
	$pages_to_show_minus_1 = $pages_to_show - 1;
	$half_page_start = floor( $pages_to_show_minus_1/2 );
	$half_page_end = ceil( $pages_to_show_minus_1/2 );
	$start_page = $paged - $half_page_start;

	if ( $start_page <= 0 )
		$start_page = 1;

	$end_page = $paged + $half_page_end;

	if ( ( $end_page - $start_page ) != $pages_to_show_minus_1 )
		$end_page = $start_page + $pages_to_show_minus_1;

	if ( $end_page > $total_pages ) {
		$start_page = $total_pages - $pages_to_show_minus_1;
		$end_page = $total_pages;
	}

	if ( $start_page < 1 )
		$start_page = 1;

	$out = '';
	switch ( $style ) {
		// Normal
		case 'list':
			// Text
			if ( !empty( $options['pages_text'] ) ) {
				$pages_text = str_replace(
					array( "%CURRENT_PAGE%", "%TOTAL_PAGES%" ),
					array( number_format_i18n( $paged ), number_format_i18n( $total_pages ) ),
				$options['pages_text'] );
				$out .= "<li><span class='pages'>$pages_text</span></li>";
			}

			if ( $start_page >= 2 && $pages_to_show < $total_pages ) {
				// First
				$first_text = str_replace( '%TOTAL_PAGES%', number_format_i18n( $total_pages ), $options['first_text'] );
				$out .= '<li class="first">' . $instance->get_single( 1, 'first', $first_text, '%TOTAL_PAGES%' ) . '</li>';
			}

			// Previous
			if ( $paged > 1 && !empty( $options['prev_text'] ) )
				$out .= '<li class="previouspostslink">' . $instance->get_single( $paged - 1, 'previouspostslink', $options['prev_text'] ) . '</li>';

			if ( $start_page >= 2 && $pages_to_show < $total_pages ) {
				if ( !empty( $options['dotleft_text'] ) )
					$out .= "<li><span class='extend'>{$options['dotleft_text']}</span></li>";
			}

			// Smaller pages
			$larger_pages_array = array();
			if ( $larger_page_multiple )
				for ( $i = $larger_page_multiple; $i <= $total_pages; $i+= $larger_page_multiple )
					$larger_pages_array[] = $i;

			$larger_page_start = 0;
			foreach ( $larger_pages_array as $larger_page ) {
				if ( $larger_page < ($start_page - $half_page_start) && $larger_page_start < $larger_page_to_show ) {
					$out .= '<li class="smaller page">' . $instance->get_single( $larger_page, 'smaller page', $options['page_text'] ) . '</li>';
					$larger_page_start++;
				}
			}

			if ( $larger_page_start )
				$out .= "<li><span class='extend'>{$options['dotleft_text']}</span></li>";

			// Page numbers
			$timeline = 'smaller';
			foreach ( range( $start_page, $end_page ) as $i ) {
				if ( $i == $paged && !empty( $options['current_text'] ) ) {
					$current_page_text = str_replace( '%PAGE_NUMBER%', number_format_i18n( $i ), $options['current_text'] );
					$out .= "<li class='$class_active'><span>$current_page_text</span></li>";
					$timeline = 'larger';
				} else {
					$out .= '<li class="page ' . $timeline . '">' . $instance->get_single( $i, "page $timeline", $options['page_text'] ) . '</li>';
				}
			}

			// Large pages
			$larger_page_end = 0;
			$larger_page_out = '';
			foreach ( $larger_pages_array as $larger_page ) {
				if ( $larger_page > ($end_page + $half_page_end) && $larger_page_end < $larger_page_to_show ) {
					$larger_page_out .= '<li class="larger page">' . $instance->get_single( $larger_page, 'larger page', $options['page_text'] ) . '</li>';
					$larger_page_end++;
				}
			}

			if ( $larger_page_out ) {
				$out .= "<li><span class='extend'>{$options['dotright_text']}</span></li>";
			}
			$out .= $larger_page_out;

			if ( $end_page < $total_pages ) {
				if ( !empty( $options['dotright_text'] ) )
					$out .= "<li><span class='extend'>{$options['dotright_text']}</span></li>";
			}

			// Next
			if ( $paged < $total_pages && !empty( $options['next_text'] ) )
				$out .= '<li class="nextpostslink">' . $instance->get_single( $paged + 1, 'nextpostslink', $options['next_text'] ) . '</li>';

			if ( $end_page < $total_pages ) {
				// Last
				$out .= '<li class="last">' . $instance->get_single( $total_pages, 'last', $options['last_text'], '%TOTAL_PAGES%' ) . '</li>';
			}
			break;
        // Normal
		case 'simple':
			// Text
			if ( !empty( $options['pages_text'] ) ) {
				$pages_text = str_replace(
					array( "%CURRENT_PAGE%", "%TOTAL_PAGES%" ),
					array( number_format_i18n( $paged ), number_format_i18n( $total_pages ) ),
				$options['pages_text'] );
				$out .= "<span class='pages'>$pages_text</span>";
			}

			if ( $start_page >= 2 && $pages_to_show < $total_pages ) {
				// First
				$first_text = str_replace( '%TOTAL_PAGES%', number_format_i18n( $total_pages ), $options['first_text'] );
				$out .= $instance->get_single( 1, 'first', $first_text, '%TOTAL_PAGES%' );
			}

			// Previous
			if ( $paged > 1 && !empty( $options['prev_text'] ) )
				$out .= $instance->get_single( $paged - 1, 'previouspostslink', $options['prev_text'] );

			if ( $start_page >= 2 && $pages_to_show < $total_pages ) {
				if ( !empty( $options['dotleft_text'] ) )
					$out .= "<span class='extend'>{$options['dotleft_text']}</span>";
			}

			// Smaller pages
			$larger_pages_array = array();
			if ( $larger_page_multiple )
				for ( $i = $larger_page_multiple; $i <= $total_pages; $i+= $larger_page_multiple )
					$larger_pages_array[] = $i;

			$larger_page_start = 0;
			foreach ( $larger_pages_array as $larger_page ) {
				if ( $larger_page < ($start_page - $half_page_start) && $larger_page_start < $larger_page_to_show ) {
					$out .= $instance->get_single( $larger_page, 'smaller page', $options['page_text'] );
					$larger_page_start++;
				}
			}

			if ( $larger_page_start )
				$out .= "<span class='extend'>{$options['dotleft_text']}</span>";

			// Page numbers
			$timeline = 'smaller';
			foreach ( range( $start_page, $end_page ) as $i ) {
				if ( $i == $paged && !empty( $options['current_text'] ) ) {
					$current_page_text = str_replace( '%PAGE_NUMBER%', number_format_i18n( $i ), $options['current_text'] );
					$out .= "<span class='$class_active'>$current_page_text</span>";
					$timeline = 'larger';
				} else {
					$out .= $instance->get_single( $i, "page $timeline", $options['page_text'] );
				}
			}

			// Large pages
			$larger_page_end = 0;
			$larger_page_out = '';
			foreach ( $larger_pages_array as $larger_page ) {
				if ( $larger_page > ($end_page + $half_page_end) && $larger_page_end < $larger_page_to_show ) {
					$larger_page_out .= $instance->get_single( $larger_page, 'larger page', $options['page_text'] );
					$larger_page_end++;
				}
			}

			if ( $larger_page_out ) {
				$out .= "<span class='extend'>{$options['dotright_text']}</span>";
			}
			$out .= $larger_page_out;

			if ( $end_page < $total_pages ) {
				if ( !empty( $options['dotright_text'] ) )
					$out .= "<span class='extend'>{$options['dotright_text']}</span>";
			}

			// Next
			if ( $paged < $total_pages && !empty( $options['next_text'] ) )
				$out .= $instance->get_single( $paged + 1, 'nextpostslink', $options['next_text'] );

			if ( $end_page < $total_pages ) {
				// Last
				$out .= $instance->get_single( $total_pages, 'last', $options['last_text'], '%TOTAL_PAGES%' );
			}
			break;
		// Dropdown
		case 'dropdown':
			$out .= '<form action="" method="get">'."\n";
			$out .= '<select size="1" onchange="document.location.href = this.options[this.selectedIndex].value;">'."\n";

			foreach ( range( 1, $total_pages ) as $i ) {
				$page_num = $i;
				if ( $page_num == 1 )
					$page_num = 0;

				if ( $i == $paged ) {
					$current_page_text = str_replace( '%PAGE_NUMBER%', number_format_i18n( $i ), $options['current_text'] );
					$out .= '<option value="'.esc_url( $instance->get_url( $page_num ) ).'" selected="selected" class="current">'.$current_page_text."</option>\n";
				} else {
					$page_text = str_replace( '%PAGE_NUMBER%', number_format_i18n( $i ), $options['page_text'] );
					$out .= '<option value="'.esc_url( $instance->get_url( $page_num ) ).'">'.$page_text."</option>\n";
				}
			}

			$out .= "</select>\n";
			$out .= "</form>\n";
			break;
	}
	
    if( 'list' == $style ) {        
        $out = $before . "<$container class='$container_class'>\n<ul class='$menu_class'>\n$out\n</ul>\n</$container>" . $after;
    }
    else {
        $out = $before . "<$container class='$container_class'>\n$out\n</$container>" . $after;
    }

	$out = apply_filters( 'wp_pagenavi', $out );

	if ( !$echo )
		return $out;

	echo $out;
}


class PageNavi_Call {

	protected $args;

	function __construct( $args ) {
		$this->args = $args;
	}

	function __get( $key ) {
		return $this->args[ $key ];
	}

	function get_pagination_args() {
		global $numpages;

		$query = $this->query;

		switch( $this->type ) {
		case 'multipart':
			// Multipart page
			$posts_per_page = 1;
			$paged = max( 1, absint( get_query_var( 'page' ) ) );
			$total_pages = max( 1, $numpages );
			break;
		case 'users':
			// WP_User_Query
			$posts_per_page = $query->query_vars['number'];
			$paged = max( 1, floor( $query->query_vars['offset'] / $posts_per_page ) + 1 );
			$total_pages = max( 1, ceil( $query->total_users / $posts_per_page ) );
			break;
		default:
			// WP_Query
			$posts_per_page = intval( $query->get( 'posts_per_page' ) );
			$paged = max( 1, absint( $query->get( 'paged' ) ) );
			$total_pages = max( 1, absint( $query->max_num_pages ) );
			break;
		}

		return array( $posts_per_page, $paged, $total_pages );
	}

	function get_single( $page, $class, $raw_text, $format = '%PAGE_NUMBER%' ) {
		if ( empty( $raw_text ) )
			return '';

		$text = str_replace( $format, number_format_i18n( $page ), $raw_text );

		return "<a href='" . esc_url( $this->get_url( $page ) ) . "'>$text</a>";
	}

	function get_url( $page ) {
		return ( 'multipart' == $this->type ) ? get_multipage_link( $page ) : get_pagenum_link( $page );
	}
}

# http://core.trac.wordpress.org/ticket/16973
if ( !function_exists( 'get_multipage_link' ) ) :
function get_multipage_link( $page = 1 ) {
	global $post, $wp_rewrite;

	if ( 1 == $page ) {
		$url = get_permalink();
	} else {
		if ( '' == get_option('permalink_structure') || in_array( $post->post_status, array( 'draft', 'pending') ) )
			$url = add_query_arg( 'page', $page, get_permalink() );
		elseif ( 'page' == get_option( 'show_on_front' ) && get_option('page_on_front') == $post->ID )
			$url = trailingslashit( get_permalink() ) . user_trailingslashit( $wp_rewrite->pagination_base . "/$page", 'single_paged' );
		else
			$url = trailingslashit( get_permalink() ) . user_trailingslashit( $page, 'single_paged' );
	}

	return $url;
}
endif;
?>