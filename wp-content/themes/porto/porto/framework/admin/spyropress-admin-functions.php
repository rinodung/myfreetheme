<?php

/**
 * SpyroPress Admin Functions
 *
 * Functions available on admin-end.
 *
 * @package		Spyropress
 * @category	Admin
 * @author		SpyroSol
 */

/** SpyroPress Admin Helper *****************************************************/

function get_company_link() { return 'http://spyropress.com'; }
function get_themeforest_username() { return 'spyropress'; }
function get_documentation_link( $text = '' ) { $text = ( $text ) ? $text : __( 'Documentation', 'spyropress' ); echo '<a target="_blank" href="http://spyropress.com/codex/">' . $text . '</a>'; }
function get_support_forum_link( $text = '' ) { $text = ( $text ) ? $text : __( 'Forum', 'spyropress' ); echo '<a target="_blank" href="http://spyropress.com/forums/">' . $text . '</a>'; }
function get_suggest_link() { echo '<a target="_blank" href="http://spyropress.com/contact/">' . __( 'Suggest a Feature', 'spyropress' ) . '</a>'; }
function get_showcase_link() { echo '<a target="_blank" href="http://spyropress.com/contact/">' . __( 'Showcase your Website', 'spyropress' ) . '</a>'; }

/** Message Helper **/
function add_message( $message = '', $heading = '', $type = 'success' ) {
    global $spyropress;

    if ( ! $message )
        return;

    $heading = ( ! $heading ) ? '' : "<strong>$heading</strong> ";

    switch ( $type ) {
        case 'error':
            $spyropress->admin->add_error( $heading . $message );
            break;
        case 'notice':
            $spyropress->admin->add_notice( $heading . $message );
            break;
        case 'success':
            $spyropress->admin->add_success( $heading . $message );
            break;
    }
}
function add_success_message( $message = '', $heading = '' ) { add_message( $message, $heading, 'success' ); }
function add_error_message( $error = '', $heading = '' ) { add_message( $error, $heading, 'error' ); }
function add_notice_message( $notice = '', $heading = '' ) { add_message( $notice, $heading, 'notice' ); }

function add_message_section( $heading = '', $type = 'success' ) {
    global $spyropress;

    if ( ! $heading )
        return;

    $heading = "<h3 class=\"message-sub-header\">$heading</h3>";

    switch ( $type ) {
        case 'error':
            $spyropress->admin->add_error( $heading );
            break;
        case 'notice':
            $spyropress->admin->add_notice( $heading );
            break;
        case 'success':
            $spyropress->admin->add_success( $heading );
            break;
    }
}
function add_success_section( $heading = '' ) { add_message_section( $heading, 'success' ); }
function add_error_section( $heading = '' ) { add_message_section( $heading, 'error' ); }
function add_notice_section( $heading = '' ) { add_message_section( $heading, 'notice' ); }

/** Admin SpyroPress Pages Functions *******************************************/

// Spyropress Badge
function get_spyropress_badge( $class = '' ) {
    printf( '<div class="wp-badge%2$s">' . __( 'Version %1$s', 'spyropress' ) . '</div>', spyropress_get_version(), ( $class ) ? ' ' . $class : '' );
}

/** Theme Upgrader Functions **/
function spyropress_get_theme_changelog() { global $spyropress; return $spyropress->api->get_theme_changelog(); }
function spyropress_get_framework_changelog() { global $spyropress; return $spyropress->api->get_framework_changelog(); }
function is_theme_updateable() {
    global $spyropress;
    $xml = $spyropress->api->get_theme_changelog();

    if ( ! empty( $xml ) && version_compare( $spyropress->theme_version, $xml->latest ) == -1 )
        return true;

    return false;
}
function spyropress_get_theme_update_notice( $theme_name, $theme_version, $latest_version ) {

    echo '<ul class="spyropress-messages spyropress-notices">';
    echo '<li>' . sprintf( __( '<strong>There is a new version of the %s theme available.</strong> You have version %s installed. Update to version %s',
        'spyropress' ), $theme_name, $theme_version, $latest_version ) . '</li>';
    echo '</ul>';
}

/** Hook Functions *******************************************/

/**
 * Email From and Name
 */
function spyropress_mail_from( $old ) {
    $new = get_setting( 'mail_from_email' );
    return ( '' != $new ) ? $new : $old;
}

