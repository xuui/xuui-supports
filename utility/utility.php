<?php
/**
 * @package xuui-supports
 * @version 1.0
 */
/* Wordpress 实用功能增强. */
require_once(XUUI_PLUGIN_DIR.'utility/utility-function.php');

// Add Link Manager.
add_filter('pre_option_link_manager_enabled','__return_true');

// 隐藏登录失败未知用户名和密码不正确的错误信息.
add_filter('wp_login_errors',function($errors){
  $error_code=$errors->get_error_code();
  if(in_array($error_code,['invalid_username','invalid_email','incorrect_password'])){
  $errors->remove($error_code);
    $errors->add($error_code,'用户名或者密码错误。');
  }
  return $errors;
});

// 禁止使用 admin 用户名尝试登录.
function wpjam_no_admin_user($user){if($user=='admin'){exit;}}
function wpjam_sanitize_user_no_admin($username,$raw_username,$strict){
	if($raw_username=='admin' || $username=='admin'){exit;}
	return $username;
}
add_filter('wp_authenticate','wpjam_no_admin_user');
add_filter('sanitize_user','wpjam_sanitize_user_no_admin',10,3);

// 防止暴露用户名.
add_filter('author_link',function($link,$author_id,$author_nicename){
  $author=get_userdata($author_id);
  if(sanitize_title($author->user_login)==$author_nicename){
    global $wp_rewrite;
    $link=$wp_rewrite->get_author_permastruct();
    $link=str_replace('%author%', $author_id, $link);
    $link=home_url(user_trailingslashit($link));
  }
  return $link;
},10,3);
add_action('pre_get_posts',function($wp_query){
  if($wp_query->is_main_query()&& $wp_query->is_author()){
    if($author_name=$wp_query->get('author_name')){
      $author_name=sanitize_title_for_query($author_name);
      $author=get_user_by('slug',$author_name);
      if($author){if(sanitize_title($author->user_login)==$author->user_nicename){
          $wp_query->set_404();
      }}else{
        if(is_numeric($author_name)){
          $wp_query->set('author_name','');
          $wp_query->set('author',$author_name);
        }
      }
    }
  }
});
add_filter('body_class',function($classes){
  if(is_author()){
    global $wp_query;
    $author=$wp_query->get_queried_object();
    if(sanitize_title($author->user_login)==$author->user_nicename){
      $author_class='author-'.sanitize_html_class($author->user_nicename,$author->ID);
      $classes=array_diff($classes,[$author_class]);
    }
  }
  return $classes;
});
add_filter('comment_class',function($classes){
  foreach($classes as $key=>$class){
    if(strstr($class,'comment-author-')){unset($classes[$key]);}
  }
  return $classes;
});

// 自动隐藏邮件地址防止垃圾邮件.
add_filter('the_content','wpjam_hide_emails',99);
add_filter('widget_text','wpjam_hide_emails',99);
function wpjam_hide_emails($content){
	$pattern='/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})/i';
	return preg_replace_callback($pattern,"wpjam_hide_emails_callback",$content);
}
function wpjam_hide_emails_callback($match) {
	return antispambot($match[1]);
}

// 防止博客内容中的 Email 地址被收集.
function wpjam_email_shortcode_handler($atts,$content=''){
    extract(shortcode_atts(array('mailto'=>'0'),$atts));
    return antispambot($content,$mailto);
}
add_shortcode('email','wpjam_email_shortcode_handler');

// 管理员快速登录其他用户账户
add_filter('user_row_actions',function($actions,$user){
  $capability=(is_multisite())?'manage_site':'manage_options';
  if(current_user_can($capability)){$actions['login_as']='<a title="以此身份登陆" href="'.wp_nonce_url("users.php?action=login_as&users=$user->ID",'bulk-users').'">以此身份登陆</a>';}
  return $actions;
},10,2);
add_filter('handle_bulk_actions-users',function($sendback,$action,$user_ids){
  if($action=='login_as'){wp_set_auth_cookie($user_ids,true);wp_set_current_user($user_ids);}
  return admin_url();
},10,3);

