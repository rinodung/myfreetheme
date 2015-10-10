<?php

/**
 * SpyroPress Custom Post Type Helper
 *
 * @author 		SpyroSol
 * @category 	Core
 * @package 	Spyropress
 */

class SpyropressCustomPostType {

    /** Variables *****************************************************/
    var $name;
    var $slug;
    var $plural;
    var $args;
    var $labels;
    var $meta_boxes;

    private static $instance;

    /**
     * Construtor
     */
    public function __construct( $name, $slug = '', $args = array(), $labels = array(), $plural = '' ) {

        $this->name = spyropress_beautify( $name );
        $this->args = $args;
        $this->labels = $labels;
        $this->meta_boxes = array();

        $slug = ( empty( $slug ) ) ? $name : $slug;
        $this->slug = spyropress_uglify( $slug );

        $this->plural = ( $plural ) ? $plural : spyropress_pluralize( $name );

        $this->init();
    }

    /**
     * Init
     */
    function init() {

        // register post type
        if ( ! post_type_exists( $this->slug ) )
            $this->register_post_type();

        // add actions and filters
        add_action( 'admin_init', array( $this, 'admin_init' ) );

        if ( ! empty( $this->post_columns ) ) {
            add_filter( 'manage_' . $this->slug . '_posts_columns', array( $this, 'post_columns_head' ), 10 );
            add_action( 'manage_' . $this->slug . '_posts_custom_column', array( $this, 'post_columns_content' ), 10, 2 );
        }

        if ( isset( $this->args['title'] ) && ! empty( $this->args['title'] ) )
            add_filter( 'enter_title_here', array( $this, 'screen_title_text' ), 1, 2 );
    }

    /**
     * admin_init handler
     */
    function admin_init() {

        if ( empty( $this->meta_boxes ) ) return;

        // Listen for post save
        add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );

