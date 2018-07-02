<?php
/**
 * @package xuui-supports
 * @version 1.0
 */

add_action('login_head','xuui_login_style');//自定义登录样式
function xuui_login_style(){
  echo "<style type=\"text/css\">@import url(\"".XUUI_PLUGIN_URL.'custom/login.css'."\");</style>\n";
}
add_action('login_form','xuui_login_script');//自定义登录表单
add_action('lostpassword_form','xuui_login_script');//自定义找回密码表单
add_action('register_form','xuui_login_script');//自定义注册表单
function xuui_login_script(){
  echo "<script type=\"text/javascript\">\n
  var user_login=document.querySelector('#user_login'),user_email=document.querySelector('#user_email'),user_pass=document.querySelector('#user_pass');
  if(user_login)user_login.setAttribute('placeholder','用户名或电子邮件地址');\n
  if(user_email)user_email.setAttribute('placeholder','电子邮件');\n
  if(user_pass)user_pass.setAttribute('placeholder','密码');\n
  </script>\n";
}
?>