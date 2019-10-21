@extends('layouts.backend.app-backend')

@section('content')
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <p class="avant-alert alert alert-{{ $msg }}" id="message">{{ Session::get('alert-' . $msg) }}
                <a href="#" data-dismiss="alert" aria-label="close">&times;</a>
            </p>
        @endif
    @endforeach

    <div class="bg-grey p-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    @if($mode == 'create')
                        <h1 class="site-color">Voeg bedrijf toe</h1>
                    @else
                        <h1 class="site-color">Wijzig: {{$companyItem->name}}</h1>
                    @endif
                </div>

                <div class="col-6 text-right">
                    <a class="btn btn-add bg-color" href="#" id="save">Opslaan</a>
                    @if($mode == 'create')
                        <a class="btn btn-add bg-color" href="#" id="saveadd">Opslaan en nieuwe toevoegen</a>
                    @else
                        <a class="btn btn-add bg-color" href="#" id="saveclose">Opslaan en sluiten</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .full-height {
            height: 100%;
        }
    </style>

    <div class="container-fluid pt-4 pb-4 bg-grey full-height">
        <form method="POST" enctype="multipart/form-data" data-ajax="false" class="was-validated"
            @if($mode == 'create')
                action="/adm/bedrijvengids"
            @else
                action="/adm/bedrijvengids/{{$companyItem->id}}"
            @endif>

            @if($mode == 'edit')
                {{ method_field('PUT') }}
            @endif
            {{ csrf_field() }}
            <div class="row">
                <div class="col-12 col-md-6">
                    <h6>Bedrijf</h6>
                    <div class="form-group">
                        <label class="font-weight-bold" for="name">Naam</label>
                        <input class="form-control" type="text" id="name" name="name" required
                        @if($mode == 'edit')value="{{$companyItem->name}}"@endif>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold" for="description">Beschrijving</label>
                        <textarea class="form-control" type="text" id="content" name="description">@if($mode == 'edit'){{$companyItem->description}}@endif</textarea>
                    </div>

                    <!-- <div class="form-group">
                        <label class="font-weight-bold" for="tags">Tags</label>
                        <input data-role="tagsinput" class="form-control" type="text" id="tags" name="tags"
                        @if($mode == 'edit')value="{{$tags}}"@endif>
                    </div> -->

                    <div class="form-group">
                        <div class="pop" id="website">
                            <label class="font-weight-bold" for="title">Website</label>
                            @if($mode == 'edit')
                                @foreach($companyItem->website as $website)
                                    <input class="form-control" type="url" id="website" style="margin-bottom: 10px;" name="website[]" value="{{$website}}">
                                @endforeach
                            @else
                                <input class="form-control" type="url" id="website" name="website[]">
                            @endif
                        </div>
                        <a href="#" class="pl h4 font-weight-bold">+</a>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <h6>Instellingen</h6>
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group switch-field">
                                <div class="switch-title font-weight-bold">Publiceren</div>
                                <input type="radio" name="published" value="1" id="publish_yes"
                                @if($mode == 'edit'){{$companyItem->is_published == 1 ? 'checked' : ''}}@endif>
                                <label for="publish_yes">Ja</label>
                                <input type="radio" name="published" value="0" id="publish_no" class="switch-no"
                                @if($mode == 'create')checked @else {{$companyItem->is_published == 0 ? 'checked' : ''}}@endif>
                                <label for="publish_no">Nee</label>
                                <div class="clearfix">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group switch-field">
                                <div class="switch-title font-weight-bold">Highlight
                                </div>
                                <input type="radio" name="highlight" value="1" id="highlight_yes"
                                @if($mode == 'edit'){{$companyItem->is_highlighted == 1 ? 'checked' : ''}}@endif>
                                <label for="highlight_yes">Ja</label>
                                <input type="radio" name="highlight" value="0" id="highlight_no" class="switch-no"
                                @if($mode == 'create')checked @else {{$companyItem->is_highlighted == 0 ? 'checked' : ''}}@endif>
                                <label for="highlight_no">Nee</label>
                                <div class="clearfix">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold" for="companyType">Type</label>
                                <select class="form-control" id="companyType" name="companyType" required>
                                    @if($mode == 'create')<option  value="" hidden>Kies een type</option> @endif
                                    @foreach(config('companyTypes') as $type)
                                        <option value="{{$type->id}}"  @if($mode == 'edit') @if($type->id == $companyItem->type_id) selected @endif @endif >{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="category">Categorie</label>
                                <select onchange="filterCat()" class="form-control" id="category" name="category" required>
                                    @if($mode == 'create')<option  value="" hidden>Kies een categorie</option> @endif
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}"  @if($mode == 'edit') @if($category->id == $companyItem->subCategory->category->id) selected @endif @endif >{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="subCategory" id="subCatLabel" @if($mode == 'create') style="display:none;" @endif>Subcategorie</label>
                                <select class="form-control" id="subCategory" name="subCategory" @if($mode == 'create') style="display:none;" @endif required>
                                    <option  value="" id="chooseCat" hidden>Kies een subcategorie</option>
                                    @foreach($subcategories as $sub)
                                        <option data-category={{$sub->category->id}} value="{{$sub->id}}"  @if($mode == 'edit') @if($sub->id == $companyItem->subCategory_id) selected @endif @endif >{{$sub->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <h6>Afbeelding</h6>
                    <p class="info-text"></p>
                    <img src="" id="img" class="img-preview" alt="">
                    @if(isset($companyItem->logo) and $companyItem->logo != '')
                        <img src="{{asset($companyItem->logo)}}" class="img-fluid img-thumbnail">
                    @endif
                    <br><br>
                    <div class="input-group">
                        <input id="thumbnail" class="form-control" type="text" value="@if(isset($companyItem->logo)){{$companyItem->logo}}@endif" name="imageUpload">
                        <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-search rounded-right">
                            <i class="far fa-image"></i> Bladeren</a>
                        </span>
                    </div>
                    <script src="/vendor/laravel-filemanager/js/lfm.js"></script>
                    <img id="holder">
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6">
                    <h6>Adres gegevens</h6>
                    <div class="form-group">
                        <label class="font-weight-bold" for="address">Adres</label>
                        <input class="form-control" type="text" id="address" name="address" required
                        @if($mode == 'edit')value="{{$companyItem->address}}"@endif>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold" for="zip_code">Postcode</label>
                        <input class="form-control" type="text" id="zip_code" name="zip_code" required
                        @if($mode == 'edit')value="{{$companyItem->zip_code}}"@endif>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold" for="city">Plaats</label>
                        <input class="form-control" type="text" id="city" name="city" required
                        @if($mode == 'edit')value="{{$companyItem->city}}"@endif>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold" for="telephone">Telefoon</label>
                        <input class="form-control" type="text" id="telephone" name="telephone" required
                        @if($mode == 'edit')value="{{$companyItem->telephone}}"@endif>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold" for="email">E-mail</label>
                        <input class="form-control" type="text" id="email" name="email"
                        @if($mode == 'edit')value="{{$companyItem->email}}"@endif>
                    </div>
                </div>

                <div class="col-6">
                    <h6>Video URL</h6>
                    @if(isset($companyItem->video) and $companyItem->video != '')
                        <iframe width="480" height="270" src="{{asset($companyItem->video)}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    @endif
                    <br><br>
                    <div class="form-group">
                        <input class="form-control" type="url" id="video" name="video"
                        @if($mode == 'edit')value="{{$companyItem->video}}"@endif>
                    </div>
                </div>
            </div>
            @include('adm.partials.savebuttons')
        </form>
    </div>
@endsection


@section('js')
    @include('adm.partials.forms-js')
    <script type="text/javascript">
    var mode = "echo $mode";
    if(mode == 'edit')
    {
        filterCat(false);
    }
    document.addEventListener("DOMContentLoaded", function() {

        document.getElementById('lfm').addEventListener('click', (event) => {
        event.preventDefault();
            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });

    function filterCat(keepvalue=true){
        var mainCategory = document.getElementById("category").value;
        var subCatSelect =     document.getElementById("subCategory");
        subCatLabel.style.display="inline-block";
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

    // set file link
    function fmSetLink($url) {
    document.getElementById('thumbnail').value = $url;
    $('#img').attr('src', $url);
    $('.info-text').text("Dit is een preview van de afbeelding, vergeet niet op te slaan.");
    }

        $(document).ready(function () {
            $('#save').click(function () {
                $('button[value="save"]').click();
            });
            $('#saveme').click(function () {
                $('button[value="saveme"]').click();
            });
            $('#saveclose').click(function () {
                $('button[value="saveclose"]').click();
            });
        });
    </script>

    <script type="text/javascript" src="dist/js/jquery-2.1.1.min.js"></script>

    <script type="text/javascript">
    $(function() {
        $('a.pl').click(function(e) {
            e.preventDefault();
            $('#website').append('<input class="form-control" style="margin-bottom: 10px;" type="text" id="website" name="website[]">');
        });
        $('a.mi').click(function (e) {
            e.preventDefault();
            if ($('#website input').length > 1) {
                $('#website').children().last().remove();
            }
        });
    });
    </script>
@endsection
