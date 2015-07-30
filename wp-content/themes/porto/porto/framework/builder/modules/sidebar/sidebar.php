<?php

/**
 * Module: SideBar
 * Place a WordPress Sidebar in to the layout.
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_SideBar extends SpyropressBuilderModule {
    
	public function __construct() {
       
       // Widget variable settings.
       $this->cssclass = 'sidebar';
       $this->description = __( 'Place a WordPress Sidebar in to the layout.', 'spyropress' );
       $this->idbase = 'spyropress_sidebar';
       $this->name = __( 'SideBar', 'spyropress' );
        
        global $wp_registered_sidebars;
        foreach ( $wp_registered_sidebars as $key => $sidebar )
            $reg_sidebars[$key] = $sidebar['name'];
        
        // Fields
        $this->fields = array(            
            array(
                'label' => __( 'Registered Sidebars', 'spyropress' ),
                'id'        => 'sidebar',
                'type'      => 'select',
                'options'   => $reg_sidebars
            )
       );
       
       $this->create_widget();
	}
    
    public function widget( $args, $instance ) {
		// extracting info
        extract($args); extract( $instance );
        // get view to render
        include $this->get_view();
	}
}

spyropress_builder_register_module( 'Spyropress_Module_SideBar' );