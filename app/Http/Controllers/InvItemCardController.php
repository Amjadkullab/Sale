<?php

namespace App\Http\Controllers;


use App\Models\Admin;
use App\Models\Inv_itemcard;
use App\Models\Inv_itemcard_categorie;
use App\Models\Inv_uom;
use Illuminate\Http\Request;
use App\Http\Requests\Inv_ItemcardRequest;

class InvItemCardController extends Controller
{
   public function index(){
    $com_code = auth()->user()->com_code;
    $data =Inv_itemcard::select()->where(["com_code"=>$com_code])->orderby('id','DESC')->paginate(PAGINATION_COUNT);

    if(!empty($data)){

        foreach($data as $info){
          $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
           $info->inv_itemcard_categories_name =Inv_itemcard_categorie::where(['id'=>$info->inv_itemcard_categories_id])->value('name');
           $info->parent_inv_itemcard_name =Inv_itemcard::where(['id'=>$info->parent_inv_itemcard_id])->value('name');
           $info->uom_name =Inv_uom::where(['id'=>$info->uom_id])->value('name');
           $info->retail_uom_name = Inv_uom::where(['id'=>$info->retail_uom_id])->value('name');


            if($info->updated_by > 0 and  $info->updated_by!=null ){
                $info->updated_by_admin = Admin::where(['id',$info->updated_by])->value('name');
            }

        }
    }
    $inv_itemcard_categories = Inv_itemcard_categorie::select('id','name')->where(['com_code'=>$com_code , 'active'=>1])->orderby('id','DESC')->get();
      return view('admin.inv_itemcard.index',['data'=>$data ,'inv_itemcard_categories'=> $inv_itemcard_categories]);

   }
  public function create(){

   $com_code = auth()->user()->com_code;
  $inv_itemcard_categories = Inv_itemcard_categorie::select('id','name')->where(['com_code'=>$com_code , 'active'=>1])->orderby('id','DESC')->get();
  $inv_uoms_parent = Inv_uom::select('id','name')->where(['com_code'=>$com_code,'active'=>1,'is_master'=>1])->orderby('id','DESC')->get();
  $inv_uoms_child = Inv_uom::select('id','name')->where(['com_code'=>$com_code,'active'=>1,'is_master'=>0])->orderby('id','DESC')->get();
  $inv_item_data= Inv_itemcard::select('id','name')->where(['com_code'=>$com_code , 'active'=>1 ])->orderby('id','DESC')->get();

  return view('admin.inv_itemcard.create',['inv_itemcard_categories'=>$inv_itemcard_categories , 'inv_uoms_parent'=>$inv_uoms_parent,'inv_uoms_child'=>$inv_uoms_child,'inv_item_data'=>$inv_item_data]);


  }
  public function store(Inv_ItemcardRequest $request){
  try{
    $com_code = auth()->user()->com_code ;
    // set item code for item card
    $row = Inv_itemcard::select('item_code')->where(['com_code'=>$com_code])->orderby('id','DESC')->first();
    if(!empty($row)){

        $data_insert['item_code'] = $row['item_code']+1 ;
    }else{
        $data_insert['item_code'] = 1 ;
    }

    if($request->barcode != ''){
        $checkExists_barcode = Inv_itemcard::where(['barcode'=>$request->barcode , 'com_code'=>$com_code])->first();
        if(!empty( $checkExists_barcode)){
            return redirect()->back()->with(['error'=>'عفوا باركود الصنف موجود من قبل'])->withInput();
        }else{
            $data_insert['barcode'] = $request->barcode ;

        }
    }else{
        $data_insert['barcode'] = "item".$data_insert['item_code'] ;

    }
        $checkExists = Inv_itemcard::where(['name'=>$request->name , 'com_code'=>$com_code])->first();
        if(!empty( $checkExists)){
            return redirect()->back()->with(['error'=>'عفوا اسم الصنف موجود من قبل'])->withInput();
        }


        $data_insert['name'] = $request->name ;
        $data_insert['item_type'] = $request->item_type ;
        $data_insert['inv_itemcard_categories_id'] = $request->inv_itemcard_categories_id ;
        $data_insert['uom_id'] = $request->uom_id ;
        $data_insert['price'] = $request->price ;
        $data_insert['nos_gomla_price'] = $request->nos_gomla_price ;
        $data_insert['gomla_price'] = $request->gomla_price ;
        $data_insert['cost_price'] = $request->cost_price ;
        $data_insert['does_has_retailunit'] = $request->does_has_retailunit ;
        $data_insert['parent_inv_itemcard_id'] = $request->parent_inv_itemcard_id ;
        if( $data_insert['parent_inv_itemcard_id']==0){
            $data_insert['parent_inv_itemcard_id']==0;
        }
       if($data_insert['does_has_retailunit'] ==1 ){
        $data_insert['retail_uom_id'] = $request->retail_uom_id;
        $data_insert['retail_uom_quntToParent'] = $request->retail_uom_quntToParent ;
        $data_insert['price_retail'] = $request->price_retail ;
        $data_insert['nos_gomla_price_retail'] = $request->nos_gomla_price_retail ;
        $data_insert['gomla_price_retail'] = $request->gomla_price_retail ;
        $data_insert['cost_price_retail'] = $request->cost_price_retail;
       }
       $data_insert['has_fixed_price'] = $request->has_fixed_price;
       $data_insert['active']=$request->active;
       if($request->has('item_image')){
        $request->validate([
            'item_image'=>['required','mimes:png,jpg,jpeg','max:2000']
        ]);
        $file_path = uploadImage('admin_assets/uploads',$request->item_image);
        $data_insert['photo'] = $file_path ;

        }
        $data_insert['added_by'] = auth()->user()->id;
        $data_insert['created_at'] = date('Y-m-d H:i:s');
        $data_insert['date'] = date('Y-m-d');
        $data_insert['com_code'] = $com_code;
        Inv_itemcard::create($data_insert);
        return redirect()->route('admin.inv_itemcard.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);

    }catch(\Exception $ex){
        return redirect()->back()->with(['error'=>'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();
    }
}
    public function edit($id){

        $com_code = auth()->user()->com_code;
        $data = Inv_itemcard::select()->find($id);
        $inv_itemcard_categories = Inv_itemcard_categorie::select('id','name')->where(['com_code'=>$com_code , 'active'=>1])->orderby('id','DESC')->get();
        $inv_uoms_parent = Inv_uom::select('id','name')->where(['com_code'=>$com_code,'active'=>1,'is_master'=>1])->orderby('id','DESC')->get();
        $inv_uoms_child = Inv_uom::select('id','name')->where(['com_code'=>$com_code,'active'=>1,'is_master'=>0])->orderby('id','DESC')->get();
        $inv_item_data= Inv_itemcard::select('id','name')->where(['com_code'=>$com_code , 'active'=>1 ])->orderby('id','DESC')->get();

        return view('admin.inv_itemcard.edit',['inv_itemcard_categories'=>$inv_itemcard_categories , 'inv_uoms_parent'=>$inv_uoms_parent,'inv_uoms_child'=>$inv_uoms_child,'inv_item_data'=>$inv_item_data,'data'=>$data]);

    }
          public function update(Inv_ItemcardRequest $request , $id){
            try{
                $com_code = auth()->user()->com_code;
                $data = Inv_itemcard::select()->find($id);
                if(empty($data)){
                    return redirect()->route('admin.inv_itemcard.index')->with(['error'=>'غير قادر على الوصول الى البيانات المطلوبة']);
                }
                if($request->barcode != ''){
                    $checkExists_barcode = Inv_itemcard::where(['barcode'=>$request->barcode , 'com_code'=>$com_code])->where('id','!=',$id)->first();
                    if(!empty( $checkExists_barcode)){
                        return redirect()->back()->with(['error'=>'عفوا باركود الصنف موجود من قبل'])->withInput();
                    }else{
                        $data_to_update['barcode'] = $request->barcode;

                    }
                }
                    $checkExists = Inv_itemcard::where(['name'=>$request->name , 'com_code'=>$com_code])->where('id','!=',$id)->first();
                    if(!empty( $checkExists)){
                        return redirect()->back()->with(['error'=>'عفوا اسم الصنف موجود من قبل'])->withInput();
                    }


        $data_to_update['name'] = $request->name ;
        $data_to_update['item_type'] = $request->item_type ;
        $data_to_update['inv_itemcard_categories_id'] = $request->inv_itemcard_categories_id ;
        $data_to_update['uom_id'] = $request->uom_id ;
        $data_to_update['price'] = $request->price ;
        $data_to_update['nos_gomla_price'] = $request->nos_gomla_price ;
        $data_to_update['gomla_price'] = $request->gomla_price ;
        $data_to_update['cost_price'] = $request->cost_price ;
        $data_to_update['does_has_retailunit'] = $request->does_has_retailunit ;
        $data_to_update['parent_inv_itemcard_id'] = $request->parent_inv_itemcard_id ;
        if( $data_to_update['parent_inv_itemcard_id']==0){
            $data_to_update['parent_inv_itemcard_id']==0;
        }
       if($data_to_update['does_has_retailunit'] ==1 ){
        $data_to_update['retail_uom_id'] = $request->retail_uom_id;
        $data_to_update['retail_uom_quntToParent'] = $request->retail_uom_quntToParent ;
        $data_to_update['price_retail'] = $request->price_retail ;
        $data_to_update['nos_gomla_price_retail'] = $request->nos_gomla_price_retail ;
        $data_to_update['gomla_price_retail'] = $request->gomla_price_retail ;
        $data_to_update['cost_price_retail'] = $request->cost_price_retail;
       }
       $data_to_update['has_fixed_price'] = $request->has_fixed_price;
       $data_to_update['active']=$request->active;
       if($request->has('photo')){
        $request->validate([
            'photo'=>['required','mimes:png,jpg,jpeg','max:2000']
        ]);
        $oldphotopath= $data['photo'];
        $file_path = uploadImage('admin_assets/uploads',$request->photo);
        if(file_exists('admin_assets/uploads/'.$oldphotopath)and !empty($oldphotopath)){
            unlink('admin_assets/uploads/'.$oldphotopath);
        }
        $data_to_update['photo'] = $file_path ;

        }
        $data_to_update['added_by'] = auth()->user()->id;
        $data_to_update['created_at'] = date('Y-m-d H:i:s');
        $data_to_update['date'] = date('Y-m-d');
        $data_to_update['com_code'] = $com_code;
     Inv_itemcard::where(['id'=>$id , 'com_code'=>$com_code])->update( $data_to_update);
                return redirect()->route('admin.inv_itemcard.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);




            }
            catch(\Exception $ex){
                return redirect()->back()->with(['error'=>'عفوا حدثث خطأ ما'.$ex->getMessage()])->withinput();
            }

  }



  public function delete($id){


    try{
        $com_code = auth()->user()->com_code;
        $data = Inv_itemcard::where(['id'=>$id ,'com_code'=>$com_code])->find($id);
        if(!empty($data)){
           $flag = $data->delete();
           if($flag){
               return redirect()->back()->with(['success'=>'تم حذف الصنف بنجاح']);
           } else {
               return redirect()->back()->with(['success'=>'عفوا حدث خطأ ما']);

           }
        }

    }  catch(\Exception $ex){
        return redirect()->back()->with(['error'=>'عفوا حدثث خطأ ما'.$ex->getMessage()])->withinput();
    }

  }
  public function show($id){

    $com_code = auth()->user()->com_code;
    $data = Inv_itemcard::select()->find($id);
    $data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');
           $data['inv_itemcard_categories_name'] =Inv_itemcard_categorie::where(['id'=>$data['inv_itemcard_categories_id']])->value('name');
           $data['parent_inv_itemcard_name' ]=Inv_itemcard::where(['id'=>$data['parent_inv_itemcard_id']])->value('name');
           $data['uom_name' ]=Inv_uom::where(['id'=>$data['uom_id']])->value('name');
           if($data['does_has_retailunit'] == 1  ){
            $data['retail_uom_name'] = Inv_uom::where(['id'=>$data['retail_uom_id']])->value('name');
           }
            if($data['updated_by'] > 0 and  $data['updated_by']!=null ){
                   $data['updated_by_admin'] = Admin::where(['id',$data['updated_by']])->value('name');
               }


    return view('admin.inv_itemcard.show',['data'=>$data]);
            }


            public function ajax_search(Request $request){


                if($request->ajax()){
                    $search_by_text = $request->search_by_text;
                    $item_type = $request->item_type;
                    $inv_itemcard_categories_id = $request->inv_itemcard_categories_id;
                    $searchbyradio=$request->searchbyradio;
                    if($item_type =='all'){
                        $field1= "id" ;
                        $operator1 = ">";
                        $value1 = 0;
                      }else{
                        $field1 = "item_type";
                        $operator1= "=";
                        $value1 = $item_type;
                      }
                    // if($search_by_text ==''){
                    //     $field1 = "id" ;
                    //     $operator1 = ">";
                    //     $value1 = 0;
                    //   }else{
                    //     $field1 = "name";
                    //     $operator1 = "LIKE";
                    //     $value1 = "%{$search_by_text}%";
                    //   }


                  if($inv_itemcard_categories_id =='all'){
                    $field2= "id" ;
                    $operator2 = ">";
                    $value2 = 0;
                  }else{
                    $field2 = "inv_itemcard_categories_id";
                    $operator2= "=";
                    $value2 = $inv_itemcard_categories_id;
                  }

                  if($search_by_text!=''){
                    if($searchbyradio=='barcode'){

                            $field3="barcode";
                            $operator3="=";
                            $value3=$search_by_text;



                      }elseif($searchbyradio=='item_code'){



                            $field3="item_code";
                            $operator3="=";
                            $value3=$search_by_text;



                      }else{
                        $field3="name";
                        $operator3="LIKE";
                        $value3="%{$search_by_text}%";

                      }

                  }else{
                    $field3="id";
                    $operator3=">";
                    $value3=0;

                  }


                //   if($search_by_text==''){
                //     $field3="id";
                //     $operator3=">";
                //     $value3=0;
                //   }else{
                //     $field3="barcode";
                //     $operator3="=";
                //     $value3=$search_by_text;

                //   }
                //   if($search_by_text==''){
                //     $field4="id";
                //     $operator4=">";
                //     $value4=0;
                //   }else{
                //     $field4="item_code";
                //     $operator4="=";
                //     $value4=$search_by_text;

                //   }


                    $data = Inv_itemcard::where($field1,$operator1,$value1)->where($field2,$operator2,$value2)->where($field3,$operator3,$value3)->Orderby('id','DESC')->paginate(PAGINATION_COUNT);
                    if(!empty($data)){

                        foreach($data as $info){
                          $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
                           $info->inv_itemcard_categories_name =Inv_itemcard_categorie::where(['id'=>$info->inv_itemcard_categories_id])->value('name');
                           $info->parent_inv_itemcard_name =Inv_itemcard::where(['id'=>$info->parent_inv_itemcard_id])->value('name');
                           $info->uom_name =Inv_uom::where(['id'=>$info->uom_id])->value('name');
                           $info->retail_uom_name = Inv_uom::where(['id'=>$info->retail_uom_id])->value('name');


                            if($info->updated_by > 0 and  $info->updated_by!=null ){
                                $info->updated_by_admin = Admin::where(['id',$info->updated_by])->value('name');
                            }

                        }
                    }

                    return view('admin.inv_itemcard.ajax_search',['data'=>$data]);

                }

            }















        }


































