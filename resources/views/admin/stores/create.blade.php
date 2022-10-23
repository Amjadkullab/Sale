@extends('layouts.master')
@section('title', 'اضافة مخزن جديد')
@section('contentheader', ' المخازن ')
@section('contentheaderlink')
    <a href="{{ route('admin.stores.index') }}"> المخازن</a>
@endsection
@section('contentheaderactive', 'اضافة')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">اضافة مخزن جديد</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                     <form action= {{ route('admin.stores.store') }} method="POST" >
                      @csrf

                      <div class="form-group">
                       <label for="name">اسم المخزن</label>
                       <input  name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="أدخل اسم المخزن" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">
                        @error('name')
                        <span class="text-danger" >{{ $message }}</span>
                        @enderror
                    </div>
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
                     <div class="form-group">
                        <label for="name">هاتف المخزن</label>
                        <input  name="phones" id="phones" class="form-control" value="{{ old('phones') }}" placeholder="أدخل  الهاتف" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">
                         @error('phones')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>
                     <div class="form-group">
                        <label for="name">عنوان المخزن</label>
                        <input  name="address" id="address" class="form-control" value="{{ old('address') }}" placeholder="أدخل  العنوان" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">
                         @error('address')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>

                    </div>

                     <div class="form-group text-center">
                        <button type="submit" class="btn btn-sm btn-primary"> اضافة</button>
                        <a href="{{ route('admin.stores.index') }}" class="btn btn-sm btn-danger" >الغاء</a>
                      </div>



                    </form>



                </div>
            </div>
        </div>
    </div>
@endsection
