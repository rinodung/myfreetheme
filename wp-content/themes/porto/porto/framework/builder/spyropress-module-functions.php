<?php

/**
 * SpyroPress Builder Module Functions
 *
 * Functions required for operation on a builder module.
 *
 * @package		Spyropress
 * @category	Builder
 * @author		SpyroSol
 */

/** AJAX Function ***************************************/

/**
 * Add or Edit Module Popup
 */
function builder_edit_module( $args, $builder_data ) {
    global $spyropress_builder, $spyropress_widgets;

    extract( $args );

    // Module
    if ( isset( $args['module_id'] ) && '' != $module_id ) {
        $module = $builder_data[$row_id]['columns'][$col_id]['modules'][$module_id];
        $module_type = $module['type'];
        $instance = $module['instance'];
    }
    else {
        $module_id = generate_module_id();
        $instance = array();
    }

    // Get form html for widget
    ob_start();
    $widget = new $module_type();
    $widget->_set( 1 );
    $widget->is_builder = true;

    // filters the widget admin form before displaying, return false to stop displaying it
    $instance = apply_filters( 'widget_form_callback', $instance, $widget );

    $form = null;
    if ( false !== $instance ) {
        $form = $widget->form( $instance );
        // add extra fields in the widget form - be sure to set $form to null if you add any
        // if the widget has no form the text echoed from the default form method can be hidden using css
        do_action_ref_array( 'in_widget_form', array( &$widget, &$form, $instance ) );
    }

    $form = ob_get_clean();
    $form_html = render_module_popup( $widget, $form, $module_type, $module_id );

    $result = true;

    // Generate json data
    $json['success'] = ( $result ) ? true : false;
    $json['message'] = ( $result ) ? 'Returning form' : 'Operation fails';
    $json['html'] = ( $result ) ? $form_html : 'Oops! something goes wrong while generating module form.';
    $json['row_id'] = $row_id;
    $json['col_id'] = $col_id;

    return $json;
}

/**
 * Generate popup html
 */
function render_module_popup( $widget, $content, $module_type, $module_id ) {

    // Hidden fields
    $hidden_fields = '<input type="hidden" name="module_id_base" value="' . $widget->id_base . '" />';
    $hidden_fields .= '<input type="hidden" name="module_type" value="' . $module_type . '" />';
    $hidden_fields .= '<input type="hidden" name="module_id" value="' . $module_id . '" />';

    $popup = sprintf( '
        <div class="builder-popup-header">
            <h2>%1$s</h2>
            <p>%2$s</p>
        </div>
        <form id="%4$s-edit-form" name="%4$s" class="builder-module-edit-form">
            <div class="builder-popup-content">
                <div class="builder-module-form">
                    %3$s
                </div>
            </div>
            <div class="builder-popup-footer">
                <span class="builder-popup-activity builder-hide">Saving Module&hellip;</span>
                <button id="module-edit-form-submit" class="button-primary button-data">Save</button>
                <span>or </span>
                <a id="builder-module-edit-close" class="builder-popup-close" href="#">Cancel</a>
                %5$s
            </div>
        </form>', $widget->name, $widget->widget_options['description'], $content, $widget->id_base, $hidden_fields
    );

    return $popup;
}

/**
 * Save Module Options
 */
function builder_save_module( $args, $builder_data ) {
    global $spyropress_builder;

    extract( $args );

    $new_instance = $old_instance = array();

    // Module
    $module_type = $form_data['module_type'];
    $module_id = $form_data['module_id'];
    $widget = new $module_type();
    $widget_id = 'widget-' . $form_data['module_id_base'];

    if ( isset( $builder_data[$row_id]['columns'][$col_id]['modules'][$module_id] ) )
        $old_instance = $builder_data[$row_id]['columns'][$col_id]['modules'][$module_id]['instance'];
    $new_instance = $form_data[$widget_id]['1'];
    $widget->_set( 1 );

    // Updating
    $new_instance = stripslashes_deep( $new_instance );
    $instance = $widget->update( $new_instance, $old_instance );

    // filters the widget's settings before saving, return false to cancel saving (keep the old settings if updating)
    $instance = apply_filters( 'widget_update_callback', $instance, $new_instance, $old_instance, $widget );

    // Saving data
    $module_data = array(
        'module_name' => $widget->name,
        'type' => $module_type,
        'instance' => $instance
    );

    $builder_data[$row_id]['columns'][$col_id]['modules'][$module_id] = $module_data;
    $result = $spyropress_builder->save_data( $post_id, $builder_data );

    // Generate Column HTML
    $module_html = builder_render_backend_module( $module_id, $widget->name );

    if ( $old_instance == $instance )
        $result = true;

    // Generate json data
    $json['success'] = ( $result ) ? true : false;
    $json['message'] = ( $result ) ? 'Module Saved' : 'Operation fails';
    $json['html'] = ( $result ) ? $module_html : 'Oops! something goes wrong while saving the new module, development team has been notified!';
    $json['row_id'] = $row_id;
    $json['col_id'] = $col_id;
    $json['module_id'] = $module_id;

    return $json;
}

/**
 * Delete Module
 */
