<div class="widget-sections">
    <div class="toggle_set">
        <div class="section section-subheading toggle_trigger section-full">
            <label class="heading"><?php _e( 'Widget Extras:', 'spyropress' );?></label>                
            <span class="toggle_icon">[+]</span>
        </div>
        <div class="toggle_container">
            <div class="section section-text section-full">
                <label class="heading"><?php _e( 'Container ID','spyropress' ); ?> </label>
                <div class="controls">
                    <input class="field" type="text" id="<?php echo $widget->get_field_id( 'custom_container_id' ); ?>" name="<?php echo $widget->get_field_name( 'custom_container_id' ); ?>" value="<?php echo $custom_container_id;?>" />
                </div>
                <div class="description"><?php _e( 'The ID that is applied to the container.', 'spyropress' );?></div>
            </div>
            <div class="section section-text section-full">
                <label class="heading"><?php _e( 'Container Class','spyropress' ); ?> </label>
                <div class="controls">
                    <input class="field" type="text" id="<?php echo $widget->get_field_id( 'custom_container_class' );?>" name="<?php echo $widget->get_field_name( 'custom_container_class' );?>" type="text" value="<?php echo $custom_container_class;?>" />
                </div>
                <div class="description"><?php _e( 'The CssClass that is applied to the container.', 'spyropress' );?></div>
            </div>
            
            <div class="section section-select section-full">
                <label class="heading"><?php _e( 'Visibility', 'spyropress' ); ?></label>
                <div class="controls">
                    <select class="chosen" name="<?php echo $widget->get_field_name( 'custom_action' );?>" id="<?php echo $widget->get_field_id( 'custom_action' );?>">
                        <option value="1"<?php selected( '1', $custom_action ); ?>><?php _e( 'Show', 'spyropress' );?></option>
                        <option value="0"<?php selected( '0', $custom_action ); ?>><?php _e( 'Do NOT show', 'spyropress' );?></option>
                    </select>
                </div>
                <label class="heading"><?php _e( 'On', 'spyropress' ); ?></label>
                <div class="controls">
                    <select class="chosen" name="<?php echo $widget->get_field_name( 'custom_show' );?>" id="<?php echo $widget->get_field_id( 'custom_show' );?>">
                        <?php
                        if ( is_array( $this->conditions ) && !empty( $this->conditions ) ) {
                            foreach ( $this->conditions as $k => $item ) {
                                printf( '<option value="%1$s"%3$s>%2$s</option>', $k, $item['name'], selected( $custom_show, $k )  );
                            }
                        }
                        ?>
                	</select>
                </div>
            </div>
            <div class="section section-text section-full">
                <label class="heading"><?php _e( 'Slug/Title/ID','spyropress' ); ?> </label>
                <div class="controls">
                    <input class="field" type="text" id="<?php echo $widget->get_field_id( 'custom_slug' );?>" name="<?php echo $widget->get_field_name( 'custom_slug' );?>" value="<?php echo htmlspecialchars( $custom_slug ); ?>" />
                </div>
                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" id="<?php echo $widget->get_field_name( 'suppress_title' ); ?>" name="<?php echo $widget->get_field_name( 'suppress_title' ); ?>" value="1"<?php checked( $suppress_title, '1' );?> /> <?php _e( 'Remove Title from Output', 'spyropress' ); ?>
                    </label>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>