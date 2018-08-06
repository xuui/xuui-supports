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

?>