function builder_delete_module( $args, $builder_data ) {
    global $spyropress_builder;

    extract( $args );

    // Deleting module if exists
    if ( isset( $builder_data[$row_id]['columns'][$col_id]['modules'][$module_id] ) ) {
        unset( $builder_data[$row_id]['columns'][$col_id]['modules'][$module_id] );

        // Saving data
        $result = $spyropress_builder->save_data( $post_id, $builder_data );

        // Generate json data
        $json['success'] = ( $result ) ? true : false;
        $json['message'] = ( $result ) ? 'Module Deleted' : 'Operation fails';
        $json['html'] = ( $result ) ? 'Module deleted successfully.' : 'Oops! something goes wrong while deleting the module, development team has been notified!';
        $json['row_id'] = $row_id;
        $json['col_id'] = $col_id;
        $json['module_id'] = $module_id;

        return $json;
    }
    // If module doesn't exists
    else {

        // Generate json data
        $json['success'] = false;
        $json['message'] = 'Module not exists';
        $json['html'] = 'Module: ' . $module_id . ' doesn\'t exists.';
        $json['row_id'] = $row_id;
        $json['col_id'] = $col_id;
        $json['module_id'] = $module_id;

        return $json;
    }
}

/**
 * Reorder Modules
 */
function builder_reorder_modules( $args, $builder_data ) {
    global $spyropress_builder;
    extract( $args );

    $allmodules = array();

    if( !empty( $sender ) ) {
        $allmodules += $builder_data[ $sender['row_id'] ]['columns'][ $sender['col_id'] ]['modules'];
        $builder_data[ $sender['row_id'] ]['columns'][ $sender['col_id'] ]['modules'] = array();
    }

    if( !empty( $receiver ) ) {
        $allmodules += $builder_data[ $receiver['row_id'] ]['columns'][ $receiver['col_id'] ]['modules'];
        $builder_data[ $receiver['row_id'] ]['columns'][ $receiver['col_id'] ]['modules'] = array();
    }

    if( isset( $sender['modules'] ) ) {
        foreach( $sender['modules'] as $module_id ) {
            $builder_data[ $sender['row_id'] ]['columns'][ $sender['col_id'] ]['modules'][$module_id] = $allmodules[$module_id];
            unset( $allmodules[$module_id] );
        }
    }

    if( isset( $receiver['modules'] ) ) {
        foreach( $receiver['modules'] as $module_id ) {
            $builder_data[ $receiver['row_id'] ]['columns'][ $receiver['col_id'] ]['modules'][$module_id] = $allmodules[$module_id];
            unset( $allmodules[$module_id] );
        }
    }

    // Saving data
    $result = $spyropress_builder->save_data( $post_id, $builder_data );

    // Generate json data
    $json['success'] = true;
    $json['message'] = ( $result ) ? 'Module Order Updated' : 'Operation fails';
    $json['html'] = ( $result ) ? 'Module Order Updated.' : 'Oops! something goes wrong while updating modules order.';

    return $json;
}

/**
 * Clone Module
 */
function builder_clone_module( $args, $builder_data ) {
    global $spyropress_builder;

    extract( $args );

    if ( isset( $builder_data[$row_id]['columns'][$col_id]['modules'][$module_id] ) ) {
        $new_module_id = generate_module_id();
        $new_module = $builder_data[$row_id]['columns'][$col_id]['modules'][$module_id];
        $builder_data[$row_id]['columns'][$col_id]['modules'][$new_module_id] = $new_module;

        // Saving data
        $result = $spyropress_builder->save_data( $post_id, $builder_data );

        // Generate Column HTML
        $module_html = builder_render_backend_module( $new_module_id, $new_module['module_name'] );

        // Generate json data
        $json['success'] = ( $result ) ? true : false;
        $json['message'] = ( $result ) ? 'Module Cloned' : 'Operation fails';
        $json['html'] = ( $result ) ? $module_html : 'Oops! something goes wrong while deleting the module, development team has been notified!';
        $json['row_id'] = $row_id;
        $json['col_id'] = $col_id;
        $json['module_id'] = $new_module_id;

        return $json;
    }
    // If module doesn't exists
    else {
        // Generate json data
        $json['success'] = false;
        $json['message'] = 'Module not exists';
        $json['html'] = 'Module: ' . $module_id . ' doesn\'t exists.';
        $json['row_id'] = $row_id;
        $json['col_id'] = $col_id;
        $json['module_id'] = $module_id;

        return $json;
    }
}

/** Rendering Function *********************************/

/**
 * Render Modules
 */
function builder_render_backend_modules( $modules ) {

    $html = '';
    if ( ! empty( $modules ) ) {
        foreach ( $modules as $module_id => $module ) {
            $html .= builder_render_backend_module( $module_id, $module['module_name'] );
        }
    }

    return $html;
}

/**
 * Render Module
 */
function builder_render_backend_module( $module_id, $module_name ) {

    $module = sprintf( '
        <div class="builder-module" id="%1$s">
            <div class="module-icon-widget"></div>
            <div class="builder-module-body">
                <strong class="builder-module-title">%2$s</strong>
                <div class="builder-module-action">
                    <a href="#%1$s" class="builder-module-edit">Edit</a>
                    <a href="#%1$s" class="builder-module-clone">Clone</a>
                    <a href="#%1$s" class="builder-module-delete">Delete</a>
                </div>
            </div>
        </div>', $module_id, $module_name
    );

    return $module;
}

/**
 * Render Modules - Frontend
 */
function builder_render_frontend_modules( $modules ) {

    $html = '';
    if ( ! empty( $modules ) ) {
        foreach ( $modules as $module_id => $module ) {
            $html .= builder_render_frontend_module( $module_id, $module );
        }
    }

    return $html;
}

/**
 * Render Module - Frontend
 */
function builder_render_frontend_module( $module_id, $module ) {
    ob_start();
    spyropress_the_builder_module( $module_id, $module );
    return ob_get_clean();
}

/** Helper Function *************************************/

/**
 * Generate Unique Module ID
 */
function generate_module_id() {
    return uniqid( 'builder-module-' );
}
?>