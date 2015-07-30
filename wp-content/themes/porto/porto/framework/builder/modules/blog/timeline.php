<?php 

spyropress_before_loop();

$counter = 0;
$translate['read-more-title'] = get_setting( 'translate' ) ? get_setting( 'read_more_title', 'Read more...' ) : __( 'Read more...', 'spyropress' );

$args = $this->query( spyropress_clean_array( $instance ) );
$blog_query = new WP_Query( $args );
?>
<div class="blog-posts">
    <section class="timeline">
        <div class="timeline-body" id="timeline-body">
            <?php                
                if( $blog_query->have_posts() ) {
                    while( $blog_query->have_posts() ) {
                        $blog_query->the_post();
                        
                        $date = the_date( '', '', '', false );
                        if( $date ) {
                            $counter = 0;
                            echo '<div class="timeline-date"><h3>' . $date . '</h3></div>';
                        }
                        
                        $post_alt = ( ++$counter % 2 ) ? 'left' : 'right';
                        
                        spyropress_before_post();
            ?>
            <article class="timeline-box post post-medium <?php echo $post_alt; ?>">
                <div class="row">
                	<div class="col-md-12">
                        <?php get_template_part( 'templates/formats/content', get_post_format() ); ?>
                        
                        <div class="post-content">
                    		<?php if( !in_array( get_post_format(), array( 'quote' ) ) ) : ?>
                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <?php the_excerpt(); ?>
                            <?php elseif( 'quote' == get_post_format() ): ?>
                                <blockquote>
                                    <?php the_content(); ?>
                                    <small><?php echo get_post_meta( get_the_ID(), '_format_quote_source_name', true ); ?></small>
                                </blockquote>
                            <?php endif; ?>
                    	</div>
                        <div class="post-meta">
                			<span><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?> </span><br>
                		</div>
                        <div class="post-meta">
                			<?php if( $author = get_the_author_link() ) { ?>
                			<span><i class="fa fa-user"></i><?php _e( 'By ', 'spyropress' ); echo $author; ?> </span>
                            <?php } ?>
                			<?php the_tags( '<span><i class="fa fa-tag"></i> ', ', ', ' </span>' ); ?>
                            <span><i class="fa fa-comments"></i> <?php comments_popup_link( __( '0 Comments', 'spyropress' ) ); ?></span>
                		</div>
                        
                        <a href="<?php the_permalink() ?>" class="btn btn-xs btn-primary pull-right"><?php echo $translate['read-more-title']; ?></a>
                        
                	</div>
                </div>
            </article>
            <?php
                        spyropress_after_post();
                    } 
                    wp_reset_query();
                }
            ?>
            <div class="timeline-date load-more-posts">
                <h3><a href="#" data-target="#timeline-body" data-loading="Loading...">Load More...</a></h3>
                <?php wp_pagenavi( array( 'container_class' => 'time-pagination hidden', 'query' => $blog_query ) ); ?>
            </div>
        </div>
    </section>
</div>
<?php spyropress_after_loop(); ?>