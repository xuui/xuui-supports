<?php
/**
 * @package xuui-supports
 * @version 1.0
 */

add_action('login_head','xuui_login_style');//自定义登录样式
function xuui_login_style(){
  echo "<style type=\"text/css\">@import url(\"".XUUI_PLUGIN_URL('ui-login/login.css')."\");</style>\n";
}
?>