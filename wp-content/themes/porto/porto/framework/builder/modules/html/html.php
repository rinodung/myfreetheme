<?php
/**
 * Module: HTML
 * Add raw HTML or JavaScript or you can apply Standard WordPress formatting. 
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_HTML extends SpyropressBuilderModule {
    
	public function __construct() {
	   
       // Widget variable settings.
       $this->cssclass = 'module-html';
       $this->description = __( 'Add raw HTML or JavaScript or you can apply Standard WordPress formatting.', 'spyropress' );
       $this->idbase = 'spyropress_html';
       $this->name = __( 'HTML', 'spyropress' );
       
       // Fields
       $this->fields = array(
       
            array(
                'options' => array(
                    '1' => __( 'Apply Wordpress formatting.', 'spyropress' )
                ),
                'id' => 'apply',
                'type' => 'checkbox'
            ),
            
            array(
                'id'        => 'html_text',
                'type'      => 'textarea',
                'class' => 'section-full',
                'rows'      => 15,
                'cols'      => 230
            )
       );
       
       $this->create_widget();
	}
    
    function widget( $args, $instance ) {
		
        // extracting info
        $apply = false;
        extract($args); extract( $instance );
        
        // get view to render
        include $this->get_view();
	}

}
spyropress_builder_register_module( 'Spyropress_Module_HTML' );