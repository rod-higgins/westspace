/**
 * Westpace Material Theme JavaScript
 * Enhanced functionality with Material Design interactions
 */

(function($) {
    "use strict";
    
    // Document ready
    $(document).ready(function() {
        initMaterialDesign();
        initNavigation();
        initWooCommerce();
        initAnimations();
        initPerformance();
    });
    
    /**
     * Initialize Material Design components
     */
    function initMaterialDesign() {
        // Material ripple effect
        $(".material-button, .woocommerce .button").on("click", function(e) {
            const button = $(this);
            const ripple = $("<span class=\"ripple\"></span>");
            
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.css({
                width: size,
                height: size,
                left: x,
                top: y
            });
            
            button.append(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
        
        // Material elevation on hover
        $(".material-card").hover(
            function() {
                $(this).addClass("elevation-4");
            },
            function() {
                $(this).removeClass("elevation-4");
            }
        );
    }
    
    /**
     * Initialize enhanced navigation
     */
    function initNavigation() {
        // Mobile menu toggle
        $(".mobile-menu-toggle").on("click", function() {
            $(this).toggleClass("active");
            $(".main-navigation").toggleClass("active");
        });
        
        // Smooth scrolling for anchor links
        $("a[href^=\"#\"]").on("click", function(e) {
            const target = $(this.getAttribute("href"));
            if (target.length) {
                e.preventDefault();
                $("html, body").animate({
                    scrollTop: target.offset().top - 100
                }, 600, "easeInOutQuart");
            }
        });
        
        // Header scroll effect
        let lastScrollTop = 0;
        $(window).on("scroll", function() {
            const scrollTop = $(this).scrollTop();
            const header = $(".site-header");
            
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                header.addClass("header-hidden");
            } else {
                header.removeClass("header-hidden");
            }
            
            if (scrollTop > 50) {
                header.addClass("header-scrolled");
            } else {
                header.removeClass("header-scrolled");
            }
            
            lastScrollTop = scrollTop;
        });
    }
    
    /**
     * Initialize WooCommerce enhancements
     */
    function initWooCommerce() {
        if (typeof wc_add_to_cart_params === "undefined") return;
        
        // Enhanced add to cart with loading states
        $(document).on("click", ".ajax_add_to_cart", function(e) {
            const button = $(this);
            button.addClass("loading");
            button.find(".material-icons").text("hourglass_empty");
        });
        
        // Update cart count after AJAX
        $(document.body).on("added_to_cart", function(event, fragments, cart_hash, button) {
            button.removeClass("loading");
            button.find(".material-icons").text("check");
            
            // Show success notification
            showNotification("Product added to cart!", "success");
            
            setTimeout(() => {
                button.find(".material-icons").text("shopping_cart");
            }, 2000);
        });
        
        // Enhanced product gallery
        if ($(".woocommerce-product-gallery").length) {
            $(".woocommerce-product-gallery").addClass("material-gallery");
        }
        
        // Quantity input enhancements
        $(".quantity input[type=number]").wrap("<div class=\"quantity-wrapper material-input\"></div>");
        
        // Enhanced select dropdowns
        $("select").each(function() {
            if (!$(this).hasClass("select2-hidden-accessible")) {
                $(this).wrap("<div class=\"select-wrapper\"></div>");
            }
        });
    }
    
    /**
     * Initialize scroll animations
     */
    function initAnimations() {
        // Intersection Observer for animations
        if ("IntersectionObserver" in window) {
            const animationObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("animate-in");
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: "0px 0px -50px 0px"
            });
            
            // Observe elements with animation classes
            document.querySelectorAll(".fade-in-up, .slide-in-left, .slide-in-right").forEach(el => {
                animationObserver.observe(el);
            });
        }
        
        // Parallax effect for hero sections
        $(".hero-section").each(function() {
            const hero = $(this);
            $(window).on("scroll", function() {
                const scrolled = $(window).scrollTop();
                const parallax = scrolled * 0.5;
                hero.css("transform", `translateY(${parallax}px)`);
            });
        });
    }
    
    /**
     * Performance optimizations
     */
    function initPerformance() {
        // Lazy load images
        if ("IntersectionObserver" in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove("lazy");
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            document.querySelectorAll("img[data-src]").forEach(img => {
                imageObserver.observe(img);
            });
        }
        
        // Preload critical resources
        const preloadLink = document.createElement("link");
        preloadLink.rel = "preload";
        preloadLink.as = "font";
        preloadLink.type = "font/woff2";
        preloadLink.crossOrigin = "anonymous";
        preloadLink.href = "https://fonts.gstatic.com/s/roboto/v30/KFOmCnqEu92Fr1Mu4mxK.woff2";
        document.head.appendChild(preloadLink);
    }
    
    /**
     * Show notification
     */
    function showNotification(message, type = "info") {
        const notification = $(`
            <div class="material-notification ${type}">
                <span class="material-icons">${getNotificationIcon(type)}</span>
                <span class="message">${message}</span>
                <button class="close-notification material-icons">close</button>
            </div>
        `);
        
        $("body").append(notification);
        
        setTimeout(() => {
            notification.addClass("show");
        }, 100);
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            hideNotification(notification);
        }, 5000);
        
        // Close button
        notification.find(".close-notification").on("click", () => {
            hideNotification(notification);
        });
    }
    
    function hideNotification(notification) {
        notification.removeClass("show");
        setTimeout(() => {
            notification.remove();
        }, 300);
    }
    
    function getNotificationIcon(type) {
        const icons = {
            success: "check_circle",
            error: "error",
            warning: "warning",
            info: "info"
        };
        return icons[type] || icons.info;
    }
    
})(jQuery);

// Add CSS for additional components
const additionalCSS = `
.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.6);
    transform: scale(0);
    animation: ripple-effect 0.6s linear;
    pointer-events: none;
}

@keyframes ripple-effect {
    to {
        transform: scale(4);
        opacity: 0;
    }
}

.header-hidden {
    transform: translateY(-100%);
}

.header-scrolled {
    box-shadow: var(--shadow-3);
}

.material-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: var(--surface-color);
    padding: 16px 20px;
    border-radius: 8px;
    box-shadow: var(--shadow-3);
    display: flex;
    align-items: center;
    gap: 12px;
    z-index: 10000;
    transform: translateX(100%);
    transition: transform 0.3s ease;
}

.material-notification.show {
    transform: translateX(0);
}

.material-notification.success {
    border-left: 4px solid var(--success-color);
}

.material-notification.error {
    border-left: 4px solid var(--error-color);
}

.material-notification.warning {
    border-left: 4px solid var(--warning-color);
}

.material-notification.info {
    border-left: 4px solid var(--info-color);
}

.close-notification {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--text-secondary);
}

.animate-in {
    animation: fadeInUp 0.6s ease-out forwards;
}
`;

// Inject additional CSS
const style = document.createElement("style");
style.textContent = additionalCSS;
document.head.appendChild(style);