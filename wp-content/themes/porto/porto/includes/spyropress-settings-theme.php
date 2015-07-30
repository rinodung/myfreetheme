<?php
/**
 * Theme Options
 *
 * @author 		SpyroSol
 * @category 	Admin
 * @package 	Spyropress
 */

global $spyropress_theme_settings;

$spyropress_theme_settings['general'] = array(

	array(
        'label' => __( 'General Settings', 'spyropress' ),
        'type' => 'heading',
        'slug' => 'generalsettings',
        'icon' => 'module-icon-general'
    ),

    array(
		'label' => __( 'Logo', 'spyropress' ),
        'desc' => __( 'Upload a logo for your site or specify an image URL directly.', 'spyropress' ),
		'id' => 'logo',
        'type' => 'upload'
	),
    
    array(
		'label' => __( 'Logo (Retina Version)', 'spyropress' ),
        'desc' => __( 'Upload a retina logo for your site. It should be exactly 2x the size of main logo', 'spyropress' ),
		'id' => 'logo_retina',
        'type' => 'upload'
	),
    
    array(
		'label' => __( 'Logo Width', 'spyropress' ),
		'id' => 'logo_width',
        'desc' => __( 'Select logo width(px)', 'spyropress' ),
        'type' => 'range_slider',
        'max' => 500,
        'std' => 111
	),
    
    array(
		'label' => __( 'Logo Height', 'spyropress' ),
		'id' => 'logo_height',
        'desc' => __( 'Select logo height(px)', 'spyropress' ),
        'type' => 'range_slider',
        'max' => 500,
        'std' => 54
	),
        
    array(
		'label' => __( 'Sticky Logo Width', 'spyropress' ),
		'id' => 'stk_logo_width',
        'desc' => __( 'Select logo width(px) used in sticky header', 'spyropress' ),
        'type' => 'range_slider',
        'max' => 100,
        'std' => 82
	),
    
    array(
		'label' => __( 'Sticky Logo Height', 'spyropress' ),
		'id' => 'stk_logo_height',
        'desc' => __( 'Select logo height(px) used in sticky header', 'spyropress' ),
        'type' => 'range_slider',
        'max' => 50,
        'std' => 40
	),

    array(
		'label' => __( 'Custom Favicon', 'spyropress' ),
        'desc' => __( 'Upload a favicon for your site or specify an icon URL directly.<br/>Accepted formats: ico, png, gif<br/>Dimension: 16px x 16px.', 'spyropress' ),
		'id' => 'custom_favicon',
        'type' => 'upload'
	),

    array(
		'label' => __( 'Apple Touch Icon (small)', 'spyropress' ),
        'desc' => __( 'Upload apple favicon.<br/>Accepted formats: png<br/>Dimension: 57px x 57px.', 'spyropress' ),
		'id' => 'apple_small',
        'type' => 'upload'
	),

    array(
		'label' => __( 'Apple Touch Icon (medium)', 'spyropress' ),
        'desc' => __( 'Upload apple favicon.<br/>Accepted formats: png<br/>Dimension: 72px x 72px.', 'spyropress' ),
		'id' => 'apple_medium',
        'type' => 'upload'
	),

    array(
		'label' => __( 'Apple Touch Icon (large)', 'spyropress' ),
        'desc' => __( 'Upload apple favicon.<br/>Accepted formats: png<br/>Dimension: 114px x 114px.', 'spyropress' ),
		'id' => 'apple_large',
        'type' => 'upload'
	),
    
    array(
        'label' => __( 'Analytics', 'spyropress' ),
        'type' => 'sub_heading',
    ),

    array(
        'label' => __( 'Tracking Code', 'spyropress' ),
        'id' => 'tracking_code',
        'type' => 'textarea',
        'rows' => 6
    ),
    
    array(
        'label' => __( 'Social Sharing', 'spyropress' ),
        'type' => 'sub_heading',
    ),

    array(
        'label' => __( 'AddThis Publisher ID', 'spyropress' ),
        'type' => 'text',
        'id' => 'add_this_pub_id',
    ),
    
    array(
        'label' => __( 'Search Options', 'spyropress' ),
        'type' => 'sub_heading',
    ),

    array(
		'id' => 'google_search',
        'type' => 'checkbox',
        'options' => array(
            1 => __( 'Enable Google Custom Search Engine', 'spyropress' )
        )
	),

    array(
        'label' => __( 'Custom Search engine ID', 'spyropress' ),
        'type' => 'text',
        'id' => 'google_cse_id',
    ),

); // End General Settings

