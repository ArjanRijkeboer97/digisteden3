@extends('layouts.frontend.app')

@section('content')
<div class="container pt-4">
	@if(session('error'))
		<div class="row">
			<div class="col-lg-10 offset-lg-1 alert alert-danger alert-block text-center">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>{{ session('error') }}</strong>
			</div>
		</div>
	@endif
	@if(session('success'))
		<div class="row">
			<div class="col-lg-10 offset-lg-1 alert alert-success alert-block text-center">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>{{ session('success') }}</strong>
			</div>
		</div>
	@endif
	<div class="row mb-4">
		<div class="col-lg-8">
			<h1 class="site-color m-0">{{ $company->name }}</h1>
			<small>Categorie: {{ $company->subCategory->category->name }} <i class="fas fa-angle-right"></i> {{ $company->subCategory->name }}</small>
		</div>

		<div class="col-lg-4 text-right editFormButton">
			<button type="button" class="btn btn-more arrow-right position-relative rounded-0 m-0" data-toggle="modal" data-target="#editForm">Wijzig gegevens</button>
		</div>
	</div>

	<div class="row mb-4">
		<div class="col-lg-6">
			@if($company->is_highlighted)
				@if(isset($company->logo))
					<img class="w-100" src="{{$company->logo ?? 'https://via.placeholder.com/450x180.png?text=Geen+afbeelding+beschikbaar'}}" alt="">
				<br /><br />
				@endif
			@endif
			{{-- <small>{{ $company->category->name }} -> "subCategory"</small><br /><br /> --}}
			<h5>Bedrijfsinformatie</h5>
			<table>
				<tr>
					<td><i class="fas fa-map-marker-alt"></i></td>
					<td>&nbsp;</td>
					<td>{{ $company->address }}</td>
				</tr>
				<tr>
					<td><i class="fas fa-map-marked-alt"></i></td>
					<td>&nbsp;</td>
					<td>{{ $company->zip_code }}&nbsp;{{ $company->city }}</td>
				</tr>
				<tr>
					<td><i class="fas fa-phone"></i></td>
					<td>&nbsp;</td>
					<td>{{ $company->telephone }}</td>
				</tr>
				@if($company->is_highlighted)
					<tr>
						<td><i class="far fa-envelope"></i></td>
						<td>&nbsp;</td>
						<td>{{ $company->email }}</td>
					</tr>
					@forelse($company->website as $website)
						<tr>
							<td><i class="fas fa-globe"></i></td>
							<td>&nbsp;</td>
							<td><a href="{{$website}}" target="blank">{{$website}}</a></td>
						</tr>
					@empty

					@endforelse
				@endif
			</table>
			@if($company->is_highlighted)
				<br />
				<h5>Beschrijving</h5>
					{!! $company->description !!}
			@endif
		</div>

		<div class="col-lg-6">
			<div id="mapid" class="mb-2"></div>
			<div class="video">
			@if($company->is_highlighted)
				<iframe width="540" height="303" src="{{$company->video}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
			@endif
			</div>
		</div>

		<div class="modal fade editForm" id="editForm" tabindex="-1" role="dialog" aria-labelledby="editFormLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header editFormHeader">
						<p class="mx-auto"><b>Bedrijfsgegevens wijzigings formulier</b><p>
					</div>
					<form method="POST" enctype="multipart/form-data" data-ajax="false" class="was-validated" action="/adm/bedrijfsmutaties">
						{{ csrf_field() }}
						<div class="modal-body editFormBody">
							<div class="form-group">
								<input type="hidden" name="company_id" value="{{$company->id}}" class="form-control applicationFormField rounded-0">
								<input type="hidden" name="is_new" value="0" class="form-control applicationFormField rounded-0">
								<input type="hidden" name="is_published" value="{{$company->is_published}}" class="form-control applicationFormField rounded-0">
								<input type="hidden" name="is_highlighted" value="{{$company->is_highlighted}}" class="form-control applicationFormField rounded-0">

								<input type="text" value="{{$company->name}}" name="name" class="form-control editFormField rounded-0" placeholder="Bedrijfsnaam" required>
								<input type="text" value="{{$company->address}}" name="address" class="form-control editFormField rounded-0" placeholder="Adres" required>
								<input type="text" value="{{$company->zip_code}}" name="zip_code" class="form-control editFormField rounded-0" placeholder="Postcode" required>
								<input type="text" value="{{$company->city}}" name="city" class="form-control editFormField rounded-0" placeholder="Vestiging/woonplaats" required>
								<input type="text" value="{{$company->telephone}}" name="telephone" class="form-control editFormField rounded-0" placeholder="Telefoonnr." required>
								<select class="form-control rounded-0" name="type_id" required>
									@foreach($types as $type)
										<option value="{{$type->id}}" @if($type->id == $company->type_id) selected @endif >{{$type->name}}</option>
									@endforeach
								</select>

								<select onchange="filterCat()" class="form-control rounded-0" id="category" name="category" required>
									@foreach($categories as $category)
										<option value="{{$category->id}}" @if($category->id == $company->subCategory->category->id) selected @endif >{{$category->name}}</option>
									@endforeach
								</select>

								<select class="form-control rounded-0" id="subCategory" name="subCategory_id" style="display:none;">
									<option  value="" id="chooseCat" hidden>Kies een subcategorie</option>
									@foreach($subcategories as $sub)
										<option data-category={{$sub->category->id}} value="{{$sub->id}}" @if($sub->id == $company->subCategory_id) selected @endif >{{$sub->name}}</option>
									@endforeach
								</select>

								<input type="text" value="{{$company->email}}" name="email" class="form-control editFormField rounded-0" placeholder="Emailadres" required>

								@if(!$company->is_highlighted)
									<button type="button" class="btn buttonExtend"data-toggle="collapse" data-target="#collapseExample">Vermelding uitbreiden</button>
								@endif

								<div @if(!$company->is_highlighted) class="collapse dropdown" id="collapseExample" @else class="dropdown" @endif>
								<label class="label">Beschrijving</label>
									<textarea class="form-control rounded-0" type="text" id="content" rows="3" placeholder="description" name="description">{{$company->description}}</textarea>
									<input type="url" value="{{$company->video}}" name="video" class="form-control editFormField rounded-0" placeholder="Link promotievideo">
									@if(is_array($company->website))
										@if($company->website)
											@forelse($company->website as $website)
												<input type="url" value="{{$website}}" name="website[]" class="form-control editFormField rounded-0" placeholder="Link website">
											@empty
												<input type="url" name="website[]" class="form-control editFormField rounded-0" placeholder="Link website">
											@endforelse
										@endif
									@else
										<input type="url" value="{{$company->website}}" name="website" class="form-control editFormField rounded-0" placeholder="Link website">
									@endif
									<input type="text" value="{{$company->logo}}" name="logo" class="form-control editFormField rounded-0" placeholder="Logo uploaden">
								</div>
							</div>
						</div>

						<div class="modal-footer editFormFooter d-block">
							<div class="row m-0 mb-2">
								<div class="g-recaptcha" data-sitekey={{config("reCaptcha_key")}}></div>
							</div>

							<div class="row m-0">
								<span class="pull-right">
									<button type="submit" id="submit" class="btn btn-more arrow-right position-relative rounded-0 buttonConfirm mr-4">Aanpas verzoek versturen</button>
								</span>
								<button type="button" class="btn rounded-0 btn-default" data-dismiss="modal">Annuleren</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6">
			<h2><strong>Recensies</strong></h2>

			@forelse ($comments as $comment)
				<h4>{{$comment->title}} - <small>{{$comment->name}}</small></h4>
				<p class="m-0">{{$comment->body}}</p>

				@php
					$remaining = 5 - $comment->rating
				@endphp

				@for($i = 0; $i < $comment->rating; $i++)
					<span class="checked-star"></span>
				@endfor

				@for($i = 0; $i < $remaining; $i++)
					<span class="unchecked-star">☆</span>
				@endfor

				<p>{{$comment->created_at}}</p>
				<hr>
			@empty
				<p>Er zijn nog geen recensies geplaatst over {{ $company->name }}.</p>
			@endforelse
		</div>

		<div class="col-lg-6">
			<h2><strong>Recensie toevoegen</strong></h2>
			<form method="POST" action="/bedrijvengids/plaatsreactie/{{$company->id}}">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="naam">Naam:</label>
					<input type="naam" class="form-control rounded-0" id="naam" name="name" required>
				</div>
				<div class="form-group">
					<label for="titel">Titel:</label>
					<input type="titel" class="form-control rounded-0" id="titel" name="title" required>
				</div>
				<div class="form-group">
					<label for="body">Bericht:</label>
					<textarea class="form-control rounded-0" id="message" name="body" rows="3" required></textarea>
				</div>
				<div class="rating">
					<input name="rating" type="radio" value="5"><span>&star;</span>
					<input name="rating" type="radio" value="4"><span>&star;</span>
					<input name="rating" type="radio" value="3"><span>&star;</span>
					<input name="rating" type="radio" value="2"><span>&star;</span>
					<input name="rating" type="radio" value="1"><span>&star;</span>
				</div>
				<button type="submit" class="btn btn-more arrow-right position-relative rounded-0 m-0">Plaats recensie</button>
			</form>
			<br><br>
		</div>
	</div>
