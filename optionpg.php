<?php
/**
 * @package xuui-supports
 * @version 1.0
 */
/* Option Page.*/

function xuui_supports_options(){
?>
<div class=wrap>
<form method="post" action="">
<h2>xuui_supports_options</h2>
</form>
</div>
<?php
}

//Add Option Menu.
function xuui_supports_options_admin(){
  add_options_page('xuui_supports', 'xuu: Supports', 'manage_options', __FILE__,'xuui_supports_options');
}
add_action('admin_menu', 'xuui_supports_options_admin');

?>