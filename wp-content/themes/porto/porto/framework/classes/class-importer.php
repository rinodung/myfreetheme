<?php

/**
 * SpyroPress Importer
 *
 * @author 		SpyroSol
 * @category 	Core
 * @package 	Spyropress
 */

if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) define( 'WP_LOAD_IMPORTERS', true );

// Load Importer API
require_once ABSPATH . 'wp-admin/includes/import.php';

$importerError = false;

if ( ! class_exists( 'WP_Importer' ) ) {
    $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
    if ( file_exists( $class_wp_importer ) )
        require_once $class_wp_importer;
}
else {
    $importerError = true;
}

if ( ! class_exists( 'WP_Import' ) ) {
    $class_wp_import = framework_path() . 'classes/wordpress-importer/wordpress-importer.php';
    if ( file_exists( $class_wp_import ) ) {
        require_once $class_wp_import;
    }
    else {
        $importerError = true;
    }
}

class SpyropressImporter extends WP_Import {

    protected $key;
    protected $import_filepath;

    function __construct( $key ) {

        $this->key = $key;
        $this->import_filepath = include_path() . 'sample/';
        $this->import_file();
    }

    function import_file() {

        global $importerError;

        if ( ! $importerError ) {

            $this->fetch_attachments = true;
            ob_start();
            $this->import( $this->import_filepath . 'dummy.xml' );
            ob_end_clean();
            $this->backfill_builder_data();
            $this->save_options( $this->import_filepath . 'dummy.php' );
            $this->import_widget_data( $this->import_filepath . 'widget_data.json' );
            $this->set_menus();
            $this->set_skin_option();
        }
    }

    function import_widget_data( $file ) {
        
        if( !$file || !file_exists( $file ) ) return;
        
        // Add data to widgets
        $widgets_json = get_template_directory_uri() . '/includes/sample/widget_data.json'; // widgets data file
        $widgets_json = wp_remote_get( $widgets_json );
        $json_data = json_decode( $widgets_json['body'], true );

        $sidebar_data = $json_data[0];
        $widget_data = $json_data[1];

        foreach ( $widget_data as $widget_data_title => $widget_data_value ) {
            $widgets[ $widget_data_title ] = '';
            foreach( $widget_data_value as $widget_data_key => $widget_data_array ) {
                if( is_int( $widget_data_key ) ) {
                    $widgets[$widget_data_title][$widget_data_key] = 'on';
                }
            }
        }
        unset($widgets[""]);

        foreach ( $sidebar_data as $title => $sidebar ) {
            $count = count( $sidebar );
            for ( $i = 0; $i < $count; $i++ ) {
                $widget = array( );
                $widget['type'] = trim( substr( $sidebar[$i], 0, strrpos( $sidebar[$i], '-' ) ) );
                $widget['type-index'] = trim( substr( $sidebar[$i], strrpos( $sidebar[$i], '-' ) + 1 ) );
                if ( !isset( $widgets[$widget['type']][$widget['type-index']] ) ) {
                    unset( $sidebar_data[$title][$i] );
                }
            }
            $sidebar_data[$title] = array_values( $sidebar_data[$title] );
        }

        foreach ( $widgets as $widget_title => $widget_value ) {
            foreach ( $widget_value as $widget_key => $widget_value ) {
                $widgets[$widget_title][$widget_key] = $widget_data[$widget_title][$widget_key];
            }
        }

        $sidebar_data = array( array_filter( $sidebar_data ), $widgets );

        $this->parse_import_data( $sidebar_data );
    }

