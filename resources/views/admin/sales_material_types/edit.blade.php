@extends('layouts.master')
@section('title', 'تعديل بيانات فئة الفاتورة ')
@section('contentheader', 'فئات الفواتير ')
@section('contentheaderlink')
    <a href="{{ route('admin.sales_material_type.index') }}">فئات الفواتير</a>
@endsection
@section('contentheaderactive', 'تعديل')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">تعديل فئة الفاتورة </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (@isset($data) && !@empty($data))
                     <form action="{{ route('admin.sales_material_type.update', $data['id']) }}" method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group">
                        <label for="name">اسم فئة الفاتورة</label>
                        <input  name="name" id="name" class="form-control" value="{{ old('name',$data['name']) }}" placeholder="أدخل اسم الخزنة" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">
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
                      </div>


                      <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-sm">حفظ التعديلات</button>
                        <a href="{{ route('admin.sales_material_type.index') }}" class="btn btn-sm btn-danger">الغاء</a>
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
