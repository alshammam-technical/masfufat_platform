<footer class="footer mt-auto @yield('footer')">
    <div class="container-lg">
        <div class="footer-links">
            <div class="row row-cols-auto justify-content-center gx-0 gy-3">

            </div>
        </div>
        <p class="copyright mb-0">&copy; <span data-year></span> {{ config('app.name', 'Masfufat') }} -
            {{ \App\CPU\Helpers::translate('All rights reserved') }}.</p>
    </div>
</footer>
