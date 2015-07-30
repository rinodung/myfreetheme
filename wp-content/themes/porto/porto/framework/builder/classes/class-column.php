<?php

/**
 * SpyroPress Builder Columns
 *
 * Main builder columns file which contains columns class, factory and functions.
 *
 * @category 	Builder
 * @package 	Spyropress
 * @subpackage  Builder
 */


/**
 * Column Factory
 */
if ( ! class_exists( 'SpyropressBuilderColumns' ) ) {

    class SpyropressBuilderColumns {

        var $columns = array();

        function __construct() {
        }

        function register( $col_class ) {
            $this->columns[$col_class] = new $col_class();
        }

        function unregister( $col_class ) {
            if ( isset( $this->columns[$col_class] ) )
                unset( $this->columns[$col_class] );
        }

        function get_column( $type ) {
            return $this->columns[$type];
        }

        function get_columns() {
            return $this->columns;
        }
    }
}

/**
 * Column
 */
if ( ! class_exists( 'SpyropressBuilderColumn' ) ) {
    class SpyropressBuilderColumn {
        var $config;
    }
}

/**
 * Render Column Types List
 */
function spyropress_builder_render_columns() {
    global $spyropress_builder;
    $columns = $spyropress_builder->columns->get_columns();

    if ( empty( $columns ) )
        return;

    $content = '<ul>';
    foreach ( $columns as $key => $col ) {
        $content .= sprintf( '
            <li><a class="column-action-add" href="#" data-column-type="%1$s" title="%4$s"><img src="%2$s"/ ><strong>%3$s</strong></a></li>',
            $key, $col->config['icon'], $col->config['name'], $col->config['description'] );
    }
    $content .= '</ul>';

    echo $content;
}

/**
 * Registers a SpyropressBuilderCol Col
 * @param string $col_class The name of a class that extends SpyropressBuilderCol
 */
function spyropress_builder_register_column( $col_class ) {
    global $spyropress_builder;

    $spyropress_builder->columns->register( $col_class );
}

/**
 * Unregisters a SpyropressBuilderCol Col
 * @param string $col_class The name of a class that extends SpyropressBuilderCol
 */
function spyropress_builder_unregister_column( $col_class ) {
    global $spyropress_builder;

    $spyropress_builder->columns->unregister( $col_class );
}

?>