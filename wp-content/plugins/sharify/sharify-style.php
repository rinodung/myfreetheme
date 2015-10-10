<?php
 $absolute_path = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
 $wp_load = $absolute_path[0] . 'wp-load.php';
 require_once($wp_load);

header('Content-type: text/css');
header('Cache-control: must-revalidate');

//Twitter
if ( 1 == get_option('sharify_twitter_btn_size') ){
	$twitter_btn_size = '10%;';
	$twitter_btn_icon_float = 'none;';
	$twitter_btn_icon_align = 'text-align: center;';
	$twitter_btn_title = 'display: none;';
	$twitter_btn_icon_count = 'none;';
	$twitter_btn_icon_padding = '0px;';
}

else{
	$twitter_btn_size = '20%';
	$twitter_btn_icon_float = 'left;';
	$facebook_btn_icon_align = '';
	$twitter_btn_title = '';
	$twitter_btn_icon_count = 'block;';
	$twitter_btn_icon_padding = '10px;';
}

//Facebook
if ( 1 == get_option('sharify_facebook_btn_size') ){
	$facebook_btn_size = '10%;';
	$facebook_btn_icon_float = 'none;';
	$facebook_btn_icon_align = 'text-align: center;';
	$facebook_btn_title = 'display: none;';
	$facebook_btn_icon_count = 'none;';
	$facebook_btn_icon_padding = '0px;';
}

else{
	$facebook_btn_size = '20%';
	$facebook_btn_icon_float = 'left;';
	$facebook_btn_icon_align = '';
	$facebook_btn_title = '';
	$facebook_btn_icon_count = 'block;';
	$facebook_btn_icon_padding = '10px;';
}

//gplus
if ( 1 == get_option('sharify_gplus_btn_size') ){
	$gplus_btn_size = '10%;';
	$gplus_btn_icon_float = 'none;';
	$gplus_btn_icon_align = 'text-align: center;';
	$gplus_btn_title = 'display: none;';
	$gplus_btn_icon_count = 'none;';
	$gplus_btn_icon_padding = '0px;';
}

else{
	$gplus_btn_size = '20%';
	$gplus_btn_icon_float = 'left;';
	$gplus_btn_icon_align = '';
	$gplus_btn_title = '';
	$gplus_btn_icon_count = 'block;';
	$gplus_btn_icon_padding = '10px;';
}

//reddit
if ( 1 == get_option('sharify_reddit_btn_size') ){
	$reddit_btn_size = '10%;';
	$reddit_btn_icon_float = 'none;';
	$reddit_btn_icon_align = 'text-align: center;';
	$reddit_btn_title = 'display: none;';
	$reddit_btn_icon_count = 'none;';
	$reddit_btn_icon_padding = '0px;';
}

else{
	$reddit_btn_size = '20%';
	$reddit_btn_icon_float = 'left;';
	$reddit_btn_icon_align = '';
	$reddit_btn_title = '';
	$reddit_btn_icon_count = 'block;';
	$reddit_btn_icon_padding = '10px;';
}

//pocket
if ( 1 == get_option('sharify_pocket_btn_size') ){
	$pocket_btn_size = '10%;';
	$pocket_btn_icon_float = 'none;';
	$pocket_btn_icon_align = 'text-align: center;';
	$pocket_btn_title = 'display: none;';
	$pocket_btn_icon_count = 'none;';
	$pocket_btn_icon_padding = '0px;';
}

else{
	$pocket_btn_size = '20%';
	$pocket_btn_icon_float = 'left;';
	$pocket_btn_icon_align = '';
	$pocket_btn_title = '';
	$pocket_btn_icon_count = 'block;';
	$pocket_btn_icon_padding = '10px;';
}

//pinterest
if ( 1 == get_option('sharify_pinterest_btn_size') ){
	$pinterest_btn_size = '10%;';
	$pinterest_btn_icon_float = 'none;';
	$pinterest_btn_icon_align = 'text-align: center;';
	$pinterest_btn_title = 'display: none;';
	$pinterest_btn_icon_count = 'none;';
	$pinterest_btn_icon_padding = '0px;';
}

else{
	$pinterest_btn_size = '20%';
	$pinterest_btn_icon_float = 'left;';
	$pinterest_btn_icon_align = '';
	$pinterest_btn_title = '';
	$pinterest_btn_icon_count = 'block;';
	$pinterest_btn_icon_padding = '10px;';
}

