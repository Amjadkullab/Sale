@extends('layouts.master')
@section('title', ' المشتريات')
@section('contentheader', 'حركات مخزنية')
@section('contentheaderlink')
    <a href="{{ route('admin.supplier_order.index') }}"> فواتير المشتريات</a>
@endsection
@section('contentheaderactive', 'اضافة')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">اضافة فاتورة مشتريات من مورد</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                     <form action= {{ route('admin.supplier_order.store') }} method="POST" >
                      @csrf


                      <div class="form-group">
                        <label for="order_date">تاريخ الفاتورة </label>
                        <input type="date" name="order_date" id="order_date" value="@php echo date("Y-m-d"); @endphp" class="form-control" style="text-align:right;direction:rtl!important;"  placeholder="أدخل  الملاحظات">
                    @error('order_date')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                      <div class="form-group">
                        <label for="DOC_NO">رقم الفاتورة المسجل بأصل فاتورة المشتريات</label>
                        <input type="text" name="DOC_NO" id="DOC_NO" value="{{ old('DOC_NO') }}" class="form-control" style="text-align:right;direction:rtl!important;"  placeholder="أدخل  الملاحظات">
                    @error('DOC_NO')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

               <div class="col-md-6">
                <div class="form-group">
                    <label for="supplier_code">بيانات الموردين</label>
                    <select name="supplier_code" id="supplier_code">
            <option value="">اختر المورد</option>
            @if(@isset($suppliers) && !empty($suppliers))
                @foreach ($suppliers as $info )
                 <option @if (old('supplier_code')==$info->supplier_code) selected="selected" @endif value="{{ $info->supplier_code }}">{{ $info->name }}</option>
                @endforeach
                    </select>
                    @error('supplier_code')
                    <span class="text-denger">{{ $messsage }}</span>
                    @enderror
                </div>
               </div>


                    <div class="form-group">
                        <label for="pill_type"> نوع الفاتورة</label>
                       <select name="pill_type" id="pill_type" class="form-control" >
                         <option value="">اختر النوع</option>
                         <option @if (old('pill_type')==1) selected = "selected" @endif  value="1"> كاش </option>
                         <option @if (old('pill_type')== 2 )selected = "selected" @endif value="2">  أجل </option>
                       </select>
                         @error('pill_type')
                         <span class="text-danger" >{{ $message }}</span>
                         @enderror
                     </div>
                    <div class="form-group">
                        <label for="notes">ملاحظات </label>
                        <input type="text" name="notes" id="notes" value="{{ old('notes') }}" class="form-control" placeholder="أدخل  الملاحظات">
                    @error('notes')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                    </div>

                     <div class="form-group text-center">
                        <button type="submit" class="btn btn-sm btn-primary"> اضافة</button>
                        <a href="{{ route('admin.supplier_order.index') }}" class="btn btn-sm btn-danger" >الغاء</a>
                      </div>



                    </form>



                </div>
            </div>
        </div>
    </div>
@endsection
