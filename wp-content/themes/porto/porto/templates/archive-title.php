<h1 class="page-title">
<?php
    $translate['blog-title'] = get_setting( 'translate' ) ? get_setting( 'blog-title', '<span>Our</span> Blog' ) : __( '<span>Our</span> Blog', 'spyropress' );
    $translate['cat-title'] = get_setting( 'translate' ) ? get_setting( 'cat-title', '<span>Category:</span> %s' ) : __( '<span>Category:</span> %s', 'spyropress' );
    $translate['tag-title'] = get_setting( 'translate' ) ? get_setting( 'tag-title', '<span>Tag:</span> %s' ) : __( '<span>Tag:</span> %s', 'spyropress' );
    $translate['day-title'] = get_setting( 'translate' ) ? get_setting( 'day-title', '<span>Daily:</span> %s' ) : __( '<span>Daily:</span> %s', 'spyropress' );
    $translate['month-title'] = get_setting( 'translate' ) ? get_setting( 'month-title', '<span>Monthly:</span> %s' ) : __( '<span>Monthly:</span> %s', 'spyropress' );
    $translate['year-title'] = get_setting( 'translate' ) ? get_setting( 'year-title', '<span>Yearly:</span> %s' ) : __( '<span>Yearly:</span> %s', 'spyropress' );
    $translate['archive-title'] = get_setting( 'translate' ) ? get_setting( 'archive-title', 'Archives' ) : __( 'Archives', 'spyropress' );
    
    if( is_home() || is_single() ) :
        echo $translate['blog-title'];
    elseif ( is_category() ) :
    	printf( $translate['cat-title'], single_cat_title( '', false ) );
    elseif ( is_tag() ) :
    	printf( $translate['tag-title'], single_tag_title( '', false ) );
    elseif ( is_day() ) :
    	printf( $translate['day-title'], get_the_date() );
    elseif ( is_month() ) :
    	printf( $translate['month-title'], get_the_date( _x( 'F Y', 'monthly archives date format', 'spyropress' ) ) );
    elseif ( is_year() ) :
    	printf( $translate['year-title'], get_the_date( _x( 'Y', 'yearly archives date format', 'spyropress' ) ) );
    else :
    	echo $translate['archive-title'];
    endif;
?>
</h1>