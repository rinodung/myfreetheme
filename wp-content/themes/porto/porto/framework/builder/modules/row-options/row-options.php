<?php

/**
 * Module: Sub-Pages
 * A list of sub-page titles or excerpts.
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Row_Options extends SpyropressBuilderModule {

    public function __construct() {

        $this->cssclass = 'row-options';
        $this->description = __( 'Set row options and styling here.', 'spyropress' );
        $this->id_base = 'spyropress_row_options';
        $this->name = __( 'Row Options', 'spyropress' );
        $this->show_custom_css = true;

        $locations = get_registered_nav_menus();
        $menus = wp_get_nav_menus();
        $menu_options = array();

        if ( isset( $locations ) && count( $locations ) > 0 && isset( $menus ) && count( $menus ) > 0 ) {
            foreach ( $menus as $menu ) {
                $menu_options[$menu->term_id] = $menu->name;
            }
        }

        // Fields
        $this->fields = array(

            array(
                'id' => 'show',
                'type' => 'checkbox',
                'options' => array(
                    '1' => '<strong>' . __( 'Disable this row temporarily', 'spyropress' ) . '</strong>'
                )
            ),

            array(
                'id' => 'container_skin',
                'type' => 'select',
                'class' => 'enable_changer section-full',
                'label' => __( 'Style/Skin', 'spyropress' ),
                'options' => array(
                    'home-intro' => __( 'Call of Action', 'spyropress' ),
                    'featured_section call-to-action footer' => __( 'Call-to-Action (Featured)', 'spyropress' ),
                    'home-intro light' => __( 'Call of Action (Light)', 'spyropress' ),
                    'home-concept' => __( 'Home Concept', 'spyropress' ),
                    'featured_section' => __( 'Featured Section', 'spyropress' ),
                    'highlight_section' => __( 'Hightlight', 'spyropress' ),
                    'highlight_section top' => __( 'Hightlight (no top-margin)', 'spyropress' ),
                    'featured_section highlight_section footer' => __( 'Featured Hightlight Section', 'spyropress' ),
                    'push-top' => __( 'Push Top', 'spyropress' ),
                    'parallax' => __( 'Parallax', 'spyropress' ),
                    'video_section' => __( 'Video', 'spyropress' ),
                )
            ),
            
            array(
                'label' => __( 'Parallax Background', 'spyropress' ),
                'id' => 'parallax_bg',
                'class' => 'parallax container_skin section-full',
                'type' => 'upload'
            ),
            
            array(
                'label' => __( 'Video Poster', 'spyropress' ),
                'id' => 'video_poster',
                'class' => 'video_section container_skin section-full',
                'type' => 'upload'
            ),
            
            array(
                'label' => __( 'Video MP4', 'spyropress' ),
                'id' => 'video_mp4',
                'class' => 'video_section container_skin section-full',
                'type' => 'upload'
            ),
            
            array(
                'label' => __( 'Video OGG', 'spyropress' ),
                'id' => 'video_ogg',
                'class' => 'video_section container_skin section-full',
                'type' => 'upload'
            )
        );

        if( !empty( $menu_options ) ) {

            $this->fields[] = array(
                'label' => __( 'OnePage Menu Builder', 'spyropress' ),
                'type' => 'sub_heading'
            );

            $this->fields[] = array(
                'label' => __( 'Select Menu', 'spyropress' ),
                'id' => 'menu_id',
                'type' => 'select',
                'options' => $menu_options
            );

            $this->fields[] = array(
                'label' => __( 'Menu Label', 'spyropress' ),
                'id' => 'menu_label',
                'type' => 'text'
            );
        }

        $this->create_widget();

        add_filter( 'builder_save_row_css', array( $this, 'compile_css' ), 10, 3 );
    }

    function after_validate_fields( $instance = '' ) {

        if(
            isset( $instance['menu_id'] ) && isset( $instance['menu_label'] ) &&
            !empty( $instance['menu_id'] ) && !empty( $instance['menu_label'] )
        ) {

            $key = sanitize_key( $instance['menu_label'] );
            if( isset( $instance['custom_container_id'] ) && !empty( $instance['custom_container_id'] ) )
                 $key = $instance['custom_container_id'];
            else
                $instance['custom_container_id'] = $key;
            $menu_link = '#HOME_URL#' . $key;
            
            $is_link = false;
            $menu_item_id = $menu_item_position = 0;

            $menu_items = wp_get_nav_menu_items( $instance['menu_id'] );
            foreach ( $menu_items as $menu_item ) {
                if ( $menu_item->url == $menu_link ) {
                    $menu_item_id = $menu_item->ID;
                    $menu_item_position = $menu_item->menu_order;
                    break;
                }
            }
            
            wp_update_nav_menu_item( $instance['menu_id'], $menu_item_id, array(
                'menu-item-title' => $instance['menu_label'],
                'menu-item-classes' => 'internal',
                'menu-item-url' => $menu_link,
                'menu-item-position' => $menu_item_position,
                'menu-item-status' => 'publish'
            ) );
            
            update_option( 'menu_check', true );
        }
        return $instance;
    }

    function compile_css( $row_id, $instance, $old_instance ) {

        $row_id = isset( $instance['custom_container_id'] ) ? $instance['custom_container_id'] : $row_id;
        $row_class = isset( $instance['custom_container_class'] ) ? $instance['custom_container_class'] : '';
        $insertion = '';

        // row custom css
        if ( isset( $instance['row_custom_css'] ) && $instance['row_custom_css'] ) {
            $custom_css = $instance['row_custom_css'];

            /**
             * @deprecated {this_row}
             * @version 3.10
             */
            $custom_css = str_replace( '{this_row}', '#' . $row_id, $custom_css );

            /**
             * @since 3.10
             */
            $custom_css = str_replace( '{row_id}', '#' . $row_id, $custom_css );
            $custom_css = str_replace( '{row_class}', '.' . spyropress_uglify_cssclass( $row_class ), $custom_css );

            $insertion .= $custom_css;
        }

        return $insertion;
    }
}