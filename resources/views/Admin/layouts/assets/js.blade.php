<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{asset('assets/dashboard')}}/plugins/global/plugins.bundle.js"></script>
<script src="{{asset('assets/dashboard')}}/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{asset('assets/dashboard')}}/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<!--end::Page Vendors Javascript-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{asset('assets/dashboard')}}/js/custom/widgets.js"></script>
<script src="{{asset('assets/dashboard')}}/js/custom/apps/chat/chat.js"></script>
<script src="{{asset('assets/dashboard')}}/js/custom/modals/create-app.js"></script>
<script src="{{asset('assets/dashboard')}}/js/custom/modals/upgrade-plan.js"></script>


<script src="{{url('assets')}}/dashboard/js/jquery.fancybox.min.js"></script>

<script src="{{url('assets')}}/dashboard/backEndFiles/alertify/alertify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- <script src="{{url('assets')}}/dashboard/js/dropify/dropify.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script src="{{url('assets')}}/dashboard/AE_style/AE_script.js"></script>



@yield('js')

<script>
    $('.select2').select2({
        dropdownParent: $('.modal') // المودال الأب
    });
</script>
<script>
    $(document).ready(function () {
        $('.dropify').dropify();
    });
</script>


<script>
    $('.lds-hourglass').fadeOut(1000)
    $.ajaxSetup({
        headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    $(document).on('keyup','.numbersOnly',function () {
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });
</script>


<script>
    window.addEventListener('online', () =>{
        alertify.success('{{helperTrans('admin.Internet service is back!')}}');
    });
    window.addEventListener('offline', () =>{
        alertify.error('{{helperTrans('admin.There is no internet service!')}}');
    });

    $(document).ready(function() {
        // Get the current URL path
        var path = window.location.href;

        // Select all <a> tags within elements with class "menu-link"
        $('.menu-link-active').each(function() {
            // Get the href attribute value
            var href = $(this).attr('href');


            // Check if the href attribute matches the current path
            if (path === href) {
                // Add the 'active' class to the parent element with class 'menu-item'
                $(this).addClass('active');
            } else {
                // Remove the 'active' class if it's not the current page
                $(this).removeClass('active');
            }
        });
    });


</script>


<script>
    @isset(admin()->user()->id)

    $(document).on('click', '.editProfile', function (e) {
        e.preventDefault()
        var id = $(this).attr('id');

        var url = '{{route('admins.show',admin()->user()->id)}}';

        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function () {
                $('.loader-ajax').show()
            },
            success: function (data) {
                $('.loader-ajax').hide()
                $('#profileEdit-addOrDelete').html(data.html);
                $('#profileEdit').modal('show')
                $('#logoOfAdmin').dropify();


            },
            error: function (data) {
                $('.loader-ajax').hide()
                $('#profileEdit-addOrDelete').html('<h3 class="text-center">{{helperTrans('admin.You do not have the authority')}}</h3>')
            }
        });

    });


    $(document).on('submit', 'form#EditForm', function (e) {
        e.preventDefault();
        var myForm = $("#EditForm")[0]
        var formData = new FormData(myForm)
        var url = $('#EditForm').attr('action');
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            beforeSend: function () {
                $('.loader-ajax').show()
            },
            complete: function () {


            },
            success: function (data) {
                $('.loader-ajax').hide()
                $('#profileEdit').modal('hide')
                $(".header-profile-user").attr("src", data.logo);
                $(".user-name-text").html(data.name);
                $(".user-name-sub-text").html(data.business_name);

                // $('#page-header-user-dropdown').html(data[html]);
                toastr.success("{{helperTrans('admin.Your file has been successfully modified')}}")

            },
            error: function (data) {
                $('.loader-ajax').hide()
                if (data.status === 500) {
                    $('#profileEdit').modal("hide");

                }
                if (data.status === 422) {
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function (key, value) {
                        if ($.isPlainObject(value)) {
                            $.each(value, function (key, value) {
                                toastr.error(value)


                            });

                        } else {

                        }
                    });
                }
            },//end error method

            cache: false,
            contentType: false,
            processData: false
        });
    });

    @endisset

    $(document).on('click','.deleteAllNotifications',function (){
        swal.fire({
            title: "هل انت متاكد من الحذف؟",
            text: "لا تستطيع الرجوع فى ذلك",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "حذف",
            cancelButtonText: "الغاء",
            okButtonText: "نعم",
            closeOnConfirm: false
        }).then((result) => {
            if (!result.isConfirmed) {
                return true;
            }


            var deleteRoute = '';
            $.ajax({
                url: deleteRoute,
                type: 'POST',
                beforeSend: function() {
                    $('.loader-ajax').show()

                },
                success: function(data) {

                    window.setTimeout(function() {
                        $('.loader-ajax').hide()
                        if (data.code == 200) {
                            toastr.success(data.message)
                            $('#table').DataTable().ajax.reload(null, false);
                            $('#notification_header_container').html('');
                        } else {
                            toastr.error('there is an error')
                        }

                    }, 1000);
                },
                error: function(data) {

                    if (data.code === 500) {
                        toastr.error('there is an error')
                    }


                    if (data.code === 422) {
                        var errors = $.parseJSON(data.responseText);

                        $.each(errors, function(key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function(key, value) {
                                    toastr.error(value)
                                });

                            } else {

                            }
                        });
                    }
                }

            });
        });
    })



    document.addEventListener('DOMContentLoaded', function () {
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    });

</script>
