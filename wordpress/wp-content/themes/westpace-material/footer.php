    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="footer-widgets">
            <div class="container">
                <div class="footer-widgets-grid">
                    <?php for ($i = 1; $i <= 4; $i++) : ?>
                        <?php if (is_active_sidebar("footer-widget-$i")) : ?>
                            <div class="footer-widget">
                                <?php dynamic_sidebar("footer-widget-$i"); ?>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <div class="footer-info">
                        <p>&copy; <?php echo date("Y"); ?> <?php bloginfo("name"); ?>. <?php esc_html_e("All rights reserved.", "westpace-material"); ?></p>
                        <p><?php esc_html_e("Premium Garment Manufacturing Since 1998", "westpace-material"); ?></p>
                    </div>
                    
                    <div class="footer-social">
                        <a href="#" class="social-link" aria-label="Facebook">
                            <span class="material-icons">facebook</span>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter">
                            <span class="material-icons">share</span>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <span class="material-icons">camera_alt</span>
                        </a>
                        <a href="#" class="social-link" aria-label="LinkedIn">
                            <span class="material-icons">business</span>
                        </a>
                    </div>
                    
                    <?php
                    wp_nav_menu(array(
                        "theme_location" => "footer",
                        "menu_id" => "footer-menu",
                        "container" => "nav",
                        "container_class" => "footer-navigation",
                        "fallback_cb" => false,
                    ));
                    ?>
                </div>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>