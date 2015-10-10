<?php

$knob_color = stripslashes( sanitize_text_field( $knob_color ) );
$knob_color = str_replace( '#', '', $knob_color );
if( !is_str_starts_with( 'rgb', $knob_color ) ) $knob_color = '#' . $knob_color;

$plugin_options = array();
$plugin_options['barColor'] = $knob_color;
$plugin_options['delay'] = (int)$delay;
?>
<div class="circular-bar center">
	<div class="circular-bar-chart" data-percent="<?php echo $percentage ?>" data-plugin-options='<?php echo json_encode( $plugin_options ); ?>'>
		<strong><?php echo $title; ?></strong>
		<label><span class="percent"><?php echo $percentage ?></span>%</label>
	</div>
</div>