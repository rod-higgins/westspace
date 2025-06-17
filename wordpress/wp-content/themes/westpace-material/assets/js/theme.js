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
     * Sticky Header with Scroll Detection - FIXED IMPLEMENTATION
     */
    function initStickyHeader() {
        const $header = $('.site-header');
        const $window = $(window);
        let lastScrollTop = 0;
        let isScrolling = false;

        if (!$header.length) return;

        // Throttled scroll handler for performance
        const scrollHandler = throttle(function() {
            const scrollTop = $window.scrollTop();
            const scrollingDown = scrollTop > lastScrollTop;
            const scrolledPastThreshold = scrollTop > 100;

            if (scrolledPastThreshold) {
                $header.addClass('scrolled');
                
                // Hide header when scrolling down, show when scrolling up
                if (scrollingDown && scrollTop > 200) {
                    $header.addClass('hidden');
                } else if (!scrollingDown) {
                    $header.removeClass('hidden');
                }
            } else {
                $header.removeClass('scrolled hidden');
            }

            lastScrollTop = scrollTop;
        }, 10);

        $window.on('scroll', scrollHandler);
    }

    /**
     * Smooth Scrolling for Anchor Links
     */
    function initSmoothScrolling() {
        $('a[href*="#"]:not([href="#"])').on('click', function(e) {
            const target = $(this.hash);
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 80
                }, 800, 'easeInOutCubic');
            }
        });
    }

    /**
     * Material Cards Hover Effects
     */
    function initMaterialCards() {
        $('.material-card').on('mouseenter', function() {
            $(this).addClass('elevation-8');
        }).on('mouseleave', function() {
            $(this).removeClass('elevation-8');
        });
    }

    /**
     * Form Enhancements
     */
    function initFormEnhancements() {
        // Floating labels
        $('.form-floating input, .form-floating textarea').on('focus blur', function() {
            const $field = $(this);
            const $label = $field.siblings('label');
            
            if ($field.val() || $field.is(':focus')) {
                $label.addClass('floating');
            } else {
                $label.removeClass('floating');
            }
        });

        // Form validation
        $('form').on('submit', function(e) {
            const $form = $(this);
            let isValid = true;

            $form.find('[required]').each(function() {
                const $field = $(this);
                if (!$field.val()) {
                    $field.addClass('error');
                    isValid = false;
                } else {
                    $field.removeClass('error');
                }
            });

            if (!isValid) {
                e.preventDefault();
                $form.find('.error').first().focus();
            }
        });
    }

    /**
     * Lazy Loading Implementation
     */
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        img.classList.add('lazy-loaded');
                        observer.unobserve(img);
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
        // Skip to content link
        $('body').prepend('<a href="#main" class="skip-link screen-reader-text">Skip to main content</a>');

        // Focus management for modal-like elements
        $(document).on('keydown', function(e) {
            if (e.keyCode === 9) { // Tab key
                const $focusable = $(':focusable:visible');
                const $first = $focusable.first();
                const $last = $focusable.last();

                if (e.target === $last[0] && !e.shiftKey) {
                    e.preventDefault();
                    $first.focus();
                } else if (e.target === $first[0] && e.shiftKey) {
                    e.preventDefault();
                    $last.focus();
                }
            }
        });
    }

    /**
     * WooCommerce Enhancements - FIXED IMPLEMENTATION
     */
    function initWooCommerceEnhancements() {
        // Add to cart button enhancement
        $('.add_to_cart_button').on('click', function() {
            const $button = $(this);
            const originalText = $button.text();
            
            // Show loading state
            $button.text('Adding...').addClass('loading');
            
            // Simulate add to cart (actual functionality handled by WooCommerce)
            setTimeout(() => {
                $button.text('Added!').removeClass('loading').addClass('added');
                
                // Reset button after 2 seconds
                setTimeout(() => {
                    $button.text(originalText).removeClass('added');
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
     * Newsletter Form Handling - FIXED IMPLEMENTATION
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
        debounce: debounce,
        throttle: throttle
    };

})(jQuery);