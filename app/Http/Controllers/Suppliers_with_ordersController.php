<?php

namespace App\Http\Controllers;

use App\Http\Requests\Suppliers_with_ordersRequest;
use App\Models\Admin;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\SuppliersWith_order;

class Suppliers_with_ordersController extends Controller
{
    public function index()
    {
        $com_code = auth()->user()->com_code ;
        $data = SuppliersWith_order::select()->where(['com_code'=>$com_code])->orderby('id', 'DESC')->paginate(PAGINATION_COUNT);
        if (!empty($data)) {
            foreach ($data as $info)
                $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
                $info->supplier_name = Supplier::where(['supplier_code'=>$info->supplier_code])->value('name');
            if ($info->updated_by > 0 and $info->updated_by != null) {
                $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
            }
        }
        return view('admin.suppliers_with_orders.index', ['data' => $data]);
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

            $supplierdata = Supplier::select('account_number')->where(['supplier_code'=>$request->supplier_code,'com_code'=>$com_code]);
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

                $data_insert['order_date'] = $request->order_date ;
                $data_insert['order_type'] = 1 ;
                $data_insert['DOC_NO'] = $request->DOC_NO ;
                $data_insert['supplier_code'] = $request->supplier_code ;
                $data_insert['pill_type'] = $request->pill_type ;
                $data_insert['account_number'] = $supplierdata['account_number'] ;

                $data_insert['added_by'] = auth()->user()->id;
                $data_insert['created_at'] = date('Y-m-d H:i:s');
                $data_insert['date'] = date('Y-m-d');
                $data_insert['com_code'] = $com_code;
                SuppliersWith_order::create($data_insert);
                return redirect()->route('admin.suppliers_with_orders.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);

            }catch(\Exception $ex){
                return redirect()->back()->with(['error'=>'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();
            }




    }
}
