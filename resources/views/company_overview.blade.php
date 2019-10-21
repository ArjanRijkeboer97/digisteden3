@extends('layouts.frontend.app')

@php
$unwanted_array = array(
	'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
	'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
    'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
    'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
    'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y'
);

foreach($companies as $company)
{
	$firstLetter = mb_substr(ucfirst($company->name), 0, 1);
		$firstLetter =  strtr( $firstLetter, $unwanted_array );
	if(is_numeric($firstLetter))
	{
		$firstLetter = "0-9";
	}
	$result[$firstLetter][] = $company;
}
@endphp

@section('content')
	<div class="container pt-4">
		@if(session('new'))
			<div class="row">
				<div class="col-lg-10 offset-lg-1 alert alert-success alert-block text-center">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>{{ session('new') }}</strong>
				</div>
			</div>
		@endif
		{{--<div class="row">
			<div class="col-lg-12 py-3">
				<a href="/"><i class="fas fa-home"></i></a> <i class="fas fa-angle-right"></i> Bedrijvengids
			</div>
		</div>--}}

		<div class="row">
			<div class="col-12">
				<h2 class="site-color">Bedrijvengids</h2>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6 selection">
				<div class="row">
					<div class="col-lg-8 alfabet" id="myBtnContainer">
						@foreach (config("alfabet") as $letter)
							<button class="btn btn-sm" onclick="filterSelection('letter{{ucfirst($letter)}}');Reset()" type="button">{{ucfirst($letter)}}</button>
						@endforeach
					</div>

					<div class="col-lg-4 newCompany">
						<select name="menu1" id="menu1" class="w-100 rounded-0">
							<option value="" hidden>Andere digisteden</option>
								@foreach($cities as $city)
								<option value="https://www.{{$city->domain}}/bedrijvengids">{{$city->name}}.net</option>
							@endforeach
							<option value="http://digisteden3.local/bedrijvengids">Uitgeschakeld</option>
						</select>
						<button type="button" class="btn btn-more arrow-right position-relative rounded-0 mt-2 w-100" data-toggle="modal" data-target="#applicationForm">Aanmeld formulier</button>
					</div>

					<div class="modal fade applicationForm" id="applicationForm" tabindex="-1" role="dialog" aria-labelledby="applicationFormLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header applicationFormHeader">
									<p class="mx-auto"><b>Bedrijfsgegevens invoer formulier</b><p>
								</div>

								<form method="POST" enctype="multipart/form-data" data-ajax="false" class="was-validated" action="/adm/bedrijfsmutaties">
									{{ csrf_field() }}
									<div class="modal-body applicationFormBody">
										<div class="form-group">
											<input type="hidden" name="company_id" value="0" class="form-control applicationFormField rounded-0">
											<input type="hidden" name="is_new" value="1" class="form-control applicationFormField rounded-0">
											<input type="hidden" name="is_published" value="0" class="form-control applicationFormField rounded-0">
											<input type="hidden" name="is_highlighted" value="0" class="form-control applicationFormField rounded-0">

											<div class="formLabelFloat">
												<input type="text" name="name" class="form-control applicationFormField rounded-0" required>
												<label for="name">Bedrijfsnaam</label>
											</div>
											<div class="formLabelFloat">
												<input type="text" name="address" class="form-control applicationFormField rounded-0" required>
												<label for="address">Adres</label>
											</div>
											<div class="formLabelFloat">
												<input type="text" name="zip_code" class="form-control applicationFormField rounded-0" required>
												<label for="zip_code">Postcode</label>
											</div>
											<div class="formLabelFloat">
												<input type="text" name="city" class="form-control applicationFormField rounded-0" required>
												<label for="city">Vestiging/woonplaats</label>
											</div>
											<div class="formLabelFloat">
												<input type="text" name="telephone" class="form-control applicationFormField rounded-0" required>
												<label for="telephone">Telefoonnummer</label>
											</div>
											<select class="form-control rounded-0" name="type_id" required>
												<option value="" hidden>Kies een type</option>
												@foreach($types as $type)
												<option value="{{$type->id}}">{{$type->name}}</option>
												@endforeach
											</select>
											<select onchange="filterCatForm()" class="form-control rounded-0" id="categoryForm" name="categories" required>
												<option value="" hidden>Kies een categorie</option>
												@foreach($categories as $category)
												<option value="{{$category->id}}">{{$category->name}}</option>
												@endforeach
											</select>
											<select class="form-control rounded-0" id="subCategoryForm" name="subCategory_id" style="display:none;" required>
												<option value="" id="chooseCatForm" hidden>Kies een subcategorie</option>
												@foreach($subcategories as $sub)
												<option data-category={{$sub->category->id}} value="{{$sub->id}}">{{$sub->name}}</option>
												@endforeach
											</select>
											<div class="formLabelFloat">
												<input type="text" name="email" class="form-control applicationFormField rounded-0" required>
												<label for="email">E-mailadres</label>
											</div>
											<button type="button" class="btn buttonExtend"data-toggle="collapse" data-target="#collapseExample">Vermelding uitbreiden</button>
											<div class="collapse dropdown" id="collapseExample">
												<label class="label">Beschrijving</label>
												<textarea class="form-control applicationFormField rounded-0" type="text" rows="3" id="content" placeholder="omschrijving" name="description"></textarea>

												<!--<label class="label">Bedrijfslogo uploaden</label>
												<input type="file" name="logo" id="file" class="company_logo" accept="image/*"/>
												<input type="hidden" value="{{ csrf_token() }}" name="_token">-->

												<div class="formLabelFloat">
													<input type="text" name="logo" class="form-control applicationFormField rounded-0">
													<label for="logo">Logo bedrijf</label>
												</div>

												<div class="formLabelFloat">
													<input type="url" name="video" class="form-control applicationFormField rounded-0">
													<label for="video">Link promotievideo</label>
												</div>
												<div class="formLabelFloat">
													<input type="url" name="website" class="form-control applicationFormField rounded-0">
													<label for="website">Link website</label>
												</div>
											</div>
										</div>
									</div>

									<div class="modal-footer applicationFormFooter d-block">
										<div class="row m-0 mb-2">
											<div class="g-recaptcha" data-sitekey={{config("reCaptcha_key")}}></div>
										</div>

										<div class="row m-0">
											<span class="pull-right">
												<button type="submit" id="submit" class="btn buttonConfirm mr-2">Aanvraag versturen</button>
											</span>
											<button type="button" class="btn buttonCancel" data-dismiss="modal">Annuleren</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-8 categories mb-4">
						<select onchange="filterCat()" class="p-2 my-2 categoryField" id="category" name="categories" required>
						<option  value="0" hidden>Kies een categorie</option>
							@foreach($categories as $category)
								<option value="{{$category->id}}">{{$category->name}}</option>
							@endforeach
						</select>

						<select class="p-2 categoryField" id="subCategory" name="subCategory" onchange="filterSelection(this.value)" style="display:none;">
						<option  value="0" id="chooseCat" hidden>Kies een subcategorie</option>
							@foreach($subcategories as $sub)
								<option data-category={{$sub->category->id}} value={{ str_replace(" ","-", $sub->name)}}>{{$sub->name}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="row">
					<div class="col-12 mb-4">
						<div id="mapid">
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-6 companies">
				<div class="row no-gutters">
					<div class="col-lg-12 introtext" id="introtext">
						<p>Welkom op de bedrijvengids van {{$sitedomain}}.<br/>
						Binnen deze pagina's worden vermeldingen en advertenties van bedrijven binnen de regio {{$sitename}} getoont.</p>

						@if(count($companies->all()) > 0)
						Selecteer een categorie of letter om bedrijven te zoeken.
						@endif
					</div>
					<div class="bedrijven">
					@if(count($companies->all()) > 0)
						@foreach($result as $key => $letter)
							@foreach($letter as $company)
								<div class="filterdiv letter{{$key}} {{ str_replace(" ","-",$company->subCategory->name)}}">
									@if($company->is_highlighted)
										<div class="company-highlighted p-3 my-1">
											<a href="/bedrijvengids/{{ $company->slug }}"><h3 class="site-color">{{$company->name}}</h3></a>
											<img class="mb-3" src="{{$company->logo ?? 'https://via.placeholder.com/450x180.png?text=Geen+afbeelding+beschikbaar'}}"><br/>
											{!!$company->description!!}
											@forelse ($company->website as $website)
												Website:
												<a class="site-color" target="blank" href="{{$website}}"><span class="text-black"></span>{{$website}}</a><br/>
											@empty

											@endforelse
										</div>
									@else
										<a class="d-block site-color" href="/bedrijvengids/{{$company->slug}}">{{$company->name}}</a>
									@endif
								</div>
								@endforeach
							@endforeach
						<p style="display:none" id="noResults">Er zijn geen resultaten om weer te geven</p>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection


@section('js')
<script>
		var leaflet_key = '{{config('leaflet_key')}}';
		var city = '{{ config('siteName') }}';
		if(city.match("Ambacht"))
		{
			var city = city.replace("Ambacht", "Hendrik-Ido-Ambacht");
		}
		var companies = {!!$companies->toJson()!!};
		//set the view to an overview of the city

			mymap = L.map('mapid').setView([companies[0]['lat'], companies[0]['lng']], 12);
			L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=' +leaflet_key, {
				attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
				maxZoom: 18,
				id: 'mapbox.streets',
				accessToken: leaflet_key
			}).addTo(mymap);

			//loop through all companies and create markers
			for (let index = 0; index < companies.length; index++) {
				// var myIcon = L.icon({
				// 	iconUrl: companies[index]['logo'],
				// 	iconSize: [30, 30],

				// });
				var myIcon = L.divIcon({className:'leaflet-marker'});
				var marker = L.marker([companies[index]['lat'], companies[index]['lng']],{color: 'red', icon:myIcon}).addTo(mymap);
				marker.bindPopup("<a href='/bedrijvengids/"+companies[index]['slug']+"'><b>"+companies[index]['name']+"</b><br>" + companies[index]['address'] + "<br>" + companies[index]['city']);
			}
