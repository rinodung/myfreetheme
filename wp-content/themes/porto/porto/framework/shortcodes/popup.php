<?php

// loads the shortcodes class, wordpress is loaded with it
require_once( 'class-shortcodes.php' );

// get popup type
$popup = trim( $_GET['popup'] );
$shortcode = new SpyropressShortcodes( $popup );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<div id="spyropress-popup">

	<div id="spyropress-shortcode-wrap">
		
		<div id="spyropress-sc-form-wrap">
			
			<form method="post" id="spyropress-sc-form">
			
				<?php echo $shortcode->hidden; ?>
                <table id="spyropress-sc-form-table">
					
					<?php echo $shortcode->output; ?>
                    
                    <tbody>
						<tr class="form-row">
							<?php if( ! $shortcode->has_child ) : ?><td class="label">&nbsp;</td><?php endif; ?>
							<td class="field"><a href="#" class="button-primary spyropress-insert">Insert Shortcode</a></td>							
						</tr>
					</tbody>
				
				</table>
				<!-- /#spyropress-sc-form-table -->
				
			</form>
			<!-- /#spyropress-sc-form -->
		
		</div>
		<!-- /#spyropress-sc-form-wrap -->
		
		<div class="clear"></div>
		
	</div>
	<!-- /#spyropress-shortcode-wrap -->

</div>
<!-- /#spyropress-popup -->

</body>
</html>