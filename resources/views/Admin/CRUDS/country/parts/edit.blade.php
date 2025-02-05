<!--begin::Form-->
<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('owners.update', $owner->id) }}">
    @csrf
    @method('PUT')
    <div class="row g-4">

        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <label for="image" class="form-control-label">الصورة</label>
            <input type="file" class="dropify" name="image" data-default-file="{{ get_file($owner->image) }}" accept="image/*"/>
            <span class="form-text text-muted text-center">يُسمح فقط بالتنسيقات التالية: jpeg، jpg، png، gif، svg، webp، avif.</span>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الاسم<span class="red-star">*</span></span>
            </label>
            <input required type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{ $owner->name }}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الهاتف<span class="red-star">*</span></span>
            </label>
            <input required type="text" class="form-control form-control-solid" placeholder="" name="phone" value="{{ $owner->phone }}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الرقم القومي<span class="red-star">*</span></span>
            </label>
            <input required type="text" class="form-control form-control-solid" placeholder="" name="national_id" value="{{ $owner->national_id }}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">رقم التسجيل<span class="red-star">*</span></span>
            </label>
            <input required type="text" class="form-control form-control-solid" placeholder="" name="register_number" value="{{ $owner->register_number }}"/>
        </div>

    </div>
</form>
<script>
    $('.dropify').dropify();
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });
</script>
