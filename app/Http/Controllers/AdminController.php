<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Treasuries;
use Illuminate\Http\Request;
use App\Models\Admins_treasuries;

class AdminController extends Controller
{
    public function index(){
        $com_code = auth()->user()->com_code ;
          $data = Admin::select()->where('com_code',$com_code)->orderby('id','DESC')->paginate(PAGINATION_COUNT);
          if (!empty($data)) {
            foreach ($data as $info) {
            $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
            if ($info->updated_by > 0 and $info->updated_by != null) {
            $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
            }
            }
            }
      return view('admin.admins_accounts.index',['data'=>$data]);


}
public function details($id){

    try{
        $com_code = auth()->user()->com_code;
        $data = Admin::select()->where('id',$id)->where('com_code',$com_code)->first();
        if(empty($data)){
            return redirect()->route('admin.admin_accounts.index')->with(['error' => 'عفوا غير قادر على الوصول الى البياات المطلوبة !!']);
    }

  $data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');

  if ($data['updated_by'] > 0 and $data['updated_by']!= null) {
      $data['updated_by_admin'] = Admin::where('id',  $data['updated_by'] )->value('name');
  }
  $treasuries = Treasuries::select('id','name')->where(['com_code' =>$com_code,'active' => 1])->get();
  $admins_treasuries = Admins_treasuries::select()->where('admin_id',$id)->where('com_code',$com_code)->get(); // treasuries_id هي الخزنة الاب
  if (!empty($admins_treasuries)) {
    foreach ($admins_treasuries as $info) {
    $info->name = Treasuries::where('id', $info->treasuries_id)->value('name');
    $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
    if ($info->updated_by > 0 and $info->updated_by != null) {
    $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
    }
    }
    }

    return view("admin.admins_accounts.details", ['data' => $data, 'admins_treasuries' => $admins_treasuries, 'treasuries' => $treasuries]);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}
public function Add_treasuries_to_admin($id , Request $request){
    try{
        $com_code = auth()->user()->com_code;
        $data = Admin::select()->where('id',$id)->where('com_code',$com_code)->first();
        if(empty($data)){
            return redirect()->route('admin.admin_accounts.index')->with(['error' => 'عفوا غير قادر على الوصول الى البيانات المطلوبة !!']);
    }
    $admin_treasuries_exists = Admins_treasuries::select('id')->where(['admin_id'=>$id,'treasuries_id'=>$request->treasuries_id,'com_code'=>$com_code])->first();
    if(!empty($admin_treasuries_exists)){
        return redirect()->route('admin.admin_accounts.details',$id )->with(['error' => 'عفوا هده الخزنة مضافة من قبل لهذا المستخدم!!']);
}

$data_insert['admin_id'] = $id;
$data_insert['treasuries_id'] = $request->treasuries_id;
$data_insert['active'] = 1;
$data_insert['created_at'] = date("Y-m-d H:i:s");
$data_insert['added_by'] = auth()->user()->id;
$data_insert['com_code'] = $com_code;
$data_insert['date'] = date("Y-m-d");
    $flag=Admins_treasuries::create($data_insert);
    if($flag){
        return redirect()->route('admin.admin_accounts.details',$id)->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
        }else{
        return redirect()->route('admin.admin_accounts.details',$id)->with(['error' => 'عفوا حدث خطأ ما من فضلك حاول مرة اخري !!!']);
        }
        } catch (\Exception $ex) {
        return redirect()->back()
        ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
        }
        }



}
