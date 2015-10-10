<?php

$features = get_setting_array( 'shop_loop_top_bar', array() );
$pagination_pos = get_setting( 'shop_pagination_pos', 'bottom' );
?>
<div class="row">
	<div class="col-md-6">
        <h2 class="shorter"><strong><?php woocommerce_page_title() ?></strong></h2>
		<?php
            if( in_array( 'result_count', $features )  ) {
                woocommerce_result_count();
            }
            else {
                echo '<p></p>'; 
            }
        ?>
	</div>
    <div class="col-md-6">
    <?php
        if( in_array( 'pagination', $features ) && $pagination_pos && ( 'top' == $pagination_pos || 'both' == $pagination_pos )  ) {
            wp_pagenavi( array( 'container_class' => 'pagination pagination-lg pagination-top pull-right' ) );
        }
        
        if( in_array( 'filter', $features )  ) {
            woocommerce_catalog_ordering();
        }
    ?>
    </div>
</div>