function spyropress_mail_from_name( $old ) {
    $new = get_setting( 'mail_from_name' );
    return ( '' != $new ) ? $new : $old;
}

/**
 * Remove dashboard widgets from admin area
 */
function spyropress_remove_dashboard_widgets() {

    $boxes = array(
        'dashboard_incoming_links', // incoming links
        'dashboard_plugins', // plugins
        'dashboard_primary', // wordpress blog
        'dashboard_secondary', // other wordpress news
        'dashboard_browser_nag' // Disable browser upgrade notification / warning
    );

    foreach ( $boxes as $box )
        remove_meta_box( $box, 'dashboard', 'normal' );
}

/**
 * Remove default metaboxes from edit screens
 */
function spyropress_remove_default_metaboxes( $hidden, $screen ) {
    if ( 'post' == $screen->base || 'page' == $screen->base )
        $hidden = array(
            'slugdiv',
            'pageslugdiv',
            'trackbacksdiv',
            'commentstatusdiv',
            'pagecommentstatusdiv',
            'commentsdiv',
            'authordiv',
            'pageauthordiv',
            'revisionsdiv',
            'postcustom',
            'postexcerpt'
        );

    return $hidden;
}

/**
 * Media Uploader
 */
function allow_img_insertion( $vars ) {
    $vars['send'] = true; // 'send' as in "Send to Editor"
    return ( $vars );
}

/**
 * Add Wp-Editor to Widget Page
 */
function dummy_editor() {
    echo '<div class="hidden">';
    wp_editor( '', 'dummy_editor' );
    echo '</div>';
}

/** tiny_mce Options *****************************************************/
function spyropress_enable_more_buttons( $buttons ) {
    $buttons[] = 'copy,cut,paste,hr,sub,sup';
    return $buttons;
}

function spyropress_change_mce_options( $option ) {

    $ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src]';

    if ( isset( $initArray['extended_valid_elements'] ) )
        $option['extended_valid_elements'] .= ',' . $ext;
    else
        $option['extended_valid_elements'] = $ext;

    return $option;
}

/** Shortcode Generator Buttons *****************************************/
function spyropress_init_tinymce_plugins() {

    if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) )
        return;

    if ( 'true' == get_user_option( 'rich_editing' ) ) {
        add_filter( 'mce_external_plugins', 'spyropress_add_tinymce_plugins' );
        add_filter( 'mce_buttons', 'spyropress_register_tinymce_buttons' );
    }
}

function spyropress_add_tinymce_plugins( $plugin_array ) {
    
    $plugin_array['spyropressImage'] = framework_assets_js() . 'editor-image.js';
    $plugin_array['code'] = framework_assets_js() . 'source_editor.js';
    
    if( current_theme_supports( 'spyropress-shortcode-generator' ) ) {
        global $wp_version;
        if( $wp_version < 3.9 ) {
            $plugin_array['spyropressShortcodes'] = include_url() . 'shortcodes/editor-shortcode.js';
        }
        else {
            $plugin_array['spyropressShortcodes'] = include_url() . 'shortcodes/editor-shortcode-39.js';
        }
    }
    
    return $plugin_array;
}

function spyropress_register_tinymce_buttons( $buttons ) {
    
    array_push( $buttons, '|', 'spyropress_image', 'code' );
    
    if( current_theme_supports( 'spyropress-shortcode-generator' ) ) {
        array_push( $buttons, "|", 'spyropress_shortcodes' );
    }
    
    return $buttons;
}

/** Custom Post Type Functions *****************************************/

/**
 * Include custom post types in "Right Now" admin dashboard widget
 */
function spyropress_right_now_content() {

    $post_types = get_post_types( array( '_builtin' => false ), 'objects' );
    foreach ( $post_types as $post_type ) {
        
        $num_posts = wp_count_posts( $post_type->name );
		if ( $num_posts && $num_posts->publish ) {
			$text = _n( $post_type->labels->singular_name, $post_type->labels->name, intval( $num_posts->publish ) );
			$text = number_format_i18n( $num_posts->publish ) . ' ' . $text;
			//$post_type_object = get_post_type_object( $post_type );
			if ( $post_type && current_user_can( $post_type->cap->edit_posts ) ) {
				printf( '<li class="page-count"><a href="edit.php?post_type=%1$s">%2$s</a></li>', $post_type->name, $text );
			} else {
				printf( '<li class="page-count"><span>%2$s</span></li>', $post_type->name, $text );
			}

		}
    }
}

