/**
 * Westpace Material Design Theme JavaScript
 * Modern, accessible, and performant interactions
 */

(function($) {
    'use strict';

    // Document ready
    $(document).ready(function() {
        initMobileMenu();
        initStickyHeader();
        initSmoothScrolling();
        initMaterialCards();
        initFormEnhancements();
        initLazyLoading();
        initAccessibility();
        initWooCommerceEnhancements();
        initNewsletterForm();
        initScrollAnimations();
    });

    /**
     * Mobile Menu Toggle
     */
    function initMobileMenu() {
        const $mobileToggle = $('.mobile-menu-toggle');
        const $mainNav = $('.main-navigation');
        const $body = $('body');

        $mobileToggle.on('click', function(e) {
            e.preventDefault();
            
            $(this).toggleClass('is-active');
            $mainNav.toggleClass('is-open');
            $body.toggleClass('mobile-menu-open');
            
            // Update ARIA attributes
            const isOpen = $mainNav.hasClass('is-open');
            $(this).attr('aria-expanded', isOpen);
            $mainNav.attr('aria-hidden', !isOpen);
        });

        // Close mobile menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.site-header').length) {
                $mobileToggle.removeClass('is-active');
                $mainNav.removeClass('is-open');
                $body.removeClass('mobile-menu-open');
                $mobileToggle.attr('aria-expanded', 'false');
                $mainNav.attr('aria-hidden', 'true');
            }
        });

        // Close mobile menu on escape key
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27 && $mainNav.hasClass('is-open')) {
                $mobileToggle.trigger('click');
            }
        });
    }

    /**
     * Sticky Header with Scroll Detection
     */
    function initStickyHeader() {
        const $header = $('.site-header');
        let lastScrollTop = 0;
        let isScrolling = false;

        $(window).on('scroll', function() {
            if (!isScrolling) {
                requestAnimationFrame(function() {
                    const scrollTop = $(window).scrollTop();
                    
                    // Add scrolled class
                    if (scrollTop > 100) {
                        $header.addClass('scrolled');
                    } else {
                        $header.removeClass('scrolled');
                    }

                    // Hide header on scroll down, show on scroll up
                    if (scrollTop > lastScrollTop && scrollTop > 200) {
                        $header.addClass('hidden');
                    } else {
                        $header.removeClass('hidden');
                    }

                    lastScrollTop = scrollTop;
                    isScrolling = false;
                });
                isScrolling = true;
            }
        });
    }

    /**
     * Smooth Scrolling for Anchor Links
     */
    function initSmoothScrolling() {
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            
            if (target.length) {
                e.preventDefault();
                
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, {
                    duration: 600,
                    easing: 'swing'
                });
            }
        });
    }

    /**
     * Material Card Hover Effects
     */
    function initMaterialCards() {
        $('.material-card').hover(
            function() {
                $(this).addClass('elevation-4');
            },
            function() {
                $(this).removeClass('elevation-4');
            }
        );

        // Add ripple effect to buttons
        $('.btn').on('click', function(e) {
            const $this = $(this);
            const rect = this.getBoundingClientRect();
            const ripple = $('<span class="ripple"></span>');
            
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.css({
                width: size,
                height: size,
                left: x,
                top: y
            });
            
            $this.append(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    }

    /**
     * Form Enhancements
     */
    function initFormEnhancements() {
        // Floating labels
        $('.form-control').on('focus blur', function() {
            const $this = $(this);
            const $label = $this.siblings('.form-label');
            
            if ($this.val() || $this.is(':focus')) {
                $label.addClass('focused');
            } else {
                $label.removeClass('focused');
            }
        });

        // Real-time validation
        $('.form-control[required]').on('blur', function() {
            const $this = $(this);
            const isValid = this.checkValidity();
            
            $this.toggleClass('is-valid', isValid)
                 .toggleClass('is-invalid', !isValid);
        });

        // Auto-resize textareas
        $('textarea').on('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
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
     * Accessibility Enhancements
     */
    function initAccessibility() {
        // Skip link functionality
        $('.skip-link').on('click', function(e) {
            const target = $($(this).attr('href'));
            if (target.length) {
                target.attr('tabindex', '-1').focus();
            }
        });

        // Keyboard navigation for dropdowns
        $('.menu-item-has-children > a').on('keydown', function(e) {
            if (e.keyCode === 13 || e.keyCode === 32) { // Enter or Space
                e.preventDefault();
                $(this).siblings('.sub-menu').toggle();
            }
        });

        // Focus management for modals
        $(document).on('shown.bs.modal', '.modal', function() {
            $(this).find('[autofocus]').focus();
        });
    }

    /**
     * WooCommerce Enhancements
     */
    function initWooCommerceEnhancements() {
        if (typeof wc_add_to_cart_params === 'undefined') {
            return;
        }

        // Enhanced add to cart functionality
        $('.add-to-cart-btn').on('click', function(e) {
            e.preventDefault();
            
            const $button = $(this);
            const productId = $button.data('product_id');
            
            // Add loading state
            $button.addClass('loading').prop('disabled', true);
            
            // Simulate AJAX call (replace with actual WooCommerce AJAX)
            setTimeout(() => {
                $button.removeClass('loading').prop('disabled', false);
                $button.text('Added!').addClass('added');
                
                // Reset button after 2 seconds
                setTimeout(() => {
                    $button.text('Add to Cart').removeClass('added');
                }, 2000);
            }, 1000);
        });

        // Product image gallery enhancement
        $('.woocommerce-product-gallery__image').on('click', function(e) {
            e.preventDefault();
            // Custom lightbox functionality would go here
        });

        // Quantity input enhancement
        $('.quantity').each(function() {
            const $qty = $(this);
            const $input = $qty.find('.qty');
            const min = parseInt($input.attr('min')) || 1;
            const max = parseInt($input.attr('max')) || 999;

            $qty.prepend('<button type="button" class="qty-btn qty-minus">-</button>');
            $qty.append('<button type="button" class="qty-btn qty-plus">+</button>');

            $qty.on('click', '.qty-minus', function() {
                const current = parseInt($input.val()) || min;
                if (current > min) {
                    $input.val(current - 1).trigger('change');
                }
            });

            $qty.on('click', '.qty-plus', function() {
                const current = parseInt($input.val()) || min;
                if (current < max) {
                    $input.val(current + 1).trigger('change');
                }
            });
        });
    }

    /**
     * Newsletter Form Handling
     */
    function initNewsletterForm() {
        $('.newsletter-form').on('submit', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $email = $form.find('input[type="email"]');
            const $button = $form.find('button[type="submit"]');
            const $message = $form.find('.form-message');
            
            // Basic validation
            if (!$email.val() || !isValidEmail($email.val())) {
                showMessage($message, 'Please enter a valid email address.', 'error');
                return;
            }
            
            // Show loading state
            $button.prop('disabled', true).text('Subscribing...');
            
            // AJAX call
            $.ajax({
                url: westpace_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'westpace_newsletter',
                    email: $email.val(),
                    nonce: westpace_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        showMessage($message, response.data, 'success');
                        $form[0].reset();
                    } else {
                        showMessage($message, response.data, 'error');
                    }
                },
                error: function() {
                    showMessage($message, 'Something went wrong. Please try again.', 'error');
                },
                complete: function() {
                    $button.prop('disabled', false).text('Subscribe');
                }
            });
        });
    }

    /**
     * Scroll Animations
     */
    function initScrollAnimations() {
        if ('IntersectionObserver' in window) {
            const animationObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate');
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.fade-in-up, .fade-in, .slide-in-left, .slide-in-right').forEach(el => {
                animationObserver.observe(el);
            });
        }
    }

    /**
     * Utility Functions
     */
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function showMessage($container, message, type) {
        $container.removeClass('success error info warning')
                  .addClass(type)
                  .html(message)
                  .fadeIn();
        
        setTimeout(() => {
            $container.fadeOut();
        }, 5000);
    }

    /**
     * Debounce function for performance
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
     * Throttle function for scroll events
     */
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    // Expose some functions globally if needed
    window.westpaceTheme = {
        showMessage: showMessage,
        isValidEmail: isValidEmail,
        debounce: debounce,
        throttle: throttle
    };

})(jQuery);

