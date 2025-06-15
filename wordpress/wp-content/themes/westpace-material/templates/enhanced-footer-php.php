<?php
/**
 * Enhanced Footer Template for Westpace Material Theme
 * Modern, comprehensive footer with multiple sections
 */
?>
        </main><!-- #main -->
    </div><!-- #content -->

    <!-- Newsletter Section -->
    <section class="newsletter-section" id="newsletter">
        <div class="container">
            <div class="newsletter-content">
                <div class="newsletter-text">
                    <h3><?php esc_html_e('Stay Updated', 'westpace-material'); ?></h3>
                    <p><?php esc_html_e('Get the latest updates on new products, industry insights, and exclusive offers.', 'westpace-material'); ?></p>
                </div>
                
                <form class="newsletter-form" action="#" method="post" id="newsletter-form">
                    <div class="form-group">
                        <label for="newsletter-email" class="sr-only"><?php esc_html_e('Email Address', 'westpace-material'); ?></label>
                        <input type="email" 
                               id="newsletter-email" 
                               name="email" 
                               placeholder="<?php esc_attr_e('Enter your email address', 'westpace-material'); ?>" 
                               required
                               class="newsletter-input">
                        <button type="submit" class="btn btn-accent">
                            <span class="material-icons">send</span>
                            <?php esc_html_e('Subscribe', 'westpace-material'); ?>
                        </button>
                    </div>
                    <p class="newsletter-privacy">
                        <?php esc_html_e('We respect your privacy. Unsubscribe at any time.', 'westpace-material'); ?>
                    </p>
                </form>
            </div>
        </div>
    </section>

    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="footer-main">
            <div class="container">
                <div class="footer-widgets-grid">
                    <!-- Company Info -->
                    <div class="footer-widget footer-about">
                        <div class="footer-logo">
                            <?php if (has_custom_logo()) : ?>
                                <?php the_custom_logo(); ?>
                            <?php else : ?>
                                <h3 class="footer-site-title"><?php bloginfo('name'); ?></h3>
                            <?php endif; ?>
                        </div>
                        
                        <p class="footer-description">
                            <?php echo esc_html(get_theme_mod('footer_description', __('Premium garment manufacturing with over 24 years of excellence. Serving Australia, New Zealand, and the South Pacific.', 'westpace-material'))); ?>
                        </p>
                        
                        <div class="footer-contact-info">
                            <div class="contact-item">
                                <span class="material-icons">location_on</span>
                                <span><?php echo esc_html(get_theme_mod('footer_address', __('Suva, Fiji Islands', 'westpace-material'))); ?></span>
                            </div>
                            <div class="contact-item">
                                <span class="material-icons">phone</span>
                                <a href="tel:<?php echo esc_attr(get_theme_mod('footer_phone', '+679123456')); ?>">
                                    <?php echo esc_html(get_theme_mod('footer_phone_display', '+679 123 456')); ?>
                                </a>
                            </div>
                            <div class="contact-item">
                                <span class="material-icons">email</span>
                                <a href="mailto:<?php echo esc_attr(get_theme_mod('footer_email', 'info@westpace.com')); ?>">
                                    <?php echo esc_html(get_theme_mod('footer_email', 'info@westpace.com')); ?>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Social Links -->
                        <div class="footer-social">
                            <?php if (get_theme_mod('social_facebook')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('social_facebook')); ?>" class="social-link" aria-label="<?php esc_attr_e('Follow us on Facebook', 'westpace-material'); ?>" target="_blank" rel="noopener">
                                    <span class="fab fa-facebook-f"></span>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('social_instagram')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('social_instagram')); ?>" class="social-link" aria-label="<?php esc_attr_e('Follow us on Instagram', 'westpace-material'); ?>" target="_blank" rel="noopener">
                                    <span class="fab fa-instagram"></span>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('social_linkedin')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('social_linkedin')); ?>" class="social-link" aria-label="<?php esc_attr_e('Connect with us on LinkedIn', 'westpace-material'); ?>" target="_blank" rel="noopener">
                                    <span class="fab fa-linkedin-in"></span>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('social_twitter')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('social_twitter')); ?>" class="social-link" aria-label="<?php esc_attr_e('Follow us on Twitter', 'westpace-material'); ?>" target="_blank" rel="noopener">
                                    <span class="fab fa-twitter"></span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <?php if (is_active_sidebar('footer-widget-1')) : ?>
                        <div class="footer-widget">
                            <?php dynamic_sidebar('footer-widget-1'); ?>
                        </div>
                    <?php else : ?>
                        <div class="footer-widget">
                            <h4 class="footer-widget-title"><?php esc_html_e('Quick Links', 'westpace-material'); ?></h4>
                            <ul class="footer-menu">
                                <li><a href="<?php echo esc_url(home_url('/about')); ?>"><?php esc_html_e('About Us', 'westpace-material'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/services')); ?>"><?php esc_html_e('Our Services', 'westpace-material'); ?></a></li>
                                <?php if (class_exists('WooCommerce')) : ?>
                                    <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"><?php esc_html_e('Products', 'westpace-material'); ?></a></li>
                                <?php endif; ?>
                                <li><a href="<?php echo esc_url(home_url('/blog')); ?>"><?php esc_html_e('Blog', 'westpace-material'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><?php esc_html_e('Contact', 'westpace-material'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/quote')); ?>"><?php esc_html_e('Get Quote', 'westpace-material'); ?></a></li>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Product Categories -->
                    <?php if (is_active_sidebar('footer-widget-2')) : ?>
                        <div class="footer-widget">
                            <?php dynamic_sidebar('footer-widget-2'); ?>
                        </div>
                    <?php elseif (class_exists('WooCommerce')) : ?>
                        <div class="footer-widget">
                            <h4 class="footer-widget-title"><?php esc_html_e('Product Categories', 'westpace-material'); ?></h4>
                            <?php
                            $product_categories = get_terms(array(
                                'taxonomy' => 'product_cat',
                                'hide_empty' => true,
                                'number' => 6,
                                'orderby' => 'count',
                                'order' => 'DESC'
                            ));
                            
                            if (!empty($product_categories) && !is_wp_error($product_categories)) :
                            ?>
                                <ul class="footer-menu">
                                    <?php foreach ($product_categories as $category) : ?>
                                        <li>
                                            <a href="<?php echo esc_url(get_term_link($category)); ?>">
                                                <?php echo esc_html($category->name); ?>
                                                <span class="category-count">(<?php echo $category->count; ?>)</span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Customer Support -->
                    <?php if (is_active_sidebar('footer-widget-3')) : ?>
                        <div class="footer-widget">
                            <?php dynamic_sidebar('footer-widget-3'); ?>
                        </div>
                    <?php else : ?>
                        <div class="footer-widget">
                            <h4 class="footer-widget-title"><?php esc_html_e('Customer Support', 'westpace-material'); ?></h4>
                            <ul class="footer-menu">
                                <li><a href="<?php echo esc_url(home_url('/help')); ?>"><?php esc_html_e('Help Center', 'westpace-material'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/shipping')); ?>"><?php esc_html_e('Shipping Info', 'westpace-material'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/returns')); ?>"><?php esc_html_e('Returns & Exchanges', 'westpace-material'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/size-guide')); ?>"><?php esc_html_e('Size Guide', 'westpace-material'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/faq')); ?>"><?php esc_html_e('FAQ', 'westpace-material'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/track-order')); ?>"><?php esc_html_e('Track Your Order', 'westpace-material'); ?></a></li>
                            </ul>
                            
                            <div class="support-hours">
                                <h5><?php esc_html_e('Support Hours', 'westpace-material'); ?></h5>
                                <p><?php esc_html_e('Monday - Friday: 8:00 AM - 6:00 PM (FJT)', 'westpace-material'); ?></p>
                                <p><?php esc_html_e('Saturday: 9:00 AM - 4:00 PM (FJT)', 'westpace-material'); ?></p>
                      