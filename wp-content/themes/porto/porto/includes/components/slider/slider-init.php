<?php

/**
 * Slider Component
 *
 * @package		SpyroPress
 * @category	Components
 */

class SpyropressSlider extends SpyropressComponent {

    private $path;
    private $sliders;

    function __construct() {

        $this->path = dirname(__FILE__);
        
        // Get Sliders
        $sliders = get_theme_support( 'spyropress-sliders' );
        if ( isset( $sliders[0] ) )
            $this->sliders = $sliders[0];

        // Init
        $this->init_slider();

        add_action( 'spyropress_register_taxonomy', array( $this, 'register' ) );
        
        if( is_admin() ) {
            add_action( 'do_meta_boxes', array( $this, 'remove_meta_boxes' ) );
        }
        else {
            add_action( 'spyropress_head', array( $this, 'resgiter_scripts' ) );
            add_shortcode( 'slider',  array( $this, 'shortcode_handler' ) );
        }
    }

    /**
     * Register Post Type and Add Meta Boxes
     */
    function register() {

        // Init Post Type
        $args = array(
            'public' => false,
            'show_in_admin_bar' => true,
            'supports' => array( 'title', 'thumbnail' ),
            'has_archive' => false,
            'query_var' => false
        );
        $post_type = new SpyropressCustomPostType( __( 'Slider', 'spyropress' ), '', $args );

        // Slider Selection
        $instructions = '<p>' . __( 'You can place this slider anywhere into your posts, pages, custom post types or widgets by using the shortcode below:', 'spyropress' ) . '</p>';
        $instructions .= '<p><code>[slider id="{post_id}"]</code></p>';

        $slider_meta_fields['slider_type'] = array(
            array(
                'label' => __( 'Start Here', 'spyropress' ),
                'type' => 'heading',
                'slug' => 'slider_type'
            ),

            array(
                'label' => __( 'Select slider type', 'spyropress' ),
                'id' => 'slider_type',
                'type' => 'select',
                'class' => 'section-full',
                'options' => $this->sliders,
                'desc' => __( 'Select a slider type and hit [Publish] to start building your slider.', 'spyropress' )
            ),

            array(
                'id' => 'instruction_info',
                'type' => 'raw_info',
                'function' => array( $this, 'set_post_id' ),
                'desc' => $instructions,
            )
        );

        $post_type->add_meta_box( 'slider_type', __( 'Start Here', 'spyropress' ), $slider_meta_fields, '', false, 'side' );

        $post_ID = $slider_type = '';
        // getting post_id
        if( isset( $_GET['post'] ) )
            $post_ID = $_GET['post'];
        elseif( isset( $_POST['post_ID'] ) )
            $post_ID = $_POST['post_ID'];

        // get slider type
        if( !empty( $post_ID ) )
            $slider_type = get_post_meta( $post_ID, 'slider_type', true );

        // check for no slider type
        if( empty( $slider_type ) ) return;

        // slides
        $post_type->add_meta_box( 'slider_slides', __( 'Slides', 'spyropress' ), $this->get_slides_settings( $slider_type ), 'slider_slides', false );

        // setting
        $slider_settings = $this->get_slider_settings( $slider_type );
        if( !empty( $slider_settings[$slider_type] ) )
            $post_type->add_meta_box( 'slider_settings', __( 'Settings', 'spyropress' ), $slider_settings, 'slider_settings', false );
    }

    /**
     * Add Registered Sliders
     */
    function init_slider() {

        foreach( $this->sliders as $type => $slider )    {

            // file name
            $file = $this->path . '/' . $type . '/' . $type . '-init.php';

            // check
            if ( is_readable( $file ) )
                include $file;
        }
    }
    
    /**
     * Enqueue Assets
     */
    function resgiter_scripts() {
        
        foreach( $this->sliders as $type => $slider )    {
            
            $func = 'enqueue_' . $type . 'slider_assets';
            
            if ( function_exists( $func ) ) $func();
        }
    }

    /**
     * Get Slide Meta Box Options
     */
    function get_slides_settings( $type ) {

        // check
        if( empty( $type ) ) return array();

        // function
        $func = 'get_' . $type . 'slides_setting';

        // check
        if( !function_exists( $func ) ) return array();

        // get setting
        $settings[$type . '_slides'] = $func();

        // return setting
        return $settings;
    }

    /**
     * Get Slider Settings Meta Box Options
     */
    function get_slider_settings( $type ) {

        // check
        if( empty( $type ) ) return array();

        // function
        $func = 'get_' . $type . 'slider_setting';

        // check
        if( !function_exists( $func ) ) return array();

        // get setting
        $settings[$type] = $func();

        // return setting
        return $settings;
    }

    /**
     * Callback for post_ID for instruction box
     */
    function set_post_id( $output ) {
        global $post;
        return str_replace( '{post_id}', $post->ID, $output );
    }

    /**
     * Remove Featured Image Metabox
     */
    function remove_meta_boxes() {
        remove_meta_box( 'postimagediv', 'slider', 'side' );
    }

    /**
     * Register Slider Widget
     */
    function register_widget( $widgets ) {

        $widgets[] = $this->path . '/widget';

        return $widgets;
    }
    
    /**
     * Shortcode handler
     */
    function shortcode_handler( $atts, $content = '' ) {
        
        // check
        if( ! isset( $atts['id'] ) || empty( $atts['id'] ) ) return;
        
        $slider_id = $atts['id'];
        
        // get slider meta
        $meta = get_post_custom( $slider_id );
        
        // get slider type
        $slider_type = maybe_unserialize( $meta['slider_type'][0] );
        if( empty( $slider_type ) ) return;
        
        // get slides
        $slides = maybe_unserialize( $meta['slider_slides'][0] );
        if( empty( $slides ) ) return;
        
        // get slider settings
        $settings = maybe_unserialize( $meta['slider_settings'][0] );
        
        $func = $slider_type . 'slider_shortcode_handler';
        
        return $func( $slider_id, $slides['slides'], $settings );
    }
}

/**
 * Init the Component
 */
new SpyropressSlider();

/**
 * Data Source - Sliders
 */
function spyropress_get_sliders() {
    
    $sliders = array();
    
    if ( ! post_type_exists( 'slider' ) ) return $sliders;
    
    // get posts
    $args = array(
        'post_type' => 'slider',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'asc'
    );
    $posts = get_posts( $args );
    if ( !empty( $posts ) ) {
        foreach ( $posts as $post ) {
            $sliders[$post->ID] = $post->post_title;
        }
    }

    return $sliders;
}

?>