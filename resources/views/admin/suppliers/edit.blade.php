@extends('layouts.master')
@section('title', '  الموردين')
@section('contentheader',  ' الحسابات ')
@section('contentheaderlink')
    <a href="{{ route('admin.supplier.index') }}"> الموردين</a>
@endsection
@section('contentheaderactive', 'تعديل')

@section('content')


            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">تعديل بيانات  المورد </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                     <form action= {{ route('admin.supplier.update',$data['id']) }} method="POST" >
                      @csrf
                      <div class="row">



                        <div class="col-md-6">
                            <div class="form-group">
                             <label for="name"> اسم  المورد</label>
                             <input  name="name" id="name" class="form-control" value="{{old('name',$data['name'])}}"  >
                              @error('name')
                              <span class="text-danger" >{{ $message }}</span>
                              @enderror
                          </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="supplier_categories_id"> فئة المورد</label>
                               <select name="supplier_categories_id" id="supplier_categories_id" class="form-control" >
                                <option value="">اختر الفئة</option>
                                @if(@isset($supplier_categories) && !@empty($supplier_categories) )
                                @foreach ($supplier_categories as $info )
                                <option {{old('supplier_categories_id',$data['supplier_categories_id'])==$info->id ? 'selected' : ''  }}   value="{{$info->id}}">{{$info->name}}</option>
                                @endforeach
                                @endif
                               </select>
                                 @error('supplier_categories_id')
                                 <span class="text-danger" >{{ $message }}</span>
                                 @enderror
                             </div>
                             </div>
                          {{-- <div class="col-md-6">
                            <div class="form-group">
                             <label for="customer_code  "> كود  العميل</label>
                             <input  name="customer_code" id="customer_code" class="form-control" value="{{old('customer_code')}}"  >
                              @error('customer_code')
                              <span class="text-danger" >{{ $message }}</span>
                              @enderror
                          </div>
                          </div> --}}

                          {{-- <div class="col-md-6">
                          <div class="form-group">
                              <label for="account_types_id">  نوع الحساب</label>
                             <select name="account_types_id" id="account_types_id" class="form-control" >
                              <option value="">اختر النوع</option>
                              @if(@isset($account_type) && !@empty($account_type) )
                              @foreach ($account_type as $info )
                              <option @if (old('account_types_id')==$info->id) selected = "selected" @endif  value="{{$info->id}}">{{$info->name}}</option>
                              @endforeach
                              @endif
                             </select>
                               @error('account_types_id')
                               <span class="text-danger" >{{ $message }}</span>
                               @enderror
                           </div>
                           </div> --}}


                                <div class="col-md-6">
                                  <div class="form-group">
                                   <label for="address">   العنوان</label>
                                   <input  name="address" id="address" class="form-control" value="{{old('address',$data['address'])}}"  >
                                    @error('address')
                                    <span class="text-danger" >{{ $message }}</span>
                                    @enderror
                                </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                   <label for="notes">   ملاحظات</label>
                                   <input  name="notes" id="notes" class="form-control" value="{{old('notes',$data['notes'])}}"  >
                                    @error('notes')
                                    <span class="text-danger" >{{ $message }}</span>
                                    @enderror
                                </div>
                                </div>
                           <div class="col-md-6">
                           <div class="form-group">
                              <label for="active"> حالة التفعيل</label>
                             <select name="active" id="active" class="form-control" >
                               <option value="">اختر الحالة</option>
                               <option {{ old('active',$data['active'])==1 ? 'selected' :''}}   value="1"> مفعل</option>
                               <option {{ old('active',$data['active'])==0 ? 'selected' :''}}  value="0"> معطل </option>
                             </select>
                               @error('active')
                               <span class="text-danger" >{{ $message }}</span>
                               @enderror
                           </div>
                           </div>



                    </div>
                    <div class="col-md-12">
                     <div class="form-group text-center">
                        <button id="do_add_item_dd" type="submit" class="btn btn-sm btn-primary"> تعديل</button>
                        <a href="{{ route('admin.supplier.index') }}" class="btn btn-sm btn-danger" >الغاء</a>
                      </div>
                      </div>


                     </div>
                    </form>



                </div>

    </div>
@endsection



@section('script')
<script src="{{ asset('admin_assets/js/customers.js')}}"></script>







@endsection
