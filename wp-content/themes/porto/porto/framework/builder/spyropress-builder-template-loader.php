<?php

/*
 * SpyroPress Builder Template Loader
 * Loads the correct template based on the visitor's url
 *
 * @package		Spyropress
 * @category	Builder
 * @author		SpyroSol
*/

add_action( 'template_redirect', 'builder_template_redirect_logic', 2 );
function builder_template_redirect_logic() {
    
    if ( is_404() && $template = get_builder_query_template( '404.php' ) ):
    elseif ( is_search() && $template = get_builder_query_template( 'search.php' ) ):
    elseif ( is_tax() && $template = get_builder_taxonomy_template() ):
    elseif ( is_front_page() && $template = get_builder_query_template( 'front-page.php' ) ):
    elseif ( is_home() && $template = get_builder_query_template( 'home.php' ) ):
    elseif ( is_single() && $template = get_builder_single_template() ):
    elseif ( is_page() && $template = get_builder_page_template() ):
    elseif ( is_category() && $template = get_builder_category_template() ):
    elseif ( is_tag() && $template = get_builder_tag_template() ):
    elseif ( is_author() && $template = get_builder_author_template() ):
    elseif ( is_date() && $template = get_builder_date_template() ):
    elseif ( is_archive() && $template = get_builder_archive_template() ):
    else:
        $template = '';
    endif;
    
    if ( $template != '' ) {
        include ( $template );
        exit;
    }
}

function get_builder_single_template() {
    $templates = array();

    // Get the queried post. 
    $object = get_queried_object();

    $templates[] = "{$object->post_type}";
    $templates[] = "single.php";

    return get_builder_query_template( 'single', $templates );
}

function get_builder_page_template() {
    $templates = array();

    // Get the queried post. 
    $object = get_queried_object();

    // Check for a custom post template by custom field key '_wp_post_template'. 
    $custom = get_post_meta( get_queried_object_id(), "_builder_template", true );
    if ( ! empty( $custom ) ) {
        global $wp_query;
        $wp_query->queried_template_id = $custom;
        return locate_template( 'builder.php' );
    }

    $templates[] = "{$object->post_type}";
    $templates[] = "page.php";

    return get_builder_query_template( 'page', $templates );
}

function get_builder_taxonomy_template() {
    $term = get_queried_object();
    $taxonomy = $term->taxonomy;

    $templates = array();

    $templates[] = "$taxonomy-{$term->slug}";
    $templates[] = "$taxonomy";
    $templates[] = 'taxonomy.php';

    return get_builder_query_template( 'taxonomy', $templates );
}

function get_builder_attachment_template() {
    global $posts;
    $type = explode( '/', $posts[0]->post_mime_type );
    if ( $template = get_builder_query_template( $type[0] ) )
        return $template;
    elseif ( $template = get_builder_query_template( $type[1] ) )
        return $template;
    elseif ( $template = get_builder_query_template( "$type[0]_$type[1]" ) )
        return $template;
    else
        return get_builder_query_template( 'attachment' );
}

function get_builder_category_template() {
    $category = get_queried_object();

    $templates = array();

    $templates[] = "{$category->slug}";
    $templates[] = "{$category->term_id}";
    $templates[] = 'category.php';

    return get_builder_query_template( 'category', $templates );
}

function get_builder_tag_template() {
    $tag = get_queried_object();

    $templates = array();

    $templates[] = "tag-{$tag->slug}.php";
    $templates[] = "tag-{$tag->term_id}.php";
    $templates[] = 'tag.php';

    return get_builder_query_template( 'tag', $templates );
}

function get_builder_author_template() {
    $author = get_queried_object();

    $templates = array();

    $templates[] = "author-{$author->user_nicename}.php";
    $templates[] = "author-{$author->ID}.php";
    $templates[] = 'author.php';

    return get_builder_query_template( 'author', $templates );
}

function get_builder_date_template() {
    return get_builder_query_template( 'date' );
}

function get_builder_archive_template() {
    $post_type = get_query_var( 'post_type' );

    $templates = array();

    if ( $post_type )
        $templates[] = "archive-{$post_type}.php";
    $templates[] = 'archive.php';

    return get_builder_query_template( 'archive', $templates );
}

function get_builder_comments_popup_template() {
    $template = get_builder_query_template( 'comments_popup', array( 'comments-popup.php' ) );

    // Backward compat code will be removed in a future release
    if ( '' == $template )
        $template = ABSPATH . WPINC . '/theme-compat/comments-popup.php';

    return $template;
}

function get_builder_query_template( $type, $templates = array() ) {
    global $wp_query;

    $meta_query['relation'] = 'AND';
    $meta_query[] = array( 'key' => 'canvas_type', 'value' => 'full' );

    if ( empty( $templates ) )
        $meta_query[] = array( 'key' => 'assigned_to', 'value' => $type );
    else
        $meta_query[] = array(
            'key' => 'assigned_to',
            'value' => $templates,
            'compare' => 'IN' );

    $args = array(
        'post_type' => 'template',
        'posts_per_page' => 1,
        'meta_query' => $meta_query );

    $posts = get_posts( $args );
    if ( ! empty( $posts ) ) {
        $wp_query->queried_template_id = $posts[0]->ID;
        return locate_template( 'builder.php' );
    }

    return '';
}

?>