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
remove_action('wp_head','wp_resource_hints',2);

// 禁用 XML-RPC 接口.
add_filter('xmlrpc_enabled','__return_false');

//彻底关闭 pingback. sql: UPDATE `wp_posts` SET ping_status="closed";
add_filter('xmlrpc_methods',function($methods){
  $methods['pingback.ping']='__return_false';
  $methods['pingback.extensions.getPingbacks']='__return_false';
  return $methods;
});
remove_action('do_pings','do_all_pings',10);//禁用 pingbacks, enclosures, trackbacks
remove_action('publish_post','_publish_post_hook',5);//去掉 _encloseme 和 do_ping 操作。

// 屏蔽 REST API.
add_filter('rest_enabled','__return_false');
add_filter('rest_jsonp_enabled','__return_false');
// 移除头部 wp-json 标签和 HTTP header 中的 link.
remove_action('wp_head','rest_output_link_wp_head',10);
remove_action('template_redirect','rest_output_link_header',11);
add_filter('rest_authentication_errors',function($access){
	return new WP_Error('rest_cannot_acess','REST API不再提供访问',array('status'=>403));
});

//禁用 Emoji 功能.
remove_action('admin_print_scripts','print_emoji_detection_script');
remove_action('admin_print_styles','print_emoji_styles');
remove_action('wp_head','print_emoji_detection_script',7);
remove_action('wp_print_styles','print_emoji_styles');
remove_action('embed_head','print_emoji_detection_script');
remove_filter('the_content_feed','wp_staticize_emoji');
remove_filter('comment_text_rss','wp_staticize_emoji');
remove_filter('wp_mail','wp_staticize_emoji_for_email');
add_filter('emoji_svg_url','__return_false');//屏蔽头部加载 s.w.org.

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
add_filter('automatic_updater_disabled','__return_true');// 彻底关闭自动更新.
remove_action('init','wp_schedule_update_checks');// 关闭更新检查定时作业.
wp_clear_scheduled_hook('wp_version_check');// 移除已有的版本检查定时作业.
wp_clear_scheduled_hook('wp_update_plugins');// 移除已有的插件更新定时作业.
wp_clear_scheduled_hook('wp_update_themes');// 移除已有的主题更新定时作业.
wp_clear_scheduled_hook('wp_maybe_auto_update');// 移除已有的自动更新定时作业.
remove_action('admin_init','_maybe_update_core');// 移除后台内核更新检查.
remove_action('load-plugins.php','wp_update_plugins');// 移除后台插件更新检查.
remove_action('load-update.php','wp_update_plugins');
remove_action('load-update-core.php','wp_update_plugins');
remove_action('admin_init','_maybe_update_plugins');
remove_action('load-themes.php','wp_update_themes');// 移除后台主题更新检查.
remove_action('load-update.php','wp_update_themes');
remove_action('load-update-core.php','wp_update_themes');
remove_action('admin_init','_maybe_update_themes');

// Disable auto-embeds for WordPress >= v3.5.
remove_filter('the_content',array($GLOBALS['wp_embed'],'autoembed'),8);

// 屏蔽文章 Embed 功能.
remove_action('rest_api_init','wp_oembed_register_route');
remove_filter('rest_pre_serve_request','_oembed_rest_pre_serve_request',10,4);
remove_filter('oembed_dataparse','wp_filter_oembed_result',10 );
remove_filter('oembed_response_data','get_oembed_response_data_rich',10,4);
remove_action('wp_head','wp_oembed_add_discovery_links');
remove_action('wp_head','wp_oembed_add_host_js');

// 屏蔽 Gutenberg 编辑器.cms.
add_filter('use_block_editor_for_post_type','__return_false');

// 去掉编辑器的 srcset.
function xuui_disable_srcset($sources){return false;}
add_filter('wp_calculate_image_srcset','xuui_disable_srcset');

// 彻底取消 Widget.cms.
remove_action('plugins_loaded','wp_maybe_load_widgets',0);
remove_action('init','wp_widgets_init',1);

