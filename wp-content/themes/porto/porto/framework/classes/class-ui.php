<?php

/**
 * SpyroPress UI
 * UI class from which all ui classes extends.
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

class SpyropressUi {

    private $id;
    private $options;
    private $settings;
    private $build_tabs;

    private $tabs;
    private $is_widget;

    /**
     * Constrctor
     */
    function __construct( $options, $id, $settings, $build_tabs = true ) {

        $this->id = $id;
        $this->options = $options;
        $this->settings = $settings;
        $this->build_tabs = $build_tabs;
    }

    /**
     * Build navigation from heading type
     */
    function build_nav() {

        foreach ( $this->options as $option ) {

            if ( isset( $option[0] ) ) {
                $tab = $option[0];

                if ( 'heading' == $tab['type'] ) $this->tabs[] = $tab;

                if ( 'separator' == $tab['type'] ) $this->tabs[] = $tab;
            }
        }

        $nav = '';
        foreach ( $this->tabs as $tab ) {

            // separator
            if ( 'separator' == $tab['type'] ) $nav .=
                    '<li class="separator"><div></div></li>';
            // heading
            else {
                // tab-icon
                $icon = '<span class="module-icon-options"></span>';
                if ( isset( $tab['icon'] ) && '' != $tab['icon'] )
                    $icon = '<span class="' . $tab['icon'] . '"></span>';

                // if tab-selected
                $selected = ( isset( $tab['selected'] ) ) ? 'class="selected" ' : '';

                // if tab-class
                $tab_class = ( isset( $tab['class'] ) ) ? ' ' . ltrim( $tab['class'] ) : '';

                $nav .= sprintf(
                    '<li class="panel-%2$s%5$s"><a %4$stitle="%1$s" href="#panel-%2$s">%3$s%1$s</a></li>',
                    $tab['label'], $tab['slug'], $icon, $selected, $tab_class
                );
            }
        }

        return $nav;
    }

    /**
     * Build Content from items
     */
    function build_content() {

        foreach ( $this->options as $group ) {

            $tab = $group[0];
            unset( $group[0] );

            if ( isset( $tab['slug'] ) ) {
                $tab_slug = $tab['slug'];

                echo '<div id="panel-' . $tab_slug . '" class="group">';
                $this->build_group( $group );
                echo '</div><!-- panel-' . $tab_slug . ' -->';
            }
        }
    }

    /**
     * Build Group of Items
     *
     * Common Item Properties
     * id = A unique lower case alphanumeric string, underscores allowed.
     * label = Displayed as the label of a form element on the Theme Options page.
     * type = Choose one of the available option types.
     * desc = Enter a detailed description for the users to read on the Theme Options page, HTML is allowed.
     * This is also where you enter content for both the Info & Raw Info option types.
     * std = Setting the standard value for your option.
     * class = Add and optional class to this option type.
     *
     * Text, Textarea, Editor, CSS
     * placeholder = display placeholer HTML5 attribute

     * Textarea, Editor, CSS
     * rows = Enter a numeric value for the number of rows in your textarea.
     *
     * Custom Post Type Select
     * post_type = Add a comma separated list of post type like 'post,page'.
     *
     * Taxonomy Select
     * taxonomy = Add a comma separated list of any registered taxonomy like 'category,post_tag'.
     *
     */
    function build_group( $group ) {

        // Loop through group
        foreach ( $group as $section ) {

            // Defaults
            $defaults = array(
                'id' => '',
                'label' => '',
                'type' => 'text',
                'desc' => '',
                'std' => '',
                'class' => '',

                'placeholder' => '',
                'rows' => '15',
                'post_type' => 'post',
                'taxonomy' => 'category',
                'options' => array()
            );
            $section = wp_parse_args( $section, $defaults );

            // id
            $id = $section['id'];
            // name
            if ( ! isset( $section['name'] ) )
                $section['name'] = $id;

            // set to default
            if ( ! isset( $this->settings[$id] ) && isset( $section['std'] ) && !empty( $section['std'] ) && !empty( $id ) ) {
                $this->settings[$id] = $section['std'];
            }

            // value
            $value =  ( isset( $this->settings[$id] ) && !empty( $this->settings[$id] ) ) ? $this->settings[$id] : '';

            // Prefix method
            $field_method = 'spyropress_ui_' . $section['type'];

            // Run method
            if ( function_exists( $field_method ) ) {

                if ( isset( $this->settings['post'] ) && isset( $section['desc'] ) &&
                    is_str_contain( '{$post->ID}', $section['desc'] ) )
                        $section['post'] = $this->settings['post'];

                // Import Type
                if ( $section['type'] == 'import_dummy' || $section['type'] == 'import' || $section['type'] == 'export' || $section['type'] == 'skin_generator' ) {
                    call_user_func_array( $field_method, array( $this->id ) );
                }
                else {
                    call_user_func_array( $field_method, array(
                        $section,
                        $id,
                        $value )
                    );
                }
            }
        }
    }

    /**
     * Get Id of UI
     */
    function get_id() {
        return $this->id;
    }

    /**
     * Build tab
     */
    function is_build_tabs() {
        return $this->build_tabs;
    }

} // Class_SpyropressUi
?>