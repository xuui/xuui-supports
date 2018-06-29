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
Version: 0.2.0
Author URI: http://xuui.net/
*/

define('XUUI_PLUGIN_URL',plugin_dir_url(__FILE__));
define('XUUI_PLUGIN_DIR',plugin_dir_path(__FILE__));
//add_action('plugins_loaded','xuui_supportinit');// Get plugin languages.


require_once(XUUI_PLUGIN_DIR.'utility/tuning.php');
require_once(XUUI_PLUGIN_DIR.'utility/utility.php');
require_once(XUUI_PLUGIN_DIR.'custom/custom.php');



/* Action */
/*
add_action('login_head','xuui_login_style');// Login
add_action('pre_ping','xuui_no_self_ping');// No Self Ping

/* Remove wp_head. */
/*

add_action('wp_before_admin_bar_render','xuui_adminbar_remove',0);//Remove adminbar 上的 WordPress Logo
remove_action('wp_head','wp_generator');
remove_action('wp_head','rsd_link');
remove_action('wp_head','wlwmanifest_link');
//remove_action('wp_head','feed_links',2);
/*
remove_action('wp_head','feed_links_extra',3);
remove_action('wp_head','index_rel_link');
remove_action('wp_head','parent_post_rel_link',10,0); 
remove_action('wp_head','start_post_rel_link',10,0); 
remove_action('wp_head','adjacent_posts_rel_link_wp_head',10,0);
remove_action('wp_head','wp_shortlink_wp_head',10,0);
remove_action('template_redirect','wp_shortlink_header',11,0);

/* Action End */


/* Filter */
/*

//add_filter('user_contactmethods','xuui_user_contactmethods');//增加额外的联系字段
/* Filter End */

/* Ex Plugin */
/*
require_once(XUUI_PLUGIN_DIR.'disable-google-fonts.php');
require_once(XUUI_PLUGIN_DIR.'shortcode.php');
/* Ex Plugin End */
?>