//linkedin
if ( 1 == get_option('sharify_linkedin_btn_size') ){
	$linkedin_btn_size = '10%;';
	$linkedin_btn_icon_float = 'none;';
	$linkedin_btn_icon_align = 'text-align: center;';
	$linkedin_btn_title = 'display: none;';
	$linkedin_btn_icon_count = 'none;';
	$linkedin_btn_icon_padding = '0px;';
}

else{
	$linkedin_btn_size = '20%';
	$linkedin_btn_icon_float = 'left;';
	$linkedin_btn_icon_align = '';
	$linkedin_btn_title = '';
	$linkedin_btn_icon_count = 'block;';
	$linkedin_btn_icon_padding = '10px;';
}

//email
if ( 1 == get_option('sharify_email_btn_size') ){
	$email_btn_size = '10%;';
	$email_btn_icon_float = 'none;';
	$email_btn_icon_align = 'text-align: center;';
	$email_btn_title = 'display: none;';
	$email_btn_icon_count = 'none;';
	$email_btn_icon_padding = '0px;';
}

else{
	$email_btn_size = '20%';
	$email_btn_icon_float = 'left;';
	$email_btn_icon_align = '';
	$email_btn_title = '';
	$email_btn_icon_count = 'block;';
	$email_btn_icon_padding = '10px;';
}

//vk
if ( 1 == get_option('sharify_vk_btn_size') ){
	$vk_btn_size = '10%;';
	$vk_btn_icon_float = 'none;';
	$vk_btn_icon_align = 'text-align: center;';
	$vk_btn_title = 'display: none;';
	$vk_btn_icon_count = 'none;';
	$vk_btn_icon_padding = '0px;';
}

else{
	$vk_btn_size = '20%';
	$vk_btn_icon_float = 'left;';
	$vk_btn_icon_align = '';
	$vk_btn_title = '';
	$vk_btn_icon_count = 'block;';
	$vk_btn_icon_padding = '10px;';
}

//wa
if ( 1 == get_option('sharify_wa_btn_size') ){
	$wa_btn_size = '10%;';
	$wa_btn_icon_float = 'none;';
	$wa_btn_icon_align = 'text-align: center;';
	$wa_btn_title = 'display: none;';
	$wa_btn_icon_count = 'none;';
	$wa_btn_icon_padding = '0px;';
}

else{
	$wa_btn_size = '20%';
	$wa_btn_icon_float = 'left;';
	$wa_btn_icon_align = '';
	$wa_btn_title = '';
	$wa_btn_icon_count = 'block;';
	$wa_btn_icon_padding = '10px;';
}

if ( 1 == get_option('sharify_use_gfont') ){
	$sharify_btn_font = 'Roboto Condensed, sans-serif;';	
}

else{
	$sharify_btn_font = 'Segoe UI, Frutiger, Frutiger Linotype, Dejavu Sans, Helvetica Neue, Arial, sans-serif;';
}

$sharify_cpm_twitter = get_option('sharify_cpm_twitter'); 

$sharify_cpm_wa = get_option('sharify_cpm_wa'); 
?>

.sharify-btn-twitter{
	min-width: <?php echo $twitter_btn_size; ?>
}

.sharify-btn-twitter .sharify-icon{
	float: <?php echo $twitter_btn_icon_float; ?>
	<?php echo $twitter_btn_icon_align; ?>
	padding-left: <?php echo $twitter_btn_icon_padding; ?>
}


.sharify-btn-twitter .sharify-count{
	display: <?php echo $twitter_btn_icon_count; ?>
	padding-right: 10px;
	float: right;
}

.sharify-btn-twitter .sharify-title{
	<?php echo $twitter_btn_title; ?>
}

.sharify-btn-facebook{
	min-width: <?php echo $facebook_btn_size; ?>
}

.sharify-btn-facebook .sharify-icon{
	float: <?php echo $facebook_btn_icon_float; ?>
	<?php echo $facebook_btn_icon_align; ?>
	padding-left: <?php echo $facebook_btn_icon_padding; ?>
}


.sharify-btn-facebook .sharify-count{
	display: <?php echo $facebook_btn_icon_count; ?>
	padding-right: 10px;
	float: right;
}

.sharify-btn-facebook .sharify-title{
	<?php echo $facebook_btn_title; ?>
}