/** SpyroPress Panel Methods *****************************************************/

/**
 * Generate section css class
 */
function build_section_class( $class = '', $item, $base_class = 'section' ) {

    $all = array();
    $all[] = $base_class;

    if ( ! empty( $class ) )
        $all[] = $class;

    if ( isset( $item['class'] ) && ! empty( $item['class'] ) )
        $all[] = $item['class'];

    return 'class="' . spyropress_clean_cssclass( $all ) . '"';
}

/**
 * Output Heading
 */
function build_heading( $item, $is_label = false ) {

    // h3 tag
    if ( isset( $item['label'] ) && $item['label'] && ! $is_label )
        printf( '<h3 class="heading">%s</h3>', htmlspecialchars_decode( $item['label'] ) );

    // label tag
    elseif ( isset( $item['label'] ) && $item['label'] && $is_label )
        printf( '<label class="heading" for="%s">%s</label>', $item['id'], htmlspecialchars_decode( $item['label'] ) );
}

/**
 * Output Reset button for section
 */
function build_section_reset() {
    echo '<a href="#" class="section-reset">' . __( 'Reset', 'spyropress' ) . '</a>';
}

/**
 * Output Section description
 */
function build_description( $item ) {
    if ( isset( $item['desc'] ) && $item['desc'] != '' )
        echo '<div class="description">' . htmlspecialchars_decode( $item['desc'] ) . '</div>';
}

/**
 * Setup Options
 *
 * Makes the registered theme option setup with default values when the theme is activated first time.
 */
function spyropress_setup_options() {

    // Get theme-supported options
    $registered_options = get_theme_support( 'spyropress-options' );

    // If there is no options, return
    if ( empty( $registered_options ) ) return;

    // setup options default settings
    foreach( $registered_options[0] as $option => $option_meta ) {

        // option key
        $key = "spyropress_{$option}_settings";

        spyropress_setup_options_default( $key );

    } // foreach_loop_registered_options
}

/**
 * Setup Default Options
 */
function spyropress_setup_options_default( $key ) {
    global $spyropress;
    
    // Check for define
    if ( isset( $GLOBALS[$key] ) ) {

        // Get options from Global
        $options = $GLOBALS[$key];

        // Update EMPTY options
        $defaults = $sections = array();
        delete_option( $key );
        add_option( $key, $defaults );

        foreach ( $options as $group ) {
            foreach ( $group as $section ) {
                // if item type in exlude list
                if( !in_array( $section['type'], spyropress_exclude_option_types() ) ) {
                    // if default value is set and section got an id
                    if ( isset( $section['std'] ) && isset( $section['id'] ) ) {

                        // section id
                        $option_key = trim( $section['id'] );

                        // section default value
                        $defaults[$option_key] = spyropress_validate_setting( $section['std'], $section['type'], $option_key, $section );
                        $sections[$option_key] = $section;
                    }
                }
            }
        }

        update_option( $key . $spyropress->lang, $defaults );
    }
}

/**
 * Excluded Option Types
 */
function spyropress_exclude_option_types() {
    return array(
        'heading',
        'sub_heading',
        'info',
        'raw_info',
        'include',
        'row',
        'row_end',
        'col',
        'col_end',
        'toggle',
        'toggle_end',
        'import',
        'export',
        'skin_generator'
    );
}

/**
 * Update Settings
 */
function spyropress_update_settings( $options ) {

    // check for null
    if( empty( $options ) ) return false;

    $new_values = $sections = $all_keys = array();

    foreach ( $options as $group ) {
        foreach ( $group as $section ) {
            // if item type in not in exclude list and setion got an id
            if(
                isset( $section['id'] ) &&
                !in_array( $section['type'], spyropress_exclude_option_types() )
            ) {
                // section id
                $key = trim( $section['id'] );
                $all_keys[] = $key;
                $sections[$key] = $section;

                if ( isset( $_POST[$key] ) && ! empty( $_POST[$key] ) ) {

                    $type = $section['type'];
                    $new_value = $_POST[$key];
                    $new_values[$key] = spyropress_validate_setting( $new_value, $type, $key, $section );
                } // if_value_set_and_not_empty

            } //if_not_in_excluded_types

        } // foreach_sections

    } // foreach_groups

    return array(
        spyropress_clean_array( $new_values ),
        $sections,
        $all_keys
    );
}

