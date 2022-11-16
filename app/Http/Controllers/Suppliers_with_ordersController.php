<?php

namespace App\Http\Controllers;

use App\Http\Requests\Suppliers_with_ordersRequest;
use App\Models\Admin;
use App\Models\Inv_itemcard;
use App\Models\Inv_uom;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\suppliers_with_orders_detail;
use Illuminate\Http\Request;
use App\Models\SuppliersWith_order;
use Exception;

class Suppliers_with_ordersController extends Controller
{
    public function index()
    {
        $com_code = auth()->user()->com_code ;
        $data = SuppliersWith_order::select()->where(['com_code'=>$com_code])->orderby('id', 'DESC')->paginate(PAGINATION_COUNT);
        if (!empty($data)) {
            foreach ($data as $info){
                $info->added_by_admin=Admin::where('id', $info->added_by)->value('name');
                $info->supplier_name=Supplier::where('supplier_code',$info->supplier_code)->value('name');
                $info->store_name=Store::where('id',$info->store_id)->value('name');
            if ($info->updated_by > 0 and $info->updated_by != null) {
                $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
            }
        }

        return view('admin.suppliers_with_orders.index', ['data' => $data]);
    }
    }
    public function create()
    {
        $com_code = auth()->user()->com_code ;
        $suppliers = Supplier::select('name','supplier_code')->where(['com_code'=>$com_code,'active'=>1])->orderby('id','DESC')->paginate(PAGINATION_COUNT);
        $stores = Store::select('id', 'name')->where(['com_code'=>$com_code , 'active'=>1])->orderby('id','DESC')->get();
        return view('admin.suppliers_with_orders.create',['suppliers'=>$suppliers ,'stores'=>$stores]);
    }
    public function store(Suppliers_with_ordersRequest $request){
        try{
            $com_code = auth()->user()->com_code ;

            $supplierdata = Supplier::select('account_number')->where(['supplier_code'=>$request->supplier_code,'com_code'=>$com_code])->first();
         if(empty($supplierdata)){
            return redirect()->back()->with(['error'=>'عفوا غير قادر على الوصول الى بيانات المورد المحدد '])->withInput();
         }


            // set item code for item card
            $row = SuppliersWith_order::select('auto_serial')->where(['com_code'=>$com_code])->orderby('id','DESC')->first();
            if(!empty($row)){

                $data_insert['auto_serial'] = $row['auto_serial']+1 ;
            }else{
                $data_insert['auto_serial'] = 1 ;
            }

                $data_insert['order_date'] = $request->order_date;
                $data_insert['order_type'] = 1 ;
                $data_insert['DOC_NO'] = $request->DOC_NO;
                $data_insert['supplier_code'] = $request->supplier_code;
                $data_insert['pill_type'] = $request->pill_type;
                $data_insert['store_id'] = $request->store_id;
                $data_insert['account_number']=$supplierdata['account_number'];
                $data_insert['added_by'] = auth()->user()->id;
                $data_insert['created_at'] = date('Y-m-d H:i:s');
                $data_insert['date'] = date('Y-m-d');
                $data_insert['com_code'] = $com_code;
                SuppliersWith_order::create($data_insert);
                return redirect()->route('admin.supplier_order.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);

            }catch(\Exception $ex){
                return redirect()->back()->with(['error'=>'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();
            }




    }
    public function show($id){

        try{
            $com_code = auth()->user()->com_code;
            $data = SuppliersWith_order::select()->where(['id'=>$id,'com_code'=>$com_code,'order_type'=>1])->first();
            if(empty($data)){
                return redirect()->route('admin.supplier_order.index')->with(['error' => 'عفوا غير قادر على الوصول الى البياات المطلوبة !!']);
        }

      $data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');
     $data['supplier_name']=Supplier::where('supplier_code',$data['supplier_code'])->value('name');
     $data['store_name']=Store::where('id',$data['store_id'])->value('name');

      if ($data['updated_by'] > 0 and $data['updated_by']!= null) {
          $data['updated_by_admin'] = Admin::where('id',  $data['updated_by'] )->value('name');
      }
        $details = suppliers_with_orders_detail::select()->where(['suppliers_with_orders_auto_serial'=>$data['auto_serial'],'order_type'=>1,'com_code'=>$com_code])->orderby('id','DESC')->get(); // treasuries_id هي الخزنة الاب
        if(!empty($details)){
            foreach($details as $info){
                $info->item_card_name = Inv_itemcard::where('item_code',$info->item_code)->value('name');
                $info->uom_name = Inv_uom::where('id',$info->uom_id)->value('name');
                $info->added_by_admin = Admin::where(['id',$info->added_by])->value('name');
                if ($data['updated_by'] > 0 and $data['updated_by']!= null) {
                    $data['updated_by_admin'] = Admin::where('id',  $data['updated_by'] )->value('name');
                }
            }

        }
        // if pill still open
        if($data['is_approved']==0){
            $item_cards = Inv_itemcard::select('name','item_code','item_type')->where(['active'=>1,'com_code'=>$com_code])->orderby('id','DESC')->get();

        }else{
            $item_cards = "";

        }


    return view('admin.suppliers_with_orders.show',['data'=>$data , 'details'=> $details,'item_cards'=>$item_cards]);

        }catch(\Exception $ex){
        return redirect()->back()->with(['error' => 'عفوا حدث خطا ما!' . $ex->getMessage()]);

    }

    }
    public function get_item_uoms (Request $request){
        if($request->ajax()){
        $item_code = $request->item_code;
           $com_code = auth()->user()->com_code ;
           $item_card_data = Inv_itemcard::select('does_has_retailunit','retail_uom_id','uom_id')->where(['item_code'=>$item_code , 'com_code'=>$com_code])->first();
         if(!empty($item_card_data)){
            if($item_card_data['does_has_retailunit']==1){
                $item_card_data['parent_uom_name'] = Inv_uom::where(['id'=>$item_card_data['uom_id']])->value('name');
                $item_card_data['retail_uom_name'] = Inv_uom::where(['id'=>$item_card_data['retail_uom_id']])->value('name');
            }

         else{
            $item_card_data['parent_uom_name'] = Inv_uom::where(['id'=>$item_card_data['uom_id']])->value('name');

         }
        }

            return view('admin.suppliers_with_orders.get_item_uoms',['item_card_data'=>$item_card_data]);
    }
}
    public function add_new_details (Request $request){
        if($request->ajax()){
             $item_code = $request->item_code;
           $com_code = auth()->user()->com_code ;
           $suuplier_with_order =SuppliersWith_order::select('is_approved','order_date','tax_value','discount_value')->where(['auto_serial'=>$request->autoserailparent , 'com_code'=>$com_code,'order_type'=>1])->first();
         if(!empty($suuplier_with_order)){
            if($suuplier_with_order['is_approved']==0){
                $data_insert['suuplier_with_order']=$request->suuplier_with_order ;
                $data_insert['order_type']=1;
                $data_insert['item_code']=$request->item_code_add ;
                $data_insert['deliverd_quantity']=$request->quantity_add ;
                $data_insert['unit_price']=$request->price_add ;
                $data_insert['uom_id']=$request->uom_id_Add ;
                $data_insert['isparentuom']=$request->isparentuom ;
                if($request->type == 2){
                    $data_insert['production_date']=$request->production_date ;
                    $data_insert['expire_date']=$request->expire_date ;
                }
                $data_insert['item_card_type']=$request->type;
                $data_insert['total_price']=$request->total_add;
                $data_insert['order_date']=$suuplier_with_order['order_date'];

                $data_insert['added_by'] = auth()->user()->id;
                $data_insert['created_at'] = date('Y-m-d H:i:s');
                $data_insert['com_code'] = $com_code;
              $flag =  suppliers_with_orders_detail::create($data_insert);
              if($flag){

              $total_details_sum =  suppliers_with_orders_detail::where(['suppliers_with_orders_auto_serial	'=>$request->autoserailparent , 'com_code'=>$com_code,'order_type'=>1])->sum('total_price');
              $dataUpdateParent['total_cost_items'] =$total_details_sum ;
              $dataUpdateParent['total_before_discount'] =$total_details_sum+$suuplier_with_order['tax_value'];
              $dataUpdateParent['total_cost'] =$dataUpdateParent['total_before_discount']-$suuplier_with_order['discount_value'] ;
              $dataUpdateParent['updated_by'] = auth()->user()->id;
              $dataUpdateParent['updated_at'] = date('Y-m-d H:i:s');
              SuppliersWith_order::where(['auto_serial'=>$request->autoserailparent , 'com_code'=>$com_code,'order_type'=>1])->update($dataUpdateParent);
              echo json_encode("done");
              }
            }
        }
    }
}
public function reload_itemsdetails (Request $request){
    if($request->ajax()){
         $auto_serial = $request->autoserailparent;
       $com_code = auth()->user()->com_code ;
       $data = SuppliersWith_order::select('is_approved')->where(['auto_serial'=>$auto_serial,'com_code'=>$com_code,'order_type'=>1])->first();
       if(!empty($data)){
        $details = suppliers_with_orders_detail::select()->where(['suppliers_with_orders_auto_serial'=>$auto_serial,'order_type'=>1,'com_code'=>$com_code])->Orderby('id','DESC')->get(); // treasuries_id هي الخزنة الاب
        if(!empty($details)){
            foreach($details as $info){
                $info->item_card_name = Inv_itemcard::where('item_code',$info->item_code)->value('name');
                $info->uom_name = Inv_uom::select('id',$info->uom_id)->value('name');
                $info->added_by_admin = Admin::where(['id',$info->added_by])->value('name');
                if ($data['updated_by'] > 0 and $data['updated_by']!= null) {
                    $data['updated_by_admin'] = Admin::where('id',  $data['updated_by'] )->value('name');
                }
            }

        }

       }


        return view('admin.suppliers_with_orders.reload_itemsdetails',['data'=>$data,'datails'=>$details]);
}
}
public function reload_parent_pill (Request $request){
    if($request->ajax()){

       $com_code = auth()->user()->com_code ;

       $data = SuppliersWith_order::select()->where(['auto_serial'=>$request->autoserailparent,'com_code'=>$com_code,'order_type'=>1])->first();
       if(!empty($data)){
        $data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');
        $data['supplier_name']=Supplier::where('supplier_code',$data['supplier_code'])->value('name');

         if ($data['updated_by'] > 0 and $data['updated_by']!= null) {
             $data['updated_by_admin'] = Admin::where('id',  $data['updated_by'] )->value('name');
         }

         return view('admin.suppliers_with_orders.reload_parent_pill',['data'=>$data]);
        }
   }



}
public function edit($id){
    $com_code = auth()->user()->com_code ;
    $data = SuppliersWith_order::select()->where(['id'=>$id , 'com_code'=>$com_code , 'order_type'=> 1 ])->first();
    if(empty($data)){
        return redirect()->route('admin.supplier_order.index')->with(['error' => 'عفوا غير قادر على الوصول الى البياات المطلوبة !!']);
}
if($data['is_approved']==1){
    return redirect()->route('admin.supplier_order.index')->with(['error' => 'لا يمكن تحديث فاتورة معتمدة ومؤرشفة!!']);
}

    $suppliers = Supplier::select('name','supplier_code')->where(['com_code'=>$com_code,'active'=>1])->orderby('id','DESC')->paginate(PAGINATION_COUNT);
    $stores = Store::select('id', 'name')->where(['com_code'=>$com_code , 'active'=>1])->orderby('id','DESC')->get();
    return view('admin.suppliers_with_orders.edit',['data'=>$data, 'suppliers'=>$suppliers,'stores'=>$stores]);
}
public function update($id,Suppliers_with_ordersRequest $request){
    try{
    $com_code = auth()->user()->com_code ;
    $data = SuppliersWith_order::select('is_approved')->where(['id'=>$id , 'com_code'=>$com_code , 'order_type'=> 1 ])->first();
    if(empty($data)){
        return redirect()->route('admin.supplier_order.index')->with(['error' => 'عفوا غير قادر على الوصول الى البياات المطلوبة !!']);
}
$supplierdata = Supplier::select('account_number')->where(['supplier_code'=>$request->supplier_code,'com_code'=>$com_code])->first();
if(empty($supplierdata)){
   return redirect()->back()->with(['error'=>'عفوا غير قادر على الوصول الى بيانات المورد المحدد '])->withInput();
}

$data_update['order_date'] = $request->order_date;
$data_update['order_type'] = 1 ;
$data_update['DOC_NO'] = $request->DOC_NO;
$data_update['supplier_code'] = $request->supplier_code;
$data_update['pill_type'] = $request->pill_type;
$data_update['store_id'] = $request->store_id;
$data_update['account_number']=$supplierdata['account_number'];
$data_update['updated_by'] = auth()->user()->id;
$data_update['updated_at'] = date('Y-m-d H:i:s');
$data_update['com_code'] = $com_code;
SuppliersWith_order::where(['id'=>$id , 'com_code'=>$com_code , 'order_type'=>1])->update($data_update);
return redirect()->route('admin.supplier_order.show',$id)->with(['success' => 'لقد تم اضافة البيانات بنجاح']);

    }catch(\Exception $ex){
        return redirect()->back()->with(['error'=>'عفوا حدث خطأ ما '.$ex->getMessage()]);
    }


}
}
