<?php

/**
 * Module: Testimonials
 * Display a list of testimonials
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Widget_Recent_Testimonials extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings.
        $this->path = dirname( __FILE__ );

        $this->description = __( 'Display a list of testimonials.', 'spyropress' );
        $this->id_base = 'recent_testimonials';
        $this->name = __( 'Testimonials', 'spyropress' );

        // Templates
        $this->templates['columns'] = array(
            'label' => __( 'Columns', 'spyropress' ),
            'view' => 'columns.php'
        );

        // Fields
        $this->fields = array(

            array(
                'label' => __( 'Styles', 'spyropress' ),
                'id' => 'template',
                'type' => 'select',
                'class' => 'enable_changer section-full',
                'options' => $this->get_option_templates()
            ),

            array(
                'label' => __( 'Title', 'spyropress' ),
                'id' => 'title',
                'type' => 'text',
                'std' => $this->name
            ),

            array(
                'label' => __( 'Number of items', 'spyropress' ),
                'id' => 'limit',
                'type' => 'range_slider',
                'std' => 4
            ),

            array(
                'label' => __( 'Number of columns', 'spyropress' ),
                'id' => 'columns',
                'type' => 'range_slider',
                'class' => 'template columns section-full',
                'std' => 3,
                'max' => 6
            ),

            array(
                'label' => __( 'Category', 'spyropress' ),
                'id' => 'cat',
                'type' => 'multi_select',
                'options' => spyropress_get_taxonomies( 'testimonial_category' )
            ),
            
            array(
                'label' => __( 'Auto Play', 'spyropress' ),
                'id' => 'auto_play',
                'type' => 'checkbox',
                'options' => array(
                    1 => __( 'Enabe Crousel Auto play effect.', 'spyropress' )
                )
            )
        );

        $this->create_widget();
    }

    function widget( $args, $instance ) {

        // extracting info
        extract( $args );

        // get view to render
        include $this->get_view( $instance['template'] );
    }

    function query( $atts, $content = null ) {

        $default = array (
            'post_type' => 'testimonial',
            'limit' => -1,
            'row' => false,
            'columns' => false,
            'pagination' => false,
            'callback' => array( $this, 'generate_item' )
        );
        $atts = wp_parse_args( $atts, $default );

        if ( ! empty( $atts['cat'] ) ) {

            $atts['tax_query']['relation'] = 'OR';
            if ( ! empty( $atts['cat'] ) ) {
                $atts['tax_query'][] = array(
                    'taxonomy' => 'testimonial_category',
                    'field' => 'slug',
                    'terms' => $atts['cat'],
                    );
                unset( $atts['cat'] );
            }
        }

        if ( $content )
            return token_repalce( $content, spyropress_query_generator( $atts ) );

        return spyropress_query_generator( $atts );
    }

    // Item HTML Generator
    function generate_item( $post_ID, $atts ) {

        // these arguments will be available from inside $content
        $image = array(
            'post_id' => $post_ID,
            'echo' => false
        );
        $image_tag = get_image( $image );

        $data = get_post_meta( $post_ID, '_testimonial', true );

        // item tempalte
        $item_tmpl = '
        <div>
			<div class="col-md-12">
				<blockquote class="testimonial">
				    ' . do_shortcode( $data['testimonial'] ) . '
				</blockquote>
                <div class="testimonial-arrow-down"></div>
                <div class="testimonial-author">
                    <div class="img-thumbnail img-thumbnail-small">
                        ' . $image_tag . '
                    </div>
                    <p class="white"><strong>' . get_the_title() . '</strong><br><span>' . $data['designation'] . ' - ' . $data['website'] . '</span></p>
			     </div>
			</div>
		</div>';

        return $item_tmpl;
    }

    function generate_column_item( $post_ID, $atts ) {

        // these arguments will be available from inside $content
        $image = array(
            'post_id' => $post_ID,
            'echo' => false,
            'responsive' => true
        );
        $image_tag = get_image( $image );

        $data = get_post_meta( $post_ID, '_testimonial', true );

        // item tempalte
        $item_tmpl = '
        <div class="' . $atts['column_class'] . '">
            <blockquote class="testimonial">
                ' . $data['testimonial'] . '
    		</blockquote>
    		<div class="testimonial-arrow-down"></div>
    		<div class="testimonial-author">
    			<div class="img-thumbnail img-thumbnail-small">
    				' . $image_tag . '
    			</div>
    			<p><strong>' . get_the_title() . '</strong><span>' . $data['designation'] . ' - ' . $data['website'] . '</span></p>
    		</div>
        </div>';

        return $item_tmpl;
    }
}

spyropress_builder_register_module( 'Spyropress_Widget_Recent_Testimonials' );