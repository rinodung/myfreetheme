<header id="header" class="clean-top center">
	<div class="header-top">
		<div class="container">
			<?php include_once 'topbar.php'; ?>
			<?php spyropress_social_icons( 'header_social' ); ?>
            <?php include_once 'searchform.php'; ?>
		</div>
	</div>
	<div class="container">
		<?php if( $logo = get_setting( 'logo', false ) ) : ?>
        <h1 class="logo">
			<a href="<?php echo esc_url( home_url( '/' ) ) ?>">
				<img alt="<?php bloginfo( 'name' ) ?>" width="<?php get_setting_e( 'logo_width', 111 ) ?>" height="<?php get_setting_e( 'logo_height', 54 ) ?>" data-sticky-width="<?php get_setting_e( 'stk_logo_width', 82 ) ?>" data-sticky-height="<?php get_setting_e( 'stk_logo_height', 40 ) ?>" src="<?php echo $logo ?>">
			</a>
		</h1>
        <?php endif; ?>
        <button class="btn btn-responsive-nav btn-inverse" data-toggle="collapse" data-target=".nav-main-collapse">
		  <i class="fa fa-bars"></i>
		</button>
    </div>
	<div class="navbar-collapse nav-main-collapse collapse">
        <div class="container">
    		<?php
                spyropress_get_nav_menu( array(
                    'container_class' => 'nav-main mega-menu',
                    'menu_class' => 'nav nav-pills nav-main',
                    'menu_id' => 'mainMenu'
                ) );
            ?>
    	</div>
     </div>
</header>