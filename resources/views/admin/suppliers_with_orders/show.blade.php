@extends('layouts.master')
@section('title', ' المشتريات')
@section('contentheader', 'حركات مخزنية')
@section('contentheaderlink')
    <a href="{{ route('admin.supplier_order.index') }}">
        فواتير المشتريات</a>
@endsection
@section('contentheaderactive', ' عرض التفاصيل')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">تفاصيل فاتورة المشتريات </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (@isset($data) && !@empty($data))
                        <table id="example2" class="table table-bordered table-hover">

                            <tr>
                                <td class="width30"> كود الفاتورة الألي</td>
                                <td>{{ $data['auto_serial'] }}</td>
                            </tr>
                            <tr>
                                <td class="width30"> كود الفاتورة بأصل فاتورة المشتريات </td>
                                <td>{{ $data['DOC_NO'] }}</td>
                            </tr>
                            <tr>
                                <td class="width30"> تاريخ الفاتورة</td>
                                <td>{{ $data['order_date'] }}</td>
                            </tr>
                            <tr>
                                <td class="width30"> اسم المورد</td>
                                <td>{{ $data['supplier_name'] }}</td>
                            </tr>

                            <tr>
                                <td class="width30"> نوع الفاتورة</td>
                                <td>
                                    @if ($data['pill_type'] == 1) كاش
                                    @else
                                        اجل@endif
                                </td>
                            </tr>
                            <tr>
                                <td class="width30"> اجمالي الفاتورة</td>
                                <td>{{ $data['total_before_discount'] * 1 }}</td>
                            </tr>

                            @if ($data['discount_type'] != null)

                                <tr>
                                    <td class="width30"> الخصم علي الفاتورة </td>
                                    <td>
                                        @if ($data['discount_type'] == 1)
                                            خصم نسبة ( {{ $data['discount_percent'] * 1 }} ) وقيمتها (
                                            {{ $data['discount_value'] * 1 }} )
                                        @else
                                            خصم يدوي وقيمته( {{ $data['discount_value'] * 1 }} )

                                        @endif


                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td class="width30"> الخصم علي الفاتورة </td>
                                    <td> لايوجد</td>
                                </tr>

                            @endif

                            <tr>
                                <td class="width30"> نسبة القيمة المضافة </td>
                                <td>
                                    @if ($data['tax_percent'] > 0)
                                        لايوجد
                                    @else
                                        بنسبة ({{ $data['tax_percent'] * 1 }}) % وقيمتها ( {{ $data['tax_value'] * 1 }} )
                                    @endif

                                </td>
                            </tr>

                            <tr>
                                <td class="width30">تاريخ الاضافة </td>
                                <td>

                                    @php
                                        $dt = new DateTime($data['created_at']);
                                        $date = $dt->format('Y-m-d');
                                        $time = $dt->format('h:i');
                                        $newDateTime = date('A', strtotime($time));
                                        $newDateTimeType = $newDateTime == 'AM' ? 'صباحا' : 'مساءا';
                                    @endphp

                                    {{ $date }}
                                    {{ $time }}
                                    {{ $newDateTimeType }}
                                    بواسطة
                                    {{ $data['added_by_admin'] }}

                                </td>

                            </tr>

                            <tr>
                                <td class="width30">تاريخ اخر تحديث </td>
                                <td>
                                    @if ($data['updated_by'] > 0 and $data['updated_by'] != null)

                                        @php
                                            $dt = new DateTime($data['updated_at']);
                                            $date = $dt->format('Y-m-d');
                                            $time = $dt->format('h:i');
                                            $newDateTime = date('A', strtotime($time));
                                            $newDateTimeType = $newDateTime == 'AM' ? 'صباحا' : 'مساءا';
                                        @endphp

                                        {{ $date }}
                                        {{ $time }}
                                        {{ $newDateTimeType }}
                                        بواسطة
                                        {{ $data['updated_by_admin'] }}
                                    @else
                                        لا يوجد تحديث

                                    @endif
                                    <a href="{{ route('admin.treasuries.edit', $data['id']) }}"
                                        class="btn btn-sm btn-success">تعديل</a>
                                </td>

                            </tr>
                        </table>
                        <!--   treasuries delivery            -->

                        <div class="card-header">
                            <h3 class="card-title card_title_center"> الأصناف المضافة للفاتورة
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#Add-item">
                                    Launch Info Modal
                                </button>

                            </h3>
                        </div>
                        <div id="ajax_responce_searchDiv">
                            @if (@isset($treasuries_delivery) && !@empty($treasuries_delivery))
                                @php
                                    $i = 1;
                                @endphp
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead class="custom_thead">
                                        <th>مسلسل</th>
                                        <th>اسم الخزنة</th>
                                        <th>تاريخ الاضافة</th>

                                        {{-- <th>تاريخ الاضافة</th>
                    <th>تاريخ التحديث</th> --}}
                                    </thead>
                                    <tbody>
                                        @foreach ($treasuries_delivery as $info)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $info->name }}</td>
                                                <td>
                                                    @php
                                                        $dt = new DateTime($info->created_at);
                                                        $date = $dt->format('Y-m-d');
                                                        $time = $dt->format('h:i');
                                                        $newDateTime = date('A', strtotime($time));
                                                        $newDateTimeType = $newDateTime == 'AM' ? 'صباحا' : 'مساءا';
                                                    @endphp

                                                    {{ $date }}
                                                    {{ $time }}
                                                    {{ $newDateTimeType }}
                                                    بواسطة
                                                    {{ $info->added_by_admin }}

                                                </td>
                                                <td><a href="{{ route('admin.delete_treasuries_delivery', $info->id) }}"
                                                        class="btn btn-sm btn-danger are_you_sure"> حذف</a></td>




                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>

                        <!--  end treasuries delivery            -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="Add-item" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-info">
                <div class="modal-header">
                    <h4 class="modal-title">Info Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="Add_item_modal" style="background-color: white !important">
                    <p>One fine body…</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-light">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>













@endsection
