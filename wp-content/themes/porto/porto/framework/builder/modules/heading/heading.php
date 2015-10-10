<?php

/**
 * Module: Heading
 * Add headings into the page layout wherever needed.
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Heading extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings
        $this->cssclass = 'module-heading';
        $this->description = __( 'Add headings into the page layout wherever needed.', 'spyropress' );
        $this->id_base = 'spyropress_heading';
        $this->name = __( 'Heading', 'spyropress' );

        // Fields
        $this->fields = array(

            array(
                'label' => __( 'Heading Text', 'spyropress' ),
                'id' => 'heading',
                'type' => 'text',
            ),
            
            array(
                'label' => __( 'HTML Tag', 'spyropress' ),
                'id' => 'html_tag',
                'type' => 'select',
                'options' => array(
                    1 => __( 'H1', 'spyropress' ),
                    2 => __( 'H2', 'spyropress' ),
                    3 => __( 'H3', 'spyropress' ),
                    4 => __( 'H4', 'spyropress' ),
                    5 => __( 'H5', 'spyropress' ),
                    6 => __( 'H6', 'spyropress' )
                ),
                'std' => 2
            ),
            
            array(
                'label' => __( 'Animation', 'spyropress' ),
                'id' => 'animation',
                'type' => 'select',
                'options' => spyropress_get_options_animation()
            ),
            
            array(
                'label' => __( 'Styles', 'spyropress' ),
                'id' => 'styles',
                'type' => 'multi_select',
                'options' => array(
                    'short' => __( 'Short', 'spyropress' ),
                    'push-top' => __( 'Push Top', 'spyropress' ),
                    'spaced' => __( 'Spaced', 'spyropress' ),
                    'more-spaced' => __( 'More Spaced', 'spyropress' )
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

spyropress_builder_register_module( 'Spyropress_Module_Heading' );