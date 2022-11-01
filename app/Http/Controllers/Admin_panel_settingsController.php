<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\Admin_panel_setting;

use function PHPUnit\Framework\fileExists;
use App\Http\Requests\Admin_panel_settings_Request;

class Admin_panel_settingsController extends Controller
{
    public function index(){

        $data=Admin_panel_setting::where('com_code',auth()->user()->com_code)->first();
        if(!empty($data)){
            if($data['updated_by'] > 0 and $data['updated_by']!= null){
             $data['updated_by_admin'] = Admin::where('id',$data['updated_by'])->value('name');
             $data['customer_parent_account_number_name'] = Account::where('account_number',$data['customer_parent_account_number'])->value('name');
             $data['supplier_parent_account_name'] = Account::where('account_number',$data['supplier_parent_account_number'])->value('name');

            }
        }
        return view('admin.admin_panel_settings.index',['data'=>$data]);
    }
    public function edit(){
        $data = Admin_panel_setting::where('com_code',auth()->user()->com_code)->first();
        $parent_accounts = Account::select('account_number','name')->where(['is_parent'=>1,'com_code'=>auth()->user()->com_code])->orderby('id','ASC')->get();
        return view('admin.admin_panel_settings.edit',['data'=>$data,'parent_accounts'=>$parent_accounts]);
    }
    public function update(Admin_panel_settings_Request $request){
        try{
            $admin_panel_setting = Admin_panel_setting::where('com_code',auth()->user()->com_code)->first();
            $admin_panel_setting->system_name = $request->system_name;
            $admin_panel_setting->address = $request->address;
            $admin_panel_setting->phone = $request->phone;
            $admin_panel_setting->general_alert = $request->general_alert;
            $admin_panel_setting->customer_parent_account_number = $request->customer_parent_account_number;
            $admin_panel_setting->supplier_parent_account_number = $request->supplier_parent_account_number;
            $admin_panel_setting->updated_by = auth()->user()->id;
            $admin_panel_setting->updated_at = date("Y-m-d H:i");
            $old_image=$admin_panel_setting->photo;
            if($request->has('photo')){
                $request->validate([
                    'photo'=>['required','mimes:png,jpg,jpeg','max:2000']
                ]);
                $file_path = uploadImage('admin_assets/uploads',$request->photo);
                $admin_panel_setting->photo = $file_path ;
                if(file_exists('admin_assets/uploads/'.$old_image)and !empty($old_image)){
                    unlink('admin_assets/uploads/'.$old_image);
                }

            }
            $admin_panel_setting->save();
            return redirect()->route('admin.adminpanelsetting.index')->with(['success'=>'تم تحديث البيانات بنجاح']);



        }catch(\Exception $ex){
            return redirect()->route('admin.adminpanelsetting.index')->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()]);

        }

    }
}
