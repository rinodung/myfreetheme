<?php

$translate['read-more-title'] = get_setting( 'translate' ) ? get_setting( 'read_more_title', 'Read more...' ) : __( 'Read more...', 'spyropress' );
?>
<article class="post post-large">

	<div class="post-date">
		<span class="day"><?php echo get_the_date( 'd' ) ?></span>
		<span class="month"><?php echo get_the_date( 'M' ) ?></span>
	</div>
	<div class="post-content">
		<?php if( !in_array( get_post_format(), array( 'quote' ) ) ) : ?>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php the_excerpt(); ?>
        <?php elseif( 'quote' == get_post_format() ): ?>
            <blockquote>
                <?php the_content(); ?>
                <small><?php echo get_post_meta( get_the_ID(), '_format_quote_source_name', true ); ?></small>
            </blockquote>
        <?php endif; ?>
		<div class="post-meta">
			<?php if( $author = get_the_author_link() ) { ?>
			<span><i class="fa fa-user"></i><?php _e( 'By ', 'spyropress' ); echo $author; ?> </span>
            <?php } ?>
			<?php the_tags( '<span><i class="fa fa-tag"></i> ', ', ', ' </span>' ); ?>
            <span><i class="fa fa-comments"></i> <?php comments_popup_link( __( '0 Comments', 'spyropress' ) ); ?></span>
			<a href="<?php the_permalink(); ?>" class="btn btn-xs btn-primary pull-right"><?php echo $translate['read-more-title']; ?></a>
		</div>
	</div>
	<?php get_template_part( 'templates/formats/content', get_post_format() ); ?>
</article>