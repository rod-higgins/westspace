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
        initScrollAnimations();
        initAccessibility();
        
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
                        scrollTop: target.offset().top - 100
                    }, 800);
                    return false;
                }
            }
        });
    }

    /**
     * Material Effects (Ripple, etc.)
     */
    function initMaterialEffects() {
        // Ripple effect for buttons
        $('.btn, .nav-link').on('click', function(e) {
            const $this = $(this);
            const ripple = $('<span class="ripple"></span>');
            
            $this.append(ripple);
            
            const btnOffset = $this.offset();
            const xPos = e.pageX - btnOffset.left;
            const yPos = e.pageY - btnOffset.top;
            
            ripple.css({
                left: xPos + 'px',
                top: yPos + 'px'
            }).addClass('animate');
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });

        // Card hover effects
        $('.material-card').hover(
            function() {
                $(this).addClass('elevated');
            },
            function() {
                $(this).removeClass('elevated');
            }
        );
    }

    /**
     * Lazy Loading
     */
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const lazyImages = document.querySelectorAll('[data-lazy]');
            
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.lazy;
                        img.classList.remove('lazy');
                        img.classList.add('loaded');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            lazyImages.forEach(img => imageObserver.observe(img));
        } else {
            // Fallback for browsers without IntersectionObserver
            $('[data-lazy]').each(function() {
                $(this).attr('src', $(this).data('lazy'));
            });
        }
    }

    /**
     * Contact Form
     */
    function initContactForm() {
        $('#contact-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const submitBtn = form.find('[type="submit"]');
            const originalText = submitBtn.text();
            
            // Show loading state
            submitBtn.text(westpaceData.strings.loading).prop('disabled', true);
            
            $.ajax({
                url: westpaceData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'westpace_contact_form',
                    nonce: westpaceData.nonce,
                    name: form.find('[name="name"]').val(),
                    email: form.find('[name="email"]').val(),
                    subject: form.find('[name="subject"]').val(),
                    message: form.find('[name="message"]').val()
                },
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
                    submitBtn.text(originalText).prop('disabled', false);
                }
            });
        });
    }

    /**
     * Newsletter Form
     */
    function initNewsletterForm() {
        $('.newsletter-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const submitBtn = form.find('[type="submit"]');
            const originalText = submitBtn.text();
            
            submitBtn.text(westpaceData.strings.loading).prop('disabled', true);
            
            $.ajax({
                url: westpaceData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'westpace_newsletter_signup',
                    nonce: westpaceData.nonce,
                    email: form.find('[name="email"]').val()
                },
                success: function(response) {
                    if (response.success) {
                        showNotification(westpaceData.strings.newsletterSuccess, 'success');
                        form[0].reset();
                    } else {
                        showNotification(response.data || westpaceData.strings.newsletterError, 'error');
                    }
                },
                error: function() {
                    showNotification(westpaceData.strings.newsletterError, 'error');
                },
                complete: function() {
                    submitBtn.text(originalText).prop('disabled', false);
                }
            });
        });
    }

    /**
     * Back to Top
     */
    function initBackToTop() {
        const backToTop = $('<button class="back-to-top" aria-label="Back to top"><span class="material-icons">keyboard_arrow_up</span></button>');
        $('body').append(backToTop);
        
        $(window).scroll(function() {
            if ($(this).scrollTop() > 500) {
                backToTop.addClass('show');
            } else {
                backToTop.removeClass('show');
            }
        });
        
        backToTop.on('click', function() {
            $('html, body').animate({scrollTop: 0}, 800);
        });
    }

    /**
     * Cookie Notice
     */
    function initCookieNotice() {
        if (!localStorage.getItem('cookieConsent')) {
            const cookieNotice = $(`
                <div class="cookie-notice">
                    <div class="cookie-content">
                        <p>We use cookies to enhance your experience. By continuing to visit this site you agree to our use of cookies.</p>
                        <button class="btn btn-primary cookie-accept">Accept</button>
                    </div>
                </div>
            `);
            
            $('body').append(cookieNotice);
            
            $('.cookie-accept').on('click', function() {
                localStorage.setItem('cookieConsent', 'true');
                cookieNotice.fadeOut();
            });
        }
    }

    /**
     * Search Toggle
     */
    function initSearchToggle() {
        $('.search-toggle').on('click', function(e) {
            e.preventDefault();
            $('.search-form').toggleClass('active');
            $('.search-form input').focus();
        });
        
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
                $(this).find('.sub-menu').stop().fadeIn(200);
            },
            function() {
                $(this).find('.sub-menu').stop().fadeOut(200);
            }
        );
        
        // Keyboard navigation
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
                }).fadeIn(200);
            },
            function() {
                $('.tooltip').fadeOut(200, function() {
                    $(this).remove();
                });
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
     * Scroll Animations
     */
    function initScrollAnimations() {
        const animatedElements = document.querySelectorAll('.animate-on-scroll');
        
        if (animatedElements.length) {
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
    }

    /**
     * Accessibility improvements
     */
    function initAccessibility() {
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
                $('.mobile-menu-toggle').attr('aria-expanded', false);
                
                // Close search
                $('.search-form').removeClass('active');
                
                // Remove tooltips
                $('.tooltip').remove();
            }
        });

        // Focus management for modals and dropdowns
        $('.modal').on('shown', function() {
            $(this).find('[tabindex], input, button, a').first().focus();
        });
    }

    /**
     * WooCommerce Features
     */
    function initWooCommerceFeatures() {
        // Quick view functionality
        $('.quick-view-btn').on('click', function(e) {
            e.preventDefault();
            const productId = $(this).data('product-id');
            loadQuickView(productId);
        });

        // Add to cart with AJAX
        $('.add-to-cart-btn').on('click', function(e) {
            e.preventDefault();
            
            const $this = $(this);
            const productId = $this.data('product-id');
            const originalText = $this.text();
            
            $this.text(westpaceData.strings.loading).prop('disabled', true);
            
            $.ajax({
                url: westpaceData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'woocommerce_add_to_cart',
                    product_id: productId,
                    quantity: 1
                },
                success: function(response) {
                    if (response.success) {
                        showNotification(westpaceData.strings.addedToCart, 'success');
                        // Update cart count if exists
                        updateCartCount();
                    } else {
                        showNotification(westpaceData.strings.cartError, 'error');
                    }
                },
                error: function() {
                    showNotification(westpaceData.strings.cartError, 'error');
                },
                complete: function() {
                    $this.text(originalText).prop('disabled', false);
                }
            });
        });

        // Product image gallery
        $('.product-gallery').each(function() {
            initProductGallery($(this));
        });

        // Quantity input improvements
        $('.quantity input').on('change', function() {
            const $this = $(this);
            const min = parseInt($this.attr('min')) || 1;
            const max = parseInt($this.attr('max')) || 999;
            let val = parseInt($this.val());
            
            if (val < min) val = min;
            if (val > max) val = max;
            
            $this.val(val);
        });

        // Checkout form enhancements
        if ($('body').hasClass('woocommerce-checkout')) {
            initCheckoutEnhancements();
        }
    }

    /**
     * Load Quick View Modal
     */
    function loadQuickView(productId) {
        const modal = $(`
            <div class="quick-view-modal">
                <div class="modal-backdrop"></div>
                <div class="modal-content">
                    <button class="modal-close" aria-label="Close">
                        <span class="material-icons">close</span>
                    </button>
                    <div class="modal-body">
                        <div class="loading">${westpaceData.strings.loading}</div>
                    </div>
                </div>
            </div>
        `);
        
        $('body').append(modal);
        
        // Load product content via AJAX
        $.ajax({
            url: westpaceData.ajaxUrl,
            type: 'POST',
            data: {
                action: 'westpace_quick_view',
                product_id: productId,
                nonce: westpaceData.nonce
            },
            success: function(response) {
                if (response.success) {
                    modal.find('.modal-body').html(response.data);
                } else {
                    modal.find('.modal-body').html('<p>Error loading product.</p>');
                }
            },
            error: function() {
                modal.find('.modal-body').html('<p>Error loading product.</p>');
            }
        });
        
        // Close modal functionality
        modal.find('.modal-close, .modal-backdrop').on('click', function() {
            modal.fadeOut(function() {
                $(this).remove();
            });
        });
    }

    /**
     * Update Cart Count
     */
    function updateCartCount() {
        $.ajax({
            url: westpaceData.ajaxUrl,
            type: 'POST',
            data: {
                action: 'westpace_get_cart_count',
                nonce: westpaceData.nonce
            },
            success: function(response) {
                if (response.success) {
                    $('.cart-count').text(response.data);
                }
            }
        });
    }

    /**
     * Product Gallery
     */
    function initProductGallery($gallery) {
        const $mainImage = $gallery.find('.main-image img');
        const $thumbnails = $gallery.find('.thumbnails img');
        
        $thumbnails.on('click', function() {
            const newSrc = $(this).attr('src');
            const newSrcset = $(this).attr('srcset') || '';
            
            $mainImage.attr('src', newSrc);
            if (newSrcset) {
                $mainImage.attr('srcset', newSrcset);
            }
            
            $thumbnails.removeClass('active');
            $(this).addClass('active');
        });
    }

    /**
     * Checkout Enhancements
     */
    function initCheckoutEnhancements() {
        // Form validation improvements
        $('.checkout .input-text').on('blur', function() {
            validateField($(this));
        });
        
        // Auto-format phone numbers
        $('input[type="tel"]').on('input', function() {
            formatPhoneNumber($(this));
        });
    }

    /**
     * Field Validation
     */
    function validateField($field) {
        const value = $field.val().trim();
        const fieldType = $field.attr('type');
        const isRequired = $field.prop('required');
        
        $field.removeClass('error');
        
        if (isRequired && !value) {
            $field.addClass('error');
            return false;
        }
        
        if (fieldType === 'email' && value && !isValidEmail(value)) {
            $field.addClass('error');
            return false;
        }
        
        return true;
    }

    /**
     * Email Validation
     */
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    /**
     * Phone Number Formatting
     */
    function formatPhoneNumber($input) {
        let value = $input.val().replace(/\D/g, '');
        
        if (value.length >= 10) {
            value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
        } else if (value.length >= 6) {
            value = value.replace(/(\d{3})(\d{3})/, '($1) $2-');
        } else if (value.length >= 3) {
            value = value.replace(/(\d{3})/, '($1) ');
        }
        
        $input.val(value);
    }

    /**
     * Show Notification
     */
    function showNotification(message, type = 'info') {
        const notification = $(`
            <div class="notification notification-${type}">
                <div class="notification-content">
                    <span class="material-icons">${getNotificationIcon(type)}</span>
                    <span class="notification-message">${message}</span>
                    <button class="notification-close" aria-label="Close">
                        <span class="material-icons">close</span>
                    </button>
                </div>
            </div>
        `);
        
        $('body').append(notification);
        
        notification.addClass('show');
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            hideNotification(notification);
        }, 5000);
        
        // Close button
        notification.find('.notification-close').on('click', function() {
            hideNotification(notification);
        });
    }

    /**
     * Hide Notification
     */
    function hideNotification($notification) {
        $notification.removeClass('show');
        setTimeout(() => {
            $notification.remove();
        }, 300);
    }

    /**
     * Get Notification Icon
     */
    function getNotificationIcon(type) {
        const icons = {
            success: 'check_circle',
            error: 'error',
            warning: 'warning',
            info: 'info'
        };
        return icons[type] || icons.info;
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
     * Throttle function
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

    // Window resize handler with throttling
    $(window).on('resize', throttle(function() {
        // Handle responsive changes
        if ($(window).width() > 768) {
            $('.main-navigation').removeClass('is-open');
            $('body').removeClass('mobile-menu-open');
            $('.mobile-menu-toggle').attr('aria-expanded', false);
        }
    }, 250));

    // Scroll handler with throttling
    $(window).on('scroll', throttle(function() {
        const scrollTop = $(this).scrollTop();
        
        // Header scroll effects
        if (scrollTop > 100) {
            $('body').addClass('scrolled');
        } else {
            $('body').removeClass('scrolled');
        }
        
        // Parallax effects (if enabled)
        if ($('.parallax').length) {
            $('.parallax').each(function() {
                const $this = $(this);
                const speed = $this.data('speed') || 0.5;
                const yPos = -(scrollTop * speed);
                $this.css('transform', `translateY(${yPos}px)`);
            });
        }
    }, 16)); // ~60fps

})(jQuery);

// Print styles and functionality
window.addEventListener('beforeprint', function() {
    document.body.classList.add('printing');
});

window.addEventListener('afterprint', function() {
    document.body.classList.remove('printing');
});