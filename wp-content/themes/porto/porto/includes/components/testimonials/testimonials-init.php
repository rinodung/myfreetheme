<?php

/**
 * Testomonial Component
 * 
 * @package		SpyroPress
 * @category	Components
 */

class SpyropressTestomonial extends SpyropressComponent {

    private $path;
    
    function __construct() {

        $this->path = dirname(__FILE__);
        add_action( 'spyropress_register_taxonomy', array( $this, 'register' ) );
        add_filter( 'builder_include_modules', array( $this, 'register_module' ) );
    }

    function register() {

        // Init Post Type
        $args = array(
            'supports' => array( 'title', 'thumbnail' ),
            'title' => __( 'Enter name here..', 'spyropress' ),
            'has_archive'   => false,
            'exclude_from_search' => true
        );
        $post = new SpyropressCustomPostType( __( 'Testimonial', 'spyropress' ), 'testimonial', $args );

        // Add Taxonomy
        $post->add_taxonomy( __( 'Testimonial Category', 'spyropress' ), '', __( 'Categories', 'spyropress' ), array( 'hierarchical' => true ) );
        
        // Add Meta Boxes
        $meta_fields['testimonial'] = array(
            array(
                'label' => __( 'Testimonial', 'spyropress' ),
                'type' => 'heading',
                'slug' => 'testimonial'
            ),
            
            array(
                'label' => __( 'Testimonial', 'spyropress' ),
                'id' => 'testimonial',
                'type' => 'editor'
            ),

            array(
                'label' => __( 'Designation', 'spyropress' ),
                'id' => 'designation',
                'type' => 'text'
            ),

            array(
                'label' => __( 'Company', 'spyropress' ),
                'id' => 'website',
                'type' => 'text'
            )
        );

        $post->add_meta_box( 'testimonial_info', __( 'Testimonial', 'spyropress' ), $meta_fields, '_testimonial', false, 'normal', 'high' );
    }

    function register_module( $modules ) {

        $modules[] = $this->path . '/module/module.php';

        return $modules;
    }
}

/**
 * Init the Component
 */
new SpyropressTestomonial();