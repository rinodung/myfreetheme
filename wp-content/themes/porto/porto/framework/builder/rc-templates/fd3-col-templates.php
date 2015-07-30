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
 * col_11
 */
class col_11 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '1/1 Column', 'spyropress' ),
            'description' => __( 'Full width column', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_11.png' ),
            'size' => 12
        );
    }
}
spyropress_builder_register_column( 'col_11' );

/**
 * col_12
 */
class col_12 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '1/2 Column', 'spyropress' ),
            'description' => __( 'Half width column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_12.png' ),
            'size' => 6
        );
    }
}
spyropress_builder_register_column( 'col_12' );

/**
 * col_13
 */
class col_13 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '1/3 Column', 'spyropress' ),
            'description' => __( 'One-Third width column', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_13.png' ),
            'size' => 4
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
            'name' => __( '1/4 Column', 'spyropress' ),
            'description' => __( 'One-Fourth width column', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_14.png' ),
            'size' => 3
        );
    }
}
spyropress_builder_register_column( 'col_14' );

/**
 * col_16
 */
class col_16 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '1/6 Column', 'spyropress' ),
            'description' => __( 'One-Sixth width column', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_16.png' ),
            'size' => 2
        );
    }
}
spyropress_builder_register_column( 'col_16' );

/**
 * col_23
 */
class col_23 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '2/3 Column', 'spyropress' ),
            'description' => __( 'Two-Third width column', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_23.png' ),
            'size' => 8
        );
    }
}
spyropress_builder_register_column( 'col_23' );

/**
 * col_34
 */
class col_34 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '3/4 Column', 'spyropress' ),
            'description' => __( 'Three-Fourth width column', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_34.png' ),
            'size' => 9
        );
    }
}
spyropress_builder_register_column( 'col_34' );

/**
 * col_56
 */
class col_56 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '5/6 Column', 'spyropress' ),
            'description' => __( 'Five-Sixth width column', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_56.png' ),
            'size' => 10
        );
    }
}
spyropress_builder_register_column( 'col_56' );

/**
 * col_11
 */
class col_s11 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( 'Span11', 'spyropress' ),
            'description' => __( '11 columns of grid', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_56.png' ),
            'size' => 11
        );
    }
}
spyropress_builder_register_column( 'col_s11' );

/**
 * col_7
 */
class col_s7 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( 'Span7', 'spyropress' ),
            'description' => __( '7 columns of grid', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_23.png' ),
            'size' => 7
        );
    }
}
spyropress_builder_register_column( 'col_s7' );

/**
 * col_5
 */
class col_s5 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( 'Span5', 'spyropress' ),
            'description' => __( '5 columns of grid', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_14.png' ),
            'size' => 5
        );
    }
}
spyropress_builder_register_column( 'col_s5' );

/**
 * col_1
 */
class col_s1 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( 'Span1', 'spyropress' ),
            'description' => __( '1 column of grid', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_16.png' ),
            'size' => 1
        );
    }
}
spyropress_builder_register_column( 'col_s1' );
?>