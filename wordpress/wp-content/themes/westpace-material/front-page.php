<?php get_header(); ?>

<main class="site-main front-page">
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1>West Pace Apparels</h1>
                <p class="hero-subtitle">Premium Garment Manufacturing Since 1998</p>
                <p>Family-owned Fijian company specializing in school wear, workwear, and winterwear for Australian and South Pacific markets.</p>
                <div class="hero-actions">
                    <?php if (class_exists('WooCommerce')) : ?>
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn-primary">View Products</a>
                    <?php endif; ?>
                    <a href="/contact/" class="btn btn-secondary">Get Quote</a>
                </div>
            </div>
        </div>
    </section>
    
    <section class="services-section">
        <div class="container">
            <h2>What We Offer</h2>
            <div class="services-grid">
                <div class="service-card">
                    <span class="material-icons">speed</span>
                    <h3>Flexible Short Runs</h3>
                    <p>Accommodate both small and large quantity orders with quick turnaround times.</p>
                </div>
                <div class="service-card">
                    <span class="material-icons">verified</span>
                    <h3>Quality Control</h3>
                    <p>Comprehensive quality assurance systems ensure reliable, consistent products.</p>
                </div>
                <div class="service-card">
                    <span class="material-icons">local_shipping</span>
                    <h3>Fast Delivery</h3>
                    <p>Prompt service with efficient shipping to Australia and South Pacific regions.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>