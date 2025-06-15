/**
 * Westpace Material Theme JavaScript
 * Enhanced functionality for Material Design WordPress theme
 */

(function($) {
    'use strict';

    // Theme namespace
    const WestpaceTheme = {
        
        init: function() {
            this.bindEvents();
            this.initMobileMenu();
            this.initSmoothScroll();
            this.initScrollToTop();
            this.initHeaderScroll();
            this.initSearchToggle();
            this.initMaterialEffects();
            this.initLazyLoading();
            this.initFormHandlers();
            this.initWooCommerce();
        },

        bindEvents: function() {
            $(document).ready(this.onDocumentReady.bind(this));
            $(window).on('load', this.onWindowLoad.bind(this));
            $(window).on('resize', this.onWindowResize.bind(this));
            $(window).on('scroll', this.throttle(this.onWindowScroll.bind(this), 16));
        },

        onDocumentReady: function() {
            this.init();
            $('body').addClass('js-loaded');
        },

        onWindowLoad: function() {
            $('body').removeClass('loading').addClass('loaded');
            this.initAnimations();
        },

        onWindowResize: function() {
            this.handleResponsiveMenu();
        },

        onWindowScroll: function() {
            this.handleHeaderScroll();
            this.handleScrollToTop();
            this.handleScrollAnimations();
        },

        /**
         * Mobile Menu
         */
        initMobileMenu: function() {
            const $menuToggle = $('.mobile-menu-toggle');
            const $navigation = $('.main-navigation');
            const $body = $('body');
            
            // Toggle mobile menu
            $menuToggle.on('click', function(e) {
                e.preventDefault();
                const isOpen = $body.hasClass('mobile-menu-open');
                
                if (isOpen) {
                    $body.removeClass('mobile-menu-open');
                    $navigation.removeClass('active');
                    $menuToggle.attr('aria-expanded', 'false');
                } else {
                    $body.addClass('mobile-menu-open');
                    $navigation.addClass('active');
                    $menuToggle.attr('aria-expanded', 'true');
                }
            });

            // Close mobile menu on overlay click
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.main-navigation, .mobile-menu-toggle').length) {
                    $body.removeClass('mobile-menu-open');
                    $navigation.removeClass('active');
                    $menuToggle.attr('aria-expanded', 'false');
                }
            });

            // Handle submenu toggles
            $('.menu-item-has-children > a').on('click', function(e) {
                if ($(window).width() <= 768) {
                    e.preventDefault();
                    const $parent = $(this).parent();
                    const $submenu = $parent.find('.sub-menu').first();
                    
                    $parent.toggleClass('submenu-open');
                    $submenu.slideToggle(250);
                }
            });

            // Close menu on escape key
            $(document).on('keydown', function(e) {
                if (e.keyCode === 27 && $body.hasClass('mobile-menu-open')) {
                    $body.removeClass('mobile-menu-open');
                    $navigation.removeClass('active');
                    $menuToggle.attr('aria-expanded', 'false');
                }
            });
        },

        handleResponsiveMenu: function() {
            const windowWidth = $(window).width();
            if (windowWidth > 768) {
                $('body').removeClass('mobile-menu-open');
                $('.main-navigation').removeClass('active');
                $('.mobile-menu-toggle').attr('aria-expanded', 'false');
            }
        },

        /**
         * Smooth Scrolling
         */
        initSmoothScroll: function() {
            $('a[href*="#"]:not([href="#"])').on('click', function(e) {
                const target = $(this.getAttribute('href'));
                if (target.length) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80
                    }, 600, 'swing');
                }
            });
        },

        /**
         * Scroll to Top Button
         */
        initScrollToTop: function() {
            // Create scroll to top button if it doesn't exist
            if (!$('.scroll-to-top').length) {
                $('body').append(`
                    <button class="scroll-to-top" aria-label="Scroll to top" style="display: none;">
                        <span class="material-icons-round">keyboard_arrow_up</span>
                    </button>
                `);
            }

            $('.scroll-to-top').on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({ scrollTop: 0 }, 600);
            });
        },

        handleScrollToTop: function() {
            const $scrollBtn = $('.scroll-to-top');
            if ($(window).scrollTop() > 300) {
                $scrollBtn.fadeIn();
            } else {
                $scrollBtn.fadeOut();
            }
        },

        /**
         * Header Scroll Effects
         */
        initHeaderScroll: function() {
            this.lastScrollTop = 0;
        },

        handleHeaderScroll: function() {
            const $header = $('.site-header');
            const scrollTop = $(window).scrollTop();
            
            // Add/remove scrolled class
            if (scrollTop > 50) {
                $header.addClass('header-scrolled');
            } else {
                $header.removeClass('header-scrolled');
            }

            // Hide/show header on scroll (optional)
            if (scrollTop > this.lastScrollTop && scrollTop > 100) {
                $header.addClass('header-hidden');
            } else {
                $header.removeClass('header-hidden');
            }
            
            this.lastScrollTop = scrollTop;
        },

        /**
         * Search Toggle
         */
        initSearchToggle: function() {
            const $searchToggle = $('.search-toggle');
            const $headerSearch = $('.header-search');
            const $searchClose = $('.search-close');
            const $searchField = $('#header-search-field');

            $searchToggle.on('click', function(e) {
                e.preventDefault();
                $headerSearch.addClass('active');
                $searchField.focus();
                $('body').addClass('search-open');
            });

            $searchClose.on('click', function(e) {
                e.preventDefault();
                $headerSearch.removeClass('active');
                $('body').removeClass('search-open');
            });

            // Close search on escape key
            $(document).on('keydown', function(e) {
                if (e.keyCode === 27 && $headerSearch.hasClass('active')) {
                    $headerSearch.removeClass('active');
                    $('body').removeClass('search-open');
                }
            });

            // Close search when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.header-search, .search-toggle').length) {
                    $headerSearch.removeClass('active');
                    $('body').removeClass('search-open');
                }
            });
        },

        /**
         * Material Design Effects
         */
        initMaterialEffects: function() {
            // Ripple effect for buttons
            $('.btn, .material-button').on('click', function(e) {
                const $button = $(this);
                const ripple = $('<span class="ripple"></span>');
                const offset = $button.offset();
                const x = e.pageX - offset.left;
                const y = e.pageY - offset.top;

                ripple.css({
                    top: y,
                    left: x,
                });

                $button.append(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });

            // Card hover effects
            $('.material-card').on('mouseenter', function() {
                $(this).addClass('hovered');
            }).on('mouseleave', function() {
                $(this).removeClass('hovered');
            });
        },

        /**
         * Lazy Loading
         */
        initLazyLoading: function() {
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            img.classList.add('loaded');
                            observer.unobserve(img);
                        }
                    });
                });

                document.querySelectorAll('img[data-src]').forEach(img => {
                    imageObserver.observe(img);
                });
            }
        },

        /**
         * Form Handlers
         */
        initFormHandlers: function() {
            // Contact Form
            $('.contact-form').on('submit', this.handleContactForm);
            
            // Newsletter Form
            $('.newsletter-form').on('submit', this.handleNewsletterForm);
            
            // Enhanced form validation
            this.initFormValidation();
        },

        handleContactForm: function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');
            const $message = $form.find('.contact-message');
            const formData = new FormData(this);
            
            formData.append('action', 'westpace_contact_form');
            formData.append('nonce', westpaceData.nonce);

            $submitBtn.prop('disabled', true).addClass('loading');
            $message.removeClass('success error').text('');

            $.ajax({
                url: westpaceData.ajaxUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $message.addClass('success').text(response.data);
                        $form[0].reset();
                        WestpaceTheme.showNotification(response.data, 'success');
                    } else {
                        $message.addClass('error').text(response.data);
                        WestpaceTheme.showNotification(response.data, 'error');
                    }
                },
                error: function() {
                    const errorMsg = westpaceData.strings.cartError || 'An error occurred. Please try again.';
                    $message.addClass('error').text(errorMsg);
                    WestpaceTheme.showNotification(errorMsg, 'error');
                },
                complete: function() {
                    $submitBtn.prop('disabled', false).removeClass('loading');
                }
            });
        },

        handleNewsletterForm: function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');
            const $message = $form.find('.newsletter-message');
            const formData = new FormData(this);
            
            formData.append('action', 'westpace_newsletter');
            formData.append('nonce', westpaceData.nonce);

            $submitBtn.prop('disabled', true).addClass('loading');
            $message.removeClass('success error').text('');

            $.ajax({
                url: westpaceData.ajaxUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $message.addClass('success').text(response.data);
                        $form[0].reset();
                        WestpaceTheme.showNotification(response.data, 'success');
                    } else {
                        $message.addClass('error').text(response.data);
                    }
                },
                error: function() {
                    const errorMsg = westpaceData.strings.newsletterError || 'Subscription failed. Please try again.';
                    $message.addClass('error').text(errorMsg);
                },
                complete: function() {
                    $submitBtn.prop('disabled', false).removeClass('loading');
                }
            });
        },

        initFormValidation: function() {
            // Real-time validation
            $('input[required], textarea[required]').on('blur', function() {
                const $field = $(this);
                const value = $field.val().trim();
                
                if (value === '') {
                    $field.addClass('error');
                } else {
                    $field.removeClass('error');
                }
                
                // Email validation
                if ($field.attr('type') === 'email' && value !== '') {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(value)) {
                        $field.addClass('error');
                    } else {
                        $field.removeClass('error');
                    }
                }
            });
        },

        /**
         * WooCommerce
         */
        initWooCommerce: function() {
            if (typeof wc_add_to_cart_params === "undefined") return;
            
            // Enhanced add to cart
            $(document).on("click", ".ajax_add_to_cart", function(e) {
                const $button = $(this);
                $button.addClass("loading");
            });
            
            // Update cart count after AJAX
            $(document.body).on("added_to_cart", function(event, fragments, cart_hash, $button) {
                $button.removeClass("loading").addClass("added");
                WestpaceTheme.showNotification(westpaceData.strings.addedToCart, "success");
                
                setTimeout(() => {
                    $button.removeClass("added");
                }, 2000);
                
                // Update cart count in header
                if (fragments && fragments['.cart-count']) {
                    $('.cart-count').html($(fragments['.cart-count']).html());
                }
            });

            // Quantity inputs
            this.initQuantityInputs();
        },

        initQuantityInputs: function() {
            // Add quantity buttons if they don't exist
            $('.quantity input.qty').each(function() {
                const $input = $(this);
                if (!$input.siblings('.qty-btn').length) {
                    $input.before('<button type="button" class="qty-btn qty-minus">-</button>');
                    $input.after('<button type="button" class="qty-btn qty-plus">+</button>');
                }
            });

            $(document).on('click', '.qty-btn', function(e) {
                e.preventDefault();
                const $btn = $(this);
                const $input = $btn.siblings('.qty');
                const currentVal = parseInt($input.val()) || 0;
                const min = parseInt($input.attr('min')) || 0;
                const max = parseInt($input.attr('max')) || 999;
                
                let newVal = currentVal;
                if ($btn.hasClass('qty-plus')) {
                    newVal = Math.min(max, currentVal + 1);
                } else {
                    newVal = Math.max(min, currentVal - 1);
                }
                
                $input.val(newVal).trigger('change');
            });
        },

        /**
         * Animations
         */
        initAnimations: function() {
            if ('IntersectionObserver' in window) {
                const animationObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animate-in');
                        }
                    });
                }, { threshold: 0.1 });

                document.querySelectorAll('.animate-on-scroll').forEach(el => {
                    animationObserver.observe(el);
                });
            }
        },

        handleScrollAnimations: function() {
            // Add scroll-based animations here
            const scrollTop = $(window).scrollTop();
            const windowHeight = $(window).height();
            
            $('.parallax').each(function() {
                const $el = $(this);
                const elementTop = $el.offset().top;
                const rate = (scrollTop - elementTop) * 0.5;
                $el.css('transform', `translateY(${rate}px)`);
            });
        },

        /**
         * Notifications
         */
        showNotification: function(message, type = 'info', duration = 5000) {
            // Create notifications container if it doesn't exist
            if (!$('.notifications-container').length) {
                $('body').append('<div class="notifications-container"></div>');
            }

            const notificationId = 'notification-' + Date.now();
            const iconMap = {
                'success': 'check_circle',
                'error': 'error',
                'warning': 'warning',
                'info': 'info'
            };

            const notification = $(`
                <div class="notification notification-${type}" id="${notificationId}">
                    <span class="material-icons-round">${iconMap[type] || 'info'}</span>
                    <span class="notification-message">${message}</span>
                    <button class="notification-close" aria-label="Close notification">
                        <span class="material-icons-round">close</span>
                    </button>
                </div>
            `);

            $('.notifications-container').append(notification);

            // Auto-remove notification
            setTimeout(() => {
                notification.addClass('fade-out');
                setTimeout(() => notification.remove(), 300);
            }, duration);

            // Manual close
            notification.find('.notification-close').on('click', function() {
                notification.addClass('fade-out');
                setTimeout(() => notification.remove(), 300);
            });
        },

        /**
         * Utility Functions
         */
        debounce: function(func, wait, immediate) {
            let timeout;
            return function executedFunction() {
                const context = this;
                const args = arguments;
                const later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                const callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        },

        throttle: function(func, delay) {
            let timeoutId;
            let lastExecTime = 0;
            return function() {
                const context = this;
                const args = arguments;
                const currentTime = Date.now();
                
                if (currentTime - lastExecTime > delay) {
                    func.apply(context, args);
                    lastExecTime = currentTime;
                } else {
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(function() {
                        func.apply(context, args);
                        lastExecTime = Date.now();
                    }, delay - (currentTime - lastExecTime));
                }
            };
        }
    };

    // Initialize theme
    WestpaceTheme.init();

    // Make available globally
    window.WestpaceTheme = WestpaceTheme;

})(jQuery);

