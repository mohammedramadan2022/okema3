@extends('Admin.layouts.master')
@section('title', 'Items')
@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Items</span>
            </h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light-primary" id="addBtn">
                    <i class="ki-duotone ki-plus fs-2"></i>New Item
                </button>
            </div>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-4" id="users_table">
                    <thead>
                        <tr class="fw-bold text-muted bg-light">
                            <th class="min-w-125px">#</th>
                            <th class="min-w-125px">Name</th>
                            <th class="min-w-125px">Category</th>
                            <th class="min-w-125px">Device</th>
                            <th class="min-w-125px">Barcode</th>
                            <th class="min-w-125px">Status</th>
                            <th class="min-w-125px">Created at</th>
                            <th class="min-w-200px rounded-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--begin::Modal - Add item-->
    <div class="modal fade" id="Modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Add Item</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7" id="form-load">

                </div>
            </div>
        </div>
    </div>
    <!--end::Modal - Add item-->
@endsection
@section('js')
    <script>
        var columns = [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'category_id',
                name: 'category_id'
            },
            {
                data: 'device_id',
                name: 'device_id'
            },
            {
                data: 'barcode',
                name: 'barcode'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ];

        // Initialize DataTable
        var itemTable = $('#users_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('items.index') }}",
            columns: columns,
            order: [
                [0, 'desc']
            ],
        });

        // Add Item
        $(document).on('click', '#addBtn', function() {
            $('#form-load').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');
            $('#Modal').modal('show');
            setTimeout(function() {
                $('#form-load').load("{{ route('items.create') }}")
            }, 250);
        });

        // Edit Item
        $(document).on('click', '.editBtn', function() {
            var id = $(this).data('id');
            $('#form-load').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');
            $('#Modal').modal('show');
            setTimeout(function() {
                $('#form-load').load("{{ route('items.edit', '') }}/" + id)
            }, 250);
        });

        // Delete Item
        $(document).on('click', '.delete', function() {
            var id = $(this).data('id');
            var url = "{{ route('items.destroy', '') }}/" + id;
            confirmDelete(url, itemTable);
        });

        // Activate/Deactivate Item
        $(document).on('click', '.activeBtn', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "{{ route('admin.active.item') }}",
                type: "GET",
                data: {
                    id: id
                },
                success: function(data) {
                    toastr.success('Status changed successfully');
                    itemTable.ajax.reload();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        // Form Submit
        $(document).on('submit', 'form', function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var data = new FormData(this);
            $.ajax({
                url: url,
                type: method,
                data: data,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 200) {
                        toastr.success(data.message);
                        $('#Modal').modal('hide');
                        itemTable.ajax.reload();
                    }
                },
                error: function(data) {
                    if (data.status == 422) {
                        var errors = data.responseJSON.errors;
                        for (var key in errors) {
                            toastr.error(errors[key][0]);
                        }
                    }
                }
            });
        });
    </script>
@endsection
