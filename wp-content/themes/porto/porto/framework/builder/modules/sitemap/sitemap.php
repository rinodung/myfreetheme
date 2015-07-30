<?php
/**
 * Module: Sitemap
 * Add sitemap for your website. 
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Sitemap extends SpyropressBuilderModule {
    
	public function __construct() {
	   
       // Widget variable settings.
       $this->description = __( 'Add sitemap for your website.', 'spyropress' );
       $this->idbase = 'spyropress_sitemap';
       $this->name = __( 'Sitemap', 'spyropress' );
       
       // Fields
       $this->fields = array(
       
            array(
                'id' => 'info',
                'type' => 'info',
                'desc' => __( 'No options', 'spyropress' )
            )
       );
       
       $this->create_widget();
	}
    
    function widget( $args, $instance ) {
		
        // extracting info
        extract($args); extract($instance);
        
        // get view to render
        spyropress_get_nav_menu( array(
            'container' => false,
            'menu_class' => 'sitemap list icons',
            'before' => '<i class="fa fa-caret-right"></i>',
            'walker' => new Sitemap_Menu_Walker
        ), 'sitemap' );
	}
}

spyropress_builder_register_module( 'Spyropress_Module_Sitemap' );

if( !class_exists( 'Sitemap_Menu_Walker' ) ) {

class Sitemap_Menu_Walker extends Walker_Nav_Menu {

    function __construct() {

    }

    function start_lvl(&$output, $depth = 0, $args = array()) {

        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"list icons\">\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $args = (object)$args;

        $output .= $indent . '<li>';

        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) .'"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

        $item_output = $args->before;
        if( '#' != $item->url )
            $item_output .= '<a' . $attributes . '>';
                $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        if( '#' != $item->url )
            $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth,
            $args);
    }
}

}