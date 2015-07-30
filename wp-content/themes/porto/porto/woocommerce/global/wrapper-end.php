<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$shop_layout = is_single() ? get_setting( 'shop_single_layout', 'full' ) : get_setting( 'shop_layout', 'full' );
$shop_sidebar_pos = is_single() ? get_setting( 'shop_single_sidebar_pos', 'right' ) : get_setting( 'shop_sidebar_pos', 'right' );

$layout = ( current_theme_supports( 'theme-demo' ) && isset( $_GET['sidebar'] ) ) ? 'sidebar' : '';
$shop_layout = !empty( $layout ) ? $layout : $shop_layout;

?>
    <?php if( 'sidebar' == $shop_layout ) : ?>
        </div>
        
        <?php if( 'right' == $shop_sidebar_pos ) : ?>
            <div class="col-md-3">
                <?php woocommerce_get_sidebar(); ?>
            </div>
        <?php endif; ?>
            
    </div>
    <?php endif; ?>
        
    </div>
</div>