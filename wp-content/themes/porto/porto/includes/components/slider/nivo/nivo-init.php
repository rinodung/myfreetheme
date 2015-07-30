<?php

/**
 * Flex Slider
 * Related functions
 */

/**
 * Slides Options
 */
function get_nivoslides_setting() {
    $slides = array(
        array(
            'label'  => __( 'Slides', 'spyropress' ),
            'type' => 'heading',
            'icon' => 'general',
            'slug' => 'instruction'
        ),

        array(
    		'label' => __( 'Slide', 'spyropress' ),
    		'type' => 'repeater',
            'id' => 'slides',
            'fields' => array(
                
                array(
                    'label' => __( 'Image', 'spyropress' ),
                    'id' => 'image',
                    'type' => 'upload',
                )
            )
        )
    );

    return $slides;
}

/**
 * Slider Setting Options
 */
function get_nivoslider_setting() {
    
}

/**
 * Enqueue Style and Script
 */
function enqueue_nivoslider_assets() {
    //wp_enqueue_style( 'flex', template_url() . 'assets/slider/flexslider/flexslider.css', '', '2.0' );
    //wp_enqueue_script( 'flex', template_url() . 'assets/slider/flexslider/jquery.flexslider-min.js', '', '2.0', true );
}

/**
 * Generate Markup
 */
function nivoslider_shortcode_handler( $slider_id, $slides, $settings = '' ) {

    // generate id
    $slider_id = 'nivoslider_' . $slider_id;
    
    add_jquery_ready( '$("#' . $slider_id . '").nivoSlider();' );
    
    $out = '<div class="nivo-slider"><div class="slider-wrapper theme-default"><div id="' . $slider_id . '" class="nivoSlider">';

    foreach ( $slides as $slide ) {

        // set content
        $out .= '<img src="' . $slide['image'] . '" data-thumb="' . $slide['image'] . '" alt="" />';
    }

    $out .= '</div></div></div>';

    return $out;
}
?>