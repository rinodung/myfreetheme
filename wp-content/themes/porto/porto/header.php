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
$bdy_cls = array();
$bdy_cls[] = get_setting( 'theme_layout', 'full' );
$bdy_cls[] = get_setting( 'theme_scheme', 'light' );
?>

<!DOCTYPE html>
<html class="<?php echo join( ' ', $bdy_cls ); ?>" <?php language_attributes(); ?>>
<head>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php spyropress_wrapper(); ?>
    <!-- header -->
    <?php spyropress_before_header(); ?>
    <?php
        spyropress_before_header_content();
        $version = isset( $_GET['header'] ) ? $_GET['header'] :  get_setting( 'header_style', 'v1' );
        get_template_part( 'templates/header/header', $version );
        spyropress_after_header_content();
    ?>
    <?php spyropress_after_header(); ?>
    <!-- /header -->