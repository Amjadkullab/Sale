<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Inv_itemcard_categorie;
use App\Http\Requests\Inv_itemcard_categoriesRequest;

class InvItemcardCategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Inv_itemcard_categorie::select()->orderby('id', 'DESC')->paginate(PAGINATION_COUNT);

        if (!empty($data)) {

            foreach ($data as $info) {
                $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');

                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
                }
            }
        }
        return view('admin.inv_itemcard_categories.index', ['data' => $data]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.inv_itemcard_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Inv_itemcard_categoriesRequest $request)
    {
        try{
            $com_code = auth()->user()->com_code;
            $checkExists = Inv_itemcard_categorie::select()->where(['name'=>$request->name , 'com_code'=>$com_code])->first();
            if($checkExists==null){
          $data_create['name']=$request->name ;
          $data_create['active'] = $request->active ;
          $data_create['created_at'] = date('Y-m-d H:s') ;
          $data_create['added_by'] = auth()->user()->id ;
          $data_create['com_code']=$com_code;
          $data_create['date'] = date('Y-m-d') ;
           Inv_itemcard_categorie::create($data_create);
           return redirect()->route('inv_itemcard_categories.index')->with(['success'=>'تم اضافة فئة الصنف بنجاح']);

            } else{
                return redirect()->back()->with(['error'=>'عفوا اسم فئة الصنف مخزنة من قبل!'])->withInput();
            }




        }catch(\Exception $ex){
            return redirect()->back()->with(['error'=>'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inv_itemcard_categorie  $inv_itemcard_categorie
     * @return \Illuminate\Http\Response
     */
    public function show(Inv_itemcard_categorie $inv_itemcard_categorie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inv_itemcard_categorie  $inv_itemcard_categorie
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)

    {
        $data = Inv_itemcard_categorie::select()->find($id);
       return view('admin.inv_itemcard_categories.edit',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inv_itemcard_categorie  $inv_itemcard_categorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{

            $com_code = auth()->user()->com_code;
            $data = Inv_itemcard_categorie::select()->find($id);
              if(empty( $data )){
                return redirect()->route('inv_itemcard_categories.index')->with(['error'=>'غير قادر على الوصول الى البيانات المطلوبة']);
            }
            $checkExists = Inv_itemcard_categorie::where(['name'=>$request->name , 'com_code'=>$com_code])->where('id','!=',$id)->first();
            if( $checkExists !=null){
                return redirect()->back()->with(['error' => 'عفوا اسم الفئة مسجل من قبل '])->withInput();
            }

        $data_to_update['name'] = $request->name ;
        $data_to_update['active'] = $request->active ;
        $data_to_update['updated_at'] = date('Y-m-d H:s');
        $data_to_update['updated_by'] = auth()->user()->id ;
        $data_to_update['date'] = date('Y-m-d');
        $data_to_update['com_code'] = $com_code;
        Inv_itemcard_categorie::where(['id'=>$id , 'com_code'=>$com_code])->update( $data_to_update);
        return redirect()->route('inv_itemcard_categories.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);




        }catch(\Exception $ex){
            return redirect()->back()->with(['error'=>'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inv_itemcard_categorie  $inv_itemcard_categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        try{
            $inv_itemcard_categories = Inv_itemcard_categorie::find($id);
            if(!empty( $inv_itemcard_categories)){

                $flag =   $inv_itemcard_categories->delete();


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
