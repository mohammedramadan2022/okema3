<div class = "row">

    <div class="col-lg-4 col-sm-12 mb-5">
        {{ Form::label('quote_client_id', __('messages.quote.client') . ':', ['class' => 'form-label required mb-3']) }}
        {{ Form::select('quote_client_id', $clients->mapWithKeys(fn($client) => [$client->id => $client->name . ' (ID: ' . $client->id . ')']), $quote->client_id,
        ['class' => 'form-select io-select2', 'id' => 'quote_client_id', 'placeholder' => __('admin.Select Client'), 'data-control'
        => 'select2', 'required']) }}
    </div>


    <div class="col-lg-4 col-sm-12 mb-lg-0 mb-5">
        @if (!empty(getQuoteNoPrefix()) || !empty(getQuoteNoSuffix()))
        <div class="" data-bs-toggle="tooltip" data-bs-trigger="hover" title="" data-bs-original-title="Quote number">
            <div class="form-group col-sm-12 mb-5">
                {{ Form::label('paid_amount', __('admin.Quote') . ':', ['class' => 'form-label mb-3 required']) }}
                <div class="input-group">
                    @if (!empty(getQuoteNoPrefix()))
                    <a class="input-group-text bg-secondary border-0 text-decoration-none text-black"
                        data-toggle="tooltip" data-placement="right" title="Quote No Prefix">
                        {{ getQuoteNoPrefix() }}
                    </a>
                    @endif
                    {{ Form::text('quote_id', $quote->quote_id, ['class' => 'form-control', 'required', 'id' => 'quoteId',
                    'maxlength' => 6, 'onkeypress' => 'return blockSpecialChar(event)']) }}
                    @if (!empty(getQuoteNoSuffix()))
                    <a class="input-group-text bg-secondary border-0 text-decoration-none text-black"
                        data-toggle="tooltip" data-placement="right" title="quote No Suffix">
                        {{ getQuoteNoSuffix() }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @else
        <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-original-title="quote number">
            <span class="form-label">{{ __('messages.quote.quote') }} #</span>
            {{ Form::text('quote_id', \App\Models\Quote::generateUniqueQuoteId(), ['class' => 'form-control mt-3',
            'required', 'id' => 'quoteId', 'maxlength' => 6, 'onkeypress' => 'return blockSpecialChar(event)']) }}


        </div>
        @endif
    </div>


    <div class="col-lg-4 col-sm-12 mb-5">
        {{ Form::label('quote_date', __('admin.quote_date') . ':', ['class' => 'form-label required mb-3']) }}
        {{ Form::date('quote_date', $quote->quote_date, ['class' => 'form-select', 'id' => 'invoice_date', 'autocomplete' => 'off',
        ]) }}
    </div>


    <div class="mb-5 col-lg-4 col-sm-12">

        {{ Form::label('due_date', __('messages.quote.due_date') . ':', ['class' => 'form-label required mb-3']) }}
        {{ Form::date('due_date', $quote->due_date, ['class' => 'form-select', 'id' => 'due_date', 'autocomplete' => 'off',
        'required']) }}

    </div>
    <div class="col-lg-4 col-sm-12">
        <div class="mb-5">
            {{ Form::label('status', __('messages.common.status') . ':', ['class' => 'form-label required mb-3']) }}
            {{ Form::select('status', getTranslatedData($statusArr), $quote->status, ['class' => 'form-select io-select2', 'id' =>
            'status', 'required', 'data-control' => 'select2']) }}
        </div>
    </div>
    <div class="col-lg-4 col-sm-12">
        <div class="mb-5">
            {{ Form::label('shop name', __('admin.Shop Name') . ':', ['class' => 'form-label required mb-3']) }}
            {{ Form::text('shop_name', $quote->shop_name, ['class' => 'form-control ', 'placeholder' =>
            __('admin.Shop Name'), 'required']) }}

        </div>
    </div>
    <div class="col-lg-4 col-sm-12">
        <div class="mb-5">
            {{ Form::label('location', __('admin.Location') . ':', ['class' => 'form-label required mb-3']) }}
            {{ Form::text('location', $quote->location, ['class' => 'form-control ', 'placeholder' =>
            __('admin.Location'), 'required']) }}

        </div>
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
                        <th scope="col" class="required">{{ __('messages.invoice.unit') }}</th>
                        <th scope="col" class="required">{{ __('messages.product.unit_price') }}</th>
                        {{-- <th scope="col">{{ __('messages.invoice.tax') }}</th>--}}
                        <th scope="col" class="required">{{ __('messages.invoice.amount') }}</th>
                        <th scope="col" class="required">{{ __('admin.image') }}</th>
                        <th scope="col" class="text-end">{{ __('messages.common.action') }}</th>
                    </tr>
                </thead>
                <tbody class="invoice-item-container">
                    @foreach($quote->items as $item)
                    <tr class="tax-tr">
                        <td class="text-center item-number align-center">{{ $loop->iteration }}</td>
                        <td class="table__item-desc w-25">
                            {{ Form::textarea('product_name[]', $item->product_name, ['class' => 'form-control', 'required', 'rows' =>
                            '2' ,'placeholder' => __('messages.flash.select_product_or_enter_free_text')])}}
                        </td>
                        <td class="table__qty">
                            {{ Form::number('quantity[]', $item->quantity, ['class' => 'form-control qty ', 'required', 'type' =>
                            'number', 'min' => '0', 'step' => '.01', 'oninput' =>
                            "validity.valid||(value=value.replace(/[e\+\-]/gi,''))"]) }}
                        </td>
                        <td class="table__qty">
                            {{ Form::number('unit[]', $item->unit, ['class' => 'form-control qty ', 'required', 'type' =>
                            'text']) }}
                        </td>
                        <td>
                            {{ Form::number('price[]', $item->price, ['class' => 'form-control price-input price ', 'oninput' =>
                            "validity.valid||(value=value.replace(/[e\+\-]/gi,''))", 'min' => '0', 'value' => '0',
                            'step' => '.01', 'pattern' => "^\d*(\.\d{0,2})?$", 'required', 'onKeyPress' =>
                            'if(this.value.length==8) return false;']) }}
                        </td>
                        <td class="text-end item-total pt-8 text-nowrap">
                            {{ number_format($item->quantity * $item->price, 2) }}
                        </td>
                        <td>
                            @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="Item Image" style="max-width: 50px;">
                            @endif
                            {{ Form::file('images[]', ['class' => 'form-control', 'accept' => 'image/*']) }}
                        </td>
                        <td class="text-end">
                            <button type="button" title="Delete"
                                class="btn btn-icon fs-3 text-danger btn-active-color-danger delete-invoice-item">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>


<div class = "row mb-5">
    <div class = "col-12 mb-5">
        {{ Form::label('terms', __('messages.quote.terms') . ':', ['class' => 'form-label mb-3']) }}
        {{ Form::textarea('term', null, [
             'class' => 'form-control ckeditor',
             'rows'  => 5,
             'style' => 'height: 120px;',
             'placeholder' => __('messages.quote.enter_terms'),
             'id' => 'term-editor',
         ]) }}
    </div>
</div>
<div class = "row mb-5">
    <div class = "col-12 mb-5">
        {{ Form::label('notes', __('messages.quote.notes') . ':', ['class' => 'form-label mb-3']) }}
        {{ Form::textarea('note', $quote->notes, [
            'class' => 'form-control ckeditor',
            'rows' => 5,
            'style' => 'height: 120px;',
            'placeholder' => __('messages.quote.enter_notes'),
            'id' => 'note-editor',
        ]) }}
    </div>
</div>

<!-- Total Amount Field -->
{{ Form::hidden('amount', $quote->amount, ['class' => 'form-control', 'id' => 'total_amount']) }}
<!-- Final Amount Field -->
{{ Form::hidden('final_amount', $quote->final_amount, ['class' => 'form-control', 'id' => 'finalTotalAmt']) }}
<!-- Submit Field -->
<div class="float-end">
    <div class="form-group col-sm-12">

        <button type="submit" name="save" class="btn btn-primary mx-1 ms-ms-3 mb-3 mb-sm-0" id="saveAndSend"
            data-status="1" value="1">{{ __('messages.common.save') }}
        </button>
        <a href="{{ route('purchase.index') }}" class="btn btn-secondary btn-active-light-primary">{{
            __('messages.common.cancel') }}</a>
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
               <textarea name = "product_name[]" class = "form-control" required rows = "2" placeholder = "Select product or enter free text"></textarea>

                </td>
                <td    class = "table__qty">
                <input type  = "number" name = "quantity[]" class = "form-control qty" required min = "0" step = ".01" value = "1">
                </td>
                <td>
                    <input type = "number" name = "price[]" class = "form-control price-input price" required min = "0" step = ".01" value = "0">
                </td>

                <td class = "text-end item-total pt-8 text-nowrap">0.00</td>
                                <td>
    <input type="file" name="images[]" class="form-control" accept="image/*" >
</td>

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
            let               qty                        = parseFloat(row.querySelector('.qty').value) || 0;
            let               price                      = parseFloat(row.querySelector('.price').value) || 0;
            let               total                      = qty * price;
            row.querySelector('.item-total').textContent = total.toFixed(2);
            updateTotalAmount();
        }

          // Function to update total invoice amount
        function updateTotalAmount() {
            let totalAmount = 0;
            document.querySelectorAll('.invoice-item-container .tax-tr').forEach(row => {
                totalAmount += parseFloat(row.querySelector('.item-total').textContent) || 0;
            });
            document.getElementById('total_amount').value  = totalAmount.toFixed(2);
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
    document.addEventListener('DOMContentLoaded', function () {


        $('#client_id').change(function() {
            var clientId = $(this).val();
            console.log(clientId);
            if (clientId) {
                $.ajax({
                    url: '{{ route("quotes.getLastQuoteId") }}',
                    type: 'GET',
                    data: { client_id: clientId },
                    success: function(response) {
                        // Handle the response, e.g., update a hidden input with the last invoice ID

                        $('#quoteId').val(response.last_quote_id);
                    },
                    error: function(e) {
                        alert('An error occurred while fetching the last invoice ID.');
                    }
                });
            }
        });

    });
</script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.CKEDITOR) {
            CKEDITOR.replace('term-editor');
            CKEDITOR.replace('note-editor');
        }
    });
</script>
