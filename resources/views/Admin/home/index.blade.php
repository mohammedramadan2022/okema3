@extends('Admin.layouts.inc.app')
@section('title')
احصائيات عامة
@endsection
@section('css')

    <style>
        .border {
            padding: 20px; /* زيادة المسافة داخل كل عداد */
            min-width: 200px; /* تعيين الحد الأدنى للعرض */
        }

        .fs-2 {
            font-size: 2.5rem; /* زيادة حجم الأرقام */
        }

        .fw-semibold {
            font-size: 1.25rem; /* زيادة حجم النص */
        }

    </style>
@endsection

@section('toolbar')

    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                 data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                 class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Dashboard
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">#XRS-45670</small>
                    <!--end::Description--></h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center py-1">
                <!--begin::Wrapper-->
                <div class="me-4">
                    <!--begin::Menu-->
                    <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder"
                       data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                        <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                fill="black"/>
                        </svg>
                    </span>
                        <!--end::Svg Icon-->Filter</a>
                    <!--begin::Menu 1-->
                    <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                         id="kt_menu_61233a943d1f9">
                        <!--begin::Header-->
                        <div class="px-7 py-5">
                            <div class="fs-5 text-dark fw-bolder">Filter Options</div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Menu separator-->
                        <div class="separator border-gray-200"></div>
                        <!--end::Menu separator-->
                        <!--begin::Form-->
                        <div class="px-7 py-5">
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <!--begin::Label-->
                                <label class="form-label fw-bold">Status:</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div>
                                    <select class="form-select form-select-solid" data-kt-select2="true"
                                            data-placeholder="Select option"
                                            data-dropdown-parent="#kt_menu_61233a943d1f9" data-allow-clear="true">
                                        <option></option>
                                        <option value="1">Approved</option>
                                        <option value="2">Pending</option>
                                        <option value="2">In Process</option>
                                        <option value="2">Rejected</option>
                                    </select>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <!--begin::Label-->
                                <label class="form-label fw-bold">Member Type:</label>
                                <!--end::Label-->
                                <!--begin::Options-->
                                <div class="d-flex">
                                    <!--begin::Options-->
                                    <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                        <input class="form-check-input" type="checkbox" value="1"/>
                                        <span class="form-check-label">Author</span>
                                    </label>
                                    <!--end::Options-->
                                    <!--begin::Options-->
                                    <label class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="2" checked="checked"/>
                                        <span class="form-check-label">Customer</span>
                                    </label>
                                    <!--end::Options-->
                                </div>
                                <!--end::Options-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <!--begin::Label-->
                                <label class="form-label fw-bold">Notifications:</label>
                                <!--end::Label-->
                                <!--begin::Switch-->
                                <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="" name="notifications"
                                           checked="checked"/>
                                    <label class="form-check-label">Enabled</label>
                                </div>
                                <!--end::Switch-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2"
                                        data-kt-menu-dismiss="true">Reset
                                </button>
                                <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply
                                </button>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Form-->
                    </div>
                    <!--end::Menu 1-->
                    <!--end::Menu-->
                </div>
                <!--end::Wrapper-->
                <!--begin::Button-->
                <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app"
                   id="kt_toolbar_primary_button">Create</a>
                <!--end::Button-->
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->

@endsection


