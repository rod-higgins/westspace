<?php
add_action( 'admin_menu', 'apparel_ecommerce_store_getting_started' );
function apparel_ecommerce_store_getting_started() {
	add_theme_page( esc_html__('Get Started', 'apparel-ecommerce-store'), esc_html__('Get Started', 'apparel-ecommerce-store'), 'edit_theme_options', 'apparel-ecommerce-store-guide-page', 'apparel_ecommerce_store_test_guide');
}

// Add a Custom CSS file to WP Admin Area
function apparel_ecommerce_store_admin_theme_style() {
   wp_enqueue_style('custom-admin-style', esc_url(get_template_directory_uri()) . '/inc/get-started/get-started.css');
}
add_action('admin_enqueue_scripts', 'apparel_ecommerce_store_admin_theme_style');

//guidline for about theme
function apparel_ecommerce_store_test_guide() { 
	//custom function about theme customizer
	$return = add_query_arg( array()) ;
	$theme = wp_get_theme( 'apparel-ecommerce-store' );
?>
	<div class="wrapper-outer">
		<div class="left-main-box">
			<div class="intro"><h3><?php echo esc_html( $theme->Name ); ?></h3></div>
			<div class="left-inner">
				<div class="about-wrapper">
					<div class="col-left">
						<p><?php echo esc_html( $theme->get( 'Description' ) ); ?></p>
					</div>
					<div class="col-right">
						<img role="img" src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/get-started/images/screenshot.png" alt="" />
					</div>
				</div>
				<div class="link-wrapper">
					<h4><?php esc_html_e('Important Links', 'apparel-ecommerce-store'); ?></h4>
					<div class="link-buttons">
						<a href="<?php echo esc_url( APPAREL_ECOMMERCE_STORE_THEME_DOC ); ?>" target="_blank"><?php esc_html_e('Free Setup Guide', 'apparel-ecommerce-store'); ?></a>
						<a href="<?php echo esc_url( APPAREL_ECOMMERCE_STORE_SUPPORT ); ?>" target="_blank"><?php esc_html_e('Support Forum', 'apparel-ecommerce-store'); ?></a>
						<a href="<?php echo esc_url( APPAREL_ECOMMERCE_STORE_PRO_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'apparel-ecommerce-store'); ?></a>
						<a href="<?php echo esc_url( APPAREL_ECOMMERCE_STORE_PRO_THEME_DOC ); ?>" target="_blank"><?php esc_html_e('Pro Setup Guide', 'apparel-ecommerce-store'); ?></a>
					</div>
				</div>
				<div class="support-wrapper">
					<div class="editor-box">
						<i class="dashicons dashicons-admin-appearance"></i>
						<h4><?php esc_html_e('Theme Customization', 'apparel-ecommerce-store'); ?></h4>
						<p><?php esc_html_e('Effortlessly modify & maintain your site using editor.', 'apparel-ecommerce-store'); ?></p>
						<div class="support-button">
							<a class="button button-primary" href="<?php echo esc_url( admin_url( 'site-editor.php' ) ); ?>" target="_blank"><?php esc_html_e('Site Editor', 'apparel-ecommerce-store'); ?></a>
						</div>
					</div>
					<div class="support-box">
						<i class="dashicons dashicons-microphone"></i>
						<h4><?php esc_html_e('Need Support?', 'apparel-ecommerce-store'); ?></h4>
						<p><?php esc_html_e('Go to our support forum to help you in case of queries.', 'apparel-ecommerce-store'); ?></p>
						<div class="support-button">
							<a class="button button-primary" href="<?php echo esc_url( APPAREL_ECOMMERCE_STORE_SUPPORT ); ?>" target="_blank"><?php esc_html_e('Get Support', 'apparel-ecommerce-store'); ?></a>
						</div>
					</div>
					<div class="review-box">
						<i class="dashicons dashicons-star-filled"></i>
						<h4><?php esc_html_e('Leave Us A Review', 'apparel-ecommerce-store'); ?></h4>
						<p><?php esc_html_e('Are you enjoying Our Theme? We would Love to hear your Feedback.', 'apparel-ecommerce-store'); ?></p>
						<div class="support-button">
							<a class="button button-primary" href="<?php echo esc_url( APPAREL_ECOMMERCE_STORE_REVIEW ); ?>" target="_blank"><?php esc_html_e('Rate Us', 'apparel-ecommerce-store'); ?></a>
						</div>
					</div>
				</div>
			</div>
			<div class="go-premium-box">
				<h4><?php esc_html_e('Why Go For Premium?', 'apparel-ecommerce-store'); ?></h4>
				<ul class="pro-list">
					<li><?php esc_html_e('Advanced Customization Options', 'apparel-ecommerce-store');?></li>
					<li><?php esc_html_e('One-Click Demo Import', 'apparel-ecommerce-store');?></li>
					<li><?php esc_html_e('WooCommerce Integration & Enhanced Features', 'apparel-ecommerce-store');?></li>
					<li><?php esc_html_e('Performance Optimization & SEO-Ready', 'apparel-ecommerce-store');?></li>
					<li><?php esc_html_e('Premium Support & Regular Updates', 'apparel-ecommerce-store');?></li>
				</ul>
			</div>
		</div>
		<div class="right-main-box">
			<div class="right-inner">
				<div class="pro-boxes">
					<h4><?php esc_html_e('Get Theme Bundle', 'apparel-ecommerce-store'); ?></h4>
					<img role="img" src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/get-started/images/bundle.png" alt="bundle image" />
					<p><?php esc_html_e('SUMMER SALE: ', 'apparel-ecommerce-store'); ?><strong><?php esc_html_e('Extra 20%', 'apparel-ecommerce-store'); ?></strong><?php esc_html_e(' OFF on WordPress Theme Bundle Use Code: ', 'apparel-ecommerce-store'); ?><strong><?php esc_html_e('“HEAT20”', 'apparel-ecommerce-store'); ?></strong></p>
					<a href="<?php echo esc_url( APPAREL_ECOMMERCE_STORE_PRO_THEME_BUNDLE ); ?>" target="_blank"><?php esc_html_e('Get Theme Bundle For ', 'apparel-ecommerce-store'); ?><span><?php esc_html_e('$86', 'apparel-ecommerce-store'); ?></span><?php esc_html_e(' $68', 'apparel-ecommerce-store'); ?></a>
				</div>
				<div class="pro-boxes">
					<h4><?php esc_html_e('Apparel Ecommerce Store Pro', 'apparel-ecommerce-store'); ?></h4>
					<img role="img" src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/get-started/images/premium.png" alt="premium image" />
					<p><?php esc_html_e('SUMMER SALE: ', 'apparel-ecommerce-store'); ?><strong><?php esc_html_e('Extra 25%', 'apparel-ecommerce-store'); ?></strong><?php esc_html_e(' OFF on WordPress Block Themes! Use Code: ', 'apparel-ecommerce-store'); ?><strong><?php esc_html_e('“SUMMER25”', 'apparel-ecommerce-store'); ?></strong></p>
					<a href="<?php echo esc_url( APPAREL_ECOMMERCE_STORE_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Upgrade To Pro', 'apparel-ecommerce-store'); ?></a>
				</div>
				<div class="pro-boxes last-pro-box">
					<h4><?php esc_html_e('View All Our Themes', 'apparel-ecommerce-store'); ?></h4>
					<img role="img" src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/get-started/images/all-themes.png" alt="all themes image" />
					<a href="<?php echo esc_url( APPAREL_ECOMMERCE_STORE_PRO_ALL_THEMES ); ?>" target="_blank"><?php esc_html_e('View All Our Premium Themes', 'apparel-ecommerce-store'); ?></a>
				</div>
			</div>
		</div>
	</div>
<?php } ?>