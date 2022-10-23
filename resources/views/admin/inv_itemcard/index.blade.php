@extends('layouts.master')
@section('title', ' ضبط الأصناف')
@section('contentheader', 'الأصناف')
@section('contentheaderlink')
    <a href="{{ route('admin.stores.index') }}">الأصناف</a>
@endsection
@section('contentheaderactive', 'عرض')

@section('content')

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات الأصناف</h3>
                    <input type="hidden" id="search_token" value="{{csrf_token() }}">
                    <input type="hidden" id="ajax_search_url" value="{{route('admin.inv_itemcard.ajax_search')}}">
                <a href="{{ route('admin.inv_itemcard.create') }}" class="btn btn-sm btn-success">اضافة جديد</a>

                </div>

                <!-- /.card-header -->

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4">

                            <input checked type="radio" name="searchbyradio" id="searchbyradio" value="barcode">بالباركود
                            <input  type="radio" name="searchbyradio" id="searchbyradio" value="item_code">بالكود
                            <input  type="radio" name="searchbyradio" id="searchbyradio" value="name">بالاسم
                            <input style="margin-top: 6px !important;" type="text" id="search_by_text" class="form-control" placeholder=" اسم- باركود - كود الصنف"> <br>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="item_type_search">  بحث بنوع الصنف </label>
                               <select name="item_type_search" id="item_type_search" class="form-control" >
                                 <option value="all"> بحث بالكل</option>
                                 <option   value="1"> مخزني</option>
                                 <option  value="2"> استهلاكي بتاريخ صلاحية</option>
                                 <option   value="3"> عهدة</option>

                               </select>
                                 @error('item_type')
                                 <span class="text-danger" >{{ $message }}</span>
                                 @enderror
                             </div>
                             </div>
                            <div class="col-md-4">
                            <div class="form-group">
                                <label for="inv_itemcard_categories_id_search">بحث بفئة الصنف </label>
                               <select name="inv_itemcard_categories_id_search" id="inv_itemcard_categories_id_search" class="form-control" >
                                <option value="all"> بحث بالكل</option>
                                @if(@isset($inv_itemcard_categories) && !@empty($inv_itemcard_categories) )
                                @foreach ($inv_itemcard_categories as $info )
                                <option  value="{{$info->id}}">{{$info->name}}</option>
                                @endforeach
                                @endif
                               </select>
                                 @error('inv_itemcard_categories_id')
                                 <span class="text-danger" >{{ $message }}</span>
                                 @enderror
                             </div>
                             </div>

                        <div class="clearfix"></div>
                        <div class="col-md-12">


                        <div id="ajax_responce_searchDiv">
                            @if (@isset($data) && !@empty($data))
                            @php
                                $i = 1;
                            @endphp
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <th>مسلسل</th>
                                    <th>اسم</th>
                                    <th>نوع</th>
                                    <th>الفئة</th>
                                    <th> الصنف الاب</th>
                                    <th> الوحدة الأب</th>
                                    <th> الوحدة التجزئة</th>
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
                                            <td> @if ($info->item_type == 1)مخزني @elseif ($info->item_type == 2) استهلاكي بصلاحية @elseif ($info->item_type == 3)  عهدة  @else غير محدد @endif</td>
                                            <td>{{$info->inv_itemcard_categories_name}}</td>
                                            <td>{{$info->parent_inv_itemcard_name}}</td>
                                            <td>{{$info->uom_name}}</td>
                                            <td>{{$info->retail_uom_name}}</td>
                                            <td> @if ($info->active == 1)مفعلة  @else معطل @endif</td>



                                            <td>
                                              <a href="{{route('admin.inv_itemcard.edit',$info->id)}}" class="btn btn-sm btn-primary">تعديل</a>
                                                <a href="{{ route('admin.inv_itemcard.delete',$info->id) }}" class="btn btn-sm btn-danger are_you_sure">حذف</a>
                                                <a href="{{ route('admin.inv_itemcard.show',$info->id) }}" class="btn btn-sm btn-info ">عرض</a>
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
<script src="{{ asset('admin_assets/js/inv_itemcard.js')}}"></script>

@endsection
