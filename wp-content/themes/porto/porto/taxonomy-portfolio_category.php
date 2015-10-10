<?php

/**
 * Default Taxonomy Template
 */
?>
<?php get_header(); ?>

<?php spyropress_before_main_container(); ?>
<!-- content -->
<div role="main" class="main">
        
        <?php
            
            get_template_part( 'templates/top-page', 'portfolio' ); 
            get_template_part( 'templates/portfolio-content', get_setting( 'portfolio_layout', 'full' ) );
        ?>       
            
        
</div>
<!-- /content -->
<?php spyropress_after_main_container(); ?>
<?php get_footer(); ?>
 
