<?php
if( $ids = get_post_meta( get_the_ID(), '_format_gallery_embed', true ) ) {
    
    $ids = explode( ',', str_replace( array( '[gallery ids=', ']', '"' ), '', $ids ) );
    
    if ( !empty( $ids ) ) {
?>
<div class="post-image">
    <div class="owl-carousel" data-plugin-options='{"items":1}'>
    <?php
        foreach( $ids as $id ) {
            $image = get_image( array(
                'attachment' => $id,
                'width' => 9999,
                'responsive' => true,
                'class' => 'img-responsive',
                'before' => '<div><div class="img-thumbnail">',
                'after' => '</div></div>'
            ));
        }
    ?>
	</div>
</div>
<?php
    }
}
?>