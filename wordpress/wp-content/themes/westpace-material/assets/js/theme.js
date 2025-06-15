/**
 * Westpace Material Theme JavaScript
 * Main functionality for the theme
 */

(function($) {
    'use strict';

    // Wait for DOM to be ready
    $(document).ready(function() {
        
        // Initialize theme functionality
        initMobileNavigation();
        initSmoothScrolling();
        initMaterialEffects();
        initLazyLoading();
        initContactForm();
        initNewsletterForm();
        initBackToTop();
        initCookieNotice();
        initSearchToggle();
        initDropdownMenus();
        initTooltips();
        initProgressBars();
        
        // WooCommerce specific functionality
        if (westpaceData.isWooActive) {
            initWooCommerceFeatures();
        }
    });

    /**
     * Mobile Navigation
     */
    function initMobileNavigation() {
        const mobileToggle = $('.mobile-menu-toggle');
        const navigation = $('.main-navigation');
        const body = $('body');

        mobileToggle.on('click', function() {
            navigation.toggleClass('is-open');
            body.toggleClass('mobile-menu-open');
            
            // Update aria attributes
            const isOpen = navigation.hasClass('is-open');
            $(this).attr('aria-expanded', isOpen);
            
            // Change icon
            const icon = $(this).find('.material-icons');
            icon.text(isOpen ? 'close' : 'menu');
        });

        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.main-navigation, .mobile-menu-toggle').length) {
                navigation.removeClass('is-open');
                body.removeClass('mobile-menu-open');
                mobileToggle.attr('aria-expanded', false);
                mobileToggle.find('.material-icons').text('menu');
            }
        });

        // Handle submenu toggles on mobile
        $('.menu-item-has-children > a').on('click', function(e) {
            if ($(window).width() <= 768) {
                e.preventDefault();
                const submenu = $(this).next('.sub-menu');
                submenu.slideToggle();
                $(this).parent().toggleClass('submenu-open');
            }
        });
    }

    /**
     * Smooth Scrolling
     */
    function initSmoothScrolling() {
        $('a[href*="#"]:not([href="#"])').on('click', function() {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
                location.hostname === this.hostname) {
                
                let target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80
                    }, 800);
                    return false;
                }
            }
        });
    }

    /**
     * Material Design Effects
     */
    function initMaterialEffects() {
        // Ripple effect for buttons
        $('.btn, .nav-link, .material-card').on('click', function(e) {
            const button = $(this);
            const ripple = $('<span class="ripple"></span>');
            
            button.append(ripple);
            
            const buttonPos = button.offset();
            const buttonWidth = button.outerWidth();
            const buttonHeight = button.outerHeight();
            
            const rippleX = e.pageX - buttonPos.left;
            const rippleY = e.pageY - buttonPos.top;
            
            ripple.css({
                left: rippleX,
                top: rippleY,
                width: Math.max(buttonWidth, buttonHeight),
                height: Math.max(buttonWidth, buttonHeight)
            });
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });

        // Card hover animations
        $('.material-card').hover(
            function() {
                $(this).addClass('elevated');
            },
            function() {
                $(this).removeClass('elevated');
            }
        );

        // Focus states for accessibility
        $('button, a, input, textarea, select').on('focus', function() {
            $(this).addClass('focused');
        }).on('blur', function() {
            $(this).removeClass('focused');
        });
    }

    /**
     * Lazy Loading for Images
     */
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    /**
     * Contact Form Handler
     */
    function initContactForm() {
        $('#contact-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const formData = new FormData(this);
            formData.append('action', 'westpace_contact_form');
            formData.append('nonce', westpaceData.nonce);
            
            const submitButton = form.find('button[type="submit"]');
            const originalText = submitButton.text();
            
            submitButton.prop('disabled', true).text(westpaceData.strings.loading);
            
            $.ajax({
                url: westpaceData.ajaxUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showNotification(response.data, 'success');
                        form[0].reset();
                    } else {
                        showNotification(response.data, 'error');
                    }
                },
                error: function() {
                    showNotification('An error occurred. Please try again.', 'error');
                },
                complete: function() {
                    submitButton.prop('disabled', false).text(originalText);
                }
            });
        });
    }

    /**
     * Newsletter Form Handler
     */
    function initNewsletterForm() {
        $('#newsletter-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const email = form.find('input[name="email"]').val();
            const messageDiv = $('#newsletter-message');
            
            if (!isValidEmail(email)) {
                messageDiv.html('<div class="error">Please enter a valid email address.</div>');
                return;
            }
            
            const submitButton = form.find('button[type="submit"]');
            const originalText = submitButton.text();
            
            submitButton.prop('disabled', true).text(westpaceData.strings.loading);
            
            // Simulate newsletter subscription (replace with actual implementation)
            setTimeout(() => {
                messageDiv.html('<div class="success">' + westpaceData.strings.newsletterSuccess + '</div>');
                form[0].reset();
                submitButton.prop('disabled', false).text(originalText);
            }, 1000);
        });
    }

    /**
     * Back to Top Button
     */
    function initBackToTop() {
        const backToTop = $('#back-to-top');
        
        if (backToTop.length) {
            $(window).on('scroll', function() {
                if ($(this).scrollTop() > 300) {
                    backToTop.addClass('visible');
                } else {
                    backToTop.removeClass('visible');
                }
            });
            
            backToTop.on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({ scrollTop: 0 }, 800);
            });
        }
    }

    /**
     * Cookie Notice
     */
    function initCookieNotice() {
        const cookieNotice = $('#cookie-notice');
        
        if (cookieNotice.length) {
            // Check if user has already accepted/declined cookies
            if (!localStorage.getItem('cookiesAccepted') && !localStorage.getItem('cookiesDeclined')) {
                setTimeout(() => {
                    cookieNotice.fadeIn();
                }, 2000);
            }
            
            $('#accept-cookies').on('click', function() {
                localStorage.setItem('cookiesAccepted', 'true');
                cookieNotice.fadeOut();
            });
            
            $('#decline-cookies').on('click', function() {
                localStorage.setItem('cookiesDeclined', 'true');
                cookieNotice.fadeOut();
            });
        }
    }

    /**
     * Search Toggle
     */
    function initSearchToggle() {
        $('.search-toggle').on('click', function() {
            $('.search-form').toggleClass('active');
            $('.search-field').focus();
        });
        
        // Close search when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-form, .search-toggle').length) {
                $('.search-form').removeClass('active');
            }
        });
    }

    /**
     * Dropdown Menus
     */
    function initDropdownMenus() {
        $('.menu-item-has-children').hover(
            function() {
                $(this).addClass('hover');
            },
            function() {
                $(this).removeClass('hover');
            }
        );
        
        // Keyboard navigation for dropdowns
        $('.menu-item-has-children > a').on('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                const submenu = $(this).next('.sub-menu');
                const firstLink = submenu.find('a').first();
                if (firstLink.length) {
                    firstLink.focus();
                }
            }
        });
    }

    /**
     * Tooltips
     */
    function initTooltips() {
        $('[data-tooltip]').hover(
            function() {
                const tooltip = $('<div class="tooltip">' + $(this).data('tooltip') + '</div>');
                $('body').append(tooltip);
                
                const pos = $(this).offset();
                tooltip.css({
                    top: pos.top - tooltip.outerHeight() - 10,
                    left: pos.left + ($(this).outerWidth() / 2) - (tooltip.outerWidth() / 2)
                }).fadeIn();
            },
            function() {
                $('.tooltip').remove();
            }
        );
    }

    /**
     * Progress Bars
     */
    function initProgressBars() {
        const progressBars = $('.progress-bar');
        
        if (progressBars.length) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const progressBar = $(entry.target);
                        const percent = progressBar.data('percent');
                        progressBar.find('.progress-fill').animate({
                            width: percent + '%'
                        }, 1000);
                        observer.unobserve(entry.target);
                    }
                });
            });
            
            progressBars.each(function() {
                observer.observe(this);
            });
        }
    }

    /**
     * WooCommerce Features
     */
    function initWooCommerceFeatures() {
        // Update cart count
        $(document.body).on('added_to_cart', function() {
            updateCartCount();
            showNotification(westpaceData.strings.addedToCart, 'success');
        });
        
        // Product gallery
        $('.woocommerce-product-gallery').each(function() {
            $(this).wc_product_gallery();
        });
        
        // Quantity buttons
        $(document).on('click', '.quantity-plus, .quantity-minus', function() {
            const input = $(this).siblings('.qty');
            const currentVal = parseInt(input.val());
            const max = parseInt(input.attr('max'));
            const min = parseInt(input.attr('min'));
            
            if ($(this).hasClass('quantity-plus') && currentVal < max) {
                input.val(currentVal + 1);
            } else if ($(this).hasClass('quantity-minus') && currentVal > min) {
                input.val(currentVal - 1);
            }
            
            input.trigger('change');
        });
    }

    /**
     * Update cart count
     */
    function updateCartCount() {
        $.get(westpaceData.ajaxUrl + '?action=westpace_get_cart_count', function(data) {
            $('.cart-count').text(data);
        });
    }

    /**
     * Show notification
     */
    function showNotification(message, type = 'info') {
        const notification = $('<div class="notification notification-' + type + '">' + message + '</div>');
        $('body').append(notification);
        
        setTimeout(() => {
            notification.addClass('show');
        }, 100);
        
        setTimeout(() => {
            notification.removeClass('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }

    /**
     * Validate email address
     */
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    /**
     * Debounce function
     */
    function debounce(func, wait, immediate) {
        let timeout;
        return function() {
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
    }

    /**
     * Handle window resize
     */
    $(window).on('resize', debounce(function() {
        // Close mobile menu on resize to desktop
        if ($(window).width() > 768) {
            $('.main-navigation').removeClass('is-open');
            $('body').removeClass('mobile-menu-open');
            $('.mobile-menu-toggle').attr('aria-expanded', false);
            $('.mobile-menu-toggle .material-icons').text('menu');
        }
    }, 250));

    /**
     * Handle scroll events
     */
    $(window).on('scroll', debounce(function() {
        const scrollTop = $(this).scrollTop();
        
        // Header scroll effect
        if (scrollTop > 100) {
            $('.site-header').addClass('scrolled');
        } else {
            $('.site-header').removeClass('scrolled');
        }
        
        // Animate elements on scroll
        $('.fade-in-up').each(function() {
            const elementTop = $(this).offset().top;
            const elementBottom = elementTop + $(this).outerHeight();
            const viewportTop = scrollTop;
            const viewportBottom = viewportTop + $(window).height();
            
            if (elementBottom > viewportTop && elementTop < viewportBottom) {
                $(this).addClass('animated');
            }
        });
    }, 10));

    /**
     * Initialize AOS (Animate On Scroll) alternative
     */
    function initScrollAnimations() {
        const animatedElements = document.querySelectorAll('.animate-on-scroll');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        animatedElements.forEach(el => {
            observer.observe(el);
        });
    }

    // Initialize scroll animations
    initScrollAnimations();

    /**
     * Accessibility improvements
     */
    
    // Skip link functionality
    $('.skip-link').on('click', function(e) {
        const target = $($(this).attr('href'));
        if (target.length) {
            target.attr('tabindex', '-1').focus();
        }
    });
    
    // Escape key handling
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            // Close mobile menu
            $('.main-navigation').removeClass('is-open');
            $('body').removeClass('mobile-menu-open');
            
            // Close search
            $('.search-form').removeClass('active');
            
            // Remove tooltips
            $('.tooltip').remove();
        }
    });

    /**
     * Print styles
     */
    window.addEventListener('beforeprint', function() {
        // Expand all collapsed content for printing
        $('.sub-menu, .accordion-content').show();
    });

    window.addEventListener('afterprint', function() {
        // Restore collapsed state after printing
        $('.sub-menu, .accordion-content').hide();
        $('.menu-item-has-children.submenu-open .sub-menu').show();
    });

})(jQuery);

