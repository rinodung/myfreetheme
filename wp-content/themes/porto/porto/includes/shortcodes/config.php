<?php

/*-----------------------------------------------------------------------------------*/
/*	Data Sources
/*-----------------------------------------------------------------------------------*/
$spyropress_sc_variations = array(
    'primary' => 'Primary',
    'info' => 'Info',
    'success' => 'Success',
    'warning' => 'Warning',
    'danger' => 'Danger',
    'inverse' => 'Inverse'
);

$spyropress_sc_float = array(
    'left' => 'Left',
    'right' => 'Right'
);

$spyropress_sc_window = array(
    '_blank' => 'New window',
    '_self' => 'Same window'
);
$spyropress_sc_animation = array(
    'flash' => 'Flash',
    'shake' => 'Shake',
    'bounce' => 'Bounce',
    'tada' => 'Tada',
    'swing' => 'Swing',
    'wobble' => 'Wobble',
    'wiggle' => 'Wiggle',
    'pulse' => 'Pulse',
    'fadeIn' => 'FadeIn',
    'fadeInUp' => 'FadeInUp',
    'fadeInDown' => 'FadeInDown',
    'fadeInLeft' => 'FadeInLeft',
    'fadeInRight' => 'FadeInRight',
    'fadeInUpBig' => 'FadeInUpBig',
    'fadeInDownBig' => 'FadeInDownBig',
    'fadeInLeftBig' => 'FadeInLeftBig',
    'fadeInRightBig' => 'FadeInRightBig',
    'bounceIn' => 'BounceIn',
    'bounceInUp' => 'BounceInUp',
    'bounceInDown' => 'BounceInDown',
    'bounceInLeft' => 'BounceInLeft',
    'bounceInRight' => 'BounceInRight',
    'rotateIn' => 'RotateIn',
    'rotateInUpLeft' => 'RotateInUpLeft',
    'rotateInDownLeft' => 'RotateInDownLeft',
    'rotateInUpRight' => 'RotateInUpRight',
    'rotateInDownRight' => 'RotateInDownRight'
);

/**
 * Button Config
 */
$spyropress_shortcodes['button'] = array(
	'no_preview' => true,
	'params' => array(
        'content' => array(
			'std' => 'Button Text',
			'type' => 'text',
			'label' => __( 'Button\'s Text', 'spyropress' ),
			'desc' => __('Add the button\'s text', 'spyropress'),
		),

        'disabled' => array(
			'type' => 'checkbox',
			'label' => __( 'Disabled Button', 'spyropress' ),
            'checkbox_text' => __( 'Make the button state disable', 'spyropress' ),
            'desc' => ''
		),

		'size' => array(
			'type' => 'select',
			'label' => __( 'Button Size', 'spyropress' ),
			'desc' => __( 'Select the button\'s size', 'spyropress' ),
			'options' => array(
				'xs' => 'Mini',
				'sm' => 'Small',
				'default' => 'Medium',
				'lg' => 'Large'
			)
		),

		'cls' => array(
			'type' => 'select',
			'label' => __( 'Variation', 'spyropress' ),
			'desc' => __( 'Select the button\'s style', 'spyropress' ),
			'options' => $spyropress_sc_variations
		)
	),
    'shortcode' => 'button'
);

/**
 * Button Link Config
 */
