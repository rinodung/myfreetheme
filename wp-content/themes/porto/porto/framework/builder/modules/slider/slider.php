<?php

/**
 * Module: Slider
 * Flexslider of images
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_FlexSlider extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings.
        $this->path = dirname( __FILE__ );
        
        $this->cssclass = '';
        $this->description = __( 'Slide content or images using FlexSlider', 'spyropress' );
        $this->idbase = 'spyropress_flexslider';
        $this->name = __( 'Slider', 'spyropress' );

        // Fields
        $this->templates['image'] = array(
            'label' => 'Image Slider'
        );
        
        $this->templates['image2'] = array(
            'label' => 'Image Slider with Border'
        );
        
        $this->templates['content'] = array(
            'label' => 'Content Slider',
            'view' => 'content.php'
        );
        
        $this->fields = array(            
            
            array(
                'label' => __( 'Template', 'spyropress' ),
                'id' => 'template',
                'type' => 'select',
                'options' => $this->get_option_templates(),
                'class' => 'enable_changer section-full',
                'std' => 'image'
            ),
            
            array(
                'label' => __('Slides', 'spyropress'),
                'type' => 'repeater',
                'id' => 'slides',
                'fields' => array(
                    array(
                        'name' => __('Image', 'spyropress'),
                        'id' => 'image',
                        'type' => 'upload',
                        'class' => 'template image image2 section-full'
                    ),
                    
                    array(
                        'name' => __('Content', 'spyropress'),
                        'id' => 'content',
                        'type' => 'textarea',
                        'class' => 'template content section-full'
                    )
                )
            ),
            
            array(
                'id' => 'controlNav',
                'type' => 'checkbox',
                'options' => array(
                    '1' => __( 'Display control navigation', 'spyropress' )
                )
            ),
            
            array(
                'id' => 'directionNav',
                'type' => 'checkbox',
                'options' => array(
                    '1' => 'Display direction navigation'
                )
            ),
            
            array(
                'id' => 'slideshow',
                'type' => 'checkbox',
                'options' => array(
                    '1' => 'Enable AutoPlay'
                )
            ),
            
            array(
                'id' => 'autoheight',
                'type' => 'checkbox',
                'options' => array(
                    '1' => 'Enable AutoHeight'
                )
            ),
            
            array(
                'id' => 'items',
                'type' => 'range_slider',
                'label' => __( 'Number of items', 'spyropress' ),
                'std' => 1,
                'min' => 1,
                'max' => 20
            ),
            
            array(
                'label' => 'Animation',
                'id' => 'animation',
                'type' => 'select',
                'options' => array(
                    'backSlide' => 'Back Slide',
                    'fade' => 'Fade',
                    'fadeUp' => 'Fade Up',
                    'goDown' => 'Go Down',
                    'slide' => 'Slide'
                )
            )

        );

        $this->create_widget();
    }

    function widget( $args, $instance ) {
        
        // extracting info
        $defaults = array(
            'controlNav' => false,
            'directionNav' => false,
            'animation' => false,
            'slideshow' => false,
            'autoheight' => false,
            'items' => 1
        );
        extract( $args ); extract( wp_parse_args( $instance, $defaults ) );
        
        // get view to render
        include $this->get_view( $template );
    }

}

spyropress_builder_register_module( 'Spyropress_Module_FlexSlider' );