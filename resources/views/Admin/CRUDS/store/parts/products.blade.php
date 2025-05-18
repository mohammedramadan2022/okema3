@extends('Admin.layouts.inc.app')
@section('title')
    {{__('admin.Store Products')}}
@endsection

@section('content')
<div class="card mb-5 mb-xl-8">
    <!--begin::Header-->
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder fs-3 mb-1">{{__('admin.Store Products')}} - {{ $store->name }}</span>
        </h3>
    </div>
    <div class="card-body py-3">
        <div class="table-responsive">
            <table class="table align-middle gs-0 gy-4 table table-bordered dt-responsive nowrap table-striped align-middle">
                <thead>
                    <tr class="fw-bolder text-muted bg-light">
                        <th>#</th>
                        <th>{{__('admin.Product Name')}}</th>
                        <th>{{__('admin.Product Code')}}</th>
                        <th>{{__('admin.Quantity')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->code }}</td>
                            <td>
                                <input type="number"
                                       class="form-control quantity-input"
                                       data-product-id="{{ $product->id }}"
                                       value="{{ $product->productStores->first() ? $product->productStores->first()->quantity : 0 }}"
                                       min="0">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('.quantity-input').on('change', function() {
            const productId = $(this).data('product-id');
            const quantity = $(this).val();
            const storeId = {{ $store->id }};

            $.ajax({
                url: "{{ route('stores.update-quantities', $store->id) }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: 'PUT',
                    product_id: productId,
                    quantity: quantity
                },
                success: function(response) {
                    toastr.success("{{__('admin.Quantity updated successfully')}}");
                },
                error: function(xhr) {
                    toastr.error("{{__('admin.Error updating quantity')}}");
                }
            });
        });
    });
</script>
@endsection