.sharify-btn-gplus{
	min-width: <?php echo $gplus_btn_size; ?>
}

.sharify-btn-gplus .sharify-icon{
	float: <?php echo $gplus_btn_icon_float; ?>
	<?php echo $gplus_btn_icon_align; ?>
	padding-left: <?php echo $gplus_btn_icon_padding; ?>
}


.sharify-btn-gplus .sharify-count{
	display: <?php echo $gplus_btn_icon_count; ?>
	padding-right: 10px;
	float: right;
}

.sharify-btn-gplus .sharify-title{
	<?php echo $gplus_btn_title; ?>
}

.sharify-btn-reddit{
	min-width: <?php echo $reddit_btn_size; ?>
}

.sharify-btn-reddit .sharify-icon{
	float: <?php echo $reddit_btn_icon_float; ?>
	<?php echo $reddit_btn_icon_align; ?>
	padding-left: <?php echo $reddit_btn_icon_padding; ?>
}


.sharify-btn-reddit .sharify-count{
	display: <?php echo $reddit_btn_icon_count; ?>
	padding-right: 10px;
	float: right;
}

.sharify-btn-reddit .sharify-title{
	<?php echo $reddit_btn_title; ?>
}

.sharify-btn-pocket{
	min-width: <?php echo $pocket_btn_size; ?>
}

.sharify-btn-pocket .sharify-icon{
	float: <?php echo $pocket_btn_icon_float; ?>
	<?php echo $pocket_btn_icon_align; ?>
	padding-left: <?php echo $pocket_btn_icon_padding; ?>
}


.sharify-btn-pocket .sharify-count{
	display: <?php echo $pocket_btn_icon_count; ?>
	padding-right: 10px;
	float: right;
}

.sharify-btn-pocket .sharify-title{
	<?php echo $pocket_btn_title; ?>
}

.sharify-btn-pinterest{
	min-width: <?php echo $pinterest_btn_size; ?>
}

.sharify-btn-pinterest .sharify-icon{
	float: <?php echo $pinterest_btn_icon_float; ?>
	<?php echo $pinterest_btn_icon_align; ?>
	padding-left: <?php echo $pinterest_btn_icon_padding; ?>
}


.sharify-btn-pinterest .sharify-count{
	display: <?php echo $pinterest_btn_icon_count; ?>
	padding-right: 10px;
	float: right;
}

.sharify-btn-pinterest .sharify-title{
	<?php echo $pinterest_btn_title; ?>
}

.sharify-btn-linkedin{
	min-width: <?php echo $linkedin_btn_size; ?>
}

.sharify-btn-linkedin .sharify-icon{
	float: <?php echo $linkedin_btn_icon_float; ?>
	<?php echo $linkedin_btn_icon_align; ?>
	padding-left: <?php echo $linkedin_btn_icon_padding; ?>
}


.sharify-btn-linkedin .sharify-count{
	display: <?php echo $linkedin_btn_icon_count; ?>
	padding-right: 10px;
	float: right;
}

.sharify-btn-linkedin .sharify-title{
	<?php echo $linkedin_btn_title; ?>
}

.sharify-btn-email{
	min-width: <?php echo $email_btn_size; ?>
}

.sharify-btn-email .sharify-icon{
	float: <?php echo $email_btn_icon_float; ?>
	<?php echo $email_btn_icon_align; ?>
	padding-left: <?php echo $email_btn_icon_padding; ?>
}


.sharify-btn-email .sharify-count{
	display: <?php echo $email_btn_icon_count; ?>
	padding-right: 10px;
	float: right;
}

.sharify-btn-email .sharify-title{
	<?php echo $email_btn_title; ?>
}

.sharify-btn-vk{
	min-width: <?php echo $vk_btn_size; ?>
}

.sharify-btn-vk .sharify-icon{
	float: <?php echo $vk_btn_icon_float; ?>
	<?php echo $vk_btn_icon_align; ?>
	padding-left: <?php echo $vk_btn_icon_padding; ?>
}


.sharify-btn-vk .sharify-count{
	display: <?php echo $vk_btn_icon_count; ?>
	padding-right: 10px;
	float: right;
}

.sharify-btn-vk .sharify-title{
	<?php echo $vk_btn_title; ?>
}

.sharify-btn-wa{
	min-width: <?php echo $wa_btn_size; ?>
}

