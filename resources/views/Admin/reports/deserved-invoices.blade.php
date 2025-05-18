@extends('Admin.layouts.inc.app')
@section('title')
    {{__('admin.Deserved Invoices')}}
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
                <span class="card-label fw-bolder fs-3 mb-1">{{__('admin.Deserved Invoices')}}</span>
            </h3>

        </div>
        <div class="card-body py-3">
            <form class="row mb-5">
                <div class="col-md-3">
                    <label class="form-label">{{__('admin.Safe')}}</label>
                    <select class="form-select" name="client_id">
                        <option value="">{{__('admin.All Clients')}}</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        {{__('admin.Filter')}}
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table id="table"
                       class="table align-middle gs-0 gy-4 table table-bordered dt-responsive nowrap table-striped align-middle">
                    <thead>
                    <tr class="fw-bolder text-muted bg-light">
                        <th>#</th>
                        <th>{{__('admin.Invoice ID')}}</th>
                        <th>{{__('admin.Client')}}</th>
                        <th>{{__('admin.Amount')}}</th>
                        <th>{{__('admin.Paid')}}</th>
                        <th>{{__('admin.Deserved')}}</th>
                        <th>{{__('admin.Type')}}</th>
                        <th>{{__('admin.created at')}}</th>
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
            {data: 'invoice_id', name: 'invoice_id'},
            {data: 'client.name', name: 'client'},
            {data: 'final_amount', name: 'final_amount'},
            {data: 'safes_transaction_sum_amount', name: 'paid'},
            {data: null, name: 'deserved', render: function(data) {
                return data.final_amount - (data.safes_transaction_sum_amount || 0);
            }},
            {data: 'type', name: 'type', render: function(data) {
                return data == 0 ? 'Maintenance' : 'Sales';
            }},
            {data: 'created_at', name: 'created_at'},
        ];

        // Initialize select2 for safe filter

    </script>
    @include('Admin.layouts.inc.ajax',['url'=>'safes'])

    <link href="{{url('assets/dashboard/css/select2.css')}}" rel="stylesheet"/>
    <script src="{{url('assets/dashboard/js/select2.js')}}"></script>


@endsection

