<?php

/**
 * Module: Home Concept
 * A flexible component to showcase your concept.
 *
 * @author 		SpyroSol
 * @category 	SpyropressBuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Home_Concept extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings
        $this->description = __( 'A flexible component to showcase your concept', 'spyropress' );
        $this->id_base = 'home_concept';
        $this->name = __( 'Home Concept', 'spyropress' );

        // Fields
        $this->fields = array(

            array(
                'label' => __( 'Concepts', 'spyropress' ),
                'id' => 'concepts',
                'item_field' => 'title',
                'type' => 'repeater',
                'fields' => array(
                    array(
                        'label' => __( 'Title', 'spyropress' ),
                        'id' => 'title',
                        'type' => 'text',
                    ),

                    array(
                        'label' => __( 'Image', 'spyropress' ),
                        'id' => 'img',
                        'type' => 'upload',
                    ),
                )
            ),

            array(
                'label' => __( 'Works', 'spyropress' ),
                'type' => 'sub_heading',
            ),

            array(
                'label' => __( 'Title', 'spyropress' ),
                'id' => 'work_title',
                'type' => 'text',
            ),

            array(
                'id' => 'works',
                'type' => 'repeater',
                'fields' => array(

                    array(
                        'label' => __( 'Image', 'spyropress' ),
                        'id' => 'img',
                        'type' => 'upload',
                    ),

                    array(
                        'label' => __( 'Link', 'spyropress' ),
                        'id' => 'link',
                        'type' => 'custom_post',
                        'post_type' => array( 'portfolio' )
                    ),
                    
                    array(
                        'label' => __( 'External Link', 'spyropress' ),
                        'id' => 'url',
                        'type' => 'text'
                    )
                )
            )
        );

        $this->create_widget();
    }

    function widget( $args, $instance ) {

        extract( $args ); extract( $instance );

        // get view to render
        if( empty( $concepts ) ) return;

        include $this->get_view();
    }

}
spyropress_builder_register_module( 'Spyropress_Module_Home_Concept' );