        foreach ( $this->meta_boxes as $box )
            add_meta_box(
                $box['id'],
                $box['title'],
                array( $this, 'output_meta_box' ),
                $this->slug,
                $box['context'],
                $box['priority']
            );
    }

    /**
     * manage_posts_columns handler
     */
    function post_columns_head() {

    }

    /**
     * manage_posts_custom_column handler
     */
    function post_columns_content() {

    }

    /**
     * enter_title_here handler
     */
    function screen_title_text( $title, $post ) {
        $screen = get_current_screen();

        if ( $post->post_type == $this->slug )
            $title = $this->args['title'];

        return $title;
    }

    /**
     * Register Post Typr
     */
    function register_post_type() {

        $name = $this->name;
        $plural = $this->plural;

        // We set the default labels based on the post type name and plural. We overwrite them with the given labels.
        $labels = array_merge(

            // Default
            array(
                'name'                  => _x( $plural, 'post type general name' ),
                'singular_name'         => _x( $name, 'post type singular name' ),
                'add_new'               => _x( 'Add New', strtolower( $name ) ),
                'add_new_item'          => sprintf( __( 'Add New %s', 'spyropress' ), $name ),
                'edit_item'             => sprintf( __( 'Edit %s', 'spyropress' ), $name ),
                'new_item'              => sprintf( __( 'New %s', 'spyropress' ), $name ),
                'all_items'             => sprintf( __( 'All %s', 'spyropress' ), $plural ),
                'view_item'             => sprintf( __( 'View %s', 'spyropress' ), $name ),
                'search_items'          => sprintf( __( 'Search %s', 'spyropress' ), $plural ),
                'not_found'             => sprintf( __( 'No %s found', 'spyropress' ), strtolower( $plural ) ),
                'not_found_in_trash'    => sprintf( __( 'No %s found in Trash', 'spyropress' ), strtolower( $plural ) ),
                'parent_item_colon'     => '',
                'menu_name'             => $plural
            ),

            // Given labels
            $this->labels
        );

        // Same principle as the labels. We set some default and overwite them with the given arguments.
        $args = array_merge(

            // Default
            array(
                'label'             => $plural,
                'labels'            => $labels,
                'public'            => true,
                'show_ui'           => true,
                'has_archive'       => true,
                'capability_type'   => 'post',
                'supports'          => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
            ),

            // Given args
            $this->args
        );

        // Register the post type
        register_post_type( $this->slug, $args );

    }

    /**
     * Attach Taxonomy to the post type
     */
    public function add_taxonomy( $name, $slug = '', $menu_label = '', $args = array(), $labels = array() ) {

        // checks
        if ( empty( $name ) ) return;

        // We need to know the post type name, so the new taxonomy can be attached to it.
        $post_type_name = $this->slug;

        // Taxonomy properties
        $slug = ( empty( $slug ) ) ? $name : $slug;
        $taxonomy_name = spyropress_uglify( $slug );
        $taxonomy_labels = $labels;
        $taxonomy_args = $args;

        if ( ! taxonomy_exists( $taxonomy_name ) ) {

            //Capitilize the words and make it plural
            $name = spyropress_beautify( $name );
            $plural = spyropress_pluralize( $name );
            $menu_label = ( empty( $menu_label ) ) ? $name : $menu_label;

            // Default labels, overwrite them with the given labels.
            $labels = array_merge(
                // Default
                array(
                    'name'              => _x( $plural, 'taxonomy general name' ),
                    'singular_name'     => _x( $name, 'taxonomy singular name' ),
                    'search_items'      => sprintf( __( 'Search %s', 'spyropress' ), $plural ),
                    'all_items'         => sprintf( __( 'All %s', 'spyropress' ), $plural ),
                    'parent_item'       => sprintf( __( 'Parent %s', 'spyropress' ), $name ),
                    'parent_item_colon' => sprintf( __( 'Parent %s:', 'spyropress' ), $name ),
                    'edit_item'         => sprintf( __( 'Edit %s', 'spyropress' ), $name ),
                    'update_item'       => sprintf( __( 'Update %s', 'spyropress' ), $name ),
                    'add_new_item'      => sprintf( __( 'Add New %s', 'spyropress' ), $name ),
                    'new_item_name'     => sprintf( __( 'New %s Name', 'spyropress' ), $name ),
                    'menu_name'         => $menu_label
                ),

                // Given labels
                $taxonomy_labels
            );

            // Default arguments, overwitten with the given arguments
            $args = array_merge(
                // Default
                array(
                    'label'     => $plural,
                    'labels'    => $labels,
                    'public'    => true
                ),

                // Given
                $taxonomy_args
            );

            // Add the taxonomy to the post type
            register_taxonomy( $taxonomy_name, $post_type_name, $args );
        }
        else {
            register_taxonomy_for_object_type( $taxonomy_name, $post_type_name );
        }
    }

    /**
     * Add MetaBoxes to the post type
     */
    public function add_meta_box( $id, $title = '', $fields = array(), $meta_key = false,
        $build_tabs = true, $context = 'normal', $priority = 'default' ) {

        // checks
        if ( empty( $id ) ) return;

        $title = ( empty( $title ) ) ? $id : $title;

        // Meta variables
        $box_id = spyropress_uglify( $id );
        $box_title = spyropress_beautify( $title );
        $box_context = $context;
        $box_priority = $priority;

        $args = array(
            'id' => $box_id,
            'title' => $box_title,
            'context' => $context,
            'priority' => $priority,
            'meta_key' => $meta_key,
            'build_tabs' => $build_tabs,
            'post_type_slug' => $this->slug,
            'fields' => $fields
        );

        $this->meta_boxes[$id] = $args;
    }

    /**
     * Render Meta Box
     */
    function output_meta_box( $post, $args ) {

        if ( $this->slug !== get_current_post_type() ) return;

        $box_id = $args['id'];
        $box_args = $this->meta_boxes[$box_id];
        extract( $box_args );

        $new_settings = array();
        $settings = get_post_custom( $post->ID );

        if ( empty( $settings ) ) {
            $settings = array();
        }
        else {
            if ( isset( $meta_key ) && ! empty( $meta_key ) && isset( $settings[$meta_key] ) ) {
                $sets = maybe_unserialize( $settings[$meta_key][0] );
                $new_settings = ( empty( $sets ) ) ? array() : $sets;
            }
            else {
                foreach ( $settings as $k => $v )
                    $new_settings[$k] = maybe_unserialize( $v[0] );
            }
        }

        // Start the Engine
        new SpyropressMetaBoxUi( $fields, $box_id, $new_settings, $build_tabs );
    }

    /**
     * Post save handler
     */
    function save_post( $post_ID, $post ) {

        // Deny the wordpress autosave function
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        // Deny the wordpress ajax
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) return;

        // Check
        if( isset( $_POST['post_type'] ) && $this->slug != $_POST['post_type'] ) return;
        
        // verify post is not a revision
        if ( wp_is_post_revision( $post_ID ) ) return;
        
        clean_post_cache( $post_ID );

        // Check nonce
        if ( isset( $_POST['security'] ) && ! wp_verify_nonce( $_POST['security'], 'spyropress_metabox_nonce' ) ) return;

        // Looping through all the meta boxes
        foreach ( $this->meta_boxes as $box_id => $box_args ) {
            $meta_key = $box_args['meta_key'];

            // get settings
            $settings = spyropress_update_meta_box( $box_args['fields'], $post_ID, $meta_key );

            // saving new info
            if ( ! empty( $settings ) ) {
                if ( $meta_key ) {
                    update_post_meta( $post_ID, $meta_key, $settings );
                }
                else {
                    foreach ( $settings as $k => $v ) {
                        update_post_meta( $post_ID, $k, $v );
                    }
                }
            }
        }
    }
}

?>