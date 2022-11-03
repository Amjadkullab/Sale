@if (@isset($data) && !@empty($data) && count($data)>0)

<table id="example2" class="table table-bordered table-hover">
    <thead class="custom_thead">

        <th>اسم</th>
        <th>الكود</th>
        <th>فئة المورد</th>
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
                <td>{{ $info->supplier_code}}</td>
                <td>{{ $info->supplier_categories_name}}</td>
                <td>{{$info->account_number}}</td>
                <td></td>
                <td> @if ($info->active == 1)مفعلة  @else معطل @endif</td>
                <td>
                  <a href="{{route('admin.supplier.edit',$info->id)}}" class="btn btn-sm btn-primary">تعديل</a>
                    <a href="{{ route('admin.supplier.delete',$info->id) }}" class="btn btn-sm btn-danger are_you_sure">حذف</a>
                    <a href="{{ route('admin.supplier.show',$info->id) }}" class="btn btn-sm btn-info ">عرض</a>
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
