@extends('layouts.master')
@section('title', '   تعديل حساب مالي')
@section('contentheader', 'الحسابات المالية')
@section('contentheaderlink')
    <a href="{{ route('admin.accounts.index') }}">الحسابات المالية</a>
@endsection
@section('contentheaderactive', 'اضافة')

@section('content')


            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">تعديل حساب مالي </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                     <form action= {{ route('admin.accounts.update',$data['id']) }} method="POST" >
                      @csrf
                      <div class="row">


                    <div class="col-md-6">
                      <div class="form-group">
                       <label for="name"> اسم الحساب المالي</label>
                       <input  name="name" id="name" class="form-control" value="{{old('name',$data['name'])}}"  >
                        @error('name')
                        <span class="text-danger" >{{ $message }}</span>
                        @enderror
                    </div>
                    </div>

                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="account_types_id">  نوع الحساب</label>
                       <select name="account_types_id" id="account_types_id" class="form-control" >
                        <option value="">اختر النوع</option>
                        @if(@isset($account_type) && !@empty($account_type) )
                        @foreach ($account_type as $info )
                        <option {{old('account_type',$data['account_types_id'])==$info->id ? 'selected':''}}  value="{{$info->id}}">{{$info->name}}</option>
                        @endforeach
                        @endif
                       </select>
                         @error('account_types_id')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>
                     </div>


                     <div class="col-md-6">
                     <div class="form-group">
                        <label for="is_parent">  هل الحساب أب</label>
                       <select name="is_parent" id="is_parent" class="form-control" >
                         <option value="">اختر الحالة</option>
                         <option  {{old('is_parent',$data['is_parent'])== 1 ? 'selected':''}}   value="1"> نعم</option>
                         <option  {{old('is_parent',$data['is_parent'])== 0 ? 'selected':''}}  value="0"> لا </option>
                       </select>
                         @error('is_parent')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>
                     </div>


                     <div class="col-md-6" id="parentDiv" @if(old('is_parent',$data['is_parent'])==1) style="display: none;" @endif>
                        <div class="form-group">
                            <label for="parent_account_number ">  الحسابات الأب </label>
                           <select name="parent_account_number " id="parent_account_number " class="form-control" >
                            <option value="">اختر الحساب الاب</option>
                            @if(@isset($parent_accounts) && !@empty($parent_accounts) )
                            @foreach ($parent_accounts as $info )
                            <option {{old('parent_account_number',$data['parent_account_number'])== $info->account_number ? 'selected':''}}   value="{{$info->account_number}}">{{$info->name}}</option>
                            @endforeach
                            @endif
                           </select>
                             @error('parent_account_number')
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
                        <label for="is_archived"> حالة التفعيل</label>
                       <select name="is_archived" id="is_archived" class="form-control" >
                         <option value="">اختر الحالة</option>
                         <option  {{old('is_archived',$data['is_archived'])== 1 ? 'selected':''}}   value="1"> مفعل</option>
                         <option {{old('is_archived',$data['is_archived'])== 0 ? 'selected':''}}  value="0"> معطل </option>
                       </select>
                         @error('is_archived')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>
                     </div>



                    </div>
                    <div class="col-md-12">
                     <div class="form-group text-center">
                        <button id="do_add_item_dd" type="submit" class="btn btn-sm btn-primary"> تعديل</button>
                        <a href="{{ route('admin.accounts.index') }}" class="btn btn-sm btn-danger" >الغاء</a>
                      </div>
                      </div>


                     </div>
                    </form>



                </div>

    </div>
@endsection



@section('script')
<script src="{{ asset('admin_assets/js/accounts.js')}}"></script>







@endsection
