<?php

/**
 * SpyroPress Builder
 * Default builder row types
 *
 * @author 		SpyroSol
 * @category 	Builder
 * @package 	Spyropress
 */


/**
 * col_16
 */
class col_16 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '1/1 Column', 'spyropress' ),
            'description' => __( 'Full width column', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_11.png' ),
            'size' => 16
        );
    }
}
spyropress_builder_register_column( 'col_16' );

/**
 * col_1by2
 */
class col_1by2 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '1/2 Column', 'spyropress' ),
            'description' => __( 'Half width column', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_12.png' ),
            'size' => 8
        );
    }
}
spyropress_builder_register_column( 'col_1by2' );

/**
 * col_1by3
 */
class col_1by3 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '1/3 Column', 'spyropress' ),
            'description' => __( 'One Third column', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_13.png' ),
            'size' => '1/3'
        );
    }
}
spyropress_builder_register_column( 'col_1by3' );

/**
 * col_1by4
 */
class col_1by4 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '1/4 Column', 'spyropress' ),
            'description' => __( 'One-Fourth width column', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_14.png' ),
            'size' => 4
        );
    }
}
spyropress_builder_register_column( 'col_1by4' );

/**
 * col_1by8
 */
class col_1by8 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '1/8 Column', 'spyropress' ),
            'description' => __( 'One-Eight width column', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_16.png' ),
            'size' => 2
        );
    }
}
spyropress_builder_register_column( 'col_1by8' );

/**
 * col_3by4
 */
class col_3by4 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '3/4 Column', 'spyropress' ),
            'description' => __( 'Three-Fourth width column', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_34.png' ),
            'size' => 12
        );
    }
}
spyropress_builder_register_column( 'col_3by4' );

/**
 * col_3by8
 */
class col_3by8 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '3/8 Column', 'spyropress' ),
            'description' => __( 'Three-Eigth width column', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_56.png' ),
            'size' => 6
        );
    }
}
spyropress_builder_register_column( 'col_3by8' );

/**
 * col_5by8
 */
class col_5by8 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '5/8 Column', 'spyropress' ),
            'description' => __( 'Five-Eigth width column', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_56.png' ),
            'size' => 10
        );
    }
}
spyropress_builder_register_column( 'col_5by8' );

/**
 * col_1
 */
class col_1 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( 'Span1', 'spyropress' ),
            'description' => __( '1 column of grid', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_16.png' ),
            'size' => 1
        );
    }
}
spyropress_builder_register_column( 'col_1' );

/**
 * col_3
 */
class col_3 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( 'Span3', 'spyropress' ),
            'description' => __( '3 columns of grid', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_14.png' ),
            'size' => 3
        );
    }
}
spyropress_builder_register_column( 'col_3' );

/**
 * col_5
 */
class col_5 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( 'Span5', 'spyropress' ),
            'description' => __( '5 columns of grid', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_13.png' ),
            'size' => 5
        );
    }
}
spyropress_builder_register_column( 'col_5' );

/**
 * col_7
 */
class col_7 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( 'Span7', 'spyropress' ),
            'description' => __( '7 columns of grid', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_12.png' ),
            'size' => 7
        );
    }
}
spyropress_builder_register_column( 'col_7' );

/**
 * col_9
 */
class col_9 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( 'Span9', 'spyropress' ),
            'description' => __( '9 columns of grid', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_23.png' ),
            'size' => 9
        );
    }
}
spyropress_builder_register_column( 'col_9' );

/**
 * col_11
 */
class col_11 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( 'Span11', 'spyropress' ),
            'description' => __( '11 columns of grid', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_34.png' ),
            'size' => 11
        );
    }
}
spyropress_builder_register_column( 'col_11' );

/**
 * col_13
 */
class col_13 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( 'Span13', 'spyropress' ),
            'description' => __( '13 columns of grid', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_34.png' ),
            'size' => 13
        );
    }
}
spyropress_builder_register_column( 'col_13' );

/**
 * col_14
 */
class col_14 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( 'Span14', 'spyropress' ),
            'description' => __( '14 columns of grid', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_56.png' ),
            'size' => 14
        );
    }
}
spyropress_builder_register_column( 'col_14' );

/**
 * col_15
 */
class col_15 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( 'Span15', 'spyropress' ),
            'description' => __( '15 columns of grid', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_56.png' ),
            'size' => 15
        );
    }
}
spyropress_builder_register_column( 'col_15' );
?>