<?php

/**
 * Module: Rich Text
 * Provides a WYSIWYG editor.
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Rich_Text extends SpyropressBuilderModule {

    public function __construct() {
        
        // Widget variable settings.
        $this->cssclass = 'rich-text';
        $this->description = __( 'Provides a WYSIWYG editor.', 'spyropress' );
        $this->id_base = 'rich_text';
        $this->name = __( 'Rich Text', 'spyropress' );

        // Fields
        $this->fields = array(
            array(
                'id' => 'rich_text',
                'type' => 'editor'
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

spyropress_builder_register_module( 'Spyropress_Module_Rich_Text' );