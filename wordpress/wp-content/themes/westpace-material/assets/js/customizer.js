/**
 * Customizer Preview JavaScript
 * Live preview for theme customizer changes
 */

(function($) {
    'use strict';

    // Site Title and Tagline
    wp.customize('blogname', function(value) {
        value.bind(function(newval) {
            $('.site-title a, .site-logo').text(newval);
        });
    });

    wp.customize('blogdescription', function(value) {
        value.bind(function(newval) {
            $('.site-description').text(newval);
        });
    });

    // Colors
    wp.customize('westpace_primary_color', function(value) {
        value.bind(function(newval) {
            updateColorProperty('--primary-600', newval);
            updateColorProperty('--primary-700', darkenColor(newval, 0.1));
            updateColorProperty('--primary-800', darkenColor(newval, 0.2));
            updateColorProperty('--primary-500', lightenColor(newval, 0.1));
            updateColorProperty('--primary-400', lightenColor(newval, 0.2));
        });
    });

    wp.customize('westpace_secondary_color', function(value) {
        value.bind(function(newval) {
            updateColorProperty('--secondary-color', newval);
        });
    });

    wp.customize('westpace_text_color', function(value) {
        value.bind(function(newval) {
            updateColorProperty('--text-primary', newval);
        });
    });

    wp.customize('westpace_background_color', function(value) {
        value.bind(function(newval) {
            updateColorProperty('--background', newval);
            $('body').css('background-color', newval);
        });
    });

    // Typography
    wp.customize('heading_font', function(value) {
        value.bind(function(newval) {
            if (newval === 'System') {
                $('h1, h2, h3, h4, h5, h6').css('font-family', '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif');
            } else {
                loadGoogleFont(newval);
                $('h1, h2, h3, h4, h5, h6').css('font-family', '"' + newval + '", sans-serif');
            }
        });
    });

    wp.customize('body_font', function(value) {
        value.bind(function(newval) {
            if (newval === 'System') {
                $('body').css('font-family', '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif');
            } else {
                loadGoogleFont(newval);
                $('body').css('font-family', '"' + newval + '", sans-serif');
            }
        });
    });

    wp.customize('base_font_size', function(value) {
        value.bind(function(newval) {
            updateColorProperty('--base-font-size', newval + 'px');
            $('body').css('font-size', newval + 'px');
        });
    });

    // Layout
    wp.customize('container_width', function(value) {
        value.bind(function(newval) {
            updateColorProperty('--container-width', newval + 'px');
            $('.container').css('max-width', newval + 'px');
        });
    });

    // Hero Section
    wp.customize('hero_title', function(value) {
        value.bind(function(newval) {
            $('.hero-title').text(newval);
        });
    });

    wp.customize('hero_subtitle', function(value) {
        value.bind(function(newval) {
            $('.hero-subtitle').text(newval);
        });
    });

    wp.customize('hero_description', function(value) {
        value.bind(function(newval) {
            $('.hero-description').text(newval);
        });
    });

    wp.customize('hero_cta_text', function(value) {
        value.bind(function(newval) {
            $('.hero-actions .btn-primary').text(newval);
        });
    });

    wp.customize('hero_background_image', function(value) {
        value.bind(function(newval) {
            if (newval) {
                $('.hero-section').css('background-image', 'url(' + newval + ')');
            } else {
                $('.hero-section').css('background-image', 'none');
            }
        });
    });

    // Footer
    wp.customize('footer_description', function(value) {
        value.bind(function(newval) {
            $('.company-description').text(newval);
        });
    });

    wp.customize('footer_phone', function(value) {
        value.bind(function(newval) {
            $('.contact-item a[href^="tel:"]').attr('href', 'tel:' + newval);
        });
    });

    wp.customize('footer_phone_display', function(value) {
        value.bind(function(newval) {
            $('.contact-item a[href^="tel:"]').text(newval);
        });
    });

    wp.customize('footer_email', function(value) {
        value.bind(function(newval) {
            $('.contact-item a[href^="mailto:"]').attr('href', 'mailto:' + newval).text(newval);
        });
    });

    wp.customize('footer_address', function(value) {
        value.bind(function(newval) {
            $('.contact-item').has('.material-icons-round:contains("location_on")').find('span:not(.material-icons-round)').text(newval);
        });
    });

    wp.customize('footer_copyright', function(value) {
        value.bind(function(newval) {
            $('.copyright-text').html(newval);
        });
    });

    // WooCommerce
    if (typeof wc_add_to_cart_params !== 'undefined') {
        wp.customize('woocommerce_products_per_page', function(value) {
            value.bind(function(newval) {
                // This would typically trigger a page reload for archive pages
            });
        });

        wp.customize('woocommerce_product_columns', function(value) {
            value.bind(function(newval) {
                $('.products').removeClass('columns-2 columns-3 columns-4').addClass('columns-' + newval);
            });
        });
    }

    // Utility Functions
    function updateColorProperty(property, value) {
        document.documentElement.style.setProperty(property, value);
    }

    function hexToRgb(hex) {
        const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    }

    function rgbToHex(r, g, b) {
        return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
    }

    function darkenColor(hex, amount) {
        const rgb = hexToRgb(hex);
        if (!rgb) return hex;
        
        return rgbToHex(
            Math.max(0, Math.floor(rgb.r * (1 - amount))),
            Math.max(0, Math.floor(rgb.g * (1 - amount))),
            Math.max(0, Math.floor(rgb.b * (1 - amount)))
        );
    }

    function lightenColor(hex, amount) {
        const rgb = hexToRgb(hex);
        if (!rgb) return hex;
        
        return rgbToHex(
            Math.min(255, Math.floor(rgb.r + (255 - rgb.r) * amount)),
            Math.min(255, Math.floor(rgb.g + (255 - rgb.g) * amount)),
            Math.min(255, Math.floor(rgb.b + (255 - rgb.b) * amount))
        );
    }

    function loadGoogleFont(fontFamily) {
        const fontName = fontFamily.replace(' ', '+');
        const link = $('<link>');
        link.attr('href', 'https://fonts.googleapis.com/css2?family=' + fontName + ':wght@300;400;500;600;700;800;900&display=swap');
        link.attr('rel', 'stylesheet');
        
        // Check if font is already loaded
        if (!$('link[href*="' + fontName + '"]').length) {
            $('head').append(link);
        }
    }

    // Performance Settings
    wp.customize('enable_lazy_loading', function(value) {
        value.bind(function(newval) {
            if (newval) {
                $('img').attr('loading', 'lazy');
            } else {
                $('img').removeAttr('loading');
            }
        });
    });

    // Custom CSS injection for live preview
    function injectCustomCSS(css) {
        let styleElement = $('#westpace-customizer-preview-css');
        if (!styleElement.length) {
            styleElement = $('<style id="westpace-customizer-preview-css"></style>');
            $('head').append(styleElement);
        }
        styleElement.text(css);
    }

    // Watch for customizer changes and update preview
    wp.customize.bind('change', function(setting) {
        // Trigger a small animation to show the change
        const changedElements = getElementsForSetting(setting.id);
        if (changedElements.length > 0) {
            changedElements.addClass('customizer-changed');
            setTimeout(() => {
                changedElements.removeClass('customizer-changed');
            }, 500);
        }
    });

    function getElementsForSetting(settingId) {
        const settingMap = {
            'westpace_primary_color': $('.btn-primary, .nav-link.active, .primary-color-element'),
            'westpace_secondary_color': $('.btn-secondary, .secondary-color-element'),
            'hero_title': $('.hero-title'),
            'hero_subtitle': $('.hero-subtitle'),
            'hero_description': $('.hero-description'),
            'heading_font': $('h1, h2, h3, h4, h5, h6'),
            'body_font': $('body, p, span, div'),
            'base_font_size': $('body'),
            'container_width': $('.container')
        };

        return settingMap[settingId] || $();
    }

    // Add CSS for customizer animations
    const customizerCSS = `
        <style>
        .customizer-changed {
            animation: customizerHighlight 0.5s ease-in-out;
        }
        
        @keyframes customizerHighlight {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }
        
        .customize-partial-edit-shortcut-button {
            background: var(--primary-600) !important;
            border-color: var(--primary-600) !important;
        }
        </style>
    `;
    
    $('head').append(customizerCSS);

})(jQuery);