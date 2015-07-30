<?php

/**
 * Shortcodes
 */

init_shortcode();
function init_shortcode() {

    $shortcodes = array(
        'lead'          => 'spyropress_sc_lead',
        'inverted'      => 'spyropress_sc_inverted',
        'alt_font'      => 'spyropress_sc_alt_font',
        'promo_img'     => 'spyropress_sc_promo_img',
        'button'        => 'spyropress_sc_button',
        'btn_link'      => 'spyropress_sc_link_button',
        'img'           => 'spyropress_sc_img',
        'label'         => 'spyropress_sc_label_badge',
        'badge'         => 'spyropress_sc_label_badge',
        'alerts'        => 'spyropress_sc_alerts',
        'bar'           => 'spyropress_sc_bar',
        'tooltip'       => 'spyropress_sc_tooltip',
        'lightbox'      => 'spyropress_sc_lightbox',
        'inline_list'   => 'spyropress_sc_list',
        'tables'        => 'spyropress_sc_tables',

        // New
        'rotate_words'  => 'spyropress_sc_rotate_words',
        'icon_list'     => 'spyropress_sc_icon_list',
        'blockquote'    => 'spyropress_sc_blockquote',
        'dropcap'       => 'spyropress_sc_dropcap',
        'unstyled_list' => 'spyropress_sc_list',
        'icon'          => 'spyropress_sc_icon',
		'animation'     => 'spyropress_sc_animation',
        
        /**
         * @since 2.9.0
         */
        'arrow'         => 'spyropress_sc_arrow'
    );

    foreach( $shortcodes as $tag => $func )
        add_shortcode( $tag, $func );
}

function spyropress_sc_arrow( $atts = array(), $content = '' ) {

    extract( shortcode_atts( array(
        'pos' => 'hlb'
    ), $atts ) );

    return '<span class="arrow ' . $pos . '"></span>';
}

function spyropress_sc_icon( $atts = array(), $content = '' ) {

    extract( shortcode_atts( array(
        'icon' => ''
    ), $atts ) );

    if( !$icon ) return '';

    return '<i class="fa ' . $icon . '"></i>';
}

function spyropress_sc_dropcap( $atts = array(), $content = '' ) {

    if( empty( $content ) ) return;

    extract( shortcode_atts( array(
        'style' => 's1'
    ), $atts ) );

    $styles = array(
        's1' => 'drop-caps',
        's2' => 'drop-caps secundary'
    );

    return '<p class="' . $styles[$style] . '">' . spyropress_remove_formatting( $content ) . '</p>';
}

function spyropress_sc_blockquote( $atts = array(), $content = '' ) {

    if( empty( $content ) ) return;

    extract( shortcode_atts( array(
        'author' => '',
        'source' => '',
        'style' => ''
    ), $atts ) );

    if( 's1' == $style ) {
        if( $author )
            $author = '<span>- ' . $author . '</span>';

        $count = 1;
        $content = do_shortcode( wpautop( $content ) );
        $content = str_replace( '<p>', '<p><i class="fa fa-quote-left"></i> ', $content, $count );
    }
    else {
        $content = do_shortcode( $content );
        $author = sprintf( '<small>%1$s <cite title="%2$s">%2$s</cite></small>', $author, $source );
    }

    return sprintf( '<blockquote>%1$s%2$s</blockquote>', $content, $author );
}

function spyropress_sc_icon_list( $atts = array(), $content = '' ) {

    if( empty( $content ) ) return;

    extract( shortcode_atts( array(
        'icon' => ''
    ), $atts ) );

    $content = str_replace( '<ul>', '<ul class="list icons list-unstyled">', $content );
    $content = str_replace( '<ol>', '<ol class="list icons list-unstyled">', $content );

    return str_replace( '<li>', '<li><i class="fa ' . $icon . '"></i> ', $content );
}

function spyropress_sc_rotate_words( $atts = array(), $content = '' ) {

    if( empty( $content ) ) return;

    $content = str_replace( ';', '</span><span>', spyropress_remove_formatting( $content ) );

    return '<span class="word-rotate"  data-plugin-options=\'{"delay": 2000}\'><span class="word-rotate-items"><span>' . $content . '</span></span></span>';
}

