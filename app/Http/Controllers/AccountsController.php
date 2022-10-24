<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountsRequest;
use App\Models\Admin;
use App\Models\Account;
use App\Models\AccountsType;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function index(){
        $com_code = Auth()->user()->com_code ;
        $data =Account::select()->where(['com_code'=>$com_code])->orderby('id','DESC')->paginate(PAGINATION_COUNT);

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



  public function create(){
    $com_code = Auth()->user()->com_code ;
    $account_type = AccountsType::select('id','name')->where(['active'=>1,'relatediternalaccounts'=>0])->orderby('id','ASC')->get();
  $parent_accounts = Account::select('account_number','name')->where(['is_parent'=>1,'com_code'=>$com_code])->orderby('id','ASC')->get();
    return view('admin.accounts.create',['account_type'=> $account_type ,'parent_accounts'=>$parent_accounts ]);
  }
 public function store(AccountsRequest $request){
      try{
        $com_code = auth()->user()->com_code;
        $checkExists = Account::where(['name' => $request->name, 'com_code' => $com_code])->first();
    $row = Account::select('account_number')->where(['com_code'=>$com_code])->orderby('id','DESC')->first();
    if(!empty($row)){
        $data_insert['account_number']=$row['account_number']+1;
        }else{
            $data_insert['account_number']=1;
        }

        $checkExists = Account::where(['name'=>$request->name ,'com_code'=>$com_code])->first();
        if(!empty( $checkExists)){
            return redirect()->back()->with(['error'=>'عفوا اسم الحساب موجود من قبل'])->withInput();
        }


        $data_insert['name'] = $request->name;
        $data_insert['account_types_id']=$request->account_types_id;
        $data_insert['is_parent']=$request->is_parent;
        if($data_insert['is_parent']==0){
            $data_insert['parent_account_number']=$request->parent_account_number;
        }
        $data_insert['start_balance_status']=$request->start_balance_status;
        if( $data_insert['start_balance_status']==1){
            $data_insert['start_balance']=$request->start_balance*(-1);
        }elseif( $data_insert['start_balance_status']==2){
            $data_insert['start_balance']=$request->start_balance;
            if( $data_insert['start_balance']<0){
                $data_insert['start_balance']=$request->start_balance*(-1);

            }
        }elseif($data_insert['start_balance_status']==3){
            $data_insert['start_balance'] = 0 ;

        }else{
            $data_insert['start_balance_status']==3 ;
            $data_insert['start_balance'] = 0 ;
        }
        $data_insert['notes']=$request->notes;
        $data_insert['is_archived']=$request->is_archived;
        $data_insert['created_at']=date('Y-m-d H:i:s');
        $data_insert['added_by']=auth()->user()->id;
        $data_insert['com_code']=$com_code;
        $data_insert['date']=date('Y-m-d');
        Account::create($data_insert);
        return redirect()->route('admin.accounts.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);

    }catch(\Exception $ex){
        return redirect()->back()->with(['error'=>'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();
    }
    }
}

