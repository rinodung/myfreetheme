<?php

/**
 * SpyroPress Builder Column Functions
 * Functions required for operation on a builder column.
 *
 * @package		Spyropress
 * @category	Builder
 * @author		SpyroSol
 */

/** AJAX Function *************************************/

/**
 * Insert Column
 */
function builder_new_column( $args, $builder_data ) {
    global $spyropress_builder;

    extract( $args );

    // Get row prev width
    $prev_width = $builder_data[$row_id]['prev_width'];

    // Column
    $col = $spyropress_builder->columns->get_column( $col_type );
    $col_ID = generate_column_id();
    $col_data = array(
        'type' => $col_type,
        'col_class' => builder_column_class( $prev_width, $col ),
        'modules' => array()
    );

    // Generate Column HTML
    $html = builder_render_backend_column( $col_ID, $col_data );

    // Saving data
    $builder_data[$row_id]['prev_width'] = $prev_width;
    $builder_data[$row_id]['columns'][$col_ID] = $col_data;
    $result = $spyropress_builder->save_data( $post_id, $builder_data );

    // Generate json data
    $json['success'] = ( $result ) ? true : false;
    $json['message'] = ( $result ) ? 'Column Saved' : 'Operation fails';
    $json['html'] = ( $result ) ? $html : 'Oops! something goes wrong while creating the new column.';
    $json['row_id'] = $row_id;
    $json['col_id'] = $col_ID;

    return $json;
}

/**
 * Delete Column
 */
function builder_delete_column( $args, $builder_data ) {
    global $spyropress_builder;

    extract( $args );

    $html = '';
    $prev_width = 0;

    // Deleting column if exists
    if ( isset( $builder_data[$row_id]['columns'][$col_id] ) ) {
        unset( $builder_data[$row_id]['columns'][$col_id] );

        // regenerating column classes
        $columns = $builder_data[$row_id]['columns'];

        if ( ! empty( $columns ) ) {
            foreach ( $columns as $colID => $col ) {

                $col_obj = $spyropress_builder->columns->get_column( $col['type'] );
                $builder_data[$row_id]['columns'][$colID]['col_class'] = builder_column_class( $prev_width, $col_obj );

                // Generate Column HTML
                $html .= builder_render_backend_column( $colID, $builder_data[$row_id]['columns'][$colID] );
            }
        }
        else {
            $html = '<div class="row-empty builder-row-column"></div>';
        }

        // Saving data
        $builder_data[$row_id]['prev_width'] = $prev_width;
        $result = $spyropress_builder->save_data( $post_id, $builder_data );

        // Generate json data
        $json['success'] = ( $result ) ? true : false;
        $json['message'] = ( $result ) ? 'Column Deleted' : 'Operation fails';
        $json['html'] = ( $result ) ? $html : 'Oops! something goes wrong while deleting the column.';
        $json['row_id'] = $row_id;
        $json['col_id'] = $col_id;

        return $json;
    }
    // If column doesn't exists
    else {

        // Generate json data
        $json['success'] = false;
        $json['message'] = 'Column not exists';
        $json['html'] = 'Column: ' . $col_id . ' doesn\'t exists.';
        $json['row_id'] = $row_id;
        $json['col_id'] = $col_id;

        return $json;
    }
}

/** Rendering Function **********************************/

/**
 * Render Columns
 */
function builder_render_backend_columns( $columns ) {

    if ( empty( $columns ) )
        return '<div class="row-empty builder-row-column"></div>';

    $html = '';
    foreach ( $columns as $col_ID => $column ) {
        $html .= builder_render_backend_column( $col_ID, $column );
    }

    return $html;
}

/**
 * Render Column
 */
function builder_render_backend_column( $col_ID, $column ) {

    $column = sprintf( '
        <div id="%1$s" class="builder-row-column %2$s">
            <div class="builder-row-column-data">
                %3$s
            </div>
            <div class="builder-row-column-toolbar">
                <span class="builder-column-sizer">
                    <a href="#%1$s" title="Decrease Width" class="builder-column-decrease"><i class="module-dark module-icon-left"></i></a>
                    <span>Size</span>
                    <a href="#%1$s" title="Increase Width" class="builder-column-increase"><i class="module-dark module-icon-right"></i></a>
                </span>
                <a title="Remove Column" href="#" class="builder-column-delete left"><i class="module-dark module-icon-delete"></i></a>
                <a title="Add Module" href="#" class="builder-module-add left"><i class="module-dark module-icon-add"></i><strong>Module</strong></a>
                <div class="clear"></div>
            </div>
        </div>', $col_ID, $column['col_class'], builder_render_backend_modules( $column['modules'] )
    );

    return $column;
}

/**
 * Render Column - Frontend
 */
function builder_render_frontend_columns( $columns ) {

    $html = '';
    foreach ( $columns as $col_ID => $column ) {
        $html .= builder_render_frontend_column( $col_ID, $column );
    }

    return $html;
}

/**
 * Render Column - Frontend
 */
function builder_render_frontend_column( $col_ID, $column ) {

    $section_class = '';
    if( isset( $column['col_class'] ) && !empty( $column['col_class'] ) )
        $section_class = ' class="' . $column['col_class'] . '"';

    $column = sprintf( '
        <div id="%1$s"%2$s>
            %3$s
        </div>', $col_ID, $section_class, builder_render_frontend_modules( $column['modules'] )
    );

    return $column;
}

/** Helper Function *************************************/

/**
 * Generate Unique Column ID
 */
function generate_column_id() {
    return uniqid( 'builder-column-' );
}

/**
 * Generate column classes
 */
function builder_column_class( &$prev_width, $col, $extra_class = '' ) {
    global $spyropress_builder;

    $classes = array();

    // grid col size class
    $classes[] = 'span' . str_replace( '/', 'by', $col->config['size'] );
    if( 'skt' == get_html_framework() )
        $classes[] = get_skeleton_class( $col->config['size'] );
    if( 'fd3' == get_html_framework() )
        $classes[] = get_foundation3_class( $col->config['size'] );
    if( 'bs3' == get_html_framework() )
        $classes[] = 'col-md-' . $col->config['size'];

    // add span_first class
    $width = is_string( $col->config['size'] ) ? ( int )1/3*16 : ( int )$col->config['size'];
    $new_width = $prev_width + $width;

    if ( $prev_width == 0 ) {
        $classes[] = get_first_column_class();
        $prev_width = $new_width;
    } elseif ( ( get_grid_columns() - $new_width ) < 0 ) {
        $prev_width = $width;
        $classes[] = get_first_column_class();
    } else {
        $prev_width = $new_width;
    }

    if( get_grid_columns() == $new_width ) {
        $prev_width = 0;
        $classes[] = get_last_column_class();
    }

    // extra class define by row block
    if ( $extra_class != '' ) {
        $classes[] = $extra_class;
    }

    return spyropress_clean_cssclass( $classes );
}
?>