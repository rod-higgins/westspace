<?php
/**
 * The template for displaying the footer
 * Contains the closing of the #content div and all content after
 *
 * @package Westpace_Material
 * @version 3.0.0
 */
?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="footer-main">
            <div class="container">
                <div class="footer-widgets-grid">
                    
                    <!-- Company Info Widget Area -->
                    <div class="footer-widget footer-company-info">
                        <h3 class="footer-widget-title"><?php bloginfo('name'); ?></h3>
                        <div class="company-description">
                            <?php 
                            $footer_description = get_theme_mod('footer_description', __('Premium garment manufacturing with over 24 years of excellence. Serving Australia, New Zealand, and the South Pacific.', 'westpace-material'));
                            echo esc_html($footer_description);
                            ?>
                        </div>
                        
                        <div class="company-contact">
                            <?php 
                            $footer_phone = get_theme_mod('footer_phone', '+679123456');
                            $footer_phone_display = get_theme_mod('footer_phone_display', '+679 123 456');
                            $footer_email = get_theme_mod('footer_email', 'info@westpace.com');
                            $footer_address = get_theme_mod('footer_address', 'Suva, Fiji Islands');
                            
                            if ($footer_phone) :
                            ?>
                                <div class="contact-item">
                                    <span class="material-icons-round">phone</span>
                                    <a href="tel:<?php echo esc_attr($footer_phone); ?>"><?php echo esc_html($footer_phone_display); ?></a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($footer_email) : ?>
                                <div class="contact-item">
                                    <span class="material-icons-round">email</span>
                                    <a href="mailto:<?php echo esc_attr($footer_email); ?>"><?php echo esc_html($footer_email); ?></a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($footer_address) : ?>
                                <div class="contact-item">
                                    <span class="material-icons-round">location_on</span>
                                    <span><?php echo esc_html($footer_address); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php westpace_get_social_links(); ?>
                    </div>

                    <!-- Footer Widget Area 1 -->
                    <?php if (is_active_sidebar('footer-widget-1')) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar('footer-widget-1'); ?>
                        </div>
                    <?php else : ?>
                        <!-- Quick Links -->
                        <div class="footer-widget">
                            <h3 class="footer-widget-title"><?php esc_html_e('Quick Links', 'westpace-material'); ?></h3>
                            <ul class="footer-menu">
                                <li><a href="<?php echo esc_url(home_url('/about')); ?>"><?php esc_html_e('About Us', 'westpace-material'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/services')); ?>"><?php esc_html_e('Services', 'westpace-material'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><?php esc_html_e('Contact', 'westpace-material'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/blog')); ?>"><?php esc_html_e('Blog', 'westpace-material'); ?></a></li>
                                <?php if (class_exists('WooCommerce')) : ?>
                                    <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"><?php esc_html_e('Shop', 'westpace-material'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Footer Widget Area 2 -->
                    <?php if (is_active_sidebar('footer-widget-2')) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar('footer-widget-2'); ?>
                        </div>
                    <?php else : ?>
                        <!-- Services -->
                        <div class="footer-widget">
                            <h3 class="footer-widget-title"><?php esc_html_e('Our Services', 'westpace-material'); ?></h3>
                            <ul class="footer-menu">
                                <li><a href="#"><?php esc_html_e('School Uniforms', 'westpace-material'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Work Wear', 'westpace-material'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Winter Wear', 'westpace-material'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Custom Apparel', 'westpace-material'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Bulk Orders', 'westpace-material'); ?></a></li>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Footer Widget Area 3 -->
                    <?php if (is_active_sidebar('footer-widget-3')) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar('footer-widget-3'); ?>
                        </div>
                    <?php else : ?>
                        <!-- Newsletter -->
                        <div class="footer-widget">
                            <h3 class="footer-widget-title"><?php esc_html_e('Newsletter', 'westpace-material'); ?></h3>
                            <p class="newsletter-description">
                                <?php esc_html_e('Stay updated with our latest products and offers.', 'westpace-material'); ?>
                            </p>
                            <?php westpace_newsletter_form(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <div class="footer-info">
                        <p class="copyright-text">
                            <?php 
                            $copyright = get_theme_mod('footer_copyright', sprintf(__('&copy; %s West Pace Apparels. All rights reserved.', 'westpace-material'), date('Y')));
                            echo wp_kses_post($copyright);
                            ?>
                        </p>
                        <p class="theme-credit">
                            <?php 
                            printf(
                                esc_html__('Powered by %1$s | Theme: %2$s', 'westpace-material'),
                                '<a href="https://wordpress.org/" target="_blank" rel="noopener">WordPress</a>',
                                '<a href="https://westpace.com/" target="_blank" rel="noopener">Westpace Material</a>'
                            );
                            ?>
                        </p>
                    </div>

                    <?php
                    // Footer navigation menu
                    if (has_nav_menu('footer')) {
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'menu_class'     => 'footer-navigation',
                            'container'      => 'nav',
                            'container_class' => 'footer-nav',
                            'depth'          => 1,
                        ));
                    } else {
                        // Fallback footer menu
                        echo '<nav class="footer-nav">';
                        echo '<ul class="footer-navigation">';
                        echo '<li><a href="' . esc_url(home_url('/privacy-policy')) . '">' . esc_html__('Privacy Policy', 'westpace-material') . '</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/terms-of-service')) . '">' . esc_html__('Terms of Service', 'westpace-material') . '</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/contact')) . '">' . esc_html__('Contact', 'westpace-material') . '</a></li>';
                        echo '</ul>';
                        echo '</nav>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<!-- Back to Top Button -->