/**
 * Validate the options by type before saving
 */
function spyropress_validate_setting( $value, $type, $field_id, $section ) {

    // check for null
    if ( ! $value || ! $type || ! $field_id ) return $value;

    // type = background
    if( 'repeater' == $type ) {

        // skip last dummy element
        array_pop( $value );
        // reset array indexes
        array_reindex( $value );

        // Validate Fields
        $new_values = array();
        $total = count( $value );
        
        for( $i = 0; $i < $total; $i++ ) {
            $raw_value = $value[$i];
            
            foreach( $section['fields'] as $field ) {
                
                if( isset( $field['id'] ) && isset( $raw_value[$field['id']] ) &&
                    !in_array( $field['type'], spyropress_exclude_option_types() )
                ) {
                    $key = trim( $field['id'] );
                    $type = $field['type'];
                    $new_value = $raw_value[$key];
                    $new_values[$i][$key] = spyropress_validate_setting( $new_value, $type, $key, $field );
                }
            }

            $new_values[$i] = spyropress_clean_array( $new_values[$i] );
        }

        $value = $new_values;
    }
    // type = background
    elseif( 'background' == $type ) {

        $value = spyropress_clean_array( $value );
        
        if( isset( $value['background-color'] ) )
            $value['background-color'] = spyropress_validate_setting( $value['background-color'], 'colorpicker', $field_id, $section );
        
        if (
            isset( $value['background-image'] ) ||
            isset( $value['background-pattern'] )
        ) {

            if( isset( $value['background-image'] ) )
                $value['background-image'] = spyropress_validate_setting( $value['background-image'], 'upload', $field_id, $section );
        }
    }
    // type = typography
    elseif( 'typography' == $type ) {

        $value = spyropress_clean_array( $value );

        // if using google fonts unset system fonts
        if( isset( $value['use'] ) ) {
            unset( $value['font-family'] );
            unset( $value['font-style'] );
            unset( $value['font-weight'] );
        }
        // if using system fonts unset google fonts
        else {
            unset( $value['font-google'] );
            unset( $value['font-google-variant'] );
        }

        if( isset( $value['color'] ) )
            $value['color'] = spyropress_validate_setting( $value['color'], 'colorpicker', $field_id, $section );

        if( isset( $value['font-size'] ) && $value['font-size'] == '0px' )
            unset( $value['font-size'] );

        if( isset( $value['line-height'] ) && $value['line-height'] == '0px' )
            unset( $value['line-height'] );

        if( isset( $value['letter-spacing'] ) && $value['letter-spacing'] == '0px' )
            unset( $value['letter-spacing'] );

        if( !isset( $value['text-shadowcolor'] ) || $value['text-shadowcolor'] == '' ) {
            unset( $value['text-hshadow'] );
            unset( $value['text-vshadow'] );
            unset( $value['text-blur'] );
            unset( $value['text-shadowcolor'] );
        }
    }
    // type = border
    elseif( 'border' == $type ) {

        $heads = array( 'top', 'right', 'bottom', 'left' );

        foreach( $heads as $h ) {

            // if empty unset
            if(
                // check width
                $value[ $h ] == '0px' || empty( $value[ $h ] ) ||
                // check style
                empty( $value[ $h . '-style' ] ) ||
                // check color
                empty( $value[ $h . '-color' ] )
            ) {
                unset( $value[ $h ] );
                unset( $value[ $h . '-style' ] );
                unset( $value[ $h . '-color' ] );
            }
            // if not empty validate
            else {
                $value[ $h . '-style' ] = spyropress_validate_setting( $value[ $h . '-style' ], 'text', $field_id, $section );
                $value[ $h . '-color' ] = spyropress_validate_setting( $value[ $h . '-color' ], 'colorpicker', $field_id, $section );
            }
        }
    }
    // type = padder
    elseif( 'padder' == $type ) {

        foreach( $value as $k => $v ) {
            if( $v == '0px')
                unset( $value[ $k ] );
        }
    }
    // type = colorpicker
    elseif( 'colorpicker' == $type ) {
        $value = stripslashes( sanitize_text_field( $value ) );
        $value = str_replace( '#', '', $value );

        if( !is_str_starts_with( 'rgb', $value ) )
            $value = '#' . $value;
    }
    elseif( 'textarea' == $type ) {
        $value = stripslashes( $value );
    }
    // type = css, text, textarea, editor
    elseif( in_array( $type, array( 'css', 'text', 'editor' ) ) ) {

        $value = stripslashes( wp_kses_post( $value ) );
    }
    // type remaining
    elseif( in_array( $type, array( 'upload', 'datepicker', 'hidden', 'range_slider' ) ) ) {
        $value = stripslashes( sanitize_text_field( $value ) );
    }

    return $value;
}

