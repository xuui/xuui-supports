<?php
/**
 * @package xuui-supports
 * @version 1.0
 */
/*
Plugin Name: x Supports
Plugin URI: http://xuui.net/plugins/xu-Podcast/
Description: WordPress Supports Plugin.
Author: Xu.hel
Version: 0.1
Author URI: http://xuui.net/
*/

#load_plugin_textdomain('xuui',false,dirname(plugin_basename(__FILE__)).'/languages/');
#Main function Start.
#Main function End.

/*
function xuui_admin_color(){//自定义后台样式
  wp_admin_css_color('xuui',__('Xu.Design','xuui'),xuui_file('xuui-colors.css'),array('#33363b','#0066aa','#259bdb','#e6e6e6'));
}
function xuui_notices(){//自定义提醒信息
  echo "<p id='Xu_Notices'>Xu_Notices</p>";
}
function xuui_notices_css(){//自定义提醒样式
  $x=is_rtl()?'left':'right';
  echo '<style type="text/css">#Xu_Notices{float:'.$x.';padding-'.$x.':15px;margin:0;padding-top:5px;font-size:11px;}</style>';
}
*/
function xuui_login_style(){//自定义登录样式
  echo '<style type="text/css">@import url("'.xuui_file('login.css').'");</style>';
}
function xuui_adminbar_remove(){//移除 Admin Bar 上的 WordPress Logo
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('wp-logo');
}
/*
function xuui_from_email($email){$wp_from_email=get_option('admin_email');return $wp_from_email;}
function xuui_search_filter($query){//把页面从搜索结果中排除
  if($query->is_search){$query->set('post_type','post');}
  return $query;
}
function xuui_remove_editor_menu(){//移除后台的主题编辑器
  remove_action('admin_menu','_add_themes_utility_last',101);
}
function xuui_remove_width_attribute($html){//移除后台上传的的图片的宽度和高度参数
   $html=preg_replace('/(width|height)="\d*"\s/',"",$html);
   return $html;
}
function xuui_adminbar_menu(){//给Admin Bar 添加链接
  global $wp_admin_bar;
  //$wp_admin_bar->add_menu(array('parent'=>false,'id'=>__('xuui','xuui'),'title'=>__('xuui','xuui'),'href'=>admin_url('themes.php?page=ilost_options'),'meta'=>false));
  $wp_admin_bar->add_menu(array('parent'=>false,'id'=>"xuui_site",'title'=>__('Xu','xuui'),'href'=>false));
  $wp_admin_bar->add_menu(array('parent'=>"xuui_site",'id'=>"xuui_design",'title'=>__('Xu.Design','xuui'),'href'=>"http://xuui.net",'meta'=>false));
  $wp_admin_bar->add_menu(array('parent'=>"xuui_site",'id'=>"xuui_work",'title'=>__('Works','xuui'),'href'=>"http://work.xuui.net",'meta'=>false));
  $wp_admin_bar->add_menu(array('parent'=>"xuui_site",'id'=>"xuui_labe",'title'=>__('Labs','xuui'),'href'=>"http://labs.xuui.net",'meta'=>false));
  $wp_admin_bar->add_menu(array('parent'=>"xuui_site",'id'=>"xuui_demo",'title'=>__('Theme Demo','xuui'),'href'=>"http://demo.xuui.net",'meta'=>false));
}
*/
function xuui_parse_query_useronly($wp_query){//让作者在后台只看到自己的文章
  if(strpos($_SERVER['REQUEST_URI'],'/wp-admin/edit.php')!==false){
    if(!current_user_can('add_user')){
      global $current_user;
      $wp_query->set('author',$current_user->id);
    }
  }
}
/*
function xuui_post_user_only($text){//设置只有注册用户才能浏览特定的内容
  global $post;
  $user_only=get_post_meta($post->ID,'user_only',true);
  if($user_only){global $user_ID;
	if(!$user_ID){
	  $redirect=get_permalink($post->ID);
	  $text=sprintf(__('The content is limited to registered users view, please <a href="%1$s">login</a>!','xuui'),wp_login_url($redirect));
	}
  }
  return $text;
}
*/
function xuui_smilies_src($img_src,$img,$siteurl){//自定义表情图片位置
  return WP_CONTENT_URL.'/smilies/'.$img;
}
function xuui_noselfping(&$links){$home=get_option('home');foreach($links as $l=>$link)if(0===strpos($link,$home))unset($links[$l]);}
/*
function xuui_replacetxt_wps($text){//自定义热点文字链接
  $replace=array(
	'WordPress'=>'<a href="http://wordpress.org/">WordPress</a>',
	'Windows'=>'<a href="http://windows.microsoft.com/zh-cn/windows/">Windows</a>',
	'apple'=>'<a href="http://www.apple.com/">apple</a>',
	'苹果'=>'<a href="http://www.apple.com/">苹果</a>',
	'microsoft'=>'<a href="http://www.microsoft.com/">Microsoft</a>',
	'微软'=>'<a href="http://www.microsoft.com/">微软</a>',
	'iPhone'=>'<a href="http://www.apple.com/iphone">iPhone</a>',
	'iPad'=>'<a href="http://www.apple.com/ipad">iPad</a>',
	'xuhel'=>'<a href="http://xuui.net/">Xu.hel</a>',
	'xu.hel'=>'<a href="http://xuui.net/">Xu.hel</a>'
  );
  $text=str_replace(array_keys($replace),$replace,$text);
  return $text;
}
function xuui_columnViews($columns){$columns['views']=__('Views','xuui');return $columns;}//文章浏览量统计
function xuui_columnViews_show($column_name,$id){if($column_name!='views'){return;}$post_views=get_post_meta($id,"views",true);if($post_views){echo $post_views.__(' views','xuui');}else{echo __('No Views','xuui');}}
function xuui_columnViews_css(){?><style type="text/css">.fixed .column-views{width:6em;}</style><?php }
/*
if(!function_exists('the_views')){function the_views(){
  $views=get_post_meta(get_the_ID(),'views',$single=true);
  if($views==''){$views='0';}
  //if(is_single()){xuui_set_views();}
  echo $views.' views';
}}
function xuui_set_views(){
  $views=get_post_meta(get_the_ID(),'views',$single=true);
  if(!update_post_meta(get_the_ID(),'views',($views+1))){
	add_post_meta(get_the_ID(),'views',1,true);
  }
}
*/
/*
function xuui_post_copyright(){//自动在文章尾部添加版权信息
  if(is_single()){global $post,$authordata;?>
<div id="copyright">
  <?php echo get_avatar($authordata->ID,'48');?>
  <p>作者：<a href="<?php echo $authordata->user_url;?>" title="<?php echo $authordata->display_name;?>"><?php echo $authordata->display_name;?></a><br />
  原文链接：<a href="<?php echo get_permalink($post->ID);?>" title="<?php echo $post->post_title;?>"><?php echo $post->post_title;?></a><br />
  <a href="<?php bloginfo('url');?>" title="<?php bloginfo('name');?>"><?php bloginfo('name');?></a>版权所有，请勿转载本博客日志到任何博客或论坛。</p>
</div>
<?php }
}
//add_filter('the_content','xuui_post_copyright_content');
function xuui_post_copyright_content($text){
	ob_start();
	xuui_post_copyright();
	$post_copyright_content = ob_get_contents();
	ob_end_clean();
	return $text.$post_copyright_content;
}



//Theme Get Function.
function xuui_get_first_p($post){//提取第一个段落文字
  if(preg_match('/<p>(.*)<\/p>/iU',trim(strip_tags($post->post_content,"<p>")),$matches)){return $matches[1];}else{
	$post_content=explode("\n",trim(strip_tags($post->post_content))); 
	return $post_content['0'];
  }
}

*/
//Theme Shortcode Start.
function xuui_xuCshortcode_style(){echo '<link rel="stylesheet" href="'.xuui_file('shortcode/shortstyle.css').'" media="screen" />';}
function xuui_xuCdownlink($atts,$content=null){
  extract(shortcode_atts(array("href"=>'http://'),$atts));
  return '<div id="xuui_downbut"><a href="'.$href.'"target="_blank"><span>'.$content.'</span></a><div class="clear"></div></div>';
}
function xuui_xuCvideolink($atts,$content=null){
  extract(shortcode_atts(array("auto"=>'0'),$atts));
  return'<embed src="'.xuui_file('shortcode/xuvideo.swf').'?auto='.$auto.'&flv='.$content.'" menu="false" quality="high" wmode="transparent" bgcolor="#ffffff" width="560" height="315" name="flvideo" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer_cn" />';
}
function xuui_xuCaudiolink($atts,$content=null){
  extract(shortcode_atts(array("auto"=>'0',"replay"=>'0'),$atts));
  return '<embed src="'.xuui_file('shortcode/xumusic.swf').'?mp3='.$content.'&amp;auto='.$auto.'" wmode="transparent" width="300" height="52" allowscriptaccess="always" allownetworking="internal" " type="application/x-shockwave-flash" />';
}
function xuui_xuCShortpage(){?>
<style type="text/css">
fieldset{border:1px solid #ddd;margin:15px 0 20px;padding:0 15px;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;}
fieldset:hover{border-color:#bbb;}
fieldset legend{padding:0 6px;font-size:14px;}
</style>
<div class="wrap">
<div id="icon-upload" class="icon32"><br></div>
  <h2><?php _e('xuui Shortcode Guide','xuui');?></h2>
  <fieldset>
    <legend><strong><?php _e('Insert Download Button','xuui');?></strong></legend>
    <p><?php _e('Insert the following code into the editor, you will be able to use the built-in download button style.','xuui');?></p>
    <p><?php printf(__('%1$s: <code>[Downlink href="http://www.xxx.com/xxx.zip"]download xxx.zip[/Downlink]</code>','xuui'),__('Code format','xuui'));?></p>
  </fieldset>
  <fieldset>
    <legend><strong><?php _e('Insert Audio','xuui');?></strong></legend>
    <p><?php _e('Insert the following code into the editor, you will be able to use the built-in MP3 music player.','xuui');?></p>
    <p><?php _e('Only supports mp3 file URL.','xuui');?></p>
    <p><?php printf(__('%1$s: <code>[mp3]http://www.xxx.com/xxx.mp3[/mp3]</code>','xuui'),__('Code format','xuui'));?></p>
    <p><?php printf(__('%1$s: <code>[mp3 auto="1"]http://www.xxx.com/xxx.mp3[/mp3]</code>','xuui'),__('Auto Play','xuui'));?></p>
    <p><?php printf(__('%1$s: <code>[mp3 replay="1"]http://www.xxx.com/xxx.mp3[/mp3]</code>','xuui'),__('Repeat Play','xuui'));?></p>
    <p><?php printf(__('%1$s: <code>[mp3 auto="1" replay="1"]http://www.xxx.com/xxx.mp3[/mp3]</code>','xuui'),__('Auto Play and Repeat Play','xuui'));?></p>
  </fieldset>
  <fieldset>
    <legend><strong><?php _e('Insert Video','xuui');?></strong></legend>
    <p><?php _e('Insert the following code into the editor, you will be able to use the built-in video player to play FLV video.','xuui');?></p>
    <p><?php _e('Only supports flv file URL.','xuui');?></p>
    <p><?php printf(__('%1$s: <code>[flv]http://www.xxx.com/xxx.flv[/flv]</code>','xuui'),__('Code format','xuui'));?></p>
    <p><?php printf(__('%1$s: <code>[flv auto="1"]http://www.xxx.com/xxx.flv[/flv]</code>','xuui'),__('Auto Play','xuui'));?></p>
  </fieldset>
</div>
<?php }
function xuui_xuCshortcode_page(){add_posts_page(__('xuui Shortcode','xuui'),__('xuui Shortcode','xuui'),'edit_posts','xuui_shortcode','xuui_xuCShortpage');}
//Theme Shortcode End.


/*

/*if(!function_exists('get_avatar')){
function get_avatar($id_or_email,$size='96',$default='',$alt=false){
	if(!get_option('show_avatars'))return false;
	if(false===$alt){$safe_alt='';}else{$safe_alt=esc_attr($alt);}
	if(!is_numeric($size))$size='96';
	$email='';
	if(is_numeric($id_or_email)){
		$id=(int)$id_or_email;
		$user=get_userdata($id);
		if($user)$email=$user->user_email;
	}elseif(is_object($id_or_email)){
		$allowed_comment_types=apply_filters('get_avatar_comment_types',array('comment'));
		if(!empty($id_or_email->comment_type) && !in_array($id_or_email->comment_type,(array) $allowed_comment_types)){return false;}
		if(!empty($id_or_email->user_id)){
			$id=(int)$id_or_email->user_id;
			$user=get_userdata($id);
			if($user)$email=$user->user_email;
		}elseif(!empty($id_or_email->comment_author_email)){$email=$id_or_email->comment_author_email;}
	}else{$email=$id_or_email;}
	if(empty($default)){$avatar_default=get_option('avatar_default');if(empty($avatar_default)){$default='mystery';}else{$default=$avatar_default;}}
	if(!empty($email))$email_hash=md5(strtolower($email));
	if(is_ssl()){$host='https://secure.gravatar.com';}else{$host='http://www.gravatar.com';}
	if('mystery'==$default)$default="$host/avatar/ad516503a11cd5ca435acc9bb6523536?s={$size}";	elseif('blank'==$default)$default=includes_url('images/blank.gif');
	elseif(!empty($email) && 'gravatar_default'==$default)$default='';
	elseif('gravatar_default'==$default)$default="$host/avatar/s={$size}";
	elseif(empty($email))$default="$host/avatar/?d=$default&amp;s={$size}";
	elseif(strpos($default,'http://')===0)$default=add_query_arg('s',$size,$default);
	if(!empty($email)){$out="$host/avatar/";$out.=$email_hash;$out.='?s='.$size;$out.='&amp;d='.urlencode($default);$rating=get_option('avatar_rating');if(!empty( $rating ))$out.="&amp;r={$rating}";$avatar="<img alt='{$safe_alt}' src='{$out}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";}else{$avatar="<img alt='{$safe_alt}' src='{$default}' class='avatar avatar-{$size} photo avatar-default' height='{$size}' width='{$size}' />";}
	return apply_filters('get_avatar',$avatar,$id_or_email,$size,$default,$alt);
}
}*/
////////////////////////////////
//



//JavaScript to Footer.
remove_action('wp_head','wp_print_scripts');
remove_action('wp_head','wp_print_head_scripts',9);
remove_action('wp_head','wp_enqueue_scripts',1);
add_action('wp_footer','wp_print_scripts',5);
add_action('wp_footer','wp_enqueue_scripts',5);
add_action('wp_footer','wp_print_head_scripts',5);
//Add to Action.
add_action('login_head','xuui_login_style');
/*
add_action('admin_init','xuui_admin_color');
add_action('admin_notices','xuui_notices');
add_action('admin_head','xuui_notices_css');
add_action('admin_bar_menu','xuui_adminbar_menu');
*/
add_filter('parse_query', 'xuui_parse_query_useronly');
add_action('pre_ping','xuui_noselfping');
/*
add_action('wp_before_admin_bar_render','xuui_adminbar_remove',0);
*/
#add_action('_admin_menu','xuui_remove_editor_menu',1);
/*
add_filter('pre_get_posts','xuui_search_filter');
add_filter('wp_mail_from','xuui_from_email');
add_filter('post_thumbnail_html','xuui_remove_width_attribute',10);
add_filter('image_send_to_editor','xuui_remove_width_attribute',10);
add_filter('the_content','xuui_replacetxt_wps');
add_filter('the_excerpt','xuui_replacetxt_wps');
*/
/*
add_filter('the_content','xuui_post_user_only');
add_filter('smilies_src','xuui_smilies_src',1,10);
//Show Views.
/*
if(!function_exists('the_views')){
add_action('admin_head','xuui_columnViews_css');
add_filter('manage_posts_columns','xuui_columnViews');
add_action('manage_posts_custom_column','xuui_columnViews_show',10,2);
}
*/
//Shortcode.
add_action('wp_head','xuui_xuCshortcode_style');
add_shortcode('Downlink','xuui_xuCdownlink');
add_shortcode('download','xuui_xuCdownlink');
add_shortcode('video','xuui_xuCvideolink');
add_shortcode('audio','xuui_xuCaudiolink ');
add_shortcode('flv','xuui_xuCvideolink');
add_shortcode('mp4','xuui_xuCvideolink');
add_shortcode('mp3','xuui_xuCaudiolink');
add_action('admin_menu','xuui_xuCshortcode_page');
?>