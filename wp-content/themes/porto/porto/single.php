<?php
/**
 * Single Blog Page.
 *
 * @package Porto
 * @author Spyropress
 * @link http://spyropress.com
 */

get_header(); 

$translate['share-title'] = get_setting( 'translate' ) ? get_setting( 'post_share_title', 'Share this post' ) : __( 'Share this post', 'spyropress' );
?>

<?php spyropress_before_main_container(); ?>
<!-- content -->
<div role="main" class="main">
    <div id="content" class="content full">
    <?php
    $position = get_setting( 'blog_single_sidebar_position', 'right' );
    spyropress_before_loop();
    while( have_posts() ) {
        the_post();

        spyropress_before_post();
    ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php
            get_template_part( 'templates/top', 'post' );
            spyropress_before_post_content();
        ?>
            <div class="container">
                <div class="row">
                    <?php if( 'left' == $position ) { ?>
                    <div class="col-md-3">
                        <aside class="sidebar">
                            <?php dynamic_sidebar( 'blog' ); ?>
                        </aside>
                    </div>
                    <?php } ?>
                	<div class="col-md-9">
                        <div class="blog-posts single-post">
        					<article class="post post-large blog-single-post">
                                <?php get_template_part( 'templates/formats/content', get_post_format() ); ?>

                                <div class="post-date">
                                    <span class="day"><?php echo get_the_date( 'd' ) ?></span>
                                    <span class="month"><?php echo get_the_date( 'M' ) ?></span>
                                </div>

        						<div class="post-content">

        							<h2><?php the_title(); ?></h2>

        							<div class="post-meta">
        								<?php if( $author = get_the_author_link() ) { ?>
                                        <span><i class="fa fa-user"></i><?php _e( 'By ', 'spyropress' ); echo $author; ?> </span>
                                        <?php } ?>
                                        <?php the_tags( '<span><i class="fa fa-tag"></i> ', ', ', ' </span>' ); ?>
        								<span><i class="fa fa-comments"></i> <?php comments_popup_link( __( '0 Comments', 'spyropress' ) ); ?></span>
        							</div>

        							
                                    <?php the_content(); ?>
                                    
                                    <?php
                                        wp_link_pages( array(
                                            'before' => '<ul class="pagination pull-right">',
                                            'after' => '</ul><div class="clearfix"></div>',
                                        ) );
                                    ?>
                                    <?php if( get_setting( 'post_social_sharing' ) ) : ?>
                                    <div class="post-block post-share">
                                        <h3><i class="fa fa-share"></i><?php echo $translate['share-title']; ?></h3>
                                        <?php get_template_part( 'templates/add', 'this' ); ?>
                                    </div>
                                    <?php endif; ?>

                                    <?php get_template_part( 'templates/author', 'box' ); ?>

                                    <?php comments_template( '', true ); ?>
        						</div>
        					</article>
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
            </div>
            <?php spyropress_after_post_content(); ?>
        </div>
    <?php

        spyropress_after_post();
    }
    spyropress_after_loop();
    ?>
    </div>
</div>
<!-- /content -->
<?php spyropress_after_main_container(); ?>
<?php get_footer(); ?>