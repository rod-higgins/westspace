<?php
// Quick cache clearing script
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
}

// Clear object cache
if (function_exists('wp_cache_delete')) {
    wp_cache_delete('alloptions', 'options');
}

// Clear transients
global $wpdb;
$wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_%'");
$wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_site_transient_%'");

echo "Cache cleared!";
?>
