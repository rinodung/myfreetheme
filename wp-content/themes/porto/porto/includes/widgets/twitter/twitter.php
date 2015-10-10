<?php

/**
 * Twitter Widget
 * Display an official Twitter Embedded Timeline widget.
 *     
 * @package		SpyroPress
 * @category	Widgets
 * @author		SpyroSol
 */

class SpyroPress_Widget_Twitter extends SpyropressWidget {

    private $_api_url = 'https://api.twitter.com/1/';

    /**
     * Constructor
     */
    function __construct() {

        // Widget variable settings.
        $this->id_base = 'spyropress_twitter';
        $this->name = __( 'Spyropress: Twitter', 'spyropress' );
        $this->description = __( 'Display latest tweets from Twitter', 'spyropress' );

        $this->fields = array(

            array(
                'label' => __( 'Title', 'spyropress' ),
                'id' => 'title',
                'type' => 'text',
                'std' => 'My Tweets'
            ),
            
            array(
                'label' => __( 'Username', 'spyropress' ),
                'id' => 'username',
                'type' => 'text'
            ),
            
            array(
                'label' => __( 'Post Count', 'spyropress' ),
                'id' => 'post_count',
                'type' => 'range_slider',
                'max' => 20,
                'std' => 5
            )
        );

        $this->create_widget();
        
        if ( is_active_widget( false, false, $this->id_base ) || is_active_widget( false, false, 'monster' ) ) {
			wp_enqueue_script( 'twitter-widgets', '//platform.twitter.com/widgets.js', '', '', true );
		}
    }
    
    function update( $new, $old ) {

        // delete cache
        delete_site_transient( '_spyropress_list_tweets' );

        return parent::update( $new, $old );
    }
    
    function widget( $args, $instance ) {
        
        $defaults = array(
            'post_count' => 10,
            'username' => ''
        );
        $instance = wp_parse_args( $instance, $defaults );
        extract( $args ); extract( $instance );
        
        include $this->get_view();
    }
    
    /**
	 * Find links and create the hyperlinks
	 */
	private function hyperlinks($text) {
	    $text = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\">$1</a>", $text);
	    $text = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $text);
	    // match name@address
	    $text = preg_replace("/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i","<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $text);
	        //mach #trendingtopics. Props to Michael Voigt
	    $text = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ", $text);
	    return $text;
	}
	/**
	 * Find twitter usernames and link to them
	 */
	private function twitter_users($text) {
	       $text = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\">@$2</a>$3 ", $text);
	       return $text;
	}
    
    /**
     * Encode single quotes in your tweets
     */
    private function encode_tweet($text) {
            $text = mb_convert_encoding( $text, "HTML-ENTITIES", "UTF-8");
            return $text;
    }
    
} // class SpyroPress_Widget_Twitter

register_widget( 'SpyroPress_Widget_Twitter' );