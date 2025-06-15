<?php
/**
 * Enhanced Westpace Material Theme Customizer
 * Comprehensive customization options with modern interface
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
function westpace_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport         = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    // Remove default background image control
    $wp_customize->remove_control('background_image');

    /**
     * ========================================
     * THEME COLORS SECTION
     * ========================================
     */
    $wp_customize->add_section('westpace_colors', array(
        'title'    => __('Theme Colors', 'westpace-material'),
        'priority' => 30,
        'description' => __('Customize the color scheme of your website. Changes will be reflected immediately in the preview.', 'westpace-material'),
    ));

    // Primary Color
    $wp_customize->add_setting('westpace_primary_color', array(
        'default'           => '#1976D2',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'westpace_primary_color', array(
        'label'       => __('Primary Color', 'westpace-material'),
        'description' => __('Used for buttons, links, and accents', 'westpace-material'),
        'section'     => 'westpace_colors',
        'settings'    => 'westpace_primary_color',
    )));

    // Secondary Color
    $wp_customize->add_setting('westpace_secondary_color', array(
        'default'           => '#FF6D00',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'westpace_secondary_color', array(
        'label'       => __('Secondary Color', 'westpace-material'),
        'description' => __('Used for highlights and call-to-action elements', 'westpace-material'),
        'section'     => 'westpace_colors',
        'settings'    => 'westpace_secondary_color',
    )));

    // Text Color
    $wp_customize->add_setting('westpace_text_color', array(
        'default'           => '#0F172A',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'westpace_text_color', array(
        'label'       => __('Text Color', 'westpace-material'),
        'description' => __('Main text color for content', 'westpace-material'),
        'section'     => 'westpace_colors',
        'settings'    => 'westpace_text_color',
    )));

    // Background Color
    $wp_customize->add_setting('westpace_background_color', array(
        'default'           => '#FFFFFF',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'westpace_background_color', array(
        'label'       => __('Background Color', 'westpace-material'),
        'description' => __('Main background color for the website', 'westpace-material'),
        'section'     => 'westpace_colors',
        'settings'    => 'westpace_background_color',
    )));

    /**
     * ========================================
     * HERO SECTION
     * ========================================
     */
    $wp_customize->add_section('westpace_hero', array(
        'title'    => __('Hero Section', 'westpace-material'),
        'priority' => 35,
        'description' => __('Customize the main hero section on your homepage.', 'westpace-material'),
    ));

    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default'           => __('West Pace Apparels', 'westpace-material'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_title', array(
        'label'       => __('Hero Title', 'westpace-material'),
        'description' => __('The main heading for your hero section', 'westpace-material'),
        'section'     => 'westpace_hero',
        'type'        => 'text',
    ));

    // Hero Subtitle
    $wp_customize->add_setting('hero_subtitle', array(
        'default'           => __('Premium Garment Manufacturing Since 1998', 'westpace-material'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_subtitle', array(
        'label'       => __('Hero Subtitle', 'westpace-material'),
        'description' => __('A subtitle or tagline for your business', 'westpace-material'),
        'section'     => 'westpace_hero',
        'type'        => 'text',
    ));

    // Hero Description
    $wp_customize->add_setting('hero_description', array(
        'default'           => __('Family-owned Fijian company specializing in school wear, workwear, and winterwear for Australian and South Pacific markets. Over 24 years of excellence in quality manufacturing.', 'westpace-material'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_description', array(
        'label'       => __('Hero Description', 'westpace-material'),
        'description' => __('A brief description of your company or services', 'westpace-material'),
        'section'     => 'westpace_hero',
        'type'        => 'textarea',
    ));

    // Hero Background Image
    $wp_customize->add_setting('hero_background_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image', array(
        'label'       => __('Hero Background Image', 'westpace-material'),
        'description' => __('Upload a background image for the hero section (optional)', 'westpace-material'),
        'section'     => 'westpace_hero',
        'settings'    => 'hero_background_image',
    )));

    // Hero Button Text
    $wp_customize->add_setting('hero_button_text', array(
        'default'           => __('Explore Products', 'westpace-material'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_button_text', array(
        'label'       => __('Primary Button Text', 'westpace-material'),
        'description' => __('Text for the main call-to-action button', 'westpace-material'),
        'section'     => 'westpace_hero',
        'type'        => 'text',
    ));

    // Hero Button URL
    $wp_customize->add_setting('hero_button_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('hero_button_url', array(
        'label'       => __('Primary Button URL', 'westpace-material'),
        'description' => __('URL for the main call-to-action button', 'westpace-material'),
        'section'     => 'westpace_hero',
        'type'        => 'url',
    ));

    /**
     * ========================================
     * COMPANY INFORMATION
     * ========================================
     */
    $wp_customize->add_section('westpace_company', array(
        'title'    => __('Company Information', 'westpace-material'),
        'priority' => 40,
        'description' => __('Update your company contact information and details.', 'westpace-material'),
    ));

    // Company Address
    $wp_customize->add_setting('company_address', array(
        'default'           => __('Suva, Fiji Islands', 'westpace-material'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('company_address', array(
        'label'       => __('Company Address', 'westpace-material'),
        'description' => __('Your business address', 'westpace-material'),
        'section'     => 'westpace_company',
        'type'        => 'text',
    ));

    // Company Phone
    $wp_customize->add_setting('company_phone', array(
        'default'           => '+679 123 456',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('company_phone', array(
        'label'       => __('Phone Number', 'westpace-material'),
        'description' => __('Your business phone number', 'westpace-material'),
        'section'     => 'westpace_company',
        'type'        => 'tel',
    ));

    // Company Phone (Raw for tel: links)
    $wp_customize->add_setting('company_phone_raw', array(
        'default'           => '+679123456',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('company_phone_raw', array(
        'label'       => __('Phone Number (Raw)', 'westpace-material'),
        'description' => __('Phone number without spaces for tel: links (e.g., +679123456)', 'westpace-material'),
        'section'     => 'westpace_company',
        'type'        => 'text',
    ));

    // Company Email
    $wp_customize->add_setting('company_email', array(
        'default'           => 'info@westpace.com',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('company_email', array(
        'label'       => __('Email Address', 'westpace-material'),
        'description' => __('Your business email address', 'westpace-material'),
        'section'     => 'westpace_company',
        'type'        => 'email',
    ));

    // Business Hours
    $wp_customize->add_setting('business_hours', array(
        'default'           => __('Monday - Friday: 8:00 AM - 6:00 PM (FJT)', 'westpace-material'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('business_hours', array(
        'label'       => __('Business Hours', 'westpace-material'),
        'description' => __('Your operating hours', 'westpace-material'),
        'section'     => 'westpace_company',
        'type'        => 'text',
    ));

    /**
     * ========================================
     * SOCIAL MEDIA LINKS
     * ========================================
     */
    $wp_customize->add_section('westpace_social', array(
        'title'    => __('Social Media', 'westpace-material'),
        'priority' => 45,
        'description' => __('Add your social media profile links.', 'westpace-material'),
    ));

    $social_networks = array(
        'facebook'  => __('Facebook', 'westpace-material'),
        'twitter'   => __('Twitter', 'westpace-material'),
        'instagram' => __('Instagram', 'westpace-material'),
        'linkedin'  => __('LinkedIn', 'westpace-material'),
        'youtube'   => __('YouTube', 'westpace-material'),
        'pinterest' => __('Pinterest', 'westpace-material'),
    );

    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting("social_{$network}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("social_{$network}", array(
            'label'       => $label . ' ' . __('URL', 'westpace-material'),
            'description' => sprintf(__('Enter your %s profile URL', 'westpace-material'), $label),
            'section'     => 'westpace_social',
            'type'        => 'url',
        ));
    }

    /**
     * ========================================
     * FOOTER SETTINGS
     * ========================================
     */
    $wp_customize->add_section('westpace_footer', array(
        'title'    => __('Footer Settings', 'westpace-material'),
        'priority' => 50,
        'description' => __('Customize footer content and appearance.', 'westpace-material'),
    ));

    // Footer Description
    $wp_customize->add_setting('footer_description', array(
        'default'           => __('Premium garment manufacturing with over 24 years of excellence. Serving Australia, New Zealand, and the South Pacific.', 'westpace-material'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_description', array(
        'label'       => __('Footer Description', 'westpace-material'),
        'description' => __('Brief description shown in the footer', 'westpace-material'),
        'section'     => 'westpace_footer',
        'type'        => 'textarea',
    ));

    // Copyright Text
    $wp_customize->add_setting('footer_copyright', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_copyright', array(
        'label'       => __('Copyright Text', 'westpace-material'),
        'description' => __('Custom copyright text (leave empty for default)', 'westpace-material'),
        'section'     => 'westpace_footer',
        'type'        => 'text',
    ));

    // Show Newsletter Signup
    $wp_customize->add_setting('show_newsletter_signup', array(
        'default'           => true,
        'sanitize_callback' => 'westpace_sanitize_checkbox',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('show_newsletter_signup', array(
        'label'       => __('Show Newsletter Signup', 'westpace-material'),
        'description' => __('Display newsletter signup form in footer', 'westpace-material'),
        'section'     => 'westpace_footer',
        'type'        => 'checkbox',
    ));

    /**
     * ========================================
     * LAYOUT OPTIONS
     * ========================================
     */
    $wp_customize->add_section('westpace_layout', array(
        'title'    => __('Layout Options', 'westpace-material'),
        'priority' => 55,
        'description' => __('Control the layout and structure of your website.', 'westpace-material'),
    ));

    // Container Width
    $wp_customize->add_setting('container_width', array(
        'default'           => '1200',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('container_width', array(
        'label'       => __('Container Width (px)', 'westpace-material'),
        'description' => __('Maximum width for content containers', 'westpace-material'),
        'section'     => 'westpace_layout',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 960,
            'max'  => 1600,
            'step' => 20,
        ),
    ));

    // Header Style
    $wp_customize->add_setting('header_style', array(
        'default'           => 'fixed',
        'sanitize_callback' => 'westpace_sanitize_select',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('header_style', array(
        'label'       => __('Header Style', 'westpace-material'),
        'description' => __('Choose how the header behaves on scroll', 'westpace-material'),
        'section'     => 'westpace_layout',
        'type'        => 'select',
        'choices'     => array(
            'fixed'  => __('Fixed (stays at top)', 'westpace-material'),
            'sticky' => __('Sticky (hides on scroll down)', 'westpace-material'),
            'static' => __('Static (scrolls with content)', 'westpace-material'),
        ),
    ));

    // Blog Layout
    $wp_customize->add_setting('blog_layout', array(
        'default'           => 'grid',
        'sanitize_callback' => 'westpace_sanitize_select',
    ));

    $wp_customize->add_control('blog_layout', array(
        'label'       => __('Blog Layout', 'westpace-material'),
        'description' => __('Default layout for blog posts', 'westpace-material'),
        'section'     => 'westpace_layout',
        'type'        => 'select',
        'choices'     => array(
            'grid' => __('Grid Layout', 'westpace-material'),
            'list' => __('List Layout', 'westpace-material'),
        ),
    ));

    // Sidebar Position
    $wp_customize->add_setting('sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'westpace_sanitize_select',
    ));

    $wp_customize->add_control('sidebar_position', array(
        'label'       => __('Sidebar Position', 'westpace-material'),
        'description' => __('Position of the sidebar on blog and single posts', 'westpace-material'),
        'section'     => 'westpace_layout',
        'type'        => 'select',
        'choices'     => array(
            'right' => __('Right Sidebar', 'westpace-material'),
            'left'  => __('Left Sidebar', 'westpace-material'),
            'none'  => __('No Sidebar', 'westpace-material'),
        ),
    ));

    /**
     * ========================================
     * PERFORMANCE & FEATURES
     * ========================================
     */
    $wp_customize->add_section('westpace_performance', array(
        'title'    => __('Performance & Features', 'westpace-material'),
        'priority' => 60,
        'description' => __('Enable or disable theme features and performance optimizations.', 'westpace-material'),
    ));

    // Enable Animations
    $wp_customize->add_setting('enable_animations', array(
        'default'           => true,
        'sanitize_callback' => 'westpace_sanitize_checkbox',
    ));

    $wp_customize->add_control('enable_animations', array(
        'label'       => __('Enable Animations', 'westpace-material'),
        'description' => __('Enable scroll animations and hover effects', 'westpace-material'),
        'section'     => 'westpace_performance',
        'type'        => 'checkbox',
    ));

    // Enable Lazy Loading
    $wp_customize->add_setting('enable_lazy_loading', array(
        'default'           => true,
        'sanitize_callback' => 'westpace_sanitize_checkbox',
    ));

    $wp_customize->add_control('enable_lazy_loading', array(
        'label'       => __('Enable Lazy Loading', 'westpace-material'),
        'description' => __('Load images only when they come into view', 'westpace-material'),
        'section'     => 'westpace_performance',
        'type'        => 'checkbox',
    ));

    // Enable Cookie Notice
    $wp_customize->add_setting('enable_cookie_notice', array(
        'default'           => true,
        'sanitize_callback' => 'westpace_sanitize_checkbox',
    ));

    $wp_customize->add_control('enable_cookie_notice', array(
        'label'       => __('Enable Cookie Notice', 'westpace-material'),
        'description' => __('Show cookie consent notice to visitors', 'westpace-material'),
        'section'     => 'westpace_performance',
        'type'        => 'checkbox',
    ));

    // Cookie Notice Text
    $wp_customize->add_setting('cookie_notice_text', array(
        'default'           => __('We use cookies to enhance your browsing experience and provide personalized content. By continuing to use our site, you agree to our use of cookies.', 'westpace-material'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('cookie_notice_text', array(
        'label'       => __('Cookie Notice Text', 'westpace-material'),
        'description' => __('Text shown in the cookie notice', 'westpace-material'),
        'section'     => 'westpace_performance',
        'type'        => 'textarea',
        'active_callback' => function() {
            return get_theme_mod('enable_cookie_notice', true);
        },
    ));

    // Enable Back to Top Button
    $wp_customize->add_setting('enable_back_to_top', array(
        'default'           => true,
        'sanitize_callback' => 'westpace_sanitize_checkbox',
    ));

    $wp_customize->add_control('enable_back_to_top', array(
        'label'       => __('Enable Back to Top Button', 'westpace-material'),
        'description' => __('Show floating back to top button', 'westpace-material'),
        'section'     => 'westpace_performance',
        'type'        => 'checkbox',
    ));

    /**
     * ========================================
     * WOOCOMMERCE SETTINGS
     * ========================================
     */
    if (class_exists('WooCommerce')) {
        $wp_customize->add_section('westpace_woocommerce', array(
            'title'    => __('WooCommerce Settings', 'westpace-material'),
            'priority' => 65,
            'description' => __('Customize WooCommerce shop appearance and functionality.', 'westpace-material'),
        ));

        // Products per Page
        $wp_customize->add_setting('shop_products_per_page', array(
            'default'           => 12,
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control('shop_products_per_page', array(
            'label'       => __('Products per Page', 'westpace-material'),
            'description' => __('Number of products to show per page in shop', 'westpace-material'),
            'section'     => 'westpace_woocommerce',
            'type'        => 'number',
            'input_attrs' => array(
                'min' => 4,
                'max' => 48,
                'step' => 4,
            ),
        ));

        // Shop Columns
        $wp_customize->add_setting('shop_columns', array(
            'default'           => 4,
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control('shop_columns', array(
            'label'       => __('Shop Columns', 'westpace-material'),
            'description' => __('Number of columns for product grid', 'westpace-material'),
            'section'     => 'westpace_woocommerce',
            'type'        => 'select',
            'choices'     => array(
                2 => __('2 Columns', 'westpace-material'),
                3 => __('3 Columns', 'westpace-material'),
                4 => __('4 Columns', 'westpace-material'),
                5 => __('5 Columns', 'westpace-material'),
                6 => __('6 Columns', 'westpace-material'),
            ),
        ));

        // Show Product Rating
        $wp_customize->add_setting('show_product_rating', array(
            'default'           => true,
            'sanitize_callback' => 'westpace_sanitize_checkbox',
        ));

        $wp_customize->add_control('show_product_rating', array(
            'label'       => __('Show Product Rating', 'westpace-material'),
            'description' => __('Display star ratings on product listings', 'westpace-material'),
            'section'     => 'westpace_woocommerce',
            'type'        => 'checkbox',
        ));

        // Show Sale Badge
        $wp_customize->add_setting('show_sale_badge', array(
            'default'           => true,
            'sanitize_callback' => 'westpace_sanitize_checkbox',
        ));

        $wp_customize->add_control('show_sale_badge', array(
            'label'       => __('Show Sale Badge', 'westpace-material'),
            'description' => __('Display sale badges on discounted products', 'westpace-material'),
            'section'     => 'westpace_woocommerce',
            'type'        => 'checkbox',
        ));
    }

    /**
     * ========================================
     * TYPOGRAPHY SETTINGS
     * ========================================
     */
    $wp_customize->add_section('westpace_typography', array(
        'title'    => __('Typography', 'westpace-material'),
        'priority' => 70,
        'description' => __('Customize fonts and typography settings.', 'westpace-material'),
    ));

    // Heading Font
    $wp_customize->add_setting('heading_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('heading_font', array(
        'label'       => __('Heading Font', 'westpace-material'),
        'description' => __('Font family for headings', 'westpace-material'),
        'section'     => 'westpace_typography',
        'type'        => 'select',
        'choices'     => array(
            'Inter'        => 'Inter',
            'Roboto'       => 'Roboto',
            'Open Sans'    => 'Open Sans',
            'Lato'         => 'Lato',
            'Montserrat'   => 'Montserrat',
            'Poppins'      => 'Poppins',
            'Source Sans Pro' => 'Source Sans Pro',
        ),
    ));

    // Body Font
    $wp_customize->add_setting('body_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('body_font', array(
        'label'       => __('Body Font', 'westpace-material'),
        'description' => __('Font family for body text', 'westpace-material'),
        'section'     => 'westpace_typography',
        'type'        => 'select',
        'choices'     => array(
            'Inter'        => 'Inter',
            'Roboto'       => 'Roboto',
            'Open Sans'    => 'Open Sans',
            'Lato'         => 'Lato',
            'Source Sans Pro' => 'Source Sans Pro',
            'System'       => 'System Default',
        ),
    ));

    // Font Size
    $wp_customize->add_setting('base_font_size', array(
        'default'           => 16,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('base_font_size', array(
        'label'       => __('Base Font Size (px)', 'westpace-material'),
        'description' => __('Base font size for body text', 'westpace-material'),
        'section'     => 'westpace_typography',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 14,
            'max'  => 20,
            'step' => 1,
        ),
    ));

    if (isset($wp_customize->selective_refresh)) {
        // Selective refresh for hero section
        $wp_customize->selective_refresh->add_partial('hero_title', array(
            'selector'        => '.hero-title',
            'render_callback' => function() { return get_theme_mod('hero_title', __('West Pace Apparels', 'westpace-material')); },
        ));

        $wp_customize->selective_refresh->add_partial('hero_subtitle', array(
            'selector'        => '.hero-subtitle',
            'render_callback' => function() { return get_theme_mod('hero_subtitle', __('Premium Garment Manufacturing Since 1998', 'westpace-material')); },
        ));

        $wp_customize->selective_refresh->add_partial('hero_description', array(
            'selector'        => '.hero-description',
            'render_callback' => function() { return get_theme_mod('hero_description'); },
        ));

        $wp_customize->selective_refresh->add_partial('blogname', array(
            'selector'        => '.site-title',
            'render_callback' => 'westpace_customize_partial_blogname',
        ));

        $wp_customize->selective_refresh->add_partial('blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'westpace_customize_partial_blogdescription',
        ));
    }
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
 * Sanitize checkbox values
 */
function westpace_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Sanitize select fields
 */
function westpace_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function westpace_customize_preview_js() {
    wp_enqueue_script('westpace-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), WESTPACE_VERSION, true);
}
add_action('customize_preview_init', 'westpace_customize_preview_js');

/**
 * Enqueue customizer control scripts
 */
function westpace_customize_controls_js() {
    wp_enqueue_script('westpace-customizer-controls', get_template_directory_uri() . '/assets/js/customizer-controls.js', array('customize-controls'), WESTPACE_VERSION, true);
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
    
    // Generate CSS
    ?>
    <style type="text/css" id="westpace-customizer-css">
        :root {
            --primary-600: <?php echo esc_attr($primary_color); ?>;
            --primary-700: <?php echo esc_attr(westpace_darken_color($primary_color, 0.1)); ?>;
            --primary-800: <?php echo esc_attr(westpace_darken_color($primary_color, 0.2)); ?>;
            --secondary-color: <?php echo esc_attr($secondary_color); ?>;
            --text-primary: <?php echo esc_attr($text_color); ?>;
            --background: <?php echo esc_attr($background_color); ?>;
        }
        
        <?php if ($heading_font !== 'Inter') : ?>
        @import url('https://fonts.googleapis.com/css2?family=<?php echo esc_attr(str_replace(' ', '+', $heading_font)); ?>:wght@300;400;500;600;700;800;900&display=swap');
        <?php endif; ?>
        
        <?php if ($body_font !== 'Inter' && $body_font !== $heading_font) : ?>
        @import url('https://fonts.googleapis.com/css2?family=<?php echo esc_attr(str_replace(' ', '+', $body_font)); ?>:wght@300;400;500;600;700&display=swap');
        <?php endif; ?>
        
        body {
            font-family: <?php echo $body_font === 'System' ? '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif' : '"' . esc_attr($body_font) . '", -apple-system, BlinkMacSystemFont, sans-serif'; ?>;
            font-size: <?php echo esc_attr($base_font_size); ?>px;
            background-color: <?php echo esc_attr($background_color); ?>;
            color: <?php echo esc_attr($text_color); ?>;
        }
        
        h1, h2, h3, h4, h5, h6,
        .hero-title,
        .section-title,
        .post-title,
        .page-title {
            font-family: "<?php echo esc_attr($heading_font); ?>", -apple-system, BlinkMacSystemFont, sans-serif;
        }
        
        .container {
            max-width: <?php echo esc_attr($container_width); ?>px;
        }
        
        <?php if (!get_theme_mod('enable_animations', true)) : ?>
        * {
            animation: none !important;
            transition: none !important;
        }
        <?php endif; ?>
        
        <?php if (get_theme_mod('header_style', 'fixed') === 'static') : ?>
        .site-header {
            position: relative;
        }
        .site-content {
            padding-top: 0;
        }
        <?php endif; ?>
        
        <?php if (get_theme_mod('sidebar_position', 'right') === 'left') : ?>
        .blog-layout.has-sidebar {
            grid-template-columns: 300px 1fr;
        }
        <?php elseif (get_theme_mod('sidebar_position', 'right') === 'none') : ?>
        .blog-layout {
            grid-template-columns: 1fr;
        }
        <?php endif; ?>
    </style>
    <?php
}
add_action('wp_head', 'westpace_customizer_css');

/**
 * Helper function to darken a color
 */
function westpace_darken_color($color, $amount) {
    $color = ltrim($color, '#');
    $rgb = array_map('hexdec', str_split($color, 2));
    
    foreach ($rgb as &$value) {
        $value = max(0, min(255, $value - ($value * $amount)));
    }
    
    return '#' . implode('', array_map(function($value) {
        return str_pad(dechex(round($value)), 2, '0', STR_PAD_LEFT);
    }, $rgb));
}

/**
 * Apply WooCommerce customizer settings
 */
function westpace_apply_woocommerce_settings() {
    if (!class_exists('WooCommerce')) {
        return;
    }
    
    // Products per page
    $products_per_page = get_theme_mod('shop_products_per_page', 12);
    add_filter('loop_shop_per_page', function() use ($products_per_page) {
        return $products_per_page;
    });
    
    // Shop columns
    $shop_columns = get_theme_mod('shop_columns', 4);
    add_filter('loop_shop_columns', function() use ($shop_columns) {
        return $shop_columns;
    });
    
    // Product rating
    if (!get_theme_mod('show_product_rating', true)) {
        remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
    }
    
    // Sale badge
    if (!get_theme_mod('show_sale_badge', true)) {
        remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
    }
}
add_action('init', 'westpace_apply_woocommerce_settings');
