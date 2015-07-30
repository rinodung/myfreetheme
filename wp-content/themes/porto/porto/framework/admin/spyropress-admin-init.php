<?php

/**
 * SpyroPress Admin
 * Main admin file which loads all settings panels and sets up admin menus.
 *
 * @author 		SpyroSol
 * @category 	Admin
 * @package 	Spyropress
 */

class SpyropressAdmin {

    /** Variblaes ***************************************************************/
    var $admin_menu_parent;
    var $admin_menus;
    var $messages = array(
        'success' => array(),
        'notice' => array(),
        'error' => array()
    );

    function __construct() {

        // Actions
        add_action( 'init', array( $this, 'includes' ), 1 );
        add_action( 'init', array( $this, 'init' ), 2 );
        add_action( 'init', array( $this, 'install' ), 2 );

        add_action( 'admin_menu', array( $this, 'add_admin_menu' ), 9 );
        add_action( 'admin_notices', array( $this, 'ouput_messages' ), 5 );

        // enqueue style and script in admin
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_print_styles', array( $this, 'enqueue_styles' ) );

        // remove advance_text_widget css
        remove_action( 'admin_print_styles', 'atw_print_styles', 10 );
    }

    /**
     * Include required files
     **/
    function includes() {

        $includes = array(
            /** Admin functions **/
            'spyropress-admin-hooks.php',
            'spyropress-admin-functions.php',
            framework_classes() . 'class-tgm-plugin-activation.php',

            /** Admin UI functions **/
            // grid
            'ui/grid.php',

            // headings
            'ui/sub-heading.php',
            'ui/toggle.php',

            // html types
            'ui/text-field.php',
            'ui/text-area.php',
            'ui/checkbox.php',
            'ui/radio.php',
            'ui/select.php',
            'ui/hidden.php',

            // custom types
            'ui/text-editor.php',
            'ui/colorpicker.php',
            'ui/datepicker.php',
            'ui/upload.php',
            'ui/typography.php',
            'ui/repeater.php',
            'ui/range-slider.php',
            'ui/background.php',
            'ui/info.php',
            'ui/border.php',
            'ui/padder.php',
            'ui/import-export.php',

            // wordpress types
            'ui/taxonomy.php',
            'ui/custom-post.php',
            'ui/skin-generator.php'
        );

        foreach ( $includes as $i )
            require_once ( $i );
        
        /** Theme and Framework Settings **/
        locate_template( 'includes/spyropress-settings-theme.php', true );

        /* Allow developers to include files before admin initialize */
        do_action( 'spyropress_admin_includes' );
    }

    /**
     * Init Admin
     */
    function init() {
        
        // Prepare Menus
        $this->construct_admin_menu();

        /** Components ********************************************************/

        if ( current_theme_supports( 'spyropress-builder' ) )
            new SpyropressThemeVerifier(); // Verify Theme Purchase
        new SpyropressThemeUpdater(); // Theme Updater

        do_action( 'spyropress_admin_init' );
    }

