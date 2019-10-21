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

        {!! Charts::styles() !!}

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
                     @if(Auth::check())
                        <img class="bg-white mb-1 ml-4 pt-2" height="50" src="{{ asset(config('siteLogoBig')) }}" alt="{{config('siteName')}}.net">
                    <nav class="navbar navbar-light bg-color h-100 align-items-start" id="topMenu">
                        <div class="container ">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item {{(Request::is('adm') ? 'active' : '')}}">
                                    <a class="nav-link" href="{{ url('/adm') }}">Dashboard</a>
                                </li>
                                <div class="dropdown-divider"></div>
                                @hasanyrole('admin|nieuws-beheerder')
                                    @if($modules->contains('Nieuws'))
                                        <li class="nav-item {{(Request::is('adm/nieuws/*')||Request::is('adm/nieuws') ? 'active' : '')}}">
                                            <a class="nav-link" href="{{ url('/adm/nieuws') }}">Nieuws</a>
                                        </li>
                                        <li class="nav-item {{(Request::is('adm/nieuws/*') || Request::is('adm/nieuwscategorie/*') || Request::is('adm/nieuwscategorie') || Request::is('adm/nieuws') ? '' : 'd-none')}}">
                                            <a class="nav-link pl-4" href="{{url('/adm/nieuws/create')}}">-Toevoegen</a>
                                        </li>
                                        <li class="nav-item {{(Request::is('adm/nieuws/*')||Request::is('adm/nieuws') || Request::is('adm/nieuwscategorie/*')||Request::is('adm/nieuwscategorie') ? '' : 'd-none')}}">
                                            <a class="nav-link pl-4" href="{{url('/adm/nieuwscategorie/')}}">-Categorieën</a>
                                        </li>
                                    @endif
                                @endhasanyrole
                                @hasanyrole('admin|agenda-beheerder')

                                    @if($modules->contains('Agenda'))

                                        <li class="nav-item {{(Request::is('adm/agenda/*')||Request::is('adm/agenda') ? 'active' : '')}}">
                                            <a class="nav-link" href="{{ url('/adm/agenda') }}">Agenda</a>
                                        </li>
                                            <li class="nav-item {{(Request::is('adm/agenda/*')||Request::is('adm/agenda') ? '' : 'd-none')}}">
                                            <a class="nav-link pl-4" href="{{url('/adm/agenda/create')}}">-Toevoegen</a>
                                        </li>
                                    @endif
                                @endhasanyrole
                                @hasanyrole('admin|columnist')
                                    @if($modules->contains('Columns'))
                                        <li class="nav-item {{(Request::is('adm/column/*')||Request::is('adm/column') ? 'active' : '')}}">
                                            <a class="nav-link" href="{{ url('/adm/column') }}">Column</a>
                                        </li>
                                        <li class="nav-item {{(Request::is('adm/column/*')||Request::is('adm/column') ? '' : 'd-none')}}">
                                            <a class="nav-link pl-4" href="{{url('/adm/column/create')}}">-Toevoegen</a>
                                        </li>
                                    @endif
                                @endhasanyrole
                                @hasrole('admin')
                                    @if($modules->contains('Paginas'))

                                        <li class="nav-item {{(Request::is('adm/pagina/*')||Request::is('adm/pagina') ? 'active' : '')}}">
                                            <a class="nav-link" href="{{ url('/adm/pagina') }}">Pagina's</a>
                                        </li>
                                        <li class="nav-item {{(Request::is('adm/pagina/*')||Request::is('adm/pagina') ? '' : 'd-none')}}">
                                            <a class="nav-link pl-4" href="{{url('/adm/pagina/create')}}">-Toevoegen</a>
                                        </li>
                                    @endif
                                    @if($modules->contains('Prikbord'))
                                        <li class="nav-item {{(Request::is('adm/prikbord/*')||Request::is('adm/prikbord') ? 'active' : '')}}">
                                            <a class="nav-link" href="{{ url('/adm/prikbord') }}">Prikbord</a>
                                        </li>
                                        <li class="nav-item {{(Request::is('adm/prikbord/*')||Request::is('adm/prikbord') ? '' : 'd-none')}}">
                                            <a class="nav-link pl-4" href="{{url('/adm/prikbord/create')}}">-Toevoegen</a>
                                        </li>
                                    @endif
                                    @if($modules->contains('Bedrijvengids'))

                                        <li class="nav-item"><a href="{{ url('/adm/bedrijvengids') }}" class="nav-link {{(Request::is('adm/bedrijvengids/*')||Request::is('adm/bedrijvengids') ? 'active' : '')}}">Bedrijvengids</a>
                                        </li>
                                         {{-- onderstaande pagina's weergeven als gebruiker zich op de bedrijvengids pagina bevindt. --}}
                                        @if(Request::is('adm/bedrijvengids/*')||Request::is('adm/bedrijvengids')||Request::is('adm/bedrijfsmutaties')||Request::is('adm/bedrijfsmutaties/*')||Request::is('adm/bedrijfstypes')||Request::is('adm/bedrijfstypes/*'))
                                            <li class="nav-item">
                                                <a class="nav-link pl-4" href="{{url('/adm/bedrijvengids/aanpassingen')}}">-Wijzigingen</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link pl-4" href="{{url('/adm/bedrijvengids/create')}}">-Toevoegen</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link pl-4" href="{{url('/adm/bedrijvengids/categorie')}}">-Categorie&euml;n</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link pl-4" style="width:162px;" href="{{url('/adm/bedrijvengids/subcategorie')}}">-Subcategorie&euml;n</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link pl-4" href="{{url('/adm/bedrijfstypes')}}">-Types</a>
                                            </li>
                                        @endif
                                    @endif
                                    @if($modules->contains('Gebruikers'))

                                        <li class="nav-item"><a href="{{ url('/adm/gebruikers') }}" class="nav-link {{(Request::is('adm/gebruikers/*')||Request::is('adm/gebruikers') ? 'active' : '')}}">Gebruikers</a>
                                        </li>
                                        @if(Request::is('adm/gebruikers/*')||Request::is('adm/gebruikers')||Request::is('adm/roles')||Request::is('adm/roles/*'))
                                        <li class="nav-item">
                                            <a class="nav-link pl-4" href="{{url('/adm/gebruikers/create')}}">-Toevoegen</a>
                                            <a class="nav-link pl-4" href="{{url('/adm/roles')}}">-Rollen</a>
                                        </li>
                                        @endif
                                    @endif
                                    @if($modules->contains('Vacatures'))
                                        <li class="nav-item">
                                            <a href="{{ url('/adm/vacatures') }}" class="nav-link {{(Request::is('adm/vacatures/*')||Request::is('adm/vacatures') ? 'active' : '')}}">Vacatures</a>
                                        </li>
                                        @if(Request::is('adm/vacatures/*')||Request::is('adm/vacatures')||Request::is('adm/vacaturefeeds')||Request::is('adm/vacaturefeeds/*'))
                                        <li class="nav-item">
                                            <a class="nav-link pl-4" href="{{url('/adm/vacaturefeeds')}}">-Feeds</a>
                                        </li>
                                        @endif
                                    @endif
                                    @if($modules->contains('Advertenties'))

                                        <li class="nav-item"><a href="{{ url('/adm/advertenties') }}" class="nav-link {{(Request::is('adm/advertenties/*')||Request::is('adm/advertenties') ? 'active' : '')}}">Advertenties</a>
                                        </li>
                                    @endif
                                    @if($modules->contains('Nieuwsbrieven'))
                                        <li class="nav-item"><a href="{{ url('/adm/nieuwsbrieven') }}" class="nav-link {{(Request::is('adm/nieuwsbrieven/*')||Request::is('adm/nieuwsbrieven') ? 'active' : '')}}">Nieuwsbrieven</a>
                                        </li>

                                        @if(Request::is('adm/nieuwsbrieven/*')||Request::is('adm/nieuwsbrieven')||Request::is('adm/subscribers')||Request::is('adm/subscribers/*')||Request::is('adm/subscribergroups')||Request::is('adm/subscribergroups/*'))
                                            <li class="nav-item">
                                                <a class="nav-link pl-4" href="{{url('/adm/nieuwsbrieven/create')}}">-Toevoegen</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link pl-4" href="{{url('/adm/subscribers')}}">-Inschrijvingen</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link pl-4" href="{{url('/adm/subscribergroups')}}">-Groepen</a>
                                            </li>
                                        @endif
                                    @endif
                                    @if($modules->contains('Tags'))
                                        <li class="nav-item">
                                            <a href="{{ url('adm/tagmanager') }}" class="nav-link {{(Request::is('adm/tagmanager') ? 'active' : '')}}">Tagmanager</a>
                                        </li>
                                    @endif
                                @endhasrole
                                <div class="dropdown-divider"></div>
                                @hasrole('admin')
                                    <li class="nav-item">
                                        <a href="{{ url('adm/modules') }}" class="nav-link {{(Request::is('adm/modules') ? 'active' : '')}}">Modules</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('adm/settings') }}" class="nav-link {{(Request::is('adm/settings') ? 'active' : '')}}">Instellingen</a>
                                    </li>
                                @endhasrole
                                @hasanyrole('admin|columnist')
                                    <li class="nav-item">
                                        <a href="{{ url('bestandsbeheer') }}" class="nav-link {{(Request::is('bestandsbeheer') ? 'active' : '')}}">Bestandsbeheer</a>
                                    </li>
                                @endhasanyrole
                                @include('adm.partials.action_buttons_block')
                            </ul>
                        </div>
                    </nav>
                    @endif
                </div>
                <div class="col-md-10">
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