$spyropress_shortcodes['button_link'] = array(
	'no_preview' => true,
	'params' => array(
        'content' => array(
			'std' => 'Button Text',
			'type' => 'text',
			'label' => __( 'Button\'s Text', 'spyropress' ),
			'desc' => __('Add the button\'s text', 'spyropress'),
		),

        'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Button URL', 'spyropress'),
			'desc' => __('Add the button\'s url eg http://example.com', 'spyropress' )
		),

        'disabled' => array(
			'type' => 'checkbox',
			'label' => __( 'Disabled Button', 'spyropress' ),
            'checkbox_text' => __( 'Make the button state disable', 'spyropress' ),
            'desc' => ''
		),

		'size' => array(
			'type' => 'select',
			'label' => __( 'Button Size', 'spyropress' ),
			'desc' => __( 'Select the button\'s size', 'spyropress' ),
			'options' => array(
				'xs' => 'Mini',
				'sm' => 'Small',
				'medium' => 'Medium',
				'lg' => 'Large'
			)
		),

		'cls' => array(
			'type' => 'select',
			'label' => __( 'Variation', 'spyropress' ),
			'desc' => __( 'Select the button\'s style', 'spyropress' ),
			'options' => $spyropress_sc_variations
		),

        'extra_cls' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Extra CssClass', 'spyropress'),
			'desc' => ''
		),
	),
	'shortcode' => 'btn_link',
);

/**
 * Image Config
 */
$spyropress_shortcodes['img'] = array(
	'no_preview' => true,
	'params' => array(

        'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Image URL', 'spyropress'),
			'desc' => __('Add the image\'s url eg http://example.com', 'spyropress' )
		),

        'alt' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Alternative Text', 'spyropress'),
			'desc' => ''
		),

		'cls' => array(
			'type' => 'select',
			'label' => __( 'Style', 'spyropress' ),
			'desc' => __( 'Select the image\'s style', 'spyropress' ),
			'options' => array(
				'rounded' => 'Rounded',
				'circle' => 'Circle',
				'polaroid' => 'Polaroid',
                'responsive' => 'Responsive'
			)
		)
	),
	'shortcode' => 'img',
);

/**
 * Promo Image Config
 */
$spyropress_shortcodes['promo_image'] = array(
	'no_preview' => true,
	'params' => array(

        'content' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Image URL', 'spyropress'),
			'desc' => __('Add the image\'s url eg http://example.com', 'spyropress' )
		),

        'animation' => array(
			'type' => 'select',
			'label' => __( 'Animation', 'spyropress'),
			'desc' => '',
			'options' => $spyropress_sc_animation
		)
	),
	'shortcode' => 'promo_img',
);

/**
 * Alert Config
 */
$spyropress_shortcodes['alerts'] = array(
	'no_preview' => true,
	'params' => array(
        'title' => array(
			'std' => 'Title',
			'type' => 'text',
			'label' => __('Alert Title', 'spyropress'),
			'desc' => __('Add the alert\'s title', 'spyropress'),
		),

		'content' => array(
			'std' => '<strong>Oh snap!</strong> Nulla vitae elit libero, a pharetra augue. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.',
			'type' => 'textarea',
			'label' => __('Alert Text', 'spyropress'),
			'desc' => __('Add the alert\'s text', 'spyropress'),
		),

        'type' => array(
			'type' => 'select',
			'label' => __('Alert Style', 'spyropress'),
			'desc' => __('Select the alert\'s style, ie the alert colour', 'spyropress'),
			'options' => array(
				'warning' => 'Warning',
				'error' => 'Error',
				'info' => 'Info',
				'success' => 'Success'
			)
		),

        'close' => array(
			'type' => 'checkbox',
			'label' => __( 'Close Button', 'spyropress' ),
            'checkbox_text' => __( 'To dismiss alerts', 'spyropress' ),
            'desc' => ''
		),

        'fade' => array(
			'type' => 'checkbox',
			'label' => __( 'Fade Alert', 'spyropress' ),
            'checkbox_text' => __( 'To dismiss alerts with fadeOut animation', 'spyropress' ),
            'desc' => ''
		)
	),
	'shortcode' => 'alerts'
);

/**
 * Lightbox Config
 */
