<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\SalesMaterialTypes;
use App\Http\Requests\Sales_Material_TypesRequest;

class Sales_material_typesController extends Controller
{
    public function index()
    {
        $data = SalesMaterialTypes::select()->orderby('id', 'DESC')->paginate(PAGINATION_COUNT);

        if (!empty($data)) {

            foreach ($data as $info) {
                $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');

                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
                }
            }
        }
        return view('admin.sales_material_types.index', ['data' => $data]);
    }
    public function create(){
        return view('admin.sales_material_types.create');
    }
    public function store(Sales_Material_TypesRequest $request){

        try{

            $com_code = auth()->user()->com_code ;
            $cheackexists = SalesMaterialTypes::select()->where(['name'=>$request->name , 'com_code'=>$com_code])->first();
            if($cheackexists ==null ){

        $data['name'] = $request->name;
        $data['active'] = $request->active;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['added_by'] = auth()->user()->id;
        $data['com_code']=$com_code;
        $data['date']=date('Y-m-d');
        SalesMaterialTypes::create($data);
        return redirect()->route('admin.sales_material_type.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
    }else {
        return redirect()->back()->with(['error' => 'عفوا اسم الفئة مسجل من قبل '])->withInput();
    }
        }
catch(\Exception $ex){
    return redirect()->back()->with(['error'=>'عفوا حدث خطأ ما !'.$ex->getMessage()])->withInput();
}

    }



public function edit($id){
    $data = SalesMaterialTypes::select()->find($id);
    return view('admin.sales_material_types.edit',['data'=>$data]);

}
public function update($id ,Sales_Material_TypesRequest $request ){
    try{
        $com_code = auth()->user()->com_code;
        $data = SalesMaterialTypes::select()->find($id);
        if(empty($data)){
            return redirect()->route('admin.sales_material_type.index')->with(['error'=>'غير قادر على الوصول الى البيانات المطلوبة']);
        }
        $checkExists = SalesMaterialTypes::where(['name'=>$request->name , 'com_code'=>$com_code])->where('id','!=',$id)->first();
        if( $checkExists !=null){
            return redirect()->back()->with(['error' => 'عفوا اسم الفئة مسجل من قبل '])->withInput();
        }

        $data_to_update['name'] = $request->name ;
        $data_to_update['active'] = $request->active ;
        $data_to_update['updated_at'] = date('Y-m-d H:s');
        $data_to_update['updated_by'] = auth()->user()->id ;
        $data_to_update['date'] = date('Y-m-d');
        $data_to_update['com_code'] = $com_code;
        SalesMaterialTypes::where(['id'=>$id , 'com_code'=>$com_code])->update( $data_to_update);
        return redirect()->route('admin.sales_material_type.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);




    }
    catch(\Exception $ex){
        return redirect()->back()->with(['error'=>'عفوا حدثث خطأ ما'.$ex->getMessage()])->withinput();
    }
}
 public function delete($id){
try{
    $sales_material_type = SalesMaterialTypes::find($id);
    if(!empty($sales_material_type)){

        $flag =  $sales_material_type->delete();


        if($flag){
            return redirect()->back()->with(['success'=>'تم حذف البيانات بنجاح']);
        }else{
            return redirect()->back()->with(['error'=>'عفوا حدث خطأ ما' ]);
        }

}

}  catch(\Exception $ex){
    return redirect()->back()->with(['error'=>'عفوا حدثث خطأ ما'.$ex->getMessage()])->withinput();
}
}
}
