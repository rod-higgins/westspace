<?php
/**
 * Custom Navigation Walker for Westpace Material Theme
 * Enhanced navigation with Material Design elements
 * 
 * @package Westpace_Material
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Custom walker class for enhanced navigation menus
 */
class Westpace_Walker_Nav_Menu extends Walker_Nav_Menu {

    private $current_item;

    /**
     * Starts the list before the elements are added.
     */
    public function start_lvl(&$output, $depth = 0, $args = null) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = str_repeat($t, $depth);

        // Default dropdown classes
        $classes = array('dropdown-menu');
        
        // Add depth-specific classes
        if ($depth === 0) {
            $classes[] = 'dropdown-menu-level-1';
        } else {
            $classes[] = 'dropdown-menu-level-' . ($depth + 1);
        }
        
        // Add alignment class
        $classes[] = $this->get_dropdown_alignment_class();
        
        $class_names = join(' ', apply_filters('nav_menu_submenu_css_class', $classes, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= "{$n}{$indent}<ul{$class_names}>{$n}";
    }

    /**
     * Ends the list after the elements are added.
     */
    public function end_lvl(&$output, $depth = 0, $args = null) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = str_repeat($t, $depth);
        $output .= "$indent</ul>{$n}";
    }

    /**
     * Starts the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = ($depth) ? str_repeat($t, $depth) : '';

        $this->current_item = $item;

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Add special classes
        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'active';
        }

        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'dropdown';
            $classes[] = 'has-dropdown';
        }

        // Add depth-specific classes
        $classes[] = 'menu-item-depth-' . $depth;

        // Add Material Design classes
        $classes[] = 'material-nav-item';

        /**
         * Filters the CSS classes applied to a menu item's list item element.
         */
        $classes = apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth);
        $class_names = join(' ', $classes);
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        /**
         * Filters the ID applied to a menu item's list item element.
         */
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) .'"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) .'"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) .'"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) .'"' : '';

        // Add Material Design attributes
        $link_classes = array('nav-link');
        
        if ($depth === 0) {
            $link_classes[] = 'nav-link-primary';
        } else {
            $link_classes[] = 'nav-link-secondary';
        }

        if (in_array('current-menu-item', $classes)) {
            $link_classes[] = 'active';
        }

        if (in_array('menu-item-has-children', $classes)) {
            $link_classes[] = 'dropdown-toggle';
            $attributes .= ' data-toggle="dropdown"';
            $attributes .= ' aria-haspopup="true"';
            $attributes .= ' aria-expanded="false"';
        }

        $link_class_names = join(' ', $link_classes);
        $attributes .= ' class="' . esc_attr($link_class_names) . '"';

        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes .'>';

        // Add icon if specified in description
        $icon = $this->parse_icon_from_description($item->description);
        if ($icon) {
            $item_output .= '<span class="material-icons nav-icon">' . esc_html($icon) . '</span>';
        }

        $item_output .= isset($args->link_before) ? $args->link_before : '';
        
        // Add the menu item title
        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
        $item_output .= '<span class="nav-text">' . $title . '</span>';

        $item_output .= isset($args->link_after) ? $args->link_after : '';

        // Add dropdown arrow for parent items
        if (in_array('menu-item-has-children', $classes)) {
            $item_output .= '<span class="dropdown-arrow material-icons">keyboard_arrow_down</span>';
        }

        // Add badge if specified in description
        $badge = $this->parse_badge_from_description($item->description);
        if ($badge) {
            $item_output .= '<span class="nav-badge">' . esc_html($badge) . '</span>';
        }
        
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';
        
        /**
         * Filters a menu item's starting output.
         */
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    /**
     * Ends the element output.
     */
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $output .= "</li>{$n}";
    }
    
    /**
     * Parse icon from menu item description
     */
    private function parse_icon_from_description($description) {
        if (empty($description)) {
            return false;
        }
        
        // Look for [icon:icon_name] syntax
        if (preg_match('/\[icon:([^\]]+)\]/', $description, $matches)) {
            return sanitize_text_field($matches[1]);
        }
        
        return false;
    }
    
    /**
     * Parse badge from menu item description
     */
    private function parse_badge_from_description($description) {
        if (empty($description)) {
            return false;
        }
        
        // Look for [badge:badge_text] syntax
        if (preg_match('/\[badge:([^\]]+)\]/', $description, $matches)) {
            return sanitize_text_field($matches[1]);
        }
        
        return false;
    }
    
    /**
     * Get dropdown alignment class based on menu position
     */
    private function get_dropdown_alignment_class() {
        if (!$this->current_item) {
            return 'dropdown-left';
        }
        
        // Simple logic: if it's one of the last few items, align right
        // In a real implementation, you might want to check the actual position
        $menu_order = $this->current_item->menu_order;
        
        // For now, return left alignment for all dropdowns
        // This can be enhanced with JavaScript for dynamic positioning
        return 'dropdown-left';
    }
}

/**
 * Fallback function for menus
 */
