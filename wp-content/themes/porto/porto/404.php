<?php
/**
 * 404 page.
 *
 * @package Porto
 * @author Spyropress
 * @link http://spyropress.com
 */

get_header(); 

$translate['404-title'] = get_setting( 'translate' ) ? get_setting( 'error-404-title', '404' ) : __( '404', 'spyropress' );
$translate['404-subtitle'] = get_setting('translate') ? get_setting( 'error-404-subtitle', '404 - Page Not Found' ) : __( '404 - Page Not Found', 'spyropress' );
$translate['404-text'] = get_setting('translate') ? get_setting( 'error-404-text', ' We\'re sorry, but the page you were looking for doesn\'t exist.' ) : __( ' We\'re sorry, but the page you were looking for doesn\'t exist.', 'spyropress' );
$translate['404-link-title'] = get_setting('translate') ? get_setting( 'error-404-link-title', 'Here are some useful links' ) : __( 'Here are some useful links', 'spyropress' );
?>

<?php spyropress_before_main_container(); ?>
<!-- content -->
<div role="main" class="main">
    <section class="page-top">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-12">
    				<ul class="breadcrumb">
                    <?php                    
                        if(function_exists('bcn_display')) {
                            bcn_display_list();
                        }  
                    ?>
                    </ul>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-md-12">
    				<h2><?php echo $translate['404-subtitle']; ?></h2>
    			</div>
    		</div>
    	</div>
    </section>
    <div class="container">
        <section class="page-not-found">
    		<div class="row">
    			<div class="col-md-6 col-md-offset-1">
    				<div class="page-not-found-main">
    					<h2><?php echo $translate['404-title']; ?> <i class="fa fa-file"></i></h2>
    					<p><?php echo $translate['404-text']; ?></p>
    				</div>
    			</div>
    			<div class="col-md-4">
    				<h4><?php echo $translate['404-link-title']; ?></h4>
    				<?php
                        spyropress_get_nav_menu( array(
                            'container' => false,
                            'menu_class' => 'nav nav-list primary'
                        ), 'page-404' );
                    ?>
    			</div>
    		</div>
    	</section>
     </div>
</div>
<!-- /content -->
<?php spyropress_after_main_container(); ?>
<?php get_footer(); ?>