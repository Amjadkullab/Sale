@extends('layouts.master')
@section('title', ' ضبط الأصناف')
@section('contentheader', 'الأصناف')
@section('contentheaderlink')
    <a href="{{ route('admin.stores.index') }}">الأصناف</a>
@endsection
@section('contentheaderactive', ' عرض التفاصيل')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">  عرض بيانات صنف</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (@isset($data) && !@empty($data))
                        <table id="example2" class="table table-bordered table-hover">


                            <tr>
                                <td colspan="3" >
                                    <label > كود الصنف الثابت الالي من النظام</label><br>
                                    {{ $data['item_code'] }}
                                </td>
                                  </tr>

                                <tr>
                                    <td >
                                        <label >باركود الصنف</label><br>
                                        {{ $data['barcode'] }}
                                    </td>


                                    <td >
                                        <label >اسم الصنف</label><br>
                                        {{ $data['name'] }}
                                    </td>

                                    <td >
                                        <label >نوع الصنف</label><br>
                                        @if ($data['item_type'] == 1)مخزني @elseif ($data['item_type'] == 2) استهلاكي بصلاحية @elseif ($data['item_type'] == 3)  عهدة  @else غير محدد @endif
                                    </td>

                                </tr>
                                <tr>
                                    <td >
                                        <label >فئة الصنف</label><br>
                                        {{ $data['inv_itemcard_categories_name'] }}
                                    </td>
                                    <td >
                                        <label >  الصنف الاب</label><br>
                                        {{ $data['parent_inv_itemcard_name'] }}
                                    </td>
                                    <td >
                                        <label > وحدة القياس الاب</label><br>
                                        {{$data['uom_name']}}
                                    </td>
                                </tr>
                                <tr>
                                    <td   @if($data['does_has_retailunit'] == 0) colspan="3" @endif>
                                        <label > هل للصنف وحدة تجزئة ابن</label><br>
                                       @if ($data['does_has_retailunit'] == 1)نعم  @else  لا @endif
                                    </td>
                                    @if($data['does_has_retailunit'] == 1)
                                    <td >
                                        <label >  وحدة قياس التجزئة الابن بالنسبة للأب</label><br>
                                        {{ $data['retail_uom_name'] }}
                                    </td>
                                    <td >
                                        <label > عدد وحدات التجزئة({{ $data['retail_uom_name'] }}) بالنسبة ({{ $data['uom_name'] }}) </label><br>
                                        {{$data['retail_uom_quntToParent']*1}}
                                    </td>


                                    @endif

                                </tr>


                                <tr>
                                    <td >
                                        <label > السعر  القطاعي بوحدة ({{ $data['uom_name'] }})</label><br>
                                        {{ $data['price'] *1}}
                                    </td>


                                    <td >
                                        <label > السعر نص جملة بوحدة ({{ $data['uom_name'] }})</label><br>
                                        {{ $data['nos_gomla_price']*1 }}
                                    </td>
                                    <td >
                                        <label >    السعر  جملة بوحدة ({{ $data['uom_name'] }})</label><br>
                                        {{ $data['gomla_price']*1}}
                                    </td>

                                </tr>
                                <tr>
                                    <td @if($data['does_has_retailunit'] == 0) colspan="3" @endif >
                                        <label >   سعر تكلفة الشراء بوحدة ({{ $data['uom_name'] }})</label><br>
                                        {{$data['cost_price']*1}}
                                    </td>

                                    @if($data['does_has_retailunit'] == 1)
                                    <td >
                                        <label > السعر  القطاعي بوحدة ({{ $data['retail_uom_name'] }})</label><br>
                                        {{ $data['price_retail']*1 }}
                                    </td>
                                    <td >
                                        <label >    السعر  النص جملة بوحدة ({{ $data['retail_uom_name'] }})</label><br>
                                        {{ $data['nos_gomla_price_retail'] *1}}
                                    </td>
                                          @endif
                                </tr>

                                <tr>
                                    @if($data['does_has_retailunit'] == 1)
                                    <td >
                                        <label > السعر الجملة بوحدة ({{ $data['retail_uom_name'] }}) </label><br>
                                        {{ $data['gomla_price_retail']*1 }}
                                    </td>
                                    <td colspan="3" >
                                        <label >   سعر تكلفة الشراء بوحدة  ({{ $data['retail_uom_name'] }})</label><br>
                                        {{$data['cost_price_retail']*1}}
                                    </td>
                                    @endif

                                </tr>


                                <tr>


                                 <td>

                                    <label> هل للصنف سعر ثابت</label><br>
                                    @if ($data['has_fixed_price'] == 1)نعم ثابت ولا يتغير بالفواتير  @else  لا وقابل للتغيير بالفواتير @endif

                                 </td>

                                 <td colspan="3">
                                    <label> حالة التفعيل</label><br>
                                    @if ($data['active'] == 1) مفعل @else معطل @endif

                                 </td>

                                </tr>
                                <tr>
                                    <td >لوجو الصنف</td>
                                    <td colspan="2">
                                        <div class="image">
                                           <img class="custom_img" src="{{ asset('admin_assets/uploads').'/'. $data['photo'] }}"alt="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td >تاريخ اخر تحديث  </td>
                                    <td colspan="2"> @if($data['updated_by'] > 0 and $data['updated_by']!=null)

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
                                     <a href="{{ route('admin.inv_itemcard.edit',$data['id']) }}" class="btn btn-sm btn-success">تعديل</a>
                                    </td>

                                </tr>


                        </table>
                    @else
                        <div class="alert alert-danger"> عفوا لا توجد بيانات لعرضها !!</div>

                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
