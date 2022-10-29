@extends('layouts.master')
@section('title', '  العملاء')
@section('contentheader',  ' الحسابات المالية')
@section('contentheaderlink')
    <a href="{{ route('admin.customer.index') }}"> العملاء</a>
@endsection
@section('contentheaderactive', 'عرض')

@section('content')

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات  العملاء</h3>
                    <input type="hidden" id="search_token" value="{{csrf_token()}}">
                    <input type="hidden" id="ajax_search_url" value="{{route('admin.customer.ajax_search')}}">
                <a href="{{ route('admin.customer.create') }}" class="btn btn-sm btn-success">اضافة جديد</a>

                </div>

                <!-- /.card-header -->

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4">

                            <input  type="radio" checked name="searchbyradio" id="searchbyradio" value="account_number">بحث برقم الحساب
                            <input  type="radio" checked name="searchbyradio" id="searchbyradio" value="customer_code">بحث برقم العميل
                            <input  type="radio" name="searchbyradio" id="searchbyradio" value="name">بالاسم
                            <input style="margin-top: 8px !important;" type="text" id="search_by_text" class="form-control" placeholder=" -كود العميل اسم- رقم الحساب"> <br>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-md-12">


                        <div id="ajax_responce_searchDiv">
                            @if (@isset($data) && !@empty($data) && count($data)>0)

                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="custom_thead">

                                    <th>اسم</th>
                                    <th>الكود</th>
                                    <th>رقم الحساب</th>
                                    <th> الرصيد</th>
                                    <th> حالة التفعيل</th>

                                    <th></th>
                                    {{-- <th>تاريخ الاضافة</th>
                                    <th>تاريخ التحديث</th> --}}
                                </thead>
                                <tbody>
                                    @foreach ($data as $info)
                                        <tr>
                                            <td>{{ $info->name }}</td>
                                            <td>{{ $info->customer_code}}</td>
                                            <td>{{$info->account_number}}</td>
                                            <td></td>
                                            <td> @if ($info->active == 1)مفعلة  @else معطل @endif</td>
                                            <td>
                                              <a href="{{route('admin.customer.edit',$info->id)}}" class="btn btn-sm btn-primary">تعديل</a>
                                                <a href="{{ route('admin.customer.delete',$info->id) }}" class="btn btn-sm btn-danger are_you_sure">حذف</a>
                                                <a href="{{ route('admin.customer.show',$info->id) }}" class="btn btn-sm btn-info ">عرض</a>
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
@section('script')
<script src="{{asset('admin_assets/js/customers.js')}}"></script>

@endsection
