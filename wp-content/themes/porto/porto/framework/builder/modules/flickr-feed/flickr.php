<?php

/**
 * Module: Flickr Feed
 * A lightweight, component to show your flickr feed.
 *
 * @author 		SpyroSol
 * @category 	SpyropressBuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Flickr_Feed extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings
        $this->path = dirname( __file__ );
        
        $this->description = __( 'A lightweight, component to show your flickr feed', 'spyropress' );
        $this->id_base = 'flickr_feed';
        $this->cssclass = 'flickr-feed';
        $this->name = __( 'Flickr Feed', 'spyropress' );
        
        // Fields
        $this->fields = array(
            
            array(
                'label' => __( 'Title', 'spyropress' ),
                'id' => 'title',
                'type' => 'text',
            ),
            
            array(
                'label' => __( 'Flickr ID', 'spyropress' ),
                'id' => 'username',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Limit of Flickr gallery images', 'spyropress' ),
                'id' => 'limit',
                'type' => 'text',
                'std' => '6'
            ),
            
            array(
                'label' => __( 'Points', 'spyropress' ),
                'id' => 'points',
                'type' => 'repeater',
                'fields' => array(
                    array(
                        'id' => 'point',
                        'type' => 'text'
                    )
                )
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
spyropress_builder_register_module( 'Spyropress_Module_Flickr_Feed' );