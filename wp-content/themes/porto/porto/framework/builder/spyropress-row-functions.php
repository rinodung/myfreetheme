<?php

/**
 * SpyroPress Builder Row Functions
 * Functions required for operation on a builder row.
 *
 * @package		Spyropress
 * @category	Builder
 * @author		SpyroSol
 */

/** AJAX Function *************************************/

/**
 * Insert Row
 */
function builder_new_row( $args, $builder_data ) {
    global $spyropress_builder;

    extract( $args );

    // Row
    $row = $spyropress_builder->rows->get_row( $row_type );
    $row_ID = generate_row_id();
    $row_data = array(
        'type' => $row_type,
        'options' => array(),
        'columns' => array()
    );

    // Generate Columns HTML
    $prev_width = 0;
    $columns = $row->config['columns'];

    if ( ! empty( $columns ) ) {

        foreach ( $columns as $column ) {

            $col = $spyropress_builder->columns->get_column( $column['type'] );
            $col_ID = generate_column_id();
            $col_class = ( isset( $column['class'] ) && $column['class'] ) ? $column['class'] : '';
            $col_data = array(
                'type' => $column['type'],
                'col_class' => builder_column_class( $prev_width, $col, $col_class ),
                'modules' => array()
            );
            $row_data['columns'][$col_ID] = $col_data;
        }

    }

    // Generate Row HTML
    $html = '';
    $html = builder_render_backend_row( $row_ID, $row_data );
    $html = str_replace( 'class="builder-row"', 'class="builder-row active"', $html );

    // Saving data
    $row_data['prev_width'] = $prev_width;
    $builder_data[$row_ID] = $row_data;
    $result = $spyropress_builder->save_data( $post_id, $builder_data );

    // Generate json data
    $json['success'] = ( $result ) ? true : false;
    $json['message'] = ( $result ) ? __( 'Row Saved', 'spyropress' ) : __( 'Operation fails', 'spyropress' );
    $json['html'] = ( $result ) ? $html : __( 'Oops! something goes wrong while creating the new row.', 'spyropress' );
    $json['row_id'] = $row_ID;

    return $json;
}

/**
 * Delete Row
 */
function builder_delete_row( $args, $builder_data ) {
    global $spyropress_builder;
    $json = array();
    extract( $args );

    // if row exists
    if ( isset( $builder_data[$row_id] ) ) {
        unset( $builder_data[$row_id] );

        // Removing CSS
        remove_row_old_css( $row_id );

        // Saving data
        $result = $spyropress_builder->save_data( $post_id, $builder_data );

        // Generate json data
        $json['success'] = ( $result ) ? true : false;
        $json['message'] = ( $result ) ? __( 'Row Deleted', 'spyropress' ) : __( 'Operation fails.', 'spyropress' );
        $json['html'] = ( $result ) ? __( 'Row deleted successfully.', 'spyropress' ) : __( 'Oops! something goes wrong while deleting the row.', 'spyropress' );
        $json['row_id'] = $row_id;
    }
    // If row doesn't exists
    else {

        // Generate json data
        $json['success'] = false;
        $json['message'] = __( 'Row not exists', 'spyropress' );
        $json['html'] = sprintf( __( 'Row: %s doesn\'t exists.', 'spyropress' ), $row_id );
        $json['row_id'] = $row_id;
    }

    return $json;
}

/**
 * Reorder Rows
 */
function builder_reorder_rows( $args, $builder_data ) {
    global $spyropress_builder;

    extract( $args );

    // Orders
    $order_by = explode( ',', $order );

    // Sorting rows
    $sorted_data = sort_array_by_array( $builder_data, $order_by );

    // Saving data
    $result = $spyropress_builder->save_data( $post_id, $sorted_data );

    // Generate json data
    $json['success'] = ( $result ) ? true : false;
    $json['message'] = ( $result ) ? __( 'Row Order Updated', 'spyropress' ) : __( 'Operation fails', 'spyropress' );
    $json['html'] = ( $result ) ? __( 'Row Order Updated', 'spyropress' ) : __( 'Oops! something goes wrong while updating rows order.', 'spyropress' );

    return $json;
}


/**
 * Add or Edit Row Options
 */