/**
 * CSS for JavaScript-added elements
 */
document.addEventListener('DOMContentLoaded', function() {
    // Add necessary CSS for ripple effect and other JS enhancements
    const style = document.createElement('style');
    style.textContent = `
        .btn {
            position: relative;
            overflow: hidden;
        }
        
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
        
        .form-control.is-valid {
            border-color: var(--success-500);
        }
        
        .form-control.is-invalid {
            border-color: var(--error-500);
        }
        
        .qty-btn {
            background: var(--gray-200);
            border: 1px solid var(--gray-300);
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition-fast);
        }
        
        .qty-btn:hover {
            background: var(--gray-300);
        }
        
        .qty-minus {
            border-radius: var(--radius) 0 0 var(--radius);
        }
        
        .qty-plus {
            border-radius: 0 var(--radius) var(--radius) 0;
        }
        
        .form-message {
            padding: var(--space-3);
            border-radius: var(--radius);
            margin-top: var(--space-3);
            display: none;
        }
        
        .form-message.success {
            background: var(--success-50);
            color: var(--success-700);
            border: 1px solid var(--success-200);
        }
        
        .form-message.error {
            background: var(--error-50);
            color: var(--error-700);
            border: 1px solid var(--error-200);
        }
        
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        
        .fade-in-up.animate {
            opacity: 1;
            transform: translateY(0);
        }
        
        .lazy {
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .lazy.loaded {
            opacity: 1;
        }
        
        @media (prefers-reduced-motion: reduce) {
            .ripple,
            .fade-in-up {
                animation: none !important;
                transition: none !important;
            }
        }
    `;
    document.head.appendChild(style);
});