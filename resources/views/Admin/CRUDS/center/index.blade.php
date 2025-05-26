@extends('Admin.layouts.inc.app')
@section('title')
{{__('admin.Centers')}}
@endsection
@section('content')
<div class="card mb-5 mb-xl-8">
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder fs-3 mb-1">{{__('admin.Centers')}}</span>
        </h3>
        <div class="card-toolbar">
            <button id="addBtn" class="btn btn-sm btn-light-primary">
                {{__('admin.Add Center')}}
            </button>
        </div>
    </div>
    <div class="card-body py-3">
        <div class="table-responsive">
            <table id="table" class="table align-middle gs-0 gy-4 table table-bordered dt-responsive nowrap table-striped align-middle">
                <thead>
                <tr class="fw-bolder text-muted bg-light">
                    <th>#</th>
                    <th>{{__('admin.name')}}</th>
                    <th>{{__('admin.status')}}</th>
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
        {data: 'name', name: 'name'},
        {data: 'is_active', name: 'is_active'},
        {data: 'created_at', name: 'created_at'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ];
</script>
@include('Admin.layouts.inc.ajax',['url'=>'centers'])
@endsection
