@extends('Admin.layouts.inc.app')
@section('title')
{{__('admin.Countries')}}
@endsection
@section('css')

    <style>
        .select2-container {
            z-index: 10000; /* Adjust the value as needed */
        }
    </style>

@endsection

@section('content')

    <!--begin::Tables Widget 11-->
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">{{__('admin.Countries')}}</span>
            </h3>
            <div class="card-toolbar">
                <button id="addBtn" class="btn btn-sm btn-light-primary">
                    <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                    </svg>
                </span>
                    {{__('admin.Add Country')}}</button>
            </div>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table id="table" class="table align-middle gs-0 gy-4 table table-bordered dt-responsive nowrap table-striped align-middle">
                    <thead>
                    <tr class="fw-bolder text-muted bg-light">
                        <th>#</th>
                        <th>{{__('admin.name')}}</th>
                        <th>{{__('admin.status')}}</th>
                        <th>{{__('admin.country code')}}</th>
                        <th>{{__('admin.created at')}}</th>
                        <th>{{__('admin.actions')}}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" data-bs-backdrop="static" id="Modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered modal-lg mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content" id="modalContent">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2><span id="operationType"></span> {{__('admin.Country')}} </h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" style="cursor: pointer"
                         data-bs-dismiss="modal" aria-label="Close">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                      transform="rotate(-45 6 17.3137)"
                                      fill="black"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                      fill="black"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7" id="form-load">

                </div>
                <!--end::Modal body-->
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="reset" data-bs-dismiss="modal" aria-label="Close" class="btn btn-light me-3">
                            {{__('admin.cancel')}}
                        </button>
                        <button form="form" type="submit" id="submit" class="btn btn-primary">
                            <span class="indicator-label">{{__('admin.Save')}}</span>
                        </button>
                    </div>
                </div>
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

@endsection
@section('js')
    <script>
        var columns = [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'is_active', name: 'is_active'},
            {data: 'country_code', name: 'country_code'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ];




        $(document).on('change', '.activeBtn', function () {
            var id = $(this).attr('data-id');

            $.ajax({
                type: 'GET',
                url: "{{route('admin.active.country')}}",
                data: {
                    id: id,
                },

                success: function (res) {
                    if (res['status'] == true) {

                        toastr.success("{{__('admin.operation accomplished successfully')}}")
                        // $('#table').DataTable().ajax.reload(null, false);
                    } else {
                        // location.reload();

                    }
                },
                error: function (data) {
                    // location.reload();
                }
            });


        })


    </script>
    @include('Admin.layouts.inc.ajax',['url'=>'countries'])

    <link href="{{url('assets/dashboard/css/select2.css')}}" rel="stylesheet"/>
    <script src="{{url('assets/dashboard/js/select2.js')}}"></script>


@endsection

