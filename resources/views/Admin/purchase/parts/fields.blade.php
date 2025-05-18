<div class = "row">
    <div class="col-lg-4 col-sm-12 mb-5">
        {{ Form::label('supplier_id', __('admin.Supplier') . ':', ['class' => 'form-label required mb-3']) }}
        {{ Form::select('supplier_id', $suppliers->mapWithKeys(fn($supplier) => [$supplier->id => $supplier->name]), $supplier_id ?? null, ['class' => 'form-select io-select2', 'id' => 'supplier_id', 'placeholder' => __('admin.Supplier'), 'data-control' => 'select2']) }}
    </div>

    <div class="col-lg-4 col-sm-12 mb-5">
        {{ Form::label('store_id', __('admin.Store') . ':', ['class' => 'form-label required mb-3']) }}
        {{ Form::select('store_id', $stores->mapWithKeys(fn($store) => [$store->id => $store->name]), $store_id ?? null, ['class' => 'form-select io-select2', 'id' => 'store_id', 'placeholder' => __('admin.Store'), 'data-control' => 'select2']) }}
    </div>


    <div class="col-lg-4 col-sm-12 mb-5">
        {{ Form::label('invoice_date', __('admin.invoice_date') . ':', ['class' => 'form-label required mb-3']) }}
        {{ Form::date('invoice_date', null, ['class' => 'form-control', 'id' => 'invoice_date', 'autocomplete' => 'off', 'required']) }}
    </div>



    <div class="mb-0">
        <div class="col-12 text-end my-5">
            <button type="button" class="btn btn-primary text-start" id="addItem">
                {{ __('messages.invoice.add') }}</button>
        </div>
        <div class="table-responsive">
            <table class="table table-striped box-shadow-none mt-4" id="billTbl">
                <thead>
                <tr class="border-bottom fs-7 fw-bolder text-gray-700 text-uppercase">
                    <th scope="col">#</th>
                    <th scope="col" class="required">{{ __('messages.product.product') }}</th>
                    <th scope="col" class="required">{{ __('messages.invoice.qty') }}</th>
                    <th scope="col" class="required">{{ __('messages.product.unit_price') }}</th>
{{--                    <th scope="col">{{ __('messages.invoice.tax') }}</th>--}}
                    <th scope="col" class="required">{{ __('messages.invoice.amount') }}</th>
                    <th scope="col" class="text-end">{{ __('messages.common.action') }}</th>
                </tr>
                </thead>
                <tbody class="invoice-item-container">
                <tr class="tax-tr">
                    <td class="text-center item-number align-center">1</td>
                    <td class="table__item-desc w-25">
                        <select name="product_id[]" class="form-select product io-select2" required data-control="select2" id="product_id">


                            <option value="" disabled selected>{{ __('messages.flash.select_product_or_enter_free_text') }}</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-unit-price="{{ $product->unit_price }}"
                                        data-tokens="{{ $product->original_code }} {{ $product->name }}"
                                >{{ $product->name }} ({{$product->original_code}})</option>
                            @endforeach
                        </select>
                    </td>


                    <td class="table__qty">
                        {{ Form::number('quantity[]', 1, ['class' => 'form-control qty ', 'required', 'type' => 'number', 'min' => '0', 'step' => '.01', 'oninput' => "validity.valid||(value=value.replace(/[e\+\-]/gi,''))"]) }}
                    </td>
                    <td>
                        {{ Form::number('price[]', null, ['class' => 'form-control price-input price ', 'oninput' => "validity.valid||(value=value.replace(/[e\+\-]/gi,''))", 'min' => '0', 'value' => '0', 'step' => '.01', 'pattern' => "^\d*(\.\d{0,2})?$", 'required', 'onKeyPress' => 'if(this.value.length==8) return false;']) }}
                    </td>

                    <td class="text-end item-total pt-8 text-nowrap">

                            0.00

                    </td>


                    <td class="text-end">
                        <button type="button" title="Delete"
                                class="btn btn-icon fs-3 text-danger btn-active-color-danger delete-invoice-item">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
