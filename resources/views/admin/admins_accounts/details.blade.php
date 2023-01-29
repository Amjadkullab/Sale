@extends('layouts.master')
@section('title', ' الصلاحيات')
@section('contentheader', 'المستخدمين ')
@section('contentheaderlink')
    <a href="{{ route('admin.admin_accounts.index') }}">المستخدمين</a>
@endsection
@section('contentheaderactive', 'عرض الصلاحيات الخاصة ')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">تفاصيل المستخدم </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (@isset($data) && !@empty($data))
                        <table id="example2" class="table table-bordered table-hover">

                                <tr>
                                    <td class="width30">اسم المستخدم</td>
                                    <td>{{$data['name']}}</td>
                                </tr>

                                <tr>
                                    <td class="width30">حالة تفعيل  </td>
                                    <td> @if ($data['active'] == 1) مفعل @else معطل @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="width30">تاريخ الاضافة  </td>
                                    <td>

                                        @php
                                            $dt = New DateTime($data['created_at']);
                                            $date = $dt->format("Y-m-d");
                                            $time = $dt->format("h:i");
                                            $newDateTime = date("A",strtotime($time));
                                            $newDateTimeType = (($newDateTime=='AM')? 'صباحا': 'مساءا');
                                        @endphp

                                        {{ $date }}
                                        {{ $time }}
                                        {{ $newDateTimeType }}
                                        بواسطة
                                        {{$data['added_by_admin']}}

                                    </td>

                                </tr>

                                <tr>
                                    <td class="width30">تاريخ اخر تحديث  </td>
                                    <td> @if($data['updated_by'] > 0 and $data['updated_by']!=null)

                                        @php
                                            $dt = New DateTime($data['updated_at']);
                                            $date = $dt->format("Y-m-d");
                                            $time = $dt->format("h:i");
                                            $newDateTime = date("A",strtotime($time));
                                            $newDateTimeType = (($newDateTime=='AM')? 'صباحا': 'مساءا');
                                        @endphp

                                        {{ $date }}
                                        {{ $time }}
                                        {{ $newDateTimeType }}
                                        بواسطة
                                        {{$data['updated_by_admin']}}

                                     @else
                                     لا يوجد تحديث

                                     @endif
                                     <a href="{{ route('admin.admin_accounts.edit',$data['id']) }}" class="btn btn-sm btn-success">تعديل</a>
                                    </td>

                                </tr>
                        </table>
         <!--   treasuries delivery            -->

         <div class="card-header">
            <h3 class="card-title card_title_center"> الخزن المضافة لصلاحيات المستخدم
               <button href="#" class = "btn btn-sm btn-success" data-toggle = "modal" data-target="#Add_treasuries_modal" > اضافة جديد</button>

            </h3>
        </div>
         <div id="ajax_responce_searchDiv">
            @if (@isset($admins_treasuries) && !@empty($admins_treasuries))
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
                    @foreach ($admins_treasuries as $info)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $info->name }}</td>
                         <td>
                            @php
                            $dt = New DateTime($info->created_at);
                            $date = $dt->format("Y-m-d");
                            $time = $dt->format("h:i");
                            $newDateTime = date("A",strtotime($time));
                            $newDateTimeType = (($newDateTime=='AM')? 'صباحا': 'مساءا');
                        @endphp

                        {{ $date }}
                        {{ $time }}
                        {{ $newDateTimeType }}
                        بواسطة
                        {{$info->added_by_admin}}

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

                        </td>
                         <td><a href="{{ route('admin.delete_treasuries_delivery', $info->id) }}" class="btn btn-sm btn-danger are_you_sure"> حذف</a></td>



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
                            </td> --}}

                        </tr>
                        @php
                            $i++;
                        @endphp
                   @endforeach
                </tbody>
            </table>
        @endif
        </div>
        @else
          <div class="alert alert-danger">
            !! عفوا لايوجد بيانات لعرضها
          </div>
          @endif

      <!--  end treasuries delivery            -->
                </div>
            </div>
        </div>
    </div>







    <div class="modal fade" id="Add_treasuries_modal">
        <div class="modal-dialog modal-xl" >
          <div class="modal-content bg-info">
            <div class="modal-header">
              <h4 class="modal-title">اضافة خزن للمستخدم</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="Add_treasuries_modal_body" style="background-color: white !important; color:black;">
                <form action= {{ route('admin.admin_accounts.Add_treasuries_to_admin',$data['id']) }} method="POST" >
                    @csrf

                    <div class="form-group">
                     <label >بيانات الخزن</label>
                    <select name="treasuries_id"  id="treasuries_id" class="form-control" >
                      <option value="">اختر الخزنة</option>
                      @if(@isset($treasuries) && !@empty($treasuries))
                      @foreach ($treasuries as $info)
                      <option  value="{{$info->id}}">{{ $info->name }}</option>
                      @endforeach
                      @endif
                    </select>

                  </div>
                  <div class="form-group text-center ">
                      <button type="submit" class="btn btn-success btn-sm">اضافة الخزنة للمستخدم </button>

                    </div>
                  </form>
              </div>

            <div class="modal-footer justify-content-between bg-info">
              <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>

            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>











@endsection
