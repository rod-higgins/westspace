/**
 * Westpace Material Design Enhanced Theme JavaScript
 * Modern, responsive, and performance-optimized JavaScript
 * With comprehensive WooCommerce integration
 * 
 * @package Westpace_Material
 * @version 3.0.0
 */

(function($) {
    'use strict';

    // Theme object
    const WestpaceTheme = {
        
        // Initialize all functionality
        init: function() {
            this.navigation();
            this.materialDesign();
            this.woocommerce();
            this.search();
            this.forms();
            this.performance();
            this.accessibility();
            this.animations();
        },

        // Navigation functionality
        navigation: function() {
            // Mobile menu toggle
            $('.mobile-menu-toggle').on('click', function(e) {
                e.preventDefault();
                $(this).toggleClass('active');
                $('.mobile-menu').toggleClass('active');
                $('body').toggleClass('mobile-menu-open');
            });

            // Close mobile menu when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.mobile-menu, .mobile-menu-toggle').length) {
                    $('.mobile-menu-toggle').removeClass('active');
                    $('.mobile-menu').removeClass('active');
                    $('body').removeClass('mobile-menu-open');
                }
            });

            // Smooth scroll for anchor links
            $('a[href*="#"]:not([href="#"])').on('click', function(e) {
                if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
                    let target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    if (target.length) {
                        e.preventDefault();
                        $('html, body').animate({
                            scrollTop: target.offset().top - 80
                        }, 800);
                    }
                }
            });

            // Sticky header
            $(window).on('scroll', function() {
                if ($(this).scrollTop() > 100) {
                    $('.site-header').addClass('sticky');
                } else {
                    $('.site-header').removeClass('sticky');
                }
            });
        },

        // Material Design interactions
        materialDesign: function() {
            // Ripple effect for buttons
            $('.btn, .material-btn').on('click', function(e) {
                const btn = $(this);
                const ripple = $('<span class="ripple"></span>');
                
                btn.append(ripple);
                
                const max = Math.max(btn.outerWidth(), btn.outerHeight());
                const size = max;
                
                ripple.css({
                    width: size,
                    height: size,
                    left: e.pageX - btn.offset().left - size / 2,
                    top: e.pageY - btn.offset().top - size / 2
                }).addClass('animate');
                
                setTimeout(() => ripple.remove(), 600);
            });

            // Material card hover effects
            $('.material-card').hover(
                function() {
                    $(this).addClass('elevation-8');
                },
                function() {
                    $(this).removeClass('elevation-8');
                }
            );

            // Form field focus effects
            $('.form-field input, .form-field textarea').on('focus blur', function() {
                $(this).closest('.form-field').toggleClass('focused');
            });

            // Floating labels
            $('.form-field input, .form-field textarea').on('blur', function() {
                if ($(this).val()) {
                    $(this).closest('.form-field').addClass('has-value');
                } else {
                    $(this).closest('.form-field').removeClass('has-value');
                }
            });
        },

        // WooCommerce specific functionality
        woocommerce: function() {
            if (!westpaceData.isWooActive) return;

            // Enhanced AJAX add to cart
            $(document).on('click', '.ajax_add_to_cart', function(e) {
                e.preventDefault();
                
                const btn = $(this);
                const productId = btn.data('product_id');
                const originalText = btn.find('.btn-text').text();
                
                // Button loading state
                btn.addClass('loading').prop('disabled', true);
                btn.find('.btn-text').text(westpaceData.strings.loading);
                btn.find('.btn-icon').text('hourglass_empty');
                
                $.ajax({
                    type: 'POST',
                    url: wc_add_to_cart_params.ajax_url,
                    data: {
                        action: 'woocommerce_add_to_cart',
                        product_id: productId,
                        quantity: 1
                    },
                    success: function(response) {
                        if (response.error && response.product_url) {
                            window.location = response.product_url;
                            return;
                        }
                        
                        // Update cart fragments
                        $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, btn]);
                        
                        // Success state
                        btn.removeClass('loading').addClass('added');
                        btn.find('.btn-text').text(westpaceData.strings.addedToCart);
                        btn.find('.btn-icon').text('check_circle');
                        
                        // Show notification
                        WestpaceTheme.showNotification(westpaceData.strings.addedToCart, 'success');
                        
                        // Reset button after 2 seconds
                        setTimeout(() => {
                            btn.removeClass('added').prop('disabled', false);
                            btn.find('.btn-text').text(originalText);
                            btn.find('.btn-icon').text('add_shopping_cart');
                        }, 2000);
                    },
                    error: function() {
                        btn.removeClass('loading').prop('disabled', false);
                        btn.find('.btn-text').text(originalText);
                        btn.find('.btn-icon').text('add_shopping_cart');
                        
                        WestpaceTheme.showNotification(westpaceData.strings.cartError, 'error');
                    }
                });
            });

            // Quantity controls
            $(document).on('click', '.btn-quantity', function(e) {
                e.preventDefault();
                
                const btn = $(this);
                const input = btn.siblings('.qty');
                const currentVal = parseInt(input.val()) || 0;
                const max = parseInt(input.attr('max')) || 999;
                const min = parseInt(input.attr('min')) || 1;
                
                if (btn.hasClass('plus')) {
                    if (currentVal < max) {
                        input.val(currentVal + 1).trigger('change');
                    }
                } else {
                    if (currentVal > min) {
                        input.val(currentVal - 1).trigger('change');
                    }
                }
            });

            // Mini cart dropdown
            $('.mini-cart-trigger').hover(
                function() {
                    $(this).siblings('.mini-cart-dropdown').addClass('show');
                },
                function() {
                    setTimeout(() => {
                        if (!$('.mini-cart-dropdown:hover').length) {
                            $('.mini-cart-dropdown').removeClass('show');
                        }
                    }, 300);
                }
            );

            $('.mini-cart-dropdown').hover(
                function() {
                    $(this).addClass('show');
                },
                function() {
                    $(this).removeClass('show');
                }
            );

            // Product gallery enhancements
            if ($('.woocommerce-product-gallery').length) {
                // Zoom functionality
                $('.woocommerce-product-gallery__image img').on('click', function() {
                    $(this).toggleClass('zoomed');
                });

                // Image lazy loading
                $('img[data-src]').each(function() {
                    const img = $(this);
                    img.attr('src', img.data('src')).removeAttr('data-src').addClass('loaded');
                });
            }

            // Quick view functionality
            $(document).on('click', '.quick-view-btn', function(e) {
                e.preventDefault();
                
                const productId = $(this).data('product-id');
                WestpaceTheme.openQuickView(productId);
            });

            // Wishlist functionality
            $(document).on('click', '.wishlist-btn', function(e) {
                e.preventDefault();
                
                const btn = $(this);
                const productId = btn.data('product-id');
                const icon = btn.find('.material-icons');
                
                btn.addClass('loading');
                
                // Toggle wishlist state (you'd integrate with actual wishlist plugin)
                setTimeout(() => {
                    btn.removeClass('loading').toggleClass('active');
                    if (btn.hasClass('active')) {
                        icon.text('favorite');
                        WestpaceTheme.showNotification('Added to wishlist', 'success');
                    } else {
                        icon.text('favorite_border');
                        WestpaceTheme.showNotification('Removed from wishlist', 'info');
                    }
                }, 500);
            });

            // Enhanced product filters
            $('.shop-filters input[type="checkbox"]').on('change', function() {
                const filter = $(this);
                const form = filter.closest('form');
                
                // Add loading state
                $('.products').addClass('loading');
                
                // Submit form with AJAX (if AJAX filtering is implemented)
                // This would need additional backend support
            });

            // Checkout enhancements
            if ($('body').hasClass('woocommerce-checkout')) {
                // Form validation
                $('.checkout').on('submit', function() {
                    const btn = $('#place_order');
                    btn.find('.btn-text').hide();
                    btn.find('.btn-loading').show();
                });

                // Show/hide login form
                $('.show-login-form').on('click', function(e) {
                    e.preventDefault();
                    $('.woocommerce-form-login').slideToggle();
                });

                // Show/hide coupon form
                $('.show-coupon-form').on('click', function(e) {
                    e.preventDefault();
                    $('.checkout_coupon').slideToggle();
                });
            }
        },

        // Enhanced search functionality
        search: function() {
            const searchForm = $('.search-form');
            const searchInput = searchForm.find('input[type="search"]');
            const searchResults = $('<div class="search-results-dropdown"></div>');
            
            searchForm.append(searchResults);
            
            let searchTimeout;
            
            searchInput.on('input', function() {
                const keyword = $(this).val().trim();
                
                clearTimeout(searchTimeout);
                
                if (keyword.length < 3) {
                    searchResults.hide();
                    return;
                }
                
                searchTimeout = setTimeout(() => {
                    WestpaceTheme.performSearch(keyword, searchResults);
                }, 300);
            });
            
            // Hide search results when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.search-form').length) {
                    searchResults.hide();
                }
            });
        },

        // Perform AJAX search
        performSearch: function(keyword, resultsContainer) {
            $.ajax({
                url: westpaceData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'westpace_product_search',
                    keyword: keyword,
                    nonce: westpaceData.nonce
                },
                success: function(response) {
                    if (response.success && response.data.length > 0) {
                        let html = '<div class="search-results-header">Products</div>';
                        
                        response.data.forEach(product => {
                            html += `
                                <div class="search-result-item">
                                    <img src="${product.image}" alt="${product.title}" class="result-image">
                                    <div class="result-content">
                                        <h4><a href="${product.url}">${product.title}</a></h4>
                                        <div class="result-price">${product.price}</div>
                                    </div>
                                </div>
                            `;
                        });
                        
                        html += '<div class="search-results-footer"><a href="?s=' + keyword + '">View all results</a></div>';
                        
                        resultsContainer.html(html).show();
                    } else {
                        resultsContainer.html('<div class="no-results">No products found</div>').show();
                    }
                },
                error: function() {
                    resultsContainer.hide();
                }
            });
        },

        // Quick view modal
        openQuickView: function(productId) {
            const modal = $(`
                <div class="quick-view-modal">
                    <div class="modal-overlay"></div>
                    <div class="modal-content">
                        <button class="modal-close">
                            <span class="material-icons">close</span>
                        </button>
                        <div class="modal-body">
                            <div class="loading-spinner">
                                <span class="material-icons">hourglass_empty</span>
                                <p>Loading product...</p>
                            </div>
                        </div>
                    </div>
                </div>
            `);
            
            $('body').append(modal).addClass('modal-open');
            
            // Close modal handlers
            modal.on('click', '.modal-close, .modal-overlay', function() {
                WestpaceTheme.closeQuickView(modal);
            });
            
            // Load product data (you'd need to implement the backend endpoint)
            setTimeout(() => {
                modal.find('.modal-body').html(`
                    <div class="quick-view-content">
                        <div class="product-images">
                            <!-- Product images would load here -->
                        </div>
                        <div class="product-summary">
                            <!-- Product summary would load here -->
                        </div>
                    </div>
                `);
            }, 1000);
        },

        // Close quick view modal
        closeQuickView: function(modal) {
            modal.addClass('closing');
            $('body').removeClass('modal-open');
            
            setTimeout(() => {
                modal.remove();
            }, 300);
        },

        // Form enhancements
        forms: function() {
            // Newsletter subscription
            $('.newsletter-form').on('submit', function(e) {
                e.preventDefault();
                
                const form = $(this);
                const email = form.find('input[type="email"]').val();
                const btn = form.find('button[type="submit"]');
                const originalText = btn.text();
                
                btn.prop('disabled', true).text(westpaceData.strings.loading);
                
                $.ajax({
                    url: westpaceData.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'westpace_newsletter',
                        email: email,
                        nonce: westpaceData.nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            WestpaceTheme.showNotification(response.data, 'success');
                            form[0].reset();
                        } else {
                            WestpaceTheme.showNotification(response.data, 'error');
                        }
                    },
                    error: function() {
                        WestpaceTheme.showNotification(westpaceData.strings.newsletterError, 'error');
                    },
                    complete: function() {
                        btn.prop('disabled', false).text(originalText);
                    }
                });
            });

            // Form validation
            $('form').on('submit', function() {
                const form = $(this);
                let isValid = true;
                
                form.find('[required]').each(function() {
                    const field = $(this);
                    const fieldContainer = field.closest('.form-field');
                    
                    if (!field.val().trim()) {
                        fieldContainer.addClass('error');
                        isValid = false;
                    } else {
                        fieldContainer.removeClass('error');
                    }
                });
                
                return isValid;
            });
        },

        // Performance optimizations
        performance: function() {
            // Lazy load images
            const lazyImages = $('img[data-src]');
            
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            img.classList.add('loaded');
                            imageObserver.unobserve(img);
                        }
                    });
                });
                
                lazyImages.each(function() {
                    imageObserver.observe(this);
                });
            } else {
                // Fallback for older browsers
                lazyImages.each(function() {
                    const img = $(this);
                    img.attr('src', img.data('src')).removeClass('lazy').addClass('loaded');
                });
            }

            // Debounce scroll events
            let scrollTimeout;
            $(window).on('scroll', function() {
                if (scrollTimeout) {
                    clearTimeout(scrollTimeout);
                }
                scrollTimeout = setTimeout(() => {
                    $(document).trigger('scroll.debounced');
                }, 16);
            });
        },

        // Accessibility enhancements
        accessibility: function() {
            // Keyboard navigation for dropdowns
            $('.dropdown-toggle').on('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    $(this).click();
                }
            });

            // Focus management for modals
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && $('.modal').is(':visible')) {
                    $('.modal-close').click();
                }
            });

            // Skip links
            $('.skip-link').on('click', function(e) {
                const target = $($(this).attr('href'));
                if (target.length) {
                    target.focus();
                }
            });
        },

        // Animation utilities
        animations: function() {
            // Fade in elements on scroll
            const animateElements = $('.animate-on-scroll');
            
            const animateOnScroll = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                    }
                });
            }, {
                threshold: 0.1
            });
            
            animateElements.each(function() {
                animateOnScroll.observe(this);
            });

            // Stagger animations for product grids
            $('.products .product').each(function(index) {
                $(this).css('animation-delay', (index * 100) + 'ms');
            });
        },

        // Notification system
        showNotification: function(message, type = 'info') {
            const notification = $(`
                <div class="westpace-notification westpace-notification--${type}">
                    <div class="notification-content">
                        <span class="material-icons">${this.getNotificationIcon(type)}</span>
                        <span class="notification-message">${message}</span>
                        <button class="notification-close">
                            <span class="material-icons">close</span>
                        </button>
                    </div>
                </div>
            `);
            
            $('body').append(notification);
            
            // Show notification
            setTimeout(() => {
                notification.addClass('show');
            }, 100);
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                this.hideNotification(notification);
            }, 5000);
            
            // Close button handler
            notification.on('click', '.notification-close', () => {
                this.hideNotification(notification);
            });
        },

        // Hide notification
        hideNotification: function(notification) {
            notification.removeClass('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        },

        // Get notification icon
        getNotificationIcon: function(type) {
            const icons = {
                success: 'check_circle',
                error: 'error',
                warning: 'warning',
                info: 'info'
            };
            return icons[type] || icons.info;
        }
    };

    // Initialize theme when document is ready
    $(document).ready(function() {
        WestpaceTheme.init();
    });

    // Back to top button
    $(window).on('scroll.debounced', function() {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn();
        } else {
            $('.back-to-top').fadeOut();
        }
    });

    $('.back-to-top').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, 800);
    });

    // Cookie consent (if needed)
    if (!localStorage.getItem('cookie-consent')) {
        const cookieBanner = $(`
            <div class="cookie-consent">
                <div class="cookie-content">
                    <p>We use cookies to enhance your experience. By continuing to visit this site you agree to our use of cookies.</p>
                    <button class="btn btn-primary accept-cookies">Accept</button>
                </div>
            </div>
        `);
        
        $('body').append(cookieBanner);
        
        $('.accept-cookies').on('click', function() {
            localStorage.setItem('cookie-consent', 'true');
            cookieBanner.fadeOut();
        });
    }

})(jQuery);