<button id="back-to-top" class="back-to-top" aria-label="<?php esc_attr_e('Back to top', 'westpace-material'); ?>">
    <span class="material-icons-round">keyboard_arrow_up</span>
</button>

<?php wp_footer(); ?>

<script>
// Enhanced footer functionality
document.addEventListener('DOMContentLoaded', function() {
    // Back to top button
    const backToTopButton = document.getElementById('back-to-top');
    
    if (backToTopButton) {
        // Show/hide back to top button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });
        
        // Smooth scroll to top
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // Newsletter form handling
    const newsletterForms = document.querySelectorAll('.newsletter-form');
    
    newsletterForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            formData.append('action', 'westpace_newsletter');
            formData.append('nonce', westpaceData.nonce);
            
            const messageElement = form.querySelector('.newsletter-message');
            const submitButton = form.querySelector('button[type="submit"]');
            
            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="material-icons-round">hourglass_empty</span> ' + westpaceData.strings.loading;
            
            fetch(westpaceData.ajaxUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageElement.textContent = data.data;
                    messageElement.className = 'newsletter-message success';
                    form.reset();
                } else {
                    messageElement.textContent = data.data;
                    messageElement.className = 'newsletter-message error';
                }
            })
            .catch(error => {
                messageElement.textContent = westpaceData.strings.newsletterError;
                messageElement.className = 'newsletter-message error';
            })
            .finally(() => {
                // Reset button state
                submitButton.disabled = false;
                submitButton.innerHTML = '<span class="material-icons-round">mail</span> Subscribe';
            });
        });
    });
    
    // Contact form handling
    const contactForms = document.querySelectorAll('.contact-form');
    
    contactForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            formData.append('action', 'westpace_contact_form');
            formData.append('nonce', westpaceData.nonce);
            
            const messageElement = form.querySelector('.contact-message');
            const submitButton = form.querySelector('button[type="submit"]');
            
            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="material-icons-round">hourglass_empty</span> ' + westpaceData.strings.loading;
            
            fetch(westpaceData.ajaxUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageElement.textContent = data.data;
                    messageElement.className = 'contact-message success';
                    form.reset();
                } else {
                    messageElement.textContent = data.data;
                    messageElement.className = 'contact-message error';
                }
            })
            .catch(error => {
                messageElement.textContent = 'Sorry, there was an error sending your message. Please try again.';
                messageElement.className = 'contact-message error';
            })
            .finally(() => {
                // Reset button state
                submitButton.disabled = false;
                submitButton.innerHTML = '<span class="material-icons-round">send</span> Send Message';
            });
        });
    });

    // Footer widget animations on scroll
    const footerWidgets = document.querySelectorAll('.footer-widget');
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const footerObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    footerWidgets.forEach(function(widget) {
        footerObserver.observe(widget);
    });
});
</script>

</body>
</html>