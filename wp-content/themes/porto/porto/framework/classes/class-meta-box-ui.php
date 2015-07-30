<?php

/**
 * SpyroPress Meta Box UI
 * Main admin file which create metabox screens.
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

class SpyropressMetaBoxUi extends SpyropressUi {

    function __construct( $options, $id, $settings, $build_tabs = true ) {

        parent::__construct( $options, $id, $settings, $build_tabs );
        include ( admin_path() . 'metabox/box_body.php' );
    }
}

?>