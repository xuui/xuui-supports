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

//禁用 Emoji 功能.
remove_action('admin_print_scripts','print_emoji_detection_script');
remove_action('admin_print_styles','print_emoji_styles');
remove_action('wp_head','print_emoji_detection_script',7);
remove_action('wp_print_styles','print_emoji_styles');
remove_action('embed_head','print_emoji_detection_script');
remove_filter('the_content_feed','wp_staticize_emoji');
remove_filter('comment_text_rss','wp_staticize_emoji');
remove_filter('wp_mail','wp_staticize_emoji_for_email');
add_filter('emoji_svg_url','__return_false');

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
add_filter('automatic_updater_disabled','__return_true');// 彻底关闭自动更新
remove_action('init','wp_schedule_update_checks');// 关闭更新检查定时作业
wp_clear_scheduled_hook('wp_version_check');// 移除已有的版本检查定时作业
wp_clear_scheduled_hook('wp_update_plugins');// 移除已有的插件更新定时作业
wp_clear_scheduled_hook('wp_update_themes');// 移除已有的主题更新定时作业
wp_clear_scheduled_hook('wp_maybe_auto_update');// 移除已有的自动更新定时作业
remove_action('admin_init','_maybe_update_core');// 移除后台内核更新检查
remove_action('load-plugins.php','wp_update_plugins');// 移除后台插件更新检查
remove_action('load-update.php','wp_update_plugins');
remove_action('load-update-core.php','wp_update_plugins');
remove_action('admin_init','_maybe_update_plugins');
remove_action('load-themes.php','wp_update_themes');// 移除后台主题更新检查
remove_action('load-update.php','wp_update_themes');
remove_action('load-update-core.php','wp_update_themes');
remove_action('admin_init','_maybe_update_themes');

// Disable auto-embeds for WordPress >= v3.5
remove_filter('the_content',array($GLOBALS['wp_embed'],'autoembed'),8);

// 屏蔽文章 Embed 功能.
remove_action('rest_api_init','wp_oembed_register_route');
remove_filter('rest_pre_serve_request','_oembed_rest_pre_serve_request',10,4);
remove_filter('oembed_dataparse','wp_filter_oembed_result',10 );
remove_filter('oembed_response_data','get_oembed_response_data_rich',10,4);
remove_action('wp_head','wp_oembed_add_discovery_links');
remove_action('wp_head','wp_oembed_add_host_js');
?>