<?php
/**
 * @package xuui-supports
 * @version 1.0
 */
/* Wordpress 优化项目.*/

// super easy way to move javascript to footer.
//remove_action('wp_head','wp_print_scripts');
//remove_action('wp_head','wp_print_head_scripts',9);
//remove_action('wp_head','wp_enqueue_scripts',1);
//add_action('wp_footer','wp_enqueue_scripts',5);
//add_action('wp_footer','wp_print_scripts',5);
//add_action('wp_footer','wp_print_head_scripts',5);

remove_action('wp_head','rsd_link');//XML-RPC.
remove_action('wp_head', 'wlwmanifest_link');//Windows Live Writer.
remove_action('wp_head', 'wp_generator');//WordPress Ver.

remove_action('wp_head', 'start_post_rel_link');//Post relational links.
remove_action('wp_head', 'index_rel_link');//Post relational links.
remove_action('wp_head', 'adjacent_posts_rel_link');//Post relational links.


?>