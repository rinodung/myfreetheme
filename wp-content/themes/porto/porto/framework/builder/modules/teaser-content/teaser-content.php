<?php

/**
 * Module: Teaser Content
 * A flexible component to emphasize content on your site.
 *
 * @author 		SpyroSol
 * @category 	SpyropressBuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Teaser_Content extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings
        $this->description = __( 'A flexible component to emphasize content on your site.', 'spyropress' );
        $this->id_base = 'teaser_content';
        $this->name = __( 'Teaser Content', 'spyropress' );
        
        $this->templates['style1'] = array(
            'label' => __( 'Featured', 'spyropress' )
        );
        
        $this->templates['style2'] = array(
            'label' => __( 'Tall', 'spyropress' )
        );
        
        // Fields
        $this->fields = array(
            
            array(
                'label' => __( 'Styles', 'spyropress' ),
                'id' => 'style',
                'type' => 'select',
                'options' => $this->get_option_templates(),
                'std' => 'style1'
            ),
            
            array(
                'label' => __( 'Teaser Line 1', 'spyropress' ),
                'id' => 'teaser1',
                'type' => 'textarea',
                'rows' => 6
            ),
            
            array(
                'label' => __( 'Teaser Line 2', 'spyropress' ),
                'id' => 'teaser2',
                'type' => 'textarea',
                'rows' => 6
            )
        );

        $this->create_widget();
    }

    function widget( $args, $instance ) {

        // extracting info
        $instance = spyropress_clean_array( $instance );
        extract( $args ); extract( $instance );
        // get view to render
        include $this->get_view();
    }

}
spyropress_builder_register_module( 'Spyropress_Module_Teaser_Content' );