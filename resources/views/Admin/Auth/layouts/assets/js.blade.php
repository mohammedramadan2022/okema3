<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{asset('assets/dashboard')}}/plugins/global/plugins.bundle.js"></script>
<script src="{{asset('assets/dashboard')}}/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{asset('assets/dashboard')}}/js/custom/authentication/sign-in/general.js"></script>
<!--end::Page Custom Javascript-->
<!--end::Javascript-->  
<script>
    window.addEventListener('online', () =>{
        alertify.success('عادت خدمة الانترنت !');
    });
    window.addEventListener('offline', () =>{
        alertify.error('لا يوجد خدمة انترنت !');
    });

</script>
@yield('js')
