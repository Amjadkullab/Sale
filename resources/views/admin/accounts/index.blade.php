@extends('layouts.master')
@section('title', '  الحسابات')
@section('contentheader', 'الحسابات المالية')
@section('contentheaderlink')
    <a href="{{ route('admin.accounts.index') }}">الحسابات المالية</a>
@endsection
@section('contentheaderactive', 'عرض')

@section('content')

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات الحسابات المالية</h3>
                    <input type="hidden" id="search_token" value="{{csrf_token()}}">
                    <input type="hidden" id="ajax_search_url" value="{{route('admin.accounts.ajax_search')}}">
                <a href="{{ route('admin.accounts.create') }}" class="btn btn-sm btn-success">اضافة جديد</a>

                </div>

                <!-- /.card-header -->

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4">

                            <input  type="radio" checked name="searchbyradio" id="searchbyradio" value="account_number">بحث برقم الحساب
                            <input  type="radio" name="searchbyradio" id="searchbyradio" value="name">بالاسم
                            <input style="margin-top: 8px !important;" type="text" id="search_by_text" class="form-control" placeholder=" اسم- رقم الحساب"> <br>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="account_types_id_search">  بحث بنوع الحساب</label>
                               <select name="account_types_id_search" id="account_types_id_search" class="form-control" >
                                <option value="all"> بحث بالكل</option>
                                @if(@isset($account_type) && !@empty($account_type) )
                                @foreach ($account_type as $info )
                                <option  value="{{$info->id}}">{{$info->name}}</option>
                                @endforeach
                                @endif
                               </select>

                             </div>
                             </div>
                             <div class="col-md-4">
                                <div class="form-group">
                                   <label for="is_parent_search">  هل الحساب أب</label>
                                  <select name="is_parent_search" id="is_parent_search" class="form-control" >
                                    <option value="all"> بحث بالكل</option>
                                    <option  value="1"> نعم</option>
                                    <option  value="0"> لا </option>
                                  </select>

                                </div>
                                </div>



                        <div class="clearfix"></div>
                        <div class="col-md-12">


                        <div id="ajax_responce_searchDiv">
                            @if (@isset($data) && !@empty($data))

                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="custom_thead">

                                    <th>اسم</th>
                                    <th>رقم الحساب</th>
                                    <th>نوع الحساب</th>
                                    <th>هل اب</th>
                                    <th> الحساب الاب</th>
                                      <th>الرصيد</th>
                                    <th>حالة التفعيل</th>
                                    <th></th>
                                    {{-- <th>تاريخ الاضافة</th>
                                    <th>تاريخ التحديث</th> --}}
                                </thead>
                                <tbody>
                                    @foreach ($data as $info)
                                        <tr>
                                            <td>{{ $info->name }}</td>
                                            <td>{{ $info->account_number }}</td>
                                            <td>{{$info->account_types_name}}</td>
                                            <td> @if ($info->is_parent == 1)نعم  @else  لا @endif</td>
                                            <td>{{$info->parent_account_name}}</td>
                                            <td></td>
                                            <td> @if ($info->is_archived == 1)مفعلة  @else معطل @endif</td>
                                            <td>
                                              <a href="{{route('admin.accounts.edit',$info->id)}}" class="btn btn-sm btn-primary">تعديل</a>
                                                <a href="{{ route('admin.accounts.delete',$info->id) }}" class="btn btn-sm btn-danger are_you_sure">حذف</a>
                                                <a href="{{ route('admin.accounts.show',$info->id) }}" class="btn btn-sm btn-info ">عرض</a>
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
<script src="{{asset('admin_assets/js/accounts.js')}}"></script>

@endsection
