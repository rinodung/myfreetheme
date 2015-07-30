<?php

/**
 * Spyropress Image
 * Functions available on both the front-end and admin.
 *
 * @author SpyroSol
 * @category Core
 * @package Spyropress
 *
 */

/**
 * Title		: Aqua Resizer
 * Version	: 1.1.6
 * Author	: Syamil MJ
 *
 * @param	string $url - (required) must be uploaded using wp media uploader
 * @param	int $width - (required)
 * @param	int $height - (optional)
 * @param	bool $crop - (optional) default to soft crop
 * @param	bool $single - (optional) returns an array if false
 * @uses		wp_upload_dir()
 * @uses		image_resize_dimensions() | image_resize()
 * @uses		wp_get_image_editor()
 *
 * @return str|array
 */

function spyropress_img_resizer( $args = array() ) {

    extract( $args );

    //define upload path & dir
    $upload_info = wp_upload_dir();
    $upload_dir = $upload_info['basedir'];
    $upload_url = $upload_info['baseurl'];

    //check if $img_url is local
    if ( false === strpos( $url, $upload_url ) ) return false;

    //define path of image
    $rel_path = str_replace( $upload_url, '', $url );
    $img_path = $upload_dir . $rel_path;

    //check if img path exists, and is an image indeed
    if ( ! file_exists( $img_path ) or ! getimagesize( $img_path ) ) return false;

    //get image info
    $info = pathinfo( $img_path );
    $ext = $info['extension'];
    list( $orig_w, $orig_h ) = getimagesize( $img_path );

    //get image size after cropping
    $dims = image_resize_dimensions( $orig_w, $orig_h, $width, $height, $crop );
    $dst_w = $dims[4];
    $dst_h = $dims[5];

    //use this to check if cropped image already exists, so we can return that instead
    $suffix = "{$dst_w}x{$dst_h}";
    $dst_rel_path = str_replace( '.' . $ext, '', $rel_path );
    $destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

    if ( ! $dst_h ) {
        //can't resize, so return original url
        $img_url = $url;
        $dst_w = $orig_w;
        $dst_h = $orig_h;
    }
    //else check if cache exists
    elseif ( file_exists( $destfilename ) && getimagesize( $destfilename ) ) {
        $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
    }
    //else, we resize the image and return the new resized image url
    else {

        // Note: This pre-3.5 fallback check will edited out in subsequent version
        if ( function_exists( 'wp_get_image_editor' ) ) {

            $editor = wp_get_image_editor( $img_path );

            if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $width, $height, $crop ) ) )
                    return false;

            $resized_file = $editor->save();

            if ( ! is_wp_error( $resized_file ) ) {
                $resized_rel_path = str_replace( $upload_dir, '', $resized_file['path'] );
                $img_url = $upload_url . $resized_rel_path;
            }
            else {
                return false;
            }

        }
        else {

            $resized_img_path = image_resize( $img_path, $width, $height, $crop ); // Fallback foo
            if ( ! is_wp_error( $resized_img_path ) ) {
                $resized_rel_path = str_replace( $upload_dir, '', $resized_img_path );
                $img_url = $upload_url . $resized_rel_path;
            }
            else {
                return false;
            }

        }
    }

    //return the output
    if ( $single ) {
        //str return
        $image = $img_url;
    }
    else {
        //array return
        $image = array(
            0 => $img_url,
            1 => $dst_w,
            2 => $dst_h
        );
    }

    return $image;
}

/**
 * Get an HTML img element representing an image url
 *
 * This function retrieves/resizes the image to be used with the post in this order:
 *      1. Image Passed
 *      2. Custom Field (meta_key)
 *      3. Attachment ID
 *      4. WP Post Thumbnail
 *      5. First Attached Image
 *      6. Default Image
 *
 * @param   $args  Array with
 *          post_id     => current post id or pass and id
 *          auto_img    => if no image found automatically search in child attachments
 * image source
 *          url         => image passed using this variable
 *          key         => meta key used to get image3
 *          attachment  => image passed using this variable
 *
 * image options
 *          width   => Optional, the width of image | default is the settings of WP
 *          height  => Optional
 *          crop    => Optional, Whether to crop image or resize. | default is false
 *          retina  => Optional boolean for creating images that are double the width and height. | default is false
 *          single  => Optional, true for single url on return $image, false for Array | default is true
 *
 *  html option
 *          type    => Output type
 *              1. With anchor of original image (rel)
 *              2. With anchor of permalink (url)
 *              3. Without anchor (img)
 *              4. Image URL (src)
 *          before  => before html
 *          after   => after html
 *          echo    => return html or echo it | default is true
 *
 *  image attributes
 *          class   =>
 *          alt     =>
 *          title   =>
 */
