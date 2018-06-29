<?php
/**
 * @package xuui-supports
 * @version 1.0
 */

// super easy way to move javascript to footer.
remove_action('wp_head','wp_print_scripts');
remove_action('wp_head','wp_print_head_scripts',9);
remove_action('wp_head','wp_enqueue_scripts',1);
add_action('wp_footer','wp_print_scripts',5);
add_action('wp_footer','wp_enqueue_scripts',5);
add_action('wp_footer','wp_print_head_scripts',5);

?>