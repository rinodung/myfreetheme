<?php

/**
 * Option Machine
 *
 * Create the option page using the options for the page.
 *
 * @category 	Admin
 * @package 	Spyropress
 *
 */

// Generate Option Key
$code = str_replace( 'spyropress-', '', $_GET['page'] );
$key = 'spyropress_' . $code . '_settings';

// Check for define
if ( ! isset( $GLOBALS[$key] ) ) return;

// Get options from Global
$options = $GLOBALS[$key];

// Start the Machine
new SpyropressOptionsUi( $options, $key );