function get_image( $args = array() ) {
    global $post;

    // set defaults
    $defaults = array(

        'post_id' => $post->ID,

        'url' => false,
        'key' => false,
        'attachment' => false,

        'width' => null,
        'height' => null,
        'crop' => null,
        'retina' => false,
        'single' => false,

        // html options
        'type' => 'img',
        'before' => '',
        'after' => '',
        'echo' => true,
        'responsive'  => true,

       // image attributes
        'class' => '',
        'alt' => '',
        'title' => '',

        // anchor attributes
        'href' => '',
        'rel' => 'lightbox',
        'link_class' => false,

        // theme options
        'auto_img' => get_setting( 'image_auto', false )
    );

    // set a filter for custom settings via plugin
    $args = wp_parse_args( $args, apply_filters( 'spyropress_img_resizer_args', $defaults ) );

    // Allow for different retina sizes
    $args['retina'] = $args['retina'] ? ( $args['retina'] === true ? 2 : $args['retina'] ) : 1;

    // validate inputs, set to integer
    $args['width'] = intval( $args['width'] * $args['retina'] );
    $args['height'] = intval( $args['height'] * $args['retina'] );

    $image_url = '';
    extract( $args );

    // Image passed # 1
    if ( ! empty( $args['url'] ) ) {
        if ( false === strpos( $args['url'], home_url() ) ) return false;

        $image_url = esc_url( $args['url'] );
    }
    // Custom Field # 2
    elseif ( empty( $image_url ) && ! empty( $args['key'] ) ) {

        // get image in custom field by meta key
        $img = get_post_meta( $post_id, $key, true );

        if ( ! empty( $img ) )
            $image_url = esc_url( $img );
    }
    // Attachment_ID # 3
    elseif ( empty( $image_url ) && ! empty( $args['attachment'] ) ) {

        // get image by attachment if
        $img = wp_get_attachment_url( $args['attachment'] );

        if ( ! empty( $img ) )
            $image_url = esc_url( $img );
    }
    // WP Post Thumbnail # 3
    elseif ( empty( $image_url ) && has_post_thumbnail( $post_id ) ) {

        // get thumbnail id
        $thumb_id = get_post_thumbnail_id( $post_id );

        // get image by attachment if
        $img = wp_get_attachment_url( $thumb_id );

        if ( ! empty( $img ) )
            $image_url = esc_url( $img );
        
        // Setting META
        $args['title'] = trim( strip_tags( get_post_field( 'post_title', $thumb_id ) ) );
        $args['alt'] = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
    }
    // Automatic Image Thumb
    // Check for an image by attachment # 5
    elseif ( empty( $image_url ) && $auto_img ) {
        // Get attachments for the inputted $post_id.
        $attachments = get_children( array(
            'post_parent' => $post_id,
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => 'ASC',
            'orderby' => 'menu_order ID',
            'suppress_filters' => true,
            'numberposts' => 1
        ) );

        // check any attachment
        if ( ! empty( $attachments ) ) {

            // loop through attachments
            foreach ( $attachments as $att_id => $attachment ) {
                $attachment_id = $att_id;
                break;
            }

            // Check if we have an attachment ID before proceeding.
            if ( ! empty( $attachment_id ) ) {

                // Get the attachment image
                $img = wp_get_attachment_url( $attachment_id, $size );
                $image_url = esc_url( $img );

                // Get the attachment excerpt
                $args['alt'] = trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );

            }
        }
    }
    // default image # 6
    elseif ( empty( $image_url ) ) {
        $image_url = get_placeholder_img_url();
    }

    // resize image now
    $args['url'] = $image_url;
    $image = spyropress_img_resizer( $args );

    // if no image returned
    if ( ! $image ) return false;

    /** Time to output **/
    if ( 'src' == $type ) return $image[0];

    // anchor attributes
    $anchor_html = false;
    if ( 'rel' == $type || 'url' == $type ) {

        $anchor_attr = array();

        if ( 'url' == $type ) {
            if ( is_single() ) {
                $href = $image_url;
            }
            else  $href = get_permalink( $post_id );
        }
        elseif ( 'rel' == $type ) {
            $href = $image_url;
        }

        $anchor_attr = array(
            'href' => $href,
            'rel' => $rel,
            'class' => $link_class );
        $anchor_attr = apply_filters( 'spyropress_image_anchor_args', spyropress_clean_array( $anchor_attr ) );

        $anchor_html = '<a ' . spyropress_build_atts( $anchor_attr ) . '>';
    }

    // set default image attributes
    list( $image[0], $image[1], $image[2] ) = $image;
    $width = ( $width ) ? $width : $image[1];
    $height = ( $height ) ? $height : $image[2];
    $hwstring = ( $responsive ) ?  '' : image_hwstring( $width, $height );

    $image_default_attr = array(
        'src' => $image[0],
        'class' => "attachment-{$image[1]}x{$image[2]}",
        'alt' => trim( strip_tags( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ) ), // Use Alt field first
        'title' => trim( strip_tags( get_the_title( $post_id ) ) ),
    );
    
    if ( empty( $image_default_attr['alt'] ) )
        $image_default_attr['alt'] = trim( strip_tags ( get_the_title() ) ); // Finally, use the title

    $image_attr = array(
        'class' => $args['class'],
        'alt' => $args['alt'],
        'title' => $args['title']
    );

    $image_attr = wp_parse_args( spyropress_clean_array( $image_attr ), $image_default_attr );
    $image_attr = array_map( 'esc_attr', $image_attr );

    // build html with attributes
    $html = '<img ' . trim( $hwstring ) . spyropress_build_atts( $image_attr ) . ' />';
    if ( $anchor_html )
        $html = $anchor_html . $html . '</a>';

    $html = wp_kses_post( $args['before'] ) . $html . wp_kses_post( $args['after'] );

    // Remove no height attribute - IE fix when no height is set
    $html = str_replace( 'height=""', '', $html );
    $html = str_replace( 'height="0"', '', $html );

    // finally!
    if ( $args['echo'] ) echo $html;
    else  return $html;
}