</script>

<script>
	//filterSelection("all")
	function filterSelection(keyword) {
		//introtext bedrijvengids aanpassen wanneer een letter of categorie geselecteerd wordt.
		var letter = keyword.replace("letter","").replace("-"," ");
		var introtext = document.getElementById("introtext");
		var oldText = document.getElementById("introtext").innerHTML;
        introtext.innerHTML = introtext.innerHTML.replace(oldText, "<h4>U filtert nu op: " + letter + " </h4>");

		var x, i;
		var count = 0;
		//vul X met alle elementen die class "filterDiv" gebruiken
		x = document.getElementsByClassName("filterdiv");
		for (i = 0; i < x.length; i++) {
			RemoveClass(x[i], "show");
			if (x[i].className.indexOf(keyword) > -1){
				count++;
				AddClass(x[i], "show");
			}
		}

		if (count == 0) {
			$('#noResults').show();
		}
		else{
			$('#noResults').hide();

		}
	}

	//voeg class "show" toe aan de geselecteerde divs
	function AddClass(element, name) {
		var i, arr1, arr2;
		arr1 = element.className.split(" ");
		arr2 = name.split(" ");
		for (i = 0; i < arr2.length; i++) {
			if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
		}
	}

	//verwijder class "show" bij niet geselecteerde divs.
	function RemoveClass(element, name) {
		var i, arr1, arr2;
		arr1 = element.className.split(" ");
		arr2 = name.split(" ");
		for (i = 0; i < arr2.length; i++) {
			while (arr1.indexOf(arr2[i]) > -1) {
			arr1.splice(arr1.indexOf(arr2[i]), 1);
			}
		}
		element.className = arr1.join(" ");
	}

	// geeft knop andere kleur als geselecteerd, niet nodig voor functionaliteit
	var btnContainer = document.getElementById("myBtnContainer");
	var btns = btnContainer.getElementsByClassName("btn");
	for (var i = 0; i < btns.length; i++) {
		btns[i].addEventListener("click", function(){
			var current = document.getElementsByClassName("active");
			current[0].className = current[0].className.replace(" active", "");
			this.className += " active";
		});
	}
