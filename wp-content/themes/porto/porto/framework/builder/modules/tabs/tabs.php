<?php

/**
 * Module: Tabs
 *
 * @author 		SpyroSol
 * @category 	SpyropressBuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Tabs extends SpyropressBuilderModule {

    public function __construct() {

        $this->path = dirname(__FILE__);
        // Widget variable settings
        $this->description = __( 'Tab Builder.', 'spyropress' );
        $this->id_base = 'tab';
        $this->name = __( 'Tabs', 'spyropress' );

        // Fields
        $this->fields = array(
            array(
                'label' => __( 'Tab Position', 'spyropress' ),
                'id' => 'tab_position',
                'type' => 'select',
                'options' => array(
                    'top' => __( 'Top', 'spyropress' ),
                    'bottom' => __( 'Bottom', 'spyropress' ),
                    'vertical' => __( 'Vertical', 'spyropress' ),
                )
            ),
            
            array(
                'label' => __( 'Tab Alignment', 'spyropress' ),
                'id' => 'tab_align',
                'type' => 'select',
                'options' => array(
                    'left' => __( 'Left', 'spyropress' ),
                    'right' => __( 'Right', 'spyropress' ),
                    'justified' => __( 'Justified', 'spyropress' ),
                )
            ),
                    
            array(
                'label' => __( 'Tab', 'spyropress' ),
                'id' => 'tabs',
                'type' => 'repeater',
                'item_title' => 'title',
                'fields' => array(
                    
                    array(
                        'label' => __( 'Title', 'spyropress' ),
                        'id' => 'title',
                        'type' => 'text'
                    ),
                    
                    array(
                        'label' => __( 'Icon', 'spyropress' ),
                        'id' => 'icon',
                        'type' => 'select',
                        'options' => spyropress_get_options_fontawesome_icons(),
                        'desc' => __( 'See the <a target="_blank" href="http://fontawesome.io/icons/">icons here</a>.', 'spyropress' )
                    ),
                    
                    array(
                        'label' => __( 'Tab Bucket', 'spyropress' ),
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
                    ),
                )
            )
        );

        $this->create_widget();
    }

    function widget( $args, $instance ) {

        // Defaults
        $defaults = array(
            'tab_position' => 'top',
            'tab_align' => 'left'
        );
        
        // extracting info
        extract( $args ); extract( wp_parse_args( spyropress_clean_array( $instance ), $defaults ) );
        
        // get view to render
        include $this->get_view();
    }

}
spyropress_builder_register_module( 'Spyropress_Module_Tabs' );

global $spyropress_tab_counter;
$spyropress_tab_counter = 0;