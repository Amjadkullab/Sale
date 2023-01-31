<?php

namespace App\Http\Controllers;

use App\Http\Requests\Collect_transactionRequest;
use App\Models\Account;
use App\Models\Admin;
use App\Models\Admins_Shifts;
use App\Models\Mov_type;
use App\Models\Treasuries;
use Illuminate\Http\Request;
use App\Models\Treasuries_transactions;

class CollectController extends Controller
{
    public function index(){
        $com_code = auth()->user()->com_code ;
        $data = Treasuries_transactions::select()->where(['com_code'=>$com_code])->orderby('id','DESC')->paginate(PAGINATION_COUNT);
        if(!empty($data)){

            foreach($data as $info){
              $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
              $info->treasuries_name = Treasuries::where('id', $info->treasuries_id)->value('name');
            }
        }
            //    $info->parent_inv_itemcard_name =Inv_itemcard::where(['id'=>$info->parent_inv_itemcard_id])->value('name');

            $checkExistsopenshifts = Admins_Shifts::select('treasuries_id','shift_code')->where(['com_code' => $com_code, 'admin_id' => auth()->user()->id , 'is_finished'=>0])->first();
           if(!empty($checkExistsopenshifts)){
            $checkExistsopenshifts['treasuries_name']= Treasuries::where('id',  $checkExistsopenshifts['treasuries_id'])->value('name');
           }
        //      و بنفعش اعمل تحصيل على حساب اب وبدي اجيب كل الحسابات المالية يعني اعرضها عشان لما اعمل تحصيل يكون ل حساب مالي معين
        $accounts = Account::select('name','account_number')->where(['com_code'=>$com_code , 'is_archived'=>0 , 'is_parent'=>0])->orderby('id','DESC')->get();
        $mov_type = Mov_type::select('id','name')->where(['active'=>1 , 'in_screen'=>2 , 'is_private_internal'=>0])->orderby('id','ASC')->get();
        //get treasuries balance
        $checkExistsopenshift['treasuries_balance_now'] = Treasuries_transactions::where(['com_code'=>$com_code,'shift_code'=>$checkExistsopenshifts['shift_code']])->sum('money');


          return view('admin.collect_transactions.index',['data'=>$data , 'checkExistsopenshifts'=>$checkExistsopenshifts , 'accounts'=>$accounts ,'mov_type'=>$mov_type , 'checkExistsopenshift'=>$checkExistsopenshift]);

       }
       public function store(Collect_transactionRequest $request){
        try{
            $com_code = auth()->user()->id ;
            //check if user has open shift or not
            $checkExistsopenshifts = Admins_Shifts::select('treasuries_id','shift_code')->where(['com_code' => $com_code, 'admin_id' => auth()->user()->id , 'is_finished'=>0 ,'treasuries_id'=>$request->treasuries_id])->first();
            if(empty($checkExistsopenshifts)){
                return redirect()->back()->with(['error'=>'عفوا لا يوجد شفت خزنة مفتوح  حاليا!!']);
            }
            // first get isal number with treasuries
            $trasury_data = Treasuries::select('last_isal_collect')->where(['com_code'=>$com_code,'id'=>$request->treasuries_id])->first();
            if(empty($trasury_data)){
                return redirect()->back()->with(['error'=>'!!عفوا بيانات الخزنة المختارة غير موجودة']);
            }

            $data_Insert['isal_number']= $trasury_data['last_isal_collect'] + 1 ;
            $data_Insert['shift_code']=   $checkExistsopenshifts ['shift_code'];
            // مدين
            $data_Insert['money']= $request->money ;
            $data_Insert['treasuries_id']= $request->treasuries_id ;
            $data_Insert['is_approved']= 1 ;
            $data_Insert['mov_type']= $request->mov_type ;
            $data_Insert['move_date']= $request->move_date ;
            $data_Insert['account_number']= $request->account_number ;
            $data_Insert['is_account']= 1;
            // دائن
            $data_Insert['money_for_account']= $request->money*(-1) ;
            $data_Insert['byan']= $request->byan;
            $data_Insert['created_at']= date("Y-m-d H:i:s");
            $data_Insert['added_by']= auth()->user()->id;
            $data_Insert['com_code']= $com_code;
            $flag = Treasuries_transactions::create($data_Insert);
            if($flag){
                $dataUpdateTresuries['last_isal_collect'] = $data_Insert['isal_number'];
                 Treasuries::update($dataUpdateTresuries)->where(['com_code'=>$com_code,'id'=>$request->treasuries_id]);
            return redirect()->route('admin.collect_transaction.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
            } else{
                return redirect()->back()->with(['error'=>'!!عفوا حدث خطأ ما من فضلك  حاول مرة أخرى']);

            }


        }catch(\Exception $ex){
                return redirect()->back()->with(['error'=>'عفوا حدث خطأ ما' . $ex->getMessage()])->withInput();
        }

       }
}
