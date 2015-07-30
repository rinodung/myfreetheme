<?php
/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */

if ( post_password_required() ) return;

$translate['comment'] = get_setting( 'translate' ) ? get_setting( 'translate-comment', 'Comment' ) : __( 'Comment', 'spyropress' );
$translate['comments'] = get_setting( 'translate' ) ? get_setting( 'translate-comments', 'Comments' ) : __( 'Comments', 'spyropress' );
$translate['comments-off'] = get_setting( 'translate' ) ? get_setting( 'translate-comments-off', 'Comments are closed.' ) : __( 'Comments are closed.', 'spyropress' );
$translate['reply-title'] = get_setting( 'translate' ) ? get_setting( 'translate-reply-title', 'Leave a comment' ) : __( 'Leave a comment', 'spyropress' );
$translate['reply-btn'] = get_setting( 'translate' ) ? get_setting( 'translate-reply-btn', 'Post Comment' ) : __( 'Post Comment', 'spyropress' );

?>

<?php if ( have_comments() ) { ?>
<div class="post-block post-comments">
    <h3><i class="fa fa-comments"></i>
    <?php
        $num_comments = get_comments_number();
        if( $num_comments != 1 )
            printf( '%1$s (%2$s)', $translate['comments'], number_format_i18n( $num_comments ) );
        else
            printf( '%1$s (%2$s)', $translate['comment'], number_format_i18n( $num_comments ) );
        ?>
	</h3>

	<ul class="comments">
		<?php
            ob_start();
			wp_list_comments( array(
				'short_ping'  => true,
                'callback' => 'spyropress_comment'
			) );
            echo str_replace( 'class="children"', 'class="comments"', ob_get_clean() );
		?>
	</ul><!-- .comment-list -->

	<?php
		// Are there comments to navigate through?
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav class="navigation comment-navigation" role="navigation">
		<h1 class="screen-reader-text section-heading"><?php _e( 'Comment navigation', 'spyropress' ); ?></h1>
		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'spyropress' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'spyropress' ) ); ?></div>
	</nav><!-- .comment-navigation -->
	<?php endif; // Check for comment navigation ?>

    <?php if ( ! comments_open() ) { echo '<p class="no-comments">' . $translate['comments-off'] . '</p>'; } ?>

</div><!-- #comments -->
<?php } // end_if have_comments ?>


<div class="post-block post-leave-comment">
<?php
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );

    $fields = array();
    $fields['author'] = '<div class="row"><div class="form-group"><div class="col-md-6"><label for="author">' . __( 'Your name (required)', 'spyropress' ) . '</label><input id="author" name="author" type="text" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) . '"' . $aria_req . ' /></div>';
    $fields['email'] = '<div class="col-md-6"><label for="email">' . __( 'Your email (required)', 'spyropress' ) . '</label><input id="email" name="email" type="text" class="form-control" value="' . esc_attr(  $commenter['comment_author_email'] ) . '"' . $aria_req . ' /></div></div></div>';
    $fields['url'] = '<div class="row"><div class="form-group"><div class="col-md-12"><label for="url">' . __( 'Website', 'spyropress' ) . '</label><input id="url" name="url" type="text" class="form-control" placeholder="http://" value="' . esc_attr( $commenter['comment_author_url'] ) . '" /></div></div></div>';

    $args = array(
        'title_reply' => $translate['reply-title'],
        'fields' => $fields,
        'comment_field' => '<div class="row"><div class="form-group"><div class="col-md-12"><label>' . __( 'Comment', 'spyropress' ) . '</label><textarea id="comment" name="comment" rows="10" class="form-control"></textarea></div></div></div>',
        'format' => 'html5',
        'label_submit' => $translate['reply-btn'],
        'comment_notes_before' => '<p class="comment-notes push-bottom">' . __( 'Your email address will not be published.', 'spyropress' ) . '</p>',
        'comment_notes_after' => ''
    );

    ob_start();
    comment_form( $args );
    $comment_form = ob_get_clean();
    $comment_form = str_replace( 'id="submit"', 'id="submit" class="btn btn-primary btn-lg" ', $comment_form );

    echo $comment_form;
?>
</div>