function spyropress_sc_lead( $atts = array(), $content = '' ) {

    if( empty( $content ) ) return;

    return '<p class="lead">' . spyropress_remove_formatting( $content ) . '</p>';
}

function spyropress_sc_animation( $atts = array(), $content = '' ) {

    if( empty( $content ) ) return;

    extract( spyropress_clean_array( shortcode_atts( array(
        'animation' => '',
        'tag' => 'div'
    ), $atts ) ) );

    return '<' . $tag . ' data-appear-animation="' . $animation . '">' . $content . '</' . $tag . '>';
}

function spyropress_sc_inverted( $atts = array(), $content = '' ) {

    if( empty( $content ) ) return;

    $atts = spyropress_clean_array( shortcode_atts( array(
        'animation' => ''
    ), $atts ) );

    return '<strong class="inverted"' . spyropress_build_atts( $atts, 'data-appear-' ) . '>' . spyropress_remove_formatting( $content ) . '</strong>';
}

function spyropress_sc_alt_font( $atts = array(), $content = '' ) {

    if( empty( $content ) ) return;

    $atts = spyropress_clean_array( shortcode_atts( array(
        'animation' => ''
    ), $atts ) );

    return '<span class="alternative-font"' . spyropress_build_atts( $atts, 'data-appear-' ) . '>' . spyropress_remove_formatting( $content ) . '</span>';
}

function spyropress_sc_promo_img( $atts = array(), $content = '' ) {

    if( empty( $content ) ) return;

    $atts = spyropress_clean_array( shortcode_atts( array(
        'animation' => 'fadeInRight'
    ), $atts ) );

    return '<div class="push-top"><img class="img-responsive" src="' . spyropress_remove_formatting( $content ) . '"' . spyropress_build_atts( $atts, 'data-appear-' ) . '></div>';
}

function spyropress_sc_button( $atts = array(), $content = '' ) {

    $default = array(
        'cls' => 'default',
        'size' => 'ds',
        'disabled' => false
    );

    extract( shortcode_atts( $default, $atts ) );

    $tmpl = '<button type="button" class="{class}" {disabled}>{content}</button>';

    $args['content'] = spyropress_remove_formatting( $content );

    //class
    $class = array();
    $class[] = 'btn';
    if( $cls ) $class[] = 'btn-' . $cls;
    if ( $size ) $class[] = 'btn-' . $size;
    if( $disabled ) $args['disabled'] = 'disabled';

    $args['class'] = spyropress_clean_cssclass( $class );

    return token_repalce( $tmpl, $args );
}

function spyropress_sc_link_button( $atts = array(), $content = '' ) {

    $default = array(
        'cls' => 'default',
        'extra_cls' => '',
        'size' => 'default',
        'disabled' => false,
        'url' => '#'
    );

    extract( shortcode_atts( $default, $atts ) );

    $tmpl = '<a href="{url}" class="{class}" {disabled}>{content}</a>';

    $args['content'] = spyropress_remove_formatting( $content );
    $args['url'] = esc_url( $url );

    //class
    $class = array();
    $class[] = 'btn';
    if( $cls ) $class[] = 'btn-' . $cls;
    if ( $size ) $class[] = 'btn-' . $size;
    if( $disabled ) $args['disabled'] = 'disabled';
    $class[] = $extra_cls;

    $args['class'] = spyropress_clean_cssclass( $class );

    return token_repalce( $tmpl, $args );
}

function spyropress_sc_img( $atts = array(), $content = '' ) {

    $default = array(
        'cls' => '',
        'alt' => '',
        'url' => ''
    );

    extract( shortcode_atts( $default, $atts ) );

    return '<img class="img-responsive img-' . $cls . '" alt="' . $alt . '" src="' . $url . '" />';
}

function spyropress_sc_label_badge( $atts = array(), $content = '', $sc ) {

    $default = array(
        'cls' => ''
    );
    extract( shortcode_atts( $default, $atts ) );

    // class
    $class = array();
    $class[] = $sc;
    if( $cls )
        $class[] = $sc . '-' . $cls;

    return sprintf( '<span class="%2$s">%1$s</span>', $content, spyropress_clean_cssclass( $class ) );
}

