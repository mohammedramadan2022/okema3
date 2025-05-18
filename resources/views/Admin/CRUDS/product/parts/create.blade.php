<!--begin::Form-->
<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('products.store') }}">
    @csrf
    <div class="row g-4">
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="is_active" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.Category')}}</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <select class="form-control" id="category_id" name="category_id">
                <option value="">{{__('admin.Select')}}</option>

                @foreach($categories as $category)

                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.name')}}<span class="red-star">*</span></span>
            </label>
            <input required type="text" class="form-control form-control-solid" placeholder="" name="name" value=""/>
        </div>
     {{--    <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.code')}}<span class="red-star">*</span></span>
            </label>
            <input required type="text" class="form-control form-control-solid" placeholder="" name="code" value=""/>
        </div> --}}
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.original_code')}}<span class="red-star">*</span></span>
            </label>
            <input required type="text" class="form-control form-control-solid" placeholder="" name="original_code" value=""/>
        </div>
        <div   class = "d-flex flex-column mb-7 fv-row col-sm-6">
        <label class = "d-flex align-items-center fs-6 fw-bold form-label mb-2">
        <span  class = "required mr-1">{{__('admin.buy_price')}}<span class = "red-star">*</span></span>
            </label>
        <input required type = "number" class = "form-control form-control-solid" placeholder = "" name = "buy_price" value = ""/>
        </div>
        <div class = "d-flex flex-column mb-7 fv-row col-sm-6">
        <label class      = "d-flex align-items-center fs-6 fw-bold form-label mb-2">
        <span  class      = "required mr-1">{{__('admin.sale_price')}}<span class = "red-star">*</span></span>
            </label>
            <input required type = "number" class = "form-control form-control-solid" placeholder = "" name = "sale_price" value = ""/>
        </div>
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.description')}}<span class="red-star">*</span></span>
            </label>
            <input required type="text" class="form-control form-control-solid" placeholder="" name="description" value=""/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <label for="name" class="form-control-label">{{__('admin.image')}} </label>
            <input type="file" class="dropify" name="image" data-default-file="{{get_file()}}" accept="image/*"/>
            <span
                class="form-text text-muted text-center">{{__('admin.only this extensions available')}}: jpeg، jpg، png، gif، svg، webp، avif.</span>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="is_active" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.status')}}</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <select class="form-control" id="is_active" name="is_active">

                <option value="1">{{__('admin.Active')}}</option>
                <option value="0">{{__('admin.Not Active')}}</option>

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
