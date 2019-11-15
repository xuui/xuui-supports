<?php /** Post Type */
function xuui_postType(){
  /* **
  //register_post_type( $post_type, $args=array() );
  $xuui_type_labels=array(
    'name'=>'xuui',
    'singular_name'=>'xuui',// - name for one object of this post type. Default is Post/Page
    'add_new'=>'add_new',// - the add new text. The default is "Add New" for both hierarchical and non-hierarchical post types. When internationalizing this string, please use a gettext context matching your post type. Example: _x('Add New', 'product');
    'add_new_item'=>'add_new_item',// - Default is Add New Post/Add New Page.
    'edit_item'=>'edit_item',// - Default is Edit Post/Edit Page.
    'new_item'=>'new_item',// - Default is New Post/New Page.
    'view_item'=>'view_item',// - Default is View Post/View Page.
    'view_items'=>'view_items',// - Label for viewing post type archives. Default is 'View Posts' / 'View Pages'.
    'search_items'=>'search_items',// - Default is Search Posts/Search Pages.
    'not_found'=>'not_found',// - Default is No posts found/No pages found.
    'not_found_in_trash'=>'not_found_in_trash',// - Default is No posts found in Trash/No pages found in Trash.
    'parent_item_colon'=>'parent_item_colon',// - This string isn't used on non-hierarchical types. In hierarchical ones the default is 'Parent Page:'.
    'all_items'=>'all_items',// - String for the submenu. Default is All Posts/All Pages.
    'archives'=>'archives',// - String for use with archives in nav menus. Default is Post Archives/Page Archives.
    'attributes'=>'attributes',// - Label for the attributes meta box. Default is 'Post Attributes' / 'Page Attributes'.
    'insert_into_item'=>'insert_into_item',// - String for the media frame button. Default is Insert into post/Insert into page.
    'uploaded_to_this_item'=>'uploaded_to_this_item',// - String for the media frame filter. Default is Uploaded to this post/Uploaded to this page.
    'featured_image'=>'featured_image',// - Default is Featured Image.
    'set_featured_image'=>'set_featured_image',// - Default is Set featured image.
    'remove_featured_image'=>'remove_featured_image',// - Default is Remove featured image.
    'use_featured_image'=>'use_featured_image',// - Default is Use as featured image.
    'menu_name'=>'menu_name',// - Default is the same as `name`.
    'filter_items_list'=>'filter_items_list',// - String for the table views hidden heading.
    'items_list_navigation'=>'items_list_navigation',// - String for the table pagination hidden heading.
    'items_list'=>'items_list',// - String for the table hidden heading.
    'name_admin_bar'=>'name_admin_bar',// - String for use in New in Admin menu bar. Default is the same as `singular_name`.
    'item_published'=>'item_published',// - The label used in the editor notice after publishing a post. Default “Post published.” / “Page published.”
    'item_published_privately'=>'item_published_privately',// - The label used in the editor notice after publishing a private post. Default “Post published privately.” / “Page published privately.”
    'item_reverted_to_draft'=>'item_reverted_to_draft',// - The label used in the editor notice after reverting a post to draft. Default “Post reverted to draft.” / “Page reverted to draft.”
    'item_scheduled'=>'item_scheduled',// - The label used in the editor notice after scheduling a post to be published at a later date. Default “Post scheduled.” / “Page scheduled.”
    'item_updated'=>'item_updated',// - The label used in the editor notice after updating a post. Default “Post updated.” / “Page updated.”
  );
  $xuui_type_args=array(
    //'label'=>$xuui_type_labels['name'],
    'labels'=>$xuui_type_labels,
    'description'=>'xuui_type demo',
    'public'=>true,
    'hierarchical'=>false, // true:类似 Pages 的层级
    'exclude_from_search'=>true,
    'publicly_queryable'=>true,
    'show_ui'=>true,
    'show_in_menu'=>true,
    'show_in_nav_menus'=>true,
    'show_in_admin_bar'=>true,
    'show_in_rest'=>true,
    //'rest_base'=>'xuui',//api
    //'rest_controller_class'=>'xuuiapi',//api
    'menu_position'=>6,
    'menu_icon'=>'dashicons-portfolio',
    'capability_type'=>'post',
    //'capabilities'=>'edit_post',// 权限
    //'map_meta_cap'=>null,// 角色
    'supports'=>array('title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'),
    //'has_archive'=>false,
    'has_archive'=>true,
    //'rewrite'=>true,
    'rewrite'=>array('slug'=>'xuui_slug','with_front'=>true,'feeds'=>false,'pages'=>true,
      //'ep_mask'=>'EP_ALL_ARCHIVES',
    ),
    //'permalink_epmask'=>EP_ALL_ARCHIVES,
    'query_var'=>true,
    'can_export'=>true,
    //'register_meta_box_cb'=>add_meta_box(),
    //'taxonomies'=> register_taxonomy_for_object_type()register_taxonomy(),
  );
  register_post_type('xuui_type',$xuui_type_args);
  */

  //SlideShow.
  $slideImage_labels=array('name'=>__('Show images','xuui'),'singular_name'=>__('Show image','xuui'),'add_new'=>__('Add Images','xuui'),'add_new_item'=>__('Add New Images','xuui'),'edit_item'=>__('Edit Image','xuui'),'new_item'=>__('Add Show image','xuui'),'view_item'=>__('View Image','xuui'),'search_items'=>__('Search Show images','xuui'),'not_found'=>__('No images found','xuui'),'not_found_in_trash'=>__('No images found in Trash','xuui'),'parent_item_colon'=>'');
  $slideImage_Aargs=array('labels'=>$slideImage_labels,'public'=>true,'publicly_queryable'=>true,'show_ui'=>true,'query_var'=>true,'has_archive'=>true,'rewrite'=>array('slug'=>'slide','with_front'=>true,'pages'=>true),'capability_type'=>'post','hierarchical'=>false,'menu_position'=>2,'menu_icon'=>'dashicons-slides','supports'=>array('title','thumbnail'));
  register_post_type('slideshow',$slideImage_Aargs);// SlideShow.end.

  //Project.
  $Project_labels=array('name'=>__('Project','xuui'),'singular_name'=>__('Project','xuui'),'add_new'=>__('Add Project','xuui'),'add_new_item'=>__('Add New Project','xuui'),'edit_item'=>__('Edit Project','xuui'),'new_item'=>__('Add Project','xuui'),'view_item'=>__('View Project','xuui'),'search_items'=>__('Search Project','xuui'),'not_found'=>__('No Project found','xuui'),'not_found_in_trash'=>__('No Project found in Trash','xuui'),'parent_item_colon'=>'');
  $Project_Aargs=array('labels'=>$Project_labels,'public'=>true,'publicly_queryable'=>true,'show_ui'=>true,'query_var'=>true,'has_archive'=>true,'rewrite'=>array('slug'=>'project','with_front'=>true,'pages'=>true),'capability_type'=>'post','hierarchical'=>false,'menu_position'=>7,'menu_icon'=>'dashicons-album','supports'=>array('title','editor','thumbnail'));//,'custom-fields'
  register_post_type('project',$Project_Aargs);

  register_taxonomy('projects','project',array(
    'labels'=>array(
      'name'=>__('Project Category','xuui'),
      'menu_name'=>__('Project Categories','xuui'),
      'singular_name'=>__('Project','xuui'),
      'search_items'=>__('Search Categories','xuui'),
      'popular_items'=>__('Popular Categories','xuui'),
      'all_items'=>__('All Categories','xuui'),
      'parent_item'=>__('Parent Category','xuui'),
      'parent_item_colon'=>__('Parent Category：','xuui'),
      'edit_item'=>__('Edit Category','xuui'),
      'update_item'=>__('Update Categories','xuui'),
      'add_new_item'=>__('Add New Project Category','xuui'),
      'new_item_name'=>__('Category Name','xuui'),
      'add_or_remove_items'=>__('Add or remove categories','xuui'),
      'choose_from_most_used'=>__('Choose from most used categories','xuui'),
    ),
    'public'=>true,'show_in_nav_menus'=>true,'hierarchical'=>true,'show_ui'=>true,'query_var'=>true,'rewrite'=>array('slug'=>'projects'),'show_admin_column'=>true
  ));// Project.end.

}
add_action('init','xuui_postType');

