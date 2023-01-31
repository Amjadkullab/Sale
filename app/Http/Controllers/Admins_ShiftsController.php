<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminShiftsRequest;
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
              $info->admin_name = Admin::where('id', $info->admin_id)->value('name');
              $info->treasuries_name = Treasuries::where('id', $info->treasuries_id)->value('name');

        }
        $checkExistsopenshifts = Admins_Shifts::select('id')->where(['com_code' => $com_code, 'admin_id' => auth()->user()->id , 'is_finished'=>0])->first();


          return view('admin.admins_shifts.index',['data'=>$data,'checkExistsopenshifts'=>$checkExistsopenshifts]);

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
       return view('admin.admins_shifts.create',['admins_treasuries'=>$admins_treasuries ]);


       }
    }
    public function store(AdminShiftsRequest $request)
    {

        try {

            $com_code = auth()->user()->com_code;
            $admin_id = auth()->user()->id;
            // check if not exists
            $checkExistsopenshifts = Admins_Shifts::select('id')->where(['com_code' => $com_code, 'admin_id' => $admin_id , 'is_finished'=>0])->first();
            if ($checkExistsopenshifts !=null and !empty($checkExistsopenshifts)) {
                return redirect()->route('admin.admin_shift.index')->with(['error' => ' عفوا هناك شفت مفتوح لديك بالفعل حاليا ولا يمكن فتح شفت جديد الا بعد اغلاق الشفت الحالي!' ]);
            }
            $checkExistsopentreasuries = Admins_Shifts::select('id')->where(['com_code' => $com_code, 'treasuries_id' => $request->treasuries_id , 'is_finished'=>0])->first();
            if ($checkExistsopentreasuries !=null and !empty($checkExistsopentreasuries)) {
                return redirect()->route('admin.admin_shift.index')->with(['error' => ' عفوا الخزنة المختارة مستخدمة بالفعل من قبل مستخدم اخر  ولا يمكن استخدامها الا بعد الانتهاء من الشفت الاخر!' ]);
            }
            $row = Admins_Shifts::select('shift_code')->where(['com_code'=>$com_code])->orderby('id','DESC')->first();
            if(!empty($row)){
                $data_insert['shift_code']=$row['shift_code']+1;
                }else{
                    $data_insert['shift_code']=1;
                }
                $data_insert['admin_id'] = $admin_id;
                $data_insert['treasuries_id'] = $request->treasuries_id;
                $data_insert['start_date'] = date('Y-m-d H:i:s');
                $data_insert['created_at'] = date('Y-m-d H:i:s');
                $data_insert['added_by'] = auth()->user()->id;
                $data_insert['com_code']  = $com_code;
                $data_insert['date']= date('Y-m-d');
               $flag = Admins_Shifts::create($data_insert);
               if($flag){
return redirect()->route('admin.admin_shift.index')->with(['success'=> 'تم اضافة البيانات بنجاح']);
               }else{
                return redirect()->route('admin.admin_shift.index')->with(['error'=> 'عفوا حدث خطا ما']);
               }

        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'عفوا حدث خطا ما!' . $ex->getMessage()])->withInput();
        }
    }

    public function edit($id){
        $data = Treasuries::select()->find($id);
        return view('admin.treasuries.edit',['data'=>$data]);
    }
}
