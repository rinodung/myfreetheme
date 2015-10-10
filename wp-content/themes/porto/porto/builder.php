<?php

global $wp_query;
$template_id = $wp_query->queried_template_id;

spyropress_get_builder_header();
if ( spyropress_has_builder_content( $template_id ) ) {
    spyropress_the_builder_content( $template_id );
}
spyropress_get_builder_footer();

?>