$spyropress_theme_settings['header'] = array(

    array(
        'label' => __( 'Header Customization', 'spyropress' ),
        'type' => 'heading',
        'slug' => 'header',
        'icon' => 'module-icon-layout'
    ),

    array(
        'label' => __( 'Header Styles', 'spyropress' ),
        'id' => 'header_style',
        'type' => 'radio_img',
        'class' => 'full-width enable_changer',
        'options' => array(
            'v1' => array( 'img' => assets_img() . 'framework_assets/header-v1.png' ),
            'v2' => array( 'img' => assets_img() . 'framework_assets/header-v2.png' ),
            'v3' => array( 'img' => assets_img() . 'framework_assets/header-v3.png' ),
            'v4' => array( 'img' => assets_img() . 'framework_assets/header-v4.png' ),
            'v5' => array( 'img' => assets_img() . 'framework_assets/header-v5.png' ),
            'v6' => array( 'img' => assets_img() . 'framework_assets/header-v6.png' ),
            'v7' => array( 'img' => assets_img() . 'framework_assets/header-v7.png' ),
        ),
        'std' => 'v1'
    ),

   
    array(
        'label' => __( 'Sticky Header', 'spyropress' ),
        'type' => 'sub_heading',
        'class' => 'header_style v1 v2 v3 v4 v6 v7'
    ),
    
     array(
		'id' => 'sticky_header',
        'type' => 'checkbox',
        'class' => 'header_style v1 v5 v6',
        'options' => array(
            '1' => __( 'Deactive Sticky Header', 'spyropress' ),
        )
	),
    
    array(
        'label' => __( 'Social Networks', 'spyropress' ),
        'type' => 'sub_heading',
        'class' => 'header_style v1 v2 v3 v4 v6 v7'
    ),

    array(
        'id' => 'header_social',
        'type' => 'repeater',
        'class' => 'header_style v1 v2 v3 v4 v6 v7',
        'item_title' => 'network',
        'fields' => array(
            array(
            	'label' => __( 'URL', 'spyropress' ),
            	'id' => 'url',
            	'type' => 'text'
            ),

            array(
                'label' => __( 'Network', 'spyropress' ),
                'id' => 'network',
                'type' => 'select',
                'options' => spyropress_get_options_social()
            )
        )
    ),

    array(
        'label' => __( 'Search', 'spyropress' ),
        'type' => 'sub_heading',
        'class' => 'header_style v1 v5 v6'
    ),

    array(
		'id' => 'search_disable',
        'type' => 'checkbox',
        'class' => 'header_style v1 v5 v6',
        'options' => array(
            '1' => __( 'Disable Search Box', 'spyropress' ),
        )
	),

    array(
        'label' => __( 'Search Placeholder', 'spyropress' ),
        'type' => 'text',
        'class' => 'header_style v1 v5 v6',
        'id' => 'search_placeholder',
        'std' => 'Search...'
    ),

    array(
        'label' => __( 'Top Bar Settings', 'spyropress' ),
        'class' => 'header_style v1 v3 v4 v5 v6',
        'type' => 'sub_heading'
    ),

    array(
        'label' => __( 'Teaser', 'spyropress' ),
        'type' => 'textarea',
        'class' => 'header_style v1 v3 v4 v5 v6',
        'id' => 'topbar_teaser',
        'std' => 'Get in touch!',
        'rows' => 5
    ),

    array(
        'label' => __( 'Phone Number', 'spyropress' ),
        'type' => 'text',
        'class' => 'header_style v1 v3 v4 v5 v6',
        'id' => 'topbar_ph',
        'std' => '(123) 456-7890'
    ),

    array(
        'label' => __( 'Email', 'spyropress' ),
        'type' => 'text',
        'class' => 'header_style v1 v3 v4 v5 v6',
        'id' => 'topbar_email',
        'std' => 'mail@domain.com'
    ),

); // End Header

$spyropress_theme_settings['footer'] = array(

    array(
        'label' => __( 'Footer Customization', 'spyropress' ),
        'type' => 'heading',
        'slug' => 'footer',
        'icon' => 'module-icon-footer'
    ),

    array(
        'label' => __( 'Footer Styles', 'spyropress' ),
        'id' => 'footer_style',
        'type' => 'radio_img',
        'class' => 'full-width enable_changer',
        'options' => array(
            'v1' => array( 'img' => assets_img() . 'framework_assets/footer-v1.png' ),
            'v2' => array( 'img' => assets_img() . 'framework_assets/footer-v2.png' ),
            'v3' => array( 'img' => assets_img() . 'framework_assets/footer-v3.png' ),
            'v4' => array( 'img' => assets_img() . 'framework_assets/footer-v4.png' )
        ),
        'std' => 'v1'
    ),


    array(
		'label' => __( 'Ribbon Text', 'spyropress' ),
        'desc' => __( 'Ribbon area above the footer make empty to disbale.', 'spyropress' ),
        'type' => 'text',
        'class' => 'footer_style v1',
        'id' => 'footer_ribbon',
        'std' => 'Get in Touch'
	),

    array(
		'label' => __( 'Footer Logo', 'spyropress' ),
        'type' => 'upload',
        'class' => 'footer_style v1 v3 v4',
        'id' => 'footer_logo'
	),

    array(
		'label' => __( 'Copyrigth Text', 'spyropress' ),
		'id' => 'footer_copyright',
        'type' => 'editor'
	),

    array(
		'label' => __( 'About', 'spyropress' ),
        'type' => 'sub_heading'
	),

    array(
		'label' => __( 'About Title', 'spyropress' ),
		'id' => 'footer_about_title',
        'class' => 'footer_style v3 v4',
        'type' => 'text'
	),

    array(
		'label' => __( 'About Company', 'spyropress' ),
		'id' => 'footer_about',
        'class' => 'footer_style v3 v4',
        'type' => 'editor'
	)

); // END FOOTER

