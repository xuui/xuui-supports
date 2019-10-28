<?php /** Post Type */
function xuui_post_type(){
  //SlideShow.
  $Show_Image_labels=array('name'=>__('Show images','xuui'),'singular_name'=>__('Show image','xuui'),'add_new'=>__('Add Images','xuui'),'add_new_item'=>__('Add New Images','xuui'),'edit_item'=>__('Edit Image','xuui'),'new_item'=>__('Add Show image','xuui'),'view_item'=>__('View Image','xuui'),'search_items'=>__('Search Show images','xuui'),'not_found'=>__('No images found','xuui'),'not_found_in_trash'=>__('No images found in Trash','xuui'),'parent_item_colon'=>'');
  $Show_Image_Aargs=array('labels'=>$Show_Image_labels,'public'=>true,'publicly_queryable'=>true,'show_ui'=>true,'query_var'=>true,'rewrite'=>true,'capability_type'=>'post','hierarchical'=>false,'menu_position'=>2,'menu_icon'=>'dashicons-slides','supports'=>array('title','thumbnail'));
  register_post_type('slideshow',$Show_Image_Aargs);// SlideShow.end.

  //Project.
  $Project_labels=array('name'=>__('Project','xuui'),'singular_name'=>__('Project','xuui'),'add_new'=>__('Add Project','xuui'),'add_new_item'=>__('Add New Project','xuui'),'edit_item'=>__('Edit Project','xuui'),'new_item'=>__('Add Project','xuui'),'view_item'=>__('View Project','xuui'),'search_items'=>__('Search Project','xuui'),'not_found'=>__('No Project found','xuui'),'not_found_in_trash'=>__('No Project found in Trash','xuui'),'parent_item_colon'=>'');
  $Project_Aargs=array('labels'=>$Project_labels,'public'=>true,'publicly_queryable'=>true,'show_ui'=>true,'query_var'=>true,'rewrite'=>true,'capability_type'=>'post','hierarchical'=>false,'menu_position'=>7,'menu_icon'=>'dashicons-album','supports'=>array('title','editor','thumbnail'));//,'custom-fields'
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

// Slide Image metabox.
$slide_image_meta=array(
  //"heading"=>array("name"=>"heading","std"=>"这里填图片的标题","title"=>"标题:"),
  "intro"=>array("name"=>"intro","std"=>"这里填图片的简介，30字以内","title"=>"简介:"),
  "link"=>array("name"=>"urlink","std"=>"http:///","title"=>"链接:"),
  "align"=>array("name"=>"align","std"=>"默认左对齐","title"=>"文字对其:")
);
function slide_image_meta(){
  global $post,$slide_image_meta;
  foreach($slide_image_meta as $meta_box){
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
  echo '<input type="hidden" name="xuui_slide_image_nonce" id="xuui_slide_image_nonce" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
}
function slide_image_save_postdata($post_id){
  global $slide_image_meta;
  if(!wp_verify_nonce(@$_POST['xuui_slide_image_nonce'],plugin_basename(__FILE__))){return;}
  if(!current_user_can('edit_posts',$post_id)){return;}
  foreach($slide_image_meta as $meta_box){
    $data=$_POST[$meta_box['name']];
    if($data==""){
      delete_post_meta($post_id,$meta_box['name'],get_post_meta($post_id,$meta_box['name'],true));
    }else{
      update_post_meta($post_id,$meta_box['name'],$data);
    }
  }
}
function slide_image_metabox(){
  if(function_exists('add_meta_box')){
    add_meta_box('slide_image_meta','轮播文字','slide_image_meta','slideshow','normal','high');
//    add_meta_box('slide_video_meta','轮播视频','slide_video_meta','slideshow','normal','high');
  }
}
add_action('admin_menu','slide_image_metabox');
add_action('save_post','slide_image_save_postdata');


// Slide Video metabox.
$slide_video_meta=array(
  "video"=>array("name"=>"video","std"=>"http://xxx/xxx.mp4","title"=>"视频地址:"),
  //"videocol"=>array("name"=>"videocol","std"=>"http://xxx/xxx.mp4","title"=>"视频地址:"),
);
function slide_video_meta(){
  global $post,$slide_video_meta;
  foreach($slide_video_meta as $meta_box){
    $meta_box_value=get_post_meta($post->ID,$meta_box['name'],true);
    echo '<p>'.$meta_box['title'].'</p>';
    echo '<input type="text" name="'.$meta_box['name'].'" value="'.$meta_box_value.'" class="regular-text ltr" placeholder="'.$meta_box['std'].'">';
  }
  echo '<input type="hidden" name="xuui_slide_video_nonce" id="xuui_slide_video_nonce" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
}
function slide_video_save_postdata($post_id){
  global $slide_video_meta;
  if(!wp_verify_nonce(@$_POST['xuui_slide_video_nonce'],plugin_basename(__FILE__))){return;}
  if(!current_user_can('edit_posts',$post_id)){return;}
  foreach($slide_video_meta as $meta_box){
    $data=$_POST[$meta_box['name']];
    if($data==""){
      delete_post_meta($post_id,$meta_box['name'],get_post_meta($post_id,$meta_box['name'],true));
    }else{
      update_post_meta($post_id,$meta_box['name'],$data);
    }
  }
}
function slide_video_metabox() {
  if(function_exists('add_meta_box')){
    add_meta_box('slide_video_meta','轮播视频','slide_video_meta','slideshow','normal','high');
  }
}
add_action('admin_menu','slide_video_metabox');
add_action('save_post','slide_video_save_postdata');


// Project Video metabox.
$project_video_meta=array(
  "video"=>array("name"=>"video","std"=>"http://xxx/xxx.mp4","title"=>"请填入作品的视频文件地址:"),
);
function project_video_meta(){
  global $post,$project_video_meta;
  foreach($project_video_meta as $meta_box){
    $meta_box_value=get_post_meta($post->ID,$meta_box['name'],true);
    echo '<p>'.$meta_box['title'].'</p>';
    echo '<input type="text" name="'.$meta_box['name'].'" value="'.$meta_box_value.'" class="regular-text ltr" placeholder="'.$meta_box['std'].'">';
  }
  echo '<input type="hidden" name="xuui_slide_video_nonce" id="xuui_slide_video_nonce" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
}
function project_video_save_postdata($post_id){
  global $project_video_meta;
  if(!wp_verify_nonce(@$_POST['xuui_slide_video_nonce'],plugin_basename(__FILE__))){return;}
  if(!current_user_can('edit_posts',$post_id)){return;}
  foreach($project_video_meta as $meta_box){
    $data=$_POST[$meta_box['name']];
    if($data==""){
      delete_post_meta($post_id,$meta_box['name'],get_post_meta($post_id,$meta_box['name'],true));
    }else{
      update_post_meta($post_id,$meta_box['name'],$data);
    }
  }
}
function project_video_metabox() {
  if(function_exists('add_meta_box')){
    add_meta_box('project_video_meta','轮播视频','project_video_meta','project','normal','high');
  }
}
add_action('admin_menu','project_video_metabox');
add_action('save_post','project_video_save_postdata');

