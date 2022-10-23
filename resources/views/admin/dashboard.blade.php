@extends('layouts.master')
@section('title','الرئيسية')
@section('contentheader','الرئيسية')
@section('contentheaderlink')
<a href="{{ route('admin.dashboard') }}">الرئيسية</a>
@endsection
@section('contentheaderactive', 'عرض')

@section('content')
<div class="row" style="background-image : url({{ asset('admin_assets/images/working-on-laptop_HYezpaW0Si.webp') }});background-size:cover;background-repeat:ni-repeat; min-height:650px;"></div>
@endsection
