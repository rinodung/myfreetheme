SpyroPress Porto v1.5.1
HTML Version 3.4.1
<?php
global $spyropress_builder;
$rows = $spyropress_builder->get_data( get_the_ID() );
$new_data = array();
function generate_id() {
    $a= str_replace( '.', '', uniqid( '', true ) );
    return substr( $a, -6 );
}
foreach( $rows as $row ) {
    
    $new_data[] = generate_section( $row );
}

function generate_section( $row ) {
    // Section
    $section = new stdClass();
    $section_id = 'section_' . generate_id();
    
    $section->settings = (object)$row['options'];
    $section->fullwidth = 'off';
    $section->type = 'section';
    $section->id = $section_id;
    $section->rows = generate_row( $row, $section_id );
    
    return $section;
}

function generate_row( $row_old, $section_id ) {
    $row = new stdClass();
    $row_id = 'row_' . generate_id();
    
    $row->parent = $section_id;
    $row->type = 'row';
    $row->id = $row_id;
    $row->settings = new stdClass();
    $row->columns = array();
    
    foreach( $row_old['columns'] as $column ) {
        $row->columns[] = generate_column( $column, $row_id );
    }
    return array( $row );
}

function generate_column( $column_old, $row_id ) {
    $column = new stdClass();
    $column_id = 'column_' . generate_id();
    
    $column->width = get_column_width( $column_old['type'] );
    $column->parent = $row_id;
    $column->type = 'column';
    $column->id = $column_id;
    $column->settings = new stdClass();
    $column->modules = array();
    
    foreach( $column_old['modules'] as $module ) {
        $column->modules[] = generate_module( $module, $column_id );
    }
    
    return $column;
}

function get_column_width( $type ) {
    
    $types = array(
        'col_11' => 12,
        'col_12' => 6,
        'col_13' => 4,
        'col_14' => 3,
        'col_16' => 2,
        'col_23' => 8,
        'col_34' => 9,
        'col_56' => 10,
        'col_s11' => 11,
        'col_s7' => 7,
        'col_s5' => 5,
        'col_s1' => 1
    );
    
    return $types[$type];
}

function generate_module( $module_old, $column_id ) {
    $module = new stdClass();
    $module_id = 'module_' . generate_id();
    
    $module->module_type = get_module_type( $module_old['type'] );
    $module->module_tag = get_module_type( $module_old['type'] );
    $module->instance = (object)$module_old['instance'];
    $module->title = $module_old['module_name'];
    $module->parent = $column_id;
    $module->type = 'module';
    $module->id = $module_id;
    
    return $module;
}

function get_module_type( $type ) {
    $types = array(
    );
    
    return isset( $types[$type] ) ? $types[$type] : $type;
}

function get_module_tag( $type ) {
    $types = array(
    );
    
    return isset( $types[$type] ) ? $types[$type] : $type;
}
print_r($new_data);
//print_r($rows);
exit;
?>