@extends('layouts.master')
@section('title', ' اضافة خزنة جديدة ')
@section('contentheader', 'الخزن ')
@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}">الخزن</a>
@endsection
@section('contentheaderactive', 'اضافة')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">اضافة خزنة جديدة</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                     <form action= {{ route('admin.treasuries.store') }} method="POST" >
                      @csrf

                      <div class="form-group">
                       <label for="name">اسم الخزنة</label>
                       <input  name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="أدخل اسم الخزنة" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">
                        @error('name')
                        <span class="text-danger" >{{ $message }}</span>
                        @enderror
                    </div>
                      <div class="form-group">
                       <label for="is_master">هل رئيسية</label>
                      <select name="is_master"  id="is_master" class="form-control" >
                        <option value="">اختر النوع</option>
                        <option @if (old('is_master')==1) selected = "selected" @endif value="1"> نعم</option>
                        <option @if (old('is_master')==0 and old('is_master')!= "") selected = "selected" @endif   value="0">لا </option>
                      </select>
                        @error('is_master')
                        <span class="text-danger" >{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="last_isal_exchange">اخر رقم ايصال صرف نقدية لهده الخزنة </label>
                        <input oninput="this.value=this.value.replace(/[^0-9]/g ,'');"  name="last_isal_exchange" value="{{ old('last_isal_exchange') }}"  id="last_isal_exchange" class="form-control"  placeholder="أدخل اخر رقم صرف نقدية لهده الخزنة" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">
                         @error('last_isal_exchange')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>
                     <div class="form-group">
                        <label for="last_isal_collect">اخر رقم ايصال تحصيل نقدية لهده الخزنة </label>
                        <input oninput="this.value=this.value.replace(/[^0-9]/g ,'');"  name="last_isal_collect" value="{{ old('last_isal_collect') }}" id="last_isal_collect" class="form-control"  placeholder="أدخل اخر رقم تحصيل نقدية لهده الخزنة" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">
                         @error('last_isal_collect')
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
                        <button type="submit" class="btn btn-sm btn-primary">حفظ التعديلات</button>
                        <a href="{{ route('admin.treasuries.index') }}" class="btn btn-sm btn-danger" >الغاء</a>
                      </div>



                    </form>



                </div>
            </div>
        </div>
    </div>
@endsection
