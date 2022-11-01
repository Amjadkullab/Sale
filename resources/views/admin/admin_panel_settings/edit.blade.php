@extends('layouts.master')
@section('title', 'تعديل الضبط العام')
@section('contentheader', 'الضبط ')
@section('contentheaderlink')
    <a href="{{ route('admin.adminpanelsetting.index') }}">الضبط</a>
@endsection
@section('contentheaderactive', 'تعديل')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">تعديل بيانات الضبط العام</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (@isset($data) && !@empty($data))
                     <form action="{{ route('admin.adminpanelsetting.update') }}" method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group">
                       <label for="system_name">اسم الشركة</label>
                       <input type="text" name="system_name" id="system_name" class="form-control" value="{{ $data['system_name'] }}" placeholder="أدخل اسم الشركة" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">
                        @error('system_name')
                        <span class="text-danger" >{{ $message }}</span>
                        @enderror
                    </div>
                      <div class="form-group">
                       <label for="address">عنوان الشركة</label>
                       <input type="text" name="address" id="address" class="form-control" value="{{ $data['address'] }}" placeholder="أدخل عنوان الشركة" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">
                       @error('address')
                       <span class="text-danger" >{{ $message }}</span>
                       @enderror

                    </div>
                      <div class="form-group">
                       <label for="phone">هاتف الشركة</label>
                       <input type="text" name="phone" id="phone" class="form-control" value="{{ $data['phone'] }}" placeholder="أدخل هاتف الشركة" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">
                       @error('phone')
                       <span class="text-danger" >{{ $message }}</span>
                       @enderror
                    </div>

                        <div class="form-group">
                            <label for="customer_parent_account_number">  الحساب الأب للعملاء بالشجرة المحاسبية </label>
                           <select name="customer_parent_account_number" id="customer_parent_account_number" class="form-control" >
                            <option value="">اختر الحساب </option>
                            @if(@isset($parent_accounts) && !@empty($parent_accounts) )
                            @foreach ($parent_accounts as $info )
                            <option @if (old('customer_parent_account_number',$data['customer_parent_account_number'])==$info->account_number) selected = "selected" @endif  value="{{$info->account_number}}">{{$info->name}}</option>
                            @endforeach
                            @endif
                           </select>
                             @error('customer_parent_account_number ')
                             <span class="text-danger" >{{ $message }}</span>
                             @enderror
                         </div>
                        <div class="form-group">
                            <label for="supplier_parent_account_number">  الحساب الأب للموردين بالشجرة المحاسبية </label>
                           <select name="supplier_parent_account_number" id="supplier_parent_account_number" class="form-control" >
                            <option value="">اختر الحساب </option>
                            @if(@isset($parent_accounts) && !@empty($parent_accounts) )
                            @foreach ($parent_accounts as $info )
                            <option @if (old('supplier_parent_account_number',$data['supplier_parent_account_number'])==$info->account_number) selected = "selected" @endif  value="{{$info->account_number}}">{{$info->name}}</option>
                            @endforeach
                            @endif
                           </select>
                             @error('supplier_parent_account_number ')
                             <span class="text-danger" >{{ $message }}</span>
                             @enderror
                         </div>

                      <div class="form-group">
                       <label for="general_alert">رسالة التنبيه اعلى الشاشة</label>
                       <input type="text" name="general_alert" id="general_alert" class="form-control" value="{{ $data['general_alert'] }}" placeholder="أدخل رسالة التنبيه اعلى الشاشة " oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">
                      </div>
                      <div class="form-group">
                        <label>شعار الشركة</label>
                    <div class="image">
                        <img class="custom_img" src="{{ asset('admin_assets/uploads').'/'. $data['photo'] }}" alt=" لوجو الشركة">
                        <button type="button" class="btn btn-sm btn-danger" id="update_image">تغيير الصورة</button>
                        <button type="button" class="btn btn-sm btn-danger" style="display:none;" id="cancel_update_image"> الغاء</button>
                    </div>
                    <div id="old_image">

                    </div>
                      </div>




                      <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-sm">حفظ التعديلات</button>
                      </div>

                    </form>

                    @else
                        <div class="alert alert-danger"> عفوا لا توجد بيانات لعرضها !!</div>

                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