function get_placeholder_img_url( $width = 0, $height = 0 ) {
    $args = array(
        'bg' => get_setting( 'no_image_bg', '#eeeeee' ),
        'color' => get_setting( 'no_image_color', '#888888' ),
        'text' => get_setting( 'no_image_text', 'No Image Found' ),
        'width' => $width,
        'height' => $height
    );

    $args = apply_filters( 'spyropress_placeholder_img_args', spyropress_clean_array( $args ) );

    // Setting dimension
    $wh = wp_constrain_dimensions( 999, 999, $width, $height );
    $args['width'] = $wh[0];
    $args['height'] = $wh[1];

    $tmpl = 'holder.js/{width}x{height}/{bg}:{color}/text:{text}';

    return token_repalce( $tmpl, $args );
}

function get_gallery( $attr ) {
    global $post;

    // Allow plugins/themes to override the default gallery template.
    $output = apply_filters( 'post_gallery', '', $attr );
    if ( $output != '' )
        return $output;

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {

		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );

		if ( ! $attr['orderby'] )
			unset( $attr['orderby'] );
	}

    extract( shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'captiontag' => 'figcaption',
		'include'    => '',
		'exclude'    => '',

		// new for resizer
		'width'      => '',
		'height'     => NULL,
        'before'     => '',
        'after'     => '',
        'before_image' => '<li>',
        'after_image' => '</li>'

	), $attr ) );

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

   $attachments = get_children( array(
		'post_parent'    => $id,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => $order,
		'orderby'        => $orderby,
        'include'        => $include,
        'exclude'        => $exclude
	) );

	if ( empty( $attachments ) ) return '';

    if (is_feed()) {
        $output = "\n";
        foreach ($attachments as $att_id => $attachment) {
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        }
        return $output;
    }

    $output = '';
    $i = 0;

    foreach ( $attachments as $id => $attachment ) {
        $image = get_image(array(
            'attachment' => $id,
            'echo' => false,
            'width' => $width,
            'responsive' => true
        ));
        $output .=  wp_kses_post( $before_image ) . $image;
        if (trim($attachment->post_excerpt)) {
            $output .= '<' . $captiontag . '>' . wptexturize($attachment->post_excerpt) . '</' . $captiontag . '>';
        }
        $output .= wp_kses_post( $after_image );
    }

    return wp_kses_post( $before ) . $output . wp_kses_post( $after );
}
?>