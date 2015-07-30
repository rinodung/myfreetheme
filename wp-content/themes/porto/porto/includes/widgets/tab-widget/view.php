<?php

if( empty( $hide ) ) $hide = array();

echo $before_widget;

echo '<ul class="nav nav-tabs">';
    if( !in_array( 'popular', $hide ) ) echo '<li class="active" ><a href="#popularPosts" data-toggle="tab"><i class="fa fa-star"></i> ' . $popular_title . '</a></li>';
    if( !in_array( 'recent', $hide ) ) echo '<li><a href="#recentPosts" data-toggle="tab">' . $recent_title . '</a></li>';
    if( !in_array( 'comment', $hide ) ) echo '<li><a href="#recentComments" data-toggle="tab">' . $comments_title . '</a></li>';
echo '</ul>';

echo '<div class="tab-content">';
    if( !in_array( 'popular', $hide ) ) {
        echo '<div class="tab-pane active" id="popularPosts"><ul class="simple-post-list">';
        $popular_query = new WP_Query( array(
            'showposts' => $popular_posts,
            'nopaging' => 0,
            'orderby'=> 'comment_count',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1
        ) );
        
        while ( $popular_query->have_posts() ) {
            $popular_query->the_post();
            
            $img = '';
            if( has_post_thumbnail() )
                $img = '
                <div class="post-image">
                    <div class="img-thumbnail">
                        <a href="' . get_permalink() . '">
                            ' . get_image(array( 'width' => 58, 'height' => 58, 'crop' => true, 'echo' => false ) ) . '
                        </a>
                    </div>
				</div>';
                
            echo '
            <li>
                ' . $img . '
				<div class="post-info">
					<a href="' . get_permalink() . '">' . get_the_title() . '</a>
					<div class="post-meta">
						 ' . get_the_date() . '
					</div>
				</div>
            </li>';
		}
        wp_reset_query();
        echo '</ul></div>';
    }
    if( !in_array( 'recent', $hide ) ) {
        
        echo '<div class="tab-pane" id="recentPosts"><ul class="simple-post-list">';
        $popular_query = new WP_Query( array(
            'showposts' => $recent_posts,
            'nopaging' => 0,
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1
        ) );
        
        while ( $popular_query->have_posts() ) {
            $popular_query->the_post();
            
            $img = '';
            if( has_post_thumbnail() )
                $img = '
                <div class="post-image">
                    <div class="img-thumbnail">
                        <a href="' . get_permalink() . '">
                            ' . get_image(array( 'width' => 58, 'height' => 58, 'crop' => true, 'echo' => false ) ) . '
                        </a>
                    </div>
				</div>';

            echo '
            <li>
                ' . $img . '
				<div class="post-info">
					<a href="' . get_permalink() . '">' . get_the_title() . '</a>
					<div class="post-meta">
						 ' . get_the_date() . '
					</div>
				</div>
            </li>';
		}
        wp_reset_query();
        echo '</ul></div>';
    }
    if( !in_array( 'comment', $hide ) ) {
        
        $comments = get_comments( array(
            'number' => $comments,
            'status' => 'approve',
            'post_status' => 'publish'
        ) );
        
        if ( $comments ) {
            echo '<div class="tab-pane" id="recentComments"><ul class="simple-post-list">';
            
			foreach ( (array) $comments as $comment ) {            
                $url = esc_url( get_comment_link( $comment->comment_ID ) );
                
                echo '
                <li>
                    <div class="post-image">
                        <div class="thumbnail">
                            ' . get_avatar( $comment, 58 ) . '
                        </div>
    				</div>
    				<div class="post-info">
    					' . sprintf(_x('%2$s <span><em>by</em> %1$s</span>', 'widgets'), get_comment_author(), '<a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '">' . get_the_title($comment->comment_post_ID) . '</a>') . '
    					<div class="post-meta">
    						 ' . get_comment_date( '', $comment->comment_ID ) . '
    					</div>
    				</div>
                </li>';
            }
            
            echo '</ul></div>';
		}
    }
echo '</div>';

echo $after_widget;