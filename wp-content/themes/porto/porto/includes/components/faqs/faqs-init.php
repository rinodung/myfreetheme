<?php

/**
 * FAQ Component
 * 
 * @package		SpyroPress
 * @category	Components
 */

class SpyropressFaq extends SpyropressComponent {

    private $path;
    
    function __construct() {

        $this->path = dirname(__FILE__);
        add_action( 'spyropress_register_taxonomy', array( $this, 'register' ) );
        add_filter( 'builder_include_modules', array( $this, 'register_module' ) );
    }

    function register() {

        // Init Post Type
        $args = array(
            'supports' => array( 'title', 'editor' ),
            'title' => __( 'Enter question here', 'spyropress' ),
            'has_archive'   => false,
            'exclude_from_search' => true
        );
        $post = new SpyropressCustomPostType( __( 'FAQ', 'spyropress' ), 'faq', $args );
        
        // Add Taxonomy
        $post->add_taxonomy( __( 'FAQ Category', 'spyropress' ), 'faq_category', __( 'Categories', 'spyropress' ), array( 'hierarchical' => true ) );
    }
    
    function register_module( $modules ) {

        $modules[] = $this->path . '/module/module.php';

        return $modules;
    }
}

/**
 * Init the Component
 */
new SpyropressFaq();

?>