.sharify-btn-wa .sharify-icon{
	float: <?php echo $wa_btn_icon_float; ?>
	<?php echo $wa_btn_icon_align; ?>
	padding-left: <?php echo $wa_btn_icon_padding; ?>
}


.sharify-btn-wa .sharify-count{
	display: <?php echo $wa_btn_icon_count; ?>
	padding-right: 10px;
	float: right;
}

.sharify-btn-wa .sharify-title{
	<?php echo $wa_btn_title; ?>
}

.sharify-container li{
	font-family: <?php echo $sharify_btn_font; ?>
}

.sharify-icon{
	  font-size: 13px;
	      line-height: 35px;
}

.sharify-container li .count{
	background-color: transparent !important;
}

.sharify-btn-wa{
	display: none;
}
.ismobilewa{
	display: block !important;
}
.sharify-container li.sharify-btn-wa a{background-color:<?php echo $sharify_cpm_wa; ?>;}.sharify-container li.sharify-btn-wa a:hover{background-color:<?php echo get_option('sharify_cph_wa'); ?>}
.sharify-gplus{
	font-size: 18px;
}
.sharify-container{position:relative;display:block;width:100%;padding:20px 0;overflow:hidden}.sharify-container ul{padding:0;margin:0}.sharify-container li{list-style:none;height:35px;line-height:36px;float:left;margin:0!important;padding-left:2.5px}.sharify-container li a{border:0;background-color:#4db2ec;border-radius:1px;display:block;font-size:15px;line-height:37px;height:100%;color:#fff;position:relative;text-align:center;text-decoration:none;text-transform:uppercase;width:100%;transition:all .2s ease-in-out}@media (max-width:955px) and (min-width:769px){.sharify-count{display:none}}@media (max-width:768px){.sharify-count,.sharify-title{display:none}.sharify-icon{width:100%;padding-left:0!important}.sharify-icon i{text-align:center}.sharify-container li{min-width:14.2857142857%!important;width:12.5%!important}}.sharify-count{float:right}.sharify-container li.sharify-btn-twitter a{background-color:<?php echo $sharify_cpm_twitter; ?>;}.sharify-container li.sharify-btn-twitter a:hover{background-color:<?php echo get_option('sharify_cph_twitter'); ?>}.sharify-container li.sharify-btn-facebook a{background-color:<?php echo get_option('sharify_cpm_fb'); ?>;}.sharify-container li.sharify-btn-facebook a:hover{background-color:<?php echo get_option('sharify_cph_fb'); ?>;}.sharify-container li.sharify-btn-gplus a{background-color:<?php echo get_option('sharify_cpm_gplus'); ?>;}.sharify-container li.sharify-btn-gplus a:hover{background-color:<?php echo get_option('sharify_cph_gplus'); ?>;}.sharify-container li.sharify-btn-pinterest a{background-color:<?php echo get_option('sharify_cpm_pin'); ?>;}.sharify-container li.sharify-btn-pinterest a:hover{background-color:<?php echo get_option('sharify_cph_pin'); ?>}.sharify-container li.sharify-btn-linkedin a{background-color:<?php echo get_option('sharify_cpm_linked'); ?>;}.sharify-container li.sharify-btn-linkedin a:hover{background-color:<?php echo get_option('sharify_cph_linked') ?>;}.sharify-container li.sharify-btn-vk a{background-color:<?php echo get_option('sharify_cpm_vk') ?>;}.sharify-container li.sharify-btn-vk a:hover{background-color:<?php echo get_option('sharify_cph_vk') ?>;}.sharify-container li.sharify-btn-reddit a{background-color:<?php echo get_option('sharify_cpm_rdt'); ?>}.sharify-container li.sharify-btn-reddit a:hover{background-color:<?php echo get_option('sharify_cph_rdt'); ?>;}.sharify-container li.sharify-btn-pocket a{background-color:#d3505a}.sharify-container li.sharify-btn-pocket a:hover{background-color:#B6202C}.sharify-container li.sharify-btn-email a{background-color:<?php echo get_option('sharify_cpm_mail'); ?>;}.sharify-container li.sharify-btn-email a:hover{background-color:<?php echo get_option('sharify_cph_mail'); ?>;}

<!--Custom css-->
<?php echo get_option('sharify_custom_css'); ?>