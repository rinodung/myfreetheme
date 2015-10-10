<?php

/**
 * Module: Portfolio Carousel
 * Display a list of portfolio in carousel
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

global $timeline_date;
class Spyropress_Module_Recent_Portfolio_Carousel extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings.
        $this->path = dirname( __FILE__ );

        $this->description = __( 'Display a list of portfolio.', 'spyropress' );
        $this->id_base = 'recent_portfolio';
        $this->name = __( 'Portfolio', 'spyropress' );

        // Templates
        $this->templates['carousel'] = array(
            'label' => __( 'Carousel', 'spyropress' ),
            'view' => 'carousel.php'
        );

        $this->templates['fullwidth'] = array(
            'label' => __( 'Full Width', 'spyropress' ),
            'view' => 'fullwidth.php'
        );

        $this->templates['lightbox'] = array(
            'label' => __( 'Lightbox', 'spyropress' ),
            'view' => 'lightbox.php'
        );

        $this->templates['listing'] = array(
            'label' => __( 'Listing', 'spyropress' )
        );

        $this->templates['timeline'] = array(
            'label' => __( 'Timeline', 'spyropress' ),
            'view' => 'timeline.php'
        );

        // Fields
        $this->fields = array(

            array(
                'label' => __( 'Templates', 'spyropress' ),
                'id' => 'template',
                'type' => 'select',
                'options' => $this->get_option_templates(),
                'std' => 'listing',
                'class' => 'enable_changer section-full'
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
                'std' => 6
            ),

            array(
                'id' => 'pagination',
                'type' => 'checkbox',
                'options' => array(
                    1 => __( 'Show pagination', 'spyropress' )
                )
            ),

            array(
                'label' => __( 'Number of Columns', 'spyropress' ),
                'id' => 'columns',
                'class' => 'template lightbox listing section-full',
                'type' => 'range_slider',
                'std' => 2,
                'max' => 4
            ),

            array(
                'label' => __( 'Portfolio Category', 'spyropress' ),
                'id' => 'cat',
                'type' => 'multi_select',
                'options' => spyropress_get_taxonomies( 'portfolio_category' )
            ),

            array(
                'id' => 'filters',
                'type' => 'checkbox',
                'class' => 'template lightbox fullwidth listing section-full',
                'options' => array(
                    1 => __( 'Show portfolio filters', 'spyropress' )
                )
            ),

            array(
                'label' => __( 'All Label', 'spyropress' ),
                'id' => 'show_all',
                'type' => 'text',
                'std' => 'Show All'
            ),
        );

        $this->create_widget();
    }

    function widget( $args, $instance ) {

        // extracting info
        extract( $args );

        $template = isset( $instance['template'] ) ? $instance['template'] : '';
        $title = isset( $instance['title'] ) && !empty( $instance['title'] ) ? $instance['title'] : '';
        $show_all = isset( $instance['show_all'] ) && !empty( $instance['show_all'] ) ? $instance['show_all'] : __( 'Show All', 'spyropress' );

        // get view to render
        include $this->get_view( $template );
    }

    function query( $atts, $content = null ) {

        $default = array (
            'post_type' => 'portfolio',
            'limit' => -1,
            'columns' => false,
            'pagination' => false,
            'callback' => array( $this, 'generate_item' ),
            'column_class' => 'isotope-item'
        );
        $atts = wp_parse_args( $atts, $default );

        if ( ! empty( $atts['cat'] ) ) {

            $atts['tax_query']['relation'] = 'OR';
            if ( ! empty( $atts['cat'] ) ) {
                $atts['tax_query'][] = array(
                    'taxonomy' => 'portfolio_category',
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

        // images
        $image = array();
        if( 2 == $atts['columns'] )
            $image = array(
                'post_id' => $post_ID,
                'echo' => false,
                'width' => 560,
                'responsive' => false,
                'class' => 'img-responsive'
            );
        else
            $image = array(
                'post_id' => $post_ID,
                'echo' => false,
                'width' => 450,
                'responsive' => true,
                'class' => 'img-responsive'
            );
        $image_tag = get_image( $image );

        $image['width'] = get_option( 'large_size_w' );
        $image['type'] = 'src';
        $full_image = get_image( $image );

        // cats
        $cat = $cat_name = array();
        $terms = get_the_terms( $post_ID, 'portfolio_category' );
        if( !empty( $terms ) && !is_wp_error( $terms ) ) {
            foreach( $terms as $item ) {
                $cat[] = $item->slug;
                $cat_name[] = $item->name;
            }
        }

        $href = ( 'lightbox' == $atts['template'] ) ? $full_image : get_permalink();
        $thumb_info = ( 'fullwidth' == $atts['template'] ) ? 'thumb-info secundary' : 'thumb-info';
        
        $class = $atts['column_class'] . ' ' . join( ' ', $cat );
        
        if( 'fullwidth' != $atts['template'] ) {
            $class = 'col-sm-6 col-xs-12 ' . $class;
        }

        // item tempalte
        $item_tmpl = '
        <li class="' . $class . '">
			<div class="portfolio-item img-thumbnail">
				<a href="' . $href . '" class="' . $thumb_info . '">
					' . $image_tag . '
					<span class="thumb-info-title">
						<span class="thumb-info-inner">' . get_the_title() . '</span>
						<span class="thumb-info-type">' . join( ', ', $cat_name ) . '</span>
					</span>
					<span class="thumb-info-action">
						<span title="' . __( 'Universal', 'spyropress' ) . '" class="thumb-info-action-icon"><i class="fa fa-link"></i></span>
					</span>
				</a>
			</div>
		</li>';

        return $item_tmpl;
    }

    function generate_item_timeline( $post_ID, $atts, $counter ) {

        // images
        $image = array(
            'post_id' => $post_ID,
            'echo' => false,
            'width' => 450,
            'responsive' => true,
            'class' => 'img-responsive'
        );
        $image_tag = get_image( $image );

        // cats
        $cat_name = array();
        $terms = get_the_terms( $post_ID, 'portfolio_category' );
        if( !empty( $terms ) && !is_wp_error( $terms ) ) {
            foreach( $terms as $item ) {
                $cat_name[] = $item->name;
            }
        }

        // item tempalte
        $post_alt = ( $counter % 2 ) ? 'left' : 'right';

        $date_header = $date = '';
        $date = the_date( '', '', '', false );
        if( $date ) $date_header = '<div class="timeline-date"><h3>' . $date . '</h3></div>';

        $item_tmpl = $date_header . '
        <article class="timeline-box ' . $post_alt . '">
			<div class="portfolio-item img-thumbnail">
				<a href="' . get_permalink() . '" class="thumb-info">
					' . $image_tag . '
					<span class="thumb-info-title">
						<span class="thumb-info-inner">' . get_the_title() . '</span>
						<span class="thumb-info-type">' . join( ', ', $cat_name ) . '</span>
					</span>
					<span class="thumb-info-action">
						<span title="' . __( 'Universal', 'spyropress' ) . '" class="thumb-info-action-icon"><i class="fa fa-link"></i></span>
					</span>
				</a>
			</div>
		</article>';

        return $item_tmpl;
    }

    function generate_item_carousel( $post_ID, $atts ) {

        // images
        $image = array(
            'post_id' => $post_ID,
            'echo' => false,
            'width' => 450,
            'responsive' => true,
            'class' => 'img-responsive'
        );
        $image_tag = get_image( $image );

        $image['width'] = get_option( 'large_size_w' );
        $image['class'] = 'img-thumbnail img-responsive';
        $full_image = get_image( $image );

        // translate
        $translate['description-title'] = get_setting( 'translate' ) ? get_setting( 'portfolio_desc_title', 'Project <strong>Description</strong>' ) : __( 'Project <strong>Description</strong>', 'spyropress' );
        $translate['preview-title'] = get_setting( 'translate' ) ? get_setting( 'portfolio_preview_title', 'Live Preview' ) : __( 'Live Preview', 'spyropress' );
        $translate['service-title'] = get_setting( 'translate' ) ? get_setting( 'portfolio_service_title', 'Services' ) : __( 'Services', 'spyropress' );

        // live url
        $live_url = get_post_meta( $post_ID, 'project_url', true );
        $live_url = ( $live_url ) ? '<a href="' . $live_url . '" class="btn btn-primary" target="_blank">' . $translate['preview-title'] . '</a> <span class="arrow hlb"></span>' : '';

        // cats
        $cat_name = array();
        $terms = get_the_terms( $post_ID, 'portfolio_category' );
        if( !empty( $terms ) && !is_wp_error( $terms ) ) {
            foreach( $terms as $item ) {
                $cat_name[] = $item->name;
            }
        }

        $services = '';
        $terms = get_the_terms( $post_ID, 'portfolio_service' );
        if( !empty( $terms ) && !is_wp_error( $terms ) ) {
            foreach( $terms as $term ) {
                $services .= '<li><i class="fa fa-check"></i> ' . $term->name . '</li>';
            }
        }

        // item tempalte
        $item_tmpl = '
		<div>
			<div class="portfolio-item img-thumbnail">
				<a class="thumb-info lightbox" href="#popupProject' . $post_ID . '" data-plugin-options=\'{"type":"inline", preloader: false}\'>
					' . $image_tag . '
					<span class="thumb-info-title">
						<span class="thumb-info-inner">' . get_the_title() . '</span>
						<span class="thumb-info-type">' . join( ', ', $cat_name ) . '</span>
					</span>
					<span class="thumb-info-action">
						<span title="' . __( 'Universal', 'spyropress' ) . '" class="thumb-info-action-icon"><i class="fa fa-link"></i></span>
					</span>
				</a>
			</div>
            <div id="popupProject' . $post_ID . '" class="popup-inline-content">
				<h2>' . get_the_title() . '</h2>
				<div class="row">
					<div class="col-md-6">
						' . $full_image . '
					</div>

					<div class="col-md-6">
						<h4>' . $translate['description-title'] . '</h4>
						' . get_the_content() . '
                        ' . $live_url . '
						<h4 class="push-top">' . $translate['service-title'] . '</h4>
						<ul class="list icons list-unstyled">
							' . $services . '
						</ul>

					</div>
				</div>
			</div>
        </div>';

        return $item_tmpl;
    }
}

spyropress_builder_register_module( 'Spyropress_Module_Recent_Portfolio_Carousel' );