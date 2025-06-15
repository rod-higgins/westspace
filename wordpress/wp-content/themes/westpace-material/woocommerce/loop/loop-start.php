<?php
// =================================
// FILE: woocommerce/loop/loop-start.php
// =================================
/**
 * Product Loop Start
 *
 * @package Westpace_Material
 * @version 3.0.0
 */

defined('ABSPATH') || exit;
?>
<ul class="products columns-<?php echo esc_attr(wc_get_loop_prop('columns')); ?>">