<?php

if( get_setting( 'search_disable', false ) ) return;

$translate['search-placeholder'] = get_setting( 'translate' ) ? get_setting( 'search_placeholder', 'Search..' ) : __( 'Search..', 'spyropress' );
?>
<div class="search">
	<form id="searchForm" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
		<div class="input-group">
			<input type="text" class="form-control search" name="s" id="s" placeholder="<?php echo $translate['search-placeholder'] ?>" value="<?php echo get_search_query(); ?>" required>
			<span class="input-group-btn">
				<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
			</span>
		</div>
	</form>
</div>