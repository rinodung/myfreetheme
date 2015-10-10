<?php

/**
 * Default Blog Template
 */
?>
<?php get_header(); ?>

<?php spyropress_before_main_container(); ?>
<!-- content -->
<div role="main" class="main">
    <?php
        get_template_part( 'templates/top', 'blog' );
        get_template_part( 'templates/blog-content', get_setting( 'blog_layout', 'full' ) );
    ?>
</div>
<!-- /content -->
<?php spyropress_after_main_container(); ?>
<?php get_footer(); ?>