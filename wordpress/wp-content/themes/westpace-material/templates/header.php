<?php
/**
 * The header for Westpace Material theme
 * Displays the site header with navigation
 *
 * @package Westpace_Material
 * @version 3.0.0
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'westpace-material'); ?></a>

    <header id="masthead" class="site-header">
        <div class="header-container">
            <div class="site-branding">
                <?php
                // Custom logo or site title
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                    <?php
                    $description = get_bloginfo('description', 'display');
                    if ($description || is_customize_preview()) {
                        ?>
                        <p class="site-description"><?php echo $description; ?></p>
                        <?php
                    }
                }
                ?>
            </div>

            <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e('Primary Menu', 'westpace-material'); ?>">
                <button class="mobile-menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="hamburger">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                    </span>
                    <span class="screen-reader-text"><?php esc_html_e('Menu', 'westpace-material'); ?></span>
                </button>

                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'primary-menu',
                    'container'      => false,
                    'fallback_cb'    => 'westpace_fallback_menu',
                ));
                ?>
            </nav>

            <div class="header-actions">
                <!-- Search Toggle -->
                <button class="search-toggle" aria-controls="header-search" aria-expanded="false">
                    <span class="material-icons-round">search</span>
                    <span class="screen-reader-text"><?php esc_html_e('Search', 'westpace-material'); ?></span>
                </button>

                <?php if (class_exists('WooCommerce')) : ?>
                    <!-- Cart Icon -->
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-toggle">
                        <span class="material-icons-round">shopping_cart</span>
                        <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                        <span class="screen-reader-text"><?php esc_html_e('Cart', 'westpace-material'); ?></span>
                    </a>

                    <!-- Account Icon -->
                    <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="account-toggle">
                        <span class="material-icons-round">person</span>
                        <span class="screen-reader-text"><?php esc_html_e('My Account', 'westpace-material'); ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Search Form Overlay -->
        <div class="header-search" id="header-search">
            <div class="search-container">
                <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="search-input-wrapper">
                        <input type="search" 
                               class="search-field" 
                               placeholder="<?php echo esc_attr_x('Search...', 'placeholder', 'westpace-material'); ?>" 
                               value="<?php echo get_search_query(); ?>" 
                               name="s" 
                               id="header-search-field">
                        <button type="submit" class="search-submit">
                            <span class="material-icons-round">search</span>
                            <span class="screen-reader-text"><?php echo _x('Search', 'submit button', 'westpace-material'); ?></span>
                        </button>
                    </div>
                </form>
                <button class="search-close">
                    <span class="material-icons-round">close</span>
                    <span class="screen-reader-text"><?php esc_html_e('Close Search', 'westpace-material'); ?></span>
                </button>
            </div>
        </div>
    </header>

    <?php
    // Display breadcrumbs on appropriate pages
    if (!is_front_page()) {
        westpace_breadcrumb();
    }
    ?>

    <div id="content" class="site-content">

<?php
/**
 * Fallback menu for when no menu is assigned
 */
function westpace_fallback_menu() {
    echo '<ul class="primary-menu fallback-menu">';
    
    // Home
    echo '<li class="menu-item">';
    echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'westpace-material') . '</a>';
    echo '</li>';
    
    // Sample pages
    $pages = get_pages(array('number' => 5));
    foreach ($pages as $page) {
        echo '<li class="menu-item">';
        echo '<a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html($page->post_title) . '</a>';
        echo '</li>';
    }
    
    // Blog (if not front page)
    if (get_option('show_on_front') === 'page') {
        echo '<li class="menu-item">';
        echo '<a href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '">' . esc_html__('Blog', 'westpace-material') . '</a>';
        echo '</li>';
    }
    
    // WooCommerce pages
    if (class_exists('WooCommerce')) {
        echo '<li class="menu-item">';
        echo '<a href="' . esc_url(wc_get_page_permalink('shop')) . '">' . esc_html__('Shop', 'westpace-material') . '</a>';
        echo '</li>';
    }
    
    echo '</ul>';
}
?>