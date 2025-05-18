@extends('Admin.layouts.inc.app')
@section('title')
{{__('admin.Safes Transactions')}}
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
                <span class="card-label fw-bolder fs-3 mb-1">{{__('admin.Safes Transactions')}}</span>
            </h3>

        </div>
        <div    class = "card-body py-3">
        <form   class = "row mb-5">
        <div    class = "col-md-3">
        <label  class = "form-label">{{__('admin.Safe')}}</label>
        <select class = "form-select" name = "safe_id">
        <option value = "">{{__('admin.All Safes')}}</option>
                        @foreach($safes as $safe)
                            <option value="{{ $safe->id }}" {{ request('safe_id') == $safe->id ? 'selected' : '' }}>
                                {{ $safe->name }}
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
                        <th>{{__('admin.name')}}</th>
                        <th>{{__('admin.amount')}}</th>
                        <th>{{__('admin.balance_before')}}</th>
                        <th>{{__('admin.balance_after')}}</th>
                        <th>{{__('admin.type')}}</th>
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
            {data: 'safe.name', name: 'name'},
            {data: 'amount', name: 'amount'},
            {data: 'balance_before', name: 'balance_before'},
            {data: 'balance_after', name: 'balance_after'},
            {data: 'type', name: 'type'},
            {data: 'created_at', name: 'created_at'},
        ];

        // Initialize select2 for safe filter
        $(document).ready(function() {
            $('select[name="safe_id"]').select2();
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

