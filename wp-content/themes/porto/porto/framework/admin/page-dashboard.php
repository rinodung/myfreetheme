<?php

/**
 * SpyroPress Dashboard
 *
 * Dashboard contains Latest News, Theme Info, Lates Tweets, etc.
 *
 */

global $spyropress;
?>

<div class="wrap spyropress-wrap">
	<?php require_if_theme_supports( 'spyropress-builder', admin_path() . 'page-verification.php' ); ?>
    <?php get_spyropress_badge(); ?>
    <h1><?php echo $spyropress->theme_name.' '.__( 'Dashboard', 'spyropress' ); ?></h1>
    <div class="teaser-text">
		<?php _e( 'Thank you for using SpyroPress. SpyroPress will improve your overall web publishing experience.', 'spyropress' ); ?>
	</div>
	<div class="clear"></div>
	<div id="dashboard-widgets" class="metabox-holder columns-2">
		<div id="postbox-container-1" class="postbox-container">
			<div id="dashboard_theme_info" class="postbox">
				<h3 class="hndle">
                    <?php _e( 'Theme Info', 'spyropress'); ?>
				</h3>
				<div class="inside">
					<ul>
						<li>
							<?php _e( 'Framework Version:', 'spyropress'); ?>
							<strong>
								<?php echo spyropress_get_version(); ?>
							</strong>
						</li>
                        <li>
							<?php _e( 'Product Version:', 'spyropress'); ?>
							<strong>
								<?php echo $spyropress->theme_version; ?>
							</strong>
						</li>
						<li>
							<?php _e( 'Product Support:', 'spyropress'); ?>
							<?php get_documentation_link(); ?> | <?php get_support_forum_link(); ?> | <?php get_suggest_link(); ?> | <?php get_showcase_link(); ?>
						</li>
					</ul>
					<br class="clear"/>
				</div>
			</div>
		</div>
		<div id="postbox-container-2" class="postbox-container">
			<div id="dashboard_spyropress_changelog" class="postbox">
				<h3 class="hndle">
					<?php _e( 'Theme Changelog', 'spyropress'); ?>
				</h3>
				<div class="inside">
					<?php $theme_log = spyropress_get_theme_changelog(); if ( !empty( $theme_log ) ) echo $theme_log->changelog; ?>
						<br class="clear"/>
				</div>
			</div>
		</div>
		<div class="clear">
		</div>
	</div>
</div>