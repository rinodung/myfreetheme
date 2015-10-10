<?php

/**
 * Module: Gmap
 * Add google map into the page layout wherever needed.
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Gmap extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings
        $this->description = __( 'Add google map markers work with google map row only.', 'spyropress' );
        $this->id_base = 'gmap_markers';
        $this->name = __( 'Google Map Markers', 'spyropress' );

        // Fields
        $this->fields = array(


            array(
                'label' => __( 'Markers Location', 'spyropress' ),
                'type' => 'sub_heading',
                'desc' => 'Find the Latitude and Longitude of your address:<br />
                        - http://universimmedia.pagesperso-orange.fr/geo/loc.htm<br />
                        - http://www.findlatitudeandlongitude.com/find-address-from-latitude-and-longitude/'
            ),

            array(
                'labels' => __( 'Markers', 'spyropress' ),
                'id' => 'markers',
                'type' => 'repeater',
                'item_title' => 'title',
                'fields' => array(
                    array(
                        'label' => __( 'Title', 'spyropress' ),
                        'id' => 'title',
                        'type' => 'text'
                    ),

                    array(
                        'label' => __( 'Description', 'spyropress' ),
                        'id' => 'desc',
                        'type' => 'text'
                    ),

                    array(
                        'label' => __( 'Address', 'spyropress' ),
                        'id' => 'address',
                        'type' => 'text'
                    ),

                    array(
                        'label' => __( 'Latitude', 'spyropress' ),
                        'id' => 'lat',
                        'type' => 'text'
                    ),

                    array(
                        'label' => __( 'Longitude', 'spyropress' ),
                        'id' => 'long',
                        'type' => 'text'
                    )
                )
            ),

            array(
                'label' => __( 'Initial Location', 'spyropress' ),
                'type' => 'sub_heading'
            ),

            array(
                'label' => __( 'Latitude', 'spyropress' ),
                'id' => 'init_lat',
                'type' => 'text',
                'std' => '37.09024'
            ),

            array(
                'label' => __( 'Longitude', 'spyropress' ),
                'id' => 'init_long',
                'type' => 'text',
                'std' => '-95.71289'
            ),

            array(
                'label' => __( 'Google Map Options', 'spyropress' ),
                'type' => 'toggle'
            ),

            array(
                'label' => __( 'Zoom Level', 'spyropress' ),
                'id' => 'zoom',
                'type' => 'range_slider',
                'min' => 1,
                'max' => 20,
                'std' => 16
            ),

            array(
                'label' => __( 'Map Type', 'spyropress' ),
                'id' => 'maptype',
                'type' => 'select',
                'options' => array(
                    'ROADMAP' => __( 'Road Map', 'spyropress' ),
                    'SATELLITE' => __( 'Satellite', 'spyropress' ),
                    'HYBRID' => __( 'Hybrid', 'spyropress' ),
                    'TERRAIN' => __( 'Terrain', 'spyropress' ),
                ),
                'std' => 'ROADMAP'
            ),
            
            array(
                'label' => __( 'Height', 'spyropress' ),
                'id' => 'height',
                'type' => 'text',
                'std' => '400'
            ),

            array(
                'type' => 'toggle_end'
            )
        );

        $this->create_widget();
    }

    function widget( $args, $instance ) {

        // extracting info
        $instance = wp_parse_args( $instance, array(
            'zoom' => 5,
            'maptype' => 'ROADMAP',
            'height' => 400

        ) );
        extract( $args ); extract( $instance );

        if( empty( $markers ) ) return;

        wp_enqueue_script( 'gmap-api', 'http' . ( is_ssl() ? 's' : '' ) . '://maps.google.com/maps/api/js?sensor=false', false, false, true );
        wp_enqueue_script( 'jquery-gmap', framework_url() . 'builder/modules/gmap/jquery.gmap.min.js', false, false, true );
        $pin_url = framework_url() . 'builder/modules/gmap/pin.png';

        echo '<style type="text/css">
        .google-map { height: ' . $height . 'px; }
        
        </style>';
        
        echo '<div class="google-map" id="googlemaps"></div>';

        $markers_js = '';
        $count = count( $markers );
        foreach( $markers as $marker ) {
            $anchor = '';
            if( !empty( $marker['lat'] ) && !empty( $marker['long'] ) )
                $anchor = '<br><br><a href=\'#\' onclick=\'mapCenterAt({latitude: ' . $marker['lat'] . ', longitude: ' . $marker['long'] . ', zoom: 16}, event)\'>' . __( '[+] zoom here', 'spyropress' ) . '</a>';

            $popup = ( 1 == $count ) ? ',popup: true' : '';
            $markers_js .= '
            {
                address: "' . $marker['address'] . '",
				html: "<strong>' . $marker['title'] . '</strong><br>' . $marker['desc'] . $anchor . '",
				icon: {
					image: "' . $pin_url . '",
					iconsize: [26, 46],
					iconanchor: [12, 46]
				}
                ' . $popup . '
			},';
        }

        $markers_js = '// Map Markers' . "\n" . 'var mapMarkers = [' . $markers_js . '];';

        $init_lat = !empty( $init_lat ) ? $init_lat : 0;
        $init_long = !empty( $init_long ) ? $init_long : 0;

        $markers_js .= "\n\n" . '// Map Initial Location' . "\n";
        $markers_js .= 'var initLatitude = ' . $init_lat . ';' . "\n";
        $markers_js .= 'var initLongitude = ' . $init_long . ';' . "\n";

        $markers_js .= "\n\n" . '// Map Extended Settings' . "\n";
        $markers_js .= '
        var mapSettings = {
            controls: {
                panControl: true,
                zoomControl: true,
                mapTypeControl: true,
                scaleControl: true,
                streetViewControl: true,
                overviewMapControl: true
			},
            scrollwheel: false,
            maptype: "' . $maptype . '",
			markers: mapMarkers,
			latitude: initLatitude,
            longitude: initLongitude,
            zoom: ' . $zoom . '
        };

        var map = $("#googlemaps").gMap(mapSettings);
        
        // Add Markers
        jQuery.each( mapMarkers, function(index, value) {
            $("#googlemaps").gMap("addMarker", value);
        });
        ';

        $centerat_js = "\n\n" . '// Map Center At' . "\n";
        $centerat_js .= '
        var mapCenterAt = function(options, e) {
            e.preventDefault();
            jQuery("#googlemaps").gMap("centerAt", options);
        }';

        add_jquery_ready( $markers_js );
        add_inline_js( $centerat_js );
    }
}

spyropress_builder_register_module( 'Spyropress_Module_Gmap' );