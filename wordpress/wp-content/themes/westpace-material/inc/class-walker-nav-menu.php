<?php
/**
 * Custom Navigation Walker for Material Design
 */
class Westpace_Walker_Nav_Menu extends Walker_Nav_Menu {
    
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu material-submenu elevation-2\">\n";
    }
    
    public function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
    
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $args = (object) $args;
        $indent = ($depth) ? str_repeat("\t", $depth) : "";
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = "menu-item-" . $item->ID;
        
        $class_names = join(" ", apply_filters("nav_menu_css_class", array_filter($classes), $item, $args));
        $class_names = $class_names ? " class=\"" . esc_attr($class_names) . "\"" : "";
        
        $id = apply_filters("nav_menu_item_id", "menu-item-" . $item->ID, $item, $args);
        $id = $id ? " id=\"" . esc_attr($id) . "\"" : "";
        
        $output .= $indent . "<li$id$class_names>";
        
        $attributes = !empty($item->attr_title) ? " title=\"" . esc_attr($item->attr_title) . "\"" : "";
        $attributes .= !empty($item->target) ? " target=\"" . esc_attr($item->target) . "\"" : "";
        $attributes .= !empty($item->xfn) ? " rel=\"" . esc_attr($item->xfn) . "\"" : "";
        $attributes .= !empty($item->url) ? " href=\"" . esc_attr($item->url) . "\"" : "";
        
        $item_output = isset($args->before) ? $args->before : "";
        $item_output .= "<a$attributes class=\"nav-link\">";
        $item_output .= (isset($args->link_before) ? $args->link_before : "") . apply_filters("the_title", $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : "");
        
        // Add dropdown arrow for parent items
        if (in_array("menu-item-has-children", $classes)) {
            $item_output .= " <span class=\"material-icons dropdown-arrow\">keyboard_arrow_down</span>";
        }
        
        $item_output .= "</a>";
        $item_output .= isset($args->after) ? $args->after : "";
        
        $output .= apply_filters("walker_nav_menu_start_el", $item_output, $item, $depth, $args);
    }
    
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}