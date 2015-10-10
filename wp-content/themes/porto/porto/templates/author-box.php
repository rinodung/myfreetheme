<?php

if( !get_setting( 'meta_authorbox' ) ) return;

$translate['author-title'] = get_setting( 'translate' ) ? get_setting( 'authorbox_title', 'Author' ) : __( 'Author', 'spyropress' );
?>
<div class="post-block post-author clearfix">
    <h3><i class="fa fa-user"></i><?php echo $translate['author-title']; ?></h3>
    <div class="img-thumbnail">
        <a href="#">
            <?php echo get_avatar( get_the_author_meta( 'email' ), '150' ); ?>
        </a>
    </div>
    <p><strong class="name"><a href="#"><?php the_author_meta( "display_name" ) ?></a></strong></p>
    <p><?php the_author_meta( "user_description" ); ?></p>
</div>