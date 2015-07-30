<?php

/**
 * Module: Blog
 * Display a list of posts
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Blog extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings.
        $this->path = dirname( __FILE__ );
        
        $this->description = __( 'Display a list of posts', 'spyropress' );
        $this->id_base = 'recent_posts';
        $this->name = __( 'Blog', 'spyropress' );
        
        // Templates
        $this->templates['full'] = array(
            'label' => __( 'Full Width', 'spyropress' )
        );
        
        $this->templates['large'] = array(
            'label' => __( 'Large Image', 'spyropress' )
        );
        
        $this->templates['medium'] = array(
            'label' => __( 'Medium Image', 'spyropress' ),
            'view' => 'medium.php'
        );
        
        $this->templates['timeline'] = array(
            'label' => __( 'Timeline', 'spyropress' ),
            'view' => 'timeline.php'
        );
        
        // Fields
        $this->fields = array(

            array(
                'label' => __( 'Templates', 'spyropress' ),
                'id' => 'layout',
                'type' => 'select',
                'class' => 'enable_changer section-full',
                'options' => $this->get_option_templates(),
        		'std' => 'full'
            ),

            array(
                'label' => __( 'Number of items per page', 'spyropress' ),
                'id' => 'limit',
                'type' => 'range_slider',
                'std' => 6
            ),
            
            array(
                'label' => __( 'Category', 'spyropress' ),
                'id' => 'cat',
                'type' => 'multi_select',
                'options' => spyropress_get_taxonomies( 'category' )
            )
        );

        $this->create_widget();
    }

    function widget( $args, $instance ) {
        
        // extracting info
        extract( $args );

        // get view to render
        $template = isset( $instance['layout'] ) ? $instance['layout'] : 'full';
        include $this->get_view( $template );
    }
    
    function query( $atts ) {

        $default = array (
            'limit' => -1,
            'pagination' => true
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
        
        if ( $atts['limit'] ) {
            $atts['posts_per_page'] = $atts['limit'];
            unset( $atts['limit'] );
    
            if ( $atts['pagination'] ) {
                $atts['paged'] = get_page_query();
            }
        }
    
        return $atts;
    }
}

spyropress_builder_register_module( 'Spyropress_Module_Blog' );