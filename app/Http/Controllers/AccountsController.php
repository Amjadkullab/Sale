<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequestUpdate;
use App\Http\Requests\AccountsRequest;
use App\Models\Admin;
use App\Models\Account;
use App\Models\AccountsType;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function index(){
        $com_code = Auth()->user()->com_code;
        $data =Account::select()->where(['com_code'=>$com_code])->orderby('id','DESC')->paginate(PAGINATION_COUNT);
        if(!empty($data)){

            foreach($data as $info){
              $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');

            //    $info->parent_inv_itemcard_name =Inv_itemcard::where(['id'=>$info->parent_inv_itemcard_id])->value('name');


                // if($info->updated_by > 0 and $info->updated_by !=null ){
                //     $info->updated_by_admin = Admin::where(['id',$info->updated_by])->value('name');
                // }
                $info->account_types_name =AccountsType::where(['id'=>$info->account_types_id])->value('name');
                   if($info->is_parent==0){

                    $info->parent_account_name =Account::where(['account_number'=>$info->parent_account_number])->value('name');
                   }else{
                    $info->parent_account_name = "لا يوجد" ;


                   }
            }
        }
        $account_type = AccountsType::select('id','name')->where(['active'=>1])->orderby('id','ASC')->get();
          return view('admin.accounts.index',['data'=>$data ,'account_type'=>$account_type]);

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

    public function edit($id){
        $com_code = Auth()->user()->com_code;
        $data = Account::select()->where(['com_code'=>$com_code,'id'=>$id])->first();
        $account_type = AccountsType::select('id','name')->where(['active'=>1,'relatediternalaccounts'=>0])->orderby('id','ASC')->get();
        $parent_accounts = Account::select('account_number','name')->where(['is_parent'=>1,'com_code'=>$com_code])->orderby('id','ASC')->get();
        return view('admin.accounts.edit',['com_code'=> $com_code,'data'=>$data,'account_type'=>$account_type ,'parent_accounts'=>$parent_accounts]);
    }


    public function update($id,AccountRequestUpdate $request){



        try{
            $com_code = auth()->user()->com_code;
            $data = Account::select('id')->where(['com_code'=>$com_code,'id'=>$id])->get();
            if(empty($data)){
                return redirect()->route('admin.accounts.index')->with(['error'=>'غير قادر على الوصول الى البيانات المطلوبة']);
            }

        $checkExists = Account::where(['name'=>$request->name ,'com_code'=>$com_code])->where('id','!=',$id)->first();
        if(!empty($checkExists)){
            return redirect()->back()->with(['error'=>'عفوا اسم الحساب موجود من قبل'])->withInput();
        }
        $data_to_update['name'] = $request->name;
        $data_to_update['account_types_id']=$request->account_types_id;
        $data_to_update['is_parent']=$request->is_parent;
        if($data_to_update['is_parent']==0){
            $data_to_update['parent_account_number']=$request->parent_account_number;
        }
        $data_to_update['notes']=$request->notes;
        $data_to_update['is_archived']=$request->is_archived;
            $data_to_update['updated_at'] = date('Y-m-d H:s');
            $data_to_update['updated_by'] = auth()->user()->id;
            $data_to_update['date'] = date('Y-m-d');
            $data_to_update['com_code'] = $com_code;
            Account::where(['id'=>$id , 'com_code'=>$com_code])->update($data_to_update);
            return redirect()->route('admin.accounts.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
        }
        catch(\Exception $ex){
            return redirect()->back()->with(['error'=>'عفوا حدثث خطأ ما'.$ex->getMessage()])->withinput();
        }
    }
  public function delete($id){
 $com_code = auth()->user()->com_code;
   $row = Account::select('name')->where(['id'=>$id,'com_code'=>$com_code]);
   try{
    if(!empty($row)){
        $flag = $row->delete();
      if($flag){
        return redirect()->back()->with(['success'=>'تم حذف البيانات بنجاح ']);
      }else{

        return redirect()->back()->with(['error'=>'عفوا حدث خطا ما']);

      }


        }else{
            return redirect()->back()->with(['error'=>'غير قادر على الوصول الى البيانات المطلوبة']);
        }


   } catch(\Exception $ex){
           return redirect()->back()->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()]);
   }

  }
public function ajax_search(Request $request){
 if($request->ajax()){
    $search_by_text = $request->search_by_text;
    $account_types =$request->account_types;
    $is_parent =$request->is_parent;
    $searchbyradio=$request->searchbyradio;



    if($account_types =='all'){
        $field1= "id" ;
        $operator1 = ">";
        $value1 = 0;
      }else{
        $field1 = "account_types";
        $operator1= "=";
        $value1 = $account_types;
      }



  if($is_parent =='all'){
    $field2= "id" ;
    $operator2 = ">";
    $value2 = 0;
  }else{
    $field2 = "is_parent";
    $operator2= "=";
    $value2 = $is_parent;
  }
    if($search_by_text!=''){
        if($searchbyradio=='account_number'){

                $field3="account_number";
                $operator3="=";
                $value3=$search_by_text;



          }else{
            $field3="name";
            $operator3="LIKE";
            $value3="%{$search_by_text}%";

          }

      }else{
        $field3="id";
        $operator3=">";
        $value3=0;

      }


      $data = Account::where($field1,$operator1,$value1)->where($field2,$operator2,$value2)->where($field3,$operator3,$value3)->Orderby('id','DESC')->paginate(PAGINATION_COUNT);
      if(!empty($data)){

        foreach($data as $info){
          $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');

        //    $info->parent_inv_itemcard_name =Inv_itemcard::where(['id'=>$info->parent_inv_itemcard_id])->value('name');


            // if($info->updated_by > 0 and $info->updated_by !=null ){
            //     $info->updated_by_admin = Admin::where(['id',$info->updated_by])->value('name');
            // }
            $info->account_types_name =AccountsType::where(['id'=>$info->account_types_id])->value('name');
               if($info->is_parent==0){

                $info->parent_account_name =Account::where(['account_number'=>$info->parent_account_number])->value('name');
               }else{
                $info->parent_account_name = "لا يوجد" ;


               }
        }
    }
      return view('admin.accounts.ajax_search',['data'=>$data]);

    }




}
}

