<?php

/**
 * SpyroPress Builder Modules
 * Main builder modules file which contains module class, factory and fucntions.
 *
 * @category 	Builder
 * @package 	Spyropress
 * @subpackage  Builder
 */

/**
 * Module Factory
 */
if ( ! class_exists( 'SpyropressBuilderModules' ) ) {

    class SpyropressBuilderModules {

        private $modules = array();

        function __construct() {
        }

        function register( $module ) {
            $this->modules[$module] = new $module();
        }

        function unregister( $module ) {
            if ( isset( $this->modules[$module] ) )
                unset( $this->modules[$module] );
        }

        function get_modules() {
            return $this->modules;
        }

        function get_module( $module_type ) {
            return $this->modules[$module_type];
        }
    }
}

/**
 * Module
 */
if ( ! class_exists( 'SpyropressBuilderModule' ) ) {

    class SpyropressBuilderModule extends SpyropressWidget {

        public $is_core = false;
        var $is_builder = true;

        /** Before Create Fields **/
        function before_create_fields( $out = "" ) {
            $out .= '<div class="builder-sections">';
            return $out;
        }

        /** After Create Fields **/
        function after_create_fields( $out = "" ) {
            $out .= '</div>';
            return $out;
        }
    }
}

/**
 * Generate widget list for wordpress admin
 */
function spyropress_builder_render_widgets() {
    global $wp_registered_widgets;
    $content = '';

    // Sorting
    $sort = $wp_registered_widgets;
    usort( $sort, 'builder_module_name_sort' );
    $done = array();

    foreach ( $sort as $widget ) {
        $callback = $widget['callback'];
        if ( in_array( $callback, $done, true ) )
            continue;

        $done[] = $callback;
        $widget_obj = $callback[0];
        $class = get_class( $widget_obj );

        /** Generate HTML **/
        $content .= sprintf( '
            <li class="module-item">
                <a class="builder-module-insert" href="#" data-module-type="%1$s">
                    <span class="module-icon-widget"></span>
                    <span class="module-item-body">
                        <strong class="module-item-title">%2$s</strong>
                        <span class="module-item-description">%3$s</span>
                    </span>
                </a>
            </li>', $class, $widget_obj->name, esc_html( $widget_obj->
            widget_options['description'] ) );
    }

    echo $content;
}

/**
 * Generate widget list for wordpress admin
 */
function spyropress_builder_render_modules( $display_core = false ) {
    global $spyropress_builder;
    $sort = $spyropress_builder->modules->get_modules();
    
    if( empty( $sort ) ) return;
    
    $content = '';
    
    // Sorting
    usort( $sort, 'builder_module_name_sort' );
    $done = array();

    foreach ( $sort as $module ) {
        if ( $display_core && $module->is_core ) {
            $module_idbase = $module->id_base;
            if ( in_array( $module_idbase, $done, true ) )
                continue;

            $done[] = $module_idbase;
            $widget_obj = $module;
            $class = get_class( $widget_obj );

            /** Generate HTML **/
            $content .= sprintf( '
                        <li class="module-item">
                            <a class="builder-module-insert" href="#" data-module-type="%1$s">
                                <span class="module-icon-widget"></span>
                                <span class="module-item-body">
                                    <strong class="module-item-title">%2$s</strong>
                                    <span class="module-item-description">%3$s</span>
                                </span>
                            </a>
                        </li>', $class, $widget_obj->name, esc_html( $widget_obj->widget_options['description'] )
            );
        }
        elseif ( ! $display_core && ! $module->is_core ) {
            $module_idbase = $module->id_base;
            if ( in_array( $module_idbase, $done, true ) )
                continue;

            $done[] = $module_idbase;
            $widget_obj = $module;
            $class = get_class( $widget_obj );

            /** Generate HTML **/
            $content .= sprintf( '
                        <li class="module-item">
                            <a class="builder-module-insert" href="#" data-module-type="%1$s">
                                <span class="module-icon-widget"></span>
                                <span class="module-item-body">
                                    <strong class="module-item-title">%2$s</strong>
                                    <span class="module-item-description">%3$s</span>
                                </span>
                            </a>
                        </li>', $class, $widget_obj->name, esc_html( $widget_obj->widget_options['description'] )
            );
        }
    }

    echo $content;
}

/**
 * Registers a BuilderModule Module
 * @param string $module The name of a class that extends BuilderModule
 */
function spyropress_builder_register_module( $module ) {
    global $spyropress_builder;

    $spyropress_builder->modules->register( $module );
}

/**
 * Unregisters a BuilderModule Module.
 * @param string $module The name of a class that extends BuilderModule
 */
function spyropress_builder_unregister_module( $module ) {
    global $spyropress_builder;

    $spyropress_builder->modules->unregister( $module );
}

/**
 * Widget sort callback
 */
function builder_module_name_sort( $a, $b ) {
    $a = ( object )$a;
    $b = ( object )$b;
    return strnatcasecmp( $a->name, $b->name );
}

?>