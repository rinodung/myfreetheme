<?php
/**
 * Typography OptionType
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

function spyropress_ui_typography( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    ob_start();

    // setting default values
    $color = $cp_style = $tsc_style = '';
    $defaults = array(
        'font-size' => '0px',
        'line-height' => '0px',
        'letter-spacing' => '0px',
        'text-hshadow' => '0px',
        'text-vshadow' => '0px',
        'text-blur' => '0px',
        'use' => 0,
        'font-family' => '',
        'font-style' => '',
        'font-weight' => '',
        'font-decoration' => '',
        'font-transform' => '',
        'font-google' => '',
        'font-google-variant' => '',
        'color' => '',
        'text-shadowcolor' => ''
    );
    $value = wp_parse_args( $value, $defaults );

    // getting values
    if( $value['color'] )
        $cp_style = sprintf(' style="background:%1$s;border-color:%1$s"', $value['color']);
    if( $value['text-shadowcolor'] )
        $tsc_style = sprintf(' style="background:%1$s;border-color:%1$s"', $value['text-shadowcolor']);
?>
    <div id="<?php echo $id; ?>" <?php echo build_section_class( 'section-typography section-full', $item ); ?>>
        <?php build_heading( $item, $is_widget ); ?>
        <?php build_description( $item ); ?>
        <div class="controls">
        <?php
            // label for use google font
            printf('
                <label class="checkbox" for="%1$s-use">
                    <input type="checkbox" id="%1$s-use" name="%2$s[use]" value="1" %3$s />'. __( 'Use Google Fonts Instead', 'spyropress' ).
                '</label>
            ', $id, $item['name'], checked($value['use'], 1, false));
        ?>
            <div class="row-fluid">
                <div class="span6">
                    <div class="pb10 web-font">
                        <strong class="sub"><?php _e( 'Font Family', 'spyropress' ); ?></strong>
                        <select name="<?php echo $item['name']; ?>[font-family]" class="chosen-typo" data-placeholder="<?php esc_attr_e( 'Select Font', 'spyropress' ); ?>" data-css="font-family">
                        <?php
                            foreach ( spyropress_panel_font_families() as $key => $family )
                                render_option(esc_attr( $key ), esc_html( $family ), array( $value['font-family'] ));
                        ?>
                        </select>
                    </div>
                    <div class="pb10 web-font row-fluid">
                        <div class="span6">
                            <select name="<?php echo $item['name']; ?>[font-style]" class="chosen-typo" data-placeholder="<?php esc_attr_e( 'Font Style', 'spyropress' ); ?>" data-css="font-style">
                            <?php
                                foreach ( spyropress_panel_font_styles() as $key => $style )
                                    render_option(esc_attr( $key ), esc_html( $style ), array( $value['font-style'] ));
                            ?>
                            </select>
                        </div>
                        <div class="span6">
                            <select name="<?php echo $item['name']; ?>[font-weight]" class="chosen-typo" data-placeholder="<?php esc_attr_e( 'Font Weight', 'spyropress' ); ?>" data-css="font-weight">
                            <?php
                                foreach ( spyropress_panel_font_weights() as $key => $weight )
                                    render_option(esc_attr( $key ), esc_html( $weight ), array( $value['font-weight'] ));
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="pb10 google-font">
                        <strong class="sub"><?php _e( 'Google Webfont Family', 'spyropress' ); ?></strong>
                        <select id="<?php echo $id; ?>-google" name="<?php echo $item['name']; ?>[font-google]" class="chosen-google-typo" data-placeholder="<?php esc_attr_e( 'Google Webfont', 'spyropress' ); ?>" data-selected="<?php echo $value['font-google']; ?>">
                        </select>
                    </div>
                    <div class="pb10 google-font">
                        <strong class="sub"><?php _e( 'Google Webfont Variants', 'spyropress' ); ?></strong>
                        <select id="<?php echo $id; ?>-google-variant" name="<?php echo $item['name']; ?>[font-google-variant]" class="chosen-google-variant" data-placeholder="<?php esc_attr_e( 'Google Webfont Variants', 'spyropress' ); ?>" data-selected="<?php echo $value['font-google-variant']; ?>">
                        </select>
                    </div>
                </div>
                <div class="span6">
                    <div class="color-picker pb10 clearfix">
                        <strong class="sub">&nbsp;</strong>
                        <input type="text" class="field" name="<?php echo $item['name']; ?>[color]" id="<?php echo $id; ?>-colorpicker" value="<?php echo $value['color']; ?>" />
                        <div class="color-box"><div<?php echo $cp_style; ?>></div></div>
                    </div>
                    <div class="pb10 range-slider">
                        <strong class="sub"><?php _e( 'Font Size:', 'spyropress' ); ?> <span><?php echo $value['font-size']; ?></span></strong>
                        <div data-css="font-size" id="<?php echo $id; ?>-fontsize" class="slider"></div>
                        <input type="hidden" name="<?php echo $item['name']; ?>[font-size]" id="<?php echo $id; ?>-fontsize-value" value="<?php echo $value['font-size']; ?>" />
                    </div>
                </div>
            </div>
            <div id="<?php echo $id; ?>-preview" class="font-preview" style="<?php spyropress_font_preview($value); ?>">
                <?php _e( 'Pack my box with five dozen liquor jugs.<br />The quick brown fox jumps over the lazy dog.', 'spyropress' ); ?>
            </div>
        </div>
        <div class="clear"></div>
        <a href="#" class="advance-settings"><?php _e( 'Advance Settings', 'spyropress' ); ?></a>
        <div class="controls" style="display: none;">
            <div class="row-fluid">
                <div class="span3">
                    <select name="<?php echo $item['name']; ?>[font-decoration]" class="chosen-typo" data-placeholder="<?php esc_attr_e( 'Text Decoration', 'spyropress' ); ?>" data-css="text-decoration">
                    <?php
                        foreach ( spyropress_panel_font_decoration() as $key => $decoration )
                            render_option(esc_attr( $key ), esc_html( $decoration ), array( $value['font-decoration'] ));
                    ?>
                    </select>
                </div>
                <div class="span3">
                    <select name="<?php echo $item['name']; ?>[font-transform]" class="chosen-typo" data-placeholder="<?php esc_attr_e( 'Text Transform', 'spyropress' ); ?>" data-css="text-transform">
                    <?php
                        foreach ( spyropress_panel_font_transform() as $key => $transform )
                            render_option(esc_attr( $key ), esc_html( $transform ), array( $value['font-transform'] ));
                    ?>
                    </select>
                </div>
                <div class="span3 range-slider">
                    <strong class="sub"><?php _e( 'Line Height:', 'spyropress' ); ?> <span><?php echo $value['line-height']; ?></span></strong>
                    <div data-css="line-height" id="<?php echo $id; ?>-linehight" class="slider"></div>
                    <input type="hidden" name="<?php echo $item['name']; ?>[line-height]" id="<?php echo $id; ?>-lineheight-value" value="<?php echo $value['line-height']; ?>" />
                </div>
                <div class="span3 range-slider">
                    <strong class="sub"><?php _e( 'Letter Spacing:', 'spyropress' ); ?> <span><?php echo $value['letter-spacing']; ?></span></strong>
                    <div data-css="letter-spacing" id="<?php echo $id; ?>-letterspacing" class="slider"></div>
                    <input type="hidden" name="<?php echo $item['name']; ?>[letter-spacing]" id="<?php echo $id; ?>-letterspacing-value" value="<?php echo $value['letter-spacing']; ?>" />
                </div>
            </div>
            <br />
            <strong class="sub"><?php _e( 'Text-Shadow', 'spyropress' ); ?></strong>
            <div class="row-fluid">
                <div class="span3 range-slider">
                    <strong class="sub"><?php _e( 'h-Shadow:', 'spyropress' ); ?> <span><?php echo $value['text-hshadow']; ?></span></strong>
                    <div data-css="text-shadow" id="<?php echo $id; ?>-hshadow" class="slider"></div>
                    <input type="hidden" name="<?php echo $item['name']; ?>[text-hshadow]" id="<?php echo $id; ?>-hshadow-value" value="<?php echo $value['text-hshadow']; ?>" />
                </div>
                <div class="span3 range-slider">
                    <strong class="sub"><?php _e( 'v-Shadow:', 'spyropress' ); ?> <span><?php echo $value['text-vshadow']; ?></span></strong>
                    <div data-css="text-shadow" id="<?php echo $id; ?>-vshadow" class="slider"></div>
                    <input type="hidden" name="<?php echo $item['name']; ?>[text-vshadow]" id="<?php echo $id; ?>-vshadow-value" value="<?php echo $value['text-vshadow']; ?>" />
                </div>
                <div class="span3 range-slider">
                    <strong class="sub"><?php _e( 'Blur:', 'spyropress' ); ?> <span><?php echo $value['text-blur']; ?></span></strong>
                    <div data-css="text-shadow" id="<?php echo $id; ?>-blur" class="slider"></div>
                    <input type="hidden" name="<?php echo $item['name']; ?>[text-blur]" id="<?php echo $id; ?>-blur-value" value="<?php echo $value['text-blur']; ?>" />
                </div>
                <div class="span3 color-picker clearfix">
                    <input type="text" class="field shadow" name="<?php echo $item['name']; ?>[text-shadowcolor]" id="<?php echo $id; ?>-shadowcolor" value="<?php echo $value['text-shadowcolor']; ?>" />
                    <div class="color-box"><div<?php echo $tsc_style; ?>></div></div>
                </div>
            </div>
        </div>
    </div>
<?php

    /* content */
    $ui_content = ob_get_clean();
    /* js */
    $fontsize_value         = str_replace('px', '', $value['font-size']);
    $line_height_value      = str_replace('px', '', $value['line-height']);
    $letter_spacing_value   = str_replace('px', '', $value['letter-spacing']);
    $slider_hshadow_value   = str_replace('px', '', $value['text-hshadow']);
    $slider_vshadow_value   = str_replace('px', '', $value['text-vshadow']);
    $slider_blur_value      = str_replace('px', '', $value['text-blur']);

    $typo['colorpicker'] = array( $id.'-colorpicker', $id.'-shadowcolor' );
    $typo['slider'] = array (
        "#{$id}-fontsize"   => array ( 'range' => 'min', 'min' => 1, 'max' => 120, 'value' => (int)$fontsize_value ),
        "#{$id}-linehight"  => array ( 'range' => 'min', 'min' => 7, 'max' => 89, 'value' => (int)$line_height_value ),
        "#{$id}-letterspacing"  => array ( 'min' => -20, 'max' => 20, 'value' => (int)$letter_spacing_value ),
        "#{$id}-hshadow"  => array ( 'min' => -50, 'max' => 50, 'value' => (int)$slider_hshadow_value ),
        "#{$id}-vshadow"  => array ( 'min' => -50, 'max' => 50, 'value' => (int)$slider_vshadow_value ),
        "#{$id}-blur"  => array ( 'range' => 'min', 'min' => 0, 'max' => 100, 'value' => (int)$slider_blur_value )
    );

    $js = "panelUi.bind_typography( '{$id}', ".json_encode($typo).");";

    if($is_widget)  {
        if(!$is_builder)
            add_jquery_ready($js);
        else
            $ui_content .= sprintf( '<script type="text/javascript">%2$s//<![CDATA[%2$s %1$s %2$s//]]>%2$s</script>', $js, "\n" );
        return $ui_content;
    }
    else {
        echo $ui_content;
        add_jquery_ready($js);
    }
}

