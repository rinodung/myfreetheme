<?php

/**
 * SpyroPress Cleaner
 * Clean the wordpress with useless things inspired by Roots
 *
 * @author 		SpyroSol
 * @category 	Class
 * @package 	Spyropress
 */

class SpyropressCleanup {

    /**
     * Class constructor
     */
    public function __construct() {

        if ( ! is_admin() || defined( 'DOING_AJAX' ) ) {

            // Remove class and ID''s from Custom Menus
            add_filter( 'nav_menu_css_class', array( $this, 'menu_class_filter' ), 10, 2 );
            add_filter( 'page_css_class', array( $this, 'menu_class_filter' ), 10, 2 );
            add_filter( 'nav_menu_item_id', '__return_false', 100, 1 );

            // Disable self trackbacks -- http://wp-snippets.com/disable-self-trackbacks
            add_action( 'pre_ping', array( $this, 'disable_self_ping' ) );

            if (
                ! class_exists( 'All_in_One_SEO_Pack' ) ||
                ! class_exists( 'Headspace_Plugin' ) ||
                ! class_exists( 'WPSEO_Admin' ) ||
                ! class_exists( 'WPSEO_Frontend' )
            ) {
                remove_action( 'wp_head', 'rel_canonical' );
                add_action( 'wp_head', array( $this, 'spyropress_rel_canonical' ) );
            }

            // Remove the WordPress version from RSS feeds
            add_filter( 'the_generator', '__return_false' );
        }

        $this->clean_urls();
    }

    function spyropress_rel_canonical() {
        global $wp_the_query;

        // checks
        if ( ! is_singular() ) return;
        // OR
        if ( ! $id = $wp_the_query->get_queried_object_id() ) return;

        $link = get_permalink( $id );
        echo "<link rel='canonical' href='$link' />\n";
    }
    
    /** URLS Cleanup  **/
    function enable_relative_urls() {
        return !( is_admin() || in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) && current_theme_supports( 'relative-urls' );
    }

    function clean_urls() {

        if ( $this->enable_relative_urls() ) {

            $relative_url_filters = array(
                'bloginfo_url',
                'the_permalink',
                'wp_list_pages',
                'wp_list_categories',
                'wp_nav_menu_item',
                'the_content_more_link',
                'the_tags',
                'get_pagenum_link',
                'get_comment_link',
                'month_link',
                'day_link',
                'year_link',
                'tag_link',
                'the_author_posts_link',
                'script_loader_src',
                'style_loader_src'
            );
            
            foreach ( $relative_url_filters as $filter ) {
                add_filter( $filter, array( $this, 'root_relative_url' ) );
            }
        }
    }
    
    function root_relative_url( $input ) {
        preg_match('|https?://([^/]+)(/.*)|i', $input, $matches);
        
        if ( isset( $matches[1] ) && isset( $matches[2] ) && $matches[1] === $_SERVER['SERVER_NAME'] ) {
            return wp_make_link_relative($input);
        }
        
        return $input;
    }

    /** Clean extra menu classes **/
    function menu_class_filter( $classes, $item ) {
        //return is_array( $classes ) ? preg_grep( '/^menu-ite.+/', $classes, PREG_GREP_INVERT ) : '';
        $classes = preg_replace('/(current(-menu-|[-_]page[-_])(item))/', '', $classes);
        $classes = preg_replace('/^((menu|page)[-_\w+]+)+/', '', $classes);
        
        $classes = array_unique( $classes );
        return array_filter( $classes, 'is_element_empty' );
    }

    function disable_self_ping( &$links ) {
        foreach ( $links as $l => $link ) {
            if ( 0 === strpos( $link, home_url() ) ) {
                unset( $links[$l] );
            }
        }
    }
}
?>