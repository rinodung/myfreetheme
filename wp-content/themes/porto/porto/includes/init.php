<?php

/**
 * Init Theme Related Settings
 */

/** Internal Settings **/
require_once 'version.php';

/**
 * Required and Recommended Plugins
 */
function spyropress_register_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        // Wordpress SEO
        array(
            'name'      => 'WordPress SEO by Yoast',
            'slug'      => 'wordpress-seo',
            'required'  => false,
        ),

        // Contact Form 7
        array(
            'name'      => 'Contact Form 7',
            'slug'      => 'contact-form-7',
            'required'  => false,
        ),
        
        // Revolution slider
        array(
            'name'      => 'Revolution Slider',
            'slug'      => 'revslider',
            'required'  => true,
            'source'    => get_template_directory() . '/includes/plugins/revslider.zip'
        ),
        
        // Breadcrumb NavXT
        array(
            'name'      => 'Breadcrumb NavXT',
            'slug'      => 'breadcrumb-navxt',
            'required'  => true,
            'source'    => get_template_directory() . '/includes/plugins/breadcrumb-navxt.zip'
        ),
    );

    tgmpa( $plugins );
}
add_action( 'tgmpa_register', 'spyropress_register_plugins' );

/**
 * Add modules and tempaltes to SpyroBuilder
 */
function spyropress_register_builder_modules( $modules ) {
    
    $path = dirname(__FILE__) . '/';
    
    include_once ( $path . 'porto-row-templates.php' );
    
    $modules[] = 'modules/about-me/about-me.php';
    $modules[] = 'modules/accordion/accordion.php';
    $modules[] = 'modules/blog/blog.php';
    $modules[] = 'modules/call-action/call-action.php';
    $modules[] = 'modules/counters/counters.php';
    $modules[] = 'modules/divider/divider.php';
    $modules[] = 'modules/feature-list/feature-list.php';
    $modules[] = 'modules/flickr-feed/flickr.php';
    $modules[] = 'modules/gmap/gmap.php';
    $modules[] = 'modules/heading/heading.php';
    $modules[] = 'modules/home-concept/home-concept.php';
    $modules[] = 'modules/html/html.php';
    $modules[] = 'modules/icon-list/icon-list.php';
    $modules[] = 'modules/our-clients/clients.php';
    $modules[] = 'modules/progress-bars/progress-bars.php';
    $modules[] = 'modules/recent-posts/recent-posts.php';
    $modules[] = 'modules/sidebar/sidebar.php';
    $modules[] = 'modules/sitemap/sitemap.php';
    $modules[] = 'modules/skills/skills.php';
    $modules[] = 'modules/slider/slider.php';
    $modules[] = 'modules/tabs/tabs.php';
    $modules[] = 'modules/teaser-content/teaser-content.php';
    $modules[] = 'modules/timeline/timeline.php';
    $modules[] = 'modules/toggle/toggle.php';
    
    return $modules;
}
add_filter( 'builder_include_modules', 'spyropress_register_builder_modules' );

/**
 * Define the row wrapper html
 */
function spyropress_row_wrapper( $row_ID, $row ) {
    
    extract( $row['options'] );
    
    $section_class = array();
    $parallax = $video = $mp4 = $ogg = '';
    
    // CssClass
    if( isset( $custom_container_class ) && !empty( $custom_container_class ) )
        $section_class[] = $custom_container_class;
    if( isset( $container_skin ) && !empty( $container_skin ) ) {
        $section_class[] = $container_skin;
        
        if( 'parallax' == $container_skin ) {
            $parallax = ' data-stellar-background-ratio="0.5" style="background-image: url(' . $parallax_bg . ');"';
        }
        
        if( 'video_section' == $container_skin ) {
            
            if( $video_mp4 ) {
                $mp4 = 'mp4: ' . $video_mp4 . ', ';
            }
            
            if( $video_ogg ) {
                $ogg = 'ogv: ' . $video_ogg . ', ';
            }
            
            if( $video_poster ) {
                $poster = 'poster: ' . $video_poster;
            }
            
            if( $video_mp4 || $video_ogg )
                $parallax = ' data-video-path="' . $mp4 . $ogg . $poster . '" data-plugin-video-background data-plugin-options=\'{"posterType": "' . end( explode( '.', $video_poster ) ) . '", "position": "50% 50%" }\'';
        }
    }
    
    $row_html = sprintf( '
        <div id="%1$s" class="%2$s"%5$s>
            <div class="container">
                <div class="%3$s">
                    %4$s
                </div>
            </div>
            %6$s
        </div>', $row_ID, spyropress_clean_cssclass( $section_class ), get_row_class( true ), builder_render_frontend_columns( $row['columns'] ), $parallax, $video
    );

    return $row_html;
}
add_filter( 'spyropress_builder_row_wrapper', 'spyropress_row_wrapper', 10, 2 );

