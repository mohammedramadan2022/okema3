<!--begin::Form-->
<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('clients.update' , $client) }}">
   @csrf
    @method('PUT')
    <div class="row g-4">
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.name')}}</span>
                <span class="red-star">*</span>
            </label>
            <input required type="text" class="form-control form-control-solid" name="name" value="{{ $client->name }}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.attention')}}</span>
                <span class="red-star">*</span>
            </label>
            <input required type="text" class="form-control form-control-solid" name="attention" value="{{ $client->attention }}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.Email')}}</span>
                <span class="red-star">*</span>
            </label>
            <input required type="email" class="form-control form-control-solid" name="email" value="{{ $client->email }}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.Contact')}}</span>
            </label>
            <input type="text" class="form-control form-control-solid" name="contact" value="{{ $client->contact }}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.company_name')}}</span>
            </label>
            <input type="text" required class="form-control form-control-solid" name="company_name" value="{{ $client->company_name }}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.invoice_start')}}</span>
            </label>
            <input type="number" class="form-control form-control-solid" name="invoice_start" value="{{ $client->invoice_start }}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.quote_start')}}</span>
            </label>
            <input type="number" class="form-control form-control-solid" name="quote_start" value="{{ $client->quote_start }}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.Address')}}</span>
            </label>
            <input type="text" class="form-control form-control-solid" name="address" value="{{ $client->address }}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label for="is_active" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.Status')}}</span>
                <span class="red-star">*</span>
            </label>
            <select class = "form-control" id = "is_active" name = "is_active">
            <option value = "1" @if ($client->is_active == 1)
                    selected

                @endif>{{__('admin.Active')}}</option>
                <option value="0" @if ($client->is_active == 0)
                    selected

                @endif>{{__('admin.Not Active')}}</option>
            </select>
        </div>
    </div>
</form>

<script>
    $('.dropify').dropify();
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });
</script>
