<?php

// Setup Instance for view
$filters = isset( $instance['enable'] );

// output content
if( $instance['title'] )
    echo '<h2' . spyropress_build_atts( array( 'animation' => $instance['animation'] ), 'data-appear-' ) . '>' . $instance['title'] . '</h2>';

if( $filters ) {
    $terms = get_terms( 'designation' );

    if( !empty( $terms ) && !is_wp_error( $terms ) ) {
        $instance['callback'] = array( $this, 'generate_filter_item' );
        wp_enqueue_script( 'jquery-isotope' );

        echo '
        <ul class="nav nav-pills sort-source" data-sort-id="team" data-option-key="filter">
            <li data-option-value="*" class="active"><a href="#">' . $instance['all_label'] . '</a></li>';

        foreach( $terms as $item )
            echo '<li data-option-value=".' . $item->slug . '"><a href="#">' . $item->name . '</a></li>';

        echo '</ul><hr/>';
    }
}

echo ( $filters ) ? '<div class="row"><ul class="team-list sort-destination" data-sort-id="team">' : '<div class="row"><ul class="team-list">';
    echo $this->query( $instance, '{content}' );
echo '</ul></div>';