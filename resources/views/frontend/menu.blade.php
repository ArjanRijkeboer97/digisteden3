
<header id="top" class="bg-white">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand m-0 p-0" href="{{ url('/') }}">
            <img id="city-logo" src="{{ asset(config('siteLogoBig')) }}">
        </a>

        <button type="button" class="navbar-toggler collapsed d-block d-lg-none" data-toggle="collapse" data-target="#topMenuCollapse">
            <i class="fas fa-bars"></i> Menu
        </button>
    @if (config('siteBanner') !== '')
        <div id="city-text" class="d-none d-lg-block text-right" style="background-image:url({{ asset(config('siteBanner')) }});">
            <div class="skew" style="color:#000; background-color: #fff6;">
                <p class="m-0 date">{{Date::now()->format('l j F Y')}}</p>
                <p class="m-0 text-big">{!! config('siteSlogan') !!}</p>
            </div>
        </div>
    @else
        <div id="city-text" class="d-none d-lg-block text-right">
            <p class="m-0 date">{{Date::now()->format('l j F Y')}}</p>
            <p class="m-0 text-big" style="color:#000;">{!! config('siteSlogan') !!}</p>
        </div>
    @endif
    </div>
</header>

<nav id="topMenu" class="navbar navbar-expand-lg bg-white p-0">
    <div class="container hidden-s">
        <div class="collapse navbar-collapse order-2 order-lg-1" id="topMenuCollapse">
            <ul class="nav navbar-nav">
                <li class="text-white nav-item {{(Request::is('/') ? 'active' : '')}}">
                    <a class="nav-link" href="{{ url('/') }}">Beginpagina</a>
                </li>
                @if(in_array('Nieuws',config('activeModules')))
                    <li class="text-white nav-item dropdown {{(Request::is('nieuws','nieuws/*','nieuwscategorie', 'nieuwscategorie/*', 'nieuwsarchief', 'nieuwsarchief/*', 'nieuws-melden') ? 'active' : '')}}">
                        <a class="nav-link" id="newsDropdown" href="/nieuws" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">Nieuws</a>
                        <div class="dropdown-menu drop-menu-avant" aria-labelledby="newsDropdown">
                            <a class="dropdown-item" href="/nieuws">Alle nieuws</a>
                            <div class="dropdown-divider"></div>
                            @foreach(config('newsCategories') as $category)
                                <a class="dropdown-item" href="{{url('/nieuwscategorie/'.strtolower($category->name))}}">{{$category->name}}</a>
                            @endforeach
                            <div class="dropdown-divider"></div>
                            <a href="/nieuwsarchief" class="dropdown-item">Archief</a>
                            <a href="/nieuws-melden" class="dropdown-item">Nieuws melden <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </li>
                @endif
                @if(in_array('Columns',config('activeModules')))
                    <li class="text-white nav-item {{(Request::is('column','column/*') ? 'active' : '')}}">
                        <a class="nav-link" href="{{ url('/column') }}">Columns</a>
                    </li>
                @endif
                @if(in_array('Agenda',config('activeModules')))
                    <li class="text-white nav-item dropdown {{(Request::is('agenda','agenda/*', 'agenda-archief', 'agenda-archief/*', 'activiteit-aanmelden') ? 'active' : '')}}">
                        <a class="nav-link" id="agendaDropdown" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">Agenda</a>
                        <div class="dropdown-menu drop-menu-avant" aria-labelledby="agendaDropdown">
                            <a class="dropdown-item" href="/agenda">Alle activiteiten</a>
                            <div class="dropdown-divider"></div>
                            <a href="/agenda-archief" class="dropdown-item">Archief</a>
                            <a href="/activiteit-aanmelden" class="dropdown-item">Activiteit aanmelden
                            <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </li>
                @endif
                @if(in_array('Bedrijvengids',config('activeModules')))
                    <li class="text-white nav-item {{(Request::is('bedrijvengids','bedrijvengids/*') ? 'active' : '')}}">
                        <a class="nav-link" href="{{ url('/bedrijvengids') }}">Bedrijvengids</a>
                    </li>
                @endif
                @if(in_array('Prikbord',config('activeModules')))
                    <li class="text-white nav-item {{(Request::is('prikbord','prikbord/*') ? 'active' : '')}}">
                        <a class="nav-link" href="{{ url('/prikbord') }}">Prikbord</a>
                    </li>
                @endif
                @if(in_array('Forum',config('activeModules')))
                    <li class="text-white nav-item {{(Request::is('forum','forum/*') ? 'active' : '')}}">
                        <a class="nav-link" href="{{ url('/forum') }}">Forum</a>
                    </li>
                @endif
                @if(in_array('Vacatures',config('activeModules')))
                <li class="text-white nav-item {{(Request::is('vacatures','vacatures/*') ? 'active' : '')}}">
                    <a class="nav-link" href="{{ url('/vacatures') }}">Vacatures</a>
                </li>
            @endif
                <li class="text-white nav-item {{(Request::is('contact','contact/*') ? 'active' : '')}}">
                    <a class="nav-link" href="{{ url('/contact') }}">Contact</a>
                </li>
            </ul>
        </div>
        {!! Form::open(array('route' => 'search', 'id'=>'search-field','class'=>'form-inline form-avant order-1 order-lg-2','autocomplete' => 'true')) !!}
        <div class="input-group">
            <input type="text" name="search" class="form-control rounded-0" placeholder="Zoeken..." value="{{$query ?? ''}}">
            <button class="btn btn-search rounded-0 border-0" type="button" title="Zoeken">
              <i class="fas fa-search"></i>
            </button>
        </div>
        {!! Form::close() !!}
    </div>
</nav>
