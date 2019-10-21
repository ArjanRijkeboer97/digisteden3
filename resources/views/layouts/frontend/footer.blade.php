<footer class="bg-color">
    <div class="container py-4">
        <div class="row">
            <div class="col-12 col-md-3 mb-3 mb-md-0">
                {!! config('siteSettings')->footer_1!!}
            </div>

            <div class="col-12 col-md-3 mb-3 mb-md-0">
                {!! config('siteSettings')->footer_2!!}
            </div>

            <div class="col-12 col-md-3 mb-3 mb-md-0">
                {!! config('siteSettings')->footer_3!!}
            </div>

            <div class="col-12 col-md-3">
                {!! config('siteSettings')->footer_4!!}
            </div>
        </div>
    </div>

    <div class="copyright py-3 position-relative">
        <div class="container">
            <div class="row">
            <div class="col-12 col-md-9 text-center text-md-left">
            <i class="far fa-copyright"></i> {{ config('domain') }}
            </div>
            <div class="col-12 col-md-3 text-center text-md-left">
            <p class="m-0"><a href="/contact" title="Contact">Contact</a> | <a href="/disclaimer" title="Disclaimer">Disclaimer</a></p>
            </div>
        </div>
        </div>
    </div>
</footer>
