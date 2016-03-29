<?php //Core.
function xuui_supportinit(){
  load_textdomain('xuui',XUUI_PLUGIN_DIR.'languages/'.get_locale().'.mo');
}

// Login
function xuui_login_style(){
  echo "<style type=\"text/css\">@import url(\"".XUUI_PLUGIN_URL.'ui-login/login.css'."\");</style>\n";
}

// Remove Admin Bar WordPress Logo
function xuui_adminbar_remove(){
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('wp-logo');
}
// No Self Ping.
function xuui_no_self_ping(&$links){
  $home=get_option('home');
  foreach($links as $l=>$link)
    if(0===strpos($link,$home))
  unset($links[$l]);
}

/* //增加额外的联系字段
function xuui_user_contactmethods($user_contactmethods){
  $user_contactmethods['weibo']=__('weibo','xuui');
  $user_contactmethods['t-qq']=__('qq weibo','xuui');
  $user_contactmethods['imessage']=__('iMessage','xuui');
  return $user_contactmethods;
}
*/
?>