    /**
     * Check if theme if activated first time
     */
    function install() {

        global $pagenow;

        $is_theme_activated = ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) );
        $installed = get_option( 'spyropress_installed_' . get_internal_name(), false );

        if ( $is_theme_activated && ! $installed )
            include_once ( 'spyropress-theme-activation.php' );
        elseif ( $is_theme_activated && $installed )
            wp_redirect( admin_url( 'admin.php?installed=true&page=spyropress' ) );
    }

    /**
     * Register/Enqueue Admin Scripts
     */
    function enqueue_scripts() {

        global $current_screen;
        
        // Register scripts using wp_register_script( $handle, $src, $deps, $ver, $in_footer );
        wp_register_script( 'webfont-loader', 'http://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js', false, '1.0', false );
        wp_register_script( 'spyropress-admin', framework_assets_js() . 'spyropress-admin.js', false, '1.0', true );

        $panel_deps = array(
            'jquery',
            'jquery-ui-button',
            'jquery-ui-datepicker',
            'jquery-ui-slider',
            'jquery-ui-sortable',
            'thickbox',
            'media-upload',
            'spyropress-admin',
        );
        wp_register_script( 'spyropress-panel', framework_assets_js() . 'spyropress-panel.js', $panel_deps, '2.0.1' );

        // Register Params
        $spyropress_params = array(
            'media_url' => framework_assets_img(),
            'shortcode_url' => framework_url() . 'shortcodes/',
        );

        wp_localize_script( 'jquery', 'spyropress_admin_settings', $spyropress_params );

        // Fallback Strategy
        if( function_exists( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }
        else {
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
            wp_enqueue_style('thickbox');
        }
        wp_enqueue_script( 'webfont-loader' );
        wp_enqueue_script( 'spyropress-panel' );
        
        if( current_theme_supports( 'spyropress-shortcode-generator' ) ) {
            wp_enqueue_script( 'jquery-livequery', framework_assets_js() . 'jquery.livequery.js', false, false, true );
            wp_enqueue_script( 'jquery-appendo', framework_assets_js() . 'jquery.appendo.js', false, false, true );
            wp_enqueue_script( 'base64', framework_assets_js() . 'base64.js', false, false, true );
            wp_enqueue_script( 'shortcode-popup', framework_assets_js() . 'popup.js', false, false, true );
        }
        
        if( 'spyropress_page_spyropress-theme' == $current_screen->base && current_theme_supports( 'spyropress-ace' ) ) {
            wp_enqueue_script( 'ace_js', framework_assets_js() . 'ace/ace.js', false, false, true );
            wp_enqueue_script( 'ace_mode_js', framework_assets_js() . 'ace/mode-css.js', false, false, true );
            wp_enqueue_script( 'ace_custom_js', framework_assets_js() . 'ace/css-editor.js', false, false, true );
        }
    }

    /**
     * Register/Enqueue Admin Styles
     */
    function enqueue_styles() {
        
        //Register Styles wp_register_style( $handle, $src, $deps, $ver, $media )
        wp_register_style( 'jquery-aristo', framework_assets_css() . 'aristo/aristo.css', false, get_core_version() );
        wp_register_style( 'jquery-plugins', framework_assets_css() . 'spyropress.plugins.css', false, get_core_version() );
        wp_register_style( 'spyropress-admin', framework_assets_css() . 'spyropress-admin.css', false, get_core_version() );
        wp_register_style( 'spyropress-admin-grid', framework_assets_css() . 'grid-' . get_grid_columns() . 'col.css', false, get_core_version() );

        wp_enqueue_style( 'jquery-aristo' );
        wp_enqueue_style( 'jquery-plugins' );
        wp_enqueue_style( 'spyropress-admin-grid' );
        wp_enqueue_style( 'spyropress-admin' );
        wp_enqueue_style( 'spyropress-builder' );
        
        if( current_theme_supports( 'spyropress-shortcode-generator' ) ) {
            wp_enqueue_style( 'shortcode-popup', framework_assets_css() . 'popup.css', false, '1.0', 'all' );
        }
    }

    /**
     * Spyropress Menu/Pages Function
     * Create spyropress menu array for the admin pages.
     */
    function construct_admin_menu() {

        global $spyropress;
        
        // Dashboard
        $this->admin_menu_parent = array(
            'page_title' => __( 'Welcome to SpyroPress', 'spyropress' ),
            'menu_title' => __( 'Spyropress', 'spyropress' ),
            'slug' => 'spyropress',
            'position' => '55'
        );

        $this->admin_menus['spyropress'] = array(
            'page_title' => __( 'Welcome to SpyroPress', 'spyropress' ),
            'menu_title' => __( 'Dashboard', 'spyropress' ),
            'page_file' => 'page-dashboard.php',
            'isactive' => true,
            'hidden' => false
        );

        // Get theme-supported options
        $registered_options = get_theme_support( 'spyropress-options' );

        if ( ! empty( $registered_options ) ) {
            foreach ( $registered_options[0] as $option => $option_meta ) {
                $key = 'spyropress-' . $option;
                $this->admin_menus[$key] = array_merge( $option_meta, array( 'page_file' => 'page-option-machine.php', ) );
            }
        }

        if ( $spyropress->is_builder_verified ) {

            $count = ( is_theme_updateable() ) ? '<span class="update-plugins count-1"><span class="update-count">1</span></span>' : '';

            $this->admin_menus['spyropress-update'] = array(
                'page_title' => __( 'Theme Updates', 'spyropress' ),
                'menu_title' => __( 'Theme Updates', 'spyropress' ) . $count,
                'page_file' => 'page-theme-update.php',
                'isactive' => true,
                'hidden' => false
            );
        }
    }

    /**
     * Add admin pages link to menu
     */
    function add_admin_menu() {
        
        $parent_slug = $this->admin_menu_parent['slug'];

        // add parent menus
        $main_page = add_menu_page( $this->admin_menu_parent['page_title'], $this->admin_menu_parent['menu_title'], 'manage_options', $this->admin_menu_parent['slug'], array( $this, 'load_custom_pages' ), '', $this->admin_menu_parent['position'] );

        // add child menus
        foreach ( $this->admin_menus as $slug => $menu ) {
            $item = ( object )$menu;
            if ( $item->isactive )
                add_submenu_page( ( ! $item->hidden ) ? $parent_slug : null, $item->page_title, $item->menu_title, 'manage_options', $slug, array( $this, 'load_custom_pages' ) );
        }

        do_action( 'spyropress_admin_css' );
    }

    /**
     * Admin Pages Callback Function
     */
    function load_custom_pages() {
        $page = $this->admin_menus[$_GET['page']]['page_file'];
        include_once $page;
    }

    /** Message Helpers ***********************************************/

    function add_success( $msg ) {
        $this->messages['success'][] = $msg;
    }

    function add_error( $msg ) {
        $this->messages['error'][] = $msg;
    }

    function add_notice( $msg ) {
        $this->messages['notice'][] = $msg;
    }

    function ouput_messages() {

        // success messages
        if ( ! empty( $this->messages['success'] ) ) {
            echo '<div class="wrap"><ul class="spyropress-messages spyropress-success">';

            foreach ( $this->messages['success'] as $msg )
                echo '<li>' . $msg . '</li>';

            echo '</ul></div>';
        }

        // notices
        if ( ! empty( $this->messages['notice'] ) ) {
            echo '<div class="wrap"><ul class="spyropress-messages spyropress-notices">';

            foreach ( $this->messages['notice'] as $msg )
                echo '<li>' . $msg . '</li>';

            echo '</ul></div>';
        }

        // errors
        if ( ! empty( $this->messages['error'] ) ) {
            echo '<div class="wrap"><ul class="spyropress-messages spyropress-errors">';

            foreach ( $this->messages['error'] as $msg )
                echo '<li>' . $msg . '</li>';

            echo '</ul></div>';
        }
    }
}
?>