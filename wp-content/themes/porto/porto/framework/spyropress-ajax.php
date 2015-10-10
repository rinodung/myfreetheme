<?php

/**
 * SpyroPress Ajax Handlers
 * Handles AJAX requests via wp_ajax hook (both admin and front-end events)
 *
 * @category 	AJAX
 * @package 	SpyroPress
 */

/** Admin AJAX events *****************************************************/

add_action( 'wp_ajax_spyropress_update_options', 'spyropress_update_options_ajax' );
add_action( 'wp_ajax_spyropress_reset_options', 'spyropress_reset_options_ajax' );
add_action( 'wp_ajax_spyropress_import_options', 'spyropress_import_options_ajax' );
add_action( 'wp_ajax_spyropress_search_taxonomy', 'wp_ajax_spyropress_search_taxonomy' );
add_action( 'wp_ajax_get_google_webfonts', 'wp_ajax_spyropress_get_google_webfonts' );

add_action( 'wp_ajax_spyropress_skin_generator', 'spyropress_skin_generator' );
add_action( 'wp_ajax_spyropress_skin_remove', 'spyropress_skin_remove' );

/** Admin AJAX Functions *************************************************/

/**
 * Save SpyroPress Panel Options
 */
function spyropress_update_options_ajax() {
    global $spyropress;
    
    // Security check
    check_ajax_referer( 'spyropress-update-options', 'security' );

    // Generate Option Key
    $key = 'spyropress_' . $_POST['setting_panel_name'];

    // Check for define
    if ( ! isset( $GLOBALS[$key] ) ) return;

    // Get options from Global
    $options = $GLOBALS[$key];

    // Update Theme Options
    $settings = spyropress_update_settings( $options );

    $result = update_option( $key . $spyropress->lang, $settings[0] );

    // Save Dynamic CSS
    if ( $result ) do_action( 'spyropress_after_options_saved', $settings, $key );

    // Allow developer to perform actions
    do_action( 'spyropress_update_' . $_POST['setting_panel_name'], $settings, $key );

    // Exit
    die();
}

/**
 * Reset SpyroPress Panel Options
 */
function spyropress_reset_options_ajax() {

    // Security
    check_ajax_referer( 'spyropress-update-options', 'security' );

    // Generate Option Key
    $key = 'spyropress_' . $_POST['setting_panel_name'];

    // Check for define
    if ( ! isset( $GLOBALS[$key] ) ) {
        _e( 'false', 'spyropress' );
        die();
    }

    // Reset Options to Default
    spyropress_setup_options_default( $key );

    // Allow developer to perform actions
    do_action( 'spyropress_reset_' . $_POST['setting_panel_name'] );

    // Refresh page
    echo 'window.location = "' . $_SERVER['HTTP_REFERER'] . '";';

    // Exit
    die();
}

/**
 * Restore SpyroPress Panel Options
 */
function spyropress_import_options_ajax() {
    global $spyropress;
    
    // Security
    check_ajax_referer( 'spyropress-update-options', 'security' );

    // Generate Option Key
    $key = 'spyropress_' . $_POST['setting_panel_name'];

    // Check for define
    if ( ! isset( $GLOBALS[$key] ) ) {
        _e( 'false', 'spyropress' );
        die();
    }

    // Doing import
    $data = $_POST['settings'];
    $data = spyropress_decode( $data );

    update_option( $key . $spyropress->lang, $data );

    // Allow developer to perform actions
    do_action( 'spyropress_import_' . $_POST['setting_panel_name'] );

    // Refresh page
    echo 'window.location = "' . $_SERVER['HTTP_REFERER'] . '";';

    // Exit
    die();
}

/**
 * Skin Generator
 */
function spyropress_skin_generator( ) {
    
    // Security
    check_ajax_referer( 'skin_generator_form', 'skin_generator_nonce' );
        
    $name = $_POST['skin_name'];
    $color = $_POST['skin_color'];
    $gradient = $_POST['skin_gradient'];
    
    if( empty( $name ) || empty( $color ) ) die();
        
    // generate filename
    $filename = spyropress_uglify( $name );
    $skin = template_path() . 'assets/less/skin.less';
    $css = template_path() . 'assets/css/skins/' . $filename . '.css';
    
    // Delte previous file
    if( file_exists( $css ) ) unlink( $css );
    
    // LESS
    require framework_classes() . 'class-lessc.php';
    $less = new lessc;
    $less->setFormatter( 'compressed' );
    $less->setVariables( array(
        'skinColor' => spyropress_validate_setting( $color, 'colorpicker', 'skin_color', array( ) ),
        'gradient' => $gradient
    ) );
    
    $result = $less->compileFile( $skin, $css );
    
    if( $result ) {
        $skins = get_option( '_spyropress_porto_skins' );
        $skins = $skins ? $skins : array();
        $skins[$filename] = array(
            'name' => $name,
            'color' => $color,
            'gradient' => $gradient
        );
        
        update_option( '_spyropress_porto_skins', $skins );
    }
    
    // Refresh page
    echo 'window.location = "' . $_SERVER['HTTP_REFERER'] . '";';

    // Exit
    die();
}

