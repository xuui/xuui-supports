<?php/**
* The Disable Google Fonts Plugin
*
* Disable enqueuing of Open Sans and other fonts used by WordPress from Google.
*
* @package Disable_Google_Fonts
* @subpackage Main
*/

/* Exit if accessed directly */
if(!defined('ABSPATH')) exit;
class Disable_Google_Fonts{
  public function __construct(){
    add_filter('gettext_with_context',array($this,'disable_open_sans'),888,4);
    add_action('after_setup_theme',array($this,'register_theme_fonts_disabler'),1);
  }
  public function disable_open_sans($translations,$text,$context,$domain){
    if('Open Sans font: on or off'==$context && 'on'==$text){$translations='off';}
    return $translations;
  }
  public function disable_lato($translations,$text,$context,$domain){
    if('Lato font: on or off'==$context && 'on'==$text){$translations='off';}
    return $translations;
  }
  public function disable_source_sans_pro($translations,$text,$context,$domain){
    if('Source Sans Pro font: on or off'==$context && 'on'==$text){$translations='off';}
    return $translations;
  }
  public function disable_bitter($translations,$text,$context,$domain){
    if('Bitter font: on or off'==$context && 'on'==$text){$translations='off';}
    return $translations;
  }
  public function disable_noto_sans($translations,$text,$context,$domain){
    if('Noto Sans font: on or off'==$context && 'on'==$text){$translations='off';}
    return $translations;
  }
  public function disable_noto_serif($translations,$text,$context,$domain){
    if('Noto Serif font: on or off'==$context && 'on'==$text){$translations='off';}
    return $translations;
  }
  public function disable_inconsolata($translations,$text,$context,$domain){
    if('Inconsolata font: on or off'==$context && 'on'==$text){$translations='off';}
    return $translations;
  }
  public function disable_merriweather($translations,$text,$context,$domain){
    if('Merriweather font: on or off'==$context && 'on'==$text){$translations='off';}
    return $translations;
  }
  public function disable_montserrat($translations,$text,$context,$domain){
    if('Montserrat font: on or off'==$context && 'on'==$text){$translations='off';}
    return $translations;
  }
  public function register_theme_fonts_disabler(){
    $template=get_template();
    switch($template){
      case 'twentysixteen' :
        add_filter('gettext_with_context',array($this,'disable_merriweather'),888,4);
        add_filter('gettext_with_context',array($this,'disable_montserrat'),888,4);
        add_filter('gettext_with_context',array($this,'disable_inconsolata'),888,4);
        break;
      case 'twentyfifteen' :
        add_filter('gettext_with_context',array($this,'disable_noto_sans'),888,4);
        add_filter('gettext_with_context',array($this,'disable_noto_serif'),888,4);
        add_filter('gettext_with_context',array($this,'disable_inconsolata'),888,4);
        break;
      case 'twentyfourteen' :
        add_filter('gettext_with_context',array($this,'disable_lato'),888,4);
        break;
      case 'twentythirteen' :
        add_filter('gettext_with_context',array($this,'disable_source_sans_pro'),888,4);
        add_filter('gettext_with_context',array($this,'disable_bitter'),888,4);
        break;
    }
  }
}
$disable_google_fonts=new Disable_Google_Fonts;
?>