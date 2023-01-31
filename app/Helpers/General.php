<?php

use Illuminate\Support\Facades\Config;

 function uploadImage($folder,$image){


    $extension = strtolower($image->extension());
    $filename = time().rand(100,999).'.'.$extension ;
    $image->getClientOrignalName = $filename ;
    $image->move($folder,$filename);

   return $filename ;
}
// /*get some cols by pagination table */
// function get_cols_where_by($model, $columns_names = array(), $where = array(), $order_field,$order_type,$pagination_counter)
// {
//   $data = $model::select($columns_names)->where($where)->orderby($order_field, $order_type)->paginate($pagination_counter);
//   return $data;
// }
// /*get some cols  table */
// function get_cols_where($model, $columns_names = array(), $where = array(), $order_field,$order_type)
// {
//   $data = $model::select($columns_names)->where($where)->orderby($order_field, $order_type)->get();
//   return $data;
// }

// /*get some cols row table */
// function get_cols_where_row($model, $columns_names = array(), $where = array())
// {
//   $data = $model::select($columns_names)->where($where)->first();
//   return $data;
// }
// /*get some cols row table order by */
// function get_cols_where_row_orderby($model, $columns_names = array(), $where = array(), $order_field,$order_type)
// {
//   $data = $model::select($columns_names)->where($where)->orderby($order_field,$order_type)->first();
//   return $data;
// }

// /*get some cols table */
// function insert($model, $arrayToInsert=array())
// {
//   $flag = $model::create($arrayToInsert);
//   return $flag;
// }
function update($model=null,$data_to_update=array(),$where=array()){
    $flag=$model::where($where)->update($data_to_update);
    return $flag;
    }
function get_field_value($model, $field_name , $where = array())
{
  $data = $model::where($where)->value($field_name);
  return $data;
}

