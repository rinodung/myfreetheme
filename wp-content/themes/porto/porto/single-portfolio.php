<?php
/**
 * Single Blog Page.
 *
 * @package Porto
 * @author Spyropress
 * @link http://spyropress.com
 */

get_header();

$translate['description-title'] = get_setting( 'translate' ) ? get_setting( 'portfolio_desc_title', 'Project <strong>Description</strong>' ) : __( 'Project <strong>Description</strong>', 'spyropress' );
$translate['preview-title'] = get_setting( 'translate' ) ? get_setting( 'portfolio_preview_title', 'Live Preview' ) : __( 'Live Preview', 'spyropress' );
$translate['service-title'] = get_setting( 'translate' ) ? get_setting( 'portfolio_service_title', 'Services' ) : __( 'Services', 'spyropress' );
$translate['client-title'] = get_setting( 'translate' ) ? get_setting( 'portfolio_client_title', 'Client' ) : __( 'Client', 'spyropress' );
$translate['testimonial-title'] = get_setting( 'translate' ) ? get_setting( 'portfolio_testimonial_title', 'Client Testimonial' ) : __( 'Client Testimonial', 'spyropress' );

?>

<?php spyropress_before_main_container(); ?>
<!-- content -->
<div role="main" class="main">
    <div id="content" class="content full">
    <?php
    spyropress_before_loop();
    while( have_posts() ) {
        the_post();

        spyropress_before_post();
        
        $showcase_type = get_post_meta( get_the_ID(), 'p_type', true );
        $col1 = $col2 = 'col-md-6';
        
        if( 'gallery' == $showcase_type ) {
            $col1 = 'col-md-4';
            $col2 = 'col-md-8';
        }
    ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php
            get_template_part( 'templates/top-page', 'portfolio' );
            spyropress_before_post_content();
        ?>
            <div class="container">
                <div class="portfolio-title">
                    <div class="row">
                    <?php if( 'title' == get_setting( 'portfolio_header_style', 'title' ) )  { ?>
                        <div class="col-md-12">
                            <h2 class="shorter"><?php the_title(); ?></h2>
                        </div>
                    <?php } else { ?>
						<div class="portfolio-nav-all col-md-1">
							<a href="<?php echo home_url( '/portfolio/' ) ?>" rel="tooltip" data-original-title="<?php esc_attr_e( 'Back to list', 'spyropress' ) ?>"><i class="fa fa-th"></i></a>
						</div>
						<div class="col-md-10 center">
							<h2 class="shorter"><?php the_title(); ?></h2>
						</div>
						<div class="portfolio-nav col-md-1">
                            <?php echo spyropress_get_next_prev_portfolio_link(); ?>
						</div>
                    <?php } ?>
                    </div>
                </div>
                
				<hr class="tall">
                
                <div class="row">
                    <div class="<?php echo $col1; ?>">
                    <?php                        
                        if( 'gallery' == $showcase_type ) {
                            if( $ids = get_post_meta( get_the_ID(), 'gallery', true ) ) {
                                $ids = explode( ',', str_replace( array( '[gallery ids=', ']', '"' ), '', $ids ) );
                                
                                if ( !empty( $ids ) ) {
                    ?>
                        <div class="owl-carousel" data-plugin-options='{"items": 1, "autoHeight": true}'>
                        <?php
                            foreach( $ids as $id ) {
                                $image = get_image( array(
                                    'attachment' => $id,
                                    'width' => 9999,
                                    'responsive' => true,
                                    'class' => 'img-responsive',
                                    'before' => '<div><div class="thumbnail">',
                                    'after' => '</div></div>'
                                ));                                
                            }
                        ?>
                		</div>
                    <?php
                                }
                            }
                        }
                        elseif( 'video' == $showcase_type ) {
                            echo wp_oembed_get( get_post_meta( get_the_ID(), 'video', true ) ) . '<br>';
                        }
                        elseif( has_post_thumbnail() ) {
                    ?>
                        <div class="owl-carousel" data-plugin-options='{"items": 1, "autoHeight": true}'>
                        <?php
                            $image = get_image( array(
                                'attachment' => get_post_thumbnail_id(),
                                'width' => 560,
                                'responsive' => false,
                                'class' => 'img-responsive',
                                'before' => '<div><div class="thumbnail">',
                                'after' => '</div></div>'
                            ));
                        ?>
                        </div>
                    <?php
                        }
                    ?>
                    <?php if( get_setting( 'portfolio_social_sharing' ) ) { get_template_part( 'templates/add', 'this' ); } ?>
                	</div>

                	<div class="<?php echo $col2; ?>">

                        <div class="portfolio-info">
							<div class="row">
								<div class="col-md-12 center">
									<ul>
										<li>
                                            <span rel="tooltip" data-original-title="<?php esc_attr_e( 'View', 'spyropress' ) ?>"><i class="fa fa-eye"></i><?php spyropress_post_views( get_the_ID(), '', '' ) ?></span>
										</li>
										<li>
											<i class="fa fa-calendar"></i> <?php the_date(); ?>
										</li>
                                        <?php the_terms( get_the_ID(), 'portfolio_category', '<li><i class="fa fa-tags"></i> ', ', ', '</li>' ); ?>
									</ul>
								</div>
							</div>
						</div>
                		<h4><?php echo $translate['description-title']; ?></h4>
                		<?php the_content(); ?>

                        <?php
                        // live url
                        $live_url = get_post_meta( get_the_ID(), 'project_url', true );
                        if( !empty( $live_url ) )
                            echo '<a href="' . $live_url . '" class="btn btn-primary btn-icon"><i class="fa fa-external-link"></i>' . $translate['preview-title'] . '</a> <span class="arrow hlb hidden-phone" data-appear-animation="rotateInUpLeft" data-appear-animation-delay="800"></span>';
                        ?>
                        <ul class="portfolio-details">
                            <?php
                            $terms = get_the_terms( get_the_ID(), 'portfolio_service' );
                            if( !empty( $terms ) && !is_wp_error( $terms ) ) {
                            ?>
        					<li>
        						<p><strong><?php echo $translate['service-title'] ?>:</strong></p>

        						<ul class="list list-skills icons list-unstyled list-inline">
       							<?php
                                foreach( $terms as $term ) {
                                    echo '<li><i class="fa fa-check-circle"></i> ' . $term->name . '</li>';
                                }
                                ?>
        						</ul>
        					</li>
                            <?php } ?>
                            <?php if( $client = get_post_meta( get_the_ID(), 'project_client', true ) ) { ?>
        					<li>
        						<p><strong><?php echo $translate['client-title']; ?>:</strong></p>
        						<p><?php echo $client ?></p>
        					</li>
                            <?php } ?>
                            <?php if( $testimonial = get_post_meta( get_the_ID(), 'project_testimonial', true ) ) { ?>
        					<li>
        						<p><strong><?php echo $translate['testimonial-title']; ?>:</strong></p>
        						<blockquote>
        							<?php echo $testimonial ?>
        						</blockquote>
        					</li>
                            <?php } ?>
        				</ul>
                	</div>
                </div>

                <hr class="tall" />

                <?php get_template_part( 'templates/related', 'works' ); ?>
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