@section('content')



    <div class="row">
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="" class="text-center bg-white d-block  rounded-3 mb-3 ItemStatistics">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-primary p-2 mb-0">
                    إجمالي المستخدمين
                </p>
                <h2 class="py-4 mb-0 text-primary"><span data-kt-countup="true" data-kt-countup-value="{{$users}}"
                                                         class="counter-value">0</span>
                </h2>
            </a>
        </div><!-- end col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="" class="text-center bg-white d-block  rounded-3 mb-3 ItemStatistics">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-warning p-2 mb-0">
                    إجمالي المستخدمين (العضويات المجانية) </p>
                <h2 class="py-4 mb-0 text-warning"><span class="counter-value" data-kt-countup="true"
                                                         data-kt-countup-value="{{$ordinary_users}}">0</span>
                </h2>
            </a>
        </div><!-- end col -->

        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="" class="text-center bg-white d-block  rounded-3 mb-3 ItemStatistics">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-dark p-2 mb-0">
                    إجمالي المشتركين (العضويات المدفوعة)
                </p>
                <h2 class="py-4 mb-0 text-info"><span class="counter-value"
                                                      data-kt-countup="true"
                                                      data-kt-countup-value="{{$distinct_users}}">0</span>
                    <span class="fs-5 text-muted">  </span>
                </h2>
            </a>
        </div><!-- end col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="#" class="text-center bg-white d-block  rounded-3 mb-3 ItemStatistics">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-danger p-2 mb-0 ">
                    إجمالي المنشورات
                </p>
                <h2 class="py-4 mb-0 text-danger"><span class="counter-value"
                                                        data-kt-countup="true"
                                                        data-kt-countup-value="{{$portfolios}}">0</span>
                    <span class="fs-5 text-muted">  </span>
                </h2>
            </a>
        </div><!-- end col -->


        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="#" class="text-center bg-white d-block  rounded-3 mb-3 ItemStatistics">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-info p-2 mb-0">
                    إجمالي الحملات التسويقية
                </p>
                <h2 class="py-4 mb-0 text-primary"><span class="counter-value" data-kt-countup="true"
                                                         data-kt-countup-value="{{$shopping_campaign}}">0</span>
                </h2>
            </a>
        </div><!-- end col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="" class="text-center bg-white d-block  rounded-3 mb-3 ItemStatistics">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-danger p-2 mb-0">
                    إجمالي الحساب الموثقة
                </p>
                <h2 class="py-4 mb-0 text-warning"><span class="counter-value" data-kt-countup="true"
                                                         data-kt-countup-value="{{$verified_users}}">0</span>
                </h2>
            </a>
        </div><!-- end col -->

        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="" class="text-center bg-white d-block  rounded-3 mb-3 ItemStatistics">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 p-2 mb-0" style="background: #2e4fb1 !important;">
                    إجمالي طلبات التوثيق
                </p>
                <h2 class="py-4 mb-0 text-info"><span class="counter-value"
                                                      data-kt-countup="true"
                                                      data-kt-countup-value="{{$verified_user_requests}}">0</span>
                    <span class="fs-5 text-muted">  </span>
                </h2>
            </a>
        </div><!-- end col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="" class="text-center bg-white d-block  rounded-3 mb-3 ItemStatistics">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-success p-2 mb-0">
                    إجمالي الحسابات النشطة
                </p>
                <h2 class="py-4 mb-0 text-danger"><span class="counter-value"
                                                        data-kt-countup="true"
                                                        data-kt-countup-value="100">0</span>
                    <span class="fs-5 text-muted">  </span>
                </h2>
            </a>
        </div><!-- end col -->


        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="" class="text-center bg-white d-block  rounded-3 mb-3 ItemStatistics">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-primary p-2 mb-0">
                    إجمالي الحسابات غير النشطة
                </p>
                <h2 class="py-4 mb-0 text-primary"><span data-kt-countup="true"
                                                         data-kt-countup-value="{{$blocked_users}}"
                                                         class="counter-value">0</span>
                </h2>
            </a>
        </div><!-- end col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="#" class="text-center bg-white d-block  rounded-3 mb-3 ItemStatistics">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-warning p-2 mb-0">
                    إجمالي زوار المنصة
                </p>
                <h2 class="py-4 mb-0 text-warning"><span class="counter-value" data-kt-countup="true"
                                                         data-kt-countup-value="4500">0</span>
                </h2>
            </a>
        </div><!-- end col -->

        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="#" class="text-center bg-white d-block  rounded-3 mb-3 ItemStatistics">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-dark p-2 mb-0">
                    إجمالي المتواجدين حاليا
                </p>
                <h2 class="py-4 mb-0 text-info"><span class="counter-value"
                                                      data-kt-countup="true" data-kt-countup-value="{{$online_users}}">0</span>
                    <span class="fs-5 text-muted">  </span>
                </h2>
            </a>
        </div><!-- end col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="" class="text-center bg-white d-block  rounded-3 mb-3 ItemStatistics">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-danger p-2 mb-0">
                    إجمالي الرسائل
                </p>
                <h2 class="py-4 mb-0 text-danger"><span class="counter-value"
                                                        data-kt-countup="true"
                                                        data-kt-countup-value="{{$contacts}}">0</span>
                    <span class="fs-5 text-muted">  </span>
                </h2>
            </a>
        </div><!-- end col -->


        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="#" class="text-center bg-white d-block  rounded-3 mb-3 ItemStatistics">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-dark p-2 mb-0">
                    إجمالى المشاهدات
                </p>
                <h2 class="py-4 mb-0 text-info"><span class="counter-value"
                                                      data-kt-countup="true" data-kt-countup-value="{{$views}}">0</span>
                    <span class="fs-5 text-muted">  </span>
                </h2>
            </a>
        </div><!-- end col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="#" class="text-center bg-white d-block  rounded-3 mb-3 ItemStatistics">
                <p class="text-uppercase fw-bold text-white text-truncate rounded-3 bg-danger p-2 mb-0">
                    إجمالي الإعجابات
                </p>
                <h2 class="py-4 mb-0 text-danger"><span class="counter-value"
                                                        data-kt-countup="true"
                                                        data-kt-countup-value="{{$likes}}">0</span>
                    <span class="fs-5 text-muted">  </span>
                </h2>
            </a>
        </div><!-- end col -->


    </div>

    <form action="{{route('admin.index')}}" method="GET" id="form">
        <div class="row mb-10">

            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                <div class="row">
                    <div class="col-md-4">
                        <label for="type">حدد الفترة</label>
                        <select class="form-control" id="type" name="type">
                            <option selected value="">الكل</option>
                            <option value="day">اليوم</option>
                            <option value="week">الاسبوع</option>
                            <option value="month">الشهر</option>
                            <option value="year">السنة</option>
                        </select>

                    </div>
                    <div class="col-md-4">
                        <label for="from">من تاريخ</label>
                        <input type="date" class="form-control" name="from" id="from">
                    </div>
                    <div class="col-md-4">
                        <label for="to">الي تاريخ</label>
                        <input type="date" class="form-control" name="to" id="to">
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <button id="submit" class="btn btn-success w-100 mt-7">بحث</button>
            </div>
        </div>

    </form>

    <div class="card mb-7">
        <div class="card-body">
            <div id="chart_container">
                @include('Admin.home.parts.analysis')
            </div>
        </div>
    </div>

