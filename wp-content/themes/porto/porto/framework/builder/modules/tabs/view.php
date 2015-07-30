<?php

// chcek
if ( empty( $tabs ) ) return;


global $spyropress_tab_counter;
$count = 0;

$tab_nav = $tabs_content = '';
foreach( $tabs as $tab ) {
    ++$spyropress_tab_counter;
    ++$count;
    
    $li_class = ( $count == 1 ) ? ' class="active"' : '';
    $active = ( $count == 1 ) ? ' active' : '';
    
    $icon = isset( $tab['icon'] ) ? '<i class="fa ' . $tab['icon'] . '"></i> ' : '';
    $tab_nav .= '<li' . $li_class . '><a href="#tab' . $spyropress_tab_counter . '" data-toggle="tab">' . $icon . $tab['title'] . '</a></li>';
    $tabs_content .= '<div class="tab-pane' . $active . '" id="tab' . $spyropress_tab_counter . '">';
    
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
        $tabs_content .= do_shortcode( $tab['content'] );
    }
    $tabs_content .= '</div> <!-- end tab-pane -->';
}
wp_reset_query();

$nav = ' nav-' . $tab_align;
$tab_class = '';
$tab_pos = 'top';

switch( $tab_position ) {
    case 'bottom':
        $tab_class = ' tabs-bottom';
        $tab_pos = 'bottom';
        break;
    case 'vertical':
        $tab_class = ' tabs-vertical tabs-' . $tab_align;
        $tab_pos = ( 'right' == $tab_align ) ? 'bottom' : 'top';
        $nav .= ' col-sm-3';
        break; 
}

?>
<div class="tabs<?php echo $tab_class; ?>">
    <?php if( 'top' == $tab_pos ) : ?>
    <ul class="nav nav-tabs<?php echo $nav; ?>">
        <?php echo $tab_nav; ?>
    </ul>
    <?php endif; ?>
    <div class="tab-content">
        <?php echo $tabs_content; ?>
    </div>
    <?php if( 'bottom' == $tab_pos ) : ?>
    <ul class="nav nav-tabs<?php echo $nav; ?>">
        <?php echo $tab_nav; ?>
    </ul>
    <?php endif; ?>
</div> <!-- end tabbable -->