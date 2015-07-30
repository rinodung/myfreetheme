<?php

/**
 * Module: Carousel
 * Display an Image Carousel
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Carousel extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings.
        $this->cssclass = 'module-carousel';
        $this->description = __( 'Display an Image Carousel', 'spyropress' );
        $this->idbase = 'spyropress_carousel';
        $this->name = __( 'Carousel', 'spyropress' );

        // Fields
        $this->fields = array(            
            array(
                'label' => __('Slides', 'spyropress'),
                'type' => 'repeater',
                'id' => 'slides',
                'fields' => array(
                    array(
                        'name' => __('Image', 'spyropress'),
                        'id' => 'image',
                        'type' => 'upload',
                    )
                )
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

spyropress_builder_register_module( 'Spyropress_Module_Carousel' );