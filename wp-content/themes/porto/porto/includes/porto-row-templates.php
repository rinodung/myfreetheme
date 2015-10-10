<?php

/**
 * SpyroPress Builder
 * Porto builder row types
 */

/**
 * Map Row
 */
class map_row_class extends SpyropressBuilderRow {

    public function __construct() {

        $this->config = array(
            'name' => __( 'Map Row', 'spyropress' ),
            'description' => __( 'Map row', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/1col.png' ),
            'columns' => array(
                array( 'type' => 'col_11' )
            )
        );
    }
    
    function row_wrapper( $row_ID, $row ) {
        $section_class = array( 'map-section' );
        if( isset( $row['options']['custom_container_class'] ) && !empty( $row['options']['custom_container_class'] ) )
            $section_class[] = $row['options']['custom_container_class'];
    
        $row_html = sprintf( '
            <div id="%1$s" class="%2$s">
                <section class="featured_section footer map">
                    <div class="container">
                        <div class="%3$s">
                            %4$s
                        </div>
                    </div>
                </section>
            </div>', $row_ID, spyropress_clean_cssclass( $section_class ), get_row_class( true ), builder_render_frontend_columns( $row['columns'] )
        );
        
        return $row_html;
    }
}
spyropress_builder_register_row( 'map_row_class' );

/**
 * Map Row
 */
class gmap_row_class extends SpyropressBuilderRow {

    public function __construct() {

        $this->config = array(
            'name' => __( 'GoogleMap Row', 'spyropress' ),
            'description' => __( 'GoogleMap row', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/1col.png' ),
            'columns' => array(
                array( 'type' => 'col_11' )
            )
        );
    }
    
    function row_wrapper( $row_ID, $row ) {
        
        return builder_render_frontend_columns( $row['columns'] );
    }
}
spyropress_builder_register_row( 'gmap_row_class' );