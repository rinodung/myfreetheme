<footer id="footer">
	<div class="container">
		<div class="row">
			<?php if( $ribbon = get_setting( 'footer_ribbon' ) ) { ?>
            <div class="footer-ribbon">
				<span><?php echo $ribbon; ?></span>
			</div>
            <?php } ?>
			<div class="col-md-3">
				<?php dynamic_sidebar( 'footer-1' ); ?>
			</div>
			<div class="col-md-3">
                <?php dynamic_sidebar( 'footer-2' ); ?>
			</div>
			<div class="col-md-4">
                <?php dynamic_sidebar( 'footer-3' ); ?>
			</div>
			<div class="col-md-2">
                <?php dynamic_sidebar( 'footer-4' ); ?>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">
			<div class="row">
                <?php if( $footer_logo = get_setting( 'footer_logo' ) ) { ?>
				<div class="col-md-1">
					<a href="<?php echo home_url(); ?>" class="logo">
						<img alt="<?php bloginfo( 'name' ) ?>" src="<?php echo $footer_logo; ?>">
					</a>
				</div>
                <?php } ?>
                <?php if( $copyright = get_setting( 'footer_copyright' ) ) { ?>
				<div class="col-md-7">
                    <?php echo do_shortcode( $copyright ); ?>
				</div>
                <?php } ?>
                <?php if( has_nav_menu( 'footer' ) ) { ?>
				<div class="col-md-4">
					<?php spyropress_get_nav_menu( 'container_id=sub-menu&menu_class=&container_class=', 'footer' ); ?>
				</div>
                <?php } ?>
			</div>
		</div>
	</div>
</footer>