<!DOCTYPE html>
<html>
<head>
</head>
<body>
<style>
table {
    border-collapse: collapse;
}
.border{
	border-bottom: 1px solid black;
}
.changed{
	color: red;
}
</style>
	{!!$message_top!!}
	{{-- {!!$siteurl!!}/bedrijvengids/{!!$slug!!} --}}

		{{-- <a href="https://{!!$siteurl!!}/bedrijvengids/{!!$slug!!}">open uw pagina</a> --}}
	<table>
		<tr>
			@if($company_old)
				<th style="width:120px">Wijzigingen</th>
			@else
				<th style="width:120px"></th>
			@endif
			<th align="left" style="width:20px"></th>
				@if($company_old)
					<th align="left" style="width:150px">Oude gegevens</th>
					<th align="left" style="width:45px"></th>
				@endif
			<th align="left" style="width:150px">Nieuwe gegevens</th>
			<th></th>
		</tr>

		<tr>
			<td align="right" class="border">Naam:</td>
			<td class="border"></td>
				@if($company_old)
					<td class="border">{!!$company_old["name"]!!}</td>
					<td class="border">-></td>
				@endif
			<td class="border">
				{!!$company_shadow->name!!}
			</td>
			@if($company_old)
				@if($company_old["name"] != $company_shadow->name)
					<td class="changed"><b>!</b></td>
				@endif
			@endif
		</tr>

		<tr>
			<td align="right" class="border">Adres:</td>
			<td class="border"></td>
				@if($company_old)
					<td class="border">{!!$company_old["address"]!!}</td>
					<td class="border">-></td>
				@endif
			<td class="border">
				{!!$company_shadow->address!!}
			</td>
			@if($company_old)
				@if($company_old["address"] != $company_shadow->address)
					<td class="changed"><b>!</b></td>
				@endif
			@endif
		</tr>

		<tr>
			<td align="right" class="border">Postcode:</td>
			<td class="border"></td>
				@if($company_old)
					<td class="border">{!!$company_old["zip_code"]!!}</td>
					<td class="border">-></td>
				@endif
			<td class="border">
				{!!$company_shadow->zip_code!!}
			</td>
			@if($company_old)
				@if($company_old["zip_code"] != $company_shadow->zip_code)
					<td class="changed"><b>!</b></td>
				@endif
			@endif
		</tr>

		<tr>
			<td align="right" class="border">Plaats:</td>
			<td class="border"></td>
				@if($company_old)
					<td class="border">{!!$company_old["city"]!!}</td>
					<td class="border">-></td>
				@endif
			<td class="border">
				{!!$company_shadow->city!!}
			</td>
			@if($company_old)
				@if($company_old["city"] != $company_shadow->city)
					<td class="changed"><b>!</b></td>
				@endif
			@endif
		</tr>

		<tr>
			<td align="right" class="border">Telefoon:</td>
			<td class="border"></td>
				@if($company_old)
					<td class="border">{!!$company_old["telephone"]!!}</td>
					<td class="border">-></td>
				@endif
			<td class="border">
				{!!$company_shadow->telephone!!}
			</td>
			@if($company_old)
				@if($company_old["telephone"] != $company_shadow->telephone)
					<td class="changed"><b>!</b></td>
				@endif
			@endif
		</tr>

		<tr>
			<td align="right" class="border">Bedrijfstype:</td>
			<td class="border"></td>
				@if($company_old)
					<td class="border">{!!$company_old["type"]["name"]!!}</td>
					<td class="border">-></td>
				@endif
			<td class="border">
				{!!$company_shadow->type->name!!}
			</td>
			@if($company_old)
				@if($company_old["type"]["name"] != $company_shadow->type->name)
					<td class="changed"><b>!</b></td>
				@endif
			@endif
		</tr>

		<tr>
			<td align="right" class="border">Categorie:</td>
			<td class="border"></td>
				@if($company_old)
					<td class="border">{!!$company_old["sub_category"]["category"]["name"]!!}</td>
					<td class="border">-></td>
				@endif
			<td class="border">
				{!!$company_shadow->subCategory->category->name!!}
			</td>
			@if($company_old)
				@if($company_old["sub_category"]["category"]["name"] != $company_shadow->subCategory->category->name)
					<td class="changed"><b>!</b></td>
				@endif
			@endif
		</tr>

		<tr>
			<td align="right" class="border">Subcategorie:</td>
			<td class="border"></td>
				@if($company_old)
					<td class="border">{!!$company_old["sub_category"]["name"]!!}</td>
					<td class="border">-></td>
				@endif
			<td class="border">
				{!!$company_shadow->subCategory->name!!}
			</td>
			@if($company_old)
				@if($company_old["sub_category"]["name"] != $company_shadow->subCategory->name)
					<td class="changed"><b>!</b></td>
				@endif
			@endif
		</tr>

		<tr>
			<td align="right" class="border">Emailadres:</td>
			<td class="border"></td>
				@if($company_old)
					<td class="border">{!!$company_old["email"]!!}</td>
					<td class="border">-></td>
				@endif
			<td class="border">
				{!!$company_shadow->email!!}
			</td>
			@if($company_old)
				@if($company_old["email"] != $company_shadow->email)
					<td class="changed"><b>!</b></td>
				@endif
			@endif
		</tr>

		<tr>
			<td align="right" valign="top" class="border">Omschrijving:</td>
			<td class="border"></td>
				@if($company_old)
					<td valign="top" class="border">
						{{-- {!!$company_old["description"]!!} --}}
						@if(isset($company_old["description"]))
							{!!$company_old["description"]!!}
						@else
							-
						@endif
					</td>
					<td valign="top" class="border">-></td>
				@endif
			{{-- <td class="border">{!!$company_shadow->description!!}</td> --}}
			<td class="border">
				@if(isset($company_shadow->description))
					{!!$company_shadow->description!!}
				@else
					-
				@endif
			</td>
			@if($company_old)
				@if($company_old["description"] != $company_shadow->description)
					<td class="changed"><b>!</b></td>
				@endif
			@endif
		</tr>

		<tr>
			<td align="right" valign="top" class="border">Website:</td>
			<td class="border"></td>
				@if($company_old)
					<td class="border">
						@if(isset($company_old["website"]))
							{!! str_replace(",","<br>", $company_old["website"])!!}
						@else
							-
						@endif
					</td>
					<td class="border">-></td>
				@endif
			<td class="border">
				@if(isset($company_shadow->website))
					{!! str_replace(",","<br>",$company_shadow->website)!!}
				@else
					-
				@endif
			</td>
			@if($company_old)
				@if($company_old["website"] != $company_shadow->website)
					<td class="changed"><b>!</b></td>
				@endif
			@endif
		</tr>

		<tr>
			<td align="right" valign="top" class="border">Logo:</td>
			<td class="border"></td>
			@if($company_old)
				<td class="border">
					@if(isset($company_old["logo"]))
						{!!$company_old["logo"]!!}
					@else
						-
					@endif
				</td>
				<td valign="top" class="border">-></td>
			@endif
			<td valign="top" class="border">
				@if(isset($company_shadow->logo))
					{!!$company_shadow->logo!!}
				@else
					-
				@endif
			</td>
			@if($company_old)
				@if($company_old["logo"] != $company_shadow->logo)
					<td class="changed"><b>!</b></td>
				@endif
			@endif
		</tr>

		<tr>
			<td align="right" valign="top">Promotievideo:</td>
			<td></td>
			@if($company_old)
				<td>
					@if(isset($company_old["video"]))
						{!!$company_old["video"]!!}
					@else
						-
					@endif
				</td>
				<td valign="top">-></td>
			@endif
			<td valign="top">
				@if(isset($company_shadow->video))
					{!!$company_shadow->video!!}
				@else
					-
				@endif
			</td>
			@if($company_old)
				@if($company_old["video"] != $company_shadow->video)
					<td class="changed"><b>!</b></td>
				@endif
			@endif
		</tr>
	</table>
	<a href="https://{!!$siteurl!!}/bedrijvengids/{!!$slug!!}">open uw pagina</a>
	{!!$message_bottom!!}
</body>
</html>