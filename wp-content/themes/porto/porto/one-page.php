<?php
/*
Template Name: OnePage
 */
?>
<?php get_header( 'one-page' ); ?>

<?php spyropress_before_main_container(); ?>
<!-- content -->
<div role="main" class="main" id="home">
    <div id="content" class="content full">
    <?php
    spyropress_before_loop();
    while( have_posts() ) {
        the_post();

        spyropress_before_post();

            get_template_part( 'templates/page', 'content' );

        spyropress_after_post();
    }
    spyropress_after_loop();
    ?>
    </div>
</div>
<!-- /content -->
<?php spyropress_after_main_container(); ?>
<?php get_footer(); ?>