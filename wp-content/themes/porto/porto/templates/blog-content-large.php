<?php $position = get_setting( 'blog_sidebar_position', 'right' );  ?>

<div class="container">
    <?php spyropress_before_loop(); ?>
    <div class="row">
        <?php if( 'left' == $position ) { ?>
        <div class="col-md-3">
            <aside class="sidebar">
                <?php dynamic_sidebar( 'blog' ); ?>
            </aside>
        </div>
        <?php } ?>
        <div class="col-md-9">
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
        <?php if( 'right' == $position ) { ?>
        <div class="col-md-3">
            <aside class="sidebar">
                <?php dynamic_sidebar( 'blog' ); ?>
            </aside>
        </div>
        <?php } ?>
    </div>
    <?php spyropress_after_loop(); ?>
</div>