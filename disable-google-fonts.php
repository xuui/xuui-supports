<?php
/*** The Disable Google Fonts Plugin */
if ( ! defined( 'ABSPATH' ) ) exit;
class Disable_Google_Fonts {
	public function __construct() {
		add_filter( 'gettext_with_context', array( $this, 'disable_open_sans'             ), 888, 4 );
		add_action( 'after_setup_theme',    array( $this, 'register_theme_fonts_disabler' ), 1      );
	}
	public function disable_open_sans( $translations, $text, $context, $domain ) {
		if ( 'Open Sans font: on or off' == $context && 'on' == $text ) {
			$translations = 'off';
		}
		return $translations;
	}
	public function disable_lato( $translations, $text, $context, $domain ) {
		if ( 'Lato font: on or off' == $context && 'on' == $text ) {
			$translations = 'off';
		}
		return $translations;
	}
	public function disable_source_sans_pro( $translations, $text, $context, $domain ) {
		if ( 'Source Sans Pro font: on or off' == $context && 'on' == $text ) {
			$translations = 'off';
		}
		return $translations;
	}
	public function disable_bitter( $translations, $text, $context, $domain ) {
		if ( 'Bitter font: on or off' == $context && 'on' == $text ) {
			$translations = 'off';
		}
		return $translations;
	}
	public function register_theme_fonts_disabler() {
		$template = get_template();
		switch ( $template ) {
			case 'twentyfourteen' :
				add_filter( 'gettext_with_context', array( $this, 'disable_lato'            ), 888, 4 );
				break;
			case 'twentythirteen' :
				add_filter( 'gettext_with_context', array( $this, 'disable_source_sans_pro' ), 888, 4 );
				add_filter( 'gettext_with_context', array( $this, 'disable_bitter'          ), 888, 4 );
				break;
		}
	}
}
$disable_google_fonts=new Disable_Google_Fonts;
?>