<?php

get_template_part( 'templates/slider' );
get_template_part( 'templates/top', 'page' );

?>
<div id="post-<?php the_ID(); ?>" <?php post_class( 'container' ); ?>>
    <div class="row">
        <div class="col-md-9">
        <?php
            spyropress_before_post_content();
            echo str_replace( 'class="container"', 'class="container-null"', spyropress_get_the_content() );
            wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'spyropress' ), 'after' => '</div>' ) );
            spyropress_after_post_content();
        ?>
        </div>
        <div class="col-md-3">
            <aside class="sidebar">
                <?php dynamic_sidebar( 'page' ); ?>
            </aside>
        </div>
    </div>
</div>