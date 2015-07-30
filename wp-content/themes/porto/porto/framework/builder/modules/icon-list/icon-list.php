<?php

/**
 * Module: Icon List
 *
 * @author 		SpyroSol
 * @category 	SpyropressBuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Icon_List extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings.
        $this->path = dirname( __FILE__ );
        
        $this->description = __( 'List your text with icons.', 'spyropress' );
        $this->id_base = 'icon_list';
        $this->name = __( 'Icon List', 'spyropress' );
        
        // Fields
        $this->fields = array(            
            
            array(
                'label' => __( 'Same Icon for All', 'spyropress' ),
                'id' => 'same_icon',
                'type' => 'select',
                'options' => spyropress_get_options_fontawesome_icons()
            ),
            
            array(
                'label' => __( 'Style', 'spyropress' ),
                'id' => 'style',
                'type' => 'select',
                'options' => array(
                    'in' => __( 'Indent', 'spyropress' ),
                    'list-unstyled' => __( 'Unindent', 'spyropress' )
                ),
                'std' => 'in'
            ),
                    
            array(
                'label' => __( 'List', 'spyropress' ),
                'id' => 'list',
                'type' => 'repeater',
                'item_title' => 'title',
                'fields' => array(
                    array(
                        'label' => __( 'Content', 'spyropress' ),
                        'id' => 'content',
                        'type' => 'textarea',
                        'rows' => 7
                    ),
                    
                    array(
                        'label' => __( 'Icon', 'spyropress' ),
                        'id' => 'icon',
                        'type' => 'select',
                        'options' => spyropress_get_options_fontawesome_icons()
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
spyropress_builder_register_module( 'Spyropress_Module_Icon_List' );