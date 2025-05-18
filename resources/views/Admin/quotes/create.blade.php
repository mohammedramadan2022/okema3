@extends('Admin.layouts.inc.app')
@section('title')
{{__('admin.Quote')}}
@endsection
@section('css')

<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet" />

@endsection



@section('content')

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('quotes.store')}}">
    @csrf

    @include('Admin.quotes.parts.fields')





</form>
@include('Admin.quotes.templates.templates')

@endsection


