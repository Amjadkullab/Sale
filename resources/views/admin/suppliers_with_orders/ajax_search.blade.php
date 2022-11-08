@if (@isset($data) && !@empty($data))
@php
    $i = 1;
@endphp
<table id="example2" class="table table-bordered table-hover">
    <thead class="custom_thead">
        <th>كود</th>
        <th> المورد</th>
        <th>تاريخ الفاتورة</th>
        <th>نوع الفاتورة </th>
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
                        class="btn btn-sm btn-info are_you_sure">الاصناف</a>
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
<div class="col-md-12" id="ajax_pagination_in_search">
    {{ $data->links() }}
</div>

@else
<div class="alert alert-danger"> عفوا لا توجد بيانات لعرضها !!</div>

@endif