function spyropress_widget_typography( $item, $id, $value, $is_builder = false ) {
    return spyropress_ui_typography( $item, $id, $value, true, $is_builder );
}

/**
 * Generate style attribute for preview
 */
function spyropress_font_preview( $styles ) {
    if( $styles['color'] )
        echo 'color:'.$styles['color'].';';
    if( $styles['font-family'] )
        echo 'font-family:'.$styles['font-family'].';';
    if( $styles['font-weight'] )
        echo 'font-weight:'.$styles['font-weight'].';';
    if( $styles['font-transform'] )
        echo 'text-transform:'.$styles['font-transform'].';';
    if( $styles['font-style'] )
        echo 'font-style:'.$styles['font-style'].';';
    if( $styles['font-decoration'] )
        echo 'text-decoration:'.$styles['font-decoration'].';';
    if( $styles['font-size'] && $styles['font-size'] != '0px' )
        echo 'font-size:'.$styles['font-size'].';';
    if( $styles['line-height'] && $styles['line-height'] != '0px')
        echo 'line-height:'.$styles['line-height'].';';
    if( $styles['letter-spacing'] && $styles['letter-spacing'] != '0px' )
        echo 'letter-spacing:'.$styles['letter-spacing'].';';
    if( $styles['text-shadowcolor'] )
        echo 'text-shadow:'.$styles['text-hshadow'].' '.$styles['text-vshadow'].' '.$styles['text-blur'].' '.$styles['text-shadowcolor'].';';
}

