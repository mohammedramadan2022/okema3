@extends('Admin.layouts.master')
@section('title', 'Item Details')
@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Item Details</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('items.index') }}" class="btn btn-sm btn-light-primary">
                    <i class="ki-duotone ki-arrow-left fs-2"></i>Back to Items
                </a>
            </div>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                    <tbody>
                        <tr>
                            <th class="fw-bold text-muted">ID</th>
                            <td>{{ $item->id }}</td>
                        </tr>
                        <tr>
                            <th class="fw-bold text-muted">Name</th>
                            <td>{{ $item->name }}</td>
                        </tr>
                        <tr>
                            <th class="fw-bold text-muted">Category</th>
                            <td>{{ $item->category_id }}</td>
                        </tr>
                        <tr>
                            <th class="fw-bold text-muted">Device</th>
                            <td>{{ $item->device_id }}</td>
                        </tr>
                        <tr>
                            <th class="fw-bold text-muted">Barcode</th>
                            <td>{{ $item->barcode }}</td>
                        </tr>
                        <tr>
                            <th class="fw-bold text-muted">Status</th>
                            <td>
                                @if($item->status == 'active')
                                    <span class="badge badge-light-success">Active</span>
                                @else
                                    <span class="badge badge-light-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="fw-bold text-muted">Created At</th>
                            <td>{{ $item->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th class="fw-bold text-muted">Updated At</th>
                            <td>{{ $item->updated_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