/**
 * Include Widgets
 */
function spyropress_register_widgets( $widgets ) {
    
    $path = dirname(__FILE__) . '/widgets/';

    $custom = array(       
        $path . 'default-widgets.php',
        $path . 'contact-info/contact.php',
        $path . 'socials/socials.php',
        $path . 'tab-widget/tab-widget.php',
        $path . 'twitter/twitter.php'
    );

    return array_merge( $widgets, $custom );
}
add_filter( 'spyropress_register_widgets', 'spyropress_register_widgets' );

/**
 * Unregister Widgets
 */
function spyropress_unregister_widgets( $widgets ) {
    
    $custom = array(
        'WP_Widget_Archives',
        'WP_Widget_Categories',
        'WP_Widget_Recent_Comments',
        'WP_Nav_Menu_Widget',
        'WP_Widget_Meta',
        'WP_Widget_Pages',
        'WP_Widget_Recent_Posts',
        
        //woocommerce widget
        'WC_Widget_Price_Filter',
        'WC_Widget_Products',
        'WC_Widget_Layered_Nav_Filters',
        'WC_Widget_Product_Tag_Cloud',
        'WC_Widget_Recently_Viewed',
        'WC_Widget_Top_Rated_Products',
        'WC_Widget_Recent_Reviews',
        'WC_Widget_Layered_Nav',
        'WC_Widget_Layered_Nav_Filters'
    );

    return array_merge( $widgets, $custom );
}
add_filter( 'spyropress_unregister_widgets', 'spyropress_unregister_widgets' );

/**
 * Comment Callback
 */
if( !function_exists( 'spyropress_comment' ) ) :
function spyropress_comment( $comment, $args, $depth ) {
    $translate['comment-reply'] = get_setting( 'translate' ) ? get_setting( 'comment-reply', 'Reply' ) : __( 'Reply', 'spyropress' );
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'spyropress' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'spyropress' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
    	<div class="comment">
    		<div class="img-thumbnail">
                <?php echo get_avatar( $comment, 80 ); ?>
    		</div>
    		<div class="comment-block">
    			<div class="comment-arrow"></div>
    			<span class="comment-by">
    				<strong><?php comment_author(); ?></strong>
    				<span class="pull-right">
                        <span><?php
                            comment_reply_link( array_merge( $args, array(
                                'depth' => $depth,
                                'reply_text' => $translate['comment-reply'],
                                'max_depth' => $args['max_depth'],
                                'before' => '<i class="fa fa-reply"></i> '
                            ) ) );
                        ?></span>
    				</span>
    			</span>
                <?php if ( $comment->comment_approved == '0' ) { ?>
                    <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'spyropress' ); ?></em><br />
                <?php }
                comment_text(); ?>
    			<span class="date pull-right"><?php printf( __( '%1$s at %2$s', 'spyropress' ), get_comment_date(), get_comment_time() ) ?></span>
    		</div>
    	</div>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Pagination Defaults
 */
function spyropress_pagination_defaults( $defaults = array() ) {
    
    $defaults['class_active'] = 'active';
    $defaults['container'] = 'div';
    $defaults['menu_class'] = 'pagination pagination-lg pull-right';
    $defaults['options']['pages_text'] = false;
    $defaults['options']['first_text'] = get_setting('pagination_first_text', __( '<i class="fa fa-chevron-left"></i> First', 'spyropress' ));
    $defaults['options']['last_text'] = get_setting('pagination_last_text', __( 'Last <i class="fa fa-chevron-right"></i>', 'spyropress' ));
    $defaults['options']['prev_text'] = get_setting('pagination_prev_text', __( '<i class="fa fa-chevron-left"></i>', 'spyropress' ));
    $defaults['options']['next_text'] = get_setting('pagination_next_text', __( '<i class="fa fa-chevron-right"></i>', 'spyropress' ));
    
    return $defaults;
}
add_filter( 'spyropress_pagination_defaults', 'spyropress_pagination_defaults' );

/**
 * oEmbed Modifier
 */
function oembed_modifier( $html ) {
    
    $html = preg_replace( '/(width|height|frameborder)="\d*"\s/', "", $html );
    
    if( is_str_contain( 'embed-responsive embed-responsive-16by9', $html ) ) return $html;
    
    return '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'oembed_modifier', 10 );
add_filter( 'oembed_result', 'oembed_modifier', 10 );