$spyropress_theme_settings['post'] = array(

    array(
        'label' => __( 'Post Options', 'spyropress' ),
        'type' => 'heading',
        'slug' => 'post',
        'icon' => 'module-icon-post'
    ),

    array(
		'label'    => __( 'Layout', 'spyropress' ),
		'type'    => 'sub_heading'
	),

    array(
		'label' => __( 'Blog Layout', 'spyropress' ),
        'id' => 'blog_layout',
		'type' => 'select',
        'class' => 'enable_changer',
		'options' => array(
            'full' => __( 'Full Width', 'spyropress' ),
            'large' => __( 'Large Image', 'spyropress' ),
            'medium' => __( 'Medium Image', 'spyropress' ),
            'timeline' => __( 'Timeline', 'spyropress' ),
        ),
		'std' => 'full'
	),

    array(
		'label' => __( 'Sidebar Position', 'spyropress' ),
        'id' => 'blog_sidebar_position',
        'class' => 'blog_layout large medium',
		'type' => 'select',
		'options' => array(
            'left' => __( 'Left Side', 'spyropress' ),
            'right' => __( 'Right Side', 'spyropress' )
        ),
		'std' => 'left'
	),

    array(
		'label' => __( 'Single Sidebar Position', 'spyropress' ),
        'id' => 'blog_single_sidebar_position',
		'type' => 'select',
		'options' => array(
            'left' => __( 'Left Side', 'spyropress' ),
            'right' => __( 'Right Side', 'spyropress' )
        ),
		'std' => 'left'
	),

    array(
		'label' => __( 'Excerpt Settings', 'spyropress' ),
		'type' => 'sub_heading'
	),

    array(
        'label' => __( 'Length by', 'spyropress' ),
        'id' => 'excerpt_by',
        'type' => 'select',
        'options' => array (
            '' => '',
            'words' => __( 'Words', 'spyropress' ),
            'chars' => __( 'Character', 'spyropress' ),
        ),
        'std' => 'words'
	),

    array(
		'label' => __( 'Length', 'spyropress' ),
        'desc' => __( 'Set the length of excerpt.', 'spyropress' ),
		'id' => 'excerpt_length',
        'type' => 'text',
        'std' => 60
	),

    array(
		'label' => __( 'Ellipsis', 'spyropress' ),
        'desc' => __( 'This is the description field, again good for additional info.', 'spyropress' ),
		'id' => 'excerpt_ellipsis',
        'type' => 'text',
        'std' => '&nbsp;[...]'
	),

    array(
		'label' => __( 'Before Text', 'spyropress' ),
        'desc' => __( 'This is the description field, again good for additional info.', 'spyropress' ),
		'id' => 'excerpt_before_text',
        'type' => 'text',
        'std' => '<p>'
	),

    array(
		'label' => __( 'After Text', 'spyropress' ),
        'desc' => __( 'This is the description field, again good for additional info.', 'spyropress' ),
		'id' => 'excerpt_after_text',
        'type' => 'text',
        'std' => '</p>'
	),

    array(
		'label' => __( 'Read More', 'spyropress' ),
		'id' => 'excerpt_link_to_post',
        'type' => 'checkbox',
        'options' => array(
            1 => __( 'Enable Read more link.', 'spyropress' ),
        )
	),

    array(
		'label' => __( 'Link Text', 'spyropress' ),
        'desc' => __( 'A text for Read More button.', 'spyropress' ),
		'id' => 'excerpt_link_text',
        'type' => 'text',
        'std' => 'read more'
	),

    array(
		'label' => __( 'Author Box', 'spyropress' ),
		'type' => 'sub_heading'
	),

    array(
        'desc' => __( 'A box to display about author.', 'spyropress' ),
		'id' => 'meta_authorbox',
        'type' => 'checkbox',
        'options' => array(
            1 => __( 'Enable author box.', 'spyropress' ),
        )
	),

    array(
		'label' => __( 'Author Title', 'spyropress' ),
        'desc' => __( 'Write the title.', 'spyropress' ),
		'id' => 'authorbox_title',
        'type' => 'text',
        'std' => 'About the Author'
	),

    array(
		'label' => __( 'Social Sharing', 'spyropress' ),
		'type' => 'sub_heading'
	),

    array(
        'desc' => __( 'An <em>AddThis</em> widget for social sharing.', 'spyropress' ),
		'id' => 'post_social_sharing',
        'type' => 'checkbox',
        'options' => array(
            1 => __( 'Enable Social Sharing', 'spyropress' ),
        )
	),

    array(
		'label' => __( 'Share Title', 'spyropress' ),
		'id' => 'post_share_title',
        'type' => 'text',
        'std' => 'Share this post'
	)

); // End Blog Settings