function spyropress_sc_alerts( $atts = array(), $content = '' ) {

    $default = array(
        'title' => '',
        'type' => 'warning',
        'close' => false,
        'fade' => false
    );
    extract(shortcode_atts($default, $atts));

    // Template
    $tmpl = '<div class="{class}">{close}{title}{content}</div>';
    $close_tmpl = '<button type="button" class="close" data-dismiss="alert">&times;</button>';

    $args['content'] = spyropress_remove_formatting( $content );

    if ( $title ) {
        $args['title'] = '<h4 class="alert-heading">' . $title . '</h4>';
        $args['content'] = wpautop( $args['content'] );
    }

    if ( $close ) $args['close'] = $close_tmpl;

    //class
    $class = array();
    $class[] = 'alert';
    if( $title ) $class[] = 'alert-block';
    if( $fade ) $class[] = 'fade in';
    if ( $type ) $class[] = 'alert-' . $type;

    $args['class'] = spyropress_clean_cssclass( $class );

    return token_repalce( $tmpl, $args );
}

function spyropress_sc_bar( $atts = array(), $content = '' ) {

    $default = array(
        'progress' => '60',
        'cls' => '',
        'animate' => false,
        'delay' => '',
        'style' => ''
    );
    extract( shortcode_atts( $default, $atts ) );

    //class
    $class = array( 'progress-bar' );
    if ( '' != $cls ) $class[] = 'progress-bar-' . $cls;

    // style
    $styles = array(
        'striped'   => 'progress-striped',
        'animated'  => 'progress-striped active'
    );

    $class2 = array( 'progress' );
    if ( '' != $style ) $class2[] = $styles[$style];


    $tmpl = '{label}<div class="{class2}"><div class="{class}"{animate}{delay}{width}>{title}{tooltip}</div></div>';

    $args = array(
        'label' => ( $content ) ? '<div class="progress-label"><span>' . $content . '</span></div>' : '',
        'class' => spyropress_clean_cssclass( $class ),
        'class2' => spyropress_clean_cssclass( $class2 ),
        'animate' => ( $animate ) ? ' data-appear-progress-animation="' . $progress . '%"' : '',
        'delay' => ( $delay ) ? ' data-appear-animation-delay="' . $delay . '"' : '',
        'tooltip' => ( $animate ) ? '<span class="progress-bar-tooltip">' . $progress . '%</span>' : '',
        'width' => ( !$animate ) ? ' style="width:' . $progress . '%;"' : '',
    );

    return token_repalce( $tmpl, $args );
}

function spyropress_sc_tooltip( $atts = array(), $content = '' ) {

    $default = array(
        'tip' => '',
        'position' => 'top'
    );
    extract( shortcode_atts( $default, $atts ) );

    // Template
    return '<a href="#" rel="tooltip" data-original-title="' . $tip . '" data-placement="' . $position . '" data-html="true">' . $content . '</a>';
}

function spyropress_sc_lightbox( $atts = array(), $content = '' ) {

    if( empty( $content ) ) return '';

    $default = array(
        'full' => '',
        'pull' => ''
    );
    extract( shortcode_atts( $default, $atts ) );

    if( $pull ) $pull = ' pull-' . $pull;

    // Template
    return '
    <a class="img-thumbnail lightbox' . $pull . '"	href="' . $full . '" data-plugin-options=\'{"type":"image"}\'>
        <img class="img-responsive" src="' . esc_url( $content ) . '">
        <span class="zoom">
            <i class="fa fa-search"></i>
        </span>
    </a>';
}

function spyropress_sc_list( $atts, $content = null, $tag ) {

    $tag = 'list-' . str_replace( '_list', '', $tag );
    $content = str_replace( '<ul>', '<ul class="' . $tag . '">', $content );
    $content = str_replace( '<ol>', '<ol class="' . $tag . '">', $content );

    return spyropress_remove_formatting( $content );
}

function spyropress_sc_tables($atts, $content = null) {

    $default = array(
        'cls' => '',
    );

    extract( shortcode_atts( $default, $atts ) );

    // class
    $class = array();
    $class[] = 'table';
    if ( $cls != '')
        $class[] = str_replace( ',', ' ', $cls );

    return str_replace( '<table', '<table class="' . spyropress_clean_cssclass( $class ) . '"', spyropress_remove_formatting( $content ) );
}