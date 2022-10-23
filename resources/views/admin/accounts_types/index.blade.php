@extends('layouts.master')
@section('title', ' الحسابات')
@section('contentheader', 'أنواع الحسابات')
@section('contentheaderlink')
    <a href="{{ route('admin.accounttypes.index') }}">انواع الحسابات</a>
@endsection
@section('contentheaderactive', 'عرض')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات أنواع الحسابات</h3>

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
                                    <th>اسم النوع</th>
                                    <th>حالة التفعيل</th>
                                    <th> هل يضاف من شاشة داخلية</th>
                                </thead>
                                <tbody>
                                    @foreach ($data as $info)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $info->name }}</td>
                                            <td> @if ($info->active == 1)مفعلة  @else معطل @endif</td>
                                            <td> @if ($info->relatediternalaccounts == 1)نعم ويضاف من شاشته  @else لا ويضاف من شاشة الحسابات @endif</td>



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

                        @else
                            <div class="alert alert-danger"> عفوا لا توجد بيانات لعرضها !!</div>

                        @endif
                        </div>



                </div>
            </div>
        </div>
    </div>
@endsection
