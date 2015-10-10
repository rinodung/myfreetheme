<!-- spyropress-panel -->
<div class="wrap spyropress-wrap spyropress-panel" id="spyropress-panel">
	<div class="ajax-message"></div>
    <form method="post" id="<?php echo $this->get_id(); ?>">
        <?php wp_nonce_field( 'spyropress-update-options', 'security', false ); ?>
        <input type="hidden" id="setting_panel_name" name="setting_panel_name" value="<?php echo str_replace( 'spyropress_', '', $this->get_id() ); ?>" />