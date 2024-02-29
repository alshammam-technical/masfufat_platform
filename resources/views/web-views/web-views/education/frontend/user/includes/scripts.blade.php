@stack('top_scripts')
<script src="{{ asset('/public/assets/vendor/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/public/assets/vendor/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/public/assets/vendor/libs/sweetalert/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/public/assets/vendor/libs/toastr/toastr.min.js') }}"></script>
@stack('scripts_libs')
<script src="{{ asset('/public/assets/js/user/application.js') }}"></script>
<script src="{{ asset('/public/assets/js/extra/extra.js') }}"></script>
@toastr_render
@stack('scripts')
