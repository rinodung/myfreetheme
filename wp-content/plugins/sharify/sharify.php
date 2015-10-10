<?php

/**
 * Plugin Name: Sharify
 * Plugin URI: https://wordpress.org/plugins/sharify/
 * Description: Sharify is a fast and simple plugin for sharing buttons on WordPress. The plugin lets you display responsive sharing
 * buttons on your WordPress website!
 * Version: 3.6
 * Author: imehedidip
 * Author URI: http://twitter.com/mehedih_
 * Text Domain: sharify
 * License: GPL2
 * Copyright 2015  Mehedi  (email : mehedi.dip@outlook.com)
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

include_once ('admin/sharify_admin.php'); //Get Admin Settings

//Enqueue Styles
function sharify_css()
{
    wp_register_style( 'sharify', plugins_url( 'sharify-style.php', __FILE__ ), false, NULL, 'all' );
    wp_register_style( 'sharify-icon', plugins_url( 'icon/css/sharify.css', __FILE__ ), false, NULL, 'all' );
	wp_enqueue_style('sharify');
	wp_enqueue_style('sharify-icon');
	wp_enqueue_script( 'sharify-counts', plugins_url( 'admin/inc/sharifycounts.js', __FILE__ ), array( 'jquery' ), '1.2', true );

	if ( 1 == get_option('sharify_use_gfont') )
	{
		wp_register_style( 'sharify-font', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:400', false, NULL, 'all' );
		wp_enqueue_style('sharify-font');
	}
}

add_action( 'wp_enqueue_scripts', 'sharify_css' );

//Activate Sharify options
function activate_sharify()
{
	add_option('display_button_facebook'	, 1);
	add_option('display_button_linkedin'	, 1);
	add_option('display_button_twitter'		, 1);
	add_option('display_button_email'		, 0);
	add_option('display_button_reddit'		, 1);
	add_option('display_button_google'	    , 1);
	add_option('display_buttons_under_post'	, 1);
	add_option('display_buttons_before_post', 0);
	add_option('display_button_pocket'		, 1);
	add_option('display_button_vkt'		    , 0);
	add_option('display_button_wa'		    , 1);
	add_option('sharify_twitter_btn_size'	, 0);
	add_option('sharify_facebook_btn_size'	, 0);
	add_option('sharify_gplus_btn_size'	    , 0);
	add_option('sharify_reddit_btn_size'	, 1);
	add_option('sharify_pocket_btn_size'	, 1);
	add_option('sharify_pinterest_btn_size'	, 1);
	add_option('sharify_linkedin_btn_size'	, 1);
	add_option('sharify_email_btn_size'		, 1);
	add_option('sharify_vk_btn_size'		, 1);
	add_option('sharify_wa_btn_size'		, 1);
	add_option('sharify_use_gfont'			, 1);
	add_option('sharify_remove_data'		, 1);
	add_option('sharify_cpm_twitter'		, "#4db2ec");
	add_option('sharify_cph_twitter'		, "#3498db");
	add_option('sharify_cpm_fb'				, "#3b5998");
	add_option('sharify_cph_fb'				, "#0E2E6F");
	add_option('sharify_cpm_gplus'			, "#b00");
	add_option('sharify_cph_gplus'			, "#A30505");
	add_option('sharify_cpm_linked'			, "#007bb6");
	add_option('sharify_cph_linked'			, "#0E2E6F");
	add_option('sharify_cpm_pin'			, "#cb2027");
	add_option('sharify_cph_pin'			, "#b00");
	add_option('sharify_cpm_rdt'			, "#ff4500");
	add_option('sharify_cph_rdt'			, "#E24207");
	add_option('sharify_cpm_pkt'			, "#ff4500");
	add_option('sharify_cph_pkt'			, "#E24207");
	add_option('sharify_cpm_vk'				, "#45668e");
	add_option('sharify_cph_vk'				, "#32506d");
	add_option('sharify_cpm_wa'				, "#4dc247");
	add_option('sharify_cph_wa'				, "#47a044");
	add_option('sharify_cpm_mail'			, "#e74c3c");
	add_option('sharify_cph_mail'			, "#c0392b");
	add_option('sharify_twitter_via'		, "");
	add_option('sharify_custom_css'		, "");
}
register_activation_hook(__FILE__, 'activate_sharify');

if ( 1 == get_option('sharify_remove_data') ){
//Deactivate Sharify options
function deactive_sharify()
{
	delete_option('display_button_facebook');
	delete_option('display_button_linkedin');
	delete_option('display_button_twitter');
	delete_option('display_button_email');
	delete_option('display_button_reddit');
	delete_option('display_button_google');
	delete_option('display_button_pocket');
	delete_option('display_button_vk');
	delete_option('display_buttons_under_post');
	delete_option('display_buttons_before_post');
	delete_option('sharify_twitter_btn_size');
	delete_option('sharify_facebook_btn_size');
	delete_option('sharify_gplus_btn_size');
	delete_option('sharify_reddit_btn_size');
	delete_option('sharify_pocket_btn_size');
	delete_option('sharify_pinterest_btn_size');
	delete_option('sharify_linkedin_btn_size');
	delete_option('sharify_email_btn_size');
	delete_option('sharify_vk_btn_size');
	delete_option('sharify_use_gfont');
	delete_option('sharify_cpm_twitter');
	delete_option('sharify_cph_twitter');
	delete_option('sharify_cpm_fb');
	delete_option('sharify_cph_fb');
	delete_option('sharify_cpm_gplus');
	delete_option('sharify_cph_gplus');
	delete_option('sharify_cpm_linked');
	delete_option('sharify_cph_linked');
	delete_option('sharify_cpm_pin');
	delete_option('sharify_cph_pin');
	delete_option('sharify_cpm_rdt');
	delete_option('sharify_cph_rdt');
	delete_option('sharify_cpm_pkt');
	delete_option('sharify_cph_pkt');
	delete_option('sharify_cpm_vk');
	delete_option('sharify_cph_vk');
	delete_option('sharify_cpm_mail');
	delete_option('sharify_cph_mail');
	delete_option('sharify_twitter_via');
	delete_option('sharify_custom_css');
}
register_deactivation_hook(__FILE__, 'deactive_sharify');
}


//Add Sharify Buttons shortcode
function sharify_show_buttons_shortcode()
{
	return sharify_display_button_buttons();
}

add_shortcode('sharify', 'sharify_show_buttons_shortcode');

//Function for getting the image
function sharify_catch_that_image()
{
	if ( has_post_thumbnail() ){
		$sharify_thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' );
		$sharify_thumb_url = $sharify_thumb['0'];
		return $sharify_thumb_url;

	} else {
	  	global $post, $posts;
	  	$first_img = '';
	  	ob_start();
	  	ob_end_clean();
	  	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	  	$first_img = $matches[1][0];

	  	return $first_img;
	}
}

//Sharify buttons
function sharify_display_button_buttons($sharify_buttons = "")
{
	$sharify_buttons .= '<div class="sharify-container">';
	$sharify_buttons .= '<ul>';

	if (get_option('sharify_twitter_via')):
		$sharify_twitter_mention = " - via:" . get_option('sharify_twitter_via');
	else:
		$sharify_twitter_mention = "";
	endif;

	if ( 1 == get_option('display_button_twitter') )
		$sharify_post_title = get_the_title();
		$sharify_buttons .='<li class="sharify-btn-twitter">
								<a title="Tweet on Twitter" href="https://twitter.com/intent/tweet?text='.$sharify_post_title.': '.get_permalink(). $sharify_twitter_mention . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;">
									<span class="sharify-icon"><i class="sharify sharify-twitter"></i></span>
									<span class="sharify-title">Tweet</span>
									<span class="sharify-count twitter" data-url="'.get_permalink().'" data-text="'.get_the_title().'" >0</span>
								</a>
							</li>';
	if ( 1 == get_option('display_button_facebook') )
		$sharify_buttons .='<li class="sharify-btn-facebook">
								<a title="Share on Facebook" href="http://www.facebook.com/sharer.php?u=' . urlencode(get_permalink()) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;">
									<span class="sharify-icon"><i class="sharify sharify-facebook"></i></span>
									<span class="sharify-title">Share</span>
									<span class="sharify-count facebook" data-url="'.get_permalink().'" data-text="'.get_the_title().' - " >0</span>
								</a>
							</li>';
	if ( 1 == get_option('display_button_google') )
		$sharify_buttons .= '<li class="sharify-btn-gplus">
								<a title="Share on Google+" href="http://plus.google.com/share?url=' . get_permalink() . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;">
									<span class="sharify-icon"><i class="sharify sharify-gplus"></i></span>
									<span class="sharify-title">+1</span>
								</a>
							</li>';
	if ( 1 == get_option('display_button_reddit') )
		$sharify_buttons .= '<li class="sharify-btn-reddit">
								<a title="Submit to Reddit" href="http://reddit.com/submit?url=' . get_permalink() . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=950,height=450,toolbar=0\'); return false;">
									<span class="sharify-icon"><i class="sharify sharify-reddit"></i></span>
									<span class="sharify-title">Reddit</span>
								</a>
							</li>';
	if ( 1 == get_option('display_button_pocket') )
		$sharify_buttons .= '<li class="sharify-btn-pocket">
								<a title="Save to read later on Pocket" href="https://getpocket.com/save?url=' . urlencode(get_permalink()) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;">
									<span class="sharify-icon"><i class="sharify sharify-pocket"></i></span>
									<span class="sharify-title">Pocket</span>
								</a>
							</li>';
	if ( 1 == get_option('display_button_pinterest') )
		$sharify_buttons .= '<li class="sharify-btn-pinterest">
								<a title="Share on Pinterest" href="http://pinterest.com/pin/create/button/?url=' . get_permalink() . '&media=' . sharify_catch_that_image() . '' . '&description='. get_the_title() .' - ' . get_permalink(). '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;">
									<span class="sharify-icon"><i class="sharify sharify-pinterest"></i></span>
									<span class="sharify-title">Pinterest</span>
								</a>
							</li>';
	if ( 1 == get_option('display_button_linkedin') )
		$sharify_buttons .= '<li class="sharify-btn-linkedin">
								<a title="Share on Linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=' . get_permalink() . '&title='. get_the_title() .'" onclick="if(!document.getElementById(\'td_social_networks_buttons\')){window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;}" >
									<span class="sharify-icon"><i class="sharify sharify-linkedin"></i></span>
									<span class="sharify-title">LinkedIn</span>
									<span class="sharify-count linkedin" data-url="'.get_permalink().'" data-text="'.get_the_title().' - " >0</span>
								</a>
							</li>';
	if ( 1 == get_option('display_button_email') )
		$sharify_buttons .= '<li class="sharify-btn-email">
								<a title="Share via mail" href="mailto:?subject='.get_the_title().'&body=Hey, checkout this great article: '.get_permalink().'">
									<span class="sharify-icon"><i class="sharify sharify-mail"></i></span>
									<span class="sharify-title">Email</span>
								</a>
							</li>';
	if ( 1 == get_option('display_button_vk') )
		$sharify_buttons .= '<li class="sharify-btn-vk">
								<a title="Share on VKontakte" href="http://vkontakte.ru/share.php?url=' . get_permalink() . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=950,height=450,toolbar=0\'); return false;">
									<span class="sharify-icon"><i class="sharify sharify-vk"></i></span>
									<span class="sharify-title">VKontakte</span>
								</a>
							</li>';
	$sharify_buttons .= '</ul>';
    $sharify_buttons .= '</div>';
	return $sharify_buttons;
}

//Add Sharify buttons automatically
function sharify_show_buttons_on_single($sharify_buttons)
{
    if ( is_single() && ( 1 == get_option('display_buttons_under_post') )  ) {
		$sharify_buttons = sharify_display_button_buttons($sharify_buttons);
	}

	return $sharify_buttons;
}

add_filter('the_content', 'sharify_show_buttons_on_single');

function sharify_show_buttons_on_single_top($content)
{
	if ( is_single() && ( 1 == get_option('display_buttons_before_post') ) ){
		$add_sharify = sharify_display_button_buttons($sharify_buttons);
		$content = $add_sharify . $content;
	}

	return $content;
}

add_filter('the_content', 'sharify_show_buttons_on_single_top');

//Load Admin Styles
function load_sharify_wp_admin_style()
{
    wp_register_style('sharify_admin_css', plugin_dir_url( __FILE__ ) . 'admin/sharify-admin.css' );
    wp_enqueue_style( 'sharify_admin_css' );
    wp_register_style('sharify_icon', plugin_dir_url( __FILE__ ) . 'icon/css/sharify.css' );
    wp_enqueue_style( 'sharify_icon' );
    wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script('iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false,1);
    wp_enqueue_script( 'my-script-handle', plugins_url('admin/sharify.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}

add_action( 'admin_enqueue_scripts', 'load_sharify_wp_admin_style' );

register_activation_hook(__FILE__, 'sharify_plugin_activation');
function sharify_plugin_activation() {
  $notices= get_option('sharify_plugin_deferred_admin_notices', array());
  $notices[]= "Thanks for using Sharify! Please make sure to <a href='https://wordpress.org/support/view/plugin-reviews/sharify#postform' title='Reviews are really apperciated :)'>leave a review </a>, and <a href='http://twitter.com/sharifyplugin' title='Follow us on Twitter'>follow us</a> on Twitter for the latest updates on Sharify! And <a href='".get_bloginfo('url') . "/wp-admin/options-general.php?page=sharify"."'>click here to go to Sharify Admin Panel!</a>";
  update_option('sharify_plugin_deferred_admin_notices', $notices);
}


add_action('admin_notices', 'sharify_plugin_admin_notices');
function sharify_plugin_admin_notices() {
  if ($notices= get_option('sharify_plugin_deferred_admin_notices')) {
    foreach ($notices as $notice) {
      echo "<div class='updated'><p>$notice</p></div>";
    }
    delete_option('sharify_plugin_deferred_admin_notices');
  }
}

register_deactivation_hook(__FILE__, 'sharify_plugin_deactivation');
function sharify_plugin_deactivation() {
  delete_option('sharify_plugin_version');
  delete_option('sharify_plugin_deferred_admin_notices');
}

?>
