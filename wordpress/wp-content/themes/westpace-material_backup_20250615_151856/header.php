<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#1565C0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Roboto+Slab:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <style>
        /* Inline critical CSS for immediate effect */
        body { 
            font-family: 'Roboto', sans-serif !important; 
            background: #fafafa !important; 
            margin: 0 !important; 
            padding: 0 !important; 
        }
        .hero-section { 
            background: linear-gradient(135deg, #1565C0 0%, #42A5F5 50%, #00BCD4 100%) !important; 
            color: white !important; 
            padding: 120px 0 80px 0 !important; 
            text-align: center !important; 
            min-height: 600px !important; 
            display: flex !important; 
            align-items: center !important; 
        }
        .btn { 
            background: linear-gradient(135deg, #1565C0 0%, #42A5F5 100%) !important; 
            color: white !important; 
            padding: 16px 32px !important; 
            border-radius: 8px !important; 
            text-decoration: none !important; 
            display: inline-flex !important; 
            align-items: center !important; 
            text-transform: uppercase !important; 
            font-weight: 500 !important; 
            box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23) !important; 
        }
        .service-card { 
            background: white !important; 
            padding: 48px 32px !important; 
            border-radius: 16px !important; 
            box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23) !important; 
            transition: all 0.3s ease !important; 
        }
    </style>
    
    <?php wp_head(); ?>
</head>
<body <?php body_class('westpace-material-theme'); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <header id="masthead" class="site-header" style="background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px); box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23); position: fixed; top: 0; left: 0; right: 0; z-index: 1000; padding: 16px 0;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 24px; display: flex; align-items: center; justify-content: space-between;">
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <h1 class="site-title" style="margin: 0; font-size: 1.5rem; font-weight: 700; color: #1565C0;">
                        <a href="<?php echo esc_url(home_url('/')); ?>" style="text-decoration: none; color: inherit;">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                <?php endif; ?>
            </div>
            
            <nav class="main-navigation">
                <?php wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class' => 'primary-menu',
                    'fallback_cb' => false,
                )); ?>
            </nav>
            
            <div class="header-actions">
                <?php if (class_exists('WooCommerce')) : ?>
                <div class="header-cart">
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" style="display: flex; align-items: center; text-decoration: none; color: #1565C0; padding: 12px; border-radius: 50px;">
                        <span class="material-icons">shopping_cart</span>
                        <?php if (WC()->cart->get_cart_contents_count() > 0) : ?>
                        <span class="cart-count" style="background: #FF6F00; color: white; border-radius: 50%; font-size: 12px; font-weight: 700; min-width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; margin-left: 8px;"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                        <?php endif; ?>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </header>
    
    <div id="content" class="site-content" style="padding-top: 80px;">
