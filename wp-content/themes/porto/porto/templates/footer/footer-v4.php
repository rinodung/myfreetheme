<footer class="short" id="footer">
	<div class="container">
		<div class="row">
			<?php if( $about = get_setting( 'footer_about' ) ) { ?>
            <div class="col-md-8">
				<?php if( $about_title = get_setting( 'footer_about_title' ) ) { ?>
                <h4><?php echo $about_title; ?></h4>
                <?php } ?>
				<?php echo do_shortcode( $about ); ?>
				<hr class="light">
			</div>
            <?php } ?>
			<div class="col-md-3 col-md-offset-1">
				<?php dynamic_sidebar( 'footer-1' ); ?>
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
				<div class="col-md-11">
					<?php echo do_shortcode( $copyright ); ?>
				</div>
                <?php } ?>
			</div>
		</div>
	</div>
</footer>