function builder_edit_row( $args, $builder_data ) {

    extract( $args );

    //global $spyropress;
    //remove_filter( 'in_widget_form', array( $spyropress->widgets, 'widget_extras_form' ), 10, 3 );

    // Module
    $module_type = 'Spyropress_Row_Options';
    $instance = ( isset( $args['row_id'] ) && !empty( $row_id ) ) ? $builder_data[$row_id]['options'] : array();

    // Get form html
    ob_start();
    $widget = new $module_type();
    $widget->_set( 1 );

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
    $html = render_row_option_popup( $widget, $form, $module_type, $row_id );

    // Generate json data
    $result = true;
    $json['success'] = ( $result ) ? true : false;
    $json['message'] = ( $result ) ? 'Returning form' : 'Operation fails';
    $json['html'] = ( $result ) ? $html : 'Oops! something goes wrong while generating module form.';
    $json['row_id'] = $row_id;

    return $json;
}

/**
 * Generate popup html
 */
function render_row_option_popup( $widget, $content, $module_type, $row_id ) {

    // Hidden fields
    $hidden_fields = '<input type="hidden" name="module_id_base" value="' . $widget->id_base . '" />';
    $hidden_fields .= '<input type="hidden" name="module_type" value="' . $module_type . '" />';
    $hidden_fields .= '<input type="hidden" name="row_id" value="' . $row_id . '" />';

    $popup = sprintf( '
        <div class="builder-popup-header">
            <h2>%1$s</h2>
            <p>%2$s</p>
        </div>
        <form id="%4$s-edit-form" name="%4$s" class="builder-row-option-form">
            <div class="builder-popup-content">
                <div class="builder-module-form">
                    %3$s
                </div>
            </div>
            <div class="builder-popup-footer">
                <span class="builder-popup-activity builder-hide">Saving Module&hellip;</span>
                <button id="row-option-form-submit" class="button-primary button-data">Save</button>
                <span>or </span>
                <a id="builder-row-option-close" class="builder-popup-close" href="#">Cancel</a>
                %5$s
            </div>
        </form>', $widget->name, $widget->widget_options['description'], $content, $widget->id_base, $hidden_fields
    );

    return $popup;
}

/**
 * Save Row Options
 */
function builder_save_row( $args, $builder_data ) {
    global $spyropress_builder;

    extract( $args );

    // Module
    $widget = new $module_type();
    $widget_id = 'widget-' . $form_data['module_id_base'];
    $old_instance = $builder_data[$row_id]['options'];
    $new_instance = $form_data[$widget_id]['1'];
    $widget->_set( 1 );

    // Updating
    $new_instance = stripslashes_deep( $new_instance );
    $instance = $widget->update( $new_instance, $old_instance );

    // filters the widget's settings before saving, return false to cancel saving (keep the old settings if updating)
    $instance = apply_filters( 'widget_update_callback', $instance, $new_instance, $old_instance, $widget );

    // Saving data
    $builder_data[$row_id]['options'] = $instance;
    $result = $spyropress_builder->save_data( $post_id, $builder_data );

    if ( $old_instance == $instance )
        $result = true;
    else {
        $css = apply_filters( 'builder_save_row_css', $row_id, $instance, $old_instance );
        
        $builder_css = syrp_get_builder_css();
        $builder_css = syrp_generate_builder_css( $row_id, $css, $builder_css );
        syrp_save_builder_css( $builder_css );
    }

    // Generate json data
    $json['success'] = ( $result ) ? true : false;
    $json['message'] = ( $result ) ? 'Row Option Saved' : 'Operation fails';
    $json['html'] = ( $result ) ? 'Saved' : 'Oops! something goes wrong while saving the row options, development team has been notified!';
    $json['row_id'] = $row_id;

    return $json;
}

function syrp_get_builder_css() {
    global $wp_filesystem;
    
    $url = wp_nonce_url( 'admin.php?page=spyropress-theme','spyropress-theme-options' );
    $result = true;
    
    if ( false === ( $creds = request_filesystem_credentials( $url ) ) ) {
        $result = false;
    }
    
    if( !WP_Filesystem( $creds ) ) {
        $result = false;
    }
    
    $css_file = dynamic_css_path() . 'builder.css';
    if ( !$wp_filesystem->is_writable( $css_file ) ) {
        $result = false;
    }
    
    return ( $result ) ? $wp_filesystem->get_contents( $css_file ) : get_option( 'spyropress_builder_css' ) ;
}

function syrp_save_builder_css( $builder_css = '' ) {
    
    global $wp_filesystem;
    
    $url = wp_nonce_url( 'admin.php?page=spyropress-theme','spyropress-theme-options' );
    $result = true;
    
    if ( false === ( $creds = request_filesystem_credentials( $url ) ) ) {
        $result = false;
    }
    
    if( !WP_Filesystem( $creds ) ) {
        $result = false;
    }
    
    $css_file = dynamic_css_path() . 'builder.css';
    if ( !$wp_filesystem->is_writable( $css_file ) ) {
        $result = false;
    }
    
    if( $result ) {
        update_option( 'spyropress_builder_css', false );
        $wp_filesystem->put_contents( $css_file, $builder_css );
    }
    else {
        update_option( 'spyropress_builder_css', $builder_css );
    }
}

