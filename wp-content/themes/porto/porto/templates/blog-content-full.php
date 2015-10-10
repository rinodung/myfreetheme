<div class="container">
    <?php spyropress_before_loop(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="blog-posts">
            <?php
                while( have_posts() ) {
                    the_post();
                    spyropress_before_post();
                        get_template_part( 'templates/blog', 'loop' );
                    spyropress_after_post();
                }
                wp_pagenavi();
            ?>
            </div>
        </div>
    </div>
    <?php spyropress_after_loop(); ?>
</div>