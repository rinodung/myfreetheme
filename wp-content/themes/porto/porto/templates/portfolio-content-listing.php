<?php
 echo '<ul class="portfolio-list">';

    if ( have_posts() ):
        while( have_posts() ):
            the_post();

            $image_tag = get_image( array(
                'post_id' => get_the_ID(),
                'echo' => false,
                'width' => 450,
                'responsive' => true,
                'class' => 'img-responsive'
            ) );

            echo $item_tmpl = '
            <li class="col-sm-6 col-xs-12 '. get_column_class(get_setting('columns')) .' isotope-item">
    			<div class="portfolio-item img-thumbnail">
    				<a href="' . get_permalink() . '" class="thumb-info">
    					' . $image_tag . '
    					<span class="thumb-info-title">
    						<span class="thumb-info-inner">' . get_the_title() . '</span>
    						<span class="thumb-info-type">' . single_cat_title( '', false ). '</span>
    					</span>
    					<span class="thumb-info-action">
    						<span title="' . __( 'Universal', 'spyropress' ) . '" class="thumb-info-action-icon"><i class="fa fa-link"></i></span>
    					</span>
    				</a>
    			</div>
    		</li>';
        endwhile;

    endif;



echo '</ul>';