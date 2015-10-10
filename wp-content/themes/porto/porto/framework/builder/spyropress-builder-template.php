<?php

/**
 * SpyroPress Builder Template Functions
 * Functions used in the template files to output content - in most cases hooked in via the template actions. All functions are pluggable.
 *
 * @category Builder
 * @package SpyroPress
 * @subpackage Builder
 */

/**
 * Get header for builder templates
 */
function spyropress_get_builder_header() {
    global $wp_query;
    $template_id = $wp_query->queried_template_id;
    $canvas_header = get_post_meta( $template_id, 'canvas_header', true );

    // if left blank or theme default
    if ( $canvas_header == '' || $canvas_header == -2 ) {
        get_header();
        return;
    }
    // blank header
    elseif ( $canvas_header == -1 ) {
        get_header( 'blank' );
        return;
    }

    // custom header
    get_header( 'blank' );

    spyropress_before_header();
        echo '<!-- header --><header id="header">';
            spyropress_before_header_content();
                echo builder_render_frontend_rows( $canvas_header, true );
            spyropress_after_header_content();
        echo '</header><!-- /header -->';
    spyropress_after_header();

    return;
}

/**
 * Get footer for builder templates
 */
function spyropress_get_builder_footer() {
    global $wp_query;
    $template_id = $wp_query->queried_template_id;
    $canvas_footer = get_post_meta( $template_id, 'canvas_footer', true );

    // if left blank or theme default
    if ( $canvas_footer == '' || $canvas_footer == -2 ) {
        get_footer();
        return;
    }
    // blank footer
    elseif ( $canvas_footer == -1 ) {
        get_footer( 'blank' );
        return;
    }

    spyropress_before_footer();
        printf( '
            <!-- footer -->
            <footer id="footer">
                <div class="container">
                    %s
                </div>
            </footer>
            <!-- /footer -->', builder_render_frontend_rows( $canvas_footer )
        );
    spyropress_after_footer();

    // custom footer
    get_footer( 'builder' );
    return;
}


/**
 * Check if post has builder generated content
 */
function spyropress_has_builder_content( $post_ID = '' ) {
    global $post;
    if ( $post_ID == '' )
        $post_ID = $post->ID;
    $data = get_post_meta( $post_ID, '_spyropress_builder_data', true );

    return ( $data ) ? true : false;
}

/**
 * Generate content using Builder
 */
function spyropress_the_builder_content( $post_ID = '' ) {
    echo spyropress_get_the_builder_content( $post_ID );
}
function spyropress_get_the_builder_content( $post_ID = '' ) {
    global $post;
    if ( $post_ID == '' )
        $post_ID = $post->ID;
    return builder_render_frontend_rows( $post_ID );
}

/**
 * Output Builder Module
 */
function spyropress_the_builder_module( $widget_id, $widget ) {
    global $wp_widget_factory, $spyropress_builder;

    $widget_type = $widget['type'];
    $instance = $widget['instance'];

    if( 'SpyropressBuilderModule' == get_parent_class( $widget_type ) )
        $widget_obj = $spyropress_builder->modules->get_module( $widget_type );
    else
        $widget_obj = $wp_widget_factory->widgets[$widget_type];

    // check for null
    if ( ! is_a( $widget_obj, 'WP_Widget' ) ) return;

    // widget css classes
    $widget_class = array();
    $widget_class[] = 'module';
    $widget_class[] = $widget_obj->widget_options['classname'];
    if ( isset( $instance['custom_container_class'] ) )
        $widget_class[] = $instance['custom_container_class'];
    if ( isset( $instance['template'] ) && !empty( $instance['template'] ) ) {
        $template = $instance['template'];
        $widget_class[] = isset( $widget_obj->templates[$template]['class'] ) ? $widget_obj->templates[$template]['class'] : '';
    }    
    
    if ( isset( $instance['custom_container_id'] ) && $instance['custom_container_id'] )
        $widget_id = $instance['custom_container_id'];

    if ( empty( $args ) )
        $args = array(
            'before_widget' => sprintf( '<div%1$s class="%2$s">', ( $widget_id ) ? ' id="' .
                $widget_id . '"' : '', spyropress_clean_cssclass( $widget_class ) ),
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget_title">',
            'after_title' => '</h3>' );

    do_action( 'the_widget', $widget, $instance, $args );

    $widget_obj->_set( -1 );
    $widget_obj->widget( $args, $instance );
}
?>