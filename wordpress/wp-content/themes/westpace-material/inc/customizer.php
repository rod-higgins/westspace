<?php
/**
 * Westpace Material Theme Customizer
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
function westpace_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('blogname', array(
            'selector'        => '.site-title a',
            'render_callback' => 'westpace_customize_partial_blogname',
        ));
        $wp_customize->selective_refresh->add_partial('blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'westpace_customize_partial_blogdescription',
        ));
    }

    // Colors Section
    $wp_customize->add_section('westpace_colors', array(
        'title'    => __('Material Design Colors', 'westpace-material'),
        'priority' => 30,
    ));

    // Primary Color
    $wp_customize->add_setting('westpace_primary_color', array(
        'default'           => '#1976D2',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'westpace_primary_color', array(
        'label'    => __('Primary Color', 'westpace-material'),
        'section'  => 'westpace_colors',
        'settings' => 'westpace_primary_color',
    )));

    // Secondary Color
    $wp_customize->add_setting('westpace_secondary_color', array(
        'default'           => '#FF6D00',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'westpace_secondary_color', array(
        'label'    => __('Secondary Color', 'westpace-material'),
        'section'  => 'westpace_colors',
        'settings' => 'westpace_secondary_color',
    )));

    // Text Color
    $wp_customize->add_setting('westpace_text_color', array(
        'default'           => '#0F172A',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'westpace_text_color', array(
        'label'    => __('Text Color', 'westpace-material'),
        'section'  => 'westpace_colors',
        'settings' => 'westpace_text_color',
    )));

    // Background Color
    $wp_customize->add_setting('westpace_background_color', array(
        'default'           => '#FFFFFF',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'westpace_background_color', array(
        'label'    => __('Background Color', 'westpace-material'),
        'section'  => 'westpace_colors',
        'settings' => 'westpace_background_color',
    )));

    // Typography Section
    $wp_customize->add_section('westpace_typography', array(
        'title'    => __('Typography', 'westpace-material'),
        'priority' => 35,
    ));

    // Heading Font
    $wp_customize->add_setting('heading_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('heading_font', array(
        'label'    => __('Heading Font', 'westpace-material'),
        'section'  => 'westpace_typography',
        'type'     => 'select',
        'choices'  => array(
            'Inter'       => 'Inter',
            'Roboto'      => 'Roboto',
            'Open Sans'   => 'Open Sans',
            'Lato'        => 'Lato',
            'Montserrat'  => 'Montserrat',
            'Poppins'     => 'Poppins',
            'System'      => 'System Default',
        ),
    ));

    // Body Font
    $wp_customize->add_setting('body_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('body_font', array(
        'label'    => __('Body Font', 'westpace-material'),
        'section'  => 'westpace_typography',
        'type'     => 'select',
        'choices'  => array(
            'Inter'       => 'Inter',
            'Roboto'      => 'Roboto',
            'Open Sans'   => 'Open Sans',
            'Lato'        => 'Lato',
            'Montserrat'  => 'Montserrat',
            'Poppins'     => 'Poppins',
            'System'      => 'System Default',
        ),
    ));

    // Base Font Size
    $wp_customize->add_setting('base_font_size', array(
        'default'           => 16,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('base_font_size', array(
        'label'       => __('Base Font Size (px)', 'westpace-material'),
        'section'     => 'westpace_typography',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ),
    ));

    // Layout Section
    $wp_customize->add_section('westpace_layout', array(
        'title'    => __('Layout Options', 'westpace-material'),
        'priority' => 40,
    ));

    // Container Width
    $wp_customize->add_setting('container_width', array(
        'default'           => 1200,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('container_width', array(
        'label'       => __('Container Width (px)', 'westpace-material'),
        'section'     => 'westpace_layout',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 960,
            'max'  => 1440,
            'step' => 20,
        ),
    ));

    // Sidebar Position
    $wp_customize->add_setting('sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'westpace_sanitize_select',
    ));

    $wp_customize->add_control('sidebar_position', array(
        'label'   => __('Sidebar Position', 'westpace-material'),
        'section' => 'westpace_layout',
        'type'    => 'select',
        'choices' => array(
            'left'  => __('Left', 'westpace-material'),
            'right' => __('Right', 'westpace-material'),
            'none'  => __('No Sidebar', 'westpace-material'),
        ),
    ));

    // Homepage Section
    $wp_customize->add_section('westpace_homepage', array(
        'title'    => __('Homepage Settings', 'westpace-material'),
        'priority' => 45,
    ));

    // Hero Section
    $wp_customize->add_setting('hero_title', array(
        'default'           => __('West Pace Apparels', 'westpace-material'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_title', array(
        'label'   => __('Hero Title', 'westpace-material'),
        'section' => 'westpace_homepage',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('hero_subtitle', array(
        'default'           => __('Premium Garment Manufacturing Since 1998', 'westpace-material'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_subtitle', array(
        'label'   => __('Hero Subtitle', 'westpace-material'),
        'section' => 'westpace_homepage',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('hero_description', array(
        'default'           => __('Family-owned Fijian company specializing in school wear, workwear, and winterwear for Australian and South Pacific markets.', 'westpace-material'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_description', array(
        'label'   => __('Hero Description', 'westpace-material'),
        'section' => 'westpace_homepage',
        'type'    => 'textarea',
    ));

    // Hero Background Image
    $wp_customize->add_setting('hero_background_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image', array(
        'label'    => __('Hero Background Image', 'westpace-material'),
        'section'  => 'westpace_homepage',
        'settings' => 'hero_background_image',
    )));

    // Hero CTA Button Text
    $wp_customize->add_setting('hero_cta_text', array(
        'default'           => __('Shop Now', 'westpace-material'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_cta_text', array(
        'label'   => __('Hero Button Text', 'westpace-material'),
        'section' => 'westpace_homepage',
        'type'    => 'text',
    ));

    // Hero CTA Button URL
    $wp_customize->add_setting('hero_cta_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('hero_cta_url', array(
        'label'   => __('Hero Button URL', 'westpace-material'),
        'section' => 'westpace_homepage',
        'type'    => 'url',
    ));

    // Show/Hide Sections
    $wp_customize->add_setting('show_hero_section', array(
        'default'           => true,
        'sanitize_callback' => 'westpace_sanitize_checkbox',
    ));

    $wp_customize->add_control('show_hero_section', array(
        'label'   => __('Show Hero Section', 'westpace-material'),
        'section' => 'westpace_homepage',
        'type'    => 'checkbox',
    ));

    $wp_customize->add_setting('show_services_section', array(
        'default'           => true,
        'sanitize_callback' => 'westpace_sanitize_checkbox',
    ));

    $wp_customize->add_control('show_services_section', array(
        'label'   => __('Show Services Section', 'westpace-material'),
        'section' => 'westpace_homepage',
        'type'    => 'checkbox',
    ));

    // WooCommerce Section (if WooCommerce is active)
    if (class_exists('WooCommerce')) {
        $wp_customize->add_section('westpace_woocommerce', array(
            'title'    => __('WooCommerce Settings', 'westpace-material'),
            'priority' => 50,
        ));

        // Products per page
        $wp_customize->add_setting('products_per_page', array(
            'default'           => 12,
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control('products_per_page', array(
            'label'   => __('Products per Page', 'westpace-material'),
            'section' => 'westpace_woocommerce',
            'type'    => 'number',
            'input_attrs' => array(
                'min' => 4,
                'max' => 48,
            ),
        ));

        // Show product count
        $wp_customize->add_setting('show_product_count', array(
            'default'           => true,
            'sanitize_callback' => 'westpace_sanitize_checkbox',
        ));

        $wp_customize->add_control('show_product_count', array(
            'label'   => __('Show Product Count', 'westpace-material'),
            'section' => 'westpace_woocommerce',
            'type'    => 'checkbox',
        ));

        // Shop sidebar
        $wp_customize->add_setting('shop_sidebar', array(
            'default'           => 'left',
            'sanitize_callback' => 'westpace_sanitize_select',
        ));

        $wp_customize->add_control('shop_sidebar', array(
            'label'   => __('Shop Sidebar Position', 'westpace-material'),
            'section' => 'westpace_woocommerce',
            'type'    => 'select',
            'choices' => array(
                'left'  => __('Left', 'westpace-material'),
                'right' => __('Right', 'westpace-material'),
                'none'  => __('No Sidebar', 'westpace-material'),
            ),
        ));
    }

    // Footer Section
    $wp_customize->add_section('westpace_footer', array(
        'title'    => __('Footer Settings', 'westpace-material'),
        'priority' => 55,
    ));

    // Footer Copyright
    $wp_customize->add_setting('footer_copyright', array(
        'default'           => sprintf(__('© %s West Pace Apparels. All rights reserved.', 'westpace-material'), date('Y')),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_copyright', array(
        'label'   => __('Footer Copyright Text', 'westpace-material'),
        'section' => 'westpace_footer',
        'type'    => 'text',
    ));

    // Footer Social Links
    $social_networks = array(
        'facebook'  => 'Facebook',
        'twitter'   => 'Twitter',
        'instagram' => 'Instagram',
        'linkedin'  => 'LinkedIn',
        'youtube'   => 'YouTube',
    );

    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting("social_{$network}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("social_{$network}", array(
            'label'   => sprintf(__('%s URL', 'westpace-material'), $label),
            'section' => 'westpace_footer',
            'type'    => 'url',
        ));
    }

    // Show footer widgets
    $wp_customize->add_setting('show_footer_widgets', array(
        'default'           => true,
        'sanitize_callback' => 'westpace_sanitize_checkbox',
    ));

    $wp_customize->add_control('show_footer_widgets', array(
        'label'   => __('Show Footer Widgets', 'westpace-material'),
        'section' => 'westpace_footer',
        'type'    => 'checkbox',
    ));
}
add_action('customize_register', 'westpace_customize_register');

/**
 * Render the site title for the selective refresh partial.
 */