function spyropress_skin_remove( ) {
    
    // Security
    check_ajax_referer( 'skin_generator_form', 'skin_generator_nonce' );
        
    $filename = $_POST['skin_name'];
    
    if( empty( $filename ) ) die();
        
    // generate filename
    $css = template_path() . 'assets/css/skins/' . $filename . '.css';
    
    // Delte previous file
    unlink( $css );
    
    $skins = get_option( '_spyropress_porto_skins' );
    unset( $skins[$filename] );
    update_option( '_spyropress_porto_skins', $skins );
    
    // Refresh page
    echo 'window.location = "' . $_SERVER['HTTP_REFERER'] . '";';

    // Exit
    die();
}
/**
 * Ajax Search function for Ajax Chosen
 */
function wp_ajax_spyropress_search_taxonomy() {

    $type = $_REQUEST['type'];
    $wp_type = $_REQUEST['wp_type'];

    if ( 'custom_post' == $type )
        search_custom_post( $wp_type );
    if ( 'taxonomy' == $type )
        search_custom_taxonomy( $wp_type );
    die();
}

function search_custom_post( $wp_type ) {

    // Search in title
    add_filter( 'posts_where', 'chosen_search_where', 1, 2 );

    // Make WP_Query
    $args = array(
        'post_type' => explode( ',', $wp_type ),
        'orderby' => 'title',
        'order' => 'ASC',
        'post_status' => array( 'publish', 'private' ),
        'posts_per_page' => -1
    );
    $the_query = new WP_Query( $args );

    // Loop
    $data = array();
    while ( $the_query->have_posts() ):
        $the_query->the_post();
        $data[] = array( 'value' => get_the_ID(), 'text' => get_the_title() );
    endwhile;

    echo json_encode( $data );
}

/**
 * Create where query to search in post title
 */
function chosen_search_where( $where, &$wp_query ) {
    remove_filter( 'posts_where', 'chosen_search_where', 1, 2 );

    global $wpdb;
    if ( $term = $_REQUEST['term'] ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape
            ( $term ) ) . '%\'';
    }
    return $where;
}

function search_custom_taxonomy( $wp_type ) {

}

/**
 * Get Google WebFonts
 */
function wp_ajax_spyropress_get_google_webfonts() {

    // Getting from cache
    if( $fonts = get_transient( '_spyropress_google_webfonts' ) ) {
        echo $fonts;
    }
    // Getting Fonts
    else {
        $key = 'AIzaSyDJYYVPLT9JaoMPF8G5cFm1YjTZMjknizE';
        $url = sprintf( 'https://www.googleapis.com/webfonts/v1/webfonts?key=%1$s&sort=alpha', $key );
        $response = wp_remote_get( $url, array( 'sslverify' => false ) );
        $fonts = wp_remote_retrieve_body( $response );

        if( !empty( $fonts ) ) {
            $fonts = json_decode( $fonts );
            $fonts = json_encode( $fonts->items );

            // saving to cache
            set_transient( '_spyropress_google_webfonts', $fonts, spyropress_get_seconds() );

            echo $fonts;
        }
        else {
            echo '-1';
        }
    }

    // Exit
    die();
}
/** Frontend AJAX events **************************************************/
add_action( 'wp_ajax_spyropress_twitter_tweets', 'spyropress_twitter_tweets' );
add_action( 'wp_ajax_nopriv_spyropress_twitter_tweets', 'spyropress_twitter_tweets' );
function spyropress_twitter_tweets() {

    $defaults = array(
        'lang' => substr( strtoupper( get_locale() ), 0, 2 ),
        'post_count' => isset( $_GET['notweets'] ) ? $_GET['notweets'] : 10,
        'username' => isset( $_GET['twitteruser'] ) ? $_GET['twitteruser'] : get_setting( 'twitter_username' ),
        'key' => '_spyropress_footer_tweets_',
        'consumer_key' => get_setting( 'twitter_consumer_key' ),
        'consumer_secret' => get_setting( 'twitter_consumer_secret' ),
        'access_token' => get_setting( 'twitter_access_token' ),
        'access_token_secret' => get_setting( 'twitter_access_token_secret' )
    );
    extract( $defaults );

    if( ! $consumer_key || ! $consumer_secret || ! $access_token || ! $access_token_secret ) {
        _e( 'No oAuth setting provided.', 'spyropress' );
        exit;
    }

    $tweets = array();
    if( false === ( $tweets = get_transient( $key . $username ) ) ) {

        require_once 'utilities/twitteroauth/twitteroauth.php';
        $twitterConnection = new TwitterOAuth( $consumer_key, $consumer_secret, $access_token, $access_token_secret );
    	$tweets = $twitterConnection->get(
    			  'statuses/user_timeline',
    			  array(
    			    'screen_name'     => $username,
    			    'count'           => $post_count
    			  )
    	);

    	if($twitterConnection->http_code != 200) {
    		$tweets = get_transient( $key . $username );
    	}

        // Cache
        set_transient( $key . $username, $tweets, spyropress_get_seconds( 0.1 ) );
    }

    echo json_encode( $tweets );
    exit;
}
?>