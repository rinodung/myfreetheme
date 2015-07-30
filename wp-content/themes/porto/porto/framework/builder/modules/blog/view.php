<?php spyropress_before_loop(); ?>
        <div class="blog-posts">
        <?php
            $instance = spyropress_clean_array( $instance );
            $args = $this->query( $instance );
            $blog_query = new WP_Query( $args );
            
            if( $blog_query->have_posts() ) {
                while( $blog_query->have_posts() ) {
                    $blog_query->the_post();
                    spyropress_before_post();
                        get_template_part( 'templates/blog', 'loop' );
                    spyropress_after_post();
                }
                
                wp_reset_query();
                
                wp_pagenavi( array( 'query' => $blog_query ) );
            }
        ?>
        </div>
<?php spyropress_after_loop(); ?>