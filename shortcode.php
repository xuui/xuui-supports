<?php //The Shortcode.
function xuui_shortcode_style(){
  //if(is_single())
  echo "<link rel=\"stylesheet\" id=\"shortcode\" href=\"".XUUI_PLUGIN_URL."shortcode/shortcode.css\" />\n";
}
add_action('wp_head','xuui_shortcode_style');

function xuui_shortDownbtn($atts,$content=null){
  extract(shortcode_atts(array("href"=>'http://'),$atts));
  return '<div id="xuui_downbut"><a href="'.$href.'"target="_blank"><span>'.$content.'</span></a><div class="clear"></div></div>';
  return '<div id="istudio_downbut"><a href="'.$href.'"target="_blank"><span>'.$content.'</span></a><div class="clear"></div></div>';
}
function xuui_shortVideo($atts,$content=null){
  extract(shortcode_atts(array("auto"=>'0'),$atts));
  return'<embed src="'.XUUI_PLUGIN_URL.'shortcode/xuvideo.swf?auto='.$auto.'&flv='.$content.'" menu="false" quality="high" wmode="transparent" bgcolor="#ffffff" width="560" height="315" name="flvideo" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer_cn" />';
}
function xuui_shortflVideo($atts,$content=null){
  extract(shortcode_atts(array("auto"=>'0'),$atts));
  return'<embed src="'.XUUI_PLUGIN_URL.'shortcode/xuvideo.swf?auto='.$auto.'&flv='.$content.'" menu="false" quality="high" wmode="transparent" bgcolor="#ffffff" width="560" height="315" name="flvideo" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer_cn" />';
}
function xuui_shortAudio($atts,$content=null){
  extract(shortcode_atts(array("auto"=>'0',"replay"=>'0'),$atts));
  return '<embed src="'.XUUI_PLUGIN_URL.'shortcode/xumusic.swf?mp3='.$content.'&amp;auto='.$auto.'" wmode="transparent" width="300" height="52" allowscriptaccess="always" allownetworking="internal" " type="application/x-shockwave-flash" />';
}

add_shortcode('Downlink','xuui_shortDownbtn');
add_shortcode('download','xuui_shortDownbtn');
add_shortcode('video','xuui_shortVideo');
add_shortcode('flv','xuui_shortflVideo');
add_shortcode('mp4','xuui_shortVideo');
add_shortcode('audio','xuui_shortAudio ');
add_shortcode('mp3','xuui_shortAudio');


//Shortcode Page.
function xuui_shortPage(){?>
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
function xuui_shortcode_page(){add_posts_page(__('xuui Shortcode','xuui'),__('xuui Shortcode','xuui'),'edit_posts','xuui_shortcode','xuui_shortPage');}
add_action('admin_menu','xuui_shortcode_page');
//Shortcode Page End.
?>