$spyropress_shortcodes['lightbox'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'type' => 'text',
			'label' => __('Image Source', 'spyropress'),
			'desc' => '',
			'std' => ''
		),

        'full' => array(
			'type' => 'text',
			'label' => __('Full Image Source', 'spyropress'),
			'desc' => '',
			'std' => ''
		),

		'pull' => array(
			'type' => 'select',
			'label' => __( 'Image Alignment', 'spyropress'),
			'desc' => __('Select the image alignment left or right', 'spyropress'),
			'options' => $spyropress_sc_float
		)
	),
	'shortcode' => 'lightbox'
);

/**
 * Progress Bar Config
 */
$spyropress_shortcodes['progress_bar'] = array(
	'no_preview' => true,
    'params' => array(
		'content' => array(
			'type' => 'text',
			'label' => __( 'Label', 'spyropress'),
			'desc' => __( 'Set progress label', 'spyropress'),
			'std' => '50'
		),

        'progress' => array(
			'type' => 'text',
			'label' => __( 'Progress', 'spyropress'),
			'desc' => __( 'Set progress percentage', 'spyropress'),
			'std' => '50'
		),

        'cls' => array(
			'type' => 'select',
			'label' => __('Variation', 'spyropress'),
			'desc' => __( 'Select the bar\'s style', 'spyropress' ),
			'options' => $spyropress_sc_variations
		),

		'style' => array(
			'type' => 'select',
			'label' => __( 'Style', 'spyropress'),
			'desc' => __('Select the bar\'s style', 'spyropress'),
			'options' => array(
                '' => 'Default',
                'striped' => 'Striped',
                'animated' => 'Animated'
            )
		),
        'animate' => array(
			'type' => 'checkbox',
			'label' => __( 'Animate Progress', 'spyropress' ),
            'checkbox_text' => __( 'To animate the progress', 'spyropress' ),
            'desc' => ''
		),

        'delay' => array(
			'type' => 'text',
			'label' => __( 'Delay', 'spyropress' ),
            'checkbox_text' => __( 'Delay in progress animation', 'spyropress' ),
            'desc' => '',
            'std' => ''
		),
	),
	'shortcode' => 'bar'
);

$spyropress_shortcodes['progress_bar1'] = array(
	'no_preview' => true,
    'params' => array(),
    'child_shortcode' => array(
    	'params' => array(
    		'progress' => array(
    			'type' => 'text',
    			'label' => __( 'Progress', 'spyropress'),
    			'desc' => __( 'Set progress percentage', 'spyropress'),
    			'std' => '50'
    		),

            'variation' => array(
    			'type' => 'select',
    			'label' => __('Variation', 'spyropress'),
    			'desc' => __( 'Select the bar\'s style', 'spyropress' ),
    			'options' => $spyropress_sc_variations
    		),

    		'style' => array(
    			'type' => 'select',
    			'label' => __( 'Style', 'spyropress'),
    			'desc' => __('Select the bar\'s style', 'spyropress'),
    			'options' => array(
                    '' => 'Default',
                    'striped' => 'Striped',
                    'animated' => 'Animated'
                )
    		)
    	),
        'shortcode' => 'bar',
        'clone_button' => __('Add Bar', 'spyropress')
     ),
	'shortcode' => 'bars] {{child_shortcode}}  [/bars'
);

/**
 * Tables Config
 */
$spyropress_shortcodes['tables'] = array(
	'no_preview' => true,
	'params' => array(
		'cls' => array(
			'type' => 'multi_select',
			'label' => __( 'Style', 'spyropress'),
			'desc' => __('Select the table\'s style', 'spyropress'),
			'options' => array(
                'table-striped' => 'Table Striped',
                'table-bordered' => 'Table Bordered',
                'table-hover' => 'Table Hover',
                'table-condensed' => 'Table Condensed'
            )
		)
	),
	'shortcode' => 'tables',
    'defaultContent' => '<table><thead><tr><th>#</th><th>First Name</th><th>Last Name</th><th>Username</th></tr></thead><tbody><tr><td>1</td><td>Mark</td><td>Otto</td><td>@mdo</td></tr><tr><td>2</td><td>Jacob</td><td>Thornton</td><td>@fat</td></tr><tr><td>3</td><td>Larry</td><td>the Bird</td><td>@twitter</td></tr></tbody></table>'
);

