<!--begin::Form-->
<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('categories.update', $category->id) }}">
    @csrf
    @method('PUT')
    <div class="row g-4">



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.name')}}<span class="red-star">*</span></span>
            </label>
            <input required type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{ $category->name }}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="is_active" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.status')}}</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <select class="form-control" id="is_active" name="is_active">

                <option value="1" {{$category->is_active == 1 ? 'checked' :''}}>{{__('admin.Active')}}</option>
                <option value="0" {{$category->is_active == 0 ? 'checked' :''}}>{{__('admin.Not Active')}}</option>

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
