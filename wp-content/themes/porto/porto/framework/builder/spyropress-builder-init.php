<?php

/**
 * SpyroPress Builder
 *
 * Main builder file which loads all panels and sets up builder.
 *
 * @author 		SpyroSol
 * @category 	Builder
 * @package 	Spyropress
 * @version     1.0.0
 */

if ( ! class_exists( 'SpyropressBuilder' ) ) {

    class SpyropressBuilder {

        /** Variblaes **********************************************/
        var $enabled_post_types = array( 'page', 'bucket', 'template' );
        var $version = '1.0.1';

        /** Private Variblaes **********************************************/
        private $builder_meta_key = '_spyropress_builder_data';
        private $post_type;

        /** Instances **********************************************/
        var $row_factory;
        var $col_factory;
        var $module_factory;
        var $columns;

        function __construct() {

            // Include required files
            $this->includes();
            
            // Register Taxonomy
            if( current_theme_supports( 'spyropress-template-builder' ) ) {
                add_action( 'spyropress_register_taxonomy', array( $this, 'register_taxonomy' ), 11 );
                
                // Add Layout Meta Box
                add_action( 'init', array( $this, 'template_meta_box' ) );
            }
            
            // Load Factories
            add_action( 'after_setup_theme', array( $this, 'init_factory' ), 3 );
            
            // Load Templates
            add_action( 'init', array( $this, 'init' ), 2 );

            if( is_admin() ) {
                // Enqueue Scripts
                add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

                // Add builder class to current enabled screen
                add_action( 'admin_body_class', array( $this, 'admin_body_class') );
    
                // Some More
                add_action( 'do_meta_boxes', array( $this, 'remove_meta_boxes' ) );
                add_action( 'deleted_post', array( $this, 'delete_post_meta' ) );
            }
        }

        function includes() {

            $includes = array(

                /** Core Function **/
                'spyropress-builder-template-loader.php',
                'spyropress-builder-template.php',
                'spyropress-row-functions.php',
                'spyropress-column-functions.php',
                'spyropress-module-functions.php',
                'spyropress-builder-ajax-functions.php',

                /** Classes **/
                'classes/class-row.php',
                'classes/class-column.php',
                'classes/class-module.php',
            );

            foreach ( $includes as $include )
                include_once $include;
        }

        /**
         * Register Post Type
         */
        function register_taxonomy() {

            $args = array(
                'public' => false,
                'show_in_admin_bar' => true,
                'supports' => array( 'title', 'thumbnail' ),
                'has_archive' => false,
                'query_var' => false );

            $labels = array( 'menu_name' => __( 'Templates', 'spyropress' ) );
            $this->post_type = new SpyropressCustomPostType( 'Template', '', $args, $labels );
        }

        /**
         * Init Factory
         */
        function init_factory() {

            $this->rows = new SpyropressBuilderRows();
            $this->columns = new SpyropressBuilderColumns();
            $this->modules = new SpyropressBuilderModules();
        }

        /**
         * Init Engine
         */
        function init() {

            // Load Templates
            include_once ( 'rc-templates/' . get_html_framework() . '-row-templates.php' );
            include_once ( 'rc-templates/' . get_html_framework() . '-col-templates.php' );

            // Load Modules
            $includes = array(

                // Row Options
                'modules/row-options/row-options.php',
                'modules/rich-text/rich-text.php'
            );

            // allow developers to add in more modules
            $includes = array_merge( $includes, apply_filters( 'builder_include_modules', array() ) );
            foreach ( $includes as $include )
                include_once $include;

            // Load Builder UI on enabled post types to render builder on
            $this->enabled_post_types = apply_filters( 'builder_enabled_post_types', $this->enabled_post_types );

            // init Builder
            add_action( 'dbx_post_sidebar', array( $this, 'rednder_builder_ui' ) );
        }

        /**
         * Enqueue Scripts and Styles
         */
        function enqueue_scripts() {

            /**
             * Styles
             */
            wp_register_style( 'spyropress-builder', framework_assets_css() . 'spyropress-builder.css', '', get_core_version() );

            /**
             * Scripts
             */
            wp_register_script( 'builder-helper', framework_assets_js() . 'builder-helper.js', false, '1.1', true );
            wp_register_script( 'builder', framework_assets_js() . 'builder.js', array( 'jquery-ui-position', 'jquery-ui-sortable', 'editor', 'builder-helper' ), '1.1', true );
            wp_enqueue_script( 'builder' );
        }

        function rednder_builder_ui() {

            if ( ! empty( $this->enabled_post_types ) &&
                 ! in_array( get_current_post_type(), $this->enabled_post_types )
            )
                return;

            // else include
            include ( 'spyropress-builder-ui.php' );
        }

        /**
         * Template Setting Meta Box
         */
        function template_meta_box() {

            $blocks = $this->get_partial_templates();
            $tree = $this->get_template_tree();

            // meta fields
            $canvas['type'] = array(
                array(
                    'label' => __( 'Canvas', 'spyropress' ),
                    'type' => 'heading',
                    'icon' => 'general',
                    'slug' => 'type'
                ),

                array(
                    'label' => __( 'Type', 'spyropress' ),
                    'id' => 'canvas_type',
                    'in_list' => true,
                    'type' => 'select',
                    'class' => 'section-full',
                    'options' => array(
                        'full' => 'Full',
                        'partial' => 'Partial'
                    )
                ),

                array(
                    'label' => __( 'Assigned To', 'spyropress' ),
                    'id' => 'assigned_to',
                    'in_list' => true,
                    'type' => 'select',
                    'class' => 'section-full',
                    'options' => $tree
                )
            );

            $canvas['blocks'] = array(
                array(
                    'label' => __( 'Blocks', 'spyropress' ),
                    'type' => 'heading',
                    'icon' => 'general',
                    'slug' => 'blocks'
                ),

                array(
                    'label' => __( 'Header', 'spyropress' ),
                    'id' => 'canvas_header',
                    'type' => 'select',
                    'class' => 'section-full',
                    'options' => $blocks
                ),

                array(
                    'label' => __( 'Footer', 'spyropress' ),
                    'id' => 'canvas_footer',
                    'type' => 'select',
                    'class' => 'section-full',
                    'options' => $blocks
                )
            );

            $this->post_type->add_meta_box( 'template_setting', __( 'Template Setting', 'spyropress' ), $canvas, false, true, 'side', 'high' );
        }

        /**
         * Delete Meta
         *
         * Delete template from posts using it as layout template
         */
        function delete_post_meta( $post_id ) {
            global $wpdb;
            $wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key = '_builder_template' AND meta_value = {$post_id} " );
        }

        /**
         * Remove Featured Image Metabox
         */
        function remove_meta_boxes() {
            remove_meta_box( 'postimagediv', 'template', 'side' );
        }

        /**
         * Add Class to Admin Body tag.
         */
        function admin_body_class() {
            if ( $post_type = get_current_post_type() ) {
                if ( in_array( $post_type, $this->enabled_post_types ) )
                    return 'builder_enabled ';
            }
            return '';
        }

        /** Helper Functions ********************************************************/

        /**
         * Get Wordpress Tree
         */
        function get_template_tree() {

            // Template Hierarchy
            $template_tree = $post_type_tree = $single_tree = $tax_tree = array();

            // Special Pages
            $special_tree = array(
                '404.php' => __( 'Error 404', 'spyropress' ),
                'home.php' => __( 'Home Page', 'spyropress' ),
                'front-page.php' => __( 'Front Page', 'spyropress' ),
                'page.php' => __( 'Generic Page', 'spyropress' ),
                'single.php' => __( 'Generic Single Post', 'spyropress' ),
                'search.php' => __( 'Search Result', 'spyropress' ),
                'archive.php' => __( 'Generic Archive', 'spyropress' ),
                'category.php' => __( 'Generic Category', 'spyropress' ),
                'tag.php' => __( 'Generic Tag', 'spyropress' ),
                'author.php' => __( 'Author', 'spyropress' ),
            );

            $template_tree[] = array(
                'name' => __( 'Special Pages', 'spyropress' ),
                'options' => $special_tree
            );

            // Post Types
            $post_types = get_post_types( array( 'public' => true, '_builtin' => false ), 'objects' );
            foreach ( $post_types as $key => $post_type ) {
                $post_type_tree[$key] = $post_type->labels->name;
                $single_tree[$key] = $post_type->labels->name;
            }
            $template_tree[] = array(
                'name' => __( 'Post Types', 'spyropress' ),
                'options' => $post_type_tree
            );

            // Date Archive
            $date = array(
                'year' => 'Yearly',
                'month' => 'Monthly',
                'day' => 'Daily'
            );
            $template_tree[] = array(
                'name' => __( 'Date Archive', 'spyropress' ),
                'options' => $date
            );

            // Taxonomies
            $taxonomies = get_taxonomies( array( '_builtin' => false ), 'objects' );
            foreach ( $taxonomies as $key => $taxonomy ) {
                if ( $taxonomy->public == 1 ) {
                    $tax_tree[$key] = $taxonomy->labels->name;
                }
            }
            $template_tree[] = array(
                'name' => __( 'Taxonomies', 'spyropress' ),
                'options' => $tax_tree
            );
            $template_tree[] = array(
                'name' => __( 'Singular', 'spyropress' ),
                'options' => $single_tree
            );

            return $template_tree;
        }

        /**
         * Get Partial Layout
         */
        function get_partial_templates() {

            // Blocks
            $blocks = array();
            $blocks['-1'] = __( 'Blank', 'spyropress' );
            $blocks['-2'] = __( 'Theme Default', 'spyropress' );

            // Partial Layouts
            $args = array(
                'post_type' => 'template',
                'posts_per_page' => -1,
                'meta_query' => array(
                    array(
                        'key' => 'canvas_type',
                        'value' => 'partial'
                    )
                )
            );
            $buckets = get_posts( $args );
            $bucket_tree = array();
            if ( ! empty( $buckets ) ) {
                foreach ( $buckets as $bucket )
                    $bucket_tree[$bucket->ID] = $bucket->post_title;
            }

            $blocks[] = array(
                'name' => __( 'Partial Layouts', 'spyropress' ),
                'options' => $bucket_tree
            );

            return $blocks;
        }

        function layout_metabox() {

            global $spyropress;

            // Custom Template
            $args = array(
                'post_type' => 'template',
                'posts_per_page' => -1,
                'meta_query' => array( array( 'key' => 'canvas_type', 'value' => 'full' ) ) );

            $layouts = get_posts( $args );
            if ( ! empty( $layouts ) ) {
                foreach ( $layouts as $layout )
                    $layout_tree[$layout->ID] = $layout->post_title;
            }

            $layout_meta['spyropress_layout'] = array( array(
                    'name' => __( 'Layouts', 'spyropress' ),
                    'type' => 'heading',
                    'icon' => 'general',
                    'slug' => 'spyropress_layout' ), array(
                    'name' => __( 'Select a Layout', 'spyropress' ),
                    'id' => '_builder_template',
                    'type' => 'select',
                    'options' => $layout_tree ) );

            $posts = array_merge( $this->enabled_post_types, array_keys( $spyropress->
                custom_post_types ) );
            foreach ( $posts as $post_type ) {
                if ( $post_type != 'template' ) {
                    if ( ! key_exists( $post_type, $spyropress->custom_post_types ) ) {
                        $page_builder = new SpyropressCustomPostType( $post_type, $post_type );
                        $spyropress->custom_post_types[$post_type] = $page_builder;
                    }
                    else
                        $page_builder = $spyropress->custom_post_types[$post_type];
                    $page_builder->add_meta_box( __( 'SpyroPress: Layout Selection', 'spyropress' ),
                        '', $layout_meta, array(
                        'build_tabs' => false,
                        'context' => 'side',
                        'priority' => 'high' ) );
                }
            }
        }

        function get_data( $post_id ) {
            return get_post_meta( $post_id, $this->builder_meta_key, true );
        }

        function save_data( $post_id, $builder_data ) {
            return update_post_meta( $post_id, $this->builder_meta_key, $builder_data );
        }

        function delete_data( $post_id ) {
            return delete_post_meta( $post_id, $this->builder_meta_key );
        }
    }

    /**
     * Init SpyropressBuilder class
     */

    $GLOBALS['spyropress_builder'] = new SpyropressBuilder();
}

?>