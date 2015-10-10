<?php
/**
 * SpyroPress Widgets Helper Class
 *
 * https://github.com/sksmatt/WordPress-Widgets-Helper-Class
 * Main admin file which create setting screens.
 *
 * @author 		SpyroSol
 * @category 	Admin
 * @package 	Spyropress
 */

class SpyropressWidget extends WP_Widget {

    /** Variables *******************************************/
    var $id_base;
    var $name;
    var $cssclass;
    var $description;

    var $path;
    var $fields;
    var $is_builder = false;

    var $width = 300;

    /**
     * templates['select_value'] = array(
            'label' => '',
            'view'  => '',
            'class' => '',
        )
     */
    var $templates = array();


    /**
     * Create Widget
     * Creates a new widget and sets it's labels, description, fields and options
     */
    function create_widget() {

        // widget options
        $widget_options = array(
            'classname'     => $this->cssclass,
            'description'   => $this->description
        );

        // control option
        $control_options = array(
            'width' => $this->width,
            'height' => ''
        );

        // widget templates
        $widget_class = strtolower( get_class( $this ) );
        $this->templates = apply_filters( $widget_class . '_templates', $this->templates );

        // Call parent constructor
        $this->WP_Widget( $this->id_base, $this->name, $widget_options, $control_options );
    }

    function get_templates() {
        return $this->templates;
    }

    function get_option_templates() {

        $options = array();
        foreach( $this->templates as $key => $template ) {
            $options[$key] = $template['label'];
        }
        return $options;
    }

    function get_view( $template = '' ) {
        $view = 'view.php';

        if( empty( $template ) ) return $view;

        $template = $this->templates[$template];

        if( !isset( $template['view'] ) ) return $view;

        if( isset( $template['view'] ) )
            return $this->path . '/' . $template['view'];
    }

    /**
     * Form
     * Creates the settings form
     *
     * @see WP_Widget->form
     */
    function form( $instance ) {
        $this->instance = $instance;
        $form = $this->create_fields();
        echo $form;
    }

    /**
     * Update Fields
     * @see WP_Widget->update
     */
    function update( $new_instance, $old_instance ) {
        $instance = array();
        foreach( $this->fields as $section ) {
            if(
                isset( $section['id'] ) &&
                !in_array( $section['type'], spyropress_exclude_option_types() )
            ) {
                $key = trim( $section['id'] );
                $type = $section['type'];
                if( isset( $new_instance[$key] ) ) {
                    $new_value = $new_instance[$key];
                    $instance[$key] = spyropress_validate_setting( $new_value, $type, $key, $section );
                }
            }
        }

        return $this->after_validate_fields( $instance );
    }

    /**
     * After Validate Fields
     * Allows to modify the output after validating the fields
     */
    function after_validate_fields( $instance = '' ) {
        return $instance;
    }

    /**
     * Create Fields
     * Creates each field defined
     */
    function create_fields( $out = '' ) {

        $out = $this->before_create_fields( $out );

        if( !empty( $this->fields ) ) {
            foreach( $this->fields as $field ) {
                $out .= $this->create_field( $field );
            }
        }

        $out = $this->after_create_fields( $out );

        return $out;
    }

    /**
     * Before Create Fields
     * Allows to modify code before creating the fields
     */
    function before_create_fields( $out = '' ) {
        return $out;
    }

    /**
     * After Create Fields
     * Allows to modify code after creating the fields
     */
    function after_create_fields( $out = "" ) {
        return $out;
    }

    function create_field( $section ) {

        // Defaults
        $defaults = array(
            'id' => '',
            'label' => '',
            'type' => 'text',
            'desc' => '',
            'std' => '',
            'class' => 'section-full',

            'placeholder' => '',
            'rows' => '15',
            'post_type' => 'post',
            'taxonomy' => 'category',
            'options' => array()
        );
        $section = wp_parse_args( $section, $defaults );

        // id
        $id = $section['id'];
        $section['id'] = $this->get_field_id( $id );
        // name
        if ( ! isset( $section['name'] ) )
            $section['name'] = $this->get_field_name( $id );
        // set to default
        if ( ! isset( $this->instance[$id] ) && isset( $section['std'] ) && $section['std'] ) {
            $this->instance[$id] = $section['std'];
        }
        // value
        $value = isset( $this->instance[$id] ) ? $this->instance[$id] : '';

        // Prefix method
        $field_method = 'spyropress_widget_' . $section['type'];

        // Run method
        if ( function_exists( $field_method ) ) {

            if (
                isset( $this->instance['post'] ) &&
                isset( $section['desc'] ) &&
                is_str_contain( '{$post->ID}', $section['desc'] )
            ) {
                $section['post'] = $this->instance['post'];
            }

            return call_user_func_array( $field_method, array(
                $section,
                $section['id'],
                $value,
                $this->is_builder
            ) );
        }
    }
}

?>