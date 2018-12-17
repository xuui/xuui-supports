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

//彻底关闭 pingback
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

// 移除后台隐私相关的页面 for China.
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

//防止上传的图片重名，加上时间戳
function xuui_handle_upload_prefilter($file){
  if(strlen($file['name'])<=7){$file['name']=time().'-'.$file['name'];}
  return $file;
};
add_filter('wp_handle_upload_prefilter','xuui_handle_upload_prefilter'); 
?>