// 用户注册时候不能含有非法关键字.
function wpjam_blacklist_check($str){
  $moderation_keys=trim(get_option('moderation_keys'));
  $blacklist_keys=trim(get_option('blacklist_keys'));
  $keys=$moderation_keys."\n".$blacklist_keys;
  $words=explode("\n",$keys);
  foreach((array)$words as $word){
      $word=trim($word);
      if(empty($word)){continue;}
      $word=preg_quote($word,'#');
      $pattern="#$word#i";
      if(preg_match($pattern,$str))return true;
  }
  return false;
}


// 后台文章列表搜索支持 ID.
add_filter('posts_clauses',function($clauses,$wp_query){
  if($wp_query->is_main_query() && $wp_query->is_search()){
    global $wpdb;
    $search_term=$wp_query->query['s'];
    if(is_numeric($search_term)){
      $clauses['where']=str_replace('('.$wpdb->posts.'.post_title LIKE','('.$wpdb->posts.'.ID='.$search_term.') OR ('.$wpdb->posts.'.post_title LIKE', $clauses['where']);
    }elseif(preg_match("/^(d+)(,s*d+)*$/", $search_term)){
      $clauses['where']=str_replace('('.$wpdb->posts.'.post_title LIKE','('.$wpdb->posts.'.ID in ('.$search_term.')) OR ('.$wpdb->posts.'.post_title LIKE', $clauses['where']);
    }
  }
  return $clauses;
},2,2);

// 后台文章列表添加作者筛选
add_action('restrict_manage_posts',function($post_type){
  if(post_type_supports($post_type,'author')){wp_dropdown_users([
    'name'=>'author','who'=>'authors',
    'show_option_all'=>'所有作者',
    'hide_if_only_one_author'=>true,
    'selected'=>$_REQUEST['author']?? 0
  ]);}
});

// 后台文章列表添加排序选项
add_action('restrict_manage_posts',function($post_type){
  global $wp_list_table;
  list($columns,$hidden,$sortable_columns,$primary)=$wp_list_table->get_column_info();
  foreach($sortable_columns as $sortable_column=>$data){
    if(isset($columns[$sortable_column])){
      $orderby_options[$sortable_column]=$columns[$sortable_column];
    }
  }
  echo xuui_get_field_html([
    'title'=>'',
    'key'=>'orderby',
    'type'=>'select',
    'value'=>$_REQUEST['orderby'] ?? '',
    'options'=>$orderby_options
  ]);
  echo xuui_get_field_html([
    'title'=>'',
    'key'=>'order',
    'type'=>'select',
    'value'=>$_REQUEST['order'] ?? 'DESC',
    'options'=>['desc'=>'降序','asc'=>'升序']
  ]);
});

// 后台文章列表添加自定义分类筛选
add_action('restrict_manage_posts',function($post_type){
  if($taxonomies=get_object_taxonomies($post_type,'objects')){
    foreach($taxonomies as $taxonomy){
      if(empty($taxonomy->hierarchical) || empty($taxonomy->show_admin_column)){continue;}
      if($taxonomy->name=='category'){$taxonomy_key='cat';}else{$taxonomy_key=$taxonomy->name.'_id';}
      $selected=0;
      if(!empty($_REQUEST[$taxonomy_key])){
        $selected=$_REQUEST[$taxonomy_key];
      }elseif(!empty($_REQUEST['taxonomy']) && ($_REQUEST['taxonomy']==$taxonomy->name) && !empty($_REQUEST['term'])){
        if($term=get_term_by('slug', $_REQUEST['term'], $taxonomy->name)){$selected=$term->term_id;}
      }elseif(!empty($taxonomy->query_var) && !empty($_REQUEST[$taxonomy->query_var])){
        if($term=get_term_by('slug', $_REQUEST[$taxonomy->query_var], $taxonomy->name)){$selected=$term->term_id;}
      }
      wp_dropdown_categories(array(
        'taxonomy'=>$taxonomy->name,'show_option_all'=>$taxonomy->labels->all_items,
        'show_option_none'=>'没有设置',
        'hide_if_empty'=>true,'hide_empty'=>0,'hierarchical'=>1,'show_count'=>0,'orderby'=>'name','name'=>$taxonomy_key,'selected'=>$selected
      ));
    }
  }
});

// 屏蔽 DEMO 账号修改密码: ID=50.
function wpjam_disable_demo_show_password_fields($status,$profileuser){
	if($profileuser->ID==50){return false;}
	return $status;
}
add_filter('show_password_fields','wpjam_disable_demo_show_password_fields',10,2);