</script>

<script>
	function Reset() {
        var dropDown = document.getElementById("category");
        dropDown.selectedIndex = 0;
		var dropDown2 = document.getElementById("subCategory");
        dropDown2.selectedIndex = 0;
        dropDown2.style.display = 'none';
    }
</script>


@include('adm.partials.forms-js')
	<script type="text/javascript">
		var urlmenu = document.getElementById( 'menu1' );
		urlmenu.onchange = function() {
		window.open( this.options[ this.selectedIndex ].value );
		};
	</script>

	<script>
		$('#submit').on('click', function(e){
            if (grecaptcha.getResponse() == '') {
				Swal.fire({
					title: 'Let op!',
					text: 'Vul de reCAPTCHA in om het formulier te verzenden.',
					type: 'warning',
					confirmButtonText: 'Ok',
					confirmButtonColor: "var(--site-color)"
				})
                e.preventDefault();
            }
        });
	</script>

    <script type="text/javascript">
		function filterCat(){
        var mainCategory = document.getElementById("category").value;
        var subCatSelect =     document.getElementById("subCategory");
        subCatSelect.style.display="inline-block";
        var chooseCat =     document.getElementById("chooseCat");
        var found = false;
            for(var i = 0; i < subCatSelect.options.length; i++)
            {
                if(subCatSelect.options[i].dataset.category != mainCategory)
                {
                    subCatSelect.options[i].style.display = 'none';
                }
                else{
                    if(!found)
                    {
                        chooseCat.selected = 'selected';
                        found = true;
                    }
                    subCatSelect.options[i].style.display = 'inline';
                }
            }
		}
	</script>

	<script type="text/javascript">
		function filterCatForm(){
        var mainCategory = document.getElementById("categoryForm").value;
        var subCatSelect =     document.getElementById("subCategoryForm");
        subCatSelect.style.display="inline-block";
        var chooseCat =     document.getElementById("chooseCatForm");
        var found = false;
            for(var i = 0; i < subCatSelect.options.length; i++)
            {
                if(subCatSelect.options[i].dataset.category != mainCategory)
                {
                    subCatSelect.options[i].style.display = 'none';
                }
                else{
                    if(!found)
                    {
                        chooseCat.selected = 'selected';
                        found = true;
                    }
                    subCatSelect.options[i].style.display = 'inline';
                }
            }
		}
	</script>

    <script type="text/javascript">
    $('.formLabelFloat input').focusin(function(){
        $(this).parent().addClass('has-value');
    });

    $('.formLabelFloat input').blur(function(){
        if(!$(this).val().length > 0) {
            $(this).parent().removeClass('has-value');
        }
    });
    </script>
@endsection