$spyropress_theme_settings['portfolio'] = array(

    array(
        'label' => __( 'Portfolio Options', 'spyropress' ),
        'type' => 'heading',
        'slug' => 'portfolio',
        'icon' => 'module-icon-post',
        'selected' => true
    ),
    
    array(
		'id' => 'portfolio-slug',
		'type' => 'text',
		'label' => __( 'Single item slug', 'spyropress' ),
		'desc' => __('<b>Important:</b> Do not use characters not allowed in links. <br /><br />Must be different from the Portfolio site title chosen above, eg. "portfolio-item". After change please go to "Settings &raquo; Permalinks" and click [Save changes] button.', 'spyropress' ),
		'std' => 'portfolio',
	),

    array(
        'label' => __( 'Header Style', 'spyropress' ),
        'id' => 'portfolio_header_style',
        'type' => 'select',
        'options' => array(
            'title' => __( 'Title Only', 'spyropress' ),
            'buttons' => __( 'Title with Buttons', 'spyropress' )
        )
    ),
    
    
    array(
		'label'    => __( 'Archives Layout', 'spyropress' ),
		'type'    => 'sub_heading'
	),
    
  
    array(
		'label' => __( 'Portfolio Layout', 'spyropress' ),
        'id' => 'portfolio_layout',
		'type' => 'select',
        'class' => 'enable_changer',
		'options' => array(
            'full' => __( 'Full Width', 'spyropress' ),
            'listing' => __( 'Listing', 'spyropress' ),
            'timeline' => __( 'Timeline', 'spyropress' ),
        ),
		'std' => 'full'
	),
    
     array(
        'label' => __( 'Number of Columns', 'spyropress' ),
        'id' => 'columns',
        'class' => 'section-full portfolio_layout listing',
        'type' => 'range_slider',
        'std' => 2,
        'max' => 4
    ),
    
    array(
		'label' => __( 'Related Work', 'spyropress' ),
		'type' => 'sub_heading'
	),

    array(
		'id' => 'related_portfolio_enable',
        'type' => 'checkbox',
        'options' => array(
            1 => __( 'Enable related work.', 'spyropress' ),
        )
	),

    array(
		'label' => __( 'Related Title', 'spyropress' ),
        'desc' => __( 'Write the title.', 'spyropress' ),
		'id' => 'related_portfolio_title',
        'type' => 'text',
        'std' => 'Related <strong>Work</strong>'
	),

    array(
		'label' => __( 'Number Of items', 'spyropress' ),
        'desc' => __( 'Set the number of related post.', 'spyropress' ),
		'id' => 'related_portfolio_number',
        'type' => 'range_slider',
        'max' => '20',
        'min' => '1',
        'std' => 4
	),

    array(
		'label' => __( 'Related Work By', 'spyropress' ),
        'desc' => __( 'Choose the tag or category to show related portfolio.', 'spyropress' ),
        'id' => 'related_portfolio_by',
		'type' => 'select',
		'options' => array(
            'portfolio_service' => __( 'Services', 'spyropress' ),
            'portfolio_category' => __( 'Category', 'spyropress' )
        ),
		'std' => 'portfolio_category'
	),

    array(
		'label' => __( 'Social Sharing', 'spyropress' ),
		'type' => 'sub_heading'
	),

    array(
        'desc' => __( 'An <em>AddThis</em> widget for social sharing.', 'spyropress' ),
		'id' => 'portfolio_social_sharing',
        'type' => 'checkbox',
        'options' => array(
            1 => __( 'Enable Social Sharing', 'spyropress' ),
        )
	)

); // End Blog Settings