function westpace_fallback_menu($args) {
    if (!current_user_can('edit_theme_options')) {
        return;
    }
    
    $fallback_output = '';
    
    if ($args['container']) {
        $fallback_output .= '<' . $args['container'];
        if ($args['container_id']) {
            $fallback_output .= ' id="' . esc_attr($args['container_id']) . '"';
        }
        if ($args['container_class']) {
            $fallback_output .= ' class="' . esc_attr($args['container_class']) . '"';
        }
        $fallback_output .= '>';
    }
    
    $fallback_output .= '<ul';
    if ($args['menu_id']) {
        $fallback_output .= ' id="' . esc_attr($args['menu_id']) . '"';
    }
    if ($args['menu_class']) {
        $fallback_output .= ' class="' . esc_attr($args['menu_class']) . '"';
    }
    $fallback_output .= '>';
    
    $fallback_output .= '<li class="menu-item menu-item-fallback">';
    $fallback_output .= '<a href="' . esc_url(admin_url('nav-menus.php')) . '" class="nav-link">';
    $fallback_output .= '<span class="material-icons nav-icon">add</span>';
    $fallback_output .= '<span class="nav-text">' . __('Add Menu', 'westpace-material') . '</span>';
    $fallback_output .= '</a>';
    $fallback_output .= '</li>';
    
    $fallback_output .= '</ul>';
    
    if ($args['container']) {
        $fallback_output .= '</' . $args['container'] . '>';
    }
    
    echo $fallback_output;
}

/**
 * Enhanced Mobile Navigation Walker
 */
class Westpace_Walker_Mobile_Nav_Menu extends Walker_Nav_Menu {

    /**
     * Starts the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = ($depth) ? str_repeat($t, $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'mobile-menu-item-' . $item->ID;
        $classes[] = 'mobile-menu-item';

        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'active';
        }

        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'has-children';
        }

        $classes[] = 'mobile-menu-item-depth-' . $depth;

        $classes = apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth);
        $class_names = join(' ', $classes);
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'mobile-menu-item-' . $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) .'"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) .'"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) .'"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) .'"' : '';
        $attributes .= ' class="mobile-nav-link"';

        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes .'>';

        // Add icon for mobile
        $icon = $this->parse_icon_from_description($item->description);
        if ($icon) {
            $item_output .= '<span class="material-icons mobile-nav-icon">' . esc_html($icon) . '</span>';
        }

        $item_output .= isset($args->link_before) ? $args->link_before : '';
        
        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
        $item_output .= '<span class="mobile-nav-text">' . $title . '</span>';

        $item_output .= isset($args->link_after) ? $args->link_after : '';

        // Add toggle for parent items
        if (in_array('menu-item-has-children', $classes)) {
            $item_output .= '<button type="button" class="mobile-submenu-toggle" aria-expanded="false">';
            $item_output .= '<span class="material-icons">keyboard_arrow_down</span>';
            $item_output .= '</button>';
        }
        
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * Parse icon from menu item description (same as main walker)
     */
    private function parse_icon_from_description($description) {
        if (empty($description)) {
            return false;
        }
        
        if (preg_match('/\[icon:([^\]]+)\]/', $description, $matches)) {
            return sanitize_text_field($matches[1]);
        }
        
        return false;
    }

    /**
     * Starts the list before the elements are added (mobile specific)
     */
    public function start_lvl(&$output, $depth = 0, $args = null) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = str_repeat($t, $depth);

        $classes = array('mobile-submenu');
        $classes[] = 'mobile-submenu-level-' . ($depth + 1);
        
        $class_names = join(' ', $classes);
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= "{$n}{$indent}<ul{$class_names}>{$n}";
    }
}

/**
 * Social Menu Walker
 */
class Westpace_Walker_Social_Menu extends Walker_Nav_Menu {

    /**
     * Starts the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'social-menu-item';

        // Detect social network from URL
        $social_network = $this->detect_social_network($item->url);
        if ($social_network) {
            $classes[] = 'social-' . $social_network;
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'social-menu-item-' . $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) .'"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) .'"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) .'"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) .'"' : '';
        $attributes .= ' class="social-link"';

        $item_output = '<a' . $attributes .'>';

        // Add social icon
        $icon = $this->get_social_icon($social_network);
        if ($icon) {
            $item_output .= '<span class="social-icon">' . $icon . '</span>';
        }

        // Add screen reader text
        $title = apply_filters('the_title', $item->title, $item->ID);
        $item_output .= '<span class="screen-reader-text">' . esc_html($title) . '</span>';
        
        $item_output .= '</a>';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * Detect social network from URL
     */
    private function detect_social_network($url) {
        $networks = array(
            'facebook.com' => 'facebook',
            'twitter.com' => 'twitter',
            'instagram.com' => 'instagram',
            'linkedin.com' => 'linkedin',
            'youtube.com' => 'youtube',
            'pinterest.com' => 'pinterest',
            'github.com' => 'github',
            'dribbble.com' => 'dribbble',
            'behance.net' => 'behance',
        );

        foreach ($networks as $domain => $network) {
            if (strpos($url, $domain) !== false) {
                return $network;
            }
        }

        return false;
    }

    /**
     * Get social icon HTML
     */
    private function get_social_icon($network) {
        $icons = array(
            'facebook' => '<svg viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
            'twitter' => '<svg viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
            'instagram' => '<svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
            'linkedin' => '<svg viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
            'youtube' => '<svg viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
            'pinterest' => '<svg viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.097.118.112.221.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.748-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24c6.624 0 11.99-5.367 11.99-11.013C24.007 5.367 18.641.001 12.017.001z"/></svg>',
            'github' => '<svg viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>',
        );

        return isset($icons[$network]) ? $icons[$network] : '';
    }
}
?>