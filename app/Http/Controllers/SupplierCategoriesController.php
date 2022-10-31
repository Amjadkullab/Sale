<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuppliesCategoriesRequest;
use App\Models\Admin;
use App\Models\SupplierCategories;
use Illuminate\Http\Request;

class SupplierCategoriesController extends Controller
{
    public function index(){
        $com_code = auth()->user()->com_code ;
        $data = SupplierCategories::select()->where(['com_code'=>$com_code])->orderby('id','DESC')->paginate(PAGINATION_COUNT);
        if(!empty($data)){
            foreach($data as $info){

              $info->added_by_admin = Admin::where('id',$info->added_by)->value('name');
              if( $info-> updated_by > 0 && $info->updated_by != null){
                $info->updated_by_admin = Admin::where('id',$info->updated_by)->value('name');
              }

            }
        }
        return view('admin.supplier_categories.index',['data'=>$data]);
    }
    public function create(){
        return view('admin.supplier_categories.create');
    }
    public function store(SuppliesCategoriesRequest $request){
        try{
            $com_code = auth()->user()->com_code ;
            $checkExists  = SupplierCategories::select()->where(['name'=>$request->name,'com_code'=>$com_code])->first();
            if( $checkExists == null){

                $data['name']=$request->name;
                $data['active']=$request->active;
                $data['created_at']= date('Y-m-d H:i:s');
                $data['added_by']=auth()->user()->id;
                $data['com_code']=$com_code;
                $data['date']=date('Y-m-d');
                SupplierCategories::create($data);
                return redirect()->route('admin.supplier_categories.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
            }else {
                return redirect()->back()->with(['error' => 'عفوا اسم الفئة مسجل من قبل '])->withInput();

            }

        }catch(\Exception $ex){
            return redirect()->back()->with(['error'=>'عفوا حدث خطا ما '.$ex->getMessage()])->withInput();

        }

    }

    public function edit($id){
        $data = SupplierCategories::select()->find($id);

        return view('admin.supplier_categories.edit',['data'=>$data]);
    }
    public function update(SuppliesCategoriesRequest $request ,$id){
 try{
    $com_code = auth()->user()->com_code ;

    $data = SupplierCategories::select()->find($id);
    if(empty($data)){
        return redirect()->route('admin.supplier_categories.index')->with(['error'=>'غير قادر على الوصول الى البيانات المطلوبة']);
    }
    $checkExists = SupplierCategories::where(['name'=>$request->name , 'com_code'=>$com_code])->where('id','!=',$id)->first();
    if( $checkExists !=null){
        return redirect()->back()->with(['error' => 'عفوا اسم الفئة مسجل من قبل '])->withInput();
    }
    $data_update['name']=$request->name;
    $data_update['active']=$request->active;
    $data_update['created_at']= date('Y-m-d H:i:s');
    $data_update['added_by']=auth()->user()->id;
    $data_update['com_code']=$com_code;
    $data_update['date']=date('Y-m-d');
    SupplierCategories::where(['id'=>$id ,'com_code'=>$com_code])->update($data_update);
    return redirect()->route('admin.supplier_categories.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);

 }catch(\Exception $ex){
            return redirect()->back()->with(['error'=>'عفوا حدث خطا ما '.$ex->getMessage()])->withInput();

        }
    }
    public function delete($id){

   try{
    $data = SupplierCategories::find($id);
    if(!empty( $data)){
        $flag = $data->delete();
        if($flag){
            return redirect()->back()->with(['success','تم حذف البيانات بنجاح' ]);
        }else{
            return redirect()->back()->with(['error','  عفوا حدث خطا ما ' ]);
        }

    }

   }catch(\Exception $ex){
            return redirect()->back()->with(['error'=>'عفوا حدث خطا ما '.$ex->getMessage()])->withInput();

        }




    }






}
