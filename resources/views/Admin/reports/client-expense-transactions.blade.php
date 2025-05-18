@extends('Admin.layouts.inc.app')
@section('title')
{{__('admin.Client Expense Transactions')}}
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
                <span class="card-label fw-bolder fs-3 mb-1">{{__('admin.Client Expense Transactions')}}</span>
            </h3>

        </div>
        <div class="card-body py-3">
            <form  class="row mb-5">
                <div class="col-md-3">
                    <label class="form-label">{{__('admin.Safe')}}</label>
                    <select class="form-select" name="safe_id">
                        <option value="">{{__('admin.All Safes')}}</option>
                        @foreach($safes as $safe)
                            <option value="{{ $safe->id }}" {{ request('safe_id') == $safe->id ? 'selected' : '' }}>
                                {{ $safe->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{__('admin.Client')}}</label>
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
                    <label class="form-label">{{__('admin.From Date')}}</label>
                    <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{__('admin.To Date')}}</label>
                    <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        {{__('admin.Filter')}}
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table id="table" class="table align-middle gs-0 gy-4 table table-bordered dt-responsive nowrap table-striped align-middle">
                    <thead>
                    <tr class="fw-bolder text-muted bg-light">
                        <th>#</th>
                        <th>{{__('admin.Client')}}</th>
                        <th>{{__('admin.Amount')}}</th>
                        <th>{{__('admin.Safe')}}</th>
                        <th>{{__('admin.Notes')}}</th>
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
            {data: 'client.name', name: 'name'},
            {data: 'amount', name: 'amount'},
            {
                data: null,
                name: 'safe_name',
                render: function(data, type, row) {
                    console.log('Full row data:', row);
                    console.log('Safes transaction:', row.safes_transaction);
                    console.log('Safe:', row.safes_transaction[0].safe);
                    if (row.safes_transaction && row.safes_transaction[0].safe) {
                        return row.safes_transaction[0].safe.name;
                    }
                    return '';
                }
            },
            {data: 'notes', name: 'notes'},
            {data: 'created_at', name: 'created_at'},
        ];

        // Initialize select2 for safe filter
        $(document).ready(function() {
            $('select[name="safe_id"]').select2();

            // Add this to see the initial data load
            $('#table').on('xhr.dt', function (e, settings, json, xhr) {
                console.log('DataTables response:', json);
            });
        });

        $(document).on('change', '.activeBtn', function () {
            var id = $(this).attr('data-id');
            $.ajax({
                type: 'GET',
                url: "{{route('admin.active.safe')}}",
                data: {
                    id: id,
                },
                success: function (res) {
                    if (res['status'] == true) {
                        toastr.success("{{__('admin.operation accomplished successfully')}}")
                    }
                },
                error: function (data) {
                    // Handle error
                }
            });
        });
    </script>
    @include('Admin.layouts.inc.ajax',['url'=>'safes'])

    <link href="{{url('assets/dashboard/css/select2.css')}}" rel="stylesheet"/>
    <script src="{{url('assets/dashboard/js/select2.js')}}"></script>


@endsection

