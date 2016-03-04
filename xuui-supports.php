<?php
/**
 * @package xuui-supports
 * @version 1.0
 */
/*
Plugin Name: xuui Supports
Plugin URI: http://xuui.net/plugins/xu-Podcast/
Description: This is Xu.Design WordPress Supports Plugin.
Author: Xu.hel
Version: 0.0.2
Author URI: http://xuui.net/
*/

/* Init */
/*
function xuui_url($file){return plugins_url($file,__FILE__);}//Get plugin file url path.
function xuui_path($file){return plugin_dir_path(__FILE__).($file);}//Get plugin file dir path.
function xuui_supportinit(){load_textdomain('xuui',plugin_dir_path(__FILE__).'languages/'.get_locale().'.mo');}
/* Init End */

/* Add Action */
//add_action('plugins_loaded','xuui_supportinit');//Get plugin languages.
//add_action('login_head','xuui_login_style');//自定义登录样式
//add_action('wp_before_admin_bar_render','xuui_adminbar_remove',0);//移除 Admin Bar 上的 WordPress Logo
/* Add Action End */

/* Add Filter */
//add_filter('pre_option_link_manager_enabled','__return_true');//恢复链接管理菜单 
//add_filter('user_contactmethods','xuui_user_contactmethods');//增加额外的联系字段
/* Add Filter End */

/* Core Function */
//require_once(xuui_path('disable-google-fonts.php'));
//require_once(xuui_path('core.php'));
/* Core Function End */
?>