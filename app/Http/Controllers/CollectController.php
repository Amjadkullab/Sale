<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Admin;
use App\Models\Admins_Shifts;
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
            }
        }
            //    $info->parent_inv_itemcard_name =Inv_itemcard::where(['id'=>$info->parent_inv_itemcard_id])->value('name');

            $checkExistsopenshifts = Admins_Shifts::select('id','treasuries_id')->where(['com_code' => $com_code, 'admin_id' => auth()->user()->id , 'is_finished'=>0])->first();
           if(!empty($checkExistsopenshifts)){
            $checkExistsopenshifts['treasuries_name']= Treasuries::where('id',  $checkExistsopenshifts['treasuries_id'])->value('name');
           }
        //      و بنفعش اعمل تحصيل على حساب اب وبدي اجيب كل الحسابات المالية يعني اعرضها عشان لما اعمل تحصيل يكون ل حساب مالي معين
        $accounts = Account::select('name','account_number')->where(['com_code'=>$com_code , 'is_archived'=>0 , 'is_parent'=>0])->orderby('id','DESC')->get();

          return view('admin.collect_transactions.index',['data'=>$data , 'checkExistsopenshifts'=>$checkExistsopenshifts , 'accounts'=>$accounts]);

       }
}
