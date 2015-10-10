<?php

/**
 * Text and Photo Widget
 * Display static text and photo.
 *
 * @package		SpyroPress
 * @category	Widgets
 * @author		SpyroSol
 */

class SpyroPress_Widget_TabWidget extends SpyropressWidget {

    /**
     * Constructor
     */
    function __construct() {

        // Widget variable settings.
        $this->cssclass = 'tabs tabs-widget';
        $this->description = __( 'Display posts and comments in tab.', 'spyropress' );
        $this->id_base = 'spyropress_tabwodget';
        $this->name = __( 'Spyropress: Tab Widget', 'spyropress' );

        $this->fields = array(

            array(
                'label' => __( 'Disable Tabs', 'spyropress' ),
                'id' => 'hide',
                'type' => 'checkbox',
                'options' => array(
                    'popular' => __( 'Hide Popular Tab', 'spyropress' ),
                    'recent' => __( 'Hide Recent Tab', 'spyropress' ),
                    'comment' => __( 'Hide Comment Tab', 'spyropress' ),
                )
            ),
            
            array(
                'label' => __( 'Popular Posts', 'spyropress' ),
                'type' => 'sub_heading'
            ),
            
            array(
                'label' => __( 'Title', 'spyropress' ),
                'id' => 'popular_title',
                'type' => 'text',
                'std' => 'Comments'
            ),

            array(
                'label' => __( 'Number of Posts', 'spyropress' ),
                'id' => 'popular_posts',
                'type' => 'text',
                'std' => 3
            ),
            
            array(
                'label' => __( 'Recent Posts', 'spyropress' ),
                'type' => 'sub_heading'
            ),
            
            array(
                'label' => __( 'Title', 'spyropress' ),
                'id' => 'recent_title',
                'type' => 'text',
                'std' => 'Recent Posts'
            ),
            
            array(
                'label' => __( 'Number of Posts', 'spyropress' ),
                'id' => 'recent_posts',
                'type' => 'text',
                'std' => 3
            ),
            
            array(
                'label' => __( 'Recent Comments', 'spyropress' ),
                'type' => 'sub_heading'
            ),
            
            array(
                'label' => __( 'Title', 'spyropress' ),
                'id' => 'comments_title',
                'type' => 'text',
                'std' => 'Comments'
            ),
            
            array(
                'label' => __( 'Number of Comments', 'spyropress' ),
                'id' => 'comments',
                'type' => 'text',
                'std' => 3
            )
        );

        $this->create_widget();
    }

    function widget( $args, $instance ) {

        // extracting info
        extract( $args );
        extract( spyropress_clean_array( $instance ) );

        // get view to render
        include $this->get_view();
    }
} // class SpyroPress_Widget_TabWidget

register_widget( 'SpyroPress_Widget_TabWidget' );