<?php

// chcek
if ( empty( $toggles ) ) return;

$count = 0;
$tabs_content = '';
foreach( $toggles as $tab ) {
    ++$count;
    $active = ( $count == 1 ) ? ' active' : '';
    
    $tabs_content .= '<section class="toggle' . $active . '"><label>' . $tab['title'] . '</label><div class="toggle-content">';
    
    // content
    if( isset( $tab['bucket'] ) ) {
        $args = array(
            'post_type' => 'bucket',
            'p' => $tab['bucket']
        );
        $query = new WP_Query( $args );
        while( $query->have_posts() ) {
            $query->the_post();
            $tabs_content .= spyropress_get_the_content();
        }
    }
    else {
        $tabs_content .= apply_filters( 'the_content', $tab['content'] );
    }
    $tabs_content .= '</div></section>';
}
wp_reset_query();

if( 'one' == $template ) {
    echo str_replace( 'toogle">', 'toggle" data-plugin-toggle data-plugin-options=\'{ "isAccordion": true }\'>', $before_widget ) . $tabs_content . $after_widget;
}
else {
    echo str_replace( '>', ' data-plugin-toggle>', $before_widget ) . $tabs_content . $after_widget;
}