$spyropress_theme_settings['woocommerce'] = array(

    array(
        'label' => __( 'WooCommerce Options', 'spyropress' ),
        'type' => 'heading',
        'slug' => 'woocommerce',
        'icon' => 'module-icon-post'
    ),

    array(
		'label' => __( 'Layout', 'spyropress' ),
		'type' => 'sub_heading'
	),

    array(
		'label' => __( 'Shop Layout', 'spyropress' ),
        'id' => 'shop_layout',
        'class' => 'enable_changer section-full',
        'type' => 'select',
        'options' => array(
            'full' => __( 'Full Width', 'spyropress' ),
            'sidebar' => __( 'Sidebar', 'spyropress' ),
        ),
        'std' => 'full'
	),

    array(
		'label' => 'Sidebar Position',
        'id' => 'shop_sidebar_pos',
        'class' => 'shop_layout sidebar section-full',
        'type' => 'select',
        'options' => array(
            'left'  =>  __( 'Left Sidebar', 'spyropress' ),
            'right' =>  __( 'Right Sidebar', 'spyropress' )
        ),
        'std' => 'right'
	),

    array(
		'label' => __( 'Top Bar' , 'spyropress' ),
        'id' => 'shop_loop_top_bar',
        'type' => 'checkbox',
        'desc' => __( 'Enable features at the Shop page.', 'spyropress' ),
        'options' => array(
            'result_count' => __( 'Show Result Count', 'spyropress' ),
            'filter' => __( 'Show Catalog Ordering', 'spyropress' ),
            'pagination' => __( 'Show Pagination', 'spyropress' ),
        )
	),

    array(
		'label' => 'Pagination Position',
        'id' => 'shop_pagination_pos',
        'type' => 'select',
        'options' => array(
            'top'  =>  __( 'Top', 'spyropress' ),
            'bottom' =>  __( 'Bottom', 'spyropress' ),
            'both' =>  __( 'Both', 'spyropress' )
        ),
        'std' => 'bottom'
	),

    array(
		'label' => __( 'Product Limit', 'spyropress' ),
        'desc' => __( 'Set the number of product per page.', 'spyropress' ),
		'id' => 'shop_loop_product_per_page',
        'type' => 'range_slider',
        'max' => '20',
        'min' => '1',
        'std' => 12
	),
    array(
        'label' => __( 'Product Columns', 'spyropress' ),
		'id' => 'shop_loop_product_columns',
        'desc' => __( 'Set the number of columns for shop.', 'spyropress' ),
        'type' => 'range_slider',
        'std' => 4,
        'max' => 4
	),

    array(
		'label' => __( 'Product Single Page Settings', 'spyropress' ),
		'type' => 'sub_heading'
	),

    array(
		'label' => __( 'Single Layout', 'spyropress' ),
        'id' => 'shop_single_layout',
        'class' => 'enable_changer section-full',
        'type' => 'select',
        'options' => array(
            'full' => __( 'Full Width', 'spyropress' ),
            'sidebar' => __( 'Sidebar', 'spyropress' ),
        ),
        'std' => 'full'
	),

    array(
		'label' => 'Sidebar Position',
        'id' => 'shop_single_sidebar_pos',
        'class' => 'shop_single_layout sidebar section-full',
        'type' => 'select',
        'options' => array(
            'left'  =>  __( 'Left Sidebar', 'spyropress' ),
            'right' =>  __( 'Right Sidebar', 'spyropress' )
        ),
        'std' => 'right'
	),

    array(
		'label' => __( 'Social Sharing', 'spyropress' ),
        'id' => 'shop_single_sharing',
        'type' => 'checkbox',
        'options' => array(
            1 => __( 'Enable social sharing', 'spyropress' ),
        )
	),

    array(
        'label' => __( 'Products Tabs', 'spyropress' ),
		'id' => 'shop_single_tabs',
        'type' => 'checkbox',
        'options' => array(
            1 => __( 'Disable product tabs on product page.', 'spyropress' ),
        )
	),

    array(
		'label' => __( 'Related Products', 'spyropress' ),
		'type' => 'sub_heading'
	),

    array(
		'id' => 'shop_related_items',
        'type' => 'checkbox',
        'options' => array(
            1 => __( 'Disable related products.', 'spyropress' ),
        )
	),

    array(
        'label' => __( 'Related Products Limit', 'spyropress' ),
		'id' => 'shop_related_items_limit',
        'desc' => __( 'Set the number of related product.', 'spyropress' ),
        'type' => 'range_slider',
        'std' => 4,
        'max' => 30
	),

    array(
        'label' => __( 'Related Product Columns', 'spyropress' ),
		'id' => 'shop_related_columns',
        'desc' => __( 'Set the number of columns for related products', 'spyropress' ),
        'type' => 'range_slider',
        'std' => 4,
        'max' => 4
	),

    array(
		'label' => __( 'Up Sell Products', 'spyropress' ),
		'type' => 'sub_heading'
	),

    array(
		'id' => 'shop_upsell',
        'type' => 'checkbox',
        'options' => array(
            1 => __( 'Disable up sell products.', 'spyropress' ),
        )
	),

    array(
        'label' => __( 'Up Sell Products Limit', 'spyropress' ),
		'id' => 'shop_upsell_limit',
        'desc' => __( 'Set the number of up sell product.', 'spyropress' ),
        'type' => 'range_slider',
        'std' => 4,
        'max' => 30
	),
    array(
        'label' => __( 'Up Sell Product Columns', 'spyropress' ),
		'id' => 'shop_upsell_columns',
        'desc' => __( 'Set the number of columns for up sell products', 'spyropress' ),
        'type' => 'range_slider',
        'std' => 4,
        'max' => 4
	),

    array(
		'label' => __( 'Mini Cart Settings', 'spyropress' ),
		'type' => 'sub_heading'
	),

    array(
		'id' => 'mini_cart_hide_if_empty',
        'type' => 'checkbox',
        'options' => array(
            1 => __( 'Hide if cart is empty', 'spyropress' ),
        )
	),

    array(
        'label' => __( 'Mini Cart Items', 'spyropress' ),
		'id' => 'mini_cart_items',
        'desc' => __( 'Set the number of cart items to display', 'spyropress' ),
        'type' => 'range_slider',
        'std' => 1,
        'max' => 10
	),

    array(
		'label' => __( 'Cross Sell Products', 'spyropress' ),
		'type' => 'sub_heading'
	),

    array(
		'id' => 'shop_cross_sell',
        'type' => 'checkbox',
        'options' => array(
            1 => __( 'Disable cross sell products.', 'spyropress' ),
        )
	),

    array(
        'label' => __( 'Cros Sell Products Limit', 'spyropress' ),
		'id' => 'shop_cross_sell_limit',
        'desc' => __( 'Set the number of cross sell product.', 'spyropress' ),
        'type' => 'range_slider',
        'std' => 4,
        'max' => 30
	),

    array(
        'label' => __( 'Cross Sell Product Columns', 'spyropress' ),
		'id' => 'shop_cross_sell_columns',
        'desc' => __( 'Set the number of columns for cross sell products', 'spyropress' ),
        'type' => 'range_slider',
        'std' => 4,
        'max' => 4
	)

);