// 搜索结果只有一篇时直接跳转到文章页面.
function wpjam_redirect_single_post(){
  if(is_search()){
    global $wp_query;
    if ($wp_query->post_count==1){
      wp_redirect(get_permalink($wp_query->posts['0']->ID));
    }
  }
}
add_action('template_redirect','wpjam_redirect_single_post');

// 优先执行 Shortcode，移除 Shortcode 中自动添加的 br 和 p 标签
remove_filter('the_content','wpautop');
add_filter('the_content','wpautop',12);
function bio_shortcode($atts,$content=null){
  $content = wpautop(trim($content));
  return '<div class="bio">'.$content.'</div>';
}
add_shortcode('bio','bio_shortcode');


// WordPress MU 分类上限为：20.
/*
add_filter('pre_insert_term',function($term,$taxonomy){
  if($taxonomy=='product_category'){
    if(wp_count_terms($taxonomy)>20){// max:20
      return new WP_Error('too_much_product_category','分类上限为：20。');
    }
  }
  return $term;
},10,2);

// WordPress MU 限制文章数量
add_action('current_screen',function($current_screen){
  global $pagenow;
  if($pagenow=='post-new.php'){
    $post_type=$current_screen->post_type;
    if($post_type=='product'){// 这里可以改成你需要限制的日志类型
      $counts=wp_count_posts($post_type);
      $total=array_sum((array)$counts);
      if($total>5000){wp_die('商品上限为：5000。');}
    }
  }
});
*/

// 正确获取文章摘要: theme usr "get_post_excerpt(post-ID,255)".
function get_post_excerpt($post,$excerpt_length=240){
  if(!$post)$post=get_post();
  $post_excerpt=$post->post_excerpt;
  if($post_excerpt==''){
    $post_content=$post->post_content;
    $post_content=do_shortcode($post_content);
    $post_content=wp_strip_all_tags($post_content);
    $post_excerpt=mb_strimwidth($post_content,0,$excerpt_length,'…','utf-8');
  }
  $post_excerpt=wp_strip_all_tags($post_excerpt);
  $post_excerpt=trim(preg_replace("/[\n\r\t ]+/",' ',$post_excerpt),' ');
  return $post_excerpt;
}

/* 给管理员显示 PHP 错误. 
if(current_user_can('manage_options')){
  define('WP_DEBUG_DISPLAY',true);
  @ini_set('display_errors',1);
}
*/

/* 屏蔽 DEMO 账号修改密码. DEMO 账号ID=50.
add_filter('show_password_fields',function($status,$profileuser){
  if($profileuser->ID==50){return false;}
  return $status;
},10,2);
*/

// 支持上传 SVG 图片.
add_filter('upload_mimes',function($mimes=array()){$mimes['svg']='image/svg+xml';return $mimes;});

/*
// 给后台特色图片加上大小说明.
add_filter('admin_post_thumbnail_html', 'xuui_admin_post_thumbnail_html',10,2);
function xuui_admin_post_thumbnail_html($content,$post_id){
  $post=get_post($post_id);
  $post_type=$post->post_type;
  if($post_type=='post'){
    return $content.'大小：390x200';
  }
  return $content;
}

// 在后台显示 ID.
/*
add_filter('manage_posts_columns','xuui_id_manage_posts_columns');
add_action('manage_posts_custom_column','xuui_id_manage_posts_custom_column',10,2);
function xuui_id_manage_posts_columns($columns){
  $columns['post_id']='ID';
  return $columns;
}
function xuui_id_manage_posts_custom_column($column_name,$id){
  if (@$column_name=='post_id'){
    echo $id;
  }
}
*/

