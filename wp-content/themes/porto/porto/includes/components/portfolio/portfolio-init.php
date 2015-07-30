<?php

/**
 * Portfolio Component
 *
 * @package		SpyroPress
 * @category	Components
 */

class SpyropressPortfolio extends SpyropressComponent {

    private $path;
    
    function __construct() {

        $this->path = dirname(__FILE__);
        add_action( 'spyropress_register_taxonomy', array( $this, 'register' ) );
        add_filter( 'builder_include_modules', array( $this, 'register_module' ) );
        add_filter( 'spyropress_register_widgets', array( $this, 'register_widgets' ) );
    }

    function register() {

        // Init Post Type
        $args = array(
            'supports'      => array( 'title', 'editor', 'thumbnail' ),
            'has_archive'   => false,
            'exclude_from_search' => false,
            'rewrite' => array( 'slug' => get_setting( 'portfolio-slug', 'portfolio' ) ),
            'menu_icon' => 'dashicons-portfolio'
        );
        $post = new SpyropressCustomPostType( __( 'Portfolio', 'spyropress' ), '', $args );
        
        // Add Taxonomy
        $post->add_taxonomy( __( 'Category', 'spyropress' ), 'portfolio_category', __( 'Portfolio Categories', 'spyropress' ), array( 'hierarchical' => true ) );
        $post->add_taxonomy( __( 'Services', 'spyropress' ), 'portfolio_service', __( 'Services', 'spyropress' ), array( 'hierarchical' => false ) );
        
        // Add Meta Boxes
        $meta_fields['portfolio'] = array(
            array(
                'label' => __( 'Portfolio', 'spyropress' ),
                'type' => 'heading',
                'slug' => 'portfolio'
            ),
    
            array(
                'label' => __( 'Project URL', 'spyropress' ),
                'id' => 'project_url',
                'type' => 'text'
            ),
            
            array(
                'label' => __( 'Client', 'spyropress' ),
                'id' => 'project_client',
                'type' => 'text'
            ),
    
            array(
                'label' => __( 'Client Testimonial', 'spyropress' ),
                'id' => 'project_testimonial',
                'type' => 'textarea',
                'rows' => 7
            ),
    
            array(
                'label' => __( 'Showcase Type', 'spyropress' ),
                'id' => 'p_type',
                'type' => 'select',
                'options' => array(
                    'gallery' => __( 'Gallery', 'spyropress' ),
                    'video' => __( 'Video', 'spyropress' )
                ),
                'class' => 'enable_changer'
            ),
            
            array(
                'label' => __( 'Gallery', 'spyropress' ),
                'desc' => __( 'Click to upload images', 'spyropress' ),
                'id' => 'gallery',
                'type' => 'gallery',
                'class' => 'p_type gallery'
            ),
            
            array(
                'label' => __( 'Video', 'spyropress' ),
                'id' => 'video',
                'type' => 'textarea',
                'rows' => 5,
                'class' => 'p_type video'
            ),
            
        );
        
        $post->add_meta_box( 'portfolio', __( 'Portfolio Details', 'spyropress' ), $meta_fields, false, false, 'normal', 'high' );
    }
    
    function register_module( $modules ) {

        $modules[] = $this->path . '/recent-portfolio/portfolio.php';

        return $modules;
    }
    
    function register_widgets( $widgets ) {
        $widgets[] = $this->path . '/recent-works/widget.php';
        
        return $widgets;
    }
}

/**
 * Init the Component
 */
new SpyropressPortfolio();