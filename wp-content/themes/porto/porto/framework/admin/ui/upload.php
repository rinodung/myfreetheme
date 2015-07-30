<?php
/**
 * Upload OptionType
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

function spyropress_ui_upload( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    ob_start();

    // collecting attributes
    $atts = array();
    $atts['class'] = 'field upload' . ( ( $value != '' ) ? ' has-file' : '' );
    $atts['type'] = 'text';
    $atts['id'] = esc_attr( $id );
    $atts['name'] = esc_attr( $item['name'] );
    $atts['value'] = esc_attr( $value );

    echo '<div ' . build_section_class( 'section-upload', $item ) . '>';
        build_heading( $item, $is_widget );
        build_description( $item );
        echo '<div class="controls">';
            echo '<div class="uploader clearfix">';
                printf( '<input%s />', spyropress_build_atts( $atts ) );
                printf( '<input class="upload_button button-secondary" type="button" value="%2$s" id="upload_%1$s" />', $id, __( 'Upload', 'spyropress' ) );
                if ( is_array( @getimagesize( $value ) ) ) {
                    echo '<div class="screenshot" id="' . $id . '_image">';
                    if ( '' != $value ) {
                        $remove = '<a href="javascript:(void);" class="remove-media">' . __( 'Remove', 'spyropress' ) . '</a>';
                        $image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $value );
                        if ( $image ) {
                            echo '<img src="' . $value . '" alt="" />' . $remove;
                        }
                        else {
                            $parts = explode( '/', $value );
                            for( $i = 0; $i < sizeof($parts); ++$i ) {
                                $title = $parts[$i];
                            }
                            echo '<div class="no_image"><a href="' . $value . '">' . $title . '</a>' . $remove . '</div>';
                        }
                    }
                    echo '</div>';
                }
            echo '</div>';
        echo '</div>';
    echo '</div>';

    $ui_content = ob_get_clean();
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function spyropress_widget_upload( $item, $id, $value, $is_builder ) {
    return spyropress_ui_upload( $item, $id, $value, true, $is_builder );
}

/**
 * Gallery OptionType
 */
function spyropress_ui_gallery( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    ob_start();

    // collecting attributes
    $atts = array();
    $atts['class'] = 'gallery_shortcode' . ( ( $value != '' ) ? ' has-file' : '' );
    $atts['type'] = 'hidden';
    $atts['id'] = esc_attr( $id );
    $atts['name'] = esc_attr( $item['name'] );
    $atts['value'] = esc_attr( $value );
    
    $ids = explode( ',', $value );

    echo '<div ' . build_section_class( 'section-gallery section-full', $item ) . '>';
        printf( '<input class="gallery_reset_button button-red button-large pull-right" type="button" value="%s" /> ', __( 'Clear Gallery', 'spyropress' ) );
        printf( '<input class="gallery_upload_button button button-primary button-large right" type="button" value="%2$s" id="upload_%1$s" />', $id, __( 'Add/Edit Gallery', 'spyropress' ) );
        build_heading( $item, $is_widget );
        build_description( $item );
        echo '<div class="controls">';
            echo '<div class="gallery_holder clearfix">';
            
            foreach( $ids as $id ) {
                printf( '<div data-id="%1$s" class="gallery-item">%2$s</div>', $id, wp_get_attachment_image( $id ) );
            }
            
            echo '</div>';
            printf( '<input%s />', spyropress_build_atts( $atts ) );
        echo '</div>';
    echo '</div>';

    $ui_content = ob_get_clean();
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function spyropress_widget_gallery( $item, $id, $value, $is_builder ) {
    return spyropress_ui_gallery( $item, $id, $value, true, $is_builder );
}
?>