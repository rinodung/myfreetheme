<?php

if( !get_setting( 'related_portfolio_enable', false ) ) return;

$limit = get_setting( 'related_portfolio_number', 4 );
$related_by = get_setting( 'related_portfolio_by' );

global $post;
$args = array(
    'post__not_in'      => array( $post->ID ),
    'posts_per_page'    => $limit,
    'ignore_sticky_posts'  => 1,
    'post_type'         => 'portfolio'
);

// by tags
if( 'portfolio_service' == $related_by ) {
    $tags = wp_get_post_terms( $post->ID, 'portfolio_service' );
    if ( $tags ) {
        $tag_ids = array();
        foreach( $tags as $individual_tag )
            $tag_ids[] = $individual_tag->term_id;
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'portfolio_service',
                'field' => 'id',
                'terms' => $tag_ids
            )
        );
    }
}
// by category
elseif( 'portfolio_category' == $related_by ) {
    $categories = wp_get_post_terms( $post->ID, 'portfolio_category' );
    if ( $categories ) {
        $category_ids = array();
        foreach( $categories as $individual_category )
            $category_ids[] = $individual_category->term_id;
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'portfolio_category',
                'field' => 'id',
                'terms' => $category_ids
            )
        );
    }
}

$my_query = new wp_query( $args );
if( $my_query->have_posts() ) {

$translate['portfolio-title'] = get_setting( 'translate' ) ? get_setting( 'related_portfolio_title', 'Related <strong>Work</strong>' ) : __( 'Related <strong>Work</strong>', 'spyropress' );
?>
<div class="row">     
    <div class="col-md-12">
    	<h3><?php echo $translate['portfolio-title']; ?></h3>
    </div>
    
    <ul class="portfolio-list">
        <?php
            while( $my_query->have_posts() ) {
                $my_query->the_post();
            
                $image = array(
                    'echo' => false,
                    'width' => 300,
                    'responsive' => true,
                    'class' => 'img-responsive'
                );
                $image_tag = get_image( $image );
                
                $cat = array();
                $terms = get_the_terms( get_the_ID(), 'portfolio_category' );
                if( !empty( $terms ) && !is_wp_error( $terms ) ) {
                    foreach( $terms as $term )
                        $cat[] = $term->name;
                }
        ?>
        <li class="col-md-3">
    		<div class="portfolio-item thumbnail">
    			<a href="<?php the_permalink(); ?>" class="thumb-info">
    				<?php echo $image_tag; ?>
    				<span class="thumb-info-title">
    					<span class="thumb-info-inner"><?php the_title(); ?></span>
    					<span class="thumb-info-type"><?php echo join( ', ', $cat ); ?></span>
    				</span>
    				<span class="thumb-info-action">
    					<span title="<?php esc_attr_e( 'View', 'spyropress' ) ?>" href="#" class="thumb-info-action-icon"><i class="fa fa-link"></i></span>
    				</span>
    			</a>
    		</div>
    	</li>
        <?php
            }
        ?>
    </ul>    
</div>
<?php
}
wp_reset_query();
?>