// 按照用户注册时间排序.
/*
add_filter('manage_users_columns','xuui_add_users_column_reg_time');
add_filter('manage_users_custom_column','xuui_show_users_column_reg_time',11,3);
add_filter('manage_users_sortable_columns','xuui_users_sortable_columns');
add_action('pre_user_query','xuui_users_search_order');
function xuui_add_users_column_reg_time($column_headers){
  $column_headers['reg_time']='注册时间';
  return $column_headers;
}
function xuui_show_users_column_reg_time($value,$column_name,$user_id){
  if($column_name=='reg_time'){
    $user=get_userdata($user_id);
    return get_date_from_gmt($user->user_registered);
  }else{
    return $value;
  }
}
function xuui_users_sortable_columns($sortable_columns){
  $sortable_columns['reg_time']='reg_time';
  return $sortable_columns;
}
function xuui_users_search_order($obj){
  if(!isset($_REQUEST['orderby']) || $_REQUEST['orderby']=='reg_time'){
    if(!in_array(@$_REQUEST['order'],array('asc','desc'))){$_REQUEST['order']='desc';}
    $obj->query_orderby="ORDER BY user_registered ".$_REQUEST['order']."";
  }
}

// Block Bad Queries.
if(strlen($_SERVER['REQUEST_URI'])>255 || strpos($_SERVER['REQUEST_URI'],"eval(") || strpos($_SERVER['REQUEST_URI'],"base64")){
  @header("HTTP/1.1 414 Request-URI Too Long");
  @header("Status: 414 Request-URI Too Long");
  @header("Connection: Close");
  @exit;
}

// 在后台插入图片时候，尺寸选择框只保留完整尺寸格式.
add_filter('image_size_names_choose',function($image_sizes){
  unset($image_sizes['thumbnail']);
  unset($image_sizes['medium']);
  unset($image_sizes['large']);
  return $image_sizes;
});

// 防止上传的图片重名，加上时间戳.
add_filter('wp_handle_upload_prefilter',function($file){
  if(strlen($file['name'])<=7){$file['name']=time().'-'.$file['name'];}
  return $file;
});

// 简化 WordPress 后台用户名称设置.
//隐藏 姓，名 和 显示的名称，三个字段
add_action('show_user_profile','xuui_edit_user_profile');
add_action('edit_user_profile','xuui_edit_user_profile');
function xuui_edit_user_profile($user){?>
<script>
jQuery(document).ready(function($){
  $('#first_name').parent().parent().hide();
  $('#last_name').parent().parent().hide();
  $('#display_name').parent().parent().hide();
  $('.show-admin-bar').hide();
});
</script>
<?php }
//更新时候，强制设置显示名称为昵称
add_action('personal_options_update','xuui_edit_user_profile_update');
add_action('edit_user_profile_update','xuui_edit_user_profile_update');
function xuui_edit_user_profile_update($user_id){
  if(!current_user_can('edit_user',$user_id)){return false;}
  $user=get_userdata($user_id);
  $_POST['nickname']=($_POST['nickname'])?:$user->user_login;
  $_POST['display_name']=$_POST['nickname'];
  $_POST['first_name']='';
  $_POST['last_name']='';
}

// 让搜索支持自定义字段. ?s=product_id
add_action('posts_search',function($search,$query){
  global $wpdb;
  if($query->is_main_query() && !empty($query->query['s'])){
    $sql=" OR EXISTS (SELECT * FROM {$wpdb->postmeta} WHERE post_id={$wpdb->posts}.ID and meta_key='product_id' and meta_value like %s)";
    $like='%'.$wpdb->esc_like($query->query['s']).'%';
    $search.=$wpdb->prepare($sql,$like);
  }
  return $search;
},2,2);

//禁止使用 admin 用户名尝试登录
//add_filter('wp_authenticate','xuui_no_admin_user');
function xuui_no_admin_user($user){
  if($user=='admin'){exit;}
}
//add_filter('sanitize_user','xuui_sanitize_user_no_admin',10,3);
function xuui_sanitize_user_no_admin($username,$raw_username,$strict){
  if($raw_username=='admin' || $username=='admin'){exit;}
  return $username;
}

//管理员快速登录其他用户账户
add_filter('user_row_actions',function($actions,$user){
  $capability=(is_multisite())?'manage_site':'manage_options';
  if(current_user_can($capability)){
    $actions['login_as']='<a title="以此身份登陆" href="'.wp_nonce_url("users.php?action=login_as&users=$user->ID", 'bulk-users').'">以此身份登陆</a>';
  }
  return $actions;
},10,2);
add_filter('handle_bulk_actions-users',function($sendback,$action,$user_ids){
  if($action=='login_as'){
    wp_set_auth_cookie($user_ids,true);
    wp_set_current_user($user_ids);
  }
  return admin_url();
},10,3);

//移除 WordPress 后台的主题编辑器
/*
function xuui_remove_editor_menu(){
  remove_action('admin_menu','_add_themes_utility_last',101);
}
add_action('_admin_menu','xuui_remove_editor_menu',1);
*/
