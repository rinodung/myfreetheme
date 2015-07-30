<?php

/**
 * SpyroPress Template Functions
 * Functions used in the template files to output content - in most cases hooked in via the template actions. All functions are pluggable.
 *
 * @category Core
 * @package SpyroPress
 */

/**
 * Get Post Views
 */
function spyropress_post_views( $post_id = 0, $singular = 'View', $plural = 'Views' ) {
    echo spyropress_get_post_views( $post_id, $singular, $plural );
}
function spyropress_get_post_views( $post_id = 0, $singular = 'View', $plural = 'Views' ) {

    global $post;

    $postID = ( !empty( $post_id ) && $post_id ) ? $post_id : $post->ID;

    $count_key = '_post_views_count';
    $count = get_post_meta( $postID, $count_key, true );
    $count = ( $count ) ? $count : 0;

    return sprintf( _n( '%d ' . $singular, '%d ' . $plural, $count ), $count );
}

/**
 * Logo
 * Get logo from theme options or pass custom logo
 */
function spyropress_logo( $args = '', $content = '' ) {
    echo spyropress_get_logo( $args, $content );
}
function spyropress_get_logo( $args = '', $content = '' ) {

    $defaults = array(
        'tag' => ( is_front_page() || is_home() ) ? 'h1' : 'div',
        'class' => 'logo',
        'id' => 'logo',
        'link' => esc_url( home_url( '/' ) ),
        'alt' => get_bloginfo( 'name' ),
        'title' => get_bloginfo( 'name' ),
        'show_img' => !get_setting( 'texttitle', false ),
        'img' => get_setting( 'logo', false ),
        'brand' => false,
        'before' => '',
        'after' => ''
    );
    $args = wp_parse_args( $args, $defaults );
    extract( $args, EXTR_SKIP );

    if ( !$brand ) {
        $before = sprintf( '<%1$s class="%2$s" id="%3$s">', $tag, $class, $id );
        $after = sprintf( '</%1$s>', $tag );
    }

    $logo = sprintf( '<a href="%1$s" title="%2$s"%3$s>%4$s</a>', $link, esc_attr( strip_tags
        ( $title ) ), ( $brand ) ? ' class="brand"' : '', ( $img ) ? '<img src="' . $img .
        '" alt="' . $alt . '" title="' . esc_attr( strip_tags( $title ) ) . '" />' : $title );

    return $before . $logo . $after;
}

/**
 * Get menu with Bootstrap Walker
 */
function spyropress_get_nav_menu( $args = '', $location = 'primary' ) {

    if( !has_nav_menu( $location ) ) return;

    $defaults = array(
        'theme_location' => $location,
        'container' => 'nav',
        'container_class' => 'navbar',
        'container_id' => $location . '-nav',
        'menu_class' => 'nav',
        'walker' => new Bootstrapwp_Walker_Nav_Menu
    );

    return wp_nav_menu( wp_parse_args( $args, $defaults ) );
}

/**
 * the_content
 */
function spyropress_the_content( $post_id = '' ) {

    echo spyropress_get_the_content( $post_id );
}

function spyropress_get_the_content( $post_id = '' ) {

    if ( class_exists( 'SpyropressBuilder' ) && spyropress_has_builder_content( $post_id ) ) {
        $post = get_post();

        // If post password required and it doesn't match the cookie.
        if ( post_password_required( $post ) )
            return '<div class="container">' . get_the_password_form( $post ) . '</div>';

        return spyropress_get_the_builder_content( $post_id );
    }
	elseif ( is_singular() ) {
        ob_start();
        echo '<div class="container">';
        the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'spyropress' ) );
        echo '</div>';
        return ob_get_clean();
    }
    else {
        return get_the_excerpt();
    }
}

function spyropress_get_next_prev_portfolio_link( ) {

    $next_link = $prev_link = '';

    // prev post link
    $prev_post = get_previous_post();
    if ( ! empty( $prev_post ) ) {
        $prev_link = '<a class="portfolio-nav-prev" rel="tooltip" data-original-title="' . __( 'Previous', 'spyroporess' ) . '" href="' . get_permalink( $prev_post->ID ) . '"><i class="fa fa-chevron-left"></i></a>';
    }

    // next post link
    $next_post = get_next_post();
    if ( ! empty( $next_post ) ) {
        $next_link = '<a href="' . get_permalink( $next_post->ID ) . '" class="portfolio-nav-next" rel="tooltip" data-original-title="' . __( 'Next', 'spyropress' ) . '"><i class="fa fa-chevron-right"></i></a>';
    }

    return $prev_link . $next_link;
}

function spyropress_social_icons( $id = '' ) {
    if( empty( $id ) ) return;

    $socials = get_setting_array( $id );

    if( empty( $socials ) ) return;

    echo '<ul class="social-icons">';

    foreach( $socials as $social )
        echo '<li class="' . $social['network'] . '"><a href="' . $social['url'] . '" target="_blank" title="' . ucwords( $social['network'] ) . '">' . ucwords( $social['network'] ) . '</a></li> ';

   echo '</ul>';
}