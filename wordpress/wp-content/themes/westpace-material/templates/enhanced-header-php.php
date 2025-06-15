<?php
/**
 * Enhanced Header Template for Westpace Material Theme
 * Modern, accessible, and performance-optimized
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#1976D2">
    <meta name="msapplication-TileColor" content="#1976D2">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    
    <!-- Performance optimizations -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    
    <!-- Modern font loading with display swap -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="https://fonts.googleapis.com/icon?family=Material+Icons+Round&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    
    <!-- Fallback for browsers without JS -->
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Round&display=swap">
    </noscript>
    
    <!-- Remove no-js class with inline script for immediate execution -->
    <script>document.documentElement.className = document.documentElement.className.replace('no-js', 'js');</script>
    
    <!-- Critical CSS for above-the-fold content -->
    <style>
        /* Critical CSS - Inline for performance */
        :root {
            --primary-600: #1976D2;
            --primary-700: #1565C0;
            --neutral-0: #FFFFFF;
            --neutral-50: #F8FAFC;
            --neutral-900: #0F172A;
            --text-primary: #0F172A;
            --border-light: #F1F5F9;
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
            --transition-normal: 250ms cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
            background: var(--neutral-0);
            overflow-x: hidden;
        }
        
        .site-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-light);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            transition: all var(--transition-normal);
        }
        
        .header-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 80px;
        }
        
        .site-content {
            padding-top: 80px;
        }
        
        /* Prevent layout shift */
        img { max-width: 100%; height: auto; }
        
        /* Loading state */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
    </style>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Skip to main content for accessibility -->
<a class="skip-link sr-only" href="#main"><?php esc_html_e('Skip to main content', 'westpace-material'); ?></a>

<!-- Loading overlay -->
<div class="loading-overlay" id="loading-overlay">
    <div class="loading-spinner"></div>
</div>

<div id="page" class="site">
    <header id="masthead" class="site-header" role="banner">
        <div class="header-container">
            <!-- Site Branding -->
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <div class="site-logo">
                        <?php 
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                        if ($logo) :
                        ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" aria-label="<?php bloginfo('name'); ?> - <?php esc_attr_e('Home', 'westpace-material'); ?>">
                                <img src="<?php echo esc_url($logo[0]); ?>" 
                                     alt="<?php bloginfo('name'); ?>" 
                                     width="<?php echo esc_attr($logo[1]); ?>" 
                                     height="<?php echo esc_attr($logo[2]); ?>"
                                     loading="eager">
                            </a>
                        <?php endif; ?>
                    </div>
                <?php else : ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="site-logo">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                    <?php
                    $description = get_bloginfo('description', 'display');
                    if ($description || is_customize_preview()) :
                    ?>
                        <p class="site-description sr-only"><?php echo $description; ?></p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- Main Navigation -->
            <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('Primary Navigation', 'westpace-material'); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'nav-menu',
                    'container'      => false,
                    'fallback_cb'    => 'westpace_fallback_menu',
                    'walker'         => new Westpace_Walker_Nav_Menu(),
                ));
                ?>
            </nav>

            <!-- Header Actions -->
            <div class="header-actions">
                <?php if (class_exists('WooCommerce')) : ?>
                    <!-- Search Toggle -->
                    <button class="search-toggle btn-ghost" aria-label="<?php esc_attr_e('Search', 'westpace-material'); ?>" aria-expanded="false">
                        <span class="material-icons">search</span>
                    </button>
                    
                    <!-- Account Link -->
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('dashboard')); ?>" 
                           class="account-link btn-ghost" 
                           aria-label="<?php esc_attr_e('My Account', 'westpace-material'); ?>">
                            <span class="material-icons">account_circle</span>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('dashboard')); ?>" 
                           class="account-link btn-ghost" 
                           aria-label="<?php esc_attr_e('Login / Register', 'westpace-material'); ?>">
                            <span class="material-icons">person</span>
                        </a>
                    <?php endif; ?>
                    
                    <!-- Cart Link -->
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" 
                       class="cart-link btn-ghost" 
                       aria-label="<?php esc_attr_e('Shopping Cart', 'westpace-material'); ?>">
                        <span class="material-icons">shopping_cart</span>
                        <?php if (WC()->cart && WC()->cart->get_cart_contents_count() > 0) : ?>
                            <span class="cart-count" aria-label="<?php echo esc_attr(sprintf(_n('%d item in cart', '%d items in cart', WC()->cart->get_cart_contents_count(), 'westpace-material'), WC()->cart->get_cart_contents_count())); ?>">
                                <?php echo WC()->cart->get_cart_contents_count(); ?>
                            </span>
                        <?php else : ?>
                            <span class="cart-count" style="display: none;">0</span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
                
                <!-- CTA Button -->
                <?php if (!is_front_page()) : ?>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary header-cta">
                        <span class="material-icons">message</span>
                        <?php esc_html_e('Get Quote', 'westpace-material'); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" 
                    aria-controls="primary-menu" 
                    aria-expanded="false"
                    aria-label="<?php esc_attr_e('Toggle Mobile Menu', 'westpace-material'); ?>">
                <span class="material-icons">menu</span>
            </button>
        </div>

        <!-- Search Overlay -->
        <?php if (class_exists('WooCommerce')) : ?>
            <div class="search-overlay" id="search-overlay">
                <div class="search-container">
                    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <label for="search-field" class="sr-only"><?php esc_html_e('Search for:', 'westpace-material'); ?></label>
                        <input type="search" 
                               id="search-field"
                               class="search-field" 
                               placeholder="<?php esc_attr_e('Search products...', 'westpace-material'); ?>" 
                               value="<?php echo get_search_query(); ?>" 
                               name="s"
                               autocomplete="off">
                        <input type="hidden" name="post_type" value="product">
                        <button type="submit" class="search-submit btn btn-primary">
                            <span class="material-icons">search</span>
                            <span class="sr-only"><?php esc_html_e('Search', 'westpace-material'); ?></span>
                        </button>
                    </form>
                    <button class="search-close" aria-label="<?php esc_attr_e('Close Search', 'westpace-material'); ?>">
                        <span class="material-icons">close</span>
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </header>

    <div id="content" class="site-content">
        <main id="main" class="site-main" role="main">