/**
 * Update Meta Boxes
 */
function spyropress_update_meta_box( $fields, $post_ID, $meta_key = false ) {

    $settings = spyropress_update_settings( $fields );

    if( $meta_key )
        delete_post_meta( $post_ID, $meta_key );
    else
        delete_all_post_meta( $settings[2], $post_ID );

    return $settings[0];
}

/**
 * Delete all previous post_meta by meta_key
 */
function delete_all_post_meta( $meta_keys, $post_ID ) {
    global $wpdb;

    // checks
    if ( empty( $meta_keys ) ) return;

    $query = "DELETE FROM $wpdb->postmeta WHERE post_id = $post_ID AND meta_key IN ( " . '\'' . implode( '\', \'', $meta_keys ) . '\'' . " )";
    $wpdb->query( $query );
}

/**
 * Save CSS for theme options
 */
function spyropress_save_css( $settings, $key ) {
    $url = wp_nonce_url( 'admin.php?page=spyropress-theme','spyropress-theme-options' );
    if ( false === ( $creds = request_filesystem_credentials( $url ) ) ) {
        return;
    }
    
    if( !WP_Filesystem( $creds ) )
        return;
    
    $insertion = spyropress_compile_dynamic_styles( $settings[1], $settings[0] );
    $result = spyropress_save_dynamic_file( $insertion );
    
    if( $result ) {
        update_option( 'spyropress_dynamic_css', false );
    }
    else {
        update_option( 'spyropress_dynamic_css', $insertion );
    }
}

/* OLD */
/**
 * Compile CSS
 */
function spyropress_compile_dynamic_styles( $settings, $values, $meta = false ) {
    
    global $spyropress, $wp_filesystem;

    // check
    if( empty( $settings ) || empty( $values ) ) return;

    // path to stylesheets
    $less_file = $spyropress->template_path . 'assets/css/dynamic.less';
    $css_file = dynamic_css_path() . 'dynamic.css';
    
    // no dir
    if( !$wp_filesystem->exists( dynamic_css_path() ) ) {
        $wp_filesystem->mkdir( untrailingslashit( dynamic_css_path() ) );
    }
    
    if ( !$wp_filesystem->is_readable( $less_file ) ) return;

    // get $insertion from dynamic.less
    $insertion = $wp_filesystem->get_contents( $less_file );
    $insertion = spyropress_normalize_css( $insertion );

    $regex = "/{{([a-zA-Z0-9\_\-\#\|\=]+)}}/";
    $fontFamilyNames = array();

    // Match custom CSS
    preg_match_all( $regex, $insertion, $matches );

    // Loop through CSS
    foreach ( $matches[0] as $option ) {

        $value = '';
        $option_marker = str_replace( array( '{{', '}}' ), '', $option );
        $option_array = explode( '|', $option_marker );
        $option_id = $option_array[0];
        $option_type = $settings[$option_id]['type'];

        if( !in_array( $option_type, spyropress_exclude_option_types() ) ) {

            // get the value
            if ( $meta ) {
                global $post;
                $value = get_post_meta( $post->ID, $option_id, true );
            }
            elseif ( isset( $values[$option_id] ) ) {
                $value = $values[$option_id];
            }

            if ( ! isset( $option_array[1] ) ) {
                $value = spyropress_generate_css_by_type( $value, $option_type, $settings[$option_id], $fontFamilyNames );
            }
            else {
                $value = $value[$option_array[1]];
            }

            // insert CSS, even if the value is empty
            if( is_string($value) )
                $insertion = stripslashes( str_replace( $option, $value, $insertion ) );
            else
                $insertion = stripslashes( str_replace( $option, '', $insertion ) );
        } // end if

    } // end foreach

    if ( ! empty( $fontFamilyNames ) ) {
        $r = update_option( '_spyropress_google_fontfamilies', array_unique( $fontFamilyNames ) );
    }
    
    return $insertion;
}

