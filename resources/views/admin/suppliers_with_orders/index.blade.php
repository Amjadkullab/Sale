@extends('layouts.master')
@section('title', ' المشتريات')
@section('contentheader', 'حركات مخزنية')
@section('contentheaderlink')
    <a href="{{ route('admin.supplier_order.index') }}"> فواتير المشتريات</a>
@endsection
@section('contentheaderactive', 'عرض')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center">    فواتير المشتريات </h3>
            <input type="hidden" id="search_token" value="{{csrf_token() }}">
            <input type="hidden" id="ajax_search_url" value="{{ route('admin.supplier_order.ajax_search') }}">
            <a href="{{ route('admin.supplier_order.create') }}" class="btn btn-sm btn-success">اضافة جديد</a>

        </div>

        <!-- /.card-header -->

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="search_by_text">  بحث بالاسم</label>
                    <input type="text" id="search_by_text" class="form-control" placeholder="ابحث بالاسم"> <br>
                </div>
                <div class="col-md-4">
                    <div class="form-group">

                        <label for="is_master"> ابحث بالنوع</label>
                        <select name="is_master_search" id="is_master_search" class="form-control">
                            <option value="all"> بحث بالكل</option>
                            <option value="1"> وحدة أب</option>
                            <option value="0"> وحدة تجزئة </option>
                        </select>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-md-12">


                    <div id="ajax_responce_searchDiv">
                        @if (@isset($data) && !@empty($data))

                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <th>كود</th>
                                    <th> المورد</th>
                                    <th>تاريخ الفاتورة</th>
                                    <th>نوع الفاتورة </th>
                                    <th>المخزن المستلم </th>
                                    <th>حالة الفاتورة</th>
                                     <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($data as $info)
                                        <tr>
                                            <td>{{ $info->auto_serial }}</td>
                                            <td>{{ $info->supplier_name }}</td>
                                            <td>{{ $info->order_date }}</td>
                                            <td>
                                                @if ($info->pill_type == 1)
                                                      كاش
                                                @elseif ($info->pill_type ==2)  اجل@else
                                                    غير محدد
                                                @endif
                                            </td>
                                            <td>{{ $info->store_name }}</td>
                                            <td>
                                                @if ($info->is_approved == 1)  معتمدة @else  مفتوحة@endif </td>
                                            <td>
                                                <a href="{{ route('admin.supplier_order.edit', $info->id) }}"
                                                    class="btn btn-sm btn-primary">تعديل</a>
                                                <a href="{{ route('admin.supplier_order.delete', $info->id) }}"
                                                    class="btn btn-sm btn-danger are_you_sure">حذف</a>
                                                <a href="{{ route('admin.supplier_order.delete', $info->id) }}"
                                                    class="btn btn-sm btn-success are_you_sure">اعتماد</a>
                                                <a href="{{ route('admin.supplier_order.show', $info->id) }}"
                                                    class="btn btn-sm btn-info">الاصناف</a>
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
    <script src="{{ asset('admin_assets/js/inv_uoms.js') }}"></script>

@endsection
