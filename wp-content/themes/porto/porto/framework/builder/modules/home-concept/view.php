<div class="<?php get_row_class(); ?> center">
	<span class="sun"></span>
	<span class="cloud"></span>
<?php
    $counter = 0;
    foreach( $concepts as $concept ) {
        
        $class = 'col-md-2';
        $animation = '';
        
        if( 0 == $counter)
            $class .= ' col-md-offset-1';
        else {
            $animation = ' data-appear-animation-delay="' . ( 200 * $counter ) . '"';
        }
        
        echo '
        <div class="' . $class . '">
    		<div class="process-image" data-appear-animation="bounceIn"' . $animation . '>
                <img src="' . $concept['img'] . '" alt="" />
    			<strong>' . $concept['title'] . '</strong>
    		</div>
    	</div>';
        
        $counter++;
    }
    
    if( !empty( $works ) ) {
        
        $js = '
        // Circle Slider
    	if($("#fcSlideshow").get(0)) {
    		$("#fcSlideshow").flipshow();
    
    		setInterval( function() {
    			$("#fcSlideshow div.fc-right span:first").click();
    		}, 3000);
    
    	}
        
        theme.Spyropress.moveCloud();';
        add_jquery_ready( $js );
?>
	<div class="col-md-4 col-md-offset-1">
		<div class="project-image">
			<div id="fcSlideshow" class="fc-slideshow">
				<ul class="fc-slides">
                <?php
                foreach( $works as $work ) {
                    $work_url = '#';
                    if( isset( $work['url'] ) )
                        $work_url = $work['url'];
                    elseif ( isset( $work['link'] ) )
                        $work_url = get_permalink( $work['link'] );
                    
                    echo '<li><a href="' . $work_url . '">' . get_image( array( 'class' => 'img-responsive', 'width' => 350, 'echo' => false, 'url' => $work['img'] ) ) .'</a></li>';
                }
                ?>
				</ul>
			</div>
            <?php if( $work_title ) { ?>
			<strong class="our-work"><?php echo $work_title ?></strong>
            <?php } ?>
		</div>
	</div>
    <?php } ?>
</div>