<div class="row center counters">
<?php
foreach( $stats as $item ) {
    $append = ( isset( $item['append'] ) && !empty( $item['append'] ) ) ? ' data-append="' . $item['append'] . '"' : '';
    echo '<div class="col-md-3 col-sm-6"><strong data-to="' . $item['count'] . '"' . $append . '>0</strong><label>' . $item['title'] . '</label></div>';
}
?>
</div>