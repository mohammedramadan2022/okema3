<!--begin::Form-->
<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('products.update', $product->id) }}">
    @csrf
    @method('PUT')
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

                    <option value="{{$category->id}}" @if($product->category_id == $category->id) selected @endif>{{$category->name}}</option>
                @endforeach
            </select>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.name')}}<span class="red-star">*</span></span>
            </label>
            <input required type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{$product->name}}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.original_code')}}<span class="red-star">*</span></span>
            </label>
            <input required type="text" class="form-control form-control-solid" placeholder="" name="original_code" value="{{$product->original_code}}"/>
        </div>
        <div   class = "d-flex flex-column mb-7 fv-row col-sm-6">
        <label class = "d-flex align-items-center fs-6 fw-bold form-label mb-2">
        <span  class = "required mr-1">{{__('admin.buy_price')}}<span class = "red-star">*</span></span>
            </label>
        <input     required type = "number" class = "form-control form-control-solid" placeholder = "" name = "buy_price" value = "{{$product->buy_price}}"/>
        </div>
        <div class = "d-flex flex-column mb-7 fv-row col-sm-6">
        <label     class = "d-flex align-items-center fs-6 fw-bold form-label mb-2">
        <span      class = "required mr-1">{{__('admin.sale_price')}}<span class = "red-star">*</span></span>
            </label>
            <input required type = "number" class = "form-control form-control-solid" placeholder = "" name = "sale_price" value = "{{$product->sale_price}}"/>
        </div>
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{__('admin.description')}}<span class="red-star">*</span></span>
            </label>
            <input required type="text" class="form-control form-control-solid" placeholder="" name="description" value="{{$product->description}}"/>
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

                <option value="1" @if($product->is_active == 1) selected @endif>{{__('admin.Active')}}</option>
                <option value="0" @if($product->is_active == 0) selected @endif>{{__('admin.Not Active')}}</option>

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