/**
 * Tooltip Config
 */
$spyropress_shortcodes['tooltip'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'type' => 'text',
			'label' => __('Title', 'spyropress'),
			'desc' => '',
			'std' => ''
		),

        'tip' => array(
			'type' => 'textarea',
			'label' => __('Tooltip', 'spyropress'),
			'desc' => '',
			'std' => ''
		),

		'position' => array(
			'type' => 'select',
			'label' => __( 'Position', 'spyropress'),
			'desc' => '',
			'options' => array(
                'top' => 'Top',
                'bottom' => 'Bottom',
                'left' => 'Left',
                'right' => 'Right'
            )
		)
	),
	'shortcode' => 'tooltip'
);

/**
 * Alternative Font Config
 */
$spyropress_shortcodes['typo_alt_font'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'type' => 'text',
			'label' => __('Content', 'spyropress'),
			'desc' => '',
			'std' => 'Content goes here'
		),

		'animation' => array(
			'type' => 'select',
			'label' => __( 'Animation', 'spyropress'),
			'desc' => '',
			'options' => $spyropress_sc_animation
		)
	),
	'shortcode' => 'alt_font'
);

/**
 * Inverted Font Config
 */
$spyropress_shortcodes['typo_inverted'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'type' => 'text',
			'label' => __('Content', 'spyropress'),
			'desc' => '',
			'std' => 'Content goes here'
		),

		'animation' => array(
			'type' => 'select',
			'label' => __( 'Animation', 'spyropress'),
			'desc' => '',
			'options' => $spyropress_sc_animation
		)
	),
	'shortcode' => 'inverted'
);

/**
 * Label Config
 */
$spyropress_shortcodes['typo_labels'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'type' => 'text',
			'label' => __('Title', 'spyropress'),
			'desc' => '',
			'std' => 'Label goes here'
		),

		'cls' => array(
			'type' => 'select',
			'label' => __( 'Variation', 'spyropress'),
			'desc' => '',
			'options' => $spyropress_sc_variations
		)
	),
	'shortcode' => 'label'
);

/**
 * Icon List Config
 */
$spyropress_shortcodes['icon_list'] = array(
	'no_preview' => true,
	'params' => array(

		'icon' => array(
			'type' => 'select',
			'label' => __( 'Icon', 'spyropress'),
			'desc' => '',
			'options' => spyropress_get_options_fontawesome_icons()
		)
	),
	'shortcode' => 'icon_list',
    'defaultContent' => '<ul><li>content goes here.</li><li>content goes here.</li><li>content goes here.</li></ul>'
);

/**
 * Icon Config
 */
$spyropress_shortcodes['icon'] = array(
	'no_preview' => true,
	'params' => array(

		'icon' => array(
			'type' => 'select',
			'label' => __( 'Icon', 'spyropress'),
			'desc' => '',
			'options' => spyropress_get_options_fontawesome_icons()
		)
	),
	'shortcode' => 'icon',
);

/**
 * Blockquote Config
 */
$spyropress_shortcodes['typo_blockquote'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'type' => 'textarea',
			'label' => __('Quote', 'spyropress'),
			'desc' => '',
			'std' => ''
		),

        'author' => array(
			'type' => 'text',
			'label' => __('Author', 'spyropress'),
			'desc' => '',
			'std' => ''
		),

        'source' => array(
			'type' => 'text',
			'label' => __('Source', 'spyropress'),
			'desc' => '',
			'std' => ''
		),

		'style' => array(
			'type' => 'select',
			'label' => __( 'Style', 'spyropress'),
			'desc' => '',
			'options' => array(
                '' => 'default',
                's1' => 'Style 1',
                'left' => 'Left',
                'right' => 'Right'
            )
		)
	),
	'shortcode' => 'blockquote'
);