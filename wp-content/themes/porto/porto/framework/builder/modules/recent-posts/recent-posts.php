<?php

/**
 * Module: Posts
 * Display a list of recent posts
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Recent_Posts extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings.
        $this->path = dirname( __FILE__ );

        $this->description = __( 'Display a list of recent posts.', 'spyropress' );
        $this->id_base = 'srecent_posts';
        $this->cssclass = 'recent-posts push-bottom';
        $this->name = __( 'Recent Posts', 'spyropress' );

        // Fields
        $this->fields = array(

            array(
                'label' => __( 'Title', 'spyropress' ),
                'id' => 'title',
                'type' => 'text',
                'std' => $this->name
            ),

            array(
                'label' => __( 'Number of items per page', 'spyropress' ),
                'id' => 'limit',
                'type' => 'text',
                'std' => 6
            ),

            array(
                'label' => __( 'Columns', 'spyropress' ),
                'id' => 'columns',
                'type' => 'select',
                'options' => array(
                    1 => __( '1 Column', 'spyropress' ),
                    2 => __( '2 Column', 'spyropress' ),
                    3 => __( '3 Column', 'spyropress' ),
                    4 => __( '4 Column', 'spyropress' )
                )
            ),

            array(
                'label' => __( 'Category', 'spyropress' ),
                'id' => 'cat',
                'type' => 'multi_select',
                'options' => spyropress_get_taxonomies( 'category' )
            ),

            array(
                'id' => 'url_enable',
                'type' => 'checkbox',
                'options' => array(
                    '1' => __( 'Show Archive Link', 'spyropress' )
                )
            ),

            array(
                'label' => __( 'Link to Text', 'spyropress' ),
                'id' => 'url_text',
                'type' => 'text',
                'std' => 'View All'
            ),

            array(
                'label' => __( 'Excerpt Length', 'spyropress' ),
                'id' => 'excerpt_length',
                'type' => 'range_slider',
                'std' => 18
            ),
            
            array(
                'label' => __( 'Auto Play', 'spyropress' ),
                'id' => 'auto_play',
                'type' => 'checkbox',
                'options' => array(
                    1 => __( 'Enabe Crousel Auto play effect.', 'spyropress' )
                )
            )
        );

        $this->create_widget();
    }

    function widget( $args, $instance ) {

        // extracting info
        extract( $args );

        // get view to render
        include $this->get_view();
    }

    function query( $atts, $content = null ) {

        $default = array (
            'post_type' => 'post',
            'limit' => -1,
            'row_container' => 'div',
            'row_class' => '',
            'columns' => 2,
            'excerpt_length' => 18,
            'pagination' => false,
            'callback' => array( $this, 'generate_item' )
        );
        $atts = wp_parse_args( $atts, $default );

        if ( ! empty( $atts['cat'] ) ) {

            $atts['tax_query']['relation'] = 'OR';
            if ( ! empty( $atts['cat'] ) ) {
                $atts['tax_query'][] = array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $atts['cat'],
                    );
                unset( $atts['cat'] );
            }
        }

        if ( $content )
            return token_repalce( $content, spyropress_query_generator( $atts ) );

        return spyropress_query_generator( $atts );
    }

    // Item HTML Generator
    function generate_item( $post_ID, $atts ) {

        // these arguments will be available from inside $content
        $image = array(
            'post_id' => $post_ID,
            'echo' => false,
        );
        $image_tag = get_image( $image );

        // item tempalte
        $item_tmpl = '
        <div class="' . $atts['column_class'] . '">
			<article>
				<div class="date">
					<span class="day">' . get_the_date( 'j' ) . '</span>
					<span class="month">' . get_the_date( 'M' ) . '</span>
				</div>
				<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>
                <p>' . spyropress_get_excerpt( 'by=words&length=' . $atts['excerpt_length'] . '&link_to_post=0&ellipsis=&before_text=&after_text=' ) . '
                <a href="' . get_permalink() . '" class="read-more">' . get_setting( 'excerpt_link_text', 'read more' ) . ' <i class="fa fa-angle-right"></i></a></p>
			</article>
		</div>';

        return $item_tmpl;
    }
}

spyropress_builder_register_module( 'Spyropress_Module_Recent_Posts' );