<?php
/**
 * Footer
 */
?>
    <?php spyropress_before_footer(); ?>
    <!-- footer -->
    <?php
        spyropress_before_footer_content();
        $version = isset( $_GET['footer'] ) ? $_GET['footer'] :  get_setting( 'footer_style', 'v1' );
        spyropress_get_template_part( 'part=templates/footer/footer-' . $version );
        spyropress_after_footer_content();
    ?>
    <!-- /footer -->
    <?php spyropress_after_footer(); ?>
<?php spyropress_wrapper_end(); ?>
<?php spyropress_footer(); ?>
<?php wp_footer(); ?>
</body>
</html>