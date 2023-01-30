@extends('layouts.master')
@section('title', ' شاشة تحصيل النقدية')
@section('contentheader', 'الحسابات ')
@section('contentheaderlink')
    <a href="{{ route('admin.collect_transaction.index') }}">شاشة تجصيل النقدية</a>
@endsection
@section('contentheaderactive', 'عرض')
@section("css")
<link rel="stylesheet" href="{{ asset('admin_assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات حركة تحصيل النقدية في النظام</h3>
                    <input type="hidden" id="search_token" value="{{csrf_token() }}">
                {{-- <a href="{{ route('admin.collect_transaction.create') }}" class="btn btn-sm btn-success">تحصيل جديد</a> --}}

                </div>

                <!-- /.card-header -->

                <div class="card-body">
                    @if(!empty($checkExistsopenshifts))

                    <form action= {{ route('admin.supplier.store') }} method="POST" class="custom-form" >
                        @csrf
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                   <label for="move_date">تاريخ الحركة  </label>
                                   <input type="date"  name="move_date" value="{{ old('move_date',date("Y-m-d")) }}"  id="money" class="form-control" >
                                    @error('move_date')
                                    <span class="text-danger" >{{ $message }}</span>
                                    @enderror
                                </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="account_number">الحسابات المالية</label>
                                        <select name="account_number" id="account_number" class="form-control select2">
                                            <option value="">اختر الحساب المالي المحصل منه</option>
                                            @if(@isset($accounts) && !@empty($accounts) )
                                            @foreach ($accounts as $info )
                                            <option @if (old('account_number')==$info->account_number) selected = "selected" @endif value="{{ $info->account_number }}">{{$info->name  }}</option>
                                            @endforeach
                                            @endif
                                        </select>

                                    </div>
                                   </div>
                                   <div class="col-md-4" id="AcountStatusDiv"></div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="treasuries_id">  بيانات الخزن </label>
                             <select name="treasuries_id" id="treasuries_id" class="form-control" >


                              <option value="{{$checkExistsopenshifts['treasuries_id']}}">{{$checkExistsopenshifts['treasuries_name']}}</option>

                             </select>
                               @error('treasuries_id')
                               <span class="text-danger" >{{ $message }}</span>
                               @enderror
                           </div>
                           </div>

                           <div class="col-md-4">
                            <div class="form-group">
                               <label for="treasuries_balance">  الرصيد المتاح في الخزنة</label>
                               <input readonly  name="treasuries_balance" value="{{ old('treasuries_balance') }}"  id="treasuries_balance" class="form-control" >
                                @error('treasuries_balance')
                                <span class="text-danger" >{{ $message }}</span>
                                @enderror
                            </div>
                            </div>

                           <div class="col-md-4">
                            <div class="form-group">
                               <label for="money">قيمة المبلغ المحصل</label>
                               <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"  name="money" value="{{ old('money') }}"  id="money" class="form-control" >
                                @error('money')
                                <span class="text-danger" >{{ $message }}</span>
                                @enderror
                            </div>
                            </div>


                            <div class="col-md-6">
                              <div class="form-group">
                               <label for="byan">   البيان</label>
                               <textarea name="byan" id="byan"  cols="10" rows="4" class="form-control"></textarea>
                                @error('byan')
                                <span class="text-danger" >{{ $message }}</span>
                                @enderror
                            </div>
                            </div>




                      </div>
                      <div class="col-md-12">
                       <div class="form-group text-center">
                          <button id="do_add_item_dd" type="submit" class="btn btn-sm btn-success"> تحصيل</button>
                        </div>
                        </div>


                       </div>
                      </form>
                      @else
                      <div class="alert alert-warning" style="color: brown !important">
!!تنبيه لا يوجد شفت مفتوح  لك  لكي تتمكن من التحصيل
                       </div>
                      @endif

                        <div id="ajax_responce_searchDiv">
                            @if (@isset($data) && !@empty($data) && count($data)>0)
                            @php
                                $i = 1;
                            @endphp
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <th>مسلسل</th>
                                    <th>اسم الخزنة</th>
                                    <th>هل رئيسية</th>
                                    <th>اخر ايصال صرف</th>
                                    <th>اخر ايصال تحصيل</th>
                                    <th>حالة التفعيل</th>
                                    <th></th>
                                    {{-- <th>تاريخ الاضافة</th>
                                    <th>تاريخ التحديث</th> --}}
                                </thead>
                                <tbody>
                                    @foreach ($data as $info)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $info->name }}</td>
                                            <td>
                                                @if ($info->is_master == 1)رئيسية @else فرعية  @endif</td>
                                            <td>{{ $info->last_isal_exchange }}</td>
                                            <td>{{ $info->last_isal_collect }} </td>
                                            <td> @if ($info->active == 1)مفعلة  @else معطل @endif</td>
                                            <td>
                                              <a href="{{ route('admin.treasuries.edit',$info->id) }}" class="btn btn-sm btn-primary">تعديل</a>
                                                <a href="{{ route('admin.treasuries.details',$info->id) }}" class="btn btn-sm btn-info">المزيد</a>
                                            </td>


                                            {{-- <td> @php
                                                $dt = new DateTime($info->created_at);
                                                $date = $dt->format('Y-m-d');
                                                $time = $dt->format('h:i');
                                                $newDateTime = date('A', strtotime($time));
                                                $newDateTimeType = $newDateTime == 'AM' ? 'صباحا' : 'مساءا';
                                            @endphp
                                                {{ $date }}<br>
                                                {{ $time }}
                                                {{ $newDateTimeType }}<br>
                                                بواسطة
                                                {{ $info->added_by_name }}
                                            </td>
                                            <td>
                                                @if ($info->updated_by > 0 and $info->updated_by != null)

                                                    @php
                                                        $dt = new DateTime($info->updated_at);
                                                        $date = $dt->format('Y-m-d');
                                                        $time = $dt->format('h:i');
                                                        $newDateTime = date('A', strtotime($time));
                                                        $newDateTimeType = $newDateTime == 'AM' ? 'صباحا' : 'مساءا';
                                                    @endphp

                                                    {{ $date }} <br>
                                                    {{ $time }}
                                                    {{ $newDateTimeType }} <br>
                                                    بواسطة
                                                    {{ $info->updated_by_admin }}
                                                @else
                                                    لا يوجد تحديث
                                                @endif

                                            </td> --}}
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                   @endforeach
                                </tbody>
                            </table>
                            <br>
                            {{ $data->links() }}
                        @else
                            <div class="alert alert-danger"> عفوا لا توجد بيانات لعرضها !!</div>

                        @endif
                        </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
<script  src="{{asset('admin_assets/js/suppliers_orders.js')}}"> </script>

<script  src="{{ asset('admin_assets/plugins/select2/js/select2.full.min.js') }}"> </script>
<script>
    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    });
    </script>
@endsection
