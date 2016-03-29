<?php //The Disable Google Fonts.
add_action('init','xuui_remove_open_sans_from_wp_core');
add_filter('gettext_with_context','xuui_disable_open_sans',888,4);
add_action('after_setup_theme','xuui_register_theme_fonts_disabler',1);
function xuui_remove_open_sans_from_wp_core(){
  wp_deregister_style('open-sans');
  wp_register_style('open-sans',false);
  wp_enqueue_style('open-sans','');
}
function xuui_disable_open_sans($translations,$text,$context,$domain){
  if('Open Sans font: on or off'==$context && 'on'==$text){$translations='off';}
  return $translations;
}
function xuui_disable_lato($translations,$text,$context,$domain){
  if('Lato font: on or off'==$context && 'on'==$text){$translations='off';}
  return $translations;
}
function xuui_disable_source_sans_pro($translations,$text,$context,$domain){
  if('Source Sans Pro font: on or off'==$context && 'on'==$text){$translations='off';}
  return $translations;
}
function xuui_disable_bitter($translations,$text,$context,$domain){
  if('Bitter font: on or off'==$context && 'on'==$text){$translations='off';}
  return $translations;
}
function xuui_disable_noto_sans($translations,$text,$context,$domain){
  if('Noto Sans font: on or off'==$context && 'on'==$text){$translations='off';}
  return $translations;
}
function xuui_disable_noto_serif($translations,$text,$context,$domain){
  if('Noto Serif font: on or off'==$context && 'on'==$text){$translations='off';}
  return $translations;
}
function xuui_disable_inconsolata($translations,$text,$context,$domain){
  if('Inconsolata font: on or off'==$context && 'on'==$text){$translations='off';}
  return $translations;
}
function xuui_disable_merriweather($translations,$text,$context,$domain){
  if('Merriweather font: on or off'==$context && 'on'==$text){$translations='off';}
  return $translations;
}
function xuui_disable_montserrat($translations,$text,$context,$domain){
  if('Montserrat font: on or off'==$context && 'on'==$text){$translations='off';}
  return $translations;
}
function xuui_register_theme_fonts_disabler(){
  $template=get_template();
  switch($template){
    case 'twentysixteen' :
      add_filter('gettext_with_context','xuui_disable_merriweather',888,4);
      add_filter('gettext_with_context','xuui_disable_montserrat',888,4);
      add_filter('gettext_with_context','xuui_disable_inconsolata',888,4);
      break;
    case 'twentyfifteen' :
      add_filter('gettext_with_context','xuui_disable_noto_sans',888,4);
      add_filter('gettext_with_context','xuui_disable_noto_serif',888,4);
      add_filter('gettext_with_context','xuui_disable_inconsolata',888,4);
      break;
    case 'twentyfourteen' :
      add_filter('gettext_with_context','xuui_disable_lato',888,4);
      break;
    case 'twentythirteen' :
      add_filter('gettext_with_context','xuui_disable_source_sans_pro',888,4);
      add_filter('gettext_with_context','xuui_disable_bitter',888,4);
      break;
  }
}
?>