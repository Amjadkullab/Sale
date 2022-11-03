<?php

namespace App\Http\Controllers;

use App\Http\Requests\supplier_request;
use App\Http\Requests\SupplierUpdateRequest;
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
    $data = Supplier::select()->where(['com_code'=>$com_code])->orderby('id','DESC')->paginate(PAGINATION_COUNT);
    if(!empty($data)){

        foreach($data as $info){
          $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
          $info->supplier_categories_name = SupplierCategories::where('id', $info->supplier_categories_id)->value('name');

        //    $info->parent_inv_itemcard_name =Inv_itemcard::where(['id'=>$info->parent_inv_itemcard_id])->value('name');


            if($info->updated_by > 0 and $info->updated_by !=null ){
                $info->updated_by_admin = Admin::where(['id',$info->updated_by])->value('name');

        }
    }

      return view('admin.suppliers.index',['data'=>$data]);
    }
   }
   public function create(){
    $com_code = auth()->user()->com_code;
    $supplier_categories = SupplierCategories::select('id','name')->where(['com_code'=>$com_code,'active'=>1])->orderby('id','DESC')->get();
    return view('admin.suppliers.create',['supplier_categories'=>$supplier_categories]);
}
public function store(supplier_request $request){
    try{
    $com_code = auth()->user()->com_code;
    $checkExists_name = Supplier::select('id')->where(['name'=>$request->name , 'com_code'=>$com_code])->first();
    if( $checkExists_name != null){
        return redirect()->back()->with(['error'=>'عفوا اسم المورد موجود من  قبل'])->withInput();
    }
    $row = Supplier::select('supplier_code')->where(['com_code'=>$com_code])->orderby('id','DESC')->first();
    if(!empty($row)){
        $data_insert['supplier_code']=$row['supplier_code']+1;
        }else{
            $data_insert['supplier_code']=1;
        }

        $row = Account::select('account_number')->where(['com_code'=>$com_code])->orderby('id','DESC')->first();
        if(!empty($row)){
            $data_insert['account_number']=$row['account_number']+1;
            }else{
                $data_insert['account_number']=1;
            }



    $data_insert['name'] = $request->name;
    $data_insert['adderss'] = $request->adderss;
    $data_insert['supplier_categories_id'] = $request->supplier_categories_id;
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
    $supplier_parent_account_number = Admin_panel_setting::where(['com_code'=>$com_code])->value('supplier_parent_account_number');
    $data_insert_account['parent_account_number']=$supplier_parent_account_number;
    $data_insert_account['is_parent']=0;
    $data_insert_account['account_number']=$data_insert['account_number'];
    $data_insert_account['notes']=$request->notes;
    $data_insert_account['account_types_id']= 2;
    $data_insert_account['is_archived']=$request->active;
    $data_insert_account['created_at']=date('Y-m-d H:i:s');
    $data_insert_account['added_by']=auth()->user()->id;
    $data_insert_account['com_code']=$com_code;
    $data_insert_account['date']=date('Y-m-d');
    $data_insert_account['other_table_FK'] = $data_insert['supplier_code'];
   Account::create($data_insert_account);
   }
    return redirect()->route('admin.supplier.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
    }catch(\Exception $ex){

        return redirect()->back()->with(['error'=>'عفوا حدث خطأ ما '.$ex->getMessage()]);
    }

}
public function edit($id){
    $com_code = Auth()->user()->com_code;
    $data = Supplier::select()->where(['com_code'=>$com_code,'id'=>$id])->first();
    $supplier_categories = SupplierCategories::select('id','name')->where(['com_code'=>$com_code,'active'=>1])->orderby('id','DESC')->get();
    return view('admin.suppliers.edit',['com_code'=> $com_code,'data'=>$data,'supplier_categories'=>$supplier_categories]);
}
public function update($id , SupplierUpdateRequest $request ){
    try{
        $com_code = auth()->user()->com_code;
        $data = Supplier::select('id','account_number','supplier_code')->where(['com_code'=>$com_code,'id'=>$id])->get();
        if(empty($data)){
            return redirect()->route('admin.supplier.index')->with(['error'=>'غير قادر على الوصول الى البيانات المطلوبة']);
        }

    $checkExists = Supplier::where(['name'=>$request->name ,'com_code'=>$com_code])->where('id','!=',$id)->first();
    if(!empty($checkExists)){
        return redirect()->back()->with(['error'=>'عفوا اسم المورد موجود من قبل'])->withInput();
    }
    $data_to_update['name'] = $request->name;
      $data_to_update['address'] = $request->address;
      $data_to_update['notes'] = $request->notes;
      $data_to_update['active'] = $request->active;
      $data_to_update['updated_by'] = auth()->user()->id;
      $data_to_update['updated_at'] = date("Y-m-d H:i:s");
       $flag= Supplier::where(['id'=>$id , 'com_code'=>$com_code])->update($data_to_update);
       if($flag){
        $data_to_update_account['name'] = $request->name;
        $data_to_update_account['updated_by'] = auth()->user()->id;
        $data_to_update_account['updated_at'] = date("Y-m-d H:i:s");
        $flag= Account::where(['account_number'=>$data['account_number'] , 'other_table_FK'=>$data['supplier_code'] ,'account_type'=>2,'com_code'=>$com_code])->update($data_to_update_account);



       }
        return redirect()->route('admin.supplier.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
    }
    catch(\Exception $ex){
        return redirect()->back()->with(['error'=>'عفوا حدثث خطأ ما'.$ex->getMessage()])->withinput();
    }
}
public function delete($id){
    $com_code = auth()->user()->com_code;
      $row = Supplier::select('name')->where(['id'=>$id,'com_code'=>$com_code]);
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

          if ($searchbyradio == 'supplier_code') {

            $field1 = "supplier_code";
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


        $data = Supplier::where($field1, $operator1, $value1)->where(['com_code'=>$com_code])->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        if (!empty($data)) {
            foreach($data as $info){
                $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
                $info->supplier_categories_name = SupplierCategories::where('id', $info->supplier_categories_id)->value('name');

              //    $info->parent_inv_itemcard_name =Inv_itemcard::where(['id'=>$info->parent_inv_itemcard_id])->value('name');


                  if($info->updated_by > 0 and $info->updated_by !=null ){
                      $info->updated_by_admin = Admin::where(['id',$info->updated_by])->value('name');

              }
          }

        }

        return view('admin.suppliers.ajax_search', ['data' => $data]);
      }
    }
}