<?php
/**
 * Fallback menu function
 */
function westpace_fallback_menu() {
    echo '<ul class="nav-menu fallback-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'westpace-material') . '</a></li>';
    
    if (class_exists('WooCommerce')) {
        echo '<li><a href="' . esc_url(wc_get_page_permalink('shop')) . '">' . esc_html__('Shop', 'westpace-material') . '</a></li>';
    }
    
    // Get pages
    $pages = get_pages(array('sort_column' => 'menu_order'));
    foreach ($pages as $page) {
        if ($page->post_title !== 'Home') {
            echo '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html($page->post_title) . '</a></li>';
        }
    }
    
    echo '</ul>';
}

// Enhanced search functionality
if (class_exists('WooCommerce')) {
    add_action('wp_footer', function() {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchToggle = document.querySelector('.search-toggle');
            const searchOverlay = document.querySelector('.search-overlay');
            const searchClose = document.querySelector('.search-close');
            const searchField = document.querySelector('.search-field');
            
            if (searchToggle && searchOverlay) {
                searchToggle.addEventListener('click', function() {
                    searchOverlay.classList.add('active');
                    document.body.classList.add('search-active');
                    setTimeout(() => searchField.focus(), 100);
                });
                
                searchClose.addEventListener('click', function() {
                    searchOverlay.classList.remove('active');
                    document.body.classList.remove('search-active');
                });
                
                searchOverlay.addEventListener('click', function(e) {
                    if (e.target === searchOverlay) {
                        searchOverlay.classList.remove('active');
                        document.body.classList.remove('search-active');
                    }
                });
                
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
                        searchOverlay.classList.remove('active');
                        document.body.classList.remove('search-active');
                    }
                });
            }
        });
        </script>
        
        <style>
        .search-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .search-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .search-container {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            width: 90%;
            max-width: 600px;
            position: relative;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .search-form {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .search-field {
            flex: 1;
            padding: 1rem;
            border: 2px solid #E2E8F0;
            border-radius: 0.75rem;
            font-size: 1.125rem;
            transition: border-color 0.15s ease;
        }
        
        .search-field:focus {
            outline: none;
            border-color: #1976D2;
            box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
        }
        
        .search-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            cursor: pointer;
            color: #64748B;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.15s ease;
        }
        
        .search-close:hover {
            background: #F1F5F9;
            color: #1976D2;
        }
        
        .btn-ghost {
            background: transparent;
            border: none;
            color: #64748B;
            padding: 0.75rem;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-ghost:hover {
            background: #F1F5F9;
            color: #1976D2;
        }
        
        .header-cta {
            display: none;
        }
        
        @media (min-width: 1024px) {
            .header-cta {
                display: inline-flex;
            }
        }
        
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
        </style>
        <?php
    });
}
?>