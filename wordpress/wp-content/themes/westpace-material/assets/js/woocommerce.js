/*!
 * Complete WooCommerce JavaScript for Westpace Material Theme
 * Version: 3.0.0
 * Description: Enhanced WooCommerce functionality with Material Design interactions
 * Dependencies: jQuery, WooCommerce
 */

(function($) {
    'use strict';

    // Initialize when document is ready
    $(document).ready(function() {
        WestpaceWooCommerce.init();
    });

    // Main WooCommerce object
    const WestpaceWooCommerce = {
        
        // Configuration
        config: {
            ajaxUrl: westpaceData?.ajaxUrl || '/wp-admin/admin-ajax.php',
            nonce: westpaceData?.nonce || '',
            strings: westpaceData?.strings || {},
            debounceDelay: 300,
            notificationDuration: 5000,
            animationDuration: 300
        },

        // Cache selectors
        cache: {
            $window: $(window),
            $document: $(document),
            $body: $('body'),
            $cart: $('.cart-count'),
            $products: $('.woocommerce ul.products'),
            $singleProduct: $('.single-product'),
            $cartPage: $('.cart-page'),
            $checkoutPage: $('.checkout-page')
        },

        /**
         * Initialize all WooCommerce enhancements
         */
        init: function() {
            this.bindEvents();
            this.enhanceAddToCart();
            this.enhanceQuantityInputs();
            this.enhanceProductGallery();
            this.enhanceCheckoutForm();
            this.enhanceCartPage();
            this.enhanceMyAccount();
            this.initNotificationSystem();
            this.initQuickView();
            this.initLazyLoading();
            this.initAccessibilityFeatures();
            this.initPerformanceOptimizations();
            
            console.log('WestpaceWooCommerce initialized successfully');
        },

        /**
         * Bind global events
         */
        bindEvents: function() {
            const self = this;

            // Window events
            this.cache.$window.on('resize.westpace', this.debounce(this.handleResize.bind(this), this.config.debounceDelay));
            this.cache.$window.on('scroll.westpace', this.throttle(this.handleScroll.bind(this), 16));

            // Document events
            this.cache.$document.on('wc_fragments_refreshed wc_fragments_loaded', this.updateCartFragments.bind(this));
            this.cache.$document.on('updated_wc_div', this.handleCartUpdate.bind(this));

            // Custom events
            this.cache.$document.on('westpace:product:added', this.handleProductAdded.bind(this));
            this.cache.$document.on('westpace:cart:updated', this.handleCartUpdated.bind(this));
        },

        /**
         * Enhanced Add to Cart functionality
         */
        enhanceAddToCart: function() {
            const self = this;

            // Handle add to cart button clicks
            this.cache.$document.on('click', '.add-to-cart-btn:not(.product_type_variable, .product_type_grouped)', function(e) {
                e.preventDefault();
                
                const $button = $(this);
                const productId = $button.data('product_id');
                const quantity = $button.closest('.product').find('.qty').val() || 1;
                const variationId = $button.data('variation_id') || 0;
                
                if (!productId) return;
                
                self.addToCart(productId, quantity, variationId, $button);
            });

            // Handle AJAX add to cart on single product page
            this.cache.$document.on('click', '.single_add_to_cart_button:not(.product_type_variable, .product_type_grouped)', function(e) {
                if (!$(this).hasClass('ajax_add_to_cart')) return;
                
                e.preventDefault();
                
                const $button = $(this);
                const $form = $button.closest('form.cart');
                const productId = $form.find('[name="add-to-cart"]').val() || $button.val();
                const quantity = $form.find('[name="quantity"]').val() || 1;
                
                self.addToCart(productId, quantity, 0, $button);
            });

            // Handle variable product add to cart
            this.cache.$document.on('click', '.single_add_to_cart_button.product_type_variable', function(e) {
                const $button = $(this);
                const $form = $button.closest('form.cart');
                
                // Add loading state
                $button.addClass('loading').prop('disabled', true);
                
                // Let WooCommerce handle variable products normally
                setTimeout(function() {
                    $button.removeClass('loading').prop('disabled', false);
                }, 2000);
            });
        },

        /**
         * AJAX Add to Cart function
         */
        addToCart: function(productId, quantity, variationId, $button) {
            const self = this;
            
            // Validation
            if (!productId || quantity < 1) {
                this.showNotification('Invalid product or quantity', 'error');
                return;
            }

            // Show loading state
            this.setButtonLoading($button, true);
            
            // Prepare data
            const data = {
                action: 'westpace_add_to_cart',
                product_id: productId,
                quantity: quantity,
                variation_id: variationId,
                nonce: this.config.nonce
            };

            // AJAX request
            $.ajax({
                type: 'POST',
                url: this.config.ajaxUrl,
                data: data,
                timeout: 10000,
                success: function(response) {
                    if (response.success) {
                        self.handleAddToCartSuccess(response.data, $button);
                    } else {
                        self.handleAddToCartError(response.data, $button);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Add to cart error:', error);
                    self.handleAddToCartError({ message: 'Network error occurred' }, $button);
                },
                complete: function() {
                    self.setButtonLoading($button, false);
                }
            });
        },

        /**
         * Handle successful add to cart
         */
        handleAddToCartSuccess: function(data, $button) {
            // Update cart count
            if (data.cart_count !== undefined) {
                this.updateCartCount(data.cart_count);
            }

            // Show success notification
            this.showNotification(this.config.strings.addedToCart || 'Product added to cart!', 'success');

            // Update button state
            this.setButtonSuccess($button);

            // Trigger custom event
            this.cache.$document.trigger('westpace:product:added', [data, $button]);

            // Update cart fragments if available
            if (typeof wc_add_to_cart_params !== 'undefined') {
                $(document.body).trigger('wc_fragment_refresh');
            }
        },

        /**
         * Handle add to cart error
         */
        handleAddToCartError: function(data, $button) {
            const message = data?.message || this.config.strings.cartError || 'Error adding product to cart';
            this.showNotification(message, 'error');
            
            // Reset button state
            this.setButtonDefault($button);
        },

        /**
         * Set button loading state
         */
        setButtonLoading: function($button, loading) {
            if (loading) {
                $button.addClass('loading').prop('disabled', true);
                $button.find('.button-text').text(this.config.strings.loading || 'Loading...');
                $button.find('.material-icons').text('hourglass_empty');
            } else {
                $button.removeClass('loading').prop('disabled', false);
            }
        },

        /**
         * Set button success state
         */
        setButtonSuccess: function($button) {
            $button.removeClass('loading').addClass('added');
            $button.find('.button-text').text('Added to Cart');
            $button.find('.material-icons').text('check');
            
            // Reset after delay
            setTimeout(() => {
                this.setButtonDefault($button);
            }, 3000);
        },

        /**
         * Set button default state
         */
        setButtonDefault: function($button) {
            $button.removeClass('loading added').prop('disabled', false);
            $button.find('.button-text').text('Add to Cart');
            $button.find('.material-icons').text('shopping_cart');
        },

        /**
         * Enhanced quantity inputs with +/- buttons
         */
        enhanceQuantityInputs: function() {
            const self = this;

            // Add quantity control buttons
            this.cache.$document.on('init', '.woocommerce .quantity', function() {
                self.initQuantityButtons($(this));
            });

            // Initialize existing quantity inputs
            $('.woocommerce .quantity').each(function() {
                self.initQuantityButtons($(this));
            });

            // Handle quantity button clicks
            this.cache.$document.on('click', '.qty-btn', function(e) {
                e.preventDefault();
                self.handleQuantityChange($(this));
            });

            // Handle manual quantity input
            this.cache.$document.on('change input', '.qty', function() {
                self.validateQuantityInput($(this));
            });
        },

        /**
         * Initialize quantity buttons for a quantity input
         */
        initQuantityButtons: function($quantity) {
            const $input = $quantity.find('.qty');
            
            if ($quantity.find('.qty-btn').length > 0) return; // Already initialized
            
            const inputHtml = $input.prop('outerHTML');
            $input.remove();
            
            $quantity.html(`
                <div class="qty-input-wrapper">
                    <button type="button" class="qty-btn qty-minus" aria-label="Decrease quantity">
                        <span class="material-icons">remove</span>
                    </button>
                    ${inputHtml}
                    <button type="button" class="qty-btn qty-plus" aria-label="Increase quantity">
                        <span class="material-icons">add</span>
                    </button>
                </div>
            `);
        },

        /**
         * Handle quantity button changes
         */
        handleQuantityChange: function($button) {
            const $input = $button.siblings('.qty');
            const currentVal = parseInt($input.val()) || 1;
            const min = parseInt($input.attr('min')) || 1;
            const max = parseInt($input.attr('max')) || 999;
            const step = parseInt($input.attr('step')) || 1;
            
            let newVal = currentVal;
            
            if ($button.hasClass('qty-plus') && currentVal < max) {
                newVal = Math.min(currentVal + step, max);
            } else if ($button.hasClass('qty-minus') && currentVal > min) {
                newVal = Math.max(currentVal - step, min);
            }
            
            if (newVal !== currentVal) {
                $input.val(newVal).trigger('change');
                
                // Add visual feedback
                $button.addClass('pressed');
                setTimeout(() => $button.removeClass('pressed'), 150);
                
                // Update cart if on cart page
                if (this.cache.$body.hasClass('woocommerce-cart')) {
                    $('[name="update_cart"]').prop('disabled', false).addClass('needs-update');
                }
            }
        },

        /**
         * Validate quantity input
         */
        validateQuantityInput: function($input) {
            const val = parseInt($input.val());
            const min = parseInt($input.attr('min')) || 1;
            const max = parseInt($input.attr('max')) || 999;
            
            if (isNaN(val) || val < min) {
                $input.val(min);
            } else if (val > max) {
                $input.val(max);
            }
        },

        /**
         * Enhanced product gallery
         */
        enhanceProductGallery: function() {
            if (!this.cache.$singleProduct.length) return;

            const self = this;

            // Add zoom effect on hover
            this.cache.$document.on('mouseenter', '.woocommerce-product-gallery__image', function() {
                $(this).find('img').addClass('zoomed');
            }).on('mouseleave', '.woocommerce-product-gallery__image', function() {
                $(this).find('img').removeClass('zoomed');
            });

            // Enhanced thumbnail navigation
            this.cache.$document.on('click', '.flex-control-thumbs img', function() {
                const $thumb = $(this);
                const $container = $thumb.closest('.flex-control-thumbs');
                
                $container.find('img').removeClass('active');
                $thumb.addClass('active');
                
                // Add loading state to main image
                const $mainImage = $('.woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image img').first();
                $mainImage.addClass('loading');
                
                setTimeout(() => {
                    $mainImage.removeClass('loading');
                }, 300);
            });

            // Add lightbox enhancement
            this.initProductLightbox();
        },

        /**
         * Initialize product lightbox
         */
        initProductLightbox: function() {
            // Simple lightbox implementation
            this.cache.$document.on('click', '.woocommerce-product-gallery__image a', function(e) {
                if ($(window).width() < 768) return; // Disable on mobile
                
                e.preventDefault();
                
                const $link = $(this);
                const imageUrl = $link.attr('href');
                const alt = $link.find('img').attr('alt') || '';
                
                const lightboxHtml = `
                    <div class="westpace-lightbox">
                        <div class="lightbox-overlay"></div>
                        <div class="lightbox-content">
                            <img src="${imageUrl}" alt="${alt}">
                            <button class="lightbox-close" aria-label="Close lightbox">
                                <span class="material-icons">close</span>
                            </button>
                        </div>
                    </div>
                `;
                
                $('body').append(lightboxHtml).addClass('lightbox-open');
                
                // Close lightbox events
                $('.lightbox-overlay, .lightbox-close').on('click', function() {
                    $('.westpace-lightbox').fadeOut(300, function() {
                        $(this).remove();
                        $('body').removeClass('lightbox-open');
                    });
                });
                
                // ESC key to close
                $(document).on('keyup.lightbox', function(e) {
                    if (e.keyCode === 27) {
                        $('.lightbox-close').trigger('click');
                        $(document).off('keyup.lightbox');
                    }
                });
            });
        },

        /**
         * Enhanced checkout form validation and UX
         */
        enhanceCheckoutForm: function() {
            if (!this.cache.$checkoutPage.length) return;

            const self = this;
            const $checkoutForm = $('form.checkout');
            
            if (!$checkoutForm.length) return;

            // Real-time field validation
            $checkoutForm.find('input[required], select[required]').on('blur', function() {
                self.validateField($(this));
            });

            // Email validation
            $checkoutForm.find('input[type="email"]').on('blur', function() {
                self.validateEmailField($(this));
            });

            // Phone validation
            $checkoutForm.find('input[type="tel"]').on('blur', function() {
                self.validatePhoneField($(this));
            });

            // Form submission enhancement
            $checkoutForm.on('submit', function() {
                self.handleCheckoutSubmission($(this));
            });

            // Payment method selection enhancement
            this.enhancePaymentMethods();

            // Auto-fill enhancements
            this.initCheckoutAutofill();
        },

        /**
         * Validate individual field
         */
        validateField: function($field) {
            const $row = $field.closest('.form-row');
            const value = $field.val().trim();
            const isRequired = $field.prop('required');
            
            $row.removeClass('woocommerce-validated woocommerce-invalid');
            
            if (isRequired && value === '') {
                $row.addClass('woocommerce-invalid');
                this.showFieldError($field, 'This field is required');
            } else if (value !== '') {
                $row.addClass('woocommerce-validated');
                this.hideFieldError($field);
            }
        },

        /**
         * Validate email field
         */
        validateEmailField: function($field) {
            const $row = $field.closest('.form-row');
            const email = $field.val().trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            $row.removeClass('woocommerce-validated woocommerce-invalid');
            
            if (email && !emailRegex.test(email)) {
                $row.addClass('woocommerce-invalid');
                this.showFieldError($field, 'Please enter a valid email address');
            } else if (email) {
                $row.addClass('woocommerce-validated');
                this.hideFieldError($field);
            }
        },

        /**
         * Validate phone field
         */
        validatePhoneField: function($field) {
            const $row = $field.closest('.form-row');
            const phone = $field.val().trim();
            const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
            
            $row.removeClass('woocommerce-validated woocommerce-invalid');
            
            if (phone && !phoneRegex.test(phone.replace(/[\s\-\(\)]/g, ''))) {
                $row.addClass('woocommerce-invalid');
                this.showFieldError($field, 'Please enter a valid phone number');
            } else if (phone) {
                $row.addClass('woocommerce-validated');
                this.hideFieldError($field);
            }
        },

        /**
         * Show field error
         */
        showFieldError: function($field, message) {
            const $row = $field.closest('.form-row');
            let $error = $row.find('.field-error');
            
            if (!$error.length) {
                $error = $('<span class="field-error"></span>');
                $row.append($error);
            }
            
            $error.text(message).fadeIn();
        },

        /**
         * Hide field error
         */
        hideFieldError: function($field) {
            const $row = $field.closest('.form-row');
            $row.find('.field-error').fadeOut();
        },

        /**
         * Enhanced payment methods
         */
        enhancePaymentMethods: function() {
            // Add visual enhancements to payment methods
            $('#payment ul.payment_methods li').each(function() {
                const $li = $(this);
                const $radio = $li.find('input[type="radio"]');
                const $label = $li.find('label');
                
                $li.on('click', function() {
                    if (!$radio.prop('checked')) {
                        $radio.prop('checked', true).trigger('change');
                    }
                });
                
                $radio.on('change', function() {
                    $('#payment ul.payment_methods li').removeClass('selected');
                    if (this.checked) {
                        $li.addClass('selected');
                    }
                });
            });

            // Initialize selected state
            $('#payment ul.payment_methods input:checked').closest('li').addClass('selected');
        },

        /**
         * Initialize checkout autofill
         */
        initCheckoutAutofill: function() {
            // Simple autofill for billing = shipping
            $('#ship-to-different-address-checkbox').on('change', function() {
                if (!this.checked) {
                    // Copy billing to shipping
                    $('[name^="billing_"]').each(function() {
                        const $billing = $(this);
                        const shippingName = $billing.attr('name').replace('billing_', 'shipping_');
                        const $shipping = $('[name="' + shippingName + '"]');
                        
                        if ($shipping.length) {
                            $shipping.val($billing.val());
                        }
                    });
                }
            });
        },

        /**
         * Handle checkout form submission
         */
        handleCheckoutSubmission: function($form) {
            // Add visual feedback
            $form.addClass('processing');
            $('body').addClass('checkout-processing');
            
            // Show processing overlay
            const $overlay = $('<div class="checkout-processing-overlay"><div class="processing-spinner"><span class="material-icons">hourglass_empty</span><p>Processing your order...</p></div></div>');
            $('body').append($overlay);
        },

        /**
         * Enhanced cart page functionality
         */
        enhanceCartPage: function() {
            if (!this.cache.$cartPage.length) return;

            const self = this;

            // Enhanced remove from cart
            this.cache.$document.on('click', '.product-remove a', function(e) {
                const $link = $(this);
                const $row = $link.closest('tr');
                
                // Add confirmation for expensive items
                const price = $row.find('.product-subtotal .amount').text();
                const productName = $row.find('.product-name a').text();
                
                if (self.shouldConfirmRemoval(price)) {
                    e.preventDefault();
                    self.confirmRemoveFromCart($link, productName);
                } else {
                    // Add fade out effect
                    $row.addClass('removing');
                }
            });

            // Auto-update cart on quantity change
            this.cache.$document.on('change', '.cart .qty', this.debounce(function() {
                if (typeof wc_add_to_cart_params !== 'undefined' && wc_add_to_cart_params.cart_refresh_enabled) {
                    $('[name="update_cart"]').trigger('click');
                }
            }, 1000));

            // Enhanced cart update feedback
            this.cache.$document.on('updated_wc_div', function() {
                self.handleCartPageUpdate();
            });
        },

        /**
         * Check if removal should be confirmed
         */
        shouldConfirmRemoval: function(priceText) {
            const priceNumber = parseFloat(priceText.replace(/[^\d.,]/g, '').replace(',', '.'));
            return priceNumber > 100; // Configurable threshold
        },

        /**
         * Confirm remove from cart
         */
        confirmRemoveFromCart: function($link, productName) {
            const confirmed = confirm(`Are you sure you want to remove "${productName}" from your cart?`);
            if (confirmed) {
                $link.closest('tr').addClass('removing');
                window.location.href = $link.attr('href');
            }
        },

        /**
         * Handle cart page updates
         */
        handleCartPageUpdate: function() {
            // Animate updated elements
            $('.cart_totals').addClass('fade-in');
            $('.shop_table').addClass('scale-in');
            
            setTimeout(() => {
                $('.cart_totals, .shop_table').removeClass('fade-in scale-in');
            }, this.config.animationDuration);

            // Show update notification
            this.showNotification('Cart updated successfully', 'success');
        },

        /**
         * Enhanced My Account page
         */
        enhanceMyAccount: function() {
            if (!this.cache.$body.hasClass('woocommerce-account')) return;

            // Enhanced navigation
            $('.woocommerce-MyAccount-navigation a').on('click', function() {
                $(this).addClass('loading');
            });

            // Form enhancements
            this.enhanceAccountForms();

            // Order tracking enhancements
            this.enhanceOrderTracking();
        },

        /**
         * Enhanced account forms
         */
        enhanceAccountForms: function() {
            // Password strength indicator
            $('input[type="password"]').on('input', this.debounce(function() {
                // Simple password strength check
                const password = $(this).val();
                const strength = this.checkPasswordStrength(password);
                this.showPasswordStrength($(this), strength);
            }.bind(this), 300));

            // Form validation
            $('.woocommerce-EditAccountForm').on('submit', function(e) {
                // Add custom validation logic here
            });
        },

        /**
         * Check password strength
         */
        checkPasswordStrength: function(password) {
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/\d/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;
            
            return strength;
        },

        /**
         * Show password strength indicator
         */
        showPasswordStrength: function($input, strength) {
            let $indicator = $input.siblings('.password-strength');
            
            if (!$indicator.length) {
                $indicator = $('<div class="password-strength"><div class="strength-bar"></div><span class="strength-text"></span></div>');
                $input.after($indicator);
            }
            
            const strengthTexts = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
            const strengthClasses = ['very-weak', 'weak', 'fair', 'good', 'strong'];
            
            $indicator.removeClass(strengthClasses.join(' ')).addClass(strengthClasses[strength] || 'very-weak');
            $indicator.find('.strength-text').text(strengthTexts[strength] || 'Very Weak');
        },

        /**
         * Enhanced order tracking
         */
        enhanceOrderTracking: function() {
            // Add order status visual enhancements
            $('.order-status').each(function() {
                const $status = $(this);
                const status = $status.text().toLowerCase();
                
                // Add appropriate icon
                const icons = {
                    'pending': 'schedule',
                    'processing': 'autorenew',
                    'shipped': 'local_shipping',
                    'delivered': 'done',
                    'completed': 'check_circle',
                    'cancelled': 'cancel',
                    'refunded': 'undo'
                };
                
                const icon = icons[status] || 'info';
                $status.prepend(`<span class="material-icons">${icon}</span>`);
            });
        },

        /**
         * Notification system
         */
        initNotificationSystem: function() {
            // Create notification container if it doesn't exist
            if (!$('#westpace-notifications').length) {
                $('body').append('<div id="westpace-notifications"></div>');
            }
        },

        /**
         * Show notification
         */
        showNotification: function(message, type = 'info', duration = null) {
            const notificationId = 'notification-' + Date.now();
            const displayDuration = duration || this.config.notificationDuration;
            
            const $notification = $(`
                <div id="${notificationId}" class="westpace-notification westpace-notification--${type}">
                    <div class="notification-content">
                        <span class="material-icons">${this.getNotificationIcon(type)}</span>
                        <span class="notification-message">${message}</span>
                        <button class="notification-close" aria-label="Close notification">
                            <span class="material-icons">close</span>
                        </button>
                    </div>
                </div>
            `);
            
            $('#westpace-notifications').append($notification);
            
            // Animate in
            requestAnimationFrame(() => {
                $notification.addClass('show');
            });
            
            // Auto close
            const autoCloseTimer = setTimeout(() => {
                this.hideNotification($notification);
            }, displayDuration);
            
            // Manual close
            $notification.find('.notification-close').on('click', () => {
                clearTimeout(autoCloseTimer);
                this.hideNotification($notification);
            });
            
            return $notification;
        },

        /**
         * Hide notification
         */
        hideNotification: function($notification) {
            $notification.removeClass('show');
            setTimeout(() => {
                $notification.remove();
            }, this.config.animationDuration);
        },

        /**
         * Get notification icon based on type
         */
        getNotificationIcon: function(type) {
            const icons = {
                success: 'check_circle',
                error: 'error',
                warning: 'warning',
                info: 'info'
            };
            return icons[type] || icons.info;
        },

        /**
         * Quick view functionality
         */
        initQuickView: function() {
            const self = this;

            // Add quick view buttons to products
            this.cache.$products.find('li.product').each(function() {
                const $product = $(this);
                const productId = $product.find('.add-to-cart-btn').data('product_id');
                
                if (productId && !$product.find('.quick-view-btn').length) {
                    const $quickViewBtn = $(`
                        <button class="quick-view-btn" data-product-id="${productId}" aria-label="Quick view product">
                            <span class="material-icons">visibility</span>
                        </button>
                    `);
                    $product.append($quickViewBtn);
                }
            });
            
            // Handle quick view clicks
            this.cache.$document.on('click', '.quick-view-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const productId = $(this).data('product-id');
                self.openQuickView(productId);
            });
        },

        /**
         * Open quick view modal
         */
        openQuickView: function(productId) {
            const self = this;
            
            // Create modal if it doesn't exist
            if (!$('#quick-view-modal').length) {
                const modalHtml = `
                    <div id="quick-view-modal" class="quick-view-modal" role="dialog" aria-modal="true" aria-labelledby="quick-view-title">
                        <div class="quick-view-overlay"></div>
                        <div class="quick-view-content">
                            <button class="quick-view-close" aria-label="Close quick view">
                                <span class="material-icons">close</span>
                            </button>
                            <div class="quick-view-loading">
                                <span class="material-icons">hourglass_empty</span>
                                <p>Loading product...</p>
                            </div>
                            <div class="quick-view-product"></div>
                        </div>
                    </div>
                `;
                $('body').append(modalHtml);
            }
            
            const $modal = $('#quick-view-modal');
            const $content = $modal.find('.quick-view-product');
            const $loading = $modal.find('.quick-view-loading');
            
            // Show modal and loading
            $modal.fadeIn(this.config.animationDuration);
            $loading.show();
            $content.hide();
            $('body').addClass('quick-view-open');
            
            // Focus management
            $modal.find('.quick-view-close').focus();
            
            // Load product via AJAX
            $.ajax({
                url: this.config.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'westpace_quick_view',
                    product_id: productId,
                    nonce: this.config.nonce
                },
                timeout: 10000,
                success: function(response) {
                    if (response.success) {
                        $content.html(response.data.html);
                        $loading.hide();
                        $content.fadeIn(self.config.animationDuration);
                        
                        // Initialize enhancements for quick view content
                        self.initQuickViewEnhancements($content);
                    } else {
                        self.closeQuickView();
                        self.showNotification('Error loading product', 'error');
                    }
                },
                error: function() {
                    self.closeQuickView();
                    self.showNotification('Network error occurred', 'error');
                }
            });
            
            // Close modal handlers
            $modal.find('.quick-view-close, .quick-view-overlay').on('click', function() {
                self.closeQuickView();
            });
            
            // ESC key to close
            $(document).on('keyup.quickview', function(e) {
                if (e.keyCode === 27) {
                    self.closeQuickView();
                }
            });
        },

        /**
         * Initialize quick view enhancements
         */
        initQuickViewEnhancements: function($content) {
            // Initialize quantity buttons
            $content.find('.quantity').each((index, element) => {
                this.initQuantityButtons($(element));
            });

            // Initialize gallery if present
            this.initProductLightbox();
        },

        /**
         * Close quick view modal
         */
        closeQuickView: function() {
            const $modal = $('#quick-view-modal');
            $modal.fadeOut(this.config.animationDuration);
            $('body').removeClass('quick-view-open');
            $(document).off('keyup.quickview');
        },

        /**
         * Initialize lazy loading for images
         */
        initLazyLoading: function() {
            if (!('IntersectionObserver' in window)) {
                // Fallback for older browsers
                $('img[data-src]').each(function() {
                    const $img = $(this);
                    $img.attr('src', $img.data('src')).addClass('loaded');
                });
                return;
            }

            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        const $img = $(img);
                        
                        img.src = img.dataset.src;
                        $img.removeClass('lazy').addClass('loaded');
                        
                        // Add fade in effect
                        $img.on('load', function() {
                            $(this).addClass('fade-in');
                        });
                        
                        imageObserver.unobserve(img);
                    }
                });
            }, {
                rootMargin: '50px 0px',
                threshold: 0.01
            });

            // Observe all lazy images
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        },

        /**
         * Initialize accessibility features
         */
        initAccessibilityFeatures: function() {
            // Add ARIA labels to buttons without text
            $('.add-to-cart-btn, .quick-view-btn, .qty-btn').each(function() {
                const $btn = $(this);
                if (!$btn.attr('aria-label') && !$btn.text().trim()) {
                    const action = $btn.hasClass('add-to-cart-btn') ? 'Add to cart' :
                                  $btn.hasClass('quick-view-btn') ? 'Quick view' :
                                  $btn.hasClass('qty-plus') ? 'Increase quantity' :
                                  $btn.hasClass('qty-minus') ? 'Decrease quantity' : 'Button';
                    $btn.attr('aria-label', action);
                }
            });

            // Enhance keyboard navigation
            this.enhanceKeyboardNavigation();

            // Add screen reader announcements
            this.initScreenReaderAnnouncements();
        },

        /**
         * Enhance keyboard navigation
         */
        enhanceKeyboardNavigation: function() {
            // Add proper focus management for quantity buttons
            this.cache.$document.on('keydown', '.qty-btn', function(e) {
                if (e.keyCode === 13 || e.keyCode === 32) { // Enter or Space
                    e.preventDefault();
                    $(this).trigger('click');
                }
            });

            // Improve modal focus management
            this.cache.$document.on('keydown', '.quick-view-modal', function(e) {
                if (e.keyCode === 9) { // Tab
                    // Implement focus trap here if needed
                }
            });
        },

        /**
         * Initialize screen reader announcements
         */
        initScreenReaderAnnouncements: function() {
            // Create announcement container
            if (!$('#wc-announcements').length) {
                $('body').append('<div id="wc-announcements" aria-live="polite" aria-atomic="true" class="sr-only"></div>');
            }

            // Announce cart updates
            this.cache.$document.on('westpace:product:added', function() {
                $('#wc-announcements').text('Product added to cart');
            });

            this.cache.$document.on('westpace:cart:updated', function() {
                $('#wc-announcements').text('Cart updated');
            });
        },

        /**
         * Performance optimizations
         */
        initPerformanceOptimizations: function() {
            // Preload critical images
            this.preloadCriticalImages();

            // Optimize scroll events
            this.optimizeScrollEvents();

            // Prefetch on hover
            this.initHoverPrefetch();
        },

        /**
         * Preload critical images
         */
        preloadCriticalImages: function() {
            // Preload first few product images
            $('.woocommerce ul.products li.product img').slice(0, 6).each(function() {
                const $img = $(this);
                if ($img.data('src')) {
                    const preloadImg = new Image();
                    preloadImg.src = $img.data('src');
                }
            });
        },

        /**
         * Optimize scroll events
         */
        optimizeScrollEvents: function() {
            let ticking = false;
            
            this.cache.$window.on('scroll.performance', () => {
                if (!ticking) {
                    requestAnimationFrame(() => {
                        this.handleOptimizedScroll();
                        ticking = false;
                    });
                    ticking = true;
                }
            });
        },

        /**
         * Handle optimized scroll
         */
        handleOptimizedScroll: function() {
            // Add scroll-based enhancements here
            const scrollTop = this.cache.$window.scrollTop();
            
            // Example: Show back to top button
            if (scrollTop > 500) {
                this.showBackToTop();
            } else {
                this.hideBackToTop();
            }
        },

        /**
         * Show back to top button
         */
        showBackToTop: function() {
            if (!$('#back-to-top').length) {
                const $backToTop = $(`
                    <button id="back-to-top" class="back-to-top" aria-label="Back to top">
                        <span class="material-icons">keyboard_arrow_up</span>
                    </button>
                `);
                $('body').append($backToTop);
                
                $backToTop.on('click', function() {
                    $('html, body').animate({ scrollTop: 0 }, 500);
                });
            }
            $('#back-to-top').addClass('show');
        },

        /**
         * Hide back to top button
         */
        hideBackToTop: function() {
            $('#back-to-top').removeClass('show');
        },

        /**
         * Initialize hover prefetch
         */
        initHoverPrefetch: function() {
            let prefetchTimeout;
            
            this.cache.$document.on('mouseenter', '.woocommerce ul.products li.product a', function() {
                const href = $(this).attr('href');
                
                if (href && !$(this).data('prefetched')) {
                    prefetchTimeout = setTimeout(() => {
                        // Simple prefetch
                        const link = document.createElement('link');
                        link.rel = 'prefetch';
                        link.href = href;
                        document.head.appendChild(link);
                        
                        $(this).data('prefetched', true);
                    }, 200);
                }
            }).on('mouseleave', '.woocommerce ul.products li.product a', function() {
                clearTimeout(prefetchTimeout);
            });
        },

        /**
         * Update cart fragments
         */
        updateCartFragments: function(event, fragments) {
            // Handle cart fragment updates
            if (fragments && fragments['.cart-count']) {
                $('.cart-count').html(fragments['.cart-count']);
            }
            
            // Trigger custom event
            this.cache.$document.trigger('westpace:cart:updated', [fragments]);
        },

        /**
         * Handle cart updates
         */
        handleCartUpdate: function() {
            // Add visual feedback for cart updates
            $('.cart_totals, .shop_table').addClass('updated');
            
            setTimeout(() => {
                $('.cart_totals, .shop_table').removeClass('updated');
            }, 1000);
        },

        /**
         * Update cart count
         */
        updateCartCount: function(count) {
            const $cartCount = $('.cart-count');
            
            if ($cartCount.length) {
                $cartCount.text(count).attr('data-count', count);
                
                // Add bounce animation
                $cartCount.addClass('bounce');
                setTimeout(() => {
                    $cartCount.removeClass('bounce');
                }, 600);
            }
        },

        /**
         * Handle product added event
         */
        handleProductAdded: function(event, data, $button) {
            // Custom logic for when product is added
            console.log('Product added:', data);
        },

        /**
         * Handle cart updated event
         */
        handleCartUpdated: function(event, fragments) {
            // Custom logic for when cart is updated
            console.log('Cart updated:', fragments);
        },

        /**
         * Handle window resize
         */
        handleResize: function() {
            // Handle responsive changes
            const windowWidth = this.cache.$window.width();
            
            if (windowWidth < 768) {
                this.enableMobileOptimizations();
            } else {
                this.disableMobileOptimizations();
            }
        },

        /**
         * Handle window scroll
         */
        handleScroll: function() {
            // Handle scroll-based features
        },

        /**
         * Enable mobile optimizations
         */
        enableMobileOptimizations: function() {
            // Disable hover effects on mobile
            this.cache.$body.addClass('mobile-device');
            
            // Simplify interactions for touch devices
            $('.quick-view-btn').hide();
        },

        /**
         * Disable mobile optimizations
         */
        disableMobileOptimizations: function() {
            this.cache.$body.removeClass('mobile-device');
            $('.quick-view-btn').show();
        },

        /**
         * Utility: Debounce function
         */
        debounce: function(func, wait, immediate) {
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
        },

        /**
         * Utility: Throttle function
         */
        throttle: function(func, limit) {
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
    };

    // Make WestpaceWooCommerce globally available
    window.WestpaceWooCommerce = WestpaceWooCommerce;

    // Additional CSS for JavaScript enhancements
    const enhancementCSS = `
        <style id="westpace-woocommerce-js-styles">
        /* Notification System */
        #westpace-notifications {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
            pointer-events: none;
        }

        .westpace-notification {
            pointer-events: auto;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            margin-bottom: 10px;
        }

        .westpace-notification.show {
            transform: translateX(0);
        }

        /* Loading States */
        .loading .material-icons {
            animation: spin 1s linear infinite;
        }

        .add-to-cart-btn.added {
            background-color: var(--wc-success) !important;
        }

        .add-to-cart-btn.loading {
            opacity: 0.7;
            pointer-events: none;
        }

        /* Quantity Controls */
        .qty-btn.pressed {
            transform: scale(0.95);
            background-color: var(--wc-primary) !important;
            color: white !important;
        }

        /* Form Validation */
        .field-error {
            display: none;
            color: var(--wc-error);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Password Strength */
        .password-strength {
            margin-top: 0.5rem;
        }

        .password-strength .strength-bar {
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 0.25rem;
        }

        .password-strength .strength-bar::before {
            content: '';
            display: block;
            height: 100%;
            transition: width 0.3s ease;
            border-radius: 2px;
        }

        .password-strength.very-weak .strength-bar::before {
            width: 20%;
            background: #ef4444;
        }

        .password-strength.weak .strength-bar::before {
            width: 40%;
            background: #f97316;
        }

        .password-strength.fair .strength-bar::before {
            width: 60%;
            background: #eab308;
        }

        .password-strength.good .strength-bar::before {
            width: 80%;
            background: #22c55e;
        }

        .password-strength.strong .strength-bar::before {
            width: 100%;
            background: #16a34a;
        }

        /* Lightbox */
        .westpace-lightbox {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lightbox-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(4px);
        }

        .lightbox-content {
            position: relative;
            max-width: 90vw;
            max-height: 90vh;
            z-index: 1;
        }

        .lightbox-content img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 20px 25px rgba(0, 0, 0, 0.5);
        }

        .lightbox-close {
            position: absolute;
            top: -40px;
            right: -40px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }

        .lightbox-close:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Back to Top */
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--wc-primary);
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .back-to-top.show {
            transform: translateY(0);
            opacity: 1;
        }

        .back-to-top:hover {
            background: var(--wc-primary-dark);
            transform: translateY(-2px);
        }

        /* Checkout Processing */
        .checkout-processing-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .processing-spinner {
            text-align: center;
            color: var(--wc-primary);
        }

        .processing-spinner .material-icons {
            font-size: 3rem;
            animation: spin 1s linear infinite;
            margin-bottom: 1rem;
        }

        /* Cart Animations */
        .cart-count.bounce {
            animation: bounce 0.6s ease;
        }

        @keyframes bounce {
            0%, 20%, 53%, 80%, 100% {
                transform: translate3d(0, 0, 0);
            }
            40%, 43% {
                transform: translate3d(0, -30px, 0);
            }
            70% {
                transform: translate3d(0, -15px, 0);
            }
            90% {
                transform: translate3d(0, -4px, 0);
            }
        }

        /* Updated states */
        .updated {
            animation: pulse 0.5s ease;
        }

        /* Mobile optimizations */
        .mobile-device .hover-effects {
            display: none !important;
        }

        /* Screen reader only */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* High contrast mode */
        @media (prefers-contrast: high) {
            .add-to-cart-btn,
            .quick-view-btn,
            .qty-btn {
                border: 2px solid currentColor;
            }
        }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {
            .westpace-notification,
            .back-to-top,
            .quick-view-modal {
                transition: none;
            }
            
            .loading .material-icons {
                animation: none;
            }
        }
        </style>
    `;

    // Inject CSS
    if (!document.getElementById('westpace-woocommerce-js-styles')) {
        document.head.insertAdjacentHTML('beforeend', enhancementCSS);
    }

})(jQuery);

// Additional utility functions
if (typeof westpaceData === 'undefined') {
    window.westpaceData = {
        ajaxUrl: '/wp-admin/admin-ajax.php',
        nonce: '',
        strings: {
            loading: 'Loading...',
            addedToCart: 'Product added to cart!',
            cartError: 'Error adding product to cart.',
            newsletterSuccess: 'Thank you for subscribing!',
            newsletterError: 'Subscription failed. Please try again.'
        }
    };
}

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = WestpaceWooCommerce;
}