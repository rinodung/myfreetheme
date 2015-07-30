<?php

/**
 * Module: Our Clients
 * Display a list of our clients
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Our_Clients extends SpyropressBuilderModule {

    /**
     * Constructor
     */
    public function __construct() {

        // Widget variable settings
        $this->description = __( 'Display a list of our clients.', 'spyropress' );
        $this->id_base = 'spyropress_our_clients';
        $this->name = __( 'Our Clients', 'spyropress' );

        // Fields
        $this->fields = array (

            array(
                'id' => 'clients',
                'label' => __( 'Client', 'spyropress' ),
                'type' => 'repeater',
                'fields' => array(
                    array(
                        'label' => __( 'Logo', 'spyropress' ),
                        'id' => 'logo',
                        'type' => 'upload'
                    ),
                    
                    array(
                        'label' => __( 'Link to Client Website', 'spyropress' ),
                        'id' => 'url',
                        'type' => 'text'
                    )
                )
            )
        );

        $this->create_widget();
    }

    function widget( $args, $instance ) {

        // extracting info
        extract( $args ); extract( $instance );

        include $this->get_view();
    }

}

spyropress_builder_register_module( 'Spyropress_Module_Our_Clients' );