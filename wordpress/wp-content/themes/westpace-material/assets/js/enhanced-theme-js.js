/**
 * Enhanced Westpace Material Theme JavaScript
 * Modern, performance-optimized interactions with Apple-like smoothness
 */

(function() {
    'use strict';
    
    // Performance-optimized utility functions
    const utils = {
        // Throttle function for performance
        throttle: (func, wait) => {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        },
        
        // Debounce function
        debounce: (func, wait, immediate) => {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    timeout = null;
                    if (!immediate) func(...args);
                };
                const callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func(...args);
            };
        },
        
        // Check if element is in viewport
        isInViewport: (element, threshold = 0.1) => {
            const rect = element.getBoundingClientRect();
            const windowHeight = window.innerHeight || document.documentElement.clientHeight;
            const windowWidth = window.innerWidth || document.documentElement.clientWidth;
            
            return (
                rect.top <= windowHeight * (1 + threshold) &&
                rect.bottom >= windowHeight * -threshold &&
                rect.left <= windowWidth * (1 + threshold) &&
                rect.right >= windowWidth * -threshold
            );
        },
        
        // Smooth scroll to element
        smoothScrollTo: (element, offset = 0) => {
            const targetPosition = element.offsetTop - offset;
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        },
        
        // Add ripple effect to buttons
        addRippleEffect: (element, event) => {
            const ripple = document.createElement('span');
            const rect = element.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = event.clientX - rect.left - size / 2;
            const y = event.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                transform: scale(0);
                animation: ripple-animation 0.6s linear;
                pointer-events: none;
                z-index: 1;
            `;
            
            element.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        }
    };
    
    // Modern CSS injection for animations
    const injectCSS = () => {
        const css = `
            @keyframes ripple-animation {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
            
            .fade-in-up {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .fade-in-up.in-view {
                opacity: 1;
                transform: translateY(0);
            }
            
            .slide-in-left {
                opacity: 0;
                transform: translateX(-30px);
                transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .slide-in-left.in-view {
                opacity: 1;
                transform: translateX(0);
            }
            
            .slide-in-right {
                opacity: 0;
                transform: translateX(30px);
                transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .slide-in-right.in-view {
                opacity: 1;
                transform: translateX(0);
            }
            
            .scale-in {
                opacity: 0;
                transform: scale(0.9);
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .scale-in.in-view {
                opacity: 1;
                transform: scale(1);
            }
            
            .header-hidden {
                transform: translateY(-100%);
            }
            
            .mobile-menu-open .main-navigation {
                transform: translateY(0);
                opacity: 1;
                visibility: visible;
            }
            
            .mobile-menu-open .mobile-menu-toggle .material-icons {
                transform: rotate(90deg);
            }
            
            .loading-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(5px);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 9999;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }
            
            .loading-overlay.active {
                opacity: 1;
                visibility: visible;
            }
            
            .loading-spinner {
                width: 40px;
                height: 40px;
                border: 3px solid rgba(33, 150, 243, 0.1);
                border-radius: 50%;
                border-top-color: #2196F3;
                animation: spin 1s ease-in-out infinite;
            }
            
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
            
            .notification {
                position: fixed;
                top: 20px;
                right: 20px;
                background: white;
                padding: 16px 20px;
                border-radius: 12px;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
                display: flex;
                align-items: center;
                gap: 12px;
                z-index: 10000;
                transform: translateX(100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                border-left: 4px solid #2196F3;
                max-width: 300px;
            }
            
            .notification.show {
                transform: translateX(0);
            }
            
            .notification.success {
                border-left-color: #4CAF50;
            }
            
            .notification.error {
                border-left-color: #F44336;
            }
            
            .notification.warning {
                border-left-color: #FF9800;
            }
            
            .notification-close {
                background: none;
                border: none;
                cursor: pointer;
                color: #666;
                padding: 0;
                font-size: 18px;
                margin-left: auto;
            }
        `;
        
        const style = document.createElement('style');
        style.textContent = css;
        document.head.appendChild(style);
    };
    
    // Enhanced Header Functionality
    class HeaderController {
        constructor() {
            this.header = document.querySelector('.site-header');
            this.mobileToggle = document.querySelector('.mobile-menu-toggle');
            this.navigation = document.querySelector('.main-navigation');
            this.lastScrollTop = 0;
            this.isMenuOpen = false;
            
            this.init();
        }
        
        init() {
            if (!this.header) return;
            
            this.bindEvents();
            this.handleScroll();
        }
        
        bindEvents() {
            // Throttled scroll handler
            window.addEventListener('scroll', utils.throttle(() => {
                this.handleScroll();
            }, 16));
            
            // Mobile menu toggle
            if (this.mobileToggle) {
                this.mobileToggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.toggleMobileMenu();
                });
            }
            
            // Close mobile menu on outside click
            document.addEventListener('click', (e) => {
                if (this.isMenuOpen && !this.navigation.contains(e.target) && !this.mobileToggle.contains(e.target)) {
                    this.closeMobileMenu();
                }
            });
            
            // Handle escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.isMenuOpen) {
                    this.closeMobileMenu();
                }
            });
            
            // Smooth scroll for anchor links
            document.addEventListener('click', (e) => {
                const link = e.target.closest('a[href^="#"]');
                if (link) {
                    e.preventDefault();
                    const target = document.querySelector(link.getAttribute('href'));
                    if (target) {
                        utils.smoothScrollTo(target, 100);
                        if (this.isMenuOpen) {
                            this.closeMobileMenu();
                        }
                    }
                }
            });
        }
        
        handleScroll() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Add scrolled class
            if (scrollTop > 50) {
                this.header.classList.add('scrolled');
            } else {
                this.header.classList.remove('scrolled');
            }
            
            // Hide/show header on scroll
            if (scrollTop > this.lastScrollTop && scrollTop > 100) {
                this.header.classList.add('hidden');
            } else {
                this.header.classList.remove('hidden');
            }
            
            this.lastScrollTop = scrollTop;
        }
        
        toggleMobileMenu() {
            this.isMenuOpen = !this.isMenuOpen;
            document.body.classList.toggle('mobile-menu-open', this.isMenuOpen);
            this.mobileToggle.setAttribute('aria-expanded', this.isMenuOpen);
        }
        
        closeMobileMenu() {
            this.isMenuOpen = false;
            document.body.classList.remove('mobile-menu-open');
            this.mobileToggle.setAttribute('aria-expanded', 'false');
        }
    }
    
    // Scroll Animation Controller
    class ScrollAnimationController {
        constructor() {
            this.elements = document.querySelectorAll('.fade-in-up, .slide-in-left, .slide-in-right, .scale-in');
            this.observer = null;
            
            this.init();
        }
        
        init() {
            if (this.elements.length === 0) return;
            
            // Use Intersection Observer for better performance
            if ('IntersectionObserver' in window) {
                this.observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('in-view');
                            this.observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                });
                
                this.elements.forEach(element => {
                    this.observer.observe(element);
                });
            } else {
                // Fallback for older browsers
                this.handleScrollFallback();
                window.addEventListener('scroll', utils.throttle(() => {
                    this.handleScrollFallback();
                }, 16));
            }
        }
        
        handleScrollFallback() {
            this.elements.forEach(element => {
                if (utils.isInViewport(element) && !element.classList.contains('in-view')) {
                    element.classList.add('in-view');
                }
            });
        }
    }
    
    // Enhanced Button Interactions
    class ButtonController {
        constructor() {
            this.buttons = document.querySelectorAll('.btn, .button, .material-button, .woocommerce .button');
            this.init();
        }
        
        init() {
            this.buttons.forEach(button => {
                // Add ripple effect
                button.addEventListener('click', (e) => {
                    if (!button.classList.contains('no-ripple')) {
                        utils.addRippleEffect(button, e);
                    }
                });
                
                // Add loading state for form buttons
                if (button.type === 'submit' || button.classList.contains('ajax-button')) {
                    button.addEventListener('click', () => {
                        this.setLoadingState(button);
                    });
                }
            });
        }
        
        setLoadingState(button) {
            const originalText = button.textContent;
            button.classList.add('loading');
            button.disabled = true;
            
            // Reset after reasonable time (in case of errors)
            setTimeout(() => {
                button.classList.remove('loading');
                button.disabled = false;
                button.textContent = originalText;
            }, 5000);
        }
    }
    
    // Enhanced WooCommerce Integration
    class WooCommerceController {
        constructor() {
            this.cartCount = document.querySelector('.cart-count');
            this.init();
        }
        
        init() {
            if (typeof wc_add_to_cart_params === 'undefined') return;
            
            this.bindEvents();
        }
        
        bindEvents() {
            // Enhanced add to cart
            document.addEventListener('click', (e) => {
                const button = e.target.closest('.ajax_add_to_cart');
                if (button) {
                    this.handleAddToCart(button, e);
                }
            });
            
            // Update cart count after AJAX
            document.body.addEventListener('added_to_cart', (event) => {
                const { fragments, cart_hash } = event.detail;
                this.updateCartCount(fragments);
                this.showNotification('Product added to cart!', 'success');
            });
            
            // Quantity input enhancements
            this.enhanceQuantityInputs();
        }
        
        handleAddToCart(button, event) {
            button.classList.add('loading');
            const icon = button.querySelector('.material-icons');
            if (icon) {
                icon.textContent = 'hourglass_empty';
            }
        }
        
        updateCartCount(fragments) {
            if (fragments && fragments['.cart-count'] && this.cartCount) {
                this.cartCount.outerHTML = fragments['.cart-count'];
                this.cartCount = document.querySelector('.cart-count');
            }
        }
        
        enhanceQuantityInputs() {
            const quantityInputs = document.querySelectorAll('input[type="number"].qty');
            quantityInputs.forEach(input => {
                const wrapper = document.createElement('div');
                wrapper.className = 'quantity-controls';
                wrapper.innerHTML = `
                    <button type="button" class="qty-decrease">-</button>
                    ${input.outerHTML}
                    <button type="button" class="qty-increase">+</button>
                `;
                
                input.parentNode.replaceChild(wrapper, input);
                
                const newInput = wrapper.querySelector('input');
                const decreaseBtn = wrapper.querySelector('.qty-decrease');
                const increaseBtn = wrapper.querySelector('.qty-increase');
                
                decreaseBtn.addEventListener('click', () => {
                    const currentValue = parseInt(newInput.value) || 1;
                    if (currentValue > 1) {
                        newInput.value = currentValue - 1;
                        newInput.dispatchEvent(new Event('change'));
                    }
                });
                
                increaseBtn.addEventListener('click', () => {
                    const currentValue = parseInt(newInput.value) || 1;
                    const maxValue = parseInt(newInput.getAttribute('max')) || 999;
                    if (currentValue < maxValue) {
                        newInput.value = currentValue + 1;
                        newInput.dispatchEvent(new Event('change'));
                    }
                });
            });
        }
        
        showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <span class="material-icons">${this.getNotificationIcon(type)}</span>
                <span>${message}</span>
                <button class="notification-close">&times;</button>
            `;
            
            document.body.appendChild(notification);
            
            // Show notification
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);
            
            // Auto hide
            setTimeout(() => {
                this.hideNotification(notification);
            }, 5000);
            
            // Close button
            notification.querySelector('.notification-close').addEventListener('click', () => {
                this.hideNotification(notification);
            });
        }
        
        hideNotification(notification) {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }
        
        getNotificationIcon(type) {
            const icons = {
                success: 'check_circle',
                error: 'error',
                warning: 'warning',
                info: 'info'
            };
            return icons[type] || icons.info;
        }
    }
    
    // Performance Optimization Controller
    class PerformanceController {
        constructor() {
            this.init();
        }
        
        init() {
            this.lazyLoadImages();
            this.preloadCriticalResources();
            this.optimizeScrollEvents();
        }
        
        lazyLoadImages() {
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                                img.classList.remove('lazy');
                                imageObserver.unobserve(img);
                            }
                        }
                    });
                });
                
                document.querySelectorAll('img[data-src]').forEach(img => {
                    imageObserver.observe(img);
                });
            }
        }
        
        preloadCriticalResources() {
            // Preload critical fonts
            const fontPreloads = [
                'https://fonts.gstatic.com/s/inter/v12/UcCO3FwrK3iLTeHuS_fvQtMwCp50KnMw2boKoduKmMEVuLyfAZ9hiJ-Ek-_EeA.woff2',
                'https://fonts.gstatic.com/s/materialiconsround/v108/LDItaoyNOAY6Uewc665JcIzCKsKc_M9flwmP.woff2'
            ];
            
            fontPreloads.forEach(href => {
                const link = document.createElement('link');
                link.rel = 'preload';
                link.as = 'font';
                link.type = 'font/woff2';
                link.crossOrigin = 'anonymous';
                link.href = href;
                document.head.appendChild(link);
            });
        }
        
        optimizeScrollEvents() {
            let ticking = false;
            
            const scrollHandler = () => {
                if (!ticking) {
                    requestAnimationFrame(() => {
                        // Batch scroll-related DOM operations here
                        ticking = false;
                    });
                    ticking = true;
                }
            };
            
            window.addEventListener('scroll', scrollHandler, { passive: true });
        }
    }
    
    // Form Enhancement Controller
    class FormController {
        constructor() {
            this.forms = document.querySelectorAll('form');
            this.init();
        }
        
        init() {
            this.enhanceForms();
            this.addValidation();
        }
        
        enhanceForms() {
            this.forms.forEach(form => {
                // Add floating labels
                const inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], textarea');
                inputs.forEach(input => {
                    if (!input.placeholder && input.labels && input.labels[0]) {
                        input.placeholder = input.labels[0].textContent;
                    }
                });
                
                // Add focus/blur effects
                inputs.forEach(input => {
                    input.addEventListener('focus', () => {
                        input.parentElement.classList.add('focused');
                    });
                    
                    input.addEventListener('blur', () => {
                        if (!input.value) {
                            input.parentElement.classList.remove('focused');
                        }
                    });
                    
                    // Set initial state
                    if (input.value) {
                        input.parentElement.classList.add('focused');
                    }
                });
            });
        }
        
        addValidation() {
            this.forms.forEach(form => {
                const requiredInputs = form.querySelectorAll('[required]');
                
                requiredInputs.forEach(input => {
                    input.addEventListener('invalid', (e) => {
                        e.preventDefault();
                        this.showValidationError(input);
                    });
                    
                    input.addEventListener('input', () => {
                        this.clearValidationError(input);
                    });
                });
            });
        }
        
        showValidationError(input) {
            input.classList.add('error');
            
            let errorMsg = input.parentElement.querySelector('.error-message');
            if (!errorMsg) {
                errorMsg = document.createElement('div');
                errorMsg.className = 'error-message';
                input.parentElement.appendChild(errorMsg);
            }
            
            errorMsg.textContent = input.validationMessage;
        }
        
        clearValidationError(input) {
            input.classList.remove('error');
            const errorMsg = input.parentElement.querySelector('.error-message');
            if (errorMsg) {
                errorMsg.remove();
            }
        }
    }
    
    // Main App Initialization
    class WestpaceApp {
        constructor() {
            this.controllers = new Map();
            this.init();
        }
        
        init() {
            // Wait for DOM to be ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => {
                    this.initializeControllers();
                });
            } else {
                this.initializeControllers();
            }
        }
        
        initializeControllers() {
            // Inject CSS
            injectCSS();
            
            // Initialize all controllers
            this.controllers.set('header', new HeaderController());
            this.controllers.set('scrollAnimation', new ScrollAnimationController());
            this.controllers.set('buttons', new ButtonController());
            this.controllers.set('woocommerce', new WooCommerceController());
            this.controllers.set('performance', new PerformanceController());
            this.controllers.set('forms', new FormController());
            
            // Signal that app is ready
            document.body.classList.add('app-ready');
            document.dispatchEvent(new CustomEvent('westpace:ready'));
        }
        
        getController(name) {
            return this.controllers.get(name);
        }
    }
    
    // Initialize the app
    window.WestpaceApp = new WestpaceApp();
    
    // Expose utilities for theme customizations
    window.WestpaceUtils = utils;
    
})();