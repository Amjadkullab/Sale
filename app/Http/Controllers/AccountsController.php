<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Account;
use App\Models\AccountsType;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function index(){

        $data =Account::select()->orderby('id','DESC')->paginate(PAGINATION_COUNT);

        if(!empty($data)){

            foreach($data as $info){
              $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');

            //    $info->parent_inv_itemcard_name =Inv_itemcard::where(['id'=>$info->parent_inv_itemcard_id])->value('name');


                if($info->updated_by > 0 and  $info->updated_by!=null ){
                    $info->updated_by_admin = Admin::where(['id',$info->updated_by])->value('name');
                }
                $info->account_types_name =AccountsType::where(['id'=>$info->account_types_id])->value('name');
                   if($info->is_parent==0){

                    $info->parent_account_name =Account::where(['account_number'=>$info->parent_account_number])->value('name');
                   }else{
                    $info->parent_account_name = "لا يوجد" ;


                   }
            }
        }

          return view('admin.accounts.index',['data'=>$data ]);

    }

    }

