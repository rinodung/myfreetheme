<?php

/**
 * Module: Stats Counter
 *
 * @author 		SpyroSol
 * @category 	SpyropressBuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Counters extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings.
        $this->path = dirname( __FILE__ );
        
        $this->description = __( 'Display stats as counters.', 'spyropress' );
        $this->id_base = 'spyroress_counters';
        $this->name = __( 'Stats Counter', 'spyropress' );
        
        // Fields
        $this->fields = array(
            
            array(
                'label' => __( 'Stats', 'spyropress' ),
                'id' => 'stats',
                'type' => 'repeater',
                'item_title' => 'title',
                'fields' => array(
                    array(
                        'label' => __( 'Title', 'spyropress' ),
                        'id' => 'title',
                        'type' => 'text'
                    ),
                    
                    array(
                        'label' => __( 'Counter', 'spyropress' ),
                        'id' => 'count',
                        'type' => 'text'
                    ),
                    
                    array(
                        'label' => __( 'Append text', 'spyropress' ),
                        'id' => 'append',
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
        
        if( empty( $stats ) ) return;
        
        // get view to render
        include $this->get_view();
    }

}
spyropress_builder_register_module( 'Spyropress_Module_Counters' );