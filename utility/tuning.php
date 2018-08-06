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
remove_action('wp_head','wlwmanifest_link');//Windows Live Writer.
remove_action('wp_head','wp_generator');//WordPress Ver.

remove_action('wp_head','start_post_rel_link');//Post relational links.
remove_action('wp_head','index_rel_link');//Post relational links.
remove_action('wp_head','adjacent_posts_rel_link');//Post relational links.

// 屏蔽 REST API
add_filter('rest_enabled','__return_false');
add_filter('rest_jsonp_enabled','__return_false');
// 移除头部 wp-json 标签和 HTTP header 中的 link
remove_action('wp_head','rest_output_link_wp_head',10);
remove_action('template_redirect','rest_output_link_header',11);

// Disable auto-embeds for WordPress >= v3.5
remove_filter('the_content',array($GLOBALS['wp_embed'],'autoembed'),8);

// 移除 WordPress 自动修正 WordPress 大小写函数.
remove_filter('the_content','capital_P_dangit');
remove_filter('the_title','capital_P_dangit');
remove_filter('comment_text','capital_P_dangit');

// 移除 Shortcode 中自动添加的 br 和 p 标签.
remove_filter('the_content','wpautop');
add_filter('the_content','wpautop',12);

// 移除后台核心，插件和主题的更新提示.
add_filter('pre_site_transient_update_core','__return_null');
remove_action('load-update-core.php','wp_update_plugins');
add_filter('pre_site_transient_update_plugins','__return_null');
remove_action('load-update-core.php','wp_update_themes');
add_filter('pre_site_transient_update_themes','__return_null');
?>