/**
 * Save Row Options CSS
 */
function syrp_generate_builder_css( $row_id, $insertion, $builder_css ) {

    // remove CSS from file
    $new_content = $builder_css;
    $start_here = strpos( $new_content, "/* BEGIN {$row_id} */" );
    $end_here = strpos( $new_content, "/* END {$row_id} */", $start_here );
    if ( $end_here > 0 ) {
        $new_content = substr_replace( $new_content, '', $start_here, $end_here - $start_here + strlen( "/* END {$row_id} */\n" ) );
    }

    if( '' != $insertion ) {
        $new_content .= "/* BEGIN {$row_id} */\n";
        $new_content .= "{$insertion}\n";
        $new_content .= "/* END {$row_id} */\n";
    }

    return $new_content;
}

/**
 * Remove Css for Row
 */
function remove_row_old_css( $row_id = '' ) {

    // checks
    if ( '' == $row_id ) return false;
    
    $file_content = syrp_get_builder_css();
    $start_here = strpos( $file_content, "/* BEGIN {$row_id} */" );
    $end_here = strpos( $file_content, "/* END {$row_id} */", $start_here );
    
    if ( $end_here > 0 ) {
        $new_content = substr_replace( $file_content, '', $start_here, $end_here - $start_here + strlen( "/* END {$row_id} */\n" ) );
        
        syrp_save_builder_css( $new_content );
    }
}

/** Rendering Function *************************************/

/**
 * Render Rows
 */
function builder_render_backend_rows() {
    global $post, $spyropress_builder;
    $rows = $spyropress_builder->get_data( $post->ID );

    $content = '';

    if ( ! empty( $rows ) ) {
        foreach ( $rows as $row_ID => $row ) {
            $content .= builder_render_backend_row( $row_ID, $row );
        }
    }

    echo $content;
}

/**
 * Render Row
 */
function builder_render_backend_row( $row_ID, $row ) {

    return sprintf( '
        <div id="%1$s" class="builder-row">
            <div class="row-header builder-row-handle">
                <strong>Row</strong>
                <a href="#" class="toggle-row"></a>
            </div>
            <div class="toggle-container">
                <div class="row-toolbar">
                    <a title="Remove Row" class="builder-row-delete" href="#"><i class="module-icon-delete"></i> <strong>Delete</strong></a>
                    <a title="Add Column" class="builder-row-add-column" href="#builder-column-select"><i class="module-icon-grid"></i> <strong>Add Column</strong></a>
                    <a title="Row Options" class="builder-row-options" href="#builder-row-options"><i class="module-icon-options"></i> <strong>Row Options</strong></a>
                </div>
                <div class="row-body">
                    <div class="builder-row-columns %2$s">
                        %3$s
                    </div>
                </div>
            </div>
        </div>', $row_ID, get_backend_row_class(), builder_render_backend_columns( $row['columns'] )
    );
}

/**
 * Render Rows - Frontend
 */
function builder_render_frontend_rows( $post_ID = '' ) {
    global $post, $spyropress_builder;

    // set post id
    if ( $post_ID == '' ) $post_ID = $post->ID;

    // get builder data
    $rows = $spyropress_builder->get_data( $post_ID );

    $html = '';
    if ( ! empty( $rows ) ) {

        foreach ( $rows as $row_ID => $row ) {

            // set custom row id
            if( isset( $row['options']['custom_container_id'] ) && !empty( $row['options']['custom_container_id'] ) )
                $row_ID = $row['options']['custom_container_id'];

            $show_row = true;
            if ( isset( $row['options']['show'] ) )
                $show_row = ! $row['options']['show'];

            if ( $show_row ) {

                $row_obj = $spyropress_builder->rows->get_row( $row['type'] );

                // generate row html
                $html .= builder_render_frontend_row( $row_ID, $row, $row_obj );
            }
        }
    }

    return $html;
}

/**
 * Generate row html for frontend
 */
function builder_render_frontend_row( $row_ID, $row, $row_obj ) {
    return $row_obj->row_wrapper( $row_ID, $row );
}

/** Helper Function *************************************/

/**
 * WP-Admin Row Class
 */
function get_backend_row_class() {
    return 'row-fluid';
}

/**
 * Generate Unique Row ID
 */
function generate_row_id( ) {
    return uniqid( 'builder-row-' );
}
?>