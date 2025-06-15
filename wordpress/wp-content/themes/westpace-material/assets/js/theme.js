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
            this.initWooCommerce();
            this.initLazyLoading();
            this.initNotifications();
            this.initContactForm();
            this.initAnimations();
            this.initSearchToggle();
        },

        bindEvents: function() {
            $(document).ready(this.init.bind(this));
            $(window).on('load', this.onWindowLoad.bind(this));
            $(window).on('resize', this.onWindowResize.bind(this));
            $(window).on('scroll', this.onWindowScroll.bind(this));
        },

        onWindowLoad: function() {
            // Remove loading states
            $('body').removeClass('loading');
            
            // Initialize AOS if available
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 600,
                    once: true,
                    offset: 100
                });
            }
        },

        onWindowResize: function() {
            // Handle responsive adjustments
            this.handleResponsiveMenu();
        },

        onWindowScroll: function() {
            this.handleHeaderScroll();
            this.handleScrollToTop();
        },

        /**
         * Initialize Mobile Menu
         */
        initMobileMenu: function() {
            const $menuToggle = $('.mobile-menu-toggle');
            const $mobileMenu = $('.mobile-menu');
            const $overlay = $('.mobile-menu-overlay');

            // Create mobile menu if it doesn't exist
            if (!$mobileMenu.length) {
                this.createMobileMenu();
            }

            // Toggle mobile menu
            $menuToggle.on('click', function(e) {
                e.preventDefault();
                $('body').toggleClass('mobile-menu-open');
                $mobileMenu.toggleClass('active');
                $overlay.toggleClass('active');
                
                // Update aria attributes
                const isOpen = $mobileMenu.hasClass('active');
                $menuToggle.attr('aria-expanded', isOpen);
                $mobileMenu.attr('aria-hidden', !isOpen);
            });

            // Close mobile menu on overlay click
            $overlay.on('click', function() {
                $('body').removeClass('mobile-menu-open');
                $mobileMenu.removeClass('active');
                $overlay.removeClass('active');
                $menuToggle.attr('aria-expanded', false);
                $mobileMenu.attr('aria-hidden', true);
            });

            // Close mobile menu on escape key
            $(document).on('keydown', function(e) {
                if (e.keyCode === 27 && $mobileMenu.hasClass('active')) {
                    $('body').removeClass('mobile-menu-open');
                    $mobileMenu.removeClass('active');
                    $overlay.removeClass('active');
                    $menuToggle.attr('aria-expanded', false);
                    $mobileMenu.attr('aria-hidden', true);
                }
            });

            // Handle submenu toggles
            $('.mobile-menu .menu-item-has-children > a').on('click', function(e) {
                e.preventDefault();
                const $parent = $(this).parent();
                const $submenu = $parent.find('.sub-menu').first();
                
                $parent.toggleClass('submenu-open');
                $submenu.slideToggle(250);
            });
        },

        createMobileMenu: function() {
            const $primaryMenu = $('.main-navigation .menu');
            if ($primaryMenu.length) {
                const mobileMenuHTML = `
                    <div class="mobile-menu" aria-hidden="true">
                        <div class="mobile-menu-header">
                            <h3>Menu</h3>
                            <button class="mobile-menu-close" aria-label="Close menu">
                                <span class="material-icons">close</span>
                            </button>
                        </div>
                        <nav class="mobile-menu-nav">
                            ${$primaryMenu.html()}
                        </nav>
                    </div>
                    <div class="mobile-menu-overlay"></div>
                `;
                $('body').append(mobileMenuHTML);
            }
        },

        handleResponsiveMenu: function() {
            const windowWidth = $(window).width();
            if (windowWidth > 768) {
                $('body').removeClass('mobile-menu-open');
                $('.mobile-menu').removeClass('active');
                $('.mobile-menu-overlay').removeClass('active');
            }
        },

        /**
         * Initialize Smooth Scrolling
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
         * Initialize Scroll to Top Button
         */
        initScrollToTop: function() {
            // Create scroll to top button if it doesn't exist
            if (!$('.scroll-to-top').length) {
                $('body').append(`
                    <button class="scroll-to-top fab" aria-label="Scroll to top">
                        <span class="material-icons">keyboard_arrow_up</span>
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
                $scrollBtn.addClass('visible');
            } else {
                $scrollBtn.removeClass('visible');
            }
        },

        /**
         * Initialize Header Scroll Effects
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

            // Hide/show header on scroll
            if (scrollTop > this.lastScrollTop && scrollTop > 100) {
                $header.addClass('header-hidden');
            } else {
                $header.removeClass('header-hidden');
            }
            
            this.lastScrollTop = scrollTop;
        },

        /**
         * Initialize WooCommerce enhancements
         */
        initWooCommerce: function() {
            if (typeof wc_add_to_cart_params === "undefined") return;
            
            // Enhanced add to cart with loading states
            $(document).on("click", ".ajax_add_to_cart", function(e) {
                const $button = $(this);
                $button.addClass("loading");
                $button.find(".material-icons").text("hourglass_empty");
            });
            
            // Update cart count after AJAX
            $(document.body).on("added_to_cart", function(event, fragments, cart_hash, $button) {
                $button.removeClass("loading");
                $button.find(".material-icons").text("check");
                
                // Show success notification
                WestpaceTheme.showNotification("Product added to cart!", "success");
                
                setTimeout(function() {
                    $button.find(".material-icons").text("add_shopping_cart");
                }, 2000);
            });

            // Quantity input enhancements
            this.initQuantityInputs();

            // Product gallery enhancements
            this.initProductGallery();
        },

        initQuantityInputs: function() {
            $(document).on('click', '.quantity-btn', function(e) {
                e.preventDefault();
                const $input = $(this).siblings('.qty');
                const currentVal = parseInt($input.val()) || 0;
                const isIncrement = $(this).hasClass('qty-plus');
                const min = parseInt($input.attr('min')) || 0;
                const max = parseInt($input.attr('max')) || 999;
                
                let newVal = isIncrement ? currentVal + 1 : currentVal - 1;
                newVal = Math.max(min, Math.min(max, newVal));
                
                $input.val(newVal).trigger('change');
            });
        },

        initProductGallery: function() {
            // Enhanced product image zoom
            $('.woocommerce-product-gallery__image').on('mouseenter', function() {
                $(this).addClass('zoomed');
            }).on('mouseleave', function() {
                $(this).removeClass('zoomed');
            });
        },

        /**
         * Initialize Lazy Loading
         */
        initLazyLoading: function() {
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
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
         * Initialize Notifications System
         */
        initNotifications: function() {
            // Create notifications container if it doesn't exist
            if (!$('.notifications-container').length) {
                $('body').append('<div class="notifications-container"></div>');
            }
        },

        showNotification: function(message, type = 'info', duration = 5000) {
            const notificationId = 'notification-' + Date.now();
            const iconMap = {
                'success': 'check_circle',
                'error': 'error',
                'warning': 'warning',
                'info': 'info'
            };

            const notification = $(`
                <div class="notification alert alert-${type} animate-slide-in-down" id="${notificationId}">
                    <span class="material-icons">${iconMap[type] || 'info'}</span>
                    <span class="notification-message">${message}</span>
                    <button class="notification-close" aria-label="Close notification">
                        <span class="material-icons">close</span>
                    </button>
                </div>
            `);

            $('.notifications-container').append(notification);

            // Auto-remove notification
            setTimeout(() => {
                notification.addClass('animate-fade-out');
                setTimeout(() => notification.remove(), 300);
            }, duration);

            // Manual close
            notification.find('.notification-close').on('click', function() {
                notification.addClass('animate-fade-out');
                setTimeout(() => notification.remove(), 300);
            });
        },

        /**
         * Initialize Contact Form
         */
        initContactForm: function() {
            $('.contact-form').on('submit', function(e) {
                e.preventDefault();
                
                const $form = $(this);
                const $submitBtn = $form.find('.submit-btn');
                const formData = new FormData(this);
                formData.append('action', 'contact_form');
                formData.append('nonce', westpaceData.nonce);

                $submitBtn.addClass('loading').prop('disabled', true);

                $.ajax({
                    url: westpaceData.ajaxUrl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            WestpaceTheme.showNotification(response.data, 'success');
                            $form[0].reset();
                        } else {
                            WestpaceTheme.showNotification(response.data, 'error');
                        }
                    },
                    error: function() {
                        WestpaceTheme.showNotification('An error occurred. Please try again.', 'error');
                    },
                    complete: function() {
                        $submitBtn.removeClass('loading').prop('disabled', false);
                    }
                });
            });
        },

        /**
         * Initialize Animations
         */
        initAnimations: function() {
            // Fade in elements on scroll
            const $fadeElements = $('.fade-in-on-scroll');
            
            if ($fadeElements.length) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animate-fade-in');
                        }
                    });
                }, { threshold: 0.1 });

                $fadeElements.each(function() {
                    observer.observe(this);
                });
            }

            // Stagger animations for cards
            $('.cards-container .material-card').each(function(index) {
                $(this).css('animation-delay', (index * 100) + 'ms');
            });
        },

        /**
         * Initialize Search Toggle
         */
        initSearchToggle: function() {
            $('.search-toggle').on('click', function(e) {
                e.preventDefault();
                $('.search-overlay').addClass('active');
                $('.search-overlay .search-field').focus();
            });

            $('.search-overlay .close-search').on('click', function(e) {
                e.preventDefault();
                $('.search-overlay').removeClass('active');
            });

            // Close search on escape key
            $(document).on('keydown', function(e) {
                if (e.keyCode === 27 && $('.search-overlay').hasClass('active')) {
                    $('.search-overlay').removeClass('active');
                }
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

    // Initialize theme when DOM is ready
    WestpaceTheme.init();

    // Make WestpaceTheme available globally
    window.WestpaceTheme = WestpaceTheme;

})(jQuery);

// Additional CSS for dynamic functionality
const dynamicStyles = `
    <style>
        /* Mobile Menu Styles */
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 100%;
            max-width: 320px;
            height: 100vh;
            background: white;
            z-index: var(--z-modal);
            transition: right 0.3s ease;
            box-shadow: var(--elevation-3);
            overflow-y: auto;
        }
        
        .mobile-menu.active {
            right: 0;
        }
        
        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: var(--z-modal-backdrop);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        
        .mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .mobile-menu-header {
            padding: var(--spacing-6);
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .mobile-menu-nav {
            padding: var(--spacing-4);
        }
        
        .mobile-menu-nav .menu-item {
            border-bottom: 1px solid var(--gray-100);
        }
        
        .mobile-menu-nav .menu-item a {
            display: block;
            padding: var(--spacing-3) 0;
            color: var(--gray-700);
            text-decoration: none;
        }
        
        /* Header Scroll Effects */
        .site-header {
            transition: transform 0.3s ease, background-color 0.3s ease;
        }
        
        .site-header.header-scrolled {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: var(--elevation-1);
        }
        
        .site-header.header-hidden {
            transform: translateY(-100%);
        }
        
        /* Scroll to Top Button */
        .scroll-to-top {
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.3s ease;
        }
        
        .scroll-to-top.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        /* Notifications */
        .notifications-container {
            position: fixed;
            top: var(--spacing-6);
            right: var(--spacing-6);
            z-index: var(--z-tooltip);
            pointer-events: none;
        }
        
        .notification {
            pointer-events: all;
            margin-bottom: var(--spacing-3);
            display: flex;
            align-items: center;
            gap: var(--spacing-3);
            max-width: 400px;
        }
        
        .notification-close {
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            padding: 0;
            margin-left: auto;
        }
        
        /* Loading States */
        .loading {
            position: relative;
            overflow: hidden;
        }
        
        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: loading-shimmer 1.5s infinite;
        }
        
        @keyframes loading-shimmer {
            100% { left: 100%; }
        }
        
        /* Search Overlay */
        .search-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            z-index: var(--z-modal);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        
        .search-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        /* Fade out animation */
        .animate-fade-out {
            animation: fadeOut 0.3s ease-in-out forwards;
        }
        
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .notifications-container {
                left: var(--spacing-4);
                right: var(--spacing-4);
            }
            
            .notification {
                max-width: none;
            }
        }
    </style>
`;

// Inject dynamic styles
document.head.insertAdjacentHTML('beforeend', dynamicStyles);