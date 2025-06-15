<?php get_header(); ?>

<main class="site-main front-page">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-background"></div>
        <div class="container">
            <div class="hero-content fade-in-up">
                <h1 class="hero-title">West Pace Apparels</h1>
                <h2 class="hero-subtitle">Premium Garment Manufacturing Since 1998</h2>
                <p class="hero-description">
                    Family-owned Fijian company specializing in school wear, workwear, and winterwear 
                    for Australian and South Pacific markets. Over 24 years of excellence in quality manufacturing.
                </p>
                <div class="hero-actions">
                    <?php if (class_exists("WooCommerce")) : ?>
                    <a href="<?php echo esc_url(wc_get_page_permalink("shop")); ?>" class="material-button primary">
                        <span class="material-icons">shopping_bag</span>
                        <?php esc_html_e("View Products", "westpace-material"); ?>
                    </a>
                    <?php endif; ?>
                    <a href="/contact/" class="material-button outline">
                        <span class="material-icons">message</span>
                        <?php esc_html_e("Get Quote", "westpace-material"); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="services-section">
        <div class="container">
            <h2 class="section-title text-center"><?php esc_html_e("What Makes Us Different", "westpace-material"); ?></h2>
            <div class="services-grid">
                <div class="service-card material-card elevation-2 fade-in-up">
                    <span class="material-icons service-icon">speed</span>
                    <h3><?php esc_html_e("Flexible Short Runs", "westpace-material"); ?></h3>
                    <p><?php esc_html_e("We accommodate both small and large quantity orders with quick turnaround times, ensuring your deadlines are always met.", "westpace-material"); ?></p>
                </div>
                <div class="service-card material-card elevation-2 fade-in-up">
                    <span class="material-icons service-icon">verified_user</span>
                    <h3><?php esc_html_e("Quality Assurance", "westpace-material"); ?></h3>
                    <p><?php esc_html_e("Comprehensive quality control systems and rigorous testing ensure reliable, consistent products that meet international standards.", "westpace-material"); ?></p>
                </div>
                <div class="service-card material-card elevation-2 fade-in-up">
                    <span class="material-icons service-icon">local_shipping</span>
                    <h3><?php esc_html_e("Fast Delivery", "westpace-material"); ?></h3>
                    <p><?php esc_html_e("Prompt service with efficient shipping to Australia, New Zealand, and South Pacific regions.", "westpace-material"); ?></p>
                </div>
            </div>
        </div>
    </section>
    
    <?php if (class_exists("WooCommerce")) : ?>
    <!-- Featured Products Section -->
    <section class="featured-products-section">
        <div class="container">
            <h2 class="section-title text-center"><?php esc_html_e("Featured Products", "westpace-material"); ?></h2>
            <?php
            echo do_shortcode("[products limit=\"8\" columns=\"4\" orderby=\"popularity\" class=\"featured-products\"]");
            ?>
            <div class="text-center mt-xl">
                <a href="<?php echo esc_url(wc_get_page_permalink("shop")); ?>" class="material-button primary">
                    <?php esc_html_e("View All Products", "westpace-material"); ?>
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2><?php esc_html_e("About West Pace Apparels", "westpace-material"); ?></h2>
                    <p><?php esc_html_e("Established in 1998, West Pace Apparels has been a trusted partner in garment manufacturing for over two decades. Our family-owned business combines traditional craftsmanship with modern technology to deliver exceptional quality products.", "westpace-material"); ?></p>
                    <p><?php esc_html_e("We specialize in school uniforms, corporate workwear, and winter apparel, serving clients across Australia, New Zealand, and the South Pacific region.", "westpace-material"); ?></p>
                    <a href="/about/" class="material-button outline">
                        <?php esc_html_e("Learn More", "westpace-material"); ?>
                    </a>
                </div>
                <div class="about-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about-image.jpg" alt="<?php esc_attr_e("West Pace Apparels Factory", "westpace-material"); ?>" class="material-card elevation-2">
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>