// Slide Image metabox.
$slideImage_meta=array(
  //"heading"=>array("name"=>"heading","std"=>"这里填图片的标题","title"=>"标题:"),
  "intro"=>array("name"=>"intro","std"=>"这里填图片的简介，30字以内","title"=>"简介:"),
  "link"=>array("name"=>"urlink","std"=>"http:///","title"=>"链接:"),
  "align"=>array("name"=>"align","std"=>"默认左对齐","title"=>"文字对其:")
);
function xuui_slideImage_meta(){
  global $post,$slideImage_meta;
  foreach($slideImage_meta as $meta_box){
    $meta_box_value=get_post_meta($post->ID,$meta_box['name'],true);
    echo '<p>'.$meta_box['title'].'</p>';
    if($meta_box['name']=='align'){
      if($meta_box_value=='left' || $meta_box_value==''){
        $salign_l='<label><input type="radio" name="align" id="salign_l" value="left" checked />左</label>';
      }else{
        $salign_l='<label><input type="radio" name="align" id="salign_l" value="left" />左</label>';
      }
      if($meta_box_value=='center'){
        $salign_c='<label><input type="radio" name="align" id="salign_c" value="center" checked />中</label>';
      }else{
        $salign_c='<label><input type="radio" name="align" id="salign_c" value="center" />中</label>';
      }
      if($meta_box_value=='right'){
        $salign_r='<label><input type="radio" name="align" id="salign_r" value="right" checked />右</label>';
      }else{
        $salign_r='<label><input type="radio" name="align" id="salign_r" value="right" />右</label>';
      }
      echo '<p>'.$salign_l.' '.$salign_c.' '.$salign_r.'</p>';
    }else{
      echo '<input type="text" name="'.$meta_box['name'].'" value="'.$meta_box_value.'" class="regular-text ltr" placeholder="'.$meta_box['std'].'">';
    }
  }
  echo '<input type="hidden" name="xuui_slideImage_nonce" id="xuui_slideImage_nonce" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
}
function xuui_slideImage_saveData($post_id){
  global $slideImage_meta;
  if(!wp_verify_nonce(@$_POST['xuui_slideImage_nonce'],plugin_basename(__FILE__))){return;}
  if(!current_user_can('edit_posts',$post_id)){return;}
  foreach($slideImage_meta as $meta_box){
    $data=@$_POST[$meta_box['name']];
    if($data==""){
      delete_post_meta($post_id,$meta_box['name'],get_post_meta($post_id,$meta_box['name'],true));
    }else{
      update_post_meta($post_id,$meta_box['name'],$data);
    }
  }
}
function xuui_slideImage_metabox(){
  if(function_exists('add_meta_box')){
    add_meta_box('slideImage_meta','轮播文字','xuui_slideImage_meta','slideshow','normal','high');
  }
}
add_action('admin_menu','xuui_slideImage_metabox');
add_action('save_post','xuui_slideImage_saveData');

