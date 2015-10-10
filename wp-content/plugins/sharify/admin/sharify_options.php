<style type="text/css">
	#adminmenuwrap{
		height: 100% !important;
	}
	html{
		background-color: #e9eaed;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
	}
	#footer-left, #wpfooter a, #footer-upgrade{
		color: #fff !important;
		opacity: 0.6;
	}
	.wpcontent{
		padding: 0px !important;
	}
	div.updated{
		width: 88%;
		margin-right: auto;
		margin-top: 30px;
		border-color: #2D88BB;
		background: #4db2ec;
		color: #fff;
		margin-left: auto;
	}
</style>
<link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<div class="sharify-wrap">
	<!--Sharify Logo-->
	<h2 class="sharify-logo">Sharify</h2>
	<!--Sharify main-->
	<div class="sharify-inner">
		<header><span class="sharify-logo-main">Sharify</span><span class="sharify-version"><a href="https://wordpress.org/plugins/sharify/changelog/" title="Checkout the changelog!">Verison 3.4.4</a></span></header>
		<div class="sharify-main">
			<div class="sharify-settings">
				<!--Button Placement-->
				<!--Easter egg for the peeps at WinBeta.org ;)-->
				<?php if (get_site_url() == "http://winbeta.org") {
					echo "<h3>Hey dere guys Mehedi here from wmpu, and this is where you customize the plugin...tara!</h3><br/>";
				} else{
					//sleep
				}

				?>
				<div class="sharify-sec-title"><a href="https://twitter.com/sharifyplugin">Follow us on Twitter to get support!</a></div><br/>
				<div class="sharify-sec-title">General Settings</div>
				<form method="post" class="sharify-settings-form" action="options.php">
					<?php wp_nonce_field('update-options'); ?>
					<?php settings_fields('sharify');?>		
					<div id="general-settings" class="sharify-setting-wrap">
						<br><label><input class="sharify-input" type="checkbox" name="display_buttons_under_post" value="1" 
						<?php if ( 1 == get_option('display_buttons_under_post') ) echo 'checked="checked"'; ?> /> Display Sharify buttons at the bottom of posts</label> <br>
						<br><label><input class="sharify-input" type="checkbox" name="display_buttons_before_post" value="1" 
						<?php if ( 1 == get_option('display_buttons_before_post') ) echo 'checked="checked"'; ?> /> Display Sharify buttons at the top of posts</label> <br>
						<br><label><input type="checkbox" class="sharify-input" name="sharify_use_gfont" value="1" 
						<?php if ( 1 == get_option('sharify_use_gfont') ) echo 'checked="checked"'; ?> /> Load Google Font?</label><br />
						<br /><p class="sharify-version-no"><strong>Custom CSS Styles</strong></p>
						<textarea rows="4" cols="50" name="sharify_custom_css"><?php echo get_option('sharify_custom_css'); ?></textarea>
						<br />
						<p class="submit"><input type="submit" class="sharify-btn" value="<?php _e('Save Changes') ?>" /></p>
					</div>

					<!--Twitter-->
					<br /><div class="sharify-sec-title">Twitter</div>
					<?php wp_nonce_field('update-options'); ?>
					<?php settings_fields('sharify');?>	
					<div id="twitter" class="sharify-setting-wrap">
						<br><label><input type="checkbox" class="sharify-input" name="display_button_twitter" value="1" 
						<?php if ( 1 == get_option('display_button_twitter') ) echo 'checked="checked"'; ?> /> Display Twitter button?</label>
						<br><br><label><input type="checkbox" class="sharify-input" name="sharify_twitter_btn_size" value="1" 
						<?php if ( 1 == get_option('sharify_twitter_btn_size') ) echo 'checked="checked"'; ?> /> Display small button for Twitter?</label><br />
						
						<p class="sharify-version-no"><strong>Twitter Button main color</strong></p>
						<input type="text" id="color" value="<?php echo get_option('sharify_cpm_twitter'); ?>" name="sharify_cpm_twitter" class="sharify-cp color-picker" />
						<br /><p class="sharify-version-no"><strong>Twitter Button hover color</strong></p>
						<input type="text" id="color" value="<?php echo get_option('sharify_cph_twitter'); ?>" name="sharify_cph_twitter" class="sharify-cp color-picker" />
						<br /><p class="sharify-version-no"><strong>Twitter Via User (with "@")</strong></p>
						<input type="text" value="<?php echo get_option('sharify_twitter_via'); ?>" name="sharify_twitter_via"/>
						<br />
						<p class="submit"><input type="submit" class="sharify-btn" value="<?php _e('Save Changes') ?>" /></p>
					</div>

					<!--Facebook-->
					<br/><div class="sharify-sec-title">Facebook</div>
					<?php wp_nonce_field('update-options'); ?>
					<?php settings_fields('sharify');?>	
					<div id="facebook" class="sharify-setting-wrap">
						<br><label><input type="checkbox" class="sharify-input" name="display_button_facebook" value="1" 
						<?php if ( 1 == get_option('display_button_facebook') ) echo 'checked="checked"'; ?> /> Display Facebook button?</label><br />
						<br><label><input type="checkbox" class="sharify-input" name="sharify_facebook_btn_size" value="1" 
						<?php if ( 1 == get_option('sharify_facebook_btn_size') ) echo 'checked="checked"'; ?> /> Display small button for Facebook?</label><br />
						
						<p class="sharify-version-no"><strong>Facebook Button main color</strong></p>
						<input type="text" id="color" value="<?php echo get_option('sharify_cpm_fb'); ?>" name="sharify_cpm_fb" class="sharify-cp color-picker" />
						<br /><p class="sharify-version-no"><strong>Facebook Button hover color</strong></p>
						<input type="text" id="color" value="<?php echo get_option('sharify_cph_fb'); ?>" name="sharify_cph_fb" class="sharify-cp color-picker" />
						<p class="submit"><input type="submit" class="sharify-btn" value="<?php _e('Save Changes') ?>" /></p>
					</div>

					<!--GPLUS-->
					<br /><div class="sharify-sec-title">Google+</div>
					<?php wp_nonce_field('update-options'); ?>
					<?php settings_fields('sharify');?>	
					<div id="gplus" class="sharify-setting-wrap">
						<br><label><input type="checkbox" class="sharify-input" name="display_button_google" value="1" 
						<?php if ( 1 == get_option('display_button_google') ) echo 'checked="checked"'; ?> /> Display Google Plus button?</label><br />
						<br><label><input type="checkbox" class="sharify-input" name="sharify_gplus_btn_size" value="1" 
						<?php if ( 1 == get_option('sharify_gplus_btn_size') ) echo 'checked="checked"'; ?> /> Display small button for Google Plus?</label><br />

						<p class="sharify-version-no"><strong>Google+ Button main color</strong></p>
						<input type="text" id="color" value="<?php echo get_option('sharify_cpm_gplus'); ?>" name="sharify_cpm_gplus" class="sharify-cp color-picker" />
						<br /><p class="sharify-version-no"><strong>Google+ Button hover color</strong></p>
						<input type="text" id="color" value="<?php echo get_option('sharify_cph_gplus'); ?>" name="sharify_cph_gplus" class="sharify-cp color-picker" />
						<p class="submit"><input type="submit" class="sharify-btn" value="<?php _e('Save Changes') ?>" /></p>
					</div>

					<!--WhatsApp-->
					<br /><div class="sharify-sec-title">WhatsApp</div>
					<?php wp_nonce_field('update-options'); ?>
					<?php settings_fields('sharify');?>	
					<div id="wa" class="sharify-setting-wrap">
						<br>
						<em>Please note that the WhatsApp button will only display for mobile devices.</em><br>
						<br><label><input type="checkbox" class="sharify-input" name="display_button_wa" value="1" 
						<?php if ( 1 == get_option('display_button_wa') ) echo 'checked="checked"'; ?> /> Display WhatsApp button?</label><br />
						<br /><label><input type="checkbox" class="sharify-input" name="sharify_wa_btn_size" value="1" 
						<?php if ( 1 == get_option('sharify_wa_btn_size') ) echo 'checked="checked"'; ?> /> Display small button for WhatsApp?</label><br />

						<p class="sharify-version-no"><strong>WhatsApp Button main color</strong></p>
						<input type="text" id="color" value="<?php echo get_option('sharify_cpm_wa'); ?>" name="sharify_cpm_wa" class="sharify-cp color-picker" />
						<br /><p class="sharify-version-no"><strong>WhatsApp Button hover color</strong></p>
						<input type="text" id="color" value="<?php echo get_option('sharify_cph_wa'); ?>" name="sharify_cph_wa" class="sharify-cp color-picker" />
						<p class="submit"><input type="submit" class="sharify-btn" value="<?php _e('Save Changes') ?>" /></p>
					</div>

					<!--LinkedIn-->
					<br/><div class="sharify-sec-title">LinkedIn</div>
					<?php wp_nonce_field('update-options'); ?>
					<?php settings_fields('sharify');?>	
					<div id="linkedin" class="sharify-setting-wrap">
						<br><label><input type="checkbox" class="sharify-input" name="display_button_linkedin" value="1" 
						<?php if ( 1 == get_option('display_button_linkedin') ) echo 'checked="checked"'; ?> /> Display LinkedIn button?</label><br />
						<br><label><input type="checkbox" class="sharify-input" name="sharify_linkedin_btn_size" value="1" 
						<?php if ( 1 == get_option('sharify_linkedin_btn_size') ) echo 'checked="checked"'; ?> /> Display small button for LinkedIn?</label><br />

						<p class="sharify-version-no"><strong>LinkedIn Button main color</strong></p>
						<input type="text" id="color" value="<?php echo get_option('sharify_cpm_linked'); ?>" name="sharify_cpm_linked" class="sharify-cp color-picker" />
						<br /><p class="sharify-version-no"><strong>LinkedIn Button hover color</strong></p>
						<input type="text" id="color" value="<?php echo get_option('sharify_cph_linked'); ?>" name="sharify_cph_linked" class="sharify-cp color-picker" />
						<br>
						<p class="submit"><input type="submit" class="sharify-btn" value="<?php _e('Save Changes') ?>" /></p>
					</div>

					<!--Pinterest-->
					<br/><div class="sharify-sec-title">Pinterest</div>
					<?php wp_nonce_field('update-options'); ?>
					<?php settings_fields('sharify');?>	
					<div id="pinterest" class="sharify-setting-wrap">
						<br><label><input type="checkbox" class="sharify-input" name="display_button_pinterest" value="1" 
						<?php if ( 1 == get_option('display_button_pinterest') ) echo 'checked="checked"'; ?> /> Display Pinterest button?</label><br />
						<br><label><input type="checkbox" class="sharify-input" name="sharify_pinterest_btn_size" value="1" 
						<?php if ( 1 == get_option('sharify_pinterest_btn_size') ) echo 'checked="checked"'; ?> /> Display small button for Pinterest?</label><br />
						
						<p class="sharify-version-no"><strong>Pinterest Button main color</strong></p>
						<input type="text" id="color" value="<?php echo get_option('sharify_cpm_pin'); ?>" name="sharify_cpm_pin" class="sharify-cp color-picker" />
						<br /><p class="sharify-version-no"><strong>Pinterest Button hover color</strong></p>
						<input type="text" id="color" value="<?php echo get_option('sharify_cph_pin'); ?>" name="sharify_cph_pin" class="sharify-cp color-picker" />
						<p class="submit"><input type="submit" class="sharify-btn" value="<?php _e('Save Changes') ?>" /></p>
					</div>

					<!--Reddit-->
					<br/><div class="sharify-sec-title">Reddit</div>
					<?php wp_nonce_field('update-options'); ?>
					<?php settings_fields('sharify');?>	
					<div id="reddit" class="sharify-setting-wrap">
						<br><label><input type="checkbox" class="sharify-input" name="display_button_reddit" value="1" 
						<?php if ( 1 == get_option('display_button_reddit') ) echo 'checked="checked"'; ?> /> Display Reddit button?</label><br />
						<br><label><input type="checkbox" class="sharify-input" name="sharify_reddit_btn_size" value="1" 
						<?php if ( 1 == get_option('sharify_reddit_btn_size') ) echo 'checked="checked"'; ?> /> Display small button for Reddit?</label><br />

						<p class="sharify-version-no"><strong>Reddit Button main color</strong></p>
						<input type="text" id="color" value="<?php echo get_option('sharify_cpm_rdt'); ?>" name="sharify_cpm_rdt" class="sharify-cp color-picker" />
						<br /><p class="sharify-version-no"><strong>Reddit Button hover color</strong></p>
						<input type="text" id="color" value="<?php echo get_option('sharify_cph_rdt'); ?>" name="sharify_cph_rdt" class="sharify-cp color-picker" />
						<p class="submit"><input type="submit" class="sharify-btn" value="<?php _e('Save Changes') ?>" /></p>					
					</div>

					<!--Pocket-->
					<br /><div class="sharify-sec-title">Pocket</div>
					<?php wp_nonce_field('update-options'); ?>
					<?php settings_fields('sharify');?>	
					<div id="pocket" class="sharify-setting-wrap">
						<br><label><input type="checkbox" class="sharify-input" name="display_button_pocket" value="1" 
						<?php if ( 1 == get_option('display_button_pocket') ) echo 'checked="checked"'; ?> /> Display Pocket button?</label><br />
						<br><label><input type="checkbox" class="sharify-input" name="sharify_pocket_btn_size" value="1" 
						<?php if ( 1 == get_option('sharify_pocket_btn_size') ) echo 'checked="checked"'; ?> /> Display small button for Pocket?</label><br />

						<p class="sharify-version-no"><strong>Pocket Button main color</strong></p>
						<input type="text" id="color" value="<?php echo get_option('sharify_cpm_pkt'); ?>" name="sharify_cpm_pkt" class="sharify-cp color-picker" />
						<br /><p class="sharify-version-no"><strong>Pocket Button hover color</strong></p>
						<input type="text" id="color" value="<?php echo get_option('sharify_cph_pkt'); ?>" name="sharify_cph_pkt" class="sharify-cp color-picker" />
						<p class="submit"><input type="submit" class="sharify-btn" value="<?php _e('Save Changes') ?>" /></p>
					
					</div>

					<!--VK-->
					<br /><div class="sharify-sec-title">VKontakte</div>
					<?php wp_nonce_field('update-options'); ?>
					<?php settings_fields('sharify');?>	
					<div id="vk" class="sharify-setting-wrap">
						<br><label><input type="checkbox" class="sharify-input" name="display_button_vk" value="1" 
						<?php if ( 1 == get_option('display_button_vk') ) echo 'checked="checked"'; ?> /> Display VKontakte button?</label><br />
						<br /><label><input type="checkbox" class="sharify-input" name="sharify_vk_btn_size" value="1" 
						<?php if ( 1 == get_option('sharify_vk_btn_size') ) echo 'checked="checked"'; ?> /> Display small button for VKontake?</label><br />

						<p class="sharify-version-no"><strong>VKontakte Button main color</strong></p>
						<input type="text" id="color" value="<?php echo get_option('sharify_cpm_vk'); ?>" name="sharify_cpm_vk" class="sharify-cp color-picker" />
						<br /><p class="sharify-version-no"><strong>VKontakte Button hover color</strong></p>
						<input type="text" id="color" value="<?php echo get_option('sharify_cph_vk'); ?>" name="sharify_cph_vk" class="sharify-cp color-picker" />
						<p class="submit"><input type="submit" class="sharify-btn" value="<?php _e('Save Changes') ?>" /></p>			
					</div>

					<br /><div class="sharify-sec-title">Email</div>
					<?php wp_nonce_field('update-options'); ?>
					<?php settings_fields('sharify');?>	
					<div id="email" class="sharify-setting-wrap">
						<br><label><input type="checkbox" class="sharify-input" name="display_button_email" value="1" 
						<?php if ( 1 == get_option('display_button_email') ) echo 'checked="checked"'; ?> /> Email</label><br />
						<br><label><input type="checkbox" class="sharify-input" name="sharify_email_btn_size" value="1" 
						<?php if ( 1 == get_option('sharify_email_btn_size') ) echo 'checked="checked"'; ?> /> Display Small Button</label><br />
						
						<p class="sharify-version-no"><strong>Email Button main color</strong></p>
						<input type="text" id="color" value="<?php echo get_option('sharify_cpm_mail'); ?>" name="sharify_cpm_mail" class="sharify-cp color-picker" />
						<br /><p class="sharify-version-no"><strong>Email Button hover color</strong></p>
						<input type="text" id="color" value="<?php echo get_option('sharify_cph_mail'); ?>" name="sharify_cph_mail" class="sharify-cp color-picker" />
						<p class="submit"><input type="submit" class="sharify-btn" value="<?php _e('Save Changes') ?>" /></p>				
					</div>

					<br /><div class="sharify-sec-title">Uninstall</div>
					<?php wp_nonce_field('update-options'); ?>
					<?php settings_fields('sharify');?>	
					<div id="email" class="sharify-setting-wrap">
						<br><label><input type="checkbox" class="sharify-input" name="sharify_remove_data" value="1" 
						<?php if ( 1 == get_option('sharify_remove_data') ) echo 'checked="checked"'; ?> /> Remove Settings Data when unsinstalling? (will remove all Sharify data from database)</label><br />
						<p class="submit"><input type="submit" class="sharify-btn" value="<?php _e('Save Changes') ?>" /></p>					
					</div>
			</form>	
			</div>
		</div>
	</div>