<!-- Total Amount Field -->
{{ Form::hidden('amount', 0, ['class' => 'form-control', 'id' => 'total_amount']) }}
<!-- Final Amount Field -->
{{ Form::hidden('final_amount', 0, ['class' => 'form-control', 'id' => 'finalTotalAmt']) }}
<!-- Submit Field -->
<div class="float-end">
    <div class="form-group col-sm-12">

        <button type="submit" name="save" class="btn btn-primary mx-1 ms-ms-3 mb-3 mb-sm-0" id="saveAndSend"
                data-status="1" value="1">{{ __('messages.common.save') }}
        </button>
        <a href="{{ route('purchase.index') }}"
           class="btn btn-secondary btn-active-light-primary">{{ __('messages.common.cancel') }}</a>
    </div>
</div>

<!-- Your existing HTML remains the same -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('addItem').addEventListener('click', function () {
            let tableBody = document.querySelector('.invoice-item-container');

              // Create a new row from scratch to avoid select2 duplication issues
            let newRow = document.createElement('tr');
            newRow.classList.add('tax-tr');

            newRow.innerHTML = `
                <td     class = "text-center item-number align-center">${tableBody.children.length + 1}</td>
                <td     class = "table__item-desc w-25">
                <select name  = "product_id[]" class = "form-select product io-select2" required data-control = "select2">
                <option value = "" disabled selected>{{ __('messages.flash.select_product_or_enter_free_text') }}</option>
                        @foreach($products as $product)
                            <option value = "{{ $product->id }}" data-unit-price = "{{ $product->unit_price }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td    class = "table__qty">
                <input type  = "number" name = "quantity[]" class = "form-control qty" required min = "0" step = ".01" value = "1">
                </td>
                <td>
                    <input type = "number" name = "price[]" class = "form-control price-input price" required min = "0" step = ".01" value = "0">
                </td>
                <td     class = "text-end item-total pt-8 text-nowrap">0.00</td>
                <td     class = "text-end">
                <button type  = "button" title = "Delete" class = "btn btn-icon fs-3 text-danger btn-active-color-danger delete-invoice-item">
                <i      class = "fa fa-trash"></i>
                    </button>
                </td>
            `;

              // Append the new row to the table
            tableBody.appendChild(newRow);

              // Reinitialize select2 for the new select
            $(newRow).find('select').select2({
                placeholder: 'Select an option',
                allowClear : true
            });
        });

          // Handle row deletion
        document.querySelector('.invoice-item-container').addEventListener('click', function (e) {
            if (e.target.closest('.delete-invoice-item')) {
                e.target.closest('.tax-tr').remove();
                updateRowNumbers();
            }
        });

          // Update row numbers after deletion
        function updateRowNumbers() {
            document.querySelectorAll('.invoice-item-container .tax-tr').forEach((row, index) => {
                row.querySelector('.item-number').textContent = index + 1;
            });
        }
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        // Function to update total per row
        function updateRowTotal(row) {
            let qty = parseFloat(row.querySelector('.qty').value) || 0;
            let price = parseFloat(row.querySelector('.price').value) || 0;
            let total = qty * price;
            row.querySelector('.item-total').textContent = total.toFixed(2);
            updateTotalAmount();
        }

        // Function to update total invoice amount
        function updateTotalAmount() {
            let totalAmount = 0;
            document.querySelectorAll('.invoice-item-container .tax-tr').forEach(row => {
                totalAmount += parseFloat(row.querySelector('.item-total').textContent) || 0;
            });
            document.getElementById('total_amount').value = totalAmount.toFixed(2);
            document.getElementById('finalTotalAmt').value = totalAmount.toFixed(2);
        }

        // Event delegation for product change and input events
        document.querySelector('.invoice-item-container').addEventListener('change', function (e) {
            handleProductChange(e);
        });

        document.querySelector('.invoice-item-container').addEventListener('input', function (e) {
            if (e.target.classList.contains('qty') || e.target.classList.contains('price')) {
                updateRowTotal(e.target.closest('.tax-tr'));
            }
        });

        // Initialize any existing rows (e.g., when editing an existing invoice)
        document.querySelectorAll('.invoice-item-container .tax-tr').forEach(row => {
            updateRowTotal(row);
        });
    });
</script>




