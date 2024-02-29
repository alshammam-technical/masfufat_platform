<script type="text/javascript">
    "use strict";
    const BASE_URL = "route('admin.education.home')";
    const PRIMARY_COLOR = "#fdcd05";
    const SECONDARY_COLOR = "#5a409b";
</script>
@stack('top_scripts')
<script src="{{ asset('/public/assets/education/vendor/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/public/assets/education/vendor/libs/jquery/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/public/assets/education/vendor/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/public/assets/education/vendor/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('/public/assets/education/vendor/libs/sweetalert/sweetalert2.min.js') }}"></script>
@stack('scripts_libs')
<script src="{{ asset('/public/assets/education/vendor/libs/toggle-master/bootstrap-toggle.min.js') }}"></script>
<script src="{{ asset('/public/assets/education/vendor/libs/datatable/datatables.jq.min.js') }}"></script>
<script src="{{ asset('/public/assets/education/vendor/libs/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('/public/assets/education/vendor/libs/select2/select2.min.js') }}"></script>
<script src="{{ asset('/public/assets/education/vendor/libs/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('/public/assets/education/vendor/libs/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('/public/assets/education/vendor/admin/js/application.js') }}"></script>
@toastr_render
@stack('scripts')
