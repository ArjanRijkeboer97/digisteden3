
<header id="top" class="bg-white">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand m-0 p-0" href="{{ url('/') }}">
            <img id="city-logo" src="{{ asset(config('siteLogoBig')) }}">
        </a>

        <button type="button" class="navbar-toggler collapsed d-block d-lg-none" data-toggle="collapse" data-target="#topMenuCollapse">
            <i class="fas fa-bars"></i> Menu
        </button>
    </div>
</header>

<nav id="topMenu" class="navbar navbar-expand-lg bg-white p-0">
    <div class="container hidden-s">
        <div class="collapse navbar-collapse order-2 order-lg-1" id="topMenuCollapse">
            <ul class="nav navbar-nav">
                <li class="text-white nav-item {{(Request::is('/') ? 'active' : '')}}">
                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li>
                @if(in_array('Bedrijvengids',config('activeModules')))
                    <li class="text-white nav-item {{(Request::is('bedrijvengids','bedrijvengids/*') ? 'active' : '')}}">
                        <a class="nav-link" href="{{ url('/bedrijvengids') }}">Bedrijvengids</a>
                    </li>
                @endif
                <li class="text-white nav-item {{(Request::is('adm/bedrijvengids','bedrijvengids/*') ? 'active' : '')}}">
                    <a class="nav-link" href="{{ url('/adm/bedrijvengids') }}">back-end bedrijvengids</a>
                </li>
            </ul>
        </div>
        
    </div>
</nav>