function spyropress_save_dynamic_file( $insertion ) {
    global $spyropress, $wp_filesystem;

    // check
    if( empty( $insertion ) ) {
        return false;
    }

    // path to stylesheets
    $less_file = $spyropress->template_path . 'assets/css/dynamic.less';
    $css_file = dynamic_css_path() . 'dynamic.css';
    
    // no dir
    if( !$wp_filesystem->exists( dynamic_css_path() ) ) {
        $wp_filesystem->mkdir( untrailingslashit( dynamic_css_path() ) );
    }
    
    if ( !$wp_filesystem->is_readable( $less_file ) && !$wp_filesystem->is_writable( $css_file ) ) {
        return false;
    }
    
    // get dynamic.css handler
    return $wp_filesystem->put_contents( $css_file, $insertion );
    
}

/**
 * Normalize CSS
 */
function spyropress_normalize_css( $css ) {

    // Normalize & Convert
    $css = str_replace( "\r\n", "\n", $css );
    $css = str_replace( "\r", "\n", $css );

    // Don't allow out-of-control blank lines
    return preg_replace( "/\n{2,}/", "\n\n", $css );
}

/**
 * Generate CSS by type
 */
function spyropress_generate_css_by_type( $value, $type, $section, &$fontFamilyNames = '' ) {

    // check for null
    if ( ! $value || ! $type ) return $value;

    // upload
    if( 'upload' == $type ) {
        $value = 'url("' . $value . '")';
    }
    // range_slider
    if( 'range_slider' == $type ) {
        $value .= 'px';
    }
    // padder
    elseif( 'padder' == $type && isset( $section['prop'] ) ) {
        $new_value = '';
        foreach ( $value as $k => $v )
            $new_value .= $section['prop'] . '-' . $k . ': ' . $v . ';';
        $value = $new_value;
    }
    // border
    elseif( 'border' == $type ) {
        $new_value = '';
        $heads = array( 'top', 'right', 'bottom', 'left' );

        foreach( $heads as $h ) {
            if( isset( $value[ $h ] ) ) {
                $new_value .= sprintf( 'border: %1$s %2$s %3$s;', $value[ $h ], $value[ $h . '-style' ], $value[ $h . '-color' ] );
            }
        }
        $value = $new_value;
    }
    // background
    elseif( 'background' == $type ) {
        $img = '';
        $bg = array();

        if ( isset( $value['background-color'] ) )
            $bg[] = $value['background-color'];

        if ( isset( $value['background-pattern'] ) )
            $img = $value['background-pattern'];
        elseif ( isset( $value['background-image'] ) )
            $img = $value['background-image'];
        if ( $img )
            $bg[] = 'url("' . $img . '")';

        if ( isset( $value['background-repeat'] ) )
            $bg[] = $value['background-repeat'];

        if ( isset( $value['background-attachment'] ) )
            $bg[] = $value['background-attachment'];

        if ( isset( $value['background-position'] ) )
            $bg[] = $value['background-position'];

        $value = ( !empty( $bg ) ) ? 'background: ' . join( ' ', $bg ) . ';' : '';
    }
    // typography
    elseif( 'typography' == $type ) {
        $font = array();
        
        // using google fonts
        if ( isset( $value['use'] ) ) {
            
            $font_name = $value['font-google'];
            $font[] = "font-family: '" . $font_name . "';";
            
            if ( isset( $value['font-google-variant'] ) ) {
                $variant = $value['font-google-variant'];
                $font_name = $font_name . ':' . $variant;
                if ( $variant == 'italic' )
                    $font[] = "font-style: italic;";
            }
            elseif ( $variant != 'regular' ) {
                $weight = substr( $variant, 0, 3 );
                $style = substr( $variant, 3 );
                $font[] = "font-weight: " . $weight . ";";
                if ( $style != '' )
                    $font[] = "font-style: " . $style . ";";
            }
            $fontFamilyNames[] = $font_name;
        }
        else {
            if ( isset( $value['font-family'] ) )
                $font[] = "font-family: '" . $value['font-family'] . "';";
            
            if ( isset( $value['font-style'] ) )
                $font[] = "font-style: " . $value['font-style'] . ";";
            
            if ( isset( $value['font-weight'] ) )
                $font[] = "font-weight: " . $value['font-weight'] . ";";
        }
        
        if ( isset( $value['color'] ) )
            $font[] = "color: " . $value['color'] . ";";
        
        if ( isset( $value['font-size'] ) )
            $font[] = "font-size: " . $value['font-size'] . ";";

        if ( isset( $value['font-decoration'] ) )
            $font[] = "text-decoration: " . $value['font-decoration'] . ";";

        if ( isset( $value['font-transform'] ) )
            $font[] = "text-transform: " . $value['font-transform'] . ";";

        if ( isset( $value['line-height'] ) || $value['line-height'] == '0px' )
            $font[] = "line-height: " . $value['line-height'] . ";";
        
        if ( isset( $value['letter-spacing'] ) || $value['letter-spacing'] == '0px' )
            $font[] = "letter-spacing: " . $value['letter-spacing'] . ";";

        if (
            isset( $value['text-shadowcolor'] ) && isset( $value['text-hshadow'] ) &&
            isset( $value['text-vshadow'] ) && isset( $value['text-blur'] )
        ) {
            $font[] = sprintf( 'text-shadow: %s %s %s %s;', $value['text-hshadow'], $value['text-vshadow'], $value['text-blur'], $value['text-shadowcolor'] );
        }
        
        $value = ( !empty( $font ) ) ? implode( "\n", $font ) : '';
    }
    // No fomatting required
    if( !in_array( $type, array( 'padder', 'border', 'background' ) ) ) {
        // Making css from section
        if( isset( $section['format'] ) )
            $value = sprintf( $section['format'], $value );
        elseif( isset( $section['prop'] ) )
            $value = sprintf( '%1$s: %2$s;', $section['prop'], $value );
    }

    if( isset( $section['selector'] ) ) {
        $value = sprintf( '%1$s { %2$s }', $section['selector'], $value );
    }

    return $value;
}

