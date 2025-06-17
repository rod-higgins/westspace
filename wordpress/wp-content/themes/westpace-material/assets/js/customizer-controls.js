/**
 * Westpace Material Theme Customizer Controls
 * Enhanced customizer experience with dynamic controls
 * 
 * File: templates/assets/js/customizer-controls.js
 */

(function($, api) {
    'use strict';

    // Initialize when customizer is ready
    api.bind('ready', function() {
        initColorPalette();
        initFontPreview();
        initLayoutControls();
        initTypographyControls();
        initCustomCSSEditor();
        initResetButton();
        initExportImportSettings();
    });

    /**
     * Color Palette Controls
     */
    function initColorPalette() {
        // Enhanced color picker with predefined palettes
        const colorSettings = [
            'primary_color',
            'secondary_color',
            'background_color',
            'text_color'
        ];

        colorSettings.forEach(function(setting) {
            const control = api.control('westpace_' + setting);
            if (control) {
                control.container.find('.wp-color-picker').wpColorPicker({
                    palettes: [
                        '#2196F3', '#3F51B5', '#9C27B0', '#E91E63',
                        '#F44336', '#FF5722', '#FF9800', '#FFC107',
                        '#FFEB3B', '#CDDC39', '#8BC34A', '#4CAF50',
                        '#009688', '#00BCD4', '#03A9F4', '#2196F3'
                    ],
                    change: function(event, ui) {
                        updateColorPreview(setting, ui.color.toString());
                    }
                });
            }
        });
    }

    /**
     * Update color preview in real-time
     */
    function updateColorPreview(setting, color) {
        const previewFrame = $('#customize-preview iframe')[0];
        if (previewFrame && previewFrame.contentWindow) {
            const previewDoc = previewFrame.contentDocument || previewFrame.contentWindow.document;
            const rootStyle = previewDoc.documentElement.style;
            
            switch(setting) {
                case 'primary_color':
                    rootStyle.setProperty('--primary-color', color);
                    break;
                case 'secondary_color':
                    rootStyle.setProperty('--secondary-color', color);
                    break;
                case 'background_color':
                    rootStyle.setProperty('--background', color);
                    break;
                case 'text_color':
                    rootStyle.setProperty('--text-primary', color);
                    break;
            }
        }
    }

    /**
     * Font Preview Controls
     */
    function initFontPreview() {
        const fontControls = ['body_font', 'heading_font'];
        
        fontControls.forEach(function(controlId) {
            const control = api.control('westpace_' + controlId);
            if (control) {
                const $select = control.container.find('select');
                
                // Add font preview
                $select.on('change', function() {
                    const selectedFont = $(this).val();
                    updateFontPreview(controlId, selectedFont);
                });
                
                // Style the select with font preview
                $select.find('option').each(function() {
                    const fontName = $(this).val();
                    if (fontName !== 'System') {
                        $(this).css('font-family', fontName);
                    }
                });
            }
        });
    }

    /**
     * Update font preview
     */
    function updateFontPreview(controlId, fontName) {
        const previewFrame = $('#customize-preview iframe')[0];
        if (previewFrame && previewFrame.contentWindow) {
            const previewDoc = previewFrame.contentDocument || previewFrame.contentWindow.document;
            const fontFamily = fontName === 'System' ? 
                '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif' : 
                '"' + fontName + '", sans-serif';
            
            if (controlId === 'body_font') {
                previewDoc.body.style.fontFamily = fontFamily;
            } else if (controlId === 'heading_font') {
                const headings = previewDoc.querySelectorAll('h1, h2, h3, h4, h5, h6');
                headings.forEach(function(heading) {
                    heading.style.fontFamily = fontFamily;
                });
            }
        }
    }

    /**
     * Layout Controls
     */
    function initLayoutControls() {
        const layoutControl = api.control('westpace_layout_style');
        if (layoutControl) {
            layoutControl.container.find('input[type="radio"]').on('change', function() {
                const layout = $(this).val();
                updateLayoutPreview(layout);
            });
        }

        // Container width control
        const containerControl = api.control('westpace_container_width');
        if (containerControl) {
            const $slider = containerControl.container.find('input[type="range"]');
            const $value = $('<span class="range-value"></span>');
            $slider.after($value);
            
            $slider.on('input', function() {
                const width = $(this).val();
                $value.text(width + 'px');
                updateContainerWidth(width);
            });
        }
    }

    /**
     * Update layout preview
     */
    function updateLayoutPreview(layout) {
        const previewFrame = $('#customize-preview iframe')[0];
        if (previewFrame && previewFrame.contentWindow) {
            const previewDoc = previewFrame.contentDocument || previewFrame.contentWindow.document;
            const body = previewDoc.body;
            
            body.className = body.className.replace(/layout-\w+/g, '');
            body.classList.add('layout-' + layout);
        }
    }

    /**
     * Update container width
     */
    function updateContainerWidth(width) {
        const previewFrame = $('#customize-preview iframe')[0];
        if (previewFrame && previewFrame.contentWindow) {
            const previewDoc = previewFrame.contentDocument || previewFrame.contentWindow.document;
            const rootStyle = previewDoc.documentElement.style;
            rootStyle.setProperty('--container-width', width + 'px');
        }
    }

    /**
     * Typography Controls
     */
    function initTypographyControls() {
        const fontSizeControl = api.control('westpace_base_font_size');
        if (fontSizeControl) {
            const $slider = fontSizeControl.container.find('input[type="range"]');
            const $value = $('<span class="range-value"></span>');
            $slider.after($value);
            
            $slider.on('input', function() {
                const size = $(this).val();
                $value.text(size + 'px');
                updateBaseFontSize(size);
            });
        }
    }

    /**
     * Update base font size
     */
    function updateBaseFontSize(size) {
        const previewFrame = $('#customize-preview iframe')[0];
        if (previewFrame && previewFrame.contentWindow) {
            const previewDoc = previewFrame.contentDocument || previewFrame.contentWindow.document;
            const rootStyle = previewDoc.documentElement.style;
            rootStyle.setProperty('--base-font-size', size + 'px');
        }
    }

    /**
     * Custom CSS Editor
     */
    function initCustomCSSEditor() {
        const cssControl = api.control('westpace_custom_css');
        if (cssControl) {
            const $textarea = cssControl.container.find('textarea');
            
            // Add CodeMirror if available
            if (typeof CodeMirror !== 'undefined') {
                const editor = CodeMirror.fromTextArea($textarea[0], {
                    mode: 'css',
                    lineNumbers: true,
                    theme: 'default',
                    lineWrapping: true
                });
                
                editor.on('change', function() {
                    $textarea.val(editor.getValue()).trigger('change');
                });
            } else {
                // Fallback: Add basic CSS syntax highlighting classes
                $textarea.addClass('css-editor');
            }
        }
    }

    /**
     * Reset Button
     */
    function initResetButton() {
        const $resetButton = $('<button type="button" class="button button-secondary reset-customizer">Reset All Settings</button>');
        
        $resetButton.on('click', function() {
            if (confirm('Are you sure you want to reset all customizer settings? This action cannot be undone.')) {
                resetAllSettings();
            }
        });
        
        $('#customize-header-actions').append($resetButton);
    }

    /**
     * Reset all customizer settings
     */
    function resetAllSettings() {
        const settings = [
            'primary_color',
            'secondary_color',
            'background_color',
            'text_color',
            'body_font',
            'heading_font',
            'base_font_size',
            'container_width',
            'layout_style',
            'custom_css'
        ];
        
        settings.forEach(function(setting) {
            const control = api.control('westpace_' + setting);
            if (control) {
                api.set(setting, control.params.default);
            }
        });
    }

    /**
     * Export/Import Settings
     */
    function initExportImportSettings() {
        const $exportButton = $('<button type="button" class="button export-settings">Export Settings</button>');
        const $importButton = $('<button type="button" class="button import-settings">Import Settings</button>');
        const $fileInput = $('<input type="file" style="display:none;" accept=".json">');
        
        // Export functionality
        $exportButton.on('click', function() {
            const settings = {};
            api.each(function(setting) {
                if (setting.id.startsWith('westpace_')) {
                    settings[setting.id] = setting.get();
                }
            });
            
            const dataStr = JSON.stringify(settings, null, 2);
            const dataBlob = new Blob([dataStr], {type: 'application/json'});
            const url = URL.createObjectURL(dataBlob);
            
            const link = document.createElement('a');
            link.href = url;
            link.download = 'westpace-theme-settings.json';
            link.click();
            
            URL.revokeObjectURL(url);
        });
        
        // Import functionality
        $importButton.on('click', function() {
            $fileInput.click();
        });
        
        $fileInput.on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    try {
                        const settings = JSON.parse(e.target.result);
                        importSettings(settings);
                    } catch (error) {
                        alert('Error importing settings: Invalid file format');
                    }
                };
                reader.readAsText(file);
            }
        });
        
        const $actionsContainer = $('<div class="customizer-actions" style="padding: 15px; border-top: 1px solid #ddd;"></div>');
        $actionsContainer.append($exportButton, ' ', $importButton, $fileInput);
        $('#customize-controls').append($actionsContainer);
    }

    /**
     * Import settings
     */
    function importSettings(settings) {
        Object.keys(settings).forEach(function(settingId) {
            const control = api.control(settingId);
            if (control) {
                api.set(settingId, settings[settingId]);
            }
        });
        
        alert('Settings imported successfully!');
    }

    /**
     * Add custom CSS for enhanced controls
     */
    function addControlStyles() {
        const styles = `
            <style>
                .range-value {
                    margin-left: 10px;
                    font-weight: bold;
                    color: #0073aa;
                }
                
                .css-editor {
                    font-family: 'Courier New', monospace;
                    font-size: 13px;
                }
                
                .reset-customizer {
                    margin-left: 10px;
                }
                
                .customizer-actions {
                    background: #f1f1f1;
                    margin-top: 20px;
                }
                
                .customizer-actions button {
                    margin-right: 5px;
                }
                
                .export-settings,
                .import-settings {
                    font-size: 12px;
                    padding: 5px 10px;
                }
            </style>
        `;
        
        $('head').append(styles);
    }

    // Initialize styles
    addControlStyles();

})(jQuery, wp.customize);