// 屏蔽字符转码.
add_filter('run_wptexturize','__return_false');

// 屏蔽站点管理员邮箱验证功能.
#add_filter('admin_email_check_interval','__return_false');

// 移除后台隐私相关的页面 for China.
/*
add_action('admin_menu',function(){
  global $menu,$submenu;
  // 移除设置菜单下的隐私子菜单.
  unset($submenu['options-general.php'][45]);
  // 移除工具彩带下的相关页面.
  remove_action('admin_menu','_wp_privacy_hook_requests_page');
  remove_filter('wp_privacy_personal_data_erasure_page','wp_privacy_process_personal_data_erasure_page',10,5);
  remove_filter('wp_privacy_personal_data_export_page','wp_privacy_process_personal_data_export_page',10,7);
  remove_filter('wp_privacy_personal_data_export_file','wp_privacy_generate_personal_data_export_file',10);
  remove_filter('wp_privacy_personal_data_erased','_wp_privacy_send_erasure_fulfillment_notification',10);
  // Privacy policy text changes check.
  remove_action('admin_init',array( 'WP_Privacy_Policy_Content','text_change_check'),100);
  // Show a "postbox" with the text suggestions for a privacy policy.
  remove_action('edit_form_after_title',array( 'WP_Privacy_Policy_Content','notice'));
  // Add the suggested policy text from WordPress.
  remove_action('admin_init',array( 'WP_Privacy_Policy_Content','add_suggested_content'),1);
  // Update the cached policy info when the policy page is updated.
  remove_action('post_updated',array( 'WP_Privacy_Policy_Content','_policy_page_updated'));
},9);
*/

//移除后台界面右上角的帮助
add_action('in_admin_header',function(){
  global $current_screen;
  $current_screen->remove_help_tabs();
});

//移除后台界面右上角的选项
add_action('in_admin_header',function(){
  add_filter('screen_options_show_screen','__return_false');
  add_filter('hidden_columns','__return_empty_array');
});

//屏蔽站点Feed.
function wpjam_feed_disabled(){
	wp_die('Feed 已经关闭, 请访问网站<a href="'.get_bloginfo('url').'">首页</a>！');
}
add_action('do_feed','wpjam_feed_disabled',1);
add_action('do_feed_rdf','wpjam_feed_disabled',1);
add_action('do_feed_rss','wpjam_feed_disabled',1);
add_action('do_feed_rss2','wpjam_feed_disabled',1);
add_action('do_feed_atom','wpjam_feed_disabled',1);

// 替换 Gravatar 头像的服务器地址.
function dmeng_get_https_avatar($avatar){
	$avatar=str_replace(array("www.gravatar.com","0.gravatar.com","1.gravatar.com","2.gravatar.com"),"secure.gravatar.com",$avatar);
	$avatar=str_replace("http://","https://",$avatar);
	return $avatar;
}
add_filter('get_avatar','dmeng_get_https_avatar');

// 彻底关闭全高度编辑器和免打扰功能.
add_action('admin_init',function(){wp_deregister_script('editor-expand');});
add_filter('tiny_mce_before_init',function($init){unset($init['wp_autoresize_on']);return $init;});

// 在后台插入图片时候，尺寸选择框只保留完整尺寸格式.
add_filter('image_size_names_choose',function($image_sizes){
  unset($image_sizes['thumbnail']);
  unset($image_sizes['medium']);
  unset($image_sizes['large']);
  return $image_sizes;
});

// 显示后台的远程请求.
add_filter('pre_http_request','wpjam_admin_display_http_request',10,3);
function wpjam_admin_display_http_request($status,$r,$url){if(is_admin() && isset($_GET['debug'])){echo 'http_request：'.$url."\n<br />";return $status;}}
add_filter('http_request_timeout','wpjam_admin_short_http_request_timeout');
function wpjam_admin_short_http_request_timeout($timeout){if(is_admin()){return 1;}return $timeout;}
