<?php
/**
 * Westpace Material Theme Customizer
 */

function westpace_customize_register($wp_customize) {
    // Add Material Design Color Section
    $wp_customize->add_section("westpace_colors", array(
        "title" => __("Material Design Colors", "westpace-material"),
        "priority" => 30,
    ));
    
    // Primary Color
    $wp_customize->add_setting("westpace_primary_color", array(
        "default" => "#1565C0",
        "sanitize_callback" => "sanitize_hex_color",
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "westpace_primary_color", array(
        "label" => __("Primary Color", "westpace-material"),
        "section" => "westpace_colors",
        "settings" => "westpace_primary_color",
    )));
    
    // Secondary Color
    $wp_customize->add_setting("westpace_secondary_color", array(
        "default" => "#FF6F00",
        "sanitize_callback" => "sanitize_hex_color",
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "westpace_secondary_color", array(
        "label" => __("Secondary Color", "westpace-material"),
        "section" => "westpace_colors",
        "settings" => "westpace_secondary_color",
    )));
}
add_action("customize_register", "westpace_customize_register");

function westpace_customizer_css() {
    $primary_color = get_theme_mod("westpace_primary_color", "#1565C0");
    $secondary_color = get_theme_mod("westpace_secondary_color", "#FF6F00");
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_attr($primary_color); ?>;
            --secondary-color: <?php echo esc_attr($secondary_color); ?>;
        }
    </style>
    <?php
}
add_action("wp_head", "westpace_customizer_css");