/**
 * Font Families
 * @uses      apply_filters()
 */
function spyropress_panel_font_families() {
    return apply_filters( 'spyropress_font_families', array(
        ''          => '',
        'arial'     => __( 'Arial', 'spyropress' ),
        'georgia'   => __( 'Georgia', 'spyropress' ),
        'helvetica' => __( 'Helvetica', 'spyropress' ),
        'palatino'  => __( 'Palatino', 'spyropress' ),
        'tahoma'    => __( 'Tahoma', 'spyropress' ),
        'times'     => __( '"Times New Roman", sans-serif', 'spyropress' ),
        'trebuchet' => __( 'Trebuchet', 'spyropress' ),
        'verdana'   => __( 'Verdana', 'spyropress' )
    ));
}

/**
 * Font Weights
 */
function spyropress_panel_font_weights() {
    return array(
        ''          => '',
        'normal'    => __( 'Normal', 'spyropress' ),
        'bold'      => __( 'Bold', 'spyropress' ),
        'bolder'    => __( 'Bolder', 'spyropress' ),
        'lighter'   => __( 'Lighter', 'spyropress' ),
        '100'       => __( '100', 'spyropress' ),
        '200'       => __( '200', 'spyropress' ),
        '300'       => __( '300', 'spyropress' ),
        '400'       => __( '400', 'spyropress' ),
        '500'       => __( '500', 'spyropress' ),
        '600'       => __( '600', 'spyropress' ),
        '700'       => __( '700', 'spyropress' ),
        '800'       => __( '800', 'spyropress' ),
        '900'       => __( '900', 'spyropress' ),
        'inherit'   => __( 'Inherit', 'spyropress' )
    );
}

/**
 * Font Transform
 */
function spyropress_panel_font_transform() {
    return array(
        ''          => '',
        'none'          => __( 'None', 'spyropress' ),
        'uppercase'     => __( 'UpperCase', 'spyropress' ),
        'lowercase'     => __( 'LowerCase', 'spyropress' ),
        'capitalize'    => __( 'Capitalize', 'spyropress' )
    );
}

/**
 * Font Styles
 */
function spyropress_panel_font_styles() {
    return array(
        ''          => '',
        'normal'  => __( 'Normal', 'spyropress' ),
        'italic'  => __( 'Italic', 'spyropress' ),
        'oblique' => __( 'Oblique', 'spyropress' ),
        'inherit' => __( 'Inherit', 'spyropress' )
    );
}

/**
 * Font Decoration
 */
function spyropress_panel_font_decoration() {
    return array(
        ''          => '',
        'none'  => __( 'None', 'spyropress' ),
        'line-through'  => __( 'Line-Through', 'spyropress' ),
        'overline' => __( 'Overline', 'spyropress' ),
        'underline' => __( 'Underline', 'spyropress' ),
        'inherit' => __( 'Inherit', 'spyropress' )
    );
}
?>