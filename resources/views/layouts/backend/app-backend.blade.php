<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('siteName') }}</title>

        @if(!(empty(substr(config('siteIcon'), 1))))<link rel="icon" type="image/png" href="{{ config('siteIcon') }}" />
        @endif
        <script  src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.min.css') }}"/>
        <link href="{{ asset('css/backend.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/typeahead.css') }}">


        <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js"
        integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous"></script>

        

        <style type="text/css">
            :root {
                --site-color: {{config('siteColor')}};
                --site-color-light: {{config('siteColorLight')}};
                --site-color-text: {{config('siteColorText')}};
                --site-color-light-text: {{config('siteColorLightText')}};
            }
        </style>
    </head>
    @php
        $modules = App\Model\Module::where('is_active',1)->pluck('name');
    @endphp
    <body @if(!Auth::check()) class="bg-color" @endif>
        <div id="app">
            <div class="row no-gutters">
                <div class="col-md-2 min-height">
                     
                        <img class="bg-white mb-1 ml-4 pt-2" height="50" src="{{ asset(config('siteLogoBig')) }}" alt="{{config('siteName')}}.net">
                    <nav class="navbar navbar-light bg-color h-100 align-items-start" id="topMenu">
                        <div class="container ">
                            <ul class="navbar-nav mr-auto">
                                <!-- <li class="nav-item {{(Request::is('adm') ? 'active' : '')}}">
                                    <a class="nav-link" href="{{ url('/') }}">Dashboard</a>
                                </li> -->
                                <li class="text-white nav-item {{(Request::is('/') ? 'active' : '')}}">
                                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                                </li>
                                <li class="text-white nav-item {{(Request::is('bedrijvengids','bedrijvengids/*') ? 'active' : '')}}">
                                    <a class="nav-link" href="{{ url('/bedrijvengids') }}">Bedrijvengids</a>
                                </li>
                                <div class="dropdown-divider"></div>
                                <li class="nav-item"><a href="{{ url('/adm/bedrijvengids') }}" class="nav-link {{(Request::is('adm/bedrijvengids/*')||Request::is('adm/bedrijvengids') ? 'active' : '')}}">Back-end Bedrijvengids</a>
                                </li>
                                {{-- onderstaande pagina's weergeven als gebruiker zich op de bedrijvengids pagina bevindt. --}}
                                @if(Request::is('adm/bedrijvengids/*')||Request::is('adm/bedrijvengids')||Request::is('adm/bedrijfsmutaties')||Request::is('adm/bedrijfsmutaties/*')||Request::is('adm/bedrijfstypes')||Request::is('adm/bedrijfstypes/*'))
                                    <li class="nav-item">
                                        <a class="nav-link pl-4" href="{{url('/adm/bedrijvengids/aanpassingen')}}">-Wijzigingen</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link pl-4" href="{{url('/adm/bedrijvengids/create')}}">-Toevoegen</a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a class="nav-link pl-4" href="{{url('/adm/bedrijvengids/categorie')}}">-Categorie&euml;n</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link pl-4" style="width:162px;" href="{{url('/adm/bedrijvengids/subcategorie')}}">-Subcategorie&euml;n</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link pl-4" href="{{url('/adm/bedrijfstypes')}}">-Types</a>
                                    </li> -->
                                @endif
                            </ul>
                        </div>
                    </nav>
                </div>

                <style>
                    .full-height {
                        height: 100%;
                    }
                </style>

                <div class="col-md-10 bg-grey full-height">
                    @yield('content')
                </div>
                <script src="{{ asset('js/popper.min.js') }}"></script>
                <script src="{{ asset('js/jquery.highlight.js') }}"></script>
                <script src="{{ asset('js/jquery.selectlistactions.js') }}"></script>

                <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
                <script src="{{ asset('js/tagsinput.js') }}"></script>
                <script src="{{ asset('js/typeahead.js') }}"></script>
                <script src="{{ asset('js/bootstrap.min.js') }}"></script>
                <script src="{{ asset('js/delete.js') }}"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

                <script type="text/javascript">
                    $(function() {
                        // setTimeout() function will be fired after page is loaded
                        // it will wait for 5 sec. and then will fire
                        // $("#message").hide() function
                        setTimeout(function() {
                            $("#message").hide(500)
                        }, 5000);
                    });
                </script>
                @yield('js')
            </div>
        </div>
    </body>
</html>