$skins = get_option( '_spyropress_porto_skins', array() );
$skin_options = array();
foreach( $skins as $k => $skin ) {
    $skin_options[$k] = '<span class="skin-item" style="background:' . spyropress_validate_setting( $skin['color'], 'colorpicker', 'skin_color', array() ) . ';"><span>' . $skin['name'] . '</span></span><a href="#" data-name="' . $k . '" class="skin-remove-item button-red">Delete Skin</a>';
}

$spyropress_theme_settings['skin'] = array(

	array (
        'label' => __( 'Skins & layout', 'spyropress' ),
        'type' => 'heading',
        'slug' => 'skin',
        'icon' => 'module-icon-styling'
    ),

    array(
        'label' => __( 'Layout Options', 'spyropress' ),
        'type' => 'sub_heading',
    ),

    array(
        'label' => __( 'Theme Layout', 'spyropress' ),
        'id' => 'theme_layout',
        'type' => 'radio_img',
        'class' => 'enable_changer section-full',
        'desc' => __( 'Select which layout you want for theme.', 'spyropress' ),
		'options' => array(
            'full' => array(
                'title' => __( 'Full Layout', 'spyropress' ),
                'img' => get_panel_img_path( 'layouts/full.png' )
            ),
            'boxed' => array(
                'title' => __( 'Boxed Layout', 'spyropress' ),
                'img' => get_panel_img_path( 'layouts/full.png' )
            )
		),
        'std' => 'full'
    ),

    array(
        'label' => __( 'Boxed Background', 'spyropress' ),
        'id' => 'boxed_bg',
        'class' => 'theme_layout boxed',
        'type' => 'background',
        'use_pattern' => true,
        'patterns' => array(
            assets_img( 'patterns/az_subtle.png' ) => 'az_subtle',
            assets_img( 'patterns/blizzard.png' ) => 'blizzard',
            assets_img( 'patterns/bright_squares.png' ) => 'bright_squares',
            assets_img( 'patterns/denim.png' ) => 'denim',
            assets_img( 'patterns/fancy_deboss.png' ) => 'fancy_deboss',
            assets_img( 'patterns/gray_jean.png' ) => 'gray_jean',
            assets_img( 'patterns/honey_im_subtle.png' ) => 'honey_im_subtle',
            assets_img( 'patterns/linedpaper.png' ) => 'linedpaper',
            assets_img( 'patterns/linen.png' ) => 'linen',
            assets_img( 'patterns/pw_maze_white.png' ) => 'pw_maze_white',
            assets_img( 'patterns/random_grey_variations.png' ) => 'random_grey_variations',
            assets_img( 'patterns/skin_side_up.png' ) => 'skin_side_up',
            assets_img( 'patterns/stitched_wool.png' ) => 'stitched_wool',
            assets_img( 'patterns/straws.png' ) => 'straws',
            assets_img( 'patterns/subtle_grunge.png' ) => 'subtle_grunge',
            assets_img( 'patterns/textured_stripes.png' ) => 'textured_stripes',
            assets_img( 'patterns/wild_oliva.png' ) => 'wild_oliva',
            assets_img( 'patterns/worn_dots.png' ) => 'worn_dots'
        ),
        'selector' => 'html.boxed body'
    ),
    
    array(
        'label' => __( 'Theme Scheme', 'spyropress' ),
        'id' => 'theme_scheme',
        'type' => 'select',
        'desc' => __( 'Select which scheme you want for theme.', 'spyropress' ),
		'options' => array(
            'dark' => __( 'Dark Scheme', 'spyropress' ),
            'light' => __( 'Light Scheme', 'spyropress' )
		),
        'std' => 'light'
    ),

    array(
		'label' => __( 'Reponsiveness', 'spyropress' ),
		'id' => 'responsive',
        'type' => 'checkbox',
        'options' => array(
            '1' => __( 'Deactivate responsive layout', 'spyropress' ),
        )
	),

    array(
        'label' => __( 'Skin Options', 'spyropress' ),
        'type' => 'sub_heading',
    ),

    array(
        'label' => __( 'Select skin', 'spyropress' ),
        'id' => 'theme_skin',
        'class' => 'skin-selector section-full',
        'type' => 'radio',
        'options' => $skin_options
    ),

    array(
        'type' => 'skin_generator',
        'id' => 'skins'
	),

    array(
        'label' => __( 'Custom CSS', 'spyropress' ),
        'id' => 'custom_css_textarea',
        'class' => 'section-full',
        'type' => 'textarea',
        'rows' => 10
    )

); // END Import/Export

