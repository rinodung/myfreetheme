<div class="spyropress-panel-meta" id="spyropress_<?php echo $this->get_id(); ?>">
<?php
    // Nonce Field Security
    wp_nonce_field( 'spyropress_metabox_nonce' , 'security', false );
    echo '<input type="hidden" name="spyropress_metabox[]" value="' . $this->get_id() . '" />';
?>
    <?php if( $this->is_build_tabs() ) { ?>
    <div class="panel-tabs">
    	<ul>
    		<?php echo $this->build_nav(); ?>
    	</ul>
        <div class="clear"></div>
    </div>
    <!-- /panel-tabs -->
    <?php } ?>
    <div class="panel-body">
        <div class="panel-content <?php echo ( $this->is_build_tabs() ) ? 'has-tabs' : 'no-tabs' ?>">
            <?php $this->build_content(); ?>
        </div>
    </div>
    <!-- /panel-body -->
</div>