<?php

namespace App\Http\Controllers;

use App\Http\Requests\Inv_UomRequest;
use App\Models\Admin;
use App\Models\Inv_uom;
use Illuminate\Http\Request;

class Inv_UomController extends Controller
{
    public function index()
    {
        $data = Inv_uom::select()->orderby('id', 'DESC')->paginate(PAGINATION_COUNT);
        if (!empty($data)) {
            foreach ($data as $info)
                $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
            if ($info->updated_by > 0 and $info->updated_by != null) {
                $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
            }
        }
        return view('admin.inv_uom.index', ['data' => $data]);
    }
    public function create()
    {
        return view('admin.Inv_uom.create');
    }
    public function store(Inv_UomRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            $cheackexists = Inv_uom::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($cheackexists == null) {
                $data['name'] = $request->name;
                $data['is_master']=$request->is_master;
                $data['active']=$request->active;
                $data['created_at']=date('Y-m-d H:i:s');
                $data['added_by']=auth()->user()->id;
                $data['com_code']=$com_code;
                $data['date']=date('Y-m-d');
                Inv_uom::create($data);
                return redirect()->route('admin.uoms.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
            } else {
                return redirect()->back()->with(['error' => 'عفوا اسم  الوحدة من قبل '])->withInput();
            }
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ ما !' . $ex->getMessage()])->withInput();
        }
    }
    public function edit($id){
        $data = Inv_uom::select()->find($id);
        return view('admin.Inv_uom.edit',['data'=>$data]);


    }
    public function update($id,Inv_UomRequest $request){

        try{

            $com_code = auth()->user()->com_code ;
            $data = Inv_uom::select()->find($id);
            if(empty($data)){
                return redirect()->route('admin.uoms.index')->with(['error'=>'غير قادر على الوصول الى البيانات المطلوبة']);
            }
            $checkExists = Inv_uom::where(['name'=>$request->name , 'com_code'=>$com_code])->where('id','!=',$id)->first();
            if( $checkExists !=null){
                return redirect()->back()->with(['error' => 'عفوا اسم الوحدة مسجل من قبل '])->withInput();
            }

            $data_to_update['name'] = $request->name ;
            $data_to_update['is_master']=$request->is_master;
            $data_to_update['active']= $request->active;
            $data_to_update['updated_at']= date('Y-m-d H:s');
            $data_to_update['updated_by'] = auth()->user()->id ;
            $data_to_update['date'] = date('Y-m-d');
            $data_to_update['com_code']=$com_code;
            Inv_uom::where(['id'=>$id , 'com_code'=>$com_code])->update( $data_to_update);
            return redirect()->route('admin.uoms.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);

        }
        catch(\Exception $ex){
            return redirect()->back()->with(['error'=>'عفوا حدثث خطأ ما'.$ex->getMessage()])->withinput();
        }



    }

 public function delete($id){
    try{

        $data = Inv_uom::select()->find($id);
        if(!empty($data)){
           $flag = $data->delete();
           if($flag){
               return redirect()->back()->with(['success'=>'تم حذف الوحدة بنجاح']);
           } else {
               return redirect()->back()->with(['success'=>'عفوا حدث خطأ ما']);

           }
        }

    }  catch(\Exception $ex){
        return redirect()->back()->with(['error'=>'عفوا حدثث خطأ ما'.$ex->getMessage()])->withinput();
    }





 }
 public function ajax_search(Request $request){


    if($request->ajax()){
        $search_by_text = $request->search_by_text;
        $is_master_search = $request->is_master_search;
        if($search_by_text ==''){
            $field1 = "id" ;
            $operator1 = ">";
            $value1 = 0;
          }else{
            $field1 = "name";
            $operator1 = "LIKE";
            $value1 = "%{$search_by_text}%";
          }

      if($is_master_search =='all'){
        $field2= "id" ;
        $operator2 = ">";
        $value2 = 0;
      }else{
        $field2 = "is_master";
        $operator2= "=";
        $value2 = $is_master_search;
      }

        $data = Inv_uom::where($field1,$operator1,$value1)->where($field2,$operator2,$value2)->Orderby('id','DESC')->paginate(PAGINATION_COUNT);
        if (!empty($data)) {
            foreach ($data as $info)
                $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
            if ($info->updated_by > 0 and $info->updated_by != null) {
                $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
            }
        }

        return view('admin.Inv_uom.ajax_search',['data'=>$data]);

    }

}


}

