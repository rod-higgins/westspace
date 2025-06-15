<?php
/**
 * Enhanced Custom Navigation Walker for Westpace Material Theme
 * Modern, accessible navigation with Material Design principles
 */

class Westpace_Walker_Nav_Menu extends Walker_Nav_Menu {
    
    private $current_item;
    private $dropdown_menu_alignment_class;
    
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
        
        // Determine alignment class for dropdown
        $alignment_class = $this->get_dropdown_alignment_class();
        
        $output .= "{$n}{$indent}<ul class=\"sub-menu dropdown-menu elevation-3 {$alignment_class}\">{$n}";
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
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        // Store current item for dropdown alignment
        $this->current_item = $item;
        
        // Add dropdown toggle class for parent items
        $has_children = in_array('menu-item-has-children', $classes);
        if ($has_children) {
            $classes[] = 'has-dropdown';
        }
        
        // Add current item classes
        if (in_array('current-menu-item', $classes) || in_array('current_page_item', $classes)) {
            $classes[] = 'is-active';
        }
        
        // Add depth class
        $classes[] = 'menu-item-depth-' . $depth;
        
        /**
         * Filters the arguments for a single nav menu item.
         */
        $args = apply_filters('nav_menu_item_args', $args, $item, $depth);
        
        /**
         * Filters the CSS class(es) applied to a menu item's list item element.
         */
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        /**
         * Filters the ID applied to a menu item's list item element.
         */
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names .'>';
        
        // Build the link attributes
        $attributes = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target) .'"' : '';
        $attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) .'"' : '';
        $attributes .= !empty($item->url)        ? ' href="'   . esc_attr($item->url) .'"' : '';
        
        // Build the link classes
        $link_classes = array('nav-link');
        
        if ($depth === 0) {
            $link_classes[] = 'nav-link-primary';
        } else {
            $link_classes[] = 'nav-link-secondary';
        }
        
        if ($has_children) {
            $link_classes[] = 'has-dropdown-toggle';
            $attributes .= ' aria-haspopup="true"';
            $attributes .= ' aria-expanded="false"';
        }
        
        // Add Material Design ripple effect
        $link_classes[] = 'material-ripple';
        
        $link_class_attr = ' class="' . esc_attr(implode(' ', $link_classes)) . '"';
        
        // Get menu item content
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes . $link_class_attr . '>';
        
        // Add icon if specified in menu item description
        if (!empty($item->description) && $depth === 0) {
            $icon = $this->parse_icon_from_description($item->description);
            if ($icon) {
                $item_output .= '<span class="nav-icon material-icons">' . esc_attr($icon) . '</span>';
            }
        }
        
        // Add link text with proper formatting
        $link_text = isset($args->link_before) ? $args->link_before : '';
        $link_text .= apply_filters('the_title', $item->title, $item->ID);
        $link_text .= isset($args->link_after) ? $args->link_after : '';
        
        $item_output .= '<span class="nav-text">' . $link_text . '</span>';
        
        // Add dropdown arrow for parent items
        if ($has_children) {
            $arrow_icon = $depth === 0 ? 'expand_more' : 'chevron_right';
            $item_output .= '<span class="dropdown-arrow material-icons" aria-hidden="true">' . $arrow_icon . '</span>';
        }
        
        // Add badge if specified in menu description
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
        $fallback_output .= ' class="' . esc_attr($args['menu_class']) . ' fallback-menu"';
    }
    $fallback_output .= '>';
    
    // Add default menu items
    $fallback_output .= '<li class="menu-item"><a href="' . esc_url(home_url('/')) . '" class="nav-link">' . __('Home', 'westpace-material') . '</a></li>';
    
    if (class_exists('WooCommerce')) {
        $fallback_output .= '<li class="menu-item"><a href="' . esc_url(wc_get_page_permalink('shop')) . '" class="nav-link">' . __('Shop', 'westpace-material') . '</a></li>';
    }
    
    // Add pages
    $pages = get_pages(array('sort_column' => 'menu_order', 'number' => 5));
    foreach ($pages as $page) {
        if ($page->post_title !== 'Home') {
            $fallback_output .= '<li class="menu-item"><a href="' . esc_url(get_permalink($page->ID)) . '" class="nav-link">' . esc_html($page->post_title) . '</a></li>';
        }
    }
    
    $fallback_output .= '<li class="menu-item menu-item-edit"><a href="' . esc_url(admin_url('nav-menus.php')) . '" class="nav-link"><span class="material-icons">edit</span> ' . __('Add Menu', 'westpace-material') . '</a></li>';
    
    $fallback_output .= '</ul>';
    
    if ($args['container']) {
        $fallback_output .= '</' . $args['container'] . '>';
    }
    
    echo $fallback_output;
}

