<?php

if( empty( $lines ) ) return;

echo $before_widget;

if( $title ) echo '<h3 class="push-top">' . $title . '</h3>';

echo '<ul class="history">';
    
    foreach( $lines as $item ) {
        
        $img = ( isset( $item['img'] ) && !empty( $item['img'] ) ) ? '<img src="' . $item['img'] . '" alt="" />' : '';
        
        echo '
        <li data-appear-animation="fadeInUp">
			<div class="thumb">
				' . $img . '
			</div>
			<div class="featured-box">
				<div class="box-content">
					<h4>' . $item['heading'] . '</h4>
					' . wpautop( do_shortcode( $item['content'] ) ) . '
				</div>
			</div>
		</li>';
    }
    
echo '</ul>';

echo $after_widget;