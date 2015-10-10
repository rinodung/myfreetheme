<?php

/**
 * SpyroPress Framework Hooks
 * Action/filter hooks registered by SpyroPress Framework.
 *
 * @category Core
 * @package SpyroPress
 * @since 1.0
 *
 */

/** Head *****************************************************/

function spyropress_head() {
    spyropress_do_atomic( 'spyropress_head' );
}

/** Wrapper Hooks ********************************************/

function spyropress_wrapper() {
    spyropress_do_atomic( 'spyropress_wrapper' );
}

function spyropress_wrapper_end() {
    spyropress_do_atomic( 'spyropress_wrapper_end' );
}

/** Header Hooks *********************************************/

function spyropress_before_header() {
    spyropress_do_atomic( 'spyropress_before_header' );
}

function spyropress_after_header() {
    spyropress_do_atomic( 'spyropress_after_header' );
}

function spyropress_before_header_content() {
    spyropress_do_atomic( 'spyropress_before_header_content' );
}

function spyropress_after_header_content() {
    spyropress_do_atomic( 'spyropress_after_header_content' );
}

/** Footer Hooks ********************************************/

function spyropress_footer() {
    spyropress_do_atomic( 'spyropress_footer' );
}

function spyropress_before_footer() {
    spyropress_do_atomic( 'spyropress_before_footer' );
}

function spyropress_after_footer() {
    spyropress_do_atomic( 'spyropress_after_footer' );
}

function spyropress_before_footer_content() {
    spyropress_do_atomic( 'spyropress_before_footer_content' );
}

function spyropress_after_footer_content() {
    spyropress_do_atomic( 'spyropress_after_footer_content' );
}

/** Main Container Hooks ***********************************/

function spyropress_before_main_container() {
    spyropress_do_atomic( 'spyropress_before_main_container' );
}

function spyropress_after_main_container() {
    spyropress_do_atomic( 'spyropress_after_main_container' );
}

/** Loop Hooks ********************************************/

function spyropress_before_loop() {
    spyropress_do_atomic( 'spyropress_before_loop' );
}

function spyropress_after_loop() {
    spyropress_do_atomic( 'spyropress_after_loop' );
}

/** Post Hooks ********************************************/

function spyropress_before_post() {
    spyropress_do_atomic( 'spyropress_before_post' );
}

function spyropress_after_post() {
    spyropress_do_atomic( 'spyropress_after_post' );
}

function spyropress_before_post_title() {
    spyropress_do_atomic( 'spyropress_before_post_title' );
}

function spyropress_after_post_title() {
    spyropress_do_atomic( 'spyropress_after_post_title' );
}

function spyropress_before_post_content() {
    spyropress_do_atomic( 'spyropress_before_post_content' );
}

function spyropress_after_post_content() {
    spyropress_do_atomic( 'spyropress_after_post_content' );
}

/** Comments Hooks ****************************************/
function spyropress_before_comments() {
    spyropress_do_atomic( 'spyropress_before_comments' );
}

function spyropress_after_comments() {
    spyropress_do_atomic( 'spyropress_after_comments' );
}

function spyropress_before_comments_form() {
    spyropress_do_atomic( 'spyropress_before_comments_form' );
}

function spyropress_after_comments_form() {
    spyropress_do_atomic( 'spyropress_after_comments_form' );
}

/** Sidebar Hooks ****************************************/

function spyropress_before_sidebar() {
    spyropress_do_atomic( 'spyropress_before_sidebar' );
}

function spyropress_after_sidebar() {
    spyropress_do_atomic( 'spyropress_after_sidebar' );
}

?>