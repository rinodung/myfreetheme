<?php

/**
 * class Bootstrap_Walker_Nav_Menu()
 * Extending Walker_Nav_Menu to modify class assigned to submenu ul element
 */
class Bootstrapwp_Walker_Nav_Menu extends Walker_Nav_Menu {

    private $has_megamenu = false;
    private $columns = 0;
    private $is_column = false;
    
    /**
     * @see Walker::start_el()
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        if( 0 === $depth ) {
            $this->has_megamenu = $item->isMega;
            $this->columns = $item->mega_columns;
        }
        if( 1 === $depth ) {
            $this->is_column = $item->is_mega_column;
        }

        if( 'phone' == $item->title ) {

            $output .= $indent .  '<li class="phone"><span><i class="fa fa-phone"></i>' . get_setting( 'topbar_ph' ) . '</span>';
        }
        elseif( is_str_contain( 'divider', $item->title ) ) {
            $output .= $indent . '<li class="divider">';
        }
        elseif( '[sigin-form]' == $item->attr_title ) {

            ob_start();
            $templates = array( 'woocommerce/nav-signin-form.php' );
            include_once locate_template( $templates, false );
            $nav_output = ob_get_clean();

            $output .= $nav_output;
        }
        elseif( '[mini-cart]' == $item->attr_title ) {
            
            //check cart empty
            if( sizeof( WC()->cart->get_cart() ) < 1 && get_setting( 'mini_cart_hide_if_empty', false ) )
                return;
            
            ob_start();
            $templates = array( 'woocommerce/nav-mini-cart.php' );
            include_once locate_template( $templates, false );
            $nav_output = ob_get_clean();

            $output .= $nav_output;
        }
        else {
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $classes = apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args );

            if( ( $item->current && 'secondary' != $args->theme_location ) || in_array( 'current-menu-parent', $classes ) || in_array( 'current-menu-ancestor', $classes ) )
                $classes[] = 'active';

            
            if( $item->isMega || $item->bucket_id ) {
                $classes[] = 'mega-menu-item mega-menu-fullwidth';
            }
            if( $item->bucket_id ) {
                $classes[] = 'dropdown';
            }

            if ( $this->has_children && $depth > 0 ) {
                $classes[] = 'dropdown-submenu';
            } else if ( $this->has_children && $depth === 0 ) {
                $classes[] = 'dropdown';
            }

            $class_names = spyropress_clean_cssclass( $classes );
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

            if( $depth === 1 && $this->has_megamenu ) {
                $output .= $indent . '<div class="{col_class}"><ul class="sub-menu"><li>';
            }
            elseif( $depth === 2 && $this->has_megamenu && $this->is_column ) {
                
            }
            else {
                $output .= $indent . '<li' . $class_names . '>';
            }

            $item_output = '';
            if( $depth === 1 && $this->has_megamenu && $this->is_column ) {
                // do nothing
            }
            elseif( ( $depth === 1 && $this->has_megamenu ) || ( $depth === 2 && $this->has_megamenu && $this->is_column ) ) {
                $item_output .= '<span class="mega-menu-sub-title">' . apply_filters( 'the_title', $item->title, $item->ID ) . '</span>';
            }
            else {
                $atts = array();
        		$atts['title']  = ! empty( $item->attr_title ) ? esc_attr( $item->attr_title ) : '';
        		$atts['target'] = ! empty( $item->target )     ? esc_attr( $item->target )     : '';
        		$atts['rel']    = ! empty( $item->xfn )        ? esc_attr( $item->xfn )        : '';
        		$atts['href']   = ! empty( $item->url )        ? esc_url( $item->url )        : '';
    
                if( ( $this->has_children && $depth == 0 ) || $item->bucket_id ) {
                    $atts['class'] = 'dropdown-toggle';
                }
    
                $attributes = apply_filters( 'nav_menu_link_attributes', spyropress_build_atts( $atts ), $item, $args );
    
                if( is_str_contain( '#HOME_URL#', $item->url ) )
                    $attributes .= ' data-hash';
                
                $item_output = $args->before;
                    $item_output .= '<a' . $attributes . '>';
    
                        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
    
                        if( $this->has_children && $depth == 0 ) $item_output .= ' <i class="fa fa-angle-down"></i>';
    
                    $item_output .= '</a>';
                $item_output .= $args->after;
            }

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            
            if( $item->bucket_id ) {
                $output .= '<ul class="dropdown-menu"><li><div class="mega-menu-content">';
                    
                    $con = do_shortcode( '[bucket id=' . $item->bucket_id . ']' );
                    $output .= str_replace( 'class="container"', '', $con );
                
                $output .= '</div></li></ul>';
            }
        }
    }
    
   	/**
	 * @see Walker::end_el()
	 */
    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		
        if( $depth === 2 && $this->has_megamenu && $this->is_column ) {
            // do nothing
        }
        else {
            $output .= "</li>\n";
        }
        
        if( $depth === 1 && $this->has_megamenu ) {
            $output .= "</ul></div>\n";
        }
	}
    
    /**
	 * @see Walker::start_lvl()
	 */  
    function start_lvl( &$output, $depth = 0, $args = array() ) {

        $indent = str_repeat("\t", $depth);
        
        if( $depth === 1 && $this->has_megamenu && $this->is_column ) {
            // do nothing
        }
        elseif( 0 === $depth && $this->has_megamenu ) {
            $output .= '<ul class="dropdown-menu"><li><div class="mega-menu-content"><div class="row">';
        }
        else {
            $css = $this->has_megamenu ? 'sub-menu' : 'dropdown-menu';
            $output .= "\n$indent<ul class=\"$css\">\n";
        }
    }

    /**
	 * @see Walker::end_lvl()
	 */
    function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
        
        if( $depth === 1 && $this->has_megamenu && $this->is_column ) {
            // do nothing
        }
        elseif( 0 === $depth && $this->has_megamenu ) {
            
            $col_class = ( $this->columns > 4 ) ? get_column_class( 6 ) : get_column_class( $this->columns );
            
            $output = str_replace( '{col_class}', $col_class, $output );
            
            $output .= '</div></div></li></ul>';
        }
        else {
            $output .= "$indent</ul>\n";
        }
	}
}