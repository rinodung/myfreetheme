<?php

/**
 * Module: Call of Action
 * A lightweight, flexible component to showcase key content on your site.
 *
 * @author 		SpyroSol
 * @category 	SpyropressBuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Call_Action extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings
        $this->path = dirname( __file__ );
        
        $this->description = __( 'Call of Action', 'spyropress' );
        $this->id_base = 'call_action';
        $this->cssclass = 'call-action';
        $this->name = __( 'Call of Action', 'spyropress' );
        
        $this->templates['compact'] = array(
            'label' => __( 'Compact View', 'spyropress' ),
            'class' => 'home-intro home-intro-compact'
        );
        
        $this->templates['big'] = array(
            'label' => __( 'Big Teaser', 'spyropress' ),
            'view' => 'bigview.php'
        );
        
        // Fields
        $this->fields = array(
            
            array(
                'label' => __( 'Styles', 'spyropress' ),
                'id' => 'template',
                'type' => 'select',
                'options' => $this->get_option_templates()
            ),
            
            array(
                'label' => __( 'Title', 'spyropress' ),
                'id' => 'title',
                'type' => 'text',
            ),
            
            array(
                'label' => __( 'Sub Title', 'spyropress' ),
                'id' => 'sub_title',
                'type' => 'textarea',
                'rows' => 5
            ),
            
            array(
                'label' => __( 'Button Setting', 'spyropress' ),
                'type' => 'toggle'
            ),
    
            array(
                'label' => __( 'Link Text', 'spyropress' ),
                'id' => 'btn_url_text',
                'type' => 'text'
            ),
    
            array(
                'label' => __( 'URL/Hash', 'spyropress' ),
                'id' => 'btn_url',
                'type' => 'text'
            ),
    
            array(
                'label' => __( 'Link to Post/Page', 'spyropress' ),
                'id' => 'btn_link_url',
                'type' => 'page'
            ),
    
            array( 'type' => 'toggle_end' ),
            
            array(
                'label' => __( 'Link Setting', 'spyropress' ),
                'type' => 'toggle'
            ),
    
            array(
                'label' => __( 'Link Text', 'spyropress' ),
                'id' => 'url_text',
                'type' => 'text'
            ),
    
            array(
                'label' => __( 'URL/Hash', 'spyropress' ),
                'id' => 'url',
                'type' => 'text'
            ),
    
            array(
                'label' => __( 'Link to Post/Page', 'spyropress' ),
                'id' => 'link_url',
                'type' => 'page'
            ),
    
            array( 'type' => 'toggle_end' )
        );

        $this->create_widget();
    }

    function widget( $args, $instance ) {

        // extracting info
        extract( $args ); extract( $instance );
        // get view to render
        include $this->get_view( $template );
    }

}
spyropress_builder_register_module( 'Spyropress_Module_Call_Action' );