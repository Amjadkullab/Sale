@extends('layouts.master')
@section('title', 'تعديل بيانات الخزنة ')
@section('contentheader', 'الخزن ')
@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}">الخزن</a>
@endsection
@section('contentheaderactive', 'تعديل')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">تعديل بيانات الخزن</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (@isset($data) && !@empty($data))
                     <form action="{{ route('admin.treasuries.update', $data['id']) }}" method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group">
                        <label for="name">اسم الخزنة</label>
                        <input  name="name" id="name" class="form-control" value="{{ old('name',$data['name']) }}" placeholder="أدخل اسم الخزنة" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">
                         @error('name')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>
                       <div class="form-group">
                        <label for="is_master">هل رئيسية</label>
                       <select name="is_master"  id="is_master" class="form-control" >
                         <option value="">اختر النوع</option>
                         <option {{  old('is_master',$data['is_master'])==1 ?'selected ': '' }} value="1"> نعم</option>
                         <option {{ old('is_master',$data['is_master'])==0? 'selected':''}}    value="0">لا </option>
                       </select>
                         @error('is_master')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>
                     <div class="form-group">
                         <label for="last_isal_exchange">اخر رقم ايصال صرف نقدية لهده الخزنة </label>
                         <input oninput="this.value=this.value.replace(/[^0-9]/g ,'');"  name="last_isal_exchange" value="{{ old('last_isal_exchange',$data['last_isal_exchange']) }}" id="last_isal_exchange" class="form-control"  placeholder="أدخل اخر رقم صرف نقدية لهده الخزنة" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">
                          @error('last_isal_exchange')
                          <span class="text-danger" >{{ $message }}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                         <label for="last_isal_collect">اخر رقم ايصال تحصيل نقدية لهده الخزنة </label>
                         <input oninput="this.value=this.value.replace(/[^0-9]/g ,'');"  name="last_isal_collect" value="{{ old('last_isal_collect',$data['last_isal_collect']) }}" id="last_isal_collect" class="form-control"  placeholder="أدخل اخر رقم تحصيل نقدية لهده الخزنة" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">
                          @error('last_isal_collect')
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
                        <a href="{{ route('admin.treasuries.index') }}" class="btn btn-sm btn-danger">الغاء</a>
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
