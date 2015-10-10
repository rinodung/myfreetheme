<?php

/**
 * Module: Skills
 *
 * @author 		SpyroSol
 * @category 	SpyropressBuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Skill_Knob extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings.
        $this->path = dirname( __FILE__ );
        
        $this->description = __( 'List your skills.', 'spyropress' );
        $this->id_base = 'spyroress_skills';
        $this->name = __( 'Skills', 'spyropress' );
        
        // Fields
        $this->fields = array(
            
            array(
                'label' => __( 'Title', 'spyropress' ),
                'id' => 'title',
                'type' => 'text'
            ),
            
            array(
                'label' => __( 'Percentage', 'spyropress' ),
                'id' => 'percentage',
                'type' => 'range_slider'
            ),
            
            array(
                'label' => __( 'Knob Color', 'spyropress' ),
                'id' => 'knob_color',
                'type' => 'colorpicker'
            ),
            
            array(
                'label' => __( 'Delay', 'spyropress' ),
                'id' => 'delay',
                'type' => 'range_slider',
                'max' => 4000
            ),
        );

        $this->create_widget();
    }

    function widget( $args, $instance ) {

        // extracting info
        $delay = 0;
        extract( $args ); extract( $instance );
        
        // get view to render
        include $this->get_view();
    }

}
spyropress_builder_register_module( 'Spyropress_Module_Skill_Knob' );