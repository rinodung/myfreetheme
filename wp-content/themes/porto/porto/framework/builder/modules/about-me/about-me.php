<?php

/**
 * Module: About Me
 * A lightweight, flexible component to showcase intro
 *
 * @author 		SpyroSol
 * @category 	SpyropressBuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_About_Me extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings        
        $this->description = __( 'Biography', 'spyropress' );
        $this->id_base = 'about_me';
        $this->name = __( 'About Me', 'spyropress' );
        
        // Fields
        $this->fields = array(
                
            array(
                'label' => __( 'Full Name', 'spyropress' ),
                'id' => 'full_name',
                'type' => 'text'
            ),
            
            array(
                'label' => __( 'Designation', 'spyropress' ),
                'id' => 'designation',
                'type' => 'text'
            ),
            
            array(
                'label' => __( 'Social Identities', 'spyropress' ),
                'id' => 'socials',
                'type' => 'repeater',
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
                    	'type' => 'text'
                    )
                )
            ),
            
            array(
                'label' => __( 'About yourself', 'spyropress' ),
                'id' => 'about',
                'type' => 'editor',
                'rows' => 10
            )
        );

        $this->create_widget();
    }

    function widget( $args, $instance ) {

        // extracting info
        extract( $args ); extract( $instance );
        // get view to render
        include $this->get_view();
    }

}
spyropress_builder_register_module( 'Spyropress_Module_About_Me' );