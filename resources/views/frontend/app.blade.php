<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @if(!(empty(substr(config('siteIcon'), 1))))<link rel="icon" type="image/png" href="{{ asset(config('siteIcon')) }}" />
        @endif

        {{-- opengraph meta tags --}}
        <meta property="og:url" content="{{Request::url()}}" />
    @if (isset($openGraph))
        <meta property="og:type" content="{{$openGraph['type']}}" />
        <meta property="og:title"content="{{$openGraph['title']}}" />
        <meta property="og:description" content="{{$openGraph['description']}}" />
        <meta property="og:image"content="{{ asset($openGraph['image']) }}" />
    @endif

        <title>{{ config('siteName') }}</title>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"
                integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js"
                integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous"></script>
        <script src="{{ asset('js/infinite-scroll.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/simple-lightbox.min.js') }}"></script>
        <script src="https://www.google.com/recaptcha/api.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
        crossorigin=""/>

        <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
        crossorigin=""></script>


        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/frontend.css') }}" rel="stylesheet">
        <link href="{{ asset('css/simplelightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">

        <style type="text/css">
            :root {
                --site-color: {{config('siteColor')}};
                --site-color-alpha: {{config('siteColorAlpha')}};
                --site-color-light: {{config('siteColorLight')}};
                --site-color-text: {{config('siteColorText')}};
                --site-color-light-text: {{config('siteColorLightText')}};

            }
        </style>
    </head>
    <body class="p-0">

        @include('layouts.frontend.menu')

        @yield('content')

        @include('layouts.frontend.footer')

        @yield('js')

    </body>
</html>
