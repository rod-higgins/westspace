<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo("charset"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <header id="masthead" class="site-header">
        <div class="header-container">
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <div class="site-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url(home_url("/")); ?>" rel="home" class="site-logo">
                            <?php bloginfo("name"); ?>
                        </a>
                    </h1>
                <?php endif; ?>
            </div>

            <nav id="site-navigation" class="main-navigation">
                <?php
                wp_nav_menu(array(
                    "theme_location" => "primary",
                    "menu_id" => "primary-menu",
                    "container" => false,
                    "fallback_cb" => false,
                ));
                ?>
                
                <?php if (class_exists("WooCommerce")) : ?>
                <div class="header-cart">
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-link material-button outline">
                        <span class="material-icons">shopping_cart</span>
                        <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                    </a>
                </div>
                <?php endif; ?>
            </nav>

            <button class="mobile-menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                <span class="material-icons">menu</span>
            </button>
        </div>
    </header>

    <div id="content" class="site-content">