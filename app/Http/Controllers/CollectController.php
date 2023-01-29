<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Treasuries;
use Illuminate\Http\Request;
use App\Models\Treasuries_transactions;

class CollectController extends Controller
{
    public function index(){
        $com_code = auth()->user()->com_code ;
        $data = Treasuries_transactions::select()->where(['com_code'=>$com_code])->orderby('id','DESC')->paginate(PAGINATION_COUNT);
        if(!empty($data)){

            foreach($data as $info){
              $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
              $info->treasuries_name = Treasuries::where('id', $info->treasuries_id)->value('name');

            //    $info->parent_inv_itemcard_name =Inv_itemcard::where(['id'=>$info->parent_inv_itemcard_id])->value('name');


        }

          return view('admin.collect_transactions.index',['data'=>$data]);
        }
       }
}
