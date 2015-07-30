<!-- panel-body -->
<div class="panel-body">
    <!-- panel-nav -->
    <div class="panel-nav">
    	<ul>
    		<?php echo $this->build_nav(); ?>
    	</ul>
    </div>
    <!-- /panel-nav -->
    <!-- panel-content -->
    <div class="panel-content">
        <div class="panel-content-inner">
            <?php $this->build_content(); ?>
        </div>
    </div>
    <!-- /panel-content -->
</div>
<!-- /panel-body -->