$spyropress_theme_settings['translate'] = array(

	array(
        'label' => __( 'Translate', 'spyropress' ),
        'type' => 'heading',
        'slug' => 'translate',
        'icon' => 'module-icon-docs'
    ),

    array(
		'label' => __( 'General', 'spyropress' ),
		'type' => 'sub_heading'
	),

    array(
        'desc' => __( 'Turn it off if you want to use .mo .po files for more complex translation.', 'spyropress' ),
		'id' => 'translate',
        'type' => 'checkbox',
        'options' => array(
            1 => __( 'Enable Translate', 'spyropress' ),
        )
	),
    
    array(
		'label' => __( 'Home Title', 'spyropress' ),
		'id' => 'home_title',
        'type' => 'text',
        'std' => 'Home'
	),

    array(
		'label' => __( 'Portfolio Title', 'spyropress' ),
		'id' => 'portfolio_title',
        'type' => 'text',
        'std' => 'Portfolio'
	),

    array(
		'label' => __( 'Blog Title', 'spyropress' ),
		'id' => 'blog_title',
        'type' => 'text',
        'std' => 'Blog'
	),
    
    array(
		'label' => __( 'Archive Title', 'spyropress' ),
		'id' => 'archive_title',
        'type' => 'text',
        'std' => 'Archives'
	),
    
    array(
		'label' => __( 'Search Title', 'spyropress' ),
		'id' => 'saerch_title',
        'type' => 'text',
        'std' => 'Term:'
	),
    
    array(
		'label' => __( 'Read More Title', 'spyropress' ),
		'id' => 'read_more_title',
        'type' => 'text',
        'std' => 'Read more...'
	),

    array(
		'label' => __( 'Portfolio', 'spyropress' ),
		'type' => 'sub_heading'
	),

    array(
		'label' => __( 'Description Title', 'spyropress' ),
		'id' => 'portfolio_desc_title',
        'type' => 'text',
        'std' => 'Project <strong>Description</strong>'
	),

    array(
		'label' => __( 'Preview Title', 'spyropress' ),
		'id' => 'portfolio_preview_title',
        'type' => 'text',
        'std' => 'Live Preview'
	),

    array(
		'label' => __( 'Service Title', 'spyropress' ),
		'id' => 'portfolio_service_title',
        'type' => 'text',
        'std' => 'Services'
	),

    array(
		'label' => __( 'Client Title', 'spyropress' ),
		'id' => 'portfolio_client_title',
        'type' => 'text',
        'std' => 'Client'
	),

    array(
		'label' => __( 'Testimonial Title', 'spyropress' ),
		'id' => 'portfolio_testimonial_title',
        'type' => 'text',
        'std' => 'Client Testimonial'
	),

    array(
		'label' => __( 'Comments', 'spyropress' ),
		'type' => 'sub_heading'
	),

    array(
		'id' => 'translate-comment',
		'type' => 'text',
		'label' => __('Comment', 'spyropress'),
		'desc' => __('Text to display when there is one comment', 'spyropress'),
		'std' => 'Comment'
	),

	array(
		'id' => 'translate-comments',
		'type' => 'text',
		'label' => __('Comments', 'spyropress'),
		'desc' => __('Text to display when there are more than one comments', 'spyropress'),
		'std' => 'Comments'
	),

	array(
		'id' => 'translate-comments-off',
		'type' => 'text',
		'label' => __('Comments closed', 'spyropress'),
		'desc' => __('Text to display when comments are disabled', 'spyropress'),
		'std' => 'Comments are closed.'
	),

    array(
		'label' => __( 'Reply Title', 'spyropress' ),
		'id' => 'translate-reply-title',
        'type' => 'text',
        'std' => 'Leave a comment'
	),

    array(
		'label' => __( 'Reply Button', 'spyropress' ),
		'id' => 'translate-reply-btn',
        'type' => 'text',
        'std' => 'Post Comment'
	),

    array(
		'id' => 'comment-reply',
		'type' => 'text',
		'label' => __('Reply', 'spyropress'),
		'desc' => __('Text to display on comment Reply Button', 'spyropress'),
		'std' => 'Reply'
	),

    array(
		'label' => __( '404 Page', 'spyropress' ),
		'type' => 'sub_heading'
	),

    array(
		'label' => __( 'Title', 'spyropress' ),
		'id' => 'error-404-title',
        'type' => 'text',
        'std' => '404'
	),

    array(
		'label' => __( 'Subtitle', 'spyropress' ),
		'id' => 'error-404-subtitle',
        'type' => 'text',
        'std' => '404 - Page Not Found'
	),

    array(
		'label' => __( 'Short Description', 'spyropress' ),
		'id' => 'error-404-text',
        'type' => 'text',
        'std' => 'We\'re sorry, but the page you were looking for doesn\'t exist.'
	),

    array(
		'label' => __( 'Link Title', 'spyropress' ),
		'id' => 'error-404-link-title',
        'type' => 'text',
        'std' => 'Here are some useful links'
	)
);

