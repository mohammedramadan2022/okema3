<!--begin::Form-->
<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('countries.store') }}">
    @csrf
    <div class="row g-4">

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.name')}}<span class="red-star">*</span></span>
            </label>
            <input required type="text" class="form-control form-control-solid" placeholder="" name="name" value=""/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label for="is_active" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.status')}}</span>
                <span class="red-star">*</span>
            </label>
            <select class="form-control" id="is_active" name="is_active">
                <option value="1">{{__('admin.Active')}}</option>
                <option value="0">{{__('admin.Not Active')}}</option>
            </select>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.country code')}}<span class="red-star">*</span></span>
            </label>
            <input required type="text" class="form-control form-control-solid" placeholder="" name="country_code" value=""/>
        </div>

    </div>
</form>
<script>
    $('.dropify').dropify();
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });
</script>
