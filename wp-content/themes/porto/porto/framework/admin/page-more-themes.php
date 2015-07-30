<?php

/**
 * More Themes
 *
 * Retrieve more themes from ThemeForest account.
 */

function sort_items_by_sales( $a, $b ) {
    return strtotime( $b->uploaded_on ) - strtotime( $a->uploaded_on );
}
global $spyropress;

$url = sprintf( 'http://marketplace.envato.com/api/edge/new-files-from-user:%s,themeforest.json', get_themeforest_username() );
$data = wp_remote_get( $url );
$data = (array)json_decode( wp_remote_retrieve_body( $data ) );
?>
<div class="wrap spyropress-wrap">
    <h1><?php _e( 'Store', 'spyropress'); ?></h1>
    <?php
        if ( !empty( $data ) ) {
            $items = $data['new-files-from-user'];
            usort( $items, 'sort_items_by_sales' );
    ?>
    <div class="teaser-text">
        <?php printf( __( 'Currently Listing %d themes on themeforest.', 'spyropress' ), count( $items ) ); ?>
    </div>
    <div id="store-items">
        <?php
            foreach( $items as $item ) {
        ?>
        <div class="store-item" data-url="<?php echo $item->url.'?ref=spyropress'; ?>" >
            <div class="item-thumb">
                <img src="<?php echo $item->live_preview_url; ?>" />
            </div>
            <div class="item-detail">
                <h3><?php echo $item->item; ?></h3>
                <div class="item-meta">
                    <strong><i class="item-cost"></i>$<?php echo $item->cost; ?><span><?php _e( ' only', 'spyropress'); ?></span></strong>
                    <strong><i class="item-sales"></i><?php echo $item->sales; ?><span><?php _e( ' sales', 'spyropress'); ?></span></strong>
                </div>
            </div>
        </div>
        <?php
            }
        ?>
        <div class="clear"></div>
    </div>
    <?php } ?>
</div>