$spyropress_theme_settings['plugins'] = array(

	array(
        'label' => __( 'Settings', 'spyropress' ),
        'type' => 'heading',
        'slug' => 'plugins',
        'icon' => 'module-icon-general'
    ),

    array(
		'label' => __( 'Email Settings', 'spyropress' ),
		'type' => 'sub_heading'
	),

    array(
		'label' => __( 'Sender Name', 'spyropress' ),
        'desc' => __( 'For example sender name is "WordPress".', 'spyropress' ),
		'id' => 'mail_from_name',
        'type' => 'text'
	),

    array(
		'label' => __( 'Sender Email Address', 'spyropress' ),
        'desc' => __( 'For example sender email address is wordpress@yoursite.com.', 'spyropress' ),
		'id' => 'mail_from_email',
        'type' => 'text'
	),

    array( 'label' => 'Twitter oAuth Settings', 'type' => 'sub_heading' ),

    array(
        'label' => __( 'Consumer Key', 'spyropress' ),
        'id' => 'twitter_consumer_key',
        'type' => 'text'
    ),

    array(
        'label' => __( 'Consumer Secret', 'spyropress' ),
        'id' => 'twitter_consumer_secret',
        'type' => 'text'
    ),

    array(
        'label' => __( 'Access Token', 'spyropress' ),
        'id' => 'twitter_access_token',
        'type' => 'text'
    ),

    array(
        'label' => __( 'Access Token Secret', 'spyropress' ),
        'id' => 'twitter_access_token_secret',
        'type' => 'text'
    ),

    array(
        'type' => 'raw_info',
        'desc' => '<a href="https://dev.twitter.com/apps" target="_blank">Create an Application on Twitter</a>, once your application is created Twitter will generate your Oauth key and access tokens. Paste them below.'
    ),

    array(
		'label' => __( 'WP-Pagenavi', 'spyropress' ),
		'type' => 'toggle'
	),

    array(
		'label' => __( 'Text For Current Page', 'spyropress' ),
		'type' => 'text',
        'id' => 'pagination_current_text',
        'desc' => '%PAGE_NUMBER% - '.__( 'The page number.', 'spyropress' ),
        'std' => '%PAGE_NUMBER%'
	),

    array(
		'label' => __( 'Text For Page', 'spyropress' ),
		'type' => 'text',
        'id' => 'pagination_page_text',
        'desc' => '%PAGE_NUMBER% - ' .__( 'The page number.', 'spyropress' ),
        'std' => '%PAGE_NUMBER%'
	),

    array(
		'label' => __( 'Text For First Page', 'spyropress' ),
		'type' => 'text',
        'id' => 'pagination_first_text',
        'desc' => '%TOTAL_PAGES% - ' .__( 'The total number of pages.', 'spyropress' ),
        'std' => '&laquo; First'
	),

    array(
		'label' => __( 'Text For Last Page', 'spyropress' ),
		'type' => 'text',
        'id' => 'pagination_last_text',
        'desc' => '%TOTAL_PAGES% - ' .__( 'The total number of pages.', 'spyropress' ),
        'std' => 'Last &raquo;'
	),

    array(
		'label' => __( 'Text For Previous Page', 'spyropress' ),
		'type' => 'text',
        'id' => 'pagination_prev_text',
        'std' => '&laquo;'
	),

    array(
		'label' => __( 'Text For Next Page', 'spyropress' ),
		'type' => 'text',
        'id' => 'pagination_next_text',
        'std' => '&raquo;'
	),

    array(
		'label' => __( 'Text For Previous &hellip;', 'spyropress' ),
		'type' => 'text',
        'id' => 'pagination_dotleft_text',
        'std' => '&hellip;'
	),

    array(
		'label' => __( 'Text For Next &hellip;', 'spyropress' ),
		'type' => 'text',
        'id' => 'pagination_dotright_text',
        'std' => '&hellip;'
    ),

    array(
        'label' => __( 'Page Navigation Text', 'spyropress' ),
        'type' => 'sub_heading',
        'desc' => __( 'Leaving a field blank will hide that part of the navigation.', 'spyropress' ),
    ),

    array(
		'label' => __( 'Always Show Page Navigation', 'spyropress' ),
		'type' => 'checkbox',
        'id' => 'pagination_always_show',
        'options' => array(
            1 => __( 'Show navigation even if there\'s only one page.', 'spyropress' ),
        )
    ),

    array(
		'label' => __( 'Number Of Pages To Show', 'spyropress' ),
		'type' => 'text',
        'id' => 'pagination_num_pages',
        'std' => 5
    ),

    array(
		'label' => __( 'Number Of Larger Page Numbers To Show', 'spyropress' ),
		'type' => 'text',
        'id' => 'pagination_num_larger_page_numbers',
        'desc' => __( 'Larger page numbers are in addition to the normal page numbers. They are useful when there are many pages of posts.', 'spyropress' ),
        'std' => 3
    ),

    array(
		'label' => __( 'Show Larger Page Numbers In Multiples Of', 'spyropress' ),
		'type' => 'text',
        'id' => 'pagination_larger_page_numbers_multiple',
        'desc' => __( 'For example, if mutiple is 5, it will show: 5, 10, 15, 20, 25', 'spyropress' ),
        'std' => 10
    ),

    array(
		'type' => 'toggle_end'
	),

); // END PLUGINS

$spyropress_theme_settings['separator'] = array(

	array ( 'type' => 'separator' )

); // END Separator

$spyropress_theme_settings['import'] = array(

	array (
        'label' => __( 'Import / Export', 'spyropress' ),
        'type' => 'heading',
        'slug' => 'import-export',
        'icon' => 'module-icon-import'
    ),
    
    array(
        'type' => 'import_dummy'
	),

    array(
        'type' => 'import'
	),

    array(
        'type' => 'export'
	),
); // END Import/Export

$spyropress_theme_settings['support'] = array(

	array (
        'label' => __( 'Support', 'spyropress' ),
        'type' => 'heading',
        'slug' => 'support',
        'icon' => 'module-icon-support'
    ),

    array(
		'id' => 'admin/docs-support.php',
        'type' => 'include'
	)

); // END Separator
?>