</div>
@endsection


@section('js')
@include('adm.partials.forms-js')
	<script type="text/javascript">
		filterCat(false)

		function filterCat(keepvalue=true){
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
                    if(!found && keepvalue)
                    {
                        chooseCat.selected = 'selected';
                        found = true;
                    }
                    subCatSelect.options[i].style.display = 'inline';
                }
            }
		}
	</script>

	<script>
		var leaflet_key = '{{config('leaflet_key')}}';

		var address = "<?php echo $company->address; ?>";
		address += " <?php echo $company->city; ?>";

		$.get(location.protocol + '//nominatim.openstreetmap.org/search?format=json&q='+address, function(coordinates){
			var mymap = L.map('mapid').setView([coordinates[0].lat, coordinates[0].lon], 15);
			L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=' +leaflet_key, {
				attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
				maxZoom: 18,
				id: 'mapbox.streets',
				accessToken: leaflet_key
			}).addTo(mymap);
			var marker = L.marker([coordinates[0].lat, coordinates[0].lon],{color: 'red'}).addTo(mymap);
			marker.bindPopup("<b><?php echo $company->name; ?></b><br><?php echo $company->address; ?>");
		});
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
	var coll = document.getElementsByClassName("collapsible");
	var i;

	for (i = 0; i < coll.length; i++) {
		coll[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var content = this.nextElementSibling;
			if (content.style.display === "block") {
				content.style.display = "none";
			} else {
				content.style.display = "block";
			}
		});
	}
	</script>


@endsection