function westpace_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function westpace_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Sanitize select field
 */
function westpace_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Sanitize checkbox field
 */
function westpace_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Darken color utility function
 */
function westpace_darken_color($color, $amount) {
    $color = ltrim($color, '#');
    $rgb = array();
    
    for ($i = 0; $i < 3; $i++) {
        $rgb[$i] = hexdec(substr($color, $i * 2, 2));
        $rgb[$i] = max(0, min(255, $rgb[$i] - ($rgb[$i] * $amount)));
        $rgb[$i] = str_pad(dechex($rgb[$i]), 2, '0', STR_PAD_LEFT);
    }
    
    return '#' . implode('', $rgb);
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function westpace_customize_preview_js() {
    wp_enqueue_script('westpace-customizer', WESTPACE_THEME_URI . '/assets/js/customizer.js', array('customize-preview'), WESTPACE_VERSION, true);
}
add_action('customize_preview_init', 'westpace_customize_preview_js');

/**
 * Enqueue customizer control scripts
 */
function westpace_customize_controls_js() {
    wp_enqueue_script('westpace-customizer-controls', WESTPACE_THEME_URI . '/assets/js/customizer-controls.js', array('customize-controls'), WESTPACE_VERSION, true);
}
add_action('customize_controls_enqueue_scripts', 'westpace_customize_controls_js');

/**
 * Output customizer CSS
 */
function westpace_customizer_css() {
    $primary_color = get_theme_mod('westpace_primary_color', '#1976D2');
    $secondary_color = get_theme_mod('westpace_secondary_color', '#FF6D00');
    $text_color = get_theme_mod('westpace_text_color', '#0F172A');
    $background_color = get_theme_mod('westpace_background_color', '#FFFFFF');
    $container_width = get_theme_mod('container_width', 1200);
    $base_font_size = get_theme_mod('base_font_size', 16);
    $heading_font = get_theme_mod('heading_font', 'Inter');
    $body_font = get_theme_mod('body_font', 'Inter');
    
    ?>
    <style type="text/css" id="westpace-customizer-css">
        :root {
            --primary-600: <?php echo esc_attr($primary_color); ?>;
            --primary-700: <?php echo esc_attr(westpace_darken_color($primary_color, 0.1)); ?>;
            --primary-800: <?php echo esc_attr(westpace_darken_color($primary_color, 0.2)); ?>;
            --secondary-color: <?php echo esc_attr($secondary_color); ?>;
            --text-primary: <?php echo esc_attr($text_color); ?>;
            --background: <?php echo esc_attr($background_color); ?>;
            --container-width: <?php echo esc_attr($container_width); ?>px;
            --base-font-size: <?php echo esc_attr($base_font_size); ?>px;
        }
        
        <?php if ($heading_font !== 'Inter') : ?>
        @import url('https://fonts.googleapis.com/css2?family=<?php echo esc_attr(str_replace(' ', '+', $heading_font)); ?>:wght@300;400;500;600;700;800;900&display=swap');
        <?php endif; ?>
        
        <?php if ($body_font !== 'Inter' && $body_font !== $heading_font) : ?>
        @import url('https://fonts.googleapis.com/css2?family=<?php echo esc_attr(str_replace(' ', '+', $body_font)); ?>:wght@300;400;500;600;700&display=swap');
        <?php endif; ?>
        
        body {
            font-family: <?php echo $body_font === 'System' ? '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif' : '"' . esc_attr($body_font) . '", sans-serif'; ?>;
            font-size: var(--base-font-size);
            color: var(--text-primary);
            background-color: var(--background);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: <?php echo $heading_font === 'System' ? '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif' : '"' . esc_attr($heading_font) . '", sans-serif'; ?>;
        }
        
        .container {
            max-width: var(--container-width);
        }
        
        .btn-primary,
        .button,
        .wp-block-button__link {
            background-color: var(--primary-600);
            border-color: var(--primary-600);
        }
        
        .btn-primary:hover,
        .button:hover,
        .wp-block-button__link:hover {
            background-color: var(--primary-700);
            border-color: var(--primary-700);
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        a {
            color: var(--primary-600);
        }
        
        a:hover {
            color: var(--primary-700);
        }
    </style>
    <?php
}
add_action('wp_head', 'westpace_customizer_css');