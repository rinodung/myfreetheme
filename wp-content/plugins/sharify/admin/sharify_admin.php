<?php

//Regsiter Settings
function admin_init_sharify() {
	register_setting('sharify', 'display_button_facebook');
	register_setting('sharify', 'display_button_linkedin');
	register_setting('sharify', 'display_button_twitter');
	register_setting('sharify', 'display_button_email');
	register_setting('sharify', 'display_button_reddit');
	register_setting('sharify', 'display_button_google');
	register_setting('sharify', 'display_button_pocket');
	register_setting('sharify', 'display_button_pinterest');
	register_setting('sharify', 'display_button_vk');
	register_setting('sharify', 'display_button_wa');
	register_setting('sharify', 'display_buttons_under_post');
	register_setting('sharify', 'display_buttons_before_post');
	register_setting('sharify', 'sharify_twitter_btn_size');
	register_setting('sharify', 'sharify_facebook_btn_size');
	register_setting('sharify', 'sharify_gplus_btn_size');
	register_setting('sharify', 'sharify_reddit_btn_size');
	register_setting('sharify', 'sharify_pocket_btn_size');
	register_setting('sharify', 'sharify_pinterest_btn_size');
	register_setting('sharify', 'sharify_linkedin_btn_size');
	register_setting('sharify', 'sharify_email_btn_size');
	register_setting('sharify', 'sharify_vk_btn_size');
	register_setting('sharify', 'sharify_wa_btn_size');
	register_setting('sharify', 'sharify_use_gfont');
	register_setting('sharify', 'sharify_cpm_twitter');
	register_setting('sharify', 'sharify_cph_twitter');
	register_setting('sharify', 'sharify_cpm_fb');
	register_setting('sharify', 'sharify_cph_fb');
	register_setting('sharify', 'sharify_cpm_gplus');
	register_setting('sharify', 'sharify_cph_gplus');
	register_setting('sharify', 'sharify_cpm_linked');
	register_setting('sharify', 'sharify_cph_linked');
	register_setting('sharify', 'sharify_cpm_pin');
	register_setting('sharify', 'sharify_cph_pin');
	register_setting('sharify', 'sharify_cpm_rdt');
	register_setting('sharify', 'sharify_cph_rdt');
	register_setting('sharify', 'sharify_cpm_vk');
	register_setting('sharify', 'sharify_cph_vk');
	register_setting('sharify', 'sharify_cpm_wa');
	register_setting('sharify', 'sharify_cph_wa');
	register_setting('sharify', 'sharify_cpm_mail');
	register_setting('sharify', 'sharify_cph_mail');
	register_setting('sharify', 'sharify_remove_data');
	register_setting('sharify', 'sharify_twitter_via');
	register_setting('sharify', 'sharify_custom_css');
}

//Add Options Page
function admin_menu_sharify() {
  add_options_page(
		'Sharify',
		'Sharify Settings',
		'manage_options',
		'sharify',
		'options_page_sharify');
}

//Include Sharify options
function options_page_sharify() {
  include( 'sharify_options.php' );  
}

//Check if its admin
if (is_admin()) {
  add_action('admin_init', 'admin_init_sharify');
  add_action('admin_menu', 'admin_menu_sharify');
}

?>