// Slide Video metabox.
$slideVideo_meta=array(
  "video"=>array("name"=>"video","std"=>"http://xxx/xxx.mp4","title"=>"视频地址:"),
  //"videocol"=>array("name"=>"videocol","std"=>"http://xxx/xxx.mp4","title"=>"视频地址:"),
);
function xuui_slideVideo_meta(){
  global $post,$slideVideo_meta;
  foreach($slideVideo_meta as $meta_box){
    $meta_box_value=get_post_meta($post->ID,$meta_box['name'],true);
    echo '<p>'.$meta_box['title'].'</p>';
    echo '<input type="text" name="'.$meta_box['name'].'" value="'.$meta_box_value.'" class="regular-text ltr" placeholder="'.$meta_box['std'].'">';
  }
  echo '<input type="hidden" name="xuui_slideVideo_nonce" id="xuui_slideVideo_nonce" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
}
function xuui_slideVideo_saveData($post_id){
  global $slideVideo_meta;
  if(!wp_verify_nonce(@$_POST['xuui_slideVideo_nonce'],plugin_basename(__FILE__))){return;}
  if(!current_user_can('edit_posts',$post_id)){return;}
  foreach($slideVideo_meta as $meta_box){
    $data=@$_POST[$meta_box['name']];
    if($data==""){
      delete_post_meta($post_id,$meta_box['name'],get_post_meta($post_id,$meta_box['name'],true));
    }else{
      update_post_meta($post_id,$meta_box['name'],$data);
    }
  }
}
function xuui_slideVideo_metabox() {
  if(function_exists('add_meta_box')){
    add_meta_box('slideVideo_meta','轮播视频','xuui_slideVideo_meta','slideshow','normal','high');
  }
}
add_action('admin_menu','xuui_slideVideo_metabox');
add_action('save_post','xuui_slideVideo_saveData');

