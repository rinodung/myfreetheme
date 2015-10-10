<?php

/**
 * String and Numbers Helper Functions
 *
 * @author SpyroSol
 * @category Utilities
 * @package Spyropress
 *
 */

/**
 * Get seconds from days
 */
function spyropress_get_seconds( $days = 1 ) {
    return $days * 60 * 60 * 24;
}

/**
 * Helper function to return encoded strings
 */
function spyropress_encode( $value ) {

    return base64_encode( serialize( $value ) );

}

/**
 * Helper function to return decoded strings
 */
function spyropress_decode( $value ) {

    return unserialize( base64_decode( $value ) );

}

/**
 * Beautify String
 */
function spyropress_beautify( $str ) {
    return ucwords( str_replace( '_', ' ', $str ) );
}

/**
 * Uglify String
 */
function spyropress_uglify( $str ) {
    $blanks = array( ':', '&', ';', '#' );
    $underscores = array( ' ', '.', '/' );
    $str = strtolower( str_replace( $blanks, '', str_replace( $underscores, '_', $str ) ) );
    return $str;
}

/**
 * Uglify CssClass
 */
function spyropress_uglify_cssclass( $str ) {
    return str_replace( ':', '', str_replace( ' ', '.', $str ) );
}

/**
 * Pluralize String
 */
function spyropress_pluralize( $str ) {

    // Key
    $key = '_spyropress_pluralize_' . $str;
    
    // Getting from cache
    if( $plural = get_transient( $key ) ) return $plural;
    
    $plural_patterns = array(
        '/(s)tatus$/i' => '\1\2tatuses',
        '/(quiz)$/i' => '\1zes',
        '/^(ox)$/i' => '\1\2en',
        '/([m|l])ouse$/i' => '\1ice',
        '/(matr|vert|ind)(ix|ex)$/i' => '\1ices',
        '/(x|ch|ss|sh)$/i' => '\1es',
        '/([^aeiouy]|qu)y$/i' => '\1ies',
        '/(hive)$/i' => '\1s',
        '/(?:([^f])fe|([lr])f)$/i' => '\1\2ves',
        '/sis$/i' => 'ses',
        '/([ti])um$/i' => '\1a',
        '/(p)erson$/i' => '\1eople',
        '/(m)an$/i' => '\1en',
        '/(c)hild$/i' => '\1hildren',
        '/(buffal|tomat)o$/i' => '\1\2oes',
        '/(alumn|bacill|cact|foc|fung|nucle|radi|stimul|octop|syllab|termin|vir)us$/i' => '\1i',
        '/us$/i' => 'uses',
        '/(alias)$/i' => '\1es',
        '/(ax|cris|test)is$/i' => '\1es',
        '/s$/' => 's',
        '/^$/' => '',
        '/$/' => 's'
    );

    $irregular = array(
        'atlas' => 'atlases',
        'beef' => 'beefs',
        'brother' => 'brothers',
        'cafe' => 'cafes',
        'child' => 'children',
        'cookie' => 'cookies',
        'corpus' => 'corpuses',
        'cow' => 'cows',
        'ganglion' => 'ganglions',
        'genie' => 'genies',
        'genus' => 'genera',
        'graffito' => 'graffiti',
        'hoof' => 'hoofs',
        'loaf' => 'loaves',
        'man' => 'men',
        'money' => 'monies',
        'mongoose' => 'mongooses',
        'move' => 'moves',
        'mythos' => 'mythoi',
        'niche' => 'niches',
        'numen' => 'numina',
        'occiput' => 'occiputs',
        'octopus' => 'octopuses',
        'opus' => 'opuses',
        'ox' => 'oxen',
        'penis' => 'penises',
        'person' => 'people',
        'sex' => 'sexes',
        'soliloquy' => 'soliloquies',
        'testis' => 'testes',
        'trilby' => 'trilbys',
        'turf' => 'turfs'
    );

    $uncountable = array(
        'equipment',
        'fish',
        'information',
        'money',
        'rice',
        'series',
        'sheep',
        'species'
    );

    $plural = '';
    $lowercase_str = strtolower( $str );

    // save some time in the case that singular and plural are the same
    if ( in_array( $lowercase_str, $uncountable ) )
        $plural = $str;

    // check for irregular singular forms
    if ( array_key_exists( $lowercase_str, $irregular ) )
        $plural = $irregular[ $lowercase_str ];

    // check for matches using regular expressions
    foreach ( $plural_patterns as $pattern => $replace ) {
        if ( preg_match( $pattern, $str ) ) {
            $plural = preg_replace( $pattern, $replace, $str );
            break;
        }
    }
    
    // save to cache
    set_transient( $key, $plural, spyropress_get_seconds( 10 ) );

    return $plural;
}
/** Conditional String Functions ****************************************************/

/**
 * Check input contains string
 */
function is_str_contain( $search, $in ) {
    // if in string
    if ( strpos( $in, $search ) !== false )
        return true;
    // if not in string
    return false;
}

/**
 * Checks whether string begins with given string.
 */
function is_str_starts_with( $search, $string ) {
    return ( strncmp( $string, $search, strlen( $search ) ) == 0 );
}

function icon_comp( $icon ) {
    return str_replace( 'icon-', 'fa-', $icon );
}