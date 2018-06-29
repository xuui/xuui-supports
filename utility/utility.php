<?php
/**
 * @package xuui-supports
 * @version 1.0
 */

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

?>