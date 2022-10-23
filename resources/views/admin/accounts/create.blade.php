@extends('layouts.master')
@section('title', '  اضافة صنف')
@section('contentheader', 'الأصناف')
@section('contentheaderlink')
    <a href="{{ route('admin.stores.index') }}">الأصناف</a>
@endsection
@section('contentheaderactive', 'اضافة')

@section('content')


            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">اضافة صنف جديد</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                     <form action= {{ route('admin.inv_itemcard.store') }} method="POST" enctype="multipart/form-data" >
                      @csrf
                      <div class="row">
                     <div class="col-md-6">
                      <div class="form-group">
                        <label for="barcode"> باركود الصنف - في حالة عدم الادخال سيولد بشكل ألي</label>
                        <input  name="barcode" id="barcode" class="form-control" value="{{old('barcode')}}" placeholder="أدخل  باركود الصنف" >
                         @error('barcode')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                       <label for="name"> اسم الصنف</label>
                       <input  name="name" id="name" class="form-control" value="{{old('name')}}" placeholder="أدخل  اسم الصنف" >
                        @error('name')
                        <span class="text-danger" >{{ $message }}</span>
                        @enderror
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="item_type"> نوع الصنف</label>
                       <select name="item_type" id="item_type" class="form-control" >
                         <option value="">اختر النوع</option>
                         <option @if (old('item_type')==1) selected = "selected" @endif  value="1"> مخزني</option>
                         <option @if (old('item_type')==2) selected = "selected" @endif  value="2"> استهلاكي بتاريخ صلاحية</option>
                         <option @if (old('item_type')==3) selected = "selected" @endif  value="3"> عهدة</option>

                       </select>
                         @error('item_type')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>
                     </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="inv_itemcard_categories_id"> فئة الصنف</label>
                       <select name="inv_itemcard_categories_id" id="inv_itemcard_categories_id" class="form-control" >
                        <option value="">اختر الفئة</option>
                        @if(@isset($inv_itemcard_categories) && !@empty($inv_itemcard_categories) )
                        @foreach ($inv_itemcard_categories as $info )
                        <option @if (old('inv_itemcard_categories_id')==$info->id) selected = "selected" @endif  value="{{$info->id}}">{{$info->name}}</option>
                        @endforeach
                        @endif
                       </select>
                         @error('inv_itemcard_categories_id')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>
                     </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="parent_inv_itemcard_id">  الصنف الاب له</label>
                       <select name="parent_inv_itemcard_id" id="parent_inv_itemcard_id" class="form-control" >
                        <option selected value="0"> هو أب </option>
                        @if(@isset($inv_item_data) && !@empty($inv_item_data) )
                        @foreach ($inv_item_data as $info )
                        <option @if (old('parent_inv_itemcard_id')==$info->id) selected = "selected" @endif  value="{{$info->id}}">{{$info->name}}</option>
                        @endforeach
                        @endif
                       </select>
                         @error('parent_inv_itemcard_id')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>
                     </div>
                    <div class="col-md-6 " >
                    <div class="form-group">
                        <label for="uom_id">  وحدة القياس الأب</label>
                       <select name="uom_id" id="uom_id" class="form-control" >
                        <option value="">اختر وحدة القياس الأب</option>
                        @if(@isset($inv_uoms_parent) && !@empty($inv_uoms_parent) )
                        @foreach ($inv_uoms_parent as $info )
                        <option @if (old('uom_id')==$info->id) selected = "selected" @endif  value="{{$info->id}}">{{$info->name}}</option>
                        @endforeach
                        @endif
                       </select>
                         @error('uom_id')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="does_has_retailunit"> هل  للصنف وحدة تجزئة ابن</label>
                           <select name="does_has_retailunit" id="does_has_retailunit" class="form-control" >
                             <option value="">اختر الحالة</option>
                             <option @if (old('does_has_retailunit')==1) selected = "selected" @endif  value="1"> نعم</option>
                             <option @if (old('does_has_retailunit')==0 and old('does_has_retailunit')!= "") selected = "selected" @endif value="0"> لا </option>

                           </select>
                             @error('does_has_retailunit')
                             <span class="text-danger" >{{ $message }}</span>
                             @enderror
                         </div>
                         </div>
                         <div class="col-md-6" @if (old('does_has_retailunit')!=1)style="display: none;"@endif   id="retail_uom_idDiv">
                            <div class="form-group">
                                <label for="retail_uom_id">    وحدة قياس التجزئة الابن بالنسبة للأب(<span class="parentuomname"></span>)</label>
                               <select name="retail_uom_id" id="retail_uom_id" class="form-control" >
                                <option value="">اختر وحدة القياس التجزئة الأبن</option>
                                @if(@isset($inv_uoms_child) && !@empty($inv_uoms_child) )
                                @foreach ($inv_uoms_child as $info )
                                <option @if (old('retail_uom_id')==$info->id) selected = "selected" @endif  value="{{ $info->id }}">{{  $info->name }}</option>
                                @endforeach
                                @endif
                               </select>
                                 @error('retail_uom_id')
                                 <span class="text-danger" >{{ $message }}</span>
                                 @enderror
                             </div>
                             </div>
                             <div class="col-md-6 related_retail_counter" @if (old('retail_uom_id')== '')style="display: none;"@endif>
                             <div class="form-group">
                                <label for="retail_uom_quntToParent"> عدد وحدات التجزئة(<span class="childuomname"></span>) بالنسبة للاب(<span class="parentuomname"></span>)</label>
                                <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"  name="retail_uom_quntToParent" value="{{ old('retail_uom_quntToParent') }}"  id="retail_uom_quntToParent" class="form-control"  placeholder="أدخل عدد وحدات التجزئة" >
                                 @error('retail_uom_quntToParent')
                                 <span class="text-danger" >{{ $message }}</span>
                                 @enderror
                             </div>
                             </div>
                             <div class="col-md-6 related_parent_counter"  @if (old('uom_id')=='')style="display: none;"@endif>
                             <div class="form-group">
                                <label for="price"> السعر القطاعي بوحدة(<span class="parentuomname"></span>)</label>
                                <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"  name="price" value="{{ old('price') }}"  id="price" class="form-control"  placeholder="أدخل  السعر" >
                                 @error('price')
                                 <span class="text-danger" >{{ $message }}</span>
                                 @enderror
                             </div>
                             </div>
                             <div class="col-md-6 related_parent_counter" @if (old('uom_id')=='')style="display: none;"@endif>
                             <div class="form-group">
                                <label for="nos_gomla_price"> السعر نص جملة بوحدة(<span class="parentuomname"></span>)</label>
                                <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"  name="nos_gomla_price" value="{{ old('nos_gomla_price') }}"  id="nos_gomla_price" class="form-control"  placeholder="أدخل  السعر" >
                                 @error('nos_gomla_price')
                                 <span class="text-danger" >{{ $message }}</span>
                                 @enderror
                             </div>
                             </div>
                             <div class="col-md-6 related_parent_counter"  @if (old('uom_id')=='')style="display: none;"@endif>
                             <div class="form-group">
                                <label for="gomla_price"> السعر  جملة بوحدة(<span class="parentuomname"></span>)</label>
                                <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"  name="gomla_price" value="{{ old('gomla_price') }}"  id="gomla_price" class="form-control"  placeholder="أدخل  السعر" >
                                 @error('gomla_price')
                                 <span class="text-danger" >{{ $message }}</span>
                                 @enderror
                             </div>
                             </div>
                             <div class="col-md-6 related_parent_counter"  @if (old('uom_id')=='')style="display: none;"@endif>
                             <div class="form-group">
                                <label for="cost_price">  سعر تكلفة الشراء بوحدة(<span class="parentuomname"></span>)</label>
                                <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"  name="cost_price" value="{{ old('cost_price') }}"  id="cost_price" class="form-control"  placeholder="أدخل  السعر" >
                                 @error('cost_price')
                                 <span class="text-danger" >{{ $message }}</span>
                                 @enderror
                             </div>
                             </div>
                             <div class="col-md-6 related_retail_counter"  @if (old('retail_uom_id')=='')style="display: none;"@endif>
                                <div class="form-group">
                                   <label for="price_retail"> السعر القطاعي بوحدة(<span class="childuomname"></span>)</label>
                                   <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"  name="price_retail" value="{{ old('price') }}"  id="price_retail" class="form-control"  placeholder="أدخل  السعر" >
                                    @error('price_retail')
                                    <span class="text-danger" >{{ $message }}</span>
                                    @enderror
                                </div>
                                </div>
                                <div class="col-md-6 related_retail_counter"  @if (old('retail_uom_id')=='')style="display: none;"@endif>
                                    <div class="form-group">
                                       <label for="nos_gomla_price_retail"> السعر نص جملة بوحدة(<span class="childuomname"></span>)</label>
                                       <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"  name="nos_gomla_price_retail" value="{{ old('nos_gomla_price_retail') }}"  id="nos_gomla_price_retail" class="form-control"  placeholder="أدخل  السعر" >
                                        @error('nos_gomla_price_retail')
                                        <span class="text-danger" >{{ $message }}</span>
                                        @enderror
                                    </div>
                                    </div>
                                    <div class="col-md-6 related_retail_counter"  @if (old('retail_uom_id')=='')style="display: none;"@endif>
                                        <div class="form-group">
                                           <label for="gomla_price_retail"> السعر  جملة بوحدة(<span class="childuomname"></span>)</label>
                                           <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"  name="gomla_price_retail" value="{{ old('gomla_price_retail') }}"  id="gomla_price_retail" class="form-control"  placeholder="أدخل  السعر" >
                                            @error('gomla_price_retail')
                                            <span class="text-danger" >{{ $message }}</span>
                                            @enderror
                                        </div>
                                        </div>
                                        <div class="col-md-6 related_retail_counter"  @if (old('retail_uom_id')=='')style="display: none;"@endif>
                                            <div class="form-group">
                                               <label for="cost_price_retail">   سعر تكلفة الشراء بوحدة(<span class="childuomname"></span>)</label>
                                               <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"  name="cost_price_retail" value="{{ old('cost_price_retail') }}"  id="cost_price_retail" class="form-control"  placeholder="أدخل  السعر" >
                                                @error('cost_price_retail')
                                                <span class="text-danger" >{{ $message }}</span>
                                                @enderror
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="has_fixed_price">  هل للصنف سعر ثابت</label>
                                                  <select name="has_fixed_price" id="has_fixed_price" class="form-control" >
                                                    <option value="">اختر الحالة</option>
                                                    <option @if (old('has_fixed_price')==1) selected = "selected" @endif  value="1">نعم ثابت ولايتغير بالفواتير</option>
                                                    <option @if (old('has_fixed_price')==0 and old('has_fixed_price')!= "") selected = "selected" @endif value="0"> لا وقابل للتغير بالفواتير </option>
                                                  </select>
                                                    @error('has_fixed_price')
                                                    <span class="text-danger" >{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                </div>

                     <div class="col-md-6">
                     <div class="form-group">
                        <label for="active"> حالة التفعيل</label>
                       <select name="active" id="active" class="form-control" >
                         <option value="">اختر الحالة</option>
                         <option @if (old('active')==1) selected = "selected" @endif  value="1"> مفعل</option>
                         <option @if (old('active')==0 and old('active')!= "") selected = "selected" @endif value="0"> معطل </option>
                       </select>
                         @error('active')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>
                     </div>

                     <div class="col-md-6" style="border:solid 5px #000 ; margin:10px">
                        <div class="form-group">
                           <label for="item_image">  صورة الصنف ان وجدت</label>
                           <img src="#" id="imageuploaded" alt="imageuploaded" style="width: 200px ; width:200px">
                             <input onchange="readURL(this)" type="file" name="item_image" id="item_image" class="form-control">
                            @error('item_image')
                            <span class="text-danger" >{{ $message }}</span>
                            @enderror
                        </div>
                        </div>


                    </div>
                    <div class="col-md-12">
                     <div class="form-group text-center">
                        <button id="do_add_item_dd" type="submit" class="btn btn-sm btn-primary"> اضافة</button>
                        <a href="{{ route('admin.stores.index') }}" class="btn btn-sm btn-danger" >الغاء</a>
                      </div>
                      </div>


                     </div>
                    </form>



                </div>

    </div>
@endsection





@section('script')
<script src="{{ asset('admin_assets/js/inv_itemcard.js')}}"></script>
<script>
   var uom_id =   $("#uom_id").val();
if(uom_id!=""){
    var name =   $("#uom_id option:selected ").text();
    $(".parentuomname").text(name);

}
var uom_id_retail =   $("#retail_uom_id").val();
if(uom_id_retail!=""){
    var name =   $("#retail_uom_id option:selected ").text();
      $(".childuomname").text(name);

}





</script>
@endsection
