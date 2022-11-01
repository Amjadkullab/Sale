<?php

namespace App\Http\Controllers;

use App\Http\Requests\supplier_request;
use App\Models\Account;
use App\Models\Admin;
use App\Models\Supplier;
use App\Models\SupplierCategories;
use Illuminate\Http\Request;
use App\Models\Admin_panel_setting;

class SupplierController extends Controller
{
   public function index(){
    $com_code = auth()->user()->com_code ;
    $data = Supplier::select()->where(['com_code'=>$com_code])->orderby('id'.'DESC')->paginate(PAGINATION_COUNT);
    if(!empty($data)){

        foreach($data as $info){
          $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');

        //    $info->parent_inv_itemcard_name =Inv_itemcard::where(['id'=>$info->parent_inv_itemcard_id])->value('name');


            if($info->updated_by > 0 and $info->updated_by !=null ){
                $info->updated_by_admin = Admin::where(['id',$info->updated_by])->value('name');

        }
    }

      return view('admin.suppliers.index',['data'=>$data]);
    }
   }
   public function create(){
    $com_code = auth()->user()->com_code ;
    $supplier_categories = SupplierCategories::select('id','name')->where(['com_code'=>$com_code,'active'=>1])->orderby('id','DESC')->get();
    return view('admin.suppliers.create',['supplier_categories'=>$supplier_categories]);
}
public function store(supplier_request $request){
    try{
    $com_code = auth()->user()->com_code;
    $checkExists_name = Supplier::select('id')->where(['name'=>$request->name , 'com_code'=>$com_code])->first();
    if( $checkExists_name != null){
        return redirect()->back()->with(['error'=>'عفوا اسم العميل موجود من  قبل'])->withInput();
    }
    $row = Supplier::select('customer_code')->where(['com_code'=>$com_code])->orderby('id','DESC')->first();
    if(!empty($row)){
        $data_insert['customer_code']=$row['customer_code']+1;
        }else{
            $data_insert['customer_code']=1;
        }

        $row = Supplier::select('account_number')->where(['com_code'=>$com_code])->orderby('id','DESC')->first();
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
   $flag = Supplier::create($data_insert);
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
    $customer_parent_account_number = Admin_panel_setting::where(['com_code'=>$com_code])->value('supplier_parent_account_number');
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

}
