<?php
/**
 * @package xuui-supports
 * @version 1.0
 */
/* Wordpress 实用功能增强. */

function xuui_parse_field($field,$sub=false){
  $field['key']=isset($field['key'])?$field['key']:'';
  $field['name']=isset($field['name'])?$field['name']:$field['key'];
  $field['type']=isset($field['type'])?$field['type']:'text';
  $field['value']=isset($field['value'])?$field['value']:'';
  if(is_admin() && $field['type']=='file'){$field['type']='image';}
  if($field['type']=='mulit_image' || $field['type']=='multi_image' || $field['type']=='mulit-image' || $field['type']=='mulit-image'){
    $field['type']='mu-image';
  }elseif($field['type']=='mulit_text' || $field['type']=='multi_text' || $field['type']=='mulit-text' || $field['type']=='multi-text'){
    $field['type']='mu-text';
  }elseif($field['type']=='br' ){
    $field['type']='view';
  }
  $default_classes=array('textarea'=>'large-text','checkbox'=>'','radio'=>'','file'=>'','select'=>'','color'=>'');
  $class=isset($field['class'])?$field['class']:(isset($default_classes[$field['type']])?$default_classes[$field['type']]:'regular-text');
  $field['class']='type-'.$field['type'].' '.$class ;
  $field['description']=isset($field['description'])?$field['description']:'';
  if($field['description']){
    if($field['type']=='view' || $field['type']=='hr'){$field['description']='';
    }elseif($field['type']=='checkbox'){$field['description']=' <label for="'.$field['key'].'">'.$field['description'].'</label>';  
    }else{
      if($sub===false){$field['description']='<p>'.$field['description'].'</p>';}
    }
  }
  $datalist='';
  if(isset($field['list']) && !empty($field['options'])){
    $datalist.='<datalist id="'.$field['list'].'">';
    foreach($field['options'] as $option) {
      if(is_array($option)){$datalist.='<option label="'.$option['label'].'" value="'.$option['value'].'" />';
      }else{$datalist.='<option value="'.$option.'" />';}
    }
    $datalist.='</datalist>';
  }
  $field['datalist']=$datalist;
  $extra='';
  foreach($field as $attr_key=>$attr_value){
    if(is_numeric($attr_key)){
      $extra.=$attr_value.' ';
      if(strtolower(trim($attr_value))=='readonly'){$field['readonly']=1;}
      if(strtolower(trim($attr_value))=='disabled'){$field['disabled']=1;}
    }elseif( !in_array($attr_key,array('fields','type','name','title','key','description','class','value','default','options','show_admin_column','sortable_column','taxonomies','datalist','settings') ) ) {
      $extra.=$attr_key.'="'.$attr_value.'" ';
    }
  }
  $field['extra']=$extra;
  return $field;
}
function xuui_get_field_html($field,$sub=false){
  extract(xuui_parse_field($field,$sub));
  switch($type) {
    case 'image':
      $field_html=xuui_get_input_field_html('url',$name,$key,$class,$value,$extra).'<input type="button" class="xuui_upload button" value="选择图片">';
      break;
      
    case 'color':
      $extra.='style="padding:0;margin:0;border:0;background:none;box-shadow:none;-webkit-box-shadow:none;height:28px;"';
      $field_html=xuui_get_input_field_html($type,$name,$key,$class,$value,$extra);
      break;

    case 'file':
      $value=($value)?'<span style="background-color:yellow; padding:2px;margin:0 4px 0 0;">已上传</span>':'';
      if(empty($field['formenctype'])){$extra.='formenctype="multipart/form-data" ';}
      $field_html=$value.xuui_get_input_field_html($type,$key,$key,$class,'',$extra);
      break;

    case 'range':
      $extra.=' onchange="jQuery(\'#'.$key.'_span\').html(jQuery(\'#'.$key.'\').val());"';
      $field_html=xuui_get_input_field_html($type,$name,$key,$class,$value,$extra).' <span id="'.$key.'_span">'.$value.'</span>';
      break;

    case 'checkbox':
      if(!empty($field['options'])){
        $field_html='';
        foreach($field['options'] as $option_value=>$option_title){ 
          if($value && in_array($option_value,$value)){$checked=" checked='checked'";}else{$checked='';}
          $field_html.=xuui_get_input_field_html($type,$name.'[]','',$class,$option_value,$checked.$extra).$option_title.'&nbsp;&nbsp;&nbsp;';
        }
      }else{
        $extra.=checked("1",$value,false);
        $field_html=xuui_get_input_field_html($type,$name,$key,$class,'1',$extra);
      }
      break;

    case 'textarea':
      $rows=isset($field['rows'])?$field['rows']:6;
      $field_html='<textarea name="'.$name.'" id="'.$key.'" class="'.$class.' code" rows="'.$rows.'" cols="50" '.$extra.' >'.esc_textarea($value).'</textarea>';
      break;

    case 'editor':
      $field_html='';
      ob_start();
      $settings=isset($field['settings'])?$field['settings']:array();
      wp_editor($value,$key,$settings);
      $field_html=ob_get_contents();
      ob_end_clean();
      break;

    case 'select':
      $field_html='<select name="'.$name.'" id="'. $key.'" class="'.$class.'" '.$extra.' >';
      if(!empty($field['options'])){
        foreach($field['options'] as $option_value=>$option_title){$field_html.='<option value="'.$option_value.'" '.selected($option_value,$value,false).'>'.$option_title.'</option>';}
      }
      $field_html.='</select>';
      break;

    case 'radio':
      $field_html='';
      if(!empty($field['options'])){
        if($value==''){$values=array_keys($field['options']);$value=$values[0];}
        $sep=(count($field['options'])>3)?'<br />':'&nbsp;&nbsp;&nbsp;';

        foreach($field['options'] as $option_value=>$option_title) {
          $checked=checked($option_value,$value,false);
          $field_html.='<input type="radio" name="'.$name.'" id="'.$key.'_'.$option_value.'" class="'.$class.'" value="'.$option_value.'" '.$extra.$checked.' /><label for="'.$key.'_'.$option_value.'">'.$option_title."</label>".$sep;
        }
      }
      break;

    case 'mu-image':
      $field_html='';
      if(is_array($value)){
        foreach($value as $image){
          if(!empty($image)){
            $field_html.='<span><input type="text" name="'.$name.'[]" id="'.$key.'" class="'.$class.'" value="'.esc_attr($image).'"  /><a href="javascript:;" class="button del_item">删除</a><br /></span>';
          }
        }
      }
      $field_html.='<span><input type="text" name="'.$name.'[]" id="'.$key.'" value="" class="'.$class.'" /><input type="button" class="xuui_multi_upload button" value="选择图片[多选]" title="按住Ctrl点击鼠标左键可以选择多张图片"></span>';
      break;

    case 'mu-img':
      $field_html='';
      if(is_array($value)){$i=0;
        foreach($value as $img_id){
          if(!empty($img_id)){
            $img=wp_get_attachment_image_src($img_id,'full');
            $img_src=$img[0];
            if(function_exists('xuui_get_thumbnail')){$img_src=xuui_get_thumbnail($img_src,200);}
            $field_html.='<span class="mu_img"><img width="100" src="'.$img_src.'" alt=""><input type="hidden" name="'.$name.'[]" id="'.$key.'" class="'.$class.'" value="'.$img_id.'"  /><a href="javascript:;" class="del_item">—</a></span>';$i++;
            if($i%5==0){$field_html.='<br />';}
          }
        }
      }
      $field_html.='<span style="display:block;"><input type="hidden" name="'.$name.'[]" id="'.$key.'" value="" class="'.$class.'" /><input type="button" class="xuui_multi_upload2 button" value="选择图片[多选]" title="按住Ctrl点击鼠标左键可以选择多张图片"></span>';
      break;

    case 'mu-text':
      $field_html='';
      if(is_array($value)){
        foreach($value as $item){
          if(!empty($item)){
            $field_html.='<span><input type="text" name="'.$name.'[]" id="'. $key.'" value="'.esc_attr($item).'"  class="'.$class.'" /><a href="javascript:;" class="button del_item">删除</a><br /></span>';
          }
        }
      }
      $field_html.='<span><input type="text" name="'.$name.'[]" id="'.$key.'" value="" class="'.$class.'" /><a class="xuui_multi_text button">添加选项</a></span>';
      break;

    case 'view':
      if(!empty($field['options'])){
        $value=($value)?$value:0;
        $field_html=isset($field['options'][$value])?$field['options'][$value]:'';
      }else{$field_html=$value;}
      
      break;

    case 'hr':
      $field_html='<hr />';
      break;

    case 'fieldset':
      $field_html='';
      if(!empty($fields)){
        foreach($fields as $sub_key=>$sub_field) {
          $sub_field['key']=$sub_key;
          // $sub_field['value']=isset($sub_field['value'])?$sub_field['value']:(isset($value[$sub_key])?$value[$sub_key]:'');
          $field_title=(!empty($sub_field['title']))?'<label class="sub_field_label" for="'.$sub_key.'">'.$sub_field['title'].'</label>':'';
          $field_html.='<p id="p_'.$sub_key.'">'.$field_title.xuui_get_field_html($sub_field,$sub=true).'</p>';
        }
      }
      break;

    case '':
      $field_html=$value;
      break;
    
    default:
      $field_html=xuui_get_input_field_html($type,$name,$key,$class,$value,$extra);
      break;
  }

  return apply_filters('xuui_field_html',$field_html.$datalist.$description,$field);
}
