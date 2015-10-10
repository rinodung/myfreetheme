<?php

/**
 * Module: Toggle
 *
 * @author 		SpyroSol
 * @category 	SpyropressBuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Toggle extends SpyropressBuilderModule {

    public function __construct() {

        $this->path = dirname(__FILE__);
        
        // Widget variable settings
        $this->description = __( 'Toggle Content Builder', 'spyropress' );
        $this->id_base = 'toggle';
        $this->cssclass = 'toogle';
        $this->name = __( 'Toggle Content', 'spyropress' );

        // Fields     
        $this->templates['one'] = array(
            'label' => __( 'One Toggle at a Time', 'spyropress' )
        );
        
        $this->fields = array(
            array(
                'label' => __( 'Styles', 'spyropress' ),
                'id' => 'template',
                'type' => 'select',
                'options' => $this->get_option_templates()
            ),
            
            array(
                'label' => __( 'Toggles', 'spyropress' ),
                'id' => 'toggles',
                'type' => 'repeater',
                'item_title' => 'title',
                'fields' => array(
                    
                    array(
                        'label' => __( 'Title', 'spyropress' ),
                        'id' => 'title',
                        'type' => 'text'
                    ),
                    
                    array(
                        'label' => __( 'Bucket', 'spyropress' ),
                        'id' => 'bucket',
                        'type' => 'select',
                        'desc' => __( 'If you want to use html instead of plain text.', 'spyropress' ),
                        'options' => spyropress_get_buckets()
                    ),
                    
                    array(
                        'label' => __( 'Content', 'spyropress' ),
                        'id' => 'content',
                        'type' => 'textarea',
                        'rows' => 7
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
        $template = isset( $instance['template'] ) ? $instance['template'] : '';
        include $this->get_view( $template );
    }

}
spyropress_builder_register_module( 'Spyropress_Module_Toggle' );