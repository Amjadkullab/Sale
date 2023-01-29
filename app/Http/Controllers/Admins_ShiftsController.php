<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Admins_Shifts;
use App\Models\Admins_treasuries;
use App\Models\Treasuries;

class Admins_ShiftsController extends Controller
{
    public function index(){
        $com_code = Auth()->user()->com_code;
        $data =Admins_Shifts::select()->where(['com_code'=>$com_code])->orderby('id','DESC')->paginate(PAGINATION_COUNT);
        if(!empty($data)){

            foreach($data as $info){
              $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
              $info->treasuries_name = Treasuries::where('id', $info->treasuries_id)->value('name');

        }

          return view('admin.admins_shifts.index',['data'=>$data]);

    }
    }
    public function create(){

        $com_code = auth()->user()->com_code;
       $admins_treasuries = Admins_treasuries::select('treasuries_id')->where(['com_code'=>$com_code , 'active'=>1 ,'admin_id'=>auth()->user()->id])->orderby('id','DESC')->get();
       if(!empty($admins_treasuries)){
      foreach($admins_treasuries as $info){
        $info->treasuries_name = Treasuries::where('id', $info->treasuries_id)->value('name');
        $check_exists_admins_shifts = Admins_Shifts::select('id')->where(['treasuries_id'=>$info->treasuries_id , 'com_code'=>$com_code ,'is_finished'=>0])->first();
        if(!empty($check_exists_admins_shifts) and $check_exists_admins_shifts !=null){
$info->available = false ;
        }else{
            $info->available = true ;
        }

      }

       return view('admin.admins_shifts.create',['admins_treasuries'=>$admins_treasuries]);


       }
    }
}
