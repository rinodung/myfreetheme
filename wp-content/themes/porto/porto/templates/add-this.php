<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
	<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
	<a class="addthis_button_tweet"></a>
	<a class="addthis_button_pinterest_pinit"></a>
	<a class="addthis_counter addthis_pill_style"></a>
</div>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#async=1"></script>
<!-- AddThis Button END -->
<?php

add_inline_js( 'var addthis_config = { 
    "pubid": \'' . get_setting( 'add_this_pub_id' ) . '\'
};addthis.init();');