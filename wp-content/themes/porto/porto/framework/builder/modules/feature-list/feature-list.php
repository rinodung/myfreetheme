<?php

/**
 * Module: Feature List
 *
 * @author 		SpyroSol
 * @category 	SpyropressBuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Feature_List extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings.
        $this->path = dirname( __FILE__ );

        $this->cssclass = 'feature';
        $this->description = __( 'List your features.', 'spyropress' );
        $this->id_base = 'feature';
        $this->name = __( 'Features', 'spyropress' );

        $this->templates['list'] = array(
            'label' => __( 'Features List', 'spyropress' )
        );

        $this->templates['list2'] = array(
            'label' => __( 'Features List 2', 'spyropress' )
        );

        $this->templates['boxes'] = array(
            'label' => __( 'Features Boxes', 'spyropress' ),
            'view' => 'boxes.php'
        );

        // Fields
        $this->fields = array(

            array(
                'label' => __( 'Title', 'spyropress' ),
                'id' => 'title',
                'type' => 'text',
            ),

            array(
                'label' => __( 'Animation', 'spyropress' ),
                'id' => 'animation',
                'type' => 'select',
                'options' => spyropress_get_options_animation()
            ),

            array(
                'label' => __( 'Styles', 'spyropress' ),
                'id' => 'style',
                'type' => 'select',
                'options' => $this->get_option_templates(),
                'std' => 'list'
            ),

            array(
                'label' => __( 'Columns', 'spyropress' ),
                'id' => 'columns',
                'type' => 'select',
                'options' => array(
                    1 => __( '1 Column', 'spyropress' ),
                    2 => __( '2 Column', 'spyropress' ),
                    3 => __( '3 Column', 'spyropress' ),
                    4 => __( '4 Column', 'spyropress' ),
                )
            ),

            array(
                'label' => __( 'Feature', 'spyropress' ),
                'id' => 'features',
                'type' => 'repeater',
                'item_title' => 'title',
                'fields' => array(
                    array(
                        'label' => __( 'Title', 'spyropress' ),
                        'id' => 'title',
                        'type' => 'text',
                    ),

                    array(
                        'label' => __( 'Teaser', 'spyropress' ),
                        'id' => 'teaser',
                        'type' => 'textarea',
                        'rows' => 5
                    ),

                    array(
                        'label' => __( 'Icon', 'spyropress' ),
                        'id' => 'icon',
                        'type' => 'select',
                        'options' => spyropress_get_options_fontawesome_icons(),
                        'desc' => __( 'See the <a target="_blank" href="http://fontawesome.io/icons/">icons here</a>.', 'spyropress' )
                    ),

                    array(
                        'label' => __( 'Skin', 'spyropress' ),
                        'id' => 'skin',
                        'type' => 'select',
                        'options' => array(
                            'primary' => __( 'Primary', 'spyropress' ),
                            'secundary' => __( 'Secondary', 'spyropress' ),
                            'tertiary' => __( 'Tertiary', 'spyropress' ),
                            'quartenary' => __( 'Quartenary', 'spyropress' ),
                        ),
                        'std' => 'primary'
                    ),
                )
            )
        );

        $this->create_widget();
    }

    function generate_item( $item, $atts ) {

        return '
        <div class="col-sm-6 ' . $atts['column_class'] . '">
            <div class="feature-box' . $atts['box_class'] . '">
    			<div class="feature-box-icon">
    				<i class="fa ' . icon_comp( $item['icon'] ) . '"></i>
    			</div>
    			<div class="feature-box-info">
    				<h4 class="shorter">' . $item['title'] . '</h4>
    				<p class="tall">' . do_shortcode( $item['teaser'] ) . '</p>
    			</div>
    		</div>
        </div>';
    }

    function generate_box_item( $item, $atts ) {

        return '
        <div class="col-sm-6 ' . $atts['column_class'] . '">
			<div class="featured-box featured-box-' . $item['skin'] . '">
				<div class="box-content">
					<i class="icon-featured fa ' . icon_comp( $item['icon'] ) . '"></i>
					<h4>' . $item['title'] . '</h4>
					<p>' . do_shortcode( $item['teaser'] ) . '</p>
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
spyropress_builder_register_module( 'Spyropress_Module_Feature_List' );