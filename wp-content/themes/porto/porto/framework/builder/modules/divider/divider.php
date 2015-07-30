<?php

/**
 * Module: Divider 
 * Separate sections of the layout.
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Divider extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings
        $this->description = __('Separate sections of the layout.', 'spyropress');
        $this->id_base = 'spyropress_divider';
        $this->name = __('Divider', 'spyropress');
        
        $this->fields = array(
            array(
                'type' => 'multi_select',
                'id' => 'style',
                'label' => __( 'Styles', 'spyropress' ),
                'options' => array(
                    'short' => __( 'Short', 'spyropress' ),
                    'tall' => __( 'Tall', 'spyropress' ),
                    'taller' => __( 'Taller', 'spyropress' ),
                    'light' => __( 'Light', 'spyropress' ),
                    'divider_flat' => __( 'Flat Divider', 'spyropress' )
                ),
                'std' => 'tall'
            )
        );
        $this->create_widget();

    }

    function widget($args, $instance) {
        
        // outputs the content of the widget
        extract( $instance );
        
        if( !is_array( $style ) ) {
            $style = ( 's1' == $style ) ? array( 'tall' ) : array();
        }
        
        echo '<hr class="' . spyropress_clean_cssclass( $style ) . '" />';
    }

}

spyropress_builder_register_module('Spyropress_Module_Divider');