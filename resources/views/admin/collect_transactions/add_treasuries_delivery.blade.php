@extends('layouts.master')
@section('title', 'الضبط ')
@section('contentheader', 'الخزن ')
@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}">الخزن الفرعية للاستلام</a>
@endsection
@section('contentheaderactive', 'اضافة')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> اضافة خزن للاستلام منها للخزنة {{ $data['name'] }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                     <form action= {{ route('admin.treasuries.store_treasuries_delivery',$data['id']) }} method="POST" >
                      @csrf

                      <div class="form-group">
                       <label >اختر الخزنة الفرعية</label>
                      <select name="treasuries_can_delivery_id"  id="treasuries_can_delivery_id" class="form-control" >
                        <option value="">اختر الخزنة</option>
                        @if(@isset( $treasuries ) && !@empty( $treasuries ))
                        @foreach ($treasuries as $info)
                        <option  value="{{ $info->id }}">{{ $info->name }}</option>
                        @endforeach
                        @endif
                      </select>
                        @error('treasuries_can_delivery_id')
                        <span class="text-danger" >{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-sm">اضافة </button>
                        <a href="{{ route('admin.treasuries.index') }}" class="btn btn-sm btn-danger" >الغاء</a>
                      </div>
                    </form>



                </div>
            </div>
        </div>
    </div>
@endsection
