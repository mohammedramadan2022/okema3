@extends('Admin.layouts.inc.app')
@section('title')
{{__('admin.Maintenance Quote')}}
@endsection
@section('css')

<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet" />

@endsection



@section('content')

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('maintenanceQuotes.update' , $quote)}}">
    @csrf
@method('PUT')
    @include('Admin.maintenanceQuotes.parts.edit-fields')





</form>
@include('Admin.maintenanceQuotes.templates.templates')

@endsection


