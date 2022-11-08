<?php

namespace App\Http\Controllers;

use App\Http\Requests\Suppliers_with_ordersRequest;
use App\Models\Admin;
use App\Models\Inv_itemcard;
use App\Models\Supplier;
use App\Models\suppliers_with_orders_detail;
use Illuminate\Http\Request;
use App\Models\SuppliersWith_order;

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
        return view('admin.suppliers_with_orders.create',['suppliers'=>$suppliers]);
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
            $data = SuppliersWith_order::select()->where(['id'=>$id,'com_code'=>$com_code])->first();
            if(empty($data)){
                return redirect()->route('admin.supplier_order.index')->with(['error' => 'عفوا غير قادر على الوصول الى البياات المطلوبة !!']);
        }

      $data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');
     $data['supplier_name']=Supplier::where('supplier_code',$data['supplier_code'])->value('name');

      if ($data['updated_by'] > 0 and $data['updated_by']!= null) {
          $data['updated_by_admin'] = Admin::where('id',  $data['updated_by'] )->value('name');
      }
        $details = suppliers_with_orders_detail::select()->where(['suppliers_with_orders_auto_serial'=>$data['auto_serial'],'order_type'=>1,'com_code'=>$com_code])->Orderby('id','DESC')->get(); // treasuries_id هي الخزنة الاب
        if(!empty($details)){
            foreach($details as $info){
                $info->item_card_name = Inv_itemcard::where('item_code',$info->item_code)->value('name');
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
            $item_cards = array();

        }


    return view('admin.suppliers_with_orders.show',['data'=>$data , 'details'=> $details,'item_cards'=>$item_cards]);

        }catch(\Exception $ex){
        return redirect()->back()->with(['error' => 'عفوا حدث خطا ما!' . $ex->getMessage()]);

    }

    }
}