/**
 * Mobile Navigation Walker
 * Simplified walker for mobile menu
 */
class Westpace_Mobile_Walker_Nav_Menu extends Walker_Nav_Menu {
    
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"mobile-sub-menu\">\n";
    }
    
    public function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
    
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'mobile-menu-item-' . $item->ID;
        
        $has_children = in_array('menu-item-has-children', $classes);
        if ($has_children) {
            $classes[] = 'has-children';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'mobile-menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names .'>';
        
        $attributes = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= !empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';
        
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes . ' class="mobile-nav-link">';
        
        // Add icon if specified
        $icon = $this->parse_icon_from_description($item->description);
        if ($icon) {
            $item_output .= '<span class="mobile-nav-icon material-icons">' . esc_attr($icon) . '</span>';
        }
        
        $item_output .= '<span class="mobile-nav-text">';
        $item_output .= isset($args->link_before) ? $args->link_before : '';
        $item_output .= apply_filters('the_title', $item->title, $item->ID);
        $item_output .= isset($args->link_after) ? $args->link_after : '';
        $item_output .= '</span>';
        
        if ($has_children) {
            $item_output .= '<span class="mobile-dropdown-toggle material-icons">expand_more</span>';
        }
        
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
    
    private function parse_icon_from_description($description) {
        if (empty($description)) {
            return false;
        }
        
        if (preg_match('/\[icon:([^\]]+)\]/', $description, $matches)) {
            return sanitize_text_field($matches[1]);
        }
        
        return false;
    }
}

/**
 * Enhanced navigation CSS for the walker
 */
