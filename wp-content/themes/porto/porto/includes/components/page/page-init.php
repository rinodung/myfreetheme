<?php

/**
 * Page Component
 * 
 * @package		SpyroPress
 * @category	Components
 */

class SpyropressPage extends SpyropressComponent {

    private $path;
    
    function __construct() {

        $this->path = dirname(__FILE__);
        add_action( 'spyropress_register_taxonomy', array( $this, 'register' ) );
    }

    function register() {

        // Init Post Type
        $post = new SpyropressCustomPostType( 'Page' );
        
        $menus = wp_get_nav_menus();
        $menu_options = array();

        if ( isset( $menus ) && count( $menus ) > 0 ) {
            foreach ( $menus as $menu ) {
                $menu_options[$menu->term_id] = $menu->name;
            }
        }
        
        // Add Meta Boxes
        $meta_fields['options'] = array(
            
            array(
                'label' => __( 'Slider', 'spyropress' ),
                'type' => 'heading',
                'slug' => 'options'
            ),
            
            array(
                'label' => __( 'OnePage Navigation Menu', 'spyropress' ),
                'id' => 'onepage_menu',
                'type' => 'select',
                'class' => 'page_template one-page-php',
                'options' => $menu_options
            ),
            
            array(
                'label' => __( 'Slider', 'spyropress' ),
                'type' => 'sub_heading',
            ),
            
            array(
                'label' => __( 'Slider Type', 'spyropress' ),
                'id' => 'slider',
                'type' => 'select',
                'class' => 'enable_changer',
                'options' => array(
                    'nivo' => __( 'Nivo Slider', 'spyropress' ),
                    'rev' => __( 'Revolution Slider', 'spyropress' )
                )
            ),
            
            array(
                'label' => __( 'Nivo Slider', 'spyropress' ),
                'id' => 'nivo_slider',
                'type' => 'select',
                'class' => 'slider nivo',
                'options' => spyropress_get_sliders()
            ),
        );
        
        if( class_exists( 'RevSlider' ) ) {
            $slider = new RevSlider();
            $arrSliders = $slider->getArrSlidersShort();
        
            $meta_fields['options'][] = array(
                'label' => __( 'Revolution Slider', 'spyropress' ),
                'id' => 'rev_slider',
                'type' => 'select',
                'class' => 'slider rev',
                'options' => $arrSliders
            );
            
            $meta_fields['options'][] = array(
                'label' => __( 'Revolution Slider Skin', 'spyropress' ),
                'id' => 'rev_slider_skin',
                'type' => 'select',
                'class' => 'slider rev',
                'options' => array(
                    'dark' => __( 'Dark', 'spyropress' ),
                    'light' => __( 'Light', 'spyropress' ),
                    'full' => __( 'FullScreen', 'spyropress' ),
                    'dark dark-video' => __( 'Video - Dark', 'spyropress' ),
                    'light dark-light' => __( 'Video - Light', 'spyropress' )
                ),
                'std' => 'dark'
            );
        }
        
        $meta_fields['options'][] = array(
            'label' => __( 'Header', 'spyropress' ),
            'type' => 'sub_heading',
        );
        
        $meta_fields['options'][] = array(
            'label' => __( 'Header Type', 'spyropress' ),
            'id' => 'top_header',
            'type' => 'select',
            'class' => 'enable_changer',
            'options' => array(
                'none' => __( 'None', 'spyropress' ),
                'default' => __( 'Default', 'spyropress' ),
                'custom' => __( 'Custom Header', 'spyropress' )
            ),
            'std' => 'default'
        );
        
        $meta_fields['options'][] = array(
            'label' => __( 'Custom Header Bucket', 'spyropress' ),
            'id' => 'bucket',
            'type' => 'select',
            'class' => 'top_header custom',
            'desc' => __( 'Either use Bucket or Content', 'spyropress' ),
            'options' => spyropress_get_buckets()
        );
        
        $meta_fields['options'][] = array(
            'label' => __( 'Custom Header Content', 'spyropress' ),
            'id' => 'header_content',
            'type' => 'editor',
            'desc' => __( 'Either use Bucket or Content', 'spyropress' ),
            'class' => 'top_header custom'
        );
        
        $meta_fields['options'][] = array(
            'label' => __( 'Custom Header Background', 'spyropress' ),
            'id' => 'background',
            'type' => 'background',
            'class' => 'top_header custom'
        );
        
        $meta_fields['options'][] = array(
            'label' => __( 'Top Border color', 'spyropress' ),
            'id' => 'border_top',
            'type' => 'colorpicker',
            'class' => 'top_header custom'
        );
        
        $meta_fields['options'][] = array(
            'label' => __( 'Bottom Border color', 'spyropress' ),
            'id' => 'border_bottom',
            'type' => 'colorpicker',
            'class' => 'top_header custom'
        );
        
        $meta_fields['options'][] = array(
            'label' => __( 'Layout', 'spyropress' ),
            'type' => 'sub_heading',
        );
        
        $meta_fields['options'][] = array(
            'label' => __( 'Layout Type', 'spyropress' ),
            'id' => 'layout_type',
            'type' => 'select',
            'options' => array(
                'full' => __( 'Full Width', 'spyropress' ),
                'left' => __( 'Left Sidebar', 'spyropress' ),
                'right' => __( 'Right Sidebar', 'spyropress' )
            ),
            'std' => 'full'
        );
        
        $post->add_meta_box( 'page_options', __( 'Page Options', 'spyropress' ), $meta_fields, '_page_options', false, 'normal', 'high' );
    }
}

/**
 * Init the Component
 */
new SpyropressPage();
?>