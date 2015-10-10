<form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
	<div class="input-group input-group-lg">
        <input class="form-control" type="text" value="<?php echo get_search_query() ?>" name="s" id="s" placeholder="<?php  _e( 'Search for products', 'woocommerce' ); ?>" />
		<span class="input-group-btn">
			<button type="submit" class="btn btn-primary btn-lg"><i class="icon icon-search"></i></button>
		</span>
	</div>
    <input type="hidden" name="post_type" value="product" />
</form>