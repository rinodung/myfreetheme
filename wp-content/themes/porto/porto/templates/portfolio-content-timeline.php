<?php

echo '<section class="timeline" id="timeline"><div class="timeline-body" id="timeline-body">';
        $counter = 1;
    if ( have_posts() ):
        while( have_posts() ):
            the_post();

            $image_tag = get_image( array(
                'echo' => false,
                'width' => 450,
                'responsive' => true,
                'class' => 'img-responsive'
            ) );

            $post_alt = ( $counter % 2 ) ? 'left' : 'right';
            $date_header = $date = '';
            $date = the_date( '', '', '', false );
            
            if( $date ) {
                $date_header = '<div class="timeline-date"><h3>' . $date . '</h3></div>';
            }

            echo   $item_tmpl = $date_header . '
            <article class="timeline-box ' . $post_alt . '">
            	<div class="portfolio-item img-thumbnail">
            		<a href="' . get_permalink() . '" class="thumb-info">
            			' . $image_tag . '
            			<span class="thumb-info-title">
            				<span class="thumb-info-inner">' . get_the_title() . '</span>
            				<span class="thumb-info-type">' . single_cat_title( '', false ) . '</span>
            			</span>
            			<span class="thumb-info-action">
            				<span title="' . __( 'Universal', 'spyropress' ) . '" class="thumb-info-action-icon"><i class="fa fa-link"></i></span>
            			</span>
            		</a>
            	</div>
            </article>';

            $counter++;

         endwhile;
    endif;
echo '</div></section>';