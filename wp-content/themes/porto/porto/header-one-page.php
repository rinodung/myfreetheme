<?php
/*
 * Core Spyropress header template
 *
 * Customise this in your child theme by:
 * - Using hooks and your own functions
 * - Using the 'header-content' template part
 * - For example 'header-content-category.php' for category view or 'header-content.php' (fallback if location specific file not available)
 * - Copying this file to your child theme and customising - it will over-ride this file
 *
 * @package Spyropress
 */
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]> <html class="ie ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'one-page' ); ?> data-target=".single-menu" data-spy="scroll" data-offset="200">
<?php spyropress_wrapper(); ?>
    <?php spyropress_before_header(); ?>
    <!-- header -->
    <?php
        spyropress_before_header_content();
        spyropress_get_template_part( 'part=templates/header/header-onepage' );
        spyropress_after_header_content();
    ?>
    <!-- /header -->
    <?php spyropress_after_header(); ?>