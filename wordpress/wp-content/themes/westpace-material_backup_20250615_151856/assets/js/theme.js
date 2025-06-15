(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Header scroll effect
        const header = $('.site-header');
        let lastScrollTop = 0;
        
        $(window).scroll(function() {
            const scrollTop = $(this).scrollTop();
            
            if (scrollTop > 100) {
                header.addClass('scrolled');
            } else {
                header.removeClass('scrolled');
            }
            
            lastScrollTop = scrollTop;
        });
        
        // Mobile menu toggle
        $('.menu-toggle').on('click', function() {
            const nav = $('.main-navigation');
            const isExpanded = $(this).attr('aria-expanded') === 'true';
            
            nav.toggleClass('active');
            $(this).attr('aria-expanded', !isExpanded);
            
            // Toggle icon
            const icon = $(this).find('.material-icons');
            icon.text(nav.hasClass('active') ? 'close' : 'menu');
        });
        
        // Close mobile menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.site-header').length) {
                $('.main-navigation').removeClass('active');
                $('.menu-toggle').attr('aria-expanded', 'false');
                $('.menu-toggle .material-icons').text('menu');
            }
        });
        
        // Smooth scrolling for anchor links
        $('a[href*="#"]').not('[href="#"]').not('[href="#0"]').on('click', function(e) {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
                location.hostname === this.hostname) {
                
                const target = $(this.hash);
                const targetElement = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                if (targetElement.length) {
                    e.preventDefault();
                    const offsetTop = targetElement.offset().top - 80;
                    
                    $('html, body').animate({
                        scrollTop: offsetTop
                    }, 800, 'easeInOutCubic');
                }
            }
        });
        
        // Intersection Observer for animations
        if ('IntersectionObserver' in window) {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);
            
            // Observe elements with animation classes
            $('.fade-in-up, .slide-in-right, .service-card, .stat-item').each(function() {
                observer.observe(this);
            });
        }
        
        // Counter animation for stats
        function animateCounter(element, target) {
            let current = 0;
            const increment = target / 50;
            const timer = setInterval(function() {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                element.text(Math.floor(current) + (target >= 1000 ? 's' : target >= 100 ? '+' : ''));
            }, 40);
        }
        
        // Trigger counter animation when stats section is visible
        $('.stat-number').each(function() {
            const $this = $(this);
            const target = parseInt($this.text().replace(/\D/g, ''));
            
            if ('IntersectionObserver' in window) {
                const statsObserver = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            setTimeout(function() {
                                animateCounter($this, target);
                            }, 200);
                            statsObserver.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.5 });
                
                statsObserver.observe(this);
            }
        });
        
        // Enhanced button hover effects
        $('.btn').on('mouseenter', function() {
            $(this).addClass('hovered');
        }).on('mouseleave', function() {
            $(this).removeClass('hovered');
        });
        
        // Parallax effect for hero section
        if ($(window).width() > 768) {
            $(window).scroll(function() {
                const scrolled = $(window).scrollTop();
                const parallaxSpeed = 0.5;
                $('.hero-section').css('transform', 'translateY(' + (scrolled * parallaxSpeed) + 'px)');
            });
        }
        
        // Lazy loading for images
        if ('loading' in HTMLImageElement.prototype) {
            // Native lazy loading supported
            $('img').attr('loading', 'lazy');
        } else {
            // Fallback for browsers without native lazy loading
            const images = document.querySelectorAll('img[data-src]');
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            images.forEach(function(img) {
                imageObserver.observe(img);
            });
        }
        
        // Form enhancements
        $('.wpcf7-form input, .wpcf7-form textarea').on('focus', function() {
            $(this).parent().addClass('focused');
        }).on('blur', function() {
            if (!$(this).val()) {
                $(this).parent().removeClass('focused');
            }
        });
        
        // Cart update animation
        $(document.body).on('added_to_cart', function() {
            $('.cart-count').addClass('pulse');
            setTimeout(function() {
                $('.cart-count').removeClass('pulse');
            }, 1000);
        });
        
        // Performance: Debounce scroll events
        function debounce(func, wait, immediate) {
            let timeout;
            return function() {
                const context = this, args = arguments;
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
        
        // Apply debouncing to scroll events
        const debouncedScrollHandler = debounce(function() {
            // Scroll-dependent functionality here
        }, 100);
        
        $(window).on('scroll', debouncedScrollHandler);
        
    });
    
    // Add custom easing function
    $.easing.easeInOutCubic = function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return c/2*t*t*t + b;
        return c/2*((t-=2)*t*t + 2) + b;
    };
    
})(jQuery);

// Additional performance optimizations
document.addEventListener('DOMContentLoaded', function() {
    // Preload critical resources
    const preloadLinks = [
        'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Roboto+Slab:wght@300;400;500;700&display=swap',
        'https://fonts.googleapis.com/icon?family=Material+Icons'
    ];
    
    preloadLinks.forEach(function(href) {
        const link = document.createElement('link');
        link.rel = 'preload';
        link.as = 'style';
        link.href = href;
        document.head.appendChild(link);
    });
});