// CSS for JavaScript-enhanced features
const enhancedStyles = `
<style id="westpace-enhanced-styles">
/* Mobile Menu Styles */
.mobile-menu-open {
    overflow: hidden;
}

.mobile-menu-open .main-navigation {
    transform: translateX(0);
}

@media (max-width: 768px) {
    .main-navigation {
        position: fixed;
        top: 0;
        right: -100%;
        width: 100%;
        max-width: 320px;
        height: 100vh;
        background: white;
        z-index: 9999;
        transition: transform 0.3s ease;
        box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
        padding: var(--space-6);
    }
    
    .main-navigation.active {
        transform: translateX(0);
    }
    
    .main-navigation .primary-menu {
        flex-direction: column;
        gap: 0;
    }
    
    .main-navigation .menu-item {
        border-bottom: 1px solid var(--gray-100);
    }
    
    .main-navigation .menu-item a {
        padding: var(--space-4) 0;
        width: 100%;
        justify-content: space-between;
    }
    
    .main-navigation .sub-menu {
        position: static;
        opacity: 1;
        visibility: visible;
        transform: none;
        box-shadow: none;
        border: none;
        background: var(--gray-50);
        margin: var(--space-2) 0 0 var(--space-4);
        padding: 0;
        display: none;
    }
    
    .menu-item.submenu-open .sub-menu {
        display: block;
    }
}

/* Header Search Styles */
.header-search {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border-top: 1px solid var(--gray-200);
    box-shadow: var(--shadow-xl);
    padding: var(--space-6);
    transform: translateY(-20px);
    opacity: 0;
    visibility: hidden;
    transition: all var(--transition-normal);
    z-index: 999;
}

.header-search.active {
    transform: translateY(0);
    opacity: 1;
    visibility: visible;
}

.search-container {
    max-width: 600px;
    margin: 0 auto;
    position: relative;
}

.search-input-wrapper {
    display: flex;
    align-items: center;
    background: white;
    border: 2px solid var(--gray-300);
    border-radius: var(--radius-lg);
    transition: border-color var(--transition-fast);
}

.search-input-wrapper:focus-within {
    border-color: var(--primary-600);
}

.search-field {
    flex: 1;
    padding: var(--space-4) var(--space-6);
    border: none;
    font-size: var(--text-lg);
    outline: none;
    background: transparent;
}

.search-submit {
    padding: var(--space-4);
    background: var(--primary-600);
    color: white;
    border: none;
    border-radius: 0 var(--radius-lg) var(--radius-lg) 0;
    cursor: pointer;
    transition: background-color var(--transition-fast);
}

.search-submit:hover {
    background: var(--primary-700);
}

.search-close {
    position: absolute;
    top: -10px;
    right: -10px;
    background: var(--gray-100);
    border: none;
    border-radius: var(--radius-full);
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all var(--transition-fast);
}

.search-close:hover {
    background: var(--gray-200);
    transform: scale(1.1);
}

/* Scroll to Top Button */
.scroll-to-top {
    position: fixed;
    bottom: var(--space-6);
    right: var(--space-6);
    background: var(--primary-600);
    color: white;
    border: none;
    border-radius: var(--radius-full);
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: var(--shadow-lg);
    transition: all var(--transition-normal);
    z-index: 1000;
}

.scroll-to-top:hover {
    background: var(--primary-700);
    transform: scale(1.1);
}

/* Header Scroll Effects */
.site-header {
    transition: all var(--transition-normal);
}

.site-header.header-scrolled {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    box-shadow: var(--shadow-md);
}

.site-header.header-hidden {
    transform: translateY(-100%);
}

/* Material Effects */
.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.6);
    pointer-events: none;
    animation: ripple-animation 0.6s linear;
}

@keyframes ripple-animation {
    to {
        transform: scale(4);
        opacity: 0;
    }
}

.material-card.hovered {
    transform: translateY(-4px);
    box-shadow: var(--shadow-xl);
}

/* Loading States */
.loading {
    position: relative;
    pointer-events: none;
    opacity: 0.7;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid transparent;
    border-top-color: currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Notifications */
.notifications-container {
    position: fixed;
    top: var(--space-6);
    right: var(--space-6);
    z-index: 9999;
    pointer-events: none;
}

.notification {
    pointer-events: all;
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-xl);
    border: 1px solid var(--gray-200);
    padding: var(--space-4);
    margin-bottom: var(--space-3);
    display: flex;
    align-items: center;
    gap: var(--space-3);
    max-width: 400px;
    animation: slideInRight 0.3s ease;
}

.notification-success {
    border-left: 4px solid var(--success-500);
}

.notification-error {
    border-left: 4px solid var(--error-500);
}

.notification-warning {
    border-left: 4px solid var(--warning-500);
}

.notification-info {
    border-left: 4px solid var(--info-500);
}

.notification-close {
    background: none;
    border: none;
    color: var(--gray-400);
    cursor: pointer;
    padding: 0;
    margin-left: auto;
    transition: color var(--transition-fast);
}

.notification-close:hover {
    color: var(--gray-600);
}

.notification.fade-out {
    animation: fadeOut 0.3s ease forwards;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes fadeOut {
    to {
        opacity: 0;
        transform: translateX(100%);
    }
}

/* Form Enhancements */
.form-field.error input,
.form-field.error textarea {
    border-color: var(--error-500);
}

.contact-message,
.newsletter-message {
    margin-top: var(--space-2);
    padding: var(--space-2);
    border-radius: var(--radius-md);
    font-size: var(--text-sm);
    text-align: center;
}

.contact-message.success,
.newsletter-message.success {
    background: var(--success-50);
    color: var(--success-700);
    border: 1px solid var(--success-200);
}

.contact-message.error,
.newsletter-message.error {
    background: var(--error-50);
    color: var(--error-700);
    border: 1px solid var(--error-200);
}

/* Quantity Controls */
.quantity {
    display: flex;
    align-items: center;
    border: 1px solid var(--gray-300);
    border-radius: var(--radius-md);
    overflow: hidden;
}

.qty-btn {
    background: var(--gray-100);
    border: none;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color var(--transition-fast);
    font-weight: bold;
}

.qty-btn:hover {
    background: var(--gray-200);
}

.qty {
    border: none;
    text-align: center;
    width: 60px;
    height: 40px;
    margin: 0;
    outline: none;
}

/* Animations */
.animate-on-scroll {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease;
}

.animate-on-scroll.animate-in {
    opacity: 1;
    transform: translateY(0);
}

/* Responsive */
@media (max-width: 768px) {
    .notifications-container {
        left: var(--space-4);
        right: var(--space-4);
    }
    
    .notification {
        max-width: none;
    }
    
    .scroll-to-top {
        width: 48px;
        height: 48px;
        bottom: var(--space-4);
        right: var(--space-4);
    }
}
</style>
`;

// Inject styles
document.head.insertAdjacentHTML('beforeend', enhancedStyles);