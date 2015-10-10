<?php

/**
 * SpyroPress Options UI
 * Main admin file which create setting screens.
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

class SpyropressOptionsUi extends SpyropressUi {

    function __construct( $options, $id ) {

        global $spyropress;
        
        parent::__construct( $options, $id, get_option( $id . $spyropress->lang ) );

        $this->init();
    }

    function init() {

        $panels = array(
            'panel_start',
            'panel_header',
            'panel_body',
            'panel_footer',
            'panel_end'
        );

        foreach ( $panels as $file )
            include ( admin_path() . 'panel/' . $file . '.php' );
    }
}