<div class="progress-bars">
<?php
foreach( $bars as $item ) {
    
    $skin = isset( $item['skin'] ) && !empty( $item['skin'] ) ? $item['skin'] : 'primary';
    $extra = isset( $item['extra'] ) && !empty( $item['extra'] ) ? ' ' . join( ' ', $item['extra'] ) : '';
    $delay = isset( $item['delay'] ) && !empty( $item['delay'] ) ? ' data-appear-animation-delay="' . $item['delay'] . '"' : '';
    echo '
    <div class="progress-label"><span>' . $item['title'] . '</span></div>
	<div class="progress' . $extra . '">
		<div class="progress-bar progress-bar-' . $skin . '" data-appear-progress-animation="' . $item['count'] . '%"' . $delay . '>
			<span class="progress-bar-tooltip">' . $item['count'] . '%</span>
		</div>
	</div>';
}
?>
</div>