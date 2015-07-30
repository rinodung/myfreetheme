<?php

/**
 * Staff Component
 * 
 * @package		SpyroPress
 * @category	Components
 */

class SpyropressStaff extends SpyropressComponent {

    private $path;
    
    function __construct() {

        $this->path = dirname(__FILE__);
        add_action( 'spyropress_register_taxonomy', array( $this, 'register' ) );
        add_filter( 'builder_include_modules', array( $this, 'register_module' ) );
    }

    function register() {

        // Init Post Type
        $args = array(
            'title'     => __( 'Enter name here..', 'spyropress' ),
            'public'    => false,
            'supports'  => array( 'title', 'thumbnail' ),
            'menu_icon' => 'dashicons-admin-users'
        );
        $post = new SpyropressCustomPostType( __( 'Staff', 'spyropress' ), 'staff', $args );
        $post->add_taxonomy( __( 'Designation', 'spyropress' ), '', '', array( 'hierarchical' => true ) );
        
        // Add Meta Boxes
        $meta_fields['staff'] = array(
            array(
                'label' => __( 'Staffs', 'spyropress' ),
                'type' => 'heading',
                'slug' => 'staff'
            ),

            array(
                'label' => __( 'About', 'spyropress' ),
                'id' => 'about',
                'type' => 'editor',
                'rows' => 6
            ),

            array(
                'label' => __( 'Social', 'spyropress' ),
                'type' => 'repeater',
                'id' => 'socials',
                'item_title' => 'network',
                'fields' => array(
                    array(
                        'label' => __( 'Network', 'spyropress' ),
                        'id' => 'network',
                        'type' => 'select',
                        'options' => spyropress_get_options_social()
                    ),
        
                    array(
                        'label' => __( 'URL', 'spyropress' ),
                        'id' => 'url',
                        'type' => 'text',
                    )
                )
        	),
            
            array(
                'label' => __( 'Link to Page', 'spyropress' ),
                'id' => 'link_page',
                'type' => 'page'
            )
        );

        $post->add_meta_box( 'staff_info', __( 'Mate Information', 'spyropress' ), $meta_fields, '_mate_info', false );
    }
    
    function register_module( $modules ) {

        $modules[] = $this->path . '/module/staff.php';

        return $modules;
    }
}

/**
 * Init the Component
 */
new SpyropressStaff();
?>