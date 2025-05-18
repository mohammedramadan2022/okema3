<div class="row">
    <div class="col-lg-4 col-sm-12 mb-5">
        {{ Form::label('client_id', __('Admin.Client') . ':', ['class' => 'form-label required mb-3']) }}
        {{ Form::select('client_id', $clients->mapWithKeys(fn($client) => [$client->id => $client->name])->toArray(), null, [
            'class' => 'form-select io-select2',
            'id' => 'client_id',
            'placeholder' => __('admin.Select Client'),
            'data-control' => 'select2',
        ]) }}
    </div>

    <div class="col-lg-4 col-sm-12 mb-5">
        {{ Form::label('invoice_id', __('Admin.Invoice') . ':', ['class' => 'form-label required mb-3']) }}
        {{ Form::select('invoice_id', [], null, [
            'class' => 'form-select io-select2',
            'id' => 'invoice_id',
            'placeholder' => __('admin.Select Invoice'),
            'data-control' => 'select2',
            'disabled' => true
        ]) }}
    </div>

    <div class="col-lg-4 col-sm-12 mb-5">
        {{ Form::label('safe_id', __('Admin.Safe') . ':', ['class' => 'form-label required mb-3']) }}
        {{ Form::select('safe_id', $safes->mapWithKeys(fn($safe) => [$safe->id => $safe->name])->toArray(), null, [
            'class'        => 'form-select io-select2',
            'id'           => 'safe_id',
            'id'           => 'safe_id',
            'placeholder'  => __('admin.Safe'),
            'data-control' => 'select2',
        ]) }}
    </div>

    <div class="col-lg-4 col-sm-12 mb-5">
        {{ Form::label('paid_amount', __('admin.Paid Amount') . ':', ['class' => 'form-label required mb-3']) }}
        {{ Form::number('paid_amount', null, [
            'class' => 'form-control',
            'id' => 'paid_amount',
            'step' => '0.01',
            'min' => '0',
            'required' => true,
            'data-invoice-remaining' => '0',
            'disabled' => true
        ]) }}
        <div class="invalid-feedback" id="paid_amount_error"></div>
    </div>

    <div    class = "col-12 mt-5">
    <button type  = "submit" class = "btn btn-primary">
    <i      class = "fas fa-save me-2"></i>{{ __('admin.Save') }}
        </button>
    </div>
</div>

{{-- @push('scripts') --}}
<script>
      document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM Content Loaded');

        // Check if jQuery is loaded
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is not loaded!');
            return;
        }

        // Using jQuery for event binding
        $('#client_id').on('change', function() {
            console.log('Change event triggered');
            var clientId = $(this).val();
            console.log('Selected client ID:', clientId);

            if (clientId) {
                console.log('Client ID exists, proceeding with AJAX call');
                // Enable invoice select
                $('#invoice_id').prop('disabled', false);

                // Fetch invoices for selected client
                $.ajax({
                    url    : '{{ route("admin.payments.get-client-invoices") }}',
                    type   : 'GET',
                    data   : { client_id: clientId },
                    success: function(response) {
                        console.log('AJAX response:', response);
                        const invoices = response;
                        const options = invoices.map(invoice => {
                            return `<option value="${invoice.id}" data-remaining="${invoice.remaining_amount}">
                                ${invoice.invoice_id}  (Remaining: ${invoice.remaining_amount})
                            </option>`;
                        });

                        $('#invoice_id').html('<option value="">Select Invoice</option>' + options.join(''));
                    },
                    error: function(xhr) {
                        console.error('AJAX error:', xhr);
                        toastr.error('Error loading invoices');
                    }
                });
            } else {
                console.log('No client ID selected, resetting form');
                // Reset and disable invoice select
                $('#invoice_id').prop('disabled', true).val('');
                $('#paid_amount').prop('disabled', true).val('');
            }
        });

        $('#invoice_id').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const remainingAmount = parseFloat(selectedOption.data('remaining') || 0);

            $('#paid_amount').prop('disabled', false)
                .attr('data-invoice-remaining', remainingAmount)
                .attr('max', remainingAmount)
                .val('');
        });

        $('#paid_amount').on('input', function() {
            const paidAmount = parseFloat($(this).val());
            const remainingAmount = parseFloat($(this).attr('data-invoice-remaining'));

            if (paidAmount > remainingAmount) {
                $(this).addClass('is-invalid');
                $('#paid_amount_error').text('Paid amount cannot exceed the remaining amount');
            } else {
                $(this).removeClass('is-invalid');
                $('#paid_amount_error').text('');
            }
        });
    });
</script>
{{-- @endpush --}}



