@extends('layouts.master')
@section('title', 'الضبط العام')
@section('contentheader', 'فئات الأصناف ')
@section('contentheaderlink')
    <a href="{{ route('inv_itemcard_categories.index') }}">فئات الأصناف</a>
@endsection
@section('contentheaderactive', 'تعديل')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">تعديل بيانات فئة الأصناف </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (@isset($data) && !@empty($data))
                     <form action="{{ route('inv_itemcard_categories.update', $data['id']) }}" method="post" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div class="form-group">
                        <label for="name">اسم فئة الصنف</label>
                        <input  name="name" id="name" class="form-control" value="{{ old('name',$data['name']) }}" placeholder="أدخل اسم فئة الصنف" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">
                         @error('name')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>

                     <div class="form-group">
                        <label for="active"> حالة التفعيل</label>
                       <select name="active" id="active" class="form-control" >
                         <option value="">اختر الحالة</option>
                         <option {{ old('active',$data['active'])==1 ?'selected ': '' }} value="1"> نعم</option>
                         <option {{ old('active',$data['active'])==0? 'selected':''}}    value="0">لا </option>

                       </select>
                         @error('active')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>
                      </div>


                      <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-sm">حفظ التعديلات</button>
                        <a href="{{ route('inv_itemcard_categories.index') }}" class="btn btn-sm btn-danger">الغاء</a>
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
