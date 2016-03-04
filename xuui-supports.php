<?php
/**
 * @package xuui-supports
 * @version 1.0
 */
/*
Plugin Name: xuui Supports
Plugin URI: http://xuui.net/plugins/xuui-supports/
Description: This is Xu.Design WordPress Supports Plugin.
Author: Xu.hel
Version: 0.0.3
Author URI: http://xuui.net/
*/

define('XUUI_PLUGIN_URL',plugin_dir_url(__FILE__));
define('XUUI_PLUGIN_DIR',plugin_dir_path(__FILE__));
require_once(XUUI_PLUGIN_DIR.'core.php');

/* Action */
add_action('plugins_loaded','xuui_supportinit');// Get plugin languages.
add_action('login_head','xuui_login_style');// Login
//add_action('wp_before_admin_bar_render','xuui_adminbar_remove',0);//移除 Admin Bar 上的 WordPress Logo
/* Action End */

/* Filter */
//add_filter('pre_option_link_manager_enabled','__return_true');//恢复链接管理菜单 
//add_filter('user_contactmethods','xuui_user_contactmethods');//增加额外的联系字段
/* Filter End */

/* Core Function */
//require_once(xuui_path('disable-google-fonts.php'));
/* Core Function End */
?>