// Project Video metabox.
$projectVideo_meta=array(
  "video"=>array("name"=>"video","std"=>"http://xxx/xxx.mp4","title"=>"请填入项目的视频文件地址:"),
  "videoimg"=>array("name"=>"videoimg","std"=>"http://xxx/xxx.jpg","title"=>"请填入项目的视频的预览图地址:"),
);
function xuui_projectVideo_meta(){
  global $post,$projectVideo_meta;
  foreach($projectVideo_meta as $meta_box){
    $meta_box_value=get_post_meta($post->ID,$meta_box['name'],true);
    echo '<p>'.$meta_box['title'].'</p>';
    echo '<input type="text" name="'.$meta_box['name'].'" value="'.$meta_box_value.'" class="regular-text ltr" placeholder="'.$meta_box['std'].'">';
  }
  echo '<input type="hidden" name="xuui_projectVideo_nonce" id="xuui_projectVideo_nonce" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
}
function xuui_projectVideo_saveData($post_id){
  global $projectVideo_meta;
  if(!wp_verify_nonce(@$_POST['xuui_projectVideo_nonce'],plugin_basename(__FILE__))){return;}
  if(!current_user_can('edit_posts',$post_id)){return;}
  foreach($projectVideo_meta as $meta_box){
    $data=@$_POST[$meta_box['name']];
    if($data==""){
      delete_post_meta($post_id,$meta_box['name'],get_post_meta($post_id,$meta_box['name'],true));
    }else{
      update_post_meta($post_id,$meta_box['name'],$data);
    }
  }
}
function xuui_projectVideo_metabox() {
  if(function_exists('add_meta_box')){
    add_meta_box('projectVideo_meta','轮播视频','xuui_projectVideo_meta','project','normal','high');
  }
}
add_action('admin_menu','xuui_projectVideo_metabox');
add_action('save_post','xuui_projectVideo_saveData');


/**
 * Add rewrite rules.
 */
$xuui_types=array(
  'slideshow'=>'slideshow',
  'project'=>'project'
);
add_filter('post_type_link','xuui_postType_link',1,3);
function xuui_postType_link( $link, $post = 0 ){
  global $xuui_types;
  if(in_array($post->post_type,array_keys($xuui_types))){
    return home_url($xuui_types[$post->post_type].'/'.$post->ID.'.html');
  }else{
    return $link;
  }
}
add_action('init','xuui_postType_rewritesInit');
function xuui_postType_rewritesInit(){
  global $xuui_types;
  foreach($xuui_types as $type=>$slug){
    add_rewrite_rule($slug.'/([0-9]+)?.html$','index.php?post_type='.$type.'&p=$matches[1]','top');
    add_rewrite_rule($slug.'/([0-9]+)?.html/comment-page-([0-9]{1,})$','index.php?post_type='.$type.'&p=$matches[1]&cpage=$matches[2]','top');
  }
}