@extends('Admin.layouts.inc.app')
@section('title')
    {{__('admin.Expenses')}}
@endsection
@section('css')

    <style>
        .select2-container {
            z-index: 10000; /* Adjust the value as needed */
        }
    </style>

@endsection

@section('content')

    <!--begin::Tables Widget 11-->
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">{{__('admin.Client Expense Transaction')}}</span>
            </h3>

        </div>
        <div class="card-body py-3">
            @include('Admin.CRUDS.expense.parts.add-client-expense-form')

        </div>
    </div>


    @endsection
    @section('js')



{{--      @include('Admin.layouts.inc.ajax',['url'=>''])--}}

    <link href="{{url('assets/dashboard/css/select2.css')}}" rel="stylesheet"/>
    <script src="{{url('assets/dashboard/js/select2.js')}}"></script>

@endsection

