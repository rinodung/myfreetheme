<?php

/**
 * Module: Timeline
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Timeline extends SpyropressBuilderModule {

    /**
     * Constructor
     */
    public function __construct() {

        $this->path = dirname(__FILE__);
        
        // Widget variable settings
        $this->description = __( 'A flexible component to generate Timeline.', 'spyropress' );
        $this->id_base = 'timeline';
        $this->name = __( 'Timeline', 'spyropress' );
        
        // Fields
        $this->fields = array (
            
            array(
                'label' => __( 'Title', 'spyropress' ),
                'id' => 'title',
                'type' => 'text'
            ),
            
            array(
                'label' => __( 'Lines', 'spyropress' ),
                'id' => 'lines',
                'type' => 'repeater',
                'item_title' => 'heading',
                'fields' => array(
                    array(
                        'label' => __( 'Heading', 'spyropress' ),
                        'id' => 'heading',
                        'type' => 'text'
                    ),
                    
                    array(
                        'label' => __( 'Teaser', 'spyropress' ),
                        'id' => 'content',
                        'type' => 'textarea',
                        'rows' => 4
                    ),
                    
                    array(
                        'label' => __( 'Image', 'spyropress' ),
                        'id' => 'img',
                        'type' => 'upload'
                    )
                )
            )
        );
        
        $this->create_widget();
    }

    function widget( $args, $instance ) {
        
        // extracting info
        extract( $args ); extract( $instance );
        include $this->get_view();
    }

}

spyropress_builder_register_module( 'Spyropress_Module_Timeline' );