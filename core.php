<?php //Core.
//增加额外的联系字段
function xuui_user_contactmethods($user_contactmethods){
  $user_contactmethods['weibo']=__('weibo','xuui');
  $user_contactmethods['t-qq']=__('qq weibo','xuui');
  $user_contactmethods['imessage']=__('iMessage','xuui');
  return $user_contactmethods;
}
//移除 Admin Bar 上的 WordPress Logo
function xuui_adminbar_remove(){
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('wp-logo');
}
?>