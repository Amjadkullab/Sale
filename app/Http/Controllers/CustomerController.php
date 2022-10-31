<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerEditRequest;
use App\Models\Admin;
use App\Models\Account;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use App\Models\Admin_panel_setting;

class CustomerController extends Controller
{
    public function index(){
        $com_code = Auth()->user()->com_code;
        $data =Customer::select()->where(['com_code'=>$com_code])->orderby('id','DESC')->paginate(PAGINATION_COUNT);
        if(!empty($data)){

            foreach($data as $info){
              $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');

            //    $info->parent_inv_itemcard_name =Inv_itemcard::where(['id'=>$info->parent_inv_itemcard_id])->value('name');


                if($info->updated_by > 0 and $info->updated_by !=null ){
                    $info->updated_by_admin = Admin::where(['id',$info->updated_by])->value('name');

            }
        }

          return view('admin.customers.index',['data'=>$data]);

    }
    }
    public function create(){
        return view('admin.customers.create');
    }


public function store(CustomerRequest $request){
    try{
    $com_code = auth()->user()->com_code;
    $checkExists_name = Customer::select('id')->where(['name'=>$request->name , 'com_code'=>$com_code])->first();
    if( $checkExists_name != null){
        return redirect()->back()->with(['error'=>'عفوا اسم العميل موجود من  قبل'])->withInput();
    }
    $row = Customer::select('customer_code')->where(['com_code'=>$com_code])->orderby('id','DESC')->first();
    if(!empty($row)){
        $data_insert['customer_code']=$row['customer_code']+1;
        }else{
            $data_insert['customer_code']=1;
        }

        $row = Customer::select('account_number')->where(['com_code'=>$com_code])->orderby('id','DESC')->first();
        if(!empty($row)){
            $data_insert['account_number']=$row['account_number']+1;
            }else{
                $data_insert['account_number']=1;
            }



    $data_insert['name'] = $request->name;
    $data_insert['adderss'] = $request->name;
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
        $data_insert['start_balance_status']= 3 ;
        $data_insert['start_balance'] = 0 ;
    }

    $data_insert['notes']=$request->notes;

    $data_insert['active']=$request->active;
    $data_insert['created_at']=date('Y-m-d H:i:s');
    $data_insert['added_by']=auth()->user()->id;
    $data_insert['com_code']=$com_code;
    $data_insert['date']=date('Y-m-d');
   $flag = Customer::create($data_insert);
   if($flag){
    $data_insert_account['name'] = $request->name;
    $data_insert_account['start_balance_status']=$request->start_balance_status;
    if( $data_insert_account['start_balance_status']==1){
        $data_insert_account['start_balance']=$request->start_balance*(-1);
    }elseif( $data_insert_account['start_balance_status']==2){
        $data_insert_account['start_balance']=$request->start_balance;
        if( $data_insert_account['start_balance']<0){
            $data_insert_account['start_balance']=$request->start_balance*(-1);

        }
    }elseif($data_insert_account['start_balance_status']==3){
        $data_insert_account['start_balance'] = 0 ;

    }else{
        $data_insert_account['start_balance_status']=3 ;
        $data_insert_account['start_balance'] = 0 ;
    }
    $customer_parent_account_number = Admin_panel_setting::where(['com_code'=>$com_code])->value('customer_parent_account_number');
    $data_insert_account['parent_account_number']=$customer_parent_account_number;
    $data_insert_account['is_parent']=0;
    $data_insert_account['account_number'] = $data_insert['account_number'];
    $data_insert_account['notes']=$request->notes;
    $data_insert_account['account_number']=$request->account_number;
    $data_insert_account['account_types_id ']=3;
    $data_insert_account['is_archived']=$request->active;
    $data_insert_account['created_at']=date('Y-m-d H:i:s');
    $data_insert_account['added_by']=auth()->user()->id;
    $data_insert_account['com_code']=$com_code;
    $data_insert_account['date']=date('Y-m-d');
    $data_insert_account['other_table_FK'] = $data_insert['customer_code'];
   Account::create($data_insert_account);
   }
    return redirect()->route('admin.customer.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
    }catch(\Exception $ex){

        return redirect()->back()->with(['error'=>'عفوا حدث خطأ ما '.$ex->getMessage()]);
    }

}
public function edit($id){
    $com_code = Auth()->user()->com_code;
    $data = Customer::select()->where(['com_code'=>$com_code,'id'=>$id])->first();

    return view('admin.customers.edit',['com_code'=> $com_code,'data'=>$data]);
}
public function update($id,CustomerEditRequest $request ){


    try{
        $com_code = auth()->user()->com_code;
        $data = Customer::select('id','account_number','customer_code')->where(['com_code'=>$com_code,'id'=>$id])->get();
        if(empty($data)){
            return redirect()->route('admin.customer.index')->with(['error'=>'غير قادر على الوصول الى البيانات المطلوبة']);
        }

    $checkExists = Customer::where(['name'=>$request->name ,'com_code'=>$com_code])->where('id','!=',$id)->first();
    if(!empty($checkExists)){
        return redirect()->back()->with(['error'=>'عفوا اسم الحساب موجود من قبل'])->withInput();
    }
    $data_to_update['name'] = $request->name;
      $data_to_update['address'] = $request->address;
      $data_to_update['notes'] = $request->notes;
      $data_to_update['active'] = $request->active;
      $data_to_update['updated_by'] = auth()->user()->id;
      $data_to_update['updated_at'] = date("Y-m-d H:i:s");
       $flag= Customer::where(['id'=>$id , 'com_code'=>$com_code])->update($data_to_update);
       if($flag){
        $data_to_update_account['name'] = $request->name;
        $data_to_update_account['updated_by'] = auth()->user()->id;
        $data_to_update_account['updated_at'] = date("Y-m-d H:i:s");
        $flag= Account::where(['account_number'=>$data['account_number'] , 'other_table_FK'=>$data['customer_code'] ,'account_type'=> 3,'com_code'=>$com_code])->update($data_to_update_account);



       }
        return redirect()->route('admin.customer.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
    }
    catch(\Exception $ex){
        return redirect()->back()->with(['error'=>'عفوا حدثث خطأ ما'.$ex->getMessage()])->withinput();
    }



}
public function delete($id){
    $com_code = auth()->user()->com_code;
      $row = Customer::select('name')->where(['id'=>$id,'com_code'=>$com_code]);
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
 public function ajax_search (Request $request){

  if($request->ajax()){
    $com_code = auth()->user()->com_code;

    $searchbytext = $request->searchbytext ;
    $searchbyradio = $request->searchbyradio ;




    if ($searchbytext != '') {

        if ($searchbyradio == 'customer_code') {

          $field1 = "customer_code";
          $operator1 = "=";
          $value1 = $searchbytext;
        } elseif ($searchbyradio == 'account_number') {

          $field1 = "account_number";
          $operator1 = "=";
          $value1 = $searchbytext;
        } else {
          $field1 = "name";
          $operator1 = "like";
          $value1 = "%{$searchbytext}%";
        }
      } else {
        //true
        $field1 = "id";
        $operator1 = ">";
        $value1 = 0;
      }


      $data = Customer::where($field1, $operator1, $value1)->where(['com_code'=>$com_code])->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
      if (!empty($data)) {
        foreach ($data as $info) {
          $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
          if ($info->updated_by > 0 and $info->updated_by != null) {
            $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
          }
        }
      }

      return view('admin.customers.ajax_search', ['data' => $data]);
    }
  }

  }

