<?php

/**
 * FAQs
 * Display FAQs. 
 *     
 * @package		SpyroPress
 * @category	Widgets
 * @author		SpyroSol
 */
class SpyroPress_Module_Faqs extends SpyropressBuilderModule {

    function __construct() {
        
        // Widget variable settings
        $this->id_base = 'spyropress_faqs';
        $this->cssclass = 'toogle';
        $this->name = __( 'FAQs', 'spyropress' );
        $this->description = __( 'A module to display faqs.', 'spyropress' );
        
        $this->fields = array(
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
                'label' => __( 'Category', 'spyropress' ),
                'id' => 'cat',
                'type' => 'multi_select',
                'options' => spyropress_get_taxonomies( 'faq_category' )
            ),
        );
        
        $this->create_widget();
    }
    
    function widget( $args, $instance ) {
        
        // extracting info
        extract( $args );

        // get view to render
        include $this->get_view();
    }
    
    function query( $atts, $content = null ) {

        $default = array (
            'post_type' => 'faq',
            'limit' => -1,
            'columns' => false,
            'row' => false,
            'pagination' => false,
            'callback' => array( $this, 'generate_item' )
        );
        $atts = wp_parse_args( $atts, $default );
    
        if ( ! empty( $atts['cat'] ) ) {
    
            $atts['tax_query']['relation'] = 'OR';
            if ( ! empty( $atts['cat'] ) ) {
                $atts['tax_query'][] = array(
                    'taxonomy' => 'faq_category',
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
                
        return '
        <section class="toggle">
            <label>' . get_the_title() . '</label>
            ' . apply_filters( 'the_content', get_the_content() ) . '
        </section>';
    }
}

spyropress_builder_register_module( 'SpyroPress_Module_Faqs' );
?>