function westpace_walker_nav_css() {
    ?>
    <style>
    /* Enhanced Navigation Styles */
    .nav-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        color: var(--text-primary);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
        border-radius: 0.75rem;
        transition: all var(--transition-fast);
        position: relative;
        overflow: hidden;
    }
    
    .nav-link:hover,
    .nav-link:focus {
        background: var(--primary-50, rgba(25, 118, 210, 0.05));
        color: var(--primary-600);
        transform: translateY(-1px);
    }
    
    .nav-link.is-active,
    .current-menu-item .nav-link {
        background: var(--primary-100, rgba(25, 118, 210, 0.1));
        color: var(--primary-600);
        font-weight: 600;
    }
    
    .nav-icon {
        font-size: 1.125rem;
        opacity: 0.8;
    }
    
    .nav-text {
        flex: 1;
    }
    
    .dropdown-arrow {
        font-size: 1rem;
        transition: transform var(--transition-fast);
        opacity: 0.7;
    }
    
    .has-dropdown:hover .dropdown-arrow {
        transform: rotate(180deg);
    }
    
    .nav-badge {
        background: var(--accent-orange, #FF6D00);
        color: white;
        font-size: 0.625rem;
        font-weight: 600;
        padding: 0.125rem 0.375rem;
        border-radius: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        min-width: 1rem;
        text-align: center;
    }
    
    /* Dropdown Menus */
    .sub-menu {
        position: absolute;
        top: 100%;
        background: var(--surface, white);
        border-radius: 1rem;
        box-shadow: var(--shadow-xl);
        border: 1px solid var(--border-light, #F1F5F9);
        padding: 0.5rem;
        min-width: 220px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all var(--transition-normal);
        z-index: 50;
        list-style: none;
        margin: 0;
    }
    
    .dropdown-left {
        left: 0;
    }
    
    .dropdown-right {
        right: 0;
    }
    
    .dropdown-center {
        left: 50%;
        transform: translateX(-50%) translateY(-10px);
    }
    
    .has-dropdown:hover .sub-menu,
    .has-dropdown:focus-within .sub-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    .dropdown-center.sub-menu:hover,
    .dropdown-center.sub-menu:focus-within {
        transform: translateX(-50%) translateY(0);
    }
    
    .sub-menu .nav-link {
        padding: 0.5rem 0.75rem;
        margin: 0.125rem 0;
        border-radius: 0.5rem;
        width: 100%;
        justify-content: flex-start;
    }
    
    .sub-menu .dropdown-arrow {
        margin-left: auto;
        transform: rotate(-90deg);
    }
    
    /* Material Ripple Effect */
    .material-ripple {
        position: relative;
        overflow: hidden;
    }
    
    .material-ripple::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    
    .material-ripple:active::before {
        width: 300px;
        height: 300px;
    }
    
    /* Mobile Navigation */
    .mobile-nav-link {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        color: var(--text-primary);
        text-decoration: none;
        border-radius: 0.75rem;
        transition: all var(--transition-fast);
        margin-bottom: 0.25rem;
    }
    
    .mobile-nav-link:hover,
    .mobile-nav-link:focus {
        background: var(--primary-50, rgba(25, 118, 210, 0.05));
        color: var(--primary-600);
    }
    
    .mobile-nav-icon {
        font-size: 1.25rem;
        width: 24px;
        text-align: center;
    }
    
    .mobile-nav-text {
        flex: 1;
        font-weight: 500;
    }
    
    .mobile-dropdown-toggle {
        font-size: 1.125rem;
        opacity: 0.7;
        cursor: pointer;
        transition: transform var(--transition-fast);
    }
    
    .mobile-sub-menu {
        list-style: none;
        margin: 0;
        padding: 0 0 0 2.5rem;
        max-height: 0;
        overflow: hidden;
        transition: max-height var(--transition-normal);
    }
    
    .has-children.open .mobile-sub-menu {
        max-height: 500px;
    }
    
    .has-children.open .mobile-dropdown-toggle {
        transform: rotate(180deg);
    }
    
    /* Fallback Menu Styles */
    .fallback-menu {
        border: 2px dashed var(--border, #E2E8F0);
        border-radius: 0.75rem;
        padding: 1rem;
        background: var(--background-alt, #F8FAFC);
    }
    
    .menu-item-edit .nav-link {
        background: var(--primary-600, #1976D2);
        color: white;
        font-weight: 600;
    }
    
    .menu-item-edit .nav-link:hover {
        background: var(--primary-700, #1565C0);
        transform: none;
    }
    
    /* Accessibility Improvements */
    @media (prefers-reduced-motion: reduce) {
        .nav-link,
        .dropdown-arrow,
        .sub-menu,
        .mobile-dropdown-toggle {
            transition: none;
        }
    }
    
    /* High Contrast Mode */
    @media (prefers-contrast: high) {
        .nav-link {
            border: 1px solid transparent;
        }
        
        .nav-link:hover,
        .nav-link:focus {
            border-color: currentColor;
        }
    }
    
    /* Responsive Breakpoints */
    @media (max-width: 1024px) {
        .sub-menu {
            min-width: 200px;
        }
    }
    
    @media (max-width: 768px) {
        .nav-link {
            padding: 0.5rem 0.75rem;
        }
        
        .sub-menu {
            position: static;
            opacity: 1;
            visibility: visible;
            transform: none;
            box-shadow: none;
            border: none;
            border-radius: 0;
            background: transparent;
            padding: 0;
            margin-left: 1rem;
        }
    }
    </style>
    <?php
}
add_action('wp_head', 'westpace_walker_nav_css');

/**
 * Enhanced navigation JavaScript
 */
function westpace_walker_nav_js() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile dropdown toggles
        const mobileToggles = document.querySelectorAll('.mobile-dropdown-toggle');
        mobileToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const parent = this.closest('.has-children');
                parent.classList.toggle('open');
            });
        });
        
        // Keyboard navigation for dropdowns
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    if (this.classList.contains('has-dropdown-toggle')) {
                        e.preventDefault();
                        const dropdown = this.nextElementSibling;
                        if (dropdown && dropdown.classList.contains('sub-menu')) {
                            const firstLink = dropdown.querySelector('.nav-link');
                            if (firstLink) {
                                firstLink.focus();
                            }
                        }
                    }
                }
                
                if (e.key === 'Escape') {
                    const submenu = this.closest('.sub-menu');
                    if (submenu) {
                        const parentLink = submenu.previousElementSibling;
                        if (parentLink) {
                            parentLink.focus();
                        }
                    }
                }
            });
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.has-dropdown')) {
                const openDropdowns = document.querySelectorAll('.has-dropdown:hover');
                openDropdowns.forEach(dropdown => {
                    dropdown.blur();
                });
            }
        });
        
        // Add ripple effect
        const rippleElements = document.querySelectorAll('.material-ripple');
        rippleElements.forEach(element => {
            element.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.3);
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    transform: scale(0);
                    animation: ripple-animation 0.6s linear;
                    pointer-events: none;
                    z-index: 1;
                `;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    });
    
    // Add ripple animation CSS
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
    </script>
    <?php
}
add_action('wp_footer', 'westpace_walker_nav_js');
