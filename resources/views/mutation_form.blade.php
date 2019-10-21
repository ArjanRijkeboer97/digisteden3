@extends('layouts.backend.app-backend')

@section('content')

    <style>
        .full-height {
            height: 100%;
        }
    </style>

    <div class="bg-grey py-2">
        <div class="container-fluid bg-grey">
            <div class="row">
                <div class="col-6">
                    @if($mode == 'Nieuw')
                        <h1 class="text-color">Nieuwe vermelding of advertentie</h1>
                    @elseif($mode == 'Aanpassing')
                        <h1 class="text-color">Vermelding of advertentie wijzigen</h1>
                    @endif
                </div>

                <div class="col-6">
                    @include('adm.partials.action_buttons_inline')
                </div>
            </div>
        </div>
    </div>

    <div class="container bg-grey full-height">
        {{-- @if($mode == 'Nieuw')
            <div class="row">
                <div class="col-lg-12 Titel">
                    <h4 class="mb-3">Ingevoerde gegevens</h3>
                </div>
            </div>
        @elseif($mode == 'Aanpassing')
            <div class="row">
                <div class="col-lg-2 Titel">
                </div>
                <div class=".d-none .d-lg-block col-lg-5 Titel">
                    <h4 class="mb-3">Bestaande gegevens</h3>
                </div>
                <div class=".d-none .d-lg-block col-lg-5 Titel">
                    <h4 class="mb-3">Nieuw ingevoerde gegevens</h3>
                    Highlight knop: <input type="checkbox" onchange="hiddeninput(this,'highlighted')" id="highlighted" value="1">
                    @if($company_shadow->company_id != 0)
                        @if($company->is_highlighted == 1)
                            <script>
                                check_highlight();
                                function check_highlight() {
                                    document.getElementById("highlighted").checked = true;
                                }
                            </script>
                        @endif
                    @endif
                    published knop: <input type="checkbox" onchange="hiddeninput(this,'published')" id="published" value="1">
                    @if($company_shadow->company_id != 0)
                        @if($company->is_published == 1)
                            <script>
                                check_publish();
                                function check_publish() {
                                    document.getElementById("published").checked = true;
                                }
                            </script>
                        @endif
                    @endif
                </div>
            </div>
        @endif --}}

        <div class="row">
            <div class="col-lg-2 Titel">
            </div>
            @if($mode == 'Aanpassing')
                <div class=".d-none .d-lg-block col-lg-5 Titel">
                    <h4 class="mb-3">Bestaande gegevens</h3>
                </div>
            @endif
            <div class=".d-none .d-lg-block col-lg-5 Titel">
                <h4 class="mb-3">Nieuw ingevoerde gegevens</h3>
                Highlight knop: <input type="checkbox" onchange="hiddeninput(this,'hiddenhighlight')" id="highlighted" value="1">
                @if($company_shadow->company_id != 0)
                    @if($company->is_highlighted == 1)
                        <script>
                            check_highlight();
                            function check_highlight() {
                                document.getElementById("highlighted").checked = true;
                            }
                        </script>
                    @endif
                @endif
                published knop: <input type="checkbox" onchange="hiddeninput(this,'hiddenpublish')" id="published" value="1">
                @if($company_shadow->company_id != 0)
                    @if($company->is_published == 1)
                        <script>
                            check_publish();
                            function check_publish() {
                                document.getElementById("published").checked = true;
                            }
                        </script>
                    @endif
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2">
                <label>Bedrijfsnaam</label>
            </div>

            @if($company_shadow->company_id != 0)
                <div class="col-lg-5 gegevens mb-2">
                    <div class="row">
                        <div class=" col-lg-12">
                            <div class="standard">
                                    {!!$company->name!!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-5 aanpassingen mb-2">
                <div class="row">
                    <div class=" col-lg-12">
                        @if($company_shadow->company_id != 0)
                            <div class="@if($company_shadow->name != $company->name) changed @else unchanged @endif">
                                {!!$company_shadow->name!!}
                            </div>
                        @else
                            <div class="standard">
                                {!!$company_shadow->name!!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2">
                <label>Adres</label>
            </div>
            @if($company_shadow->company_id != 0)
                <div class="col-lg-5 gegevens mb-2">
                    <div class="row">
                        <div class=" col-lg-12">
                            <div class="standard">
                                {!!$company->address!!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-5 aanpassingen mb-2">
                <div class="row">
                    <div class=" col-lg-12">
                        @if($company_shadow->company_id != 0)
                            <div class="@if($company_shadow->address != $company->address) changed @else unchanged @endif">
                                {!!$company_shadow->address!!}
                            </div>
                        @else
                            <div class="standard">
                                {!!$company_shadow->address!!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2">
                <label>Postcode</label>
            </div>

            @if($company_shadow->company_id != 0)
                <div class="col-lg-5 gegevens mb-2">
                    <div class="row">
                        <div class=" col-lg-12">
                            <div class="standard">
                                {!!$company->zip_code!!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-5 aanpassingen mb-2">
                <div class="row">
                    <div class=" col-lg-12">
                        @if($company_shadow->company_id != 0)
                            <div class="@if($company_shadow->zip_code != $company->zip_code) changed @else unchanged @endif">
                                {!!$company_shadow->zip_code!!}
                            </div>
                        @else
                            <div class="standard">
                                {!!$company_shadow->zip_code!!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2">
                <label>Woonplaats</label>
            </div>

            @if($company_shadow->company_id != 0)
                <div class="col-lg-5 gegevens mb-2">
                    <div class="row">
                        <div class=" col-lg-12">
                            <div class="standard">
                                {!!$company->city!!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-5 aanpassingen mb-2">
                <div class="row">
                    <div class=" col-lg-12">
                        @if($company_shadow->company_id != 0)
                            <div class="@if($company_shadow->city != $company->city) changed @else unchanged @endif">
                                {!!$company_shadow->city!!}
                            </div>
                        @else
                            <div class="standard">
                                {!!$company_shadow->city!!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2">
                <label>Telefoon</label>
            </div>

            @if($company_shadow->company_id != 0)
                <div class="col-lg-5 gegevens mb-2">
                    <div class="row">
                        <div class=" col-lg-12">
                            <div class="standard">
                                {!!$company->telephone!!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-5 aanpassingen mb-2">
                <div class="row">
                    <div class=" col-lg-12">
                        @if($company_shadow->company_id != 0)
                            <div class="@if($company_shadow->telephone != $company->telephone) changed @else unchanged @endif">
                                {!!$company_shadow->telephone!!}
                            </div>
                        @else
                            <div class="standard">
                                {!!$company_shadow->telephone!!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2">
                <label>Bedrijfstype</label>
            </div>

            @if($company_shadow->company_id != 0)
                <div class="col-lg-5 gegevens mb-2">
                    <div class="row">
                        <div class=" col-lg-12">
                            <div class="standard">
                                {!!$company->type->name!!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-5 aanpassingen mb-2">
                <div class="row">
                    <div class=" col-lg-12">
                        @if($company_shadow->company_id != 0)
                            <div class="@if($company_shadow->type->name != $company->type->name) changed @else unchanged @endif">
                                {!!$company_shadow->type->name!!}
                            </div>
                        @else
                            <div class="standard">
                                {!!$company_shadow->type->name!!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2">
                <label>Categorie</label>
            </div>
            @if($company_shadow->company_id != 0)
                <div class="col-lg-5 gegevens mb-2">
                    <div class="row">
                        <div class=" col-lg-12">
                            <div class="standard">
                                {!!$company->subCategory->category_name!!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-5 aanpassingen mb-2">
                <div class="row">
                    <div class=" col-lg-12">
                        @if($company_shadow->company_id != 0)
                            <div class="@if($company_shadow->subCategory->category_name != $company->subCategory->category_name) changed @else unchanged @endif">
                                {!!$company_shadow->subCategory->category_name!!}
                            </div>
                        @else
                            <div class="standard">
                                {!!$company_shadow->subCategory->category_name!!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2">
                <label>Subcategory</label>
            </div>

            @if($company_shadow->company_id != 0)
                <div class="col-lg-5 gegevens mb-2">
                    <div class="row">
                        <div class=" col-lg-12">
                            <div class="standard">
                                {!!$company->subCategory->name!!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-5 aanpassingen mb-2">
                <div class="row">
                    <div class=" col-lg-12">
                        @if($company_shadow->company_id != 0)
                            <div class="@if($company_shadow->subCategory->name != $company->subCategory->name) changed @else unchanged @endif">
                                {!!$company_shadow->subCategory->name!!}
                            </div>
                        @else
                            <div class="standard">
                                {!!$company_shadow->subCategory->name!!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2">
                <label>Email</label>
            </div>

            @if($company_shadow->company_id != 0)
                <div class="col-lg-5 gegevens mb-2">
                    <div class="row">
                        <div class=" col-lg-12">
                            <div class="standard">
                                {!!$company->email!!}
                            </div>
                        </div>

                    </div>
                </div>
            @endif

            <div class="col-lg-5 aanpassingen mb-2">
                <div class="row">
                    <div class=" col-lg-12">
                        @if($company_shadow->company_id != 0)
                            <div class="@if($company_shadow->email != $company->email) changed @else unchanged @endif">
                                {!!$company_shadow->email!!}
                            </div>
                        @else
                            <div class="standard">
                                {!!$company_shadow->email!!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2">
                @if($mode == 'Nieuw')
                    @if(isset($company_shadow->description))
                        <label>Omschrijving</label>
                    @endif
                @elseif($mode == 'Aanpassing')
                    @if(isset($company_shadow->description) || isset($company->description))
                        <label>Omschrijving</label>
                    @endif
                @endif
            </div>

            @if($company_shadow->company_id != 0)
                <div class="col-lg-5 gegevens mb-2">
                    <div class="row">
                        <div class=" col-lg-12">
                            <div class="standard">
                                @if(isset($company->description))
                                    {!!$company->description!!}
                                @else
                                    Geen beschrijving beschikbaar.
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-5 aanpassingen mb-2">
                <div class="row">
                    @if(isset($company_shadow->description) || isset($company->description))
                        <div class=" col-lg-12">
                            @if($company_shadow->company_id != 0)
                                <div class="@if($company_shadow->description != $company->description) changed @else unchanged @endif">
                                    @if(isset($company_shadow->description))
                                        {!!$company_shadow->description!!}
                                    @else
                                        Geen beschrijving beschikbaar.
                                    @endif
                                </div>
                            @else
                                <div class="standard">
                                    @if(isset($company_shadow->description))
                                        {!!$company_shadow->description!!}
                                    @else
                                        Geen beschrijving beschikbaar.
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2">
                @if($mode == 'Nieuw')
                    @if(isset($company_shadow->website))
                        <label>Website</label>
                    @endif
                @elseif($mode == 'Aanpassing')
                    @if(isset($company_shadow->website) || isset($company->website))
                        <label>Website</label>
                    @endif
                @endif
            </div>
            @if($company_shadow->company_id != 0)
                <div class="col-lg-5 gegevens mb-2">
                    <div class="row">
                        <div class=" col-lg-12">
                            <div class="standard">
                                @if(isset($company->website))
                                    @if($company->website != "")
                                        {!! str_replace(",","<br>",$company->website)!!}
                                    @else
                                        Geen website beschikbaar.
                                    @endif
                                @else
                                    Geen website beschikbaar.
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-5 aanpassingen mb-2">
                <div class="row">
                    @if(isset($company_shadow->website) || isset($company->website))
                        <div class=" col-lg-12">
                            @if($company_shadow->company_id != 0)
                                <div class="@if($company_shadow->website != $company->website) changed @else unchanged @endif">
                                    @if(isset($company_shadow->website))
                                        {!! str_replace(",","<br>",$company_shadow->website)!!}
                                    @else
                                        Geen website beschikbaar.
                                    @endif
                                </div>
                            @else
                                <div class="standard">
                                    @if(isset($company_shadow->website))
                                        {!! str_replace(",","<br>",$company_shadow->website)!!}
                                    @else
                                        Geen website beschikbaar.
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2">
                @if($mode == 'Nieuw')
                    @if(isset($company_shadow->logo))
                        <label>Logo</label>
                    @endif
                @elseif($mode == 'Aanpassing')
                    @if(isset($company_shadow->logo) || isset($company->logo))
                        <label>Logo</label>
                    @endif
                @endif
            </div>

            @if($company_shadow->company_id != 0)
                <div class="col-lg-5 gegevens mb-2">
                    <div class="row">
                        <div class=" col-lg-12">
                            <div class="standard">
                                @if(isset($company->logo))
                                    {!!$company->logo!!}
                                @else
                                    Geen logo beschikbaar.
                                @endif
                            </div>
                        </div>
                        <div class=" col-lg-12">
                            @if($company->logo != '')
                                <img src="{{asset($company->logo)}}" class="img-fluid w-100 mb-0">
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-5 aanpassingen mb-2">
                <div class="row">
                    @if(isset($company_shadow->description) || isset($company->description))
                        <div class=" col-lg-12">
                            @if($company_shadow->company_id != 0)
                                <div class="@if($company_shadow->logo != $company->logo) changed @else unchanged @endif">
                                    @if(isset($company_shadow->logo))
                                        {!!$company_shadow->logo!!}
                                    @else
                                        Geen logo beschikbaar.
                                    @endif
                                </div>
                            @else
                                <div class="standard">
                                    @if(isset($company_shadow->logo))
                                        {!!$company_shadow->logo!!}
                                    @else
                                        Geen logo beschikbaar.
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class=" col-lg-12">
                            @if($company_shadow->logo != '')
                                <!-- <img src="{{asset('/storage/media/drechtsteden/bedrijfslogos/'.$company_shadow->logo)}}" class="img-fluid w-100"> -->
                                <img src="{{asset($company_shadow->logo)}}" class="img-fluid w-100 mb-0">
                            @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2">
                @if($mode == 'Nieuw')
                    @if(isset($company_shadow->video))
                        <label>Promotievideo</label>
                    @endif
                @elseif($mode == 'Aanpassing')
                    @if(isset($company_shadow->video) || isset($company->video))
                        <label>Promotievideo</label>
                    @endif
                @endif
            </div>

            @if($company_shadow->company_id != 0)
                <div class="col-lg-5 gegevens mb-2">
                    <div class="row">
                        <div class=" col-lg-12">
                            <div class="standard">
                                @if(isset($company->video))
                                    {!!$company->video!!}
                                @else
                                    Geen video beschikbaar.
                                @endif
                            </div>
                        </div>

                        @if($company->video != '')
                            <div class=" col-lg-12">
                                <iframe width="100%" height="230" src="{{asset($company->video)}}" frameborder="0" allow="autoplay; encrypted-media" class="video" allowfullscreen></iframe>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="col-lg-5 aanpassingen mb-2">
                <div class="row">
                    @if(isset($company_shadow->description) || isset($company->description))
                        <div class=" col-lg-12">
                            @if($company_shadow->company_id != 0)
                                <div class="@if($company_shadow->video != $company->video) changed @else unchanged @endif">
                                    @if(isset($company_shadow->video))
                                        {!!$company_shadow->video!!}
                                    @else
                                        Geen video beschikbaar.
                                    @endif
                                </div>
                            @else
                                <div class="standard">
                                    @if(isset($company_shadow->video))
                                        {!!$company_shadow->video!!}
                                    @else
                                        Geen video beschikbaar.
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                    @if($company_shadow->video != '')
                        <div class=" col-lg-12">
                            <iframe width="100%" height="230" src="{{asset($company_shadow->video)}}" frameborder="0" allow="autoplay; encrypted-media" class="video" allowfullscreen></iframe>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div  @if($mode == 'Aanpassing') class="col-lg-6 offset-lg-6 mutationButtons" @else class="col-lg-5 offset-md-2 mutationButtons" @endif>
                <div class="row">
                    <div @if($mode == 'Aanpassing') class="col-lg-4 offset-lg-4" @else class="col-lg-4" @endif>
                        <button type="button" class="btn btn-md btn-success buttons" data-toggle="modal" data-target="#emailForm"><i class="far fa-save"></i>  Opslaan</button>
                    </div>

                    <div class="modal fade emailForm" id="emailForm" tabindex="-1" role="dialog" aria-labelledby="emailFormLabel">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header emailFormHeader">
                                    <p class="mx-auto"><b>Bevestigingsmail mutatieformulier</b><p>
                                </div>
                                <form method="POST" enctype="multipart/form-data" data-ajax="false" class="was-validated" action="/adm/bedrijfsmutaties/{{$company_shadow->id}}/confirmChanges" id="mutationForm">
                                    {{ csrf_field() }}
                                    <div class="modal-body emailFormBody">
                                        <div class="form-group">
                                            @if($mode == 'Nieuw')
                                                <input type="text" name="receiver" class="form-control emailFormField rounded-0" placeholder="receiver" value="{{$company_shadow->email}}" required>
                                            @else
                                                <input type="text" name="receiver" class="form-control emailFormField rounded-0" placeholder="receiver" value="{{$company->email}}" required>
                                            @endif
                                            <input type="text" name="subject" class="form-control emailFormField rounded-0" placeholder="subject" value="{{$message->subject}}" required>

                                            <textarea class="form-control emailFormField rounded-0" id="content" type="text" placeholder="message" name="message_top" required>{{$message->message_top}}</textarea>

                                            <textarea class="form-control emailFormField rounded-0" id="content2" type="text" placeholder="message" name="message_bottom" required>{{$message->message_bottom}}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer emailFormFooter">
                                        <button type="button" class="btn buttonCancel" data-dismiss="modal">Annuleren</button>
                                        <span class="pull-right">
                                            <button type="submit" class="btn buttonConfirm">Versturen & opslaan</button>
                                        </span>
                                    </div>
                                    <input type="hidden" id="hiddenhighlight" value="{{$company->is_highlighted ?? 0}}" name="highlighted">
                                    <input type="hidden" id="hiddenpublish" value="{{$company->is_published ?? 0}}" name="published">
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <button type="button" class="btn btn-md btn-danger buttons" onclick='return Delete({{$company_shadow->id}},this)' data-token="{{csrf_token()}}"><i class="far fa-trash-alt"></i>  Verwijderen</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
<script>
    function hiddeninput(el,name)
    {
        if(name == 'hiddenhighlight'){
            var input=document.getElementById(name);
            var value = document.getElementById('highlighted').checked;
            console.log(value);
            input.value = value == true ? 1 : 0;
        }
        else if(name=='hiddenpublish'){
            var input=document.getElementById(name);
            var value = document.getElementById('published').checked;
            console.log(value);
            input.value = value == true ? 1 : 0;
        }
    }
</script>
@include('adm.partials.forms-js')
	<script type="text/javascript">
    function Delete(id,el)
    {
        var token = $(el).data('token');
        if (confirm("Weet u zeker dat u dit bericht wilt verwijderen?")) {
            $.ajax({
                url:'/adm/bedrijfsmutaties/'+id,
                type: 'delete',
                data: {_method: 'delete', _token :token},
                success:function(msg){
                    $.ajax({
                        url:'/adm/bedrijvengids/aanpassingen',
                        type: 'get',
                        success:function(msg){
                            window.location.replace('/adm/bedrijvengids/aanpassingen');
                        }
                    })
                }
            })
        }
        else
        {
            return false;
        }
    }
	</script>
@endsection