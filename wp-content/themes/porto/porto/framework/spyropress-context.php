<?php

/**
 * Spyropress Core Functions
 * Functions available on both the front-end and admin.
 *
 * @category Core
 * @package SpyroPress
 *
 */

/** Contextual Hook and Filter Functions *****************************************************/

/**
 * Adds contextual action hooks to the theme.  This allows users to easily add context-based content
 * without having to know how to use WordPress conditional tags.  The theme handles the logic.
 *
 * An example of a basic hook would be 'spyropress_head'.  The spyropress_do_atomic() function extends that to
 * give extra hooks such as 'spyropress_head_home', 'spyropress_head_singular', and 'spyropress_head_singular-page'.
 */
function spyropress_do_atomic( $tag = '', $args = '' ) {

    if ( empty( $tag ) ) return false;

    // Do actions on the basic hook.
    do_action( $tag, $args );

    // Loop through context array and fire actions on a contextual scale.
    foreach ( ( array )spyropress_get_query_context() as $context )
        do_action( "{$tag}_{$context}", $args );

}

/**
 * Adds contextual filter hooks to the theme.  This allows users to easily filter context-based content
 * without having to know how to use WordPress conditional tags. The theme handles the logic.
 *
 * An example of a basic hook would be 'spyropress_entry_meta'.  The spyropress_apply_atomic() function extends
 * that to give extra hooks such as 'spyropress_entry_meta_home', 'spyropress_entry_meta_singular' and 'spyropress_entry_meta_singular-page'.
 */
function spyropress_apply_atomic( $tag = '', $value = '' ) {

    if ( ! $tag ) return false;

    // Apply filters on the basic hook.
    $value = apply_filters( $tag, $value );

    // Loop through context array and apply filters on a contextual scale.
    foreach ( ( array )spyropress_get_query_context() as $context )
        $value = apply_filters( "{$context}_{$tag}", $value );

    // Return the final value once all filters have been applied.
    return $value;
}

/**
 * Retrieve the context of the queried template.
 */
function spyropress_get_query_context() {
    global $wp_query, $spyropress;

    // If $spyropress->context has been set, don't run through the conditionals again. Just return the variable.
    if ( isset( $spyropress->context ) ) return $spyropress->context;

    $context = array();
    $object = get_queried_object();
    $object_id = get_queried_object_id();

    // Front page of the site
    if ( is_front_page() ) $context[] = 'home';

    // Blog page
    if ( is_home() ) {
        $context[] = 'blog';

        // Singular views
    }
    elseif ( is_singular() ) {

        $context[] = 'singular';
        $context[] = "{$object->post_type}";
        $context[] = "singular-{$object->post_type}";
        $context[] = "singular-{$object->post_type}-{$object_id}";

        // Page Templates
        if ( is_page_template() ) {

            $to_skip = array( 'page', 'post' );

            $page_template = basename( get_page_template() );
            $page_template = str_replace( '.php', '', $page_template );
            $page_template = str_replace( '.', '-', $page_template );

            if ( $page_template && ! in_array( $page_template, $to_skip ) )
                $context[] = $page_template;

        } // End IF Statement
    }

    // Archive views
    elseif ( is_archive() ) {

        $context[] = 'archive';

        // Post type archives
        if ( is_post_type_archive() ) {
            $post_type = get_post_type_object( get_query_var( 'post_type' ) );
            $hybrid->context[] = "archive-{$post_type->name}";
        }

        // Taxonomy archives
        if ( is_tax() || is_category() || is_tag() ) {
            $context[] = "{$object->taxonomy}";

            $slug = ( ( 'post_format' == $object->taxonomy ) ? str_replace( 'post-format-', '', $object->slug ) : $object->slug );
            $context[] = "{$object->taxonomy}-" . sanitize_html_class( $slug, $object->term_id );
        }

        // User/author archives
        if ( is_author() ) {
            $context[] = 'user';
            $context[] = 'user-' . sanitize_html_class( get_the_author_meta( 'user_nicename', $object_id ), $object_id );
        }

        // Date archives
        if ( is_date() ) {

            $context[] = 'date';
            if ( is_year() )
                $context[] = 'year';

            if ( is_month() )
                $context[] = 'month';

            if ( get_query_var( 'w' ) )
                $context[] = 'week';
            if ( is_day() )
                $context[] = 'day';
        }

        if ( is_time() ) {

            $context[] = 'time';

            if ( get_query_var( 'hour' ) )
                $context[] = 'hour';

            if ( get_query_var( 'minute' ) )
                $context[] = 'minute';
        }
    }

    // Search results
    elseif ( is_search() ) {
        $context[] = 'search';

        // Error 404 pages
    }
    elseif ( is_404() ) {
        $context[] = 'error-404';

    } // End IF Statement

    $spyropress->context = array_map( 'esc_attr', $context );
    return $spyropress->context;
}
?>