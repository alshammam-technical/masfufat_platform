@stack('top_scripts')
<script src="{{ asset('/public/assets/education/vendor/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/public/assets/education/vendor/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/public/assets/education/vendor/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('/public/assets/education/vendor/libs/toastr/toastr.min.js') }}"></script>
@stack('scripts_libs')
<script src="{{ asset('/public/assets/education/js/application.js') }}"></script>
<script src="{{ asset('/public/assets/education/js/extra/extra.js') }}"></script>
@stack('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-category').forEach(function (categoryTitle) {
            categoryTitle.addEventListener('click', function () {
                var articlesContainer = this.nextElementSibling;
                var toggleIcon = this.querySelector('.toggle-icon');
                var isHidden = articlesContainer.style.display === 'none' || articlesContainer.style.display === '';

                articlesContainer.style.display = isHidden ? 'block' : 'none';
                // تغيير فئة الأيقونة بناءً على الحالة
                if (isHidden) {
                    toggleIcon.classList.remove('fa-chevron-down');
                    toggleIcon.classList.add('fa-chevron-up');
                } else {
                    toggleIcon.classList.remove('fa-chevron-up');
                    toggleIcon.classList.add('fa-chevron-down');
                }
            });
        });
    });
</script>


