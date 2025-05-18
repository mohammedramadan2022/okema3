@extends('Admin.layouts.inc.app')
@section('title')
{{__('admin.Admins')}}
@endsection
@section('css')

<link href = "//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel         = "stylesheet" type = "text/css" />
<link href = "https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel = "stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection



@section('content')
<form id="form" enctype="multipart/form-data" method="POST" action="{{route('admins.update',$admin->id)}}">
    @csrf
    @method('PUT')
    <div class="row g-4">


        <input type="hidden" name="id" value="{{$admin->id}}">

        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <label for="name" class="form-control-label">الصورة </label>
            <input type="file" class="dropify" name="image" data-default-file="{{get_file($admin->image)}}"
                   accept="image/*"/>
            <span
                class="form-text text-muted text-center">يُسمح فقط بالتنسيقات التالية: jpeg، jpg، png، gif، svg، webp، avif.</span>
        </div>
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الاسم</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input type="text" required class="form-control form-control-solid" placeholder=" " name="name"
                   value="{{$admin->name}}"/>
        </div>

        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> البريد الالكتروني</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input type="email" required class="form-control form-control-solid"
                   placeholder="  {{helperTrans('admin.email')}}"
                   name="email" value="{{$admin->email}}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="phone" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> الهاتف</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input id="phone" type="text" class="form-control form-control-solid" placeholder=" " name="phone"
                   value="{{$admin->phone}}"/>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> كلمة المرور</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input type="password" class="form-control form-control-solid" placeholder="  " name="password"
                   value=""/>
        </div>



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="is_active" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">حالة التفعيل </span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <select class="form-control" id="is_active" name="is_active">

                <option @if($admin->is_active==1) selected @endif value="1">مفعل</option>
                <option @if($admin->is_active==0) selected @endif value="0">غير مفعل </option>

            </select>
        </div>


     {{--    <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="roles" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الدور</span>
                <span class="red-star">*</span>
            </label>
            <select id="roles" class="js-example-basic-multiple" name="roles[]" multiple="multiple">
                @foreach($roles as $role)
                    <option @foreach($admin_roles_ides as $role_id) @if($role_id==$role->id) selected @endif @endforeach value="{{$role->id}}">{{$role->name??''}}</option>
                @endforeach
            </select>

        </div> --}}



        <div class = "d-flex justify-content-center mt-3">

            <div  class = "col-md-12 p-1">
            <span class = "form-check form-switch  " @if( app()->getLocale()=='en') style = "border:0px solid
                    #F3F3F9;border-radius: 4px;" @else style="border:0px solid #F3F3F9;border-radius: 4px;" @endif>
                    <input class = "form-check-input  " type   = "checkbox" name = "check_all" value = "" id = "check_all">
                    <label class = "form-check-label mx-1" for = "check_all">
                        تحديد الكل
                    </label>
                </span>
            </div>

        </div>
<div class = "row my-4" id = "permission_data">
    @foreach($permissions as $row)
        <div  class = "col-md-3 p-1">
        <span class = "form-check form-switch"
                @if(app()->getLocale() == 'en')
                    style = "border:1px solid #F3F3F9;padding: 10px; padding-left: 40px;border-radius: 4px;"
                @else
                    style = "border: 1px solid #F3F3F9;padding: 10px; padding-right: 40px;border-radius: 4px;"
                @endif>
                <input
                    class = "form-check-input checkbox"
                    type  = "checkbox"
                    name  = "permission[]"
                    value = "{{$row->id}}"
                    id    = "flexCheckDefault{{$row->id}}"
                    @if(in_array($row->id, $admin_permissions_ids)) checked @endif>
                <label class="form-check-label mx-1" for="flexCheckDefault{{$row->id}}">
                    {{$row->name}}
                </label>
            </span>
        </div>
    @endforeach
</div>



<button form="form" type="submit" id="submit" class="btn btn-primary">
    <span class="indicator-label">{{__('admin.Save')}}</span>
</button>


    </div>
</form>
<script>
    $(document).ready(function () {
        $('#check_all').on('change', function () {
            var checked = $(this).is(':checked');        // Check if the checkbox is checked
            $   ('.checkbox').prop('checked', checked);  // Set all checkboxes to the same state
        });
    });
</script>>

@endsection
