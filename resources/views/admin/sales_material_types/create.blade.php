@extends('layouts.master')
@section('title', ' اضافة فئة فواتير جديدة ')
@section('contentheader', 'فئات الفواتير ')
@section('contentheaderlink')
    <a href="{{ route('admin.sales_material_type.index') }}">فئات الفواتير</a>
@endsection
@section('contentheaderactive', 'اضافة')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">اضافة فئة فواتير جديدة</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                     <form action= {{ route('admin.sales_material_type.store') }} method="POST" >
                      @csrf

                      <div class="form-group">
                       <label for="name">اسم فئة الفواتير</label>
                       <input  name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="أدخل اسم فئة الفواتير" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">
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


                    </div>

                     <div class="form-group text-center">
                        <button type="submit" class="btn btn-sm btn-primary"> اضافة</button>
                        <a href="{{ route('admin.sales_material_type.index') }}" class="btn btn-sm btn-danger" >الغاء</a>
                      </div>



                    </form>



                </div>
            </div>
        </div>
    </div>
@endsection
