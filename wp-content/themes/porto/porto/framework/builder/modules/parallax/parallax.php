<?php

/**
 * Module: Parallax
 *
 * @author 		SpyroSol
 * @category 	SpyropressBuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Parallax extends SpyropressBuilderModule {

    public function __construct() {

        $this->description = __( 'Parallax section creator.', 'spyropress' );
        $this->id_base = 'parallax';
        $this->name = __( 'Parallax', 'spyropress' );
        
        // Fields
        $this->fields = array(
            
            array(
                'label' => __( 'Skin', 'spyropress' ),
                'id' => 'skin',
                'type' => 'select',
                'options' => array(
                    'dark' => __( 'Light', 'spyropress' ),
                    'white' => __( 'Dark', 'spyropress' )
                ),
                'std' => 'white'
            ),
            
            array(
                'label' => __( 'Background Image', 'spyropress' ),
                'id' => 'background',
                'type' => 'upload',
            ),
            
            array(
                'label' => __( 'Title', 'spyropress' ),
                'id' => 'title',
                'type' => 'text',
            ),
            
            array(
                'label' => __( 'Title Animation', 'spyropress' ),
                'id' => 'title_animation',
                'type' => 'select',
                'options' => spyropress_get_options_animation()
            ),
            
            array(
                'label' => __( 'Teaser', 'spyropress' ),
                'id' => 'teaser',
                'type' => 'text',
            ),
            
            array(
                'label' => __( 'Teaser Animation', 'spyropress' ),
                'id' => 'teaser_animation',
                'type' => 'select',
                'options' => spyropress_get_options_animation()
            ),
            
            array(
                'label' => __( 'Icon', 'spyropress' ),
                'id' => 'icon',
                'type' => 'text',
            ),
            
            array(
                'label' => __( 'Icon Animation', 'spyropress' ),
                'id' => 'icon_animation',
                'type' => 'select',
                'options' => spyropress_get_options_animation()
            ),
        );

        $this->create_widget();
    }
    
    function generate_item( $item, $atts ) {
        
        return '
        <div class="' . $atts['column_class'] . '">
            <div class="feature-box">
    			<div class="feature-box-icon">
    				<i class="' . $item['icon'] . '"></i>
    			</div>
    			<div class="feature-box-info">
    				<h4 class="shorter">' . $item['title'] . '</h4>
    				<p class="tall">' . $item['teaser'] . '</p>
    			</div>
    		</div>
        </div>';
    }
    
    function generate_box_item( $item, $atts ) {
        
        return '
        <div class="' . $atts['column_class'] . '">
			<div class="featured-box featured-box-' . $item['skin'] . '">
				<div class="box-content">
					<i class="' . $item['icon'] . '"></i>
					<h4>' . $item['title'] . '</h4>
					<p>' . $item['teaser'] . '</p>
				</div>
			</div>
		</div>';
    }

    function widget( $args, $instance ) {

        // extracting info
        extract( $args ); extract( $instance );
        
        // get view to render
        include $this->get_view( $style );
    }

}
spyropress_builder_register_module( 'Spyropress_Module_Parallax' );