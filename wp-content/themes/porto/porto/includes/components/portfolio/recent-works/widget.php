<?php

/**
 * Module: Portfolio
 * Display a list of portfolio
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Widget_Recent_Work extends SpyropressWidget {

    public function __construct() {

        // Widget variable settings.
        $this->path = dirname( __FILE__ );

        $this->description = __( 'Display a list of portfolio.', 'spyropress' );
        $this->id_base = 'recent_works';
        $this->name = __( 'Recent Works', 'spyropress' );

        // Fields
        $this->fields = array(

            array(
                'label' => __( 'Title', 'spyropress' ),
                'id' => 'title',
                'type' => 'text',
                'std' => $this->name
            ),

            array(
                'label' => __( 'Number of items', 'spyropress' ),
                'id' => 'limit',
                'type' => 'range_slider',
                'max' => 30,
                'std' => 4
            ),

            array(
                'label' => __( 'Portfolio Category', 'spyropress' ),
                'id' => 'cat',
                'type' => 'multi_select',
                'options' => spyropress_get_taxonomies( 'portfolio_category' )
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
                'std' => 'View More'
            ),
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
            'post_type' => 'portfolio',
            'limit' => -1,
            'columns' => false,
            'pagination' => false,
            'callback' => array( $this, 'generate_item' ),
            'item_class' => 'portfolio-entry'
        );
        $atts = wp_parse_args( $atts, $default );

        if ( ! empty( $atts['cat'] ) ) {

            $atts['tax_query']['relation'] = 'OR';
            if ( ! empty( $atts['cat'] ) ) {
                $atts['tax_query'][] = array(
                    'taxonomy' => 'portfolio_category',
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
            'responsive' => true,
            'class' => 'img-responsive'
        );
        $image_tag = get_image( $image );

        // item tempalte
        $item_tmpl = '
        <li>
            <a class="thumb-info" href="' . get_permalink( $post_ID ) . '">
                ' . $image_tag . '
            </a>
        </li>';

        return $item_tmpl;
    }
}

register_widget( 'Spyropress_Widget_Recent_Work' );