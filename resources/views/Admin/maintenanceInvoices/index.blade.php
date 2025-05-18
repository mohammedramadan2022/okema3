@extends('Admin.layouts.inc.app')
@section('title')
{{__('admin.Maintenance Invoices')}}
@endsection
@section('css')

<style>
    .select2-container {
        z-index: 10000;
        /* Adjust the value as needed */
    }
</style>

@endsection

@section('content')

<!--begin::Tables Widget 11-->
<div class="card mb-5 mb-xl-8">
    <!--begin::Header-->
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder fs-3 mb-1">{{__('admin.Maintenance Invoices')}}</span>
        </h3>
        <div class="card-toolbar">
            <a id="addBtn" href="{{ route('maintenanceInvoices.create') }}" class="btn btn-sm btn-light-primary">
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                            transform="rotate(-90 11.364 20.364)" fill="black" />
                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                    </svg>
                </span>
                {{__('admin.Add Invoice')}}</a>
        </div>
    </div>
    <div class="card-body py-3">
        <div class="table-responsive">
            <table id="table"
                class="table align-middle gs-0 gy-4 table table-bordered dt-responsive nowrap table-striped align-middle">
                <thead>
                    <tr class="fw-bolder text-muted bg-light">
                        <th>#</th>
                        <th>{{__('admin.Client')}}</th>
                        <th>{{__('admin.Invoice ID')}}</th>
                        <th>{{__('admin.Invoice Date')}}</th>
                        <th>{{__('admin.Invoice Due Date')}}</th>
                        <th>{{__('admin.Amount')}}</th>
                        <th>{{__('admin.Shop')}}</th>
                        <th>{{__('admin.status')}}</th>
                        <th>{{__('admin.Created By')}}</th>
                        <th>{{__('admin.created at')}}</th>
                        <th>{{__('admin.actions')}}</th>




                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>



@endsection
@section('js')
<script>
    var columns = [
            {data: 'id', name: 'id'},
            {data: 'client.name', name: 'client'},
            {data: 'invoice_id', name: 'Invoice ID'},
            {data: 'invoice_date', name: 'Invoice Date'},
            {data: 'due_date', name: 'Due Date'},
            {data: 'amount', name: 'Amount'},
            {data: 'shop_name', name: 'Shop'},
            {data: 'status', name: 'status'},
            {data: 'created_by', name: 'Created by'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ];







</script>
@include('Admin.layouts.inc.ajax',['url'=>'maintenanceInvoices'])

<link href="{{url('assets/dashboard/css/select2.css')}}" rel="stylesheet" />
<script src="{{url('assets/dashboard/js/select2.js')}}"></script>


@endsection
