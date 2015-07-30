<div id="builder-dialogs" class="builder-hide">
    <div id="builder-delete-row" class="error-popup builder-popup">
		<div class="builder-popup-header">
			<h2>Are you sure you want to delete this row?</h2>
		</div>
		<div class="builder-popup-content">
			<p>
				All information and settings for the row
				<em>
					will be permanently lost
				</em>
				.
			</p>
		</div>
        <div class="builder-popup-footer">
            <span class="builder-popup-activity builder-hide">Removing Row&hellip;</span>
            <button id="builder-delete-row-confirm" class="button-red button-data">Delete Row</button>
            <span>or </span>
            <a id="builder-delete-row-popup-close" class="builder-popup-close" href="#">Cancel</a>
		</div>
	</div>
    <!-- /builder-delete-row-popup -->
    <div id="builder-delete-column" class="error-popup builder-popup">
		<div class="builder-popup-header">
			<h2>Are you sure you want to delete this column?</h2>
		</div>
		<div class="builder-popup-content">
			<p>
				All information and settings for the column <em>will be permanently lost</em>.
			</p>
		</div>
        <div class="builder-popup-footer">
            <span class="builder-popup-activity builder-hide">Removing Column&hellip;</span>
            <button id="builder-delete-column-confirm" class="button-red button-data">Delete Column</button>
            <span>or </span>
            <a id="builder-delete-column-popup-close" class="builder-popup-close" href="#">Cancel</a>
		</div>
	</div>
    <!-- /builder-delete-column-popup -->
    <div id="builder-delete-module" class="error-popup builder-popup">
		<div class="builder-popup-header">
			<h2>Are you sure you want to delete this module?</h2>
		</div>
		<div class="builder-popup-content">
			<p>
				All information and settings for the module
				<em>
					will be permanently lost
				</em>
				.
			</p>
		</div>
        <div class="builder-popup-footer">
            <span class="builder-popup-activity builder-hide">Removing Module&hellip;</span>
            <button id="builder-delete-module-confirm" class="button-red button-data">Delete Module</button>
            <span>or </span>
            <a id="builder-delete-module-popup-close" class="builder-popup-close" href="#">Cancel</a>
		</div>
	</div>
    <!-- /builder-delete-module-popup -->
    <div id="builder-popup-wrapper" class="builder-popup">
    </div>
    <!-- /builder-general-popup -->
    <div id="builder-error-popup" class="error-popup builder-popup">
		<div class="builder-popup-header">
			<h2>Oops! An Error Has Occurred</h2>
		</div>
		<div class="builder-popup-content">
			<div id="builder-error-message">
			</div>
		</div>
		<div class="builder-popup-footer">
			<a href="#" id="builder-error-popup-close" class="builder-popup-close">Close</a>
		</div>
	</div>
    <!-- /builder-error-popup -->
    <div id="builder-modules" class="builder-popup">
		<div class="builder-popup-header">
			<h2>Choose a Type of Content</h2>
            <p>Select a module or widget to add to your content</p>
		</div>
		<div class="builder-popup-content">
            <?php if(get_current_post_type() == 'template') { ?>
            <h3 class="module-list-head">Loop Components</h3>
            <ul class="builder-module-list">
                <?php spyropress_builder_render_modules(true); ?>
            </ul>
            <?php } ?>
            <h3 class="module-list-head">Modules</h3>
            <ul class="builder-module-list">
                <?php spyropress_builder_render_modules(); ?>
            </ul>
            <div class="clear"></div>
			<h3 class="module-list-head">Widgets</h3>
            <ul class="builder-module-list">
                <?php spyropress_builder_render_widgets(); ?>
            </ul>
            <div class="clear"></div>
		</div>
        <div class="builder-popup-footer">
            <span class="builder-popup-activity builder-hide">Loading module options&hellip;</span>
            <a id="builder-modules-popup-close" class="builder-popup-close" href="#">Cancel</a>
		</div>
	</div>
    <!-- /builder-modules-popup -->
    <div id="builder-reset-popup" class="error-popup builder-popup">
		<div class="builder-popup-header">
			<h2>Are you sure you want to delete Builder Data?</h2>
		</div>
		<div class="builder-popup-content">
			<p>
				All Builder information and settings for this post
				<em>
					will be permanently lost
				</em>
				.
			</p>
		</div>
        <div class="builder-popup-footer">
            <span class="builder-popup-activity builder-hide">Resetting Builder Data&hellip;</span>
            <button id="builder-reset-confirm" class="button-red button-data">Reset Builder</button>
            <span>or </span>
            <a id="builder-reset-popup-close" class="builder-popup-close" href="#">Cancel</a>
		</div>
	</div>
    <!-- /builder-reset-popup -->
</div>
<!-- /builder-popups -->
<input type="hidden" name="builder-autosave-title" id="builder-autosave-title" value="Untitled Build" />
<!-- /builder-hidden-fields -->