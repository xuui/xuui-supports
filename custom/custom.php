<?php
/**
 * @package xuui-supports
 * @version 1.0
 */

add_action('login_head','xuui_login_style');//自定义登录样式
function xuui_login_style(){
  echo "<style type=\"text/css\">@import url(\"".XUUI_PLUGIN_URL.'custom/login.css'."\");</style>\n";
}

function xuui_adminbar_remove(){//移除 Admin Bar 上的 WordPress Logo
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('wp-logo');
}
add_action('wp_before_admin_bar_render','xuui_adminbar_remove',0);
?>