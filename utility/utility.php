<?php
/**
 * @package xuui-supports
 * @version 1.0
 */
/* Wordpress 实用功能增强. */

// Add Link Manager.
add_filter('pre_option_link_manager_enabled','__return_true');

// WordPress MU 分类上限为：20.
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

// 支持上传 SVG 图片.
add_filter('upload_mimes',function($mimes=array()){
  $mimes['svg']='image/svg+xml';
  return $mimes;
});

// 替换 Gravatar 头像的服务器地址.
add_filter('get_avatar',function($avatar){
	//~ 替换为 https 的域名
	$avatar=str_replace(array("www.gravatar.com","0.gravatar.com","1.gravatar.com","2.gravatar.com"),"secure.gravatar.com", $avatar);
	//~ 替换为 https 协议
	$avatar=str_replace("http://","https://",$avatar);
	return $avatar;
});

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
add_filter('manage_posts_columns', 'xuui_id_manage_posts_columns');
add_filter('manage_pages_columns', 'xuui_id_manage_posts_columns');
add_action('manage_posts_custom_column','xuui_id_manage_posts_custom_column',10,2);
add_action('manage_pages_custom_column','xuui_id_manage_posts_custom_column',10,2);
function xuui_id_manage_posts_columns($columns){
  $columns['post_id']='ID';
  return $columns;
}
function xuui_id_manage_posts_custom_column($column_name,$id){
  if ($column_nam =='post_id'){
      echo $id;
  }
}

// 给管理员显示 PHP 错误.
//if(current_user_can('manage_options')){
//  define('WP_DEBUG_DISPLAY',true);
//  @ini_set('display_errors',1);
//}

// 按照用户注册时间排序.
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
	if(!isset($_REQUEST['orderby']) || $_REQUEST['orderby']=='reg_time' ){
		if( !in_array($_REQUEST['order'],array('asc','desc')) ){
			$_REQUEST['order']='desc';
		}
		$obj->query_orderby ="ORDER BY user_registered ".$_REQUEST['order']."";
	}
}

// Block Bad Queries.
if(strlen($_SERVER['REQUEST_URI'])>255 ||
	strpos($_SERVER['REQUEST_URI'],"eval(") ||
	strpos($_SERVER['REQUEST_URI'],"base64")){
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

?>