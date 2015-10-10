<?php

$translate['blog-title'] = get_setting( 'translate' ) ? get_setting( 'blog_title', 'Blog' ) : __( 'Blog', 'spyropress' );
$translate['archive-title'] = get_setting( 'translate' ) ? get_setting( 'archive_title', 'Archives' ) : __( 'Archives', 'spyropress' );
$translate['search-title'] = get_setting( 'translate' ) ? get_setting( 'saerch_title', 'Term:' ) : __( 'Term:', 'spyropress' );
?>
<section class="page-top">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb">
                <?php                    
                    if(function_exists('bcn_display')) {
                        bcn_display_list();
                    }  
                ?>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h1><?php
					if ( is_category() ) :
						single_cat_title();
                    elseif ( is_tag() ) :
						single_tag_title();
                    elseif ( is_day() ) :
						echo get_the_date();
					elseif ( is_month() ) :
						echo get_the_date( 'F Y' );
					elseif ( is_year() ) :
						echo get_the_date( 'Y' );
                    elseif ( is_home() ) :
                        echo $translate['blog-title'];
                    elseif ( is_search() ) :
						echo $translate['search-title'] . ' ' . get_search_query();
					else :
                        echo $translate['archive-title'];
					endif;
				?></h1>
			</div>
		</div>
	</div>
</section>