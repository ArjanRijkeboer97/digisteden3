@if(config('cities')->count() > 0)
    <div class="dropdown mr-2 d-inline float-right my-3">
        <button class="btn btn-menu dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Verander Stad
        </button>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            @foreach(config('cities') as $city)
            <a href="//{{$city->domain}}/adm" style="color: {{$city->color}}" class="dropdown-item">{{$city->name}}</a>
            @endforeach
        </div>
    </div>
@endif
<div class="dropdown dropdown-settings d-inline float-right">
    <button class="btn btn-menu dropdown-toggle" type="button" id="dropdownSettings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-wrench"></i>
    </button>

    <div class="dropdown-menu" aria-labelledby="dropdownSettings">
        <a href="/" class="dropdown-item" target="_blank">Toon website</a>
        <a href="{{ url('/logout') }}" class="dropdown-item">Uitloggen</a>
    </div>
</div>