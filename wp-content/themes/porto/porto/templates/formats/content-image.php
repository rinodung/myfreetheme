<?php if( has_post_thumbnail() ) { ?>
<div class="post-image single">
    <?php get_image( array( 'width' => 9999, 'class' => 'img-thumbnail' )); ?>
</div>
<?php } ?>