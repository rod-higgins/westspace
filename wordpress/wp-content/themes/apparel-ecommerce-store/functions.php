<?php
/**
 * Apparel Ecommerce Store functions and definitions
 *
 * @package apparel_ecommerce_store
 * @since 1.0
 */

if ( ! function_exists( 'apparel_ecommerce_store_support' ) ) :
	function apparel_ecommerce_store_support() {

		load_theme_textdomain( 'apparel-ecommerce-store', get_template_directory() . '/languages' );

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		add_theme_support('woocommerce');

		// Enqueue editor styles.
		add_editor_style(get_stylesheet_directory_uri() . '/assets/css/editor-style.css');

		/* Theme Credit link */
		define('APPAREL_ECOMMERCE_STORE_BUY_NOW',__('https://www.cretathemes.com/products/apparel-wordpress-theme','apparel-ecommerce-store'));
		define('APPAREL_ECOMMERCE_STORE_PRO_DEMO',__('https://pattern.cretathemes.com/apparel-ecommerce-store/','apparel-ecommerce-store'));
		define('APPAREL_ECOMMERCE_STORE_THEME_DOC',__('https://pattern.cretathemes.com/free-guide/apparel-ecommerce-store/','apparel-ecommerce-store'));
		define('APPAREL_ECOMMERCE_STORE_PRO_THEME_DOC',__('https://pattern.cretathemes.com/pro-guide/apparel-ecommerce-store/','apparel-ecommerce-store'));
		define('APPAREL_ECOMMERCE_STORE_SUPPORT',__('https://wordpress.org/support/theme/apparel-ecommerce-store/','apparel-ecommerce-store'));
		define('APPAREL_ECOMMERCE_STORE_REVIEW',__('https://wordpress.org/support/theme/apparel-ecommerce-store/reviews/#new-post','apparel-ecommerce-store'));
		define('APPAREL_ECOMMERCE_STORE_PRO_THEME_BUNDLE',__('https://www.cretathemes.com/products/wordpress-theme-bundle','apparel-ecommerce-store'));
		define('APPAREL_ECOMMERCE_STORE_PRO_ALL_THEMES',__('https://www.cretathemes.com/collections/wordpress-block-themes','apparel-ecommerce-store'));

	}
endif;

add_action( 'after_setup_theme', 'apparel_ecommerce_store_support' );

if ( ! function_exists( 'apparel_ecommerce_store_styles' ) ) :
	function apparel_ecommerce_store_styles() {
		// Register theme stylesheet.
		$apparel_ecommerce_store_theme_version = wp_get_theme()->get( 'Version' );

		$apparel_ecommerce_store_version_string = is_string( $apparel_ecommerce_store_theme_version ) ? $apparel_ecommerce_store_theme_version : false;
		wp_enqueue_style(
			'apparel-ecommerce-store-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$apparel_ecommerce_store_version_string
		);
		
		wp_enqueue_script( 'apparel-ecommerce-store-custom-script', get_theme_file_uri( '/assets/js/custom-script.js' ), array( 'jquery' ), true );

		wp_enqueue_style( 'dashicons' );

		wp_style_add_data( 'apparel-ecommerce-store-style', 'rtl', 'replace' );

		//font-awesome
		wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/inc/fontawesome/css/all.css'
			, array(), '6.7.0' );

		//homepage slider
		wp_enqueue_style('apparel-ecommerce-store-swiper-bundle-style', get_template_directory_uri() . '/assets/css/swiper-bundle.css', array(), $apparel_ecommerce_store_version_string);

		wp_enqueue_script('apparel-ecommerce-store-swiper-bundle-scripts', get_template_directory_uri() . '/assets/js/swiper-bundle.js', array(), $apparel_ecommerce_store_version_string, true);
	}
endif;

add_action( 'wp_enqueue_scripts', 'apparel_ecommerce_store_styles' );

// Add block patterns
require get_template_directory() . '/inc/block-patterns.php';

// Add block styles
require get_template_directory() . '/inc/block-styles.php';

// Block Filters
require get_template_directory() . '/inc/block-filters.php';

// Svg icons
require get_template_directory() . '/inc/icon-function.php';

// Customizer
require get_template_directory() . '/inc/customizer.php';

// Get Started.
require get_template_directory() . '/inc/get-started/get-started.php';

// Add Getstart admin notice
function apparel_ecommerce_store_admin_notice() { 
    global $pagenow;
    $theme_args      = wp_get_theme();
    $meta            = get_option( 'apparel_ecommerce_store_admin_notice' );
    $name            = $theme_args->__get( 'Name' );
    $current_screen  = get_current_screen();

    if( !$meta ){
	    if( is_network_admin() ){
	        return;
	    }

	    if( ! current_user_can( 'manage_options' ) ){
	        return;
	    } if($current_screen->base != 'appearance_page_apparel-ecommerce-store-guide-page' ) { ?>

	    <div class="notice notice-success dash-notice">
	        <h1><?php esc_html_e('Hey, Thank you for installing Apparel Ecommerce Store Theme!', 'apparel-ecommerce-store'); ?></h1>
	        <p><a class="button button-primary customize load-customize hide-if-no-customize get-start-btn" href="<?php echo esc_url( admin_url( 'themes.php?page=apparel-ecommerce-store-guide-page' ) ); ?>"><?php esc_html_e('Navigate Getstart', 'apparel-ecommerce-store'); ?></a> 
	        	<a class="button button-primary site-edit" href="<?php echo esc_url( admin_url( 'site-editor.php' ) ); ?>"><?php esc_html_e('Site Editor', 'apparel-ecommerce-store'); ?></a> 
				<a class="button button-primary buy-now-btn" href="<?php echo esc_url( APPAREL_ECOMMERCE_STORE_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Buy Pro', 'apparel-ecommerce-store'); ?></a>
				<a class="button button-primary bundle-btn" href="<?php echo esc_url( APPAREL_ECOMMERCE_STORE_PRO_THEME_BUNDLE ); ?>" target="_blank"><?php esc_html_e('Get Bundle', 'apparel-ecommerce-store'); ?></a>
	        </p>
	        <p class="dismiss-link"><strong><a href="?apparel_ecommerce_store_admin_notice=1"><?php esc_html_e( 'Dismiss', 'apparel-ecommerce-store' ); ?></a></strong></p>
	    </div>
	    <?php

	}?>
	    <?php

	}
}

add_action( 'admin_notices', 'apparel_ecommerce_store_admin_notice' );

if( ! function_exists( 'apparel_ecommerce_store_update_admin_notice' ) ) :
/**
 * Updating admin notice on dismiss
*/
function apparel_ecommerce_store_update_admin_notice(){
    if ( isset( $_GET['apparel_ecommerce_store_admin_notice'] ) && $_GET['apparel_ecommerce_store_admin_notice'] = '1' ) {
        update_option( 'apparel_ecommerce_store_admin_notice', true );
    }
}
endif;
add_action( 'admin_init', 'apparel_ecommerce_store_update_admin_notice' );

//After Switch theme function
add_action('after_switch_theme', 'apparel_ecommerce_store_getstart_setup_options');
function apparel_ecommerce_store_getstart_setup_options () {
    update_option('apparel_ecommerce_store_admin_notice', FALSE );
}