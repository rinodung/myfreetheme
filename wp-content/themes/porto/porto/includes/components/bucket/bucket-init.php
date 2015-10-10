<?php

/**
 * Bucket Component
 *
 * @package		SpyroPress
 * @category	Components
 */

class SpyropressBucket extends SpyropressComponent {

    private $path;

    function __construct() {

        $this->path = dirname(__FILE__);
        add_action( 'spyropress_register_taxonomy', array( $this, 'register' ) );
        add_filter( 'builder_include_modules', array( $this, 'register_module' ) );
        add_shortcode( 'bucket', array( $this, 'shortcode_handler' ) );


        if( class_exists( 'SpyropressBuilderModule' ) )
            add_filter( 'spyropress_register_widgets', array( $this, 'register_module' ) );
    }

    function register() {

        // Init Post Type
        $args = array(
            'supports' => array( 'title', 'editor' ),
            'menu_icon' => 'dashicons-admin-site'
        );
        $post_type = new SpyropressCustomPostType( __( 'Bucket', 'spyropress' ), '', $args );

        global $pagenow;

        // Shortcode Meta Box
        $instructions = '<p>' . __( 'Display bucket anywhere into your posts, pages, custom post types or widgets by using the shortcode below:', 'spyropress' ) . '</p>';
        $instructions .= '<p><code>[bucket id={post_id}]</code></p>';

        $sc_fields['shortcode'] = array(
            array(
                'label' => __( 'Shortcode', 'spyropress' ),
                'type' => 'heading',
                'slug' => 'shortcode'
            ),

            array(
                'id' => 'instruction_info',
                'type' => 'raw_info',
                'function' => array( $this, 'set_post_id' ),
                'desc' => $instructions,
            )
        );

        $post_type->add_meta_box( 'shortcode', __( 'Shortcode', 'spyropress' ), $sc_fields, false, false, 'side' );
    }

     /**
     * Callback for post_ID for instruction box
     */
    function set_post_id( $output ) {
        global $post;
        return str_replace( '{post_id}', $post->ID, $output );
    }

    function register_module( $modules ) {

        $modules[] = $this->path . '/module/bucket.php';

        return $modules;
    }

    function shortcode_handler( $atts, $content = '' ) {

        if ( isset( $atts['id'] ) && $atts['id'] )
            return spyropress_get_the_bucket( $atts['id'] );
    }
}

/**
 * Init the Component
 */
new SpyropressBucket();

/** Template Tags ************************/

/**
 * the_builder_content
 */
function spyropress_the_bucket( $id ) {
    echo spyropress_get_the_bucket( $id );
}
function spyropress_get_the_bucket( $id ) {

    if ( class_exists( 'SpyropressBuilder' ) && spyropress_has_builder_content( $id ) ) {

        return spyropress_get_the_builder_content( $id );
    }
    else {
        $bucket = get_post( $id );
        $content = apply_filters( 'the_content', $bucket->post_content );
        $content = str_replace( ']]>', ']]&gt;', $content );
        return $content;
    }
}