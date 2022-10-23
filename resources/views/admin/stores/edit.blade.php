@extends('layouts.master')
@section('title', 'تعديل بيانات المخزن ')
@section('contentheader', 'المخازن')
@section('contentheaderlink')
    <a href="{{ route('admin.stores.index') }}">المخازن </a>
@endsection
@section('contentheaderactive', 'تعديل')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">تعديل  بيانات المخزن </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (@isset($data) && !@empty($data))
                     <form action="{{ route('admin.stores.update', $data['id']) }}" method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group">
                        <label for="name">اسم المخزن</label>
                        <input  name="name" id="name" class="form-control" value="{{ old('name',$data['name']) }}" placeholder="أدخل اسم المخزن" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">
                         @error('name')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>

                     <div class="form-group">
                        <label for="active"> حالة التفعيل</label>
                       <select name="active" id="active" class="form-control" >
                         <option value="">اختر الحالة</option>
                         <option {{  old('active',$data['active'])==1 ?'selected ': '' }} value="1"> نعم</option>
                         <option {{ old('active',$data['active'])==0? 'selected':''}}    value="0">لا </option>

                       </select>
                         @error('active')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>
                      <div class="form-group">
                        <label for="phones">هاتف المخزن</label>
                        <input  name="phones" id="phones" class="form-control" value="{{ old('phones',$data['phones']) }}" placeholder="أدخل هاتف المخزن" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">
                         @error('phones')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>
                      <div class="form-group">
                        <label for="address">عنوان المخزن</label>
                        <input  name="address" id="address" class="form-control" value="{{ old('address',$data['address']) }}" placeholder="أدخل عنوان المخزن" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">
                         @error('address')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>

                      </div>


                      <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-sm">حفظ التعديلات</button>
                        <a href="{{ route('admin.stores.index') }}" class="btn btn-sm btn-danger">الغاء</a>
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