/**
 * CSS for dynamic effects
 */
const dynamicStyles = `
    <style>
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .material-card.elevated {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }
    
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        transform: translateX(400px);
        transition: transform 0.3s ease;
    }
    
    .notification.show {
        transform: translateX(0);
    }
    
    .notification-success {
        background-color: var(--success-600);
    }
    
    .notification-error {
        background-color: var(--error-600);
    }
    
    .notification-info {
        background-color: var(--info-600);
    }
    
    .back-to-top-button {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--primary-600);
        color: white;
        border: none;
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 1000;
        box-shadow: var(--shadow-lg);
    }
    
    .back-to-top-button.visible {
        opacity: 1;
        visibility: visible;
    }
    
    .back-to-top-button:hover {
        background: var(--primary-700);
        transform: translateY(-2px);
    }
    
    .tooltip {
        position: absolute;
        background: var(--gray-800);
        color: white;
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 14px;
        white-space: nowrap;
        z-index: 10000;
        opacity: 0;
    }
    
    .fade-in-up {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }
    
    .fade-in-up.animated {
        opacity: 1;
        transform: translateY(0);
    }
    
    .animate-on-scroll {
        opacity: 0;
        transform: translateY(50px);
        transition: all 0.8s ease;
    }
    
    .animate-on-scroll.animated {
        opacity: 1;
        transform: translateY(0);
    }
    
    @media (max-width: 768px) {
        .back-to-top-button {
            bottom: 20px;
            right: 20px;
            width: 45px;
            height: 45px;
        }
        
        .notification {
            top: 10px;
            right: 10px;
            left: 10px;
            transform: translateY(-100px);
        }
        
        .notification.show {
            transform: translateY(0);
        }
    }
    </style>
`;

// Inject dynamic styles
document.head.insertAdjacentHTML('beforeend', dynamicStyles);