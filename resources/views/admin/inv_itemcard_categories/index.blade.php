@extends('layouts.master')
@section('title', ' فئات الأصناف')
@section('contentheader', 'فئات الأصناف')
@section('contentheaderlink')
    <a href="{{ route('inv_itemcard_categories.index') }}">فئات الأصناف</a>
@endsection
@section('contentheaderactive', 'عرض')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات فئات الأصناف</h3>
                    <input type="hidden" id="search_token" value="{{csrf_token() }}">
                    <input type="hidden" id="ajax_search_url" value="{{route('admin.treasuries.ajax_search')}}">
                <a href="{{ route('inv_itemcard_categories.create') }}" class="btn btn-sm btn-success">اضافة جديد</a>

                </div>

                <!-- /.card-header -->

                <div class="card-body">

                        <div id="ajax_responce_searchDiv">
                            @if (@isset($data) && !@empty($data))
                            @php
                                $i = 1;
                            @endphp
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <th>مسلسل</th>
                                    <th>اسم الفئة</th>
                                    <th>حالة التفعيل</th>
                                    <th>تاريخ الاضافة</th>
                                    <th>تاريخ التحديث</th>
                                    <th></th>
                                    {{-- <th>تاريخ الاضافة</th>
                                    <th>تاريخ التحديث</th> --}}
                                </thead>
                                <tbody>
                                    @foreach ($data as $info)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $info->name }}</td>
                                            <td> @if ($info->active == 1)مفعلة  @else معطل @endif</td>
                                            <td>

                                                @php
                                                    $dt = New DateTime($info->created_at);
                                                    $date = $dt->format("Y-m-d");
                                                    $time = $dt->format("h:i");
                                                    $newDateTime = date("A",strtotime($time));
                                                    $newDateTimeType = (($newDateTime=='AM')? 'صباحا': 'مساءا');
                                                @endphp

                                                {{ $date }} <br>
                                                {{ $time }}
                                                {{ $newDateTimeType }} <br>
                                                بواسطة
                                                {{$info->added_by_admin}}

                                            </td>
                                            <td> @if($info->updated_by > 0 and $info->updated_by !=null)

                                                @php
                                                    $dt = New DateTime($info->updated_at);
                                                    $date = $dt->format("Y-m-d");
                                                    $time = $dt->format("h:i");
                                                    $newDateTime = date("A",strtotime($time));
                                                    $newDateTimeType = (($newDateTime=='AM')? 'صباحا': 'مساءا');
                                                @endphp

                                                {{ $date }}  <br>
                                                {{ $time }}
                                                {{ $newDateTimeType }} <br>
                                                بواسطة
                                                {{$info->updated_by_admin}}

                                             @else
                                             لا يوجد تحديث

                                             @endif

                                            </td>


                                            <td>
                                            <div class="row">
                                                <a href="{{ route('inv_itemcard_categories.edit',$info->id) }}" class="btn btn-sm btn-primary">تعديل</a>
                                                <form  action="{{ route('inv_itemcard_categories.destroy',$info->id) }}" method="post">
                                                   @csrf
                                                   @method('DELETE')
                                                   <button class="btn btn-sm btn-danger are_you_sure">حذف</button>
                                                </form></div>

                                                {{-- <a href="{{ route('inv_itemcard_categories.destroy',$info->id) }}" class="btn btn-sm btn-danger are_you_sure">حذف</a> --}}
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
@section('script')
<script src="{{ asset('admin_assets/js/treasuries.js')}}"></script>

@endsection
