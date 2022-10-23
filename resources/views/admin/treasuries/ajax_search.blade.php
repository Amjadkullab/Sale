@if (@isset($data) && !@empty($data))
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
                    <button data-id="{{ $info->id   }}" class="btn btn-sm btn-info">المزيد</button>
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
<div class="col-md-12" id="ajax_pagination_in_search">
    {{ $data->links() }}
</div>

@else
<div class="alert alert-danger"> عفوا لا توجد بيانات لعرضها !!</div>

@endif
