@extends('layouts.master')
@section('title', '   اضافة حساب عميل')
@section('contentheader', 'الحسابات المالية')
@section('contentheaderlink')
    <a href="{{ route('admin.customer.index') }}"> العملاء</a>
@endsection
@section('contentheaderactive', 'اضافة')

@section('content')


            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">اضافة حساب عميل جديد</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                     <form action= {{ route('admin.customer.store') }} method="POST" >
                      @csrf
                      <div class="row">


                    <div class="col-md-6">
                      <div class="form-group">
                       <label for="name"> اسم  العميل</label>
                       <input  name="name" id="name" class="form-control" value="{{old('name')}}"  >
                        @error('name')
                        <span class="text-danger" >{{ $message }}</span>
                        @enderror
                    </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                       <label for="code"> كود  العميل</label>
                       <input  name="code" id="code" class="form-control" value="{{old('code')}}"  >
                        @error('code')
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
                        <option @if (old('account_types_id')==$info->id) selected = "selected" @endif  value="{{$info->id}}">{{$info->name}}</option>
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
                             <label for="start_balance_status">   حالة رصيد أول المدة</label>
                             <select name="start_balance_status" id="start_balance_status" class="form-control" >
                                <option value="">اختر الحالة</option>
                                <option @if (old('start_balance_status')==1) selected = "selected" @endif  value="1"> دائن</option>
                                <option @if (old('start_balance_status')==2 ) selected = "selected" @endif value="2"> مدين </option>
                                <option @if (old('start_balance_status')==3) selected = "selected" @endif value="3"> متزن </option>
                              </select>
                              @error('start_balance_status')
                              <span class="text-danger" >{{ $message }}</span>
                              @enderror
                          </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                             <label for="start_balance">   رصيد اول المدة للحساب</label>
                             <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"  name="start_balance" id="start_balance" class="form-control" value="{{old('start_balance')}}"  >
                              @error('start_balance')
                              <span class="text-danger" >{{ $message }}</span>
                              @enderror
                          </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                             <label for="address">   العنوان</label>
                             <input  name="address" id="address" class="form-control" value="{{old('address')}}"  >
                              @error('address')
                              <span class="text-danger" >{{ $message }}</span>
                              @enderror
                          </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                             <label for="notes">   ملاحظات</label>
                             <input  name="notes" id="notes" class="form-control" value="{{old('notes')}}"  >
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
                         <option @if (old('active')==1) selected = "selected" @endif  value="1"> مفعل</option>
                         <option @if (old('active')==0 and old('active')!= "") selected = "selected" @endif value="0"> معطل </option>
                       </select>
                         @error('active')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>
                     </div>



                    </div>
                    <div class="col-md-12">
                     <div class="form-group text-center">
                        <button id="do_add_item_dd" type="submit" class="btn btn-sm btn-primary"> اضافة</button>
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
