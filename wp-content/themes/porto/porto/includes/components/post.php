<?php

/**
 * Post Component
 * 
 * @package		SpyroPress
 * @category	Components
 */

class SpyropressPost extends SpyropressComponent {

    private $path;
    
    function __construct() {

        $this->path = dirname(__FILE__);
        add_action( 'spyropress_register_taxonomy', array( $this, 'register' ) );
    }

    function register() {

        // Init Post Type
        $post = new SpyropressCustomPostType( 'Post' );
        
        // Add Meta Boxes
        $meta_fields['options'] = array(
            array(
                'label' => __( 'Post Option', 'spyropress' ),
                'type' => 'heading',
                'slug' => 'post'
            ),
            
            array(
                'desc' => __( 'Select post format to have some options.<br><br>', 'spyropress' ),
                'id' => '_format_none',
                'type' => 'raw_info'
            ),
            
            array(
                'label' => __( 'Gallery', 'spyropress' ),
                'desc' => __( 'Click to upload images', 'spyropress' ),
                'class' => 'section-full post_format gallery',
                'id' => '_format_gallery_embed',
                'type' => 'gallery'
            ),
            
            array(
                'label' => __( 'Video', 'spyropress' ),
                'desc' => __( 'Enter the video link you want to embed', 'spyropress' ),
                'class' => 'section-full post_format video',
                'id' => '_format_video_embed',
                'type' => 'text'
            ),
            
            array(
                'label' => __( 'Audio', 'spyropress' ),
                'desc' => __( 'Enter the audio link you want to embed', 'spyropress' ),
                'class' => 'section-full post_format audio',
                'id' => '_format_audio_embed',
                'type' => 'text'
            ),
            
            array(
                'label' => __( 'Quote Source Name', 'spyropress' ),
                'desc' => __( 'Enter the quote source name here', 'spyropress' ),
                'class' => 'section-full post_format quote',
                'id' => '_format_quote_source_name',
                'type' => 'text'
            )
        );
        
        $post->add_meta_box( 'post_options', __( 'Post Options', 'spyropress' ), $meta_fields, false, false, 'normal', 'high' );
    }
}

/**
 * Init the Component
 */
new SpyropressPost();
?>