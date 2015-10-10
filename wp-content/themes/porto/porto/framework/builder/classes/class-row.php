<?php

/**
 * SpyroPress Builder Rows
 *
 * Main builder rows file which contains row class, factory and functions
 *
 * @category 	Builder
 * @package 	Spyropress
 * @subpackage  Builder
 */

/**
 * Row Factory
 */
if ( ! class_exists( 'SpyropressBuilderRows' ) ) {

    class SpyropressBuilderRows {

        private $rows = array();

        function __construct() {
        }

        function register( $row_class ) {
            $this->rows[$row_class] = new $row_class();
        }

        function unregister( $row_class ) {
            if ( isset( $this->rows[$row_class] ) )
                unset( $this->rows[$row_class] );
        }

        function get_row( $type ) {
            return $this->rows[$type];
        }

        function get_rows() {
            return $this->rows;
        }
    }
}

/**
 * Row
 */
if ( ! class_exists( 'SpyropressBuilderRow' ) ) {

    class SpyropressBuilderRow {
        var $config;

        function row_wrapper( $row_ID, $row ) {
            
            return apply_filters( 'spyropress_builder_row_wrapper', $row_ID, $row );
        }
    }
}

/**
 * Render Row Types List
 */
function spyropress_builder_render_rows() {
    global $spyropress_builder;
    $rows = $spyropress_builder->rows->get_rows();

    if ( empty( $rows ) )
        return;

    $content = '<ul>';
    foreach ( $rows as $key => $row ) {
        $content .= sprintf( '<li><a class="row-action-add" href="#" data-row-type="%1$s" title="%4$s"><img src="%2$s"/ ><strong>%3$s</strong></a></li>',
            $key, $row->config['icon'], $row->config['name'], $row->config['description'] );
    }
    $content .= '</ul>';

    echo $content;
}

/**
 * Registers a SpyropressBuilderRow Row
 * @param string $row_class The name of a class that extends SpyropressBuilderRow
 */
function spyropress_builder_register_row( $row_class ) {
    global $spyropress_builder;

    $spyropress_builder->rows->register( $row_class );
}

/**
 * Unregisters a SpyropressBuilderRow row.
 * @param string $row_class The name of a class that extends SpyropressBuilderRow
 */
function spyropress_builder_unregister_row( $row_class ) {
    global $spyropress_builder;

    $spyropress_builder->rows->unregister( $row_class );
}

?>