// Export SpyroPress Panel Options
function spyropress_export_options() {
    if ( !isset( $_POST['download_theme_options'] ) ) return;
    
    if( !isset( $_POST['download_what'] ) ) return;
    
    if ( isset( $_POST['export_settings_file_nonce'] ) && wp_verify_nonce( $_POST['export_settings_file_nonce'], 'export_settings_file_form' ) ) {
        spyropress_generate_option_export( $_POST['download_what'] );
    }
}

function spyropress_generate_option_export( $option_name = '' ) {
    
    global $spyropress;
    
    $data = $spyropress->options[$option_name . $spyropress->lang];
    $data = spyropress_encode( $data );
    
    // generating file name
    $blogname = str_replace( " ", "", get_option( 'blogname' ) );
    $date = date( "m-d-Y" );
    $json_name = $blogname . "-" . $date;
    
    //ob_clean();
    header( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
    header( "Pragma: no-cache ");
    header( "Content-Description: File Transfer" );
    header( 'Content-Disposition: attachment; filename="' . $json_name . '.txt"');
    header( "Content-Type: application/octet-stream");
    header( "Content-Transfer-Encoding: binary" );
    
    echo $data;
    die();
}

/**
 * Install Dummy Data
 */
function spyropress_install_dummy_data() {
    
    if( !current_user_can( 'manage_options' ) ) return;
    
    if( isset( $_GET['import-done'] ) && $_GET['import-done'] ) {
        add_success_message( 'Sucessfully imported demo data!' );
        return;
    }
    
    if( !isset( $_POST['import-dummy'] ) ) return;
    
    if( !isset( $_POST['security'] ) ) return;
    
    if( !wp_verify_nonce( $_POST['security'], 'spyropress-update-options' ) ) return;
    
    // Generate Option Key
    $key = 'spyropress_' . $_POST['setting_panel_name'];

    // Check for define
    if ( ! isset( $GLOBALS[$key] ) ) {
        _e( 'false', 'spyropress' );
        return;
    }

    // Doing import
    $importer = new SpyropressImporter( $key );

    // Allow developer to perform actions
    do_action( 'spyropress_import_' . $_POST['setting_panel_name'] );
    
    wp_safe_redirect( admin_url( 'admin.php?page=spyropress-theme&import-done=1') );
}