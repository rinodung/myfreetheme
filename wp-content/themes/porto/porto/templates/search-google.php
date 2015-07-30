<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="search-results">
            	<script>
            	  (function() {
            		var cx = '<?php get_setting_e( 'google_cse_id' ); ?>'; // Insert your own Custom Search engine ID here
            		var gcse = document.createElement('script');
            		gcse.type = 'text/javascript';
            		gcse.async = true;
            		gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
            			'//www.google.com/cse/cse.js?cx=' + cx;
            		var s = document.getElementsByTagName('script')[0];
            		s.parentNode.insertBefore(gcse, s);
            	  })();
            	</script>
            
            	<gcse:searchresults-only queryParameterName="s"></gcse:searchresults-only>
            </div>
        </div>
    </div>
</div>