@endsection


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // إعداد الرسم البياني بشكل افتراضي
        const ctx = document.getElementById('myChart');

        let myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['إجمالي المستخدمين', 'إجمالي المستخدمين (العضويات المجانية)', 'إجمالي المشتركين (العضويات المدفوعة)', 'إجمالي المنشورات', 'إجمالي الحملات التسويقية', 'إجمالي الحساب الموثقة','إجمالي طلبات التوثيق', 'إجمالي الحسابات النشطة', 'إجمالي الحسابات غير النشطة', 'إجمالي المتواجدين حاليا', 'إجمالي الرسائل', 'إجمالى المشاهدات','إجمالي الإعجابات'],
                datasets: [{
                    label: '# of Votes',
                    data: [{{$users}}, {{$ordinary_users}}, {{$distinct_users}}, {{$portfolios}}, {{$shopping_campaign}}, {{$verified_users}},{{$verified_user_requests}}, 100, {{$blocked_users}}, {{$online_users}}, {{$contacts}}, {{$views}},{{$likes}}],
                    borderWidth: 1,
                    backgroundColor: [
                        '#FF5733', '#33FF57', '#3357FF', '#FF33A1', '#F4FF33', '#33FFF4',
                        '#F433FF', '#FF8333', '#33A1FF', '#FF5733', '#F4F433', '#33FF57', '#FF33A1'
                    ]
                }]
            },
            options: {
                scales: {
                    x: {
                        grid: {
                            display: false // لإزالة الخطوط العرضية
                        }
                    },
                    y: {
                        grid: {
                            display: false // لإزالة الخطوط الطولية
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        // عندما يتم إرسال النموذج عبر AJAX
        $(document).on('submit', "form#form", function (e) {
            e.preventDefault();  // منع إرسال النموذج بشكل تقليدي

            var formData = $(this).serialize();  // جمع البيانات من النموذج

            var url = $('#form').attr('action'); // الحصول على رابط الـ action من النموذج

            $.ajax({
                url: url,
                type: 'GET',
                data: formData,  // إرسال بيانات النموذج مع الفلاتر كـ query string
                beforeSend: function () {
                    // تحديث النص في زر البحث أثناء انتظار الرد
                    $('#submit').html('<span class="spinner-border spinner-border-sm mr-2"></span> <span style="margin-left: 4px;">جاري التنفيذ</span>')
                        .attr('disabled', true);
                },
                complete: function () {
                    // يمكن إعادة تمكين الزر أو إضافة أي وظيفة بعد انتهاء الطلب
                },
                success: function (data) {
                    // عندما ننجح في الحصول على البيانات
                    $('#submit').html('بحث').attr('disabled', false);

                    // تحديث البيانات في الرسم البياني باستخدام البيانات المستلمة من الخادم
                    myChart.data.datasets[0].data = [
                        data.users, data.ordinary_users, data.distinct_users, data.portfolios,
                        data.shopping_campaign, data.verified_users, data.verified_user_requests,
                        data.active_users, data.blocked_users, 2,data.contacts, data.views,
                        data.likes
                    ];

                    // تحديث الرسم البياني بعد تغيير البيانات
                    myChart.update();
                },
                error: function (data) {
                    // في حالة حدوث خطأ، إعادة تمكين الزر
                    $('#submit').html('بحث').attr('disabled', false);
                    if (data.status === 500) {
                        toastr.error('{{helperTrans('admin.there is an error')}}');
                    }

                    if (data.status === 422) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function (key, value) {
                                    toastr.error(value);
                                });
                            }
                        });
                    }

                    if (data.status == 421) {
                        toastr.error(data.message);
                    }
                },
                cache: false,
                processData: false,  // لا نحتاجه هنا لأننا نرسل بيانات بـ GET
                contentType: false   // لا نحتاجه أيضاً لأننا نرسل بيانات عبر GET
            });
        });

    </script>


@endsection