    function parse_import_data( $import_array ) {
        global $wp_registered_sidebars;
        $sidebars_data = $import_array[0];
        $widget_data = $import_array[1];
        $current_sidebars = get_option( 'sidebars_widgets' );
        $new_widgets = array( );

        foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

            foreach ( $import_widgets as $import_widget ) :
                //if the sidebar exists
                if ( isset( $wp_registered_sidebars[$import_sidebar] ) ) :
                    $title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
                    $index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
                    $current_widget_data = get_option( 'widget_' . $title );
                    $new_widget_name = $this->get_new_widget_name( $title, $index );
                    $new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

                    if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
                        while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
                            $new_index++;
                        }
                    }
                    $current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
                    if ( array_key_exists( $title, $new_widgets ) ) {
                        $new_widgets[$title][$new_index] = $widget_data[$title][$index];
                        $multiwidget = $new_widgets[$title]['_multiwidget'];
                        unset( $new_widgets[$title]['_multiwidget'] );
                        $new_widgets[$title]['_multiwidget'] = $multiwidget;
                    } else {
                        $current_widget_data[$new_index] = $widget_data[$title][$index];
                        $current_multiwidget = $current_widget_data['_multiwidget'];
                        $new_multiwidget = isset($widget_data[$title]['_multiwidget']) ? $widget_data[$title]['_multiwidget'] : false;
                        $multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
                        unset( $current_widget_data['_multiwidget'] );
                        $current_widget_data['_multiwidget'] = $multiwidget;
                        $new_widgets[$title] = $current_widget_data;
                    }

                endif;
            endforeach;
        endforeach;

        if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
            update_option( 'sidebars_widgets', $current_sidebars );

            foreach ( $new_widgets as $title => $content )
                update_option( 'widget_' . $title, $content );

            return true;
        }

        return false;
    }

    function get_new_widget_name( $widget_name, $widget_index ) {
        $current_sidebars = get_option( 'sidebars_widgets' );
        $all_widget_array = array( );
        foreach ( $current_sidebars as $sidebar => $widgets ) {
            if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
                foreach ( $widgets as $widget ) {
                    $all_widget_array[] = $widget;
                }
            }
        }
        while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
            $widget_index++;
        }
        $new_widget_name = $widget_name . '-' . $widget_index;
        return $new_widget_name;
    }

    function backfill_builder_data() {

        //$this->url_remap as $from_url => $to_url
        foreach( $this->processed_posts as $post_id ) {
            $data = get_post_meta( $post_id, '_spyropress_builder_data', true );
            if( !empty( $data ) ) {
                $this->backfill_builder_urls( $data );
                update_post_meta( $post_id, '_spyropress_builder_data', $data );
            }
        }
    }

    function backfill_builder_urls( &$data ) {

        foreach( $data as $k => $v ) {
            if ( is_array( $data[$k] ) ) {
                $this->backfill_builder_urls( $data[$k] );
            }
            else {
                $reg_exUrl = "!http://([a-z0-9\-\.\/\_]+\.(?:jpe?g|png|gif|ico))!Ui";
                $url = array();

                if( preg_match_all( $reg_exUrl, $v, $url ) ) {
                    foreach( $url[0] as $from ) {
                        $data[$k] = str_replace( $from, $this->url_remap[$from], $v );
                    }
                }
            }
        }
    }

    function save_options( $option_file ) {

        if( !$option_file || !file_exists( $option_file ) ) return;
        
        @include_once( $option_file );

        // Doing import
        $data = spyropress_decode( $dummy_data );
        $this->backfill_builder_urls( $data );

        update_option( $this->key, $data );
    }

    function set_menus() {

        // Get theme-supported menus.
        $spyropress_menus = get_theme_support( 'spyropress-core-menus' );

        // If there is no menus, return.
        if ( ! is_array( $spyropress_menus[0] ) ) return;

        //get all registered menu locations
    	$locations = get_theme_mod( 'nav_menu_locations' );

    	//get all created menus
    	$menus = wp_get_nav_menus();

        if( !empty( $menus ) && !empty( $spyropress_menus ) ) {

            foreach( $spyropress_menus[0] as $location => $search ) {

                foreach( $menus as $menu ) {

                    if( is_object( $menu ) && is_str_contain( $search, $menu->name ) ) {

                        $locations[$location] = $menu->term_id;
                        break;
        			}
        		}
            }
    	}
    	//update the theme
    	set_theme_mod( 'nav_menu_locations', $locations);
	}
    
    function set_skin_option() {
        $colors = array(
            'red' => array( 'name' => 'Red', 'color' => 'f43232' ),
            'blue' => array( 'name' => 'Blue', 'color' => '4eb3f4' ),
            'yellow' => array( 'name' => 'Yellow', 'color' => 'fcca03' ),
            'green' => array( 'name' => 'Green', 'color' => '16a61e' )
        );
        
        update_option( '_spyropress_porto_skins', $colors );
    }
}