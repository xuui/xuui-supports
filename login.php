<?php //Login UI Option.
//print_r(get_option("xuui_loginui"));
function xuui_login_options(){
  $message='更新成功';
  if(isset($_POST['loginui_submit'])){
    $xuui_loginuiopt=get_option("xuui_loginui");
    if(!is_array($xuui_loginuiopt)){
      $xuui_loginuiopt['logo']='';
      $xuui_loginuiopt['form']='';
      $xuui_loginuiopt['background']='';
      $xuui_loginuiopt['button']='';
      $xuui_loginuiopt['inputbox']='';
      update_option('xuui_loginui',$xuui_loginuiopt);
    }
    
    $xuui_loginuiopt['logo']=stripslashes($_POST['logo']);
    $xuui_loginuiopt['form']=stripslashes($_POST['form']);
    $xuui_loginuiopt['background']=stripslashes($_POST['background']);
    $xuui_loginuiopt['button']=stripslashes($_POST['button']);
    $xuui_loginuiopt['inputbox']=stripslashes($_POST['inputbox']);
    
    update_option('xuui_loginui',$xuui_loginuiopt);
    //$message='更新失败';
	//xuui_update_login_option();
		
    echo '<div class="updated"><strong><p>'. $message . '</p></strong></div>';		
  }?>
<div class=wrap>
  <h2>登陆界面</h2>
  <form method="post" action="">
    <fieldset name="wp_basic_options"  class="options">
	  Logo图片：<input type="text" name="logo" value="<?php echo get_option("logo");  ?>" />
	  表单图片：<input type="text" name="form" value="<?php echo get_option("form");  ?>" />
	  背景图片：<input type="text" name="background" value="<?php echo get_option("background");  ?>" />
	  按钮图片：<input type="text" name="button" value="<?php echo get_option("button");  ?>" />
	  输入框图片：<input type="text" name="inputbox" value="<?php echo get_option("inputbox");  ?>" />		
    </fieldset>
    <p class="submit"><input type="submit" name="loginui_submit" value="Update Options &raquo;" /></p>
  </form>
</div>
<?php }
function xuui_signinopt(){
  add_management_page('xuui_signin','登陆界面','manage_options','xuui_login','xuui_login_options');
}
add_action('admin_menu','xuui_signinopt');
?>