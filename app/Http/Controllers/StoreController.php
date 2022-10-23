<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoresRequest;
use App\Models\Admin;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
   public function index(){
    $data = Store::select()->Orderby('id','DESC')->paginate(PAGINATION_COUNT);
if(!empty($data)){

    foreach($data as $info){
       $info->added_by_admin = Admin::where('id',$info->added_by)->value('name');
        if($info->updated_by > 0 and  $info->updated_by!=null ){
            $info->updated_by_admin =   Admin::where('id',$info->updated_by)->value('name');
        }

    }
}
  return view('admin.stores.index',['data'=>$data]);

   }

   public function create(){
    return view('admin.stores.create');
   }
 public function store(StoresRequest $request){
    try{
        $com_code = auth()->user()->com_code;
        $cheackexists= Store::where(['name'=>$request->name,'com_code'=>$com_code])->first();
        if($cheackexists==null){
            $data['name'] = $request->name;
            $data['active'] = $request->active;
            $data['phones'] = $request->phones;
            $data['address'] = $request->address;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['added_by'] = auth()->user()->id;
            $data['com_code']=$com_code;
            $data['date']=date('Y-m-d');
            Store::create($data);
            return redirect()->route('admin.stores.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
        }else {
            return redirect()->back()->with(['error' => 'عفوا اسم  المخزن من قبل '])->withInput();
        }


    }catch(\Exception $ex){
        return redirect()->back()->with(['error'=>'عفوا حدث خطأ ما !'.$ex->getMessage()])->withInput();
    }

 }
 public function edit($id){
    $data = Store::select()->find($id);
    return view('admin.stores.edit',['data'=>$data]);

}
public function update($id ,StoresRequest $request ){
    try{
        $com_code = auth()->user()->com_code;
        $data = Store::select()->find($id);
        if(empty($data)){
            return redirect()->route('admin.sales_material_type.index')->with(['error'=>'غير قادر على الوصول الى البيانات المطلوبة']);
        }
        $checkExists = Store::where(['name'=>$request->name , 'com_code'=>$com_code])->where('id','!=',$id)->first();
        if( $checkExists !=null){
            return redirect()->back()->with(['error' => 'عفوا اسم الفئة مسجل من قبل '])->withInput();
        }

        $data_to_update['name'] = $request->name ;
        $data_to_update['active'] = $request->active ;
        $data_to_update['phones'] = $request->phones ;
        $data_to_update['address'] = $request->address ;
        $data_to_update['updated_at'] = date('Y-m-d H:s');
        $data_to_update['updated_by'] = auth()->user()->id ;
        $data_to_update['date'] = date('Y-m-d');
        $data_to_update['com_code'] = $com_code;
        Store::where(['id'=>$id , 'com_code'=>$com_code])->update( $data_to_update);
        return redirect()->route('admin.stores.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);




    }
    catch(\Exception $ex){
        return redirect()->back()->with(['error'=>'عفوا حدثث خطأ ما'.$ex->getMessage()])->withinput();
    }
}
public function delete($id){
    try{
        $stores = Store::find($id);
        if(!empty($stores)){

            $flag =  $stores->delete();


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
