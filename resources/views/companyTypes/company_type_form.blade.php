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
                        <h1 class="site-color">Voeg bedrijfs type toe</h1>
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

    <div class="container-fluid pt-4 pb-4">
        <form method="POST" enctype="multipart/form-data" data-ajax="false" class="was-validated"
                @if($mode == 'create')
                action="/adm/bedrijfstypes"
                @else
                action="/adm/bedrijfstypes/{{$companyItem->id}}"
                @endif>
            @if($mode == 'edit')
                {{ method_field('PUT') }}
            @endif
            {{ csrf_field() }}
            <div class="row">
                <div class="col-12 col-md-6">
                    <h6>BedrijfsType</h6>
                    <div class="form-group">
                        <label class="font-weight-bold" for="name">Type</label>
                        <input class="form-control" type="text" id="name" name="name" required
                                @if($mode == 'edit')value="{{$companyItem->name}}"@endif>
                    </div>
                </div>
                <div class="col-12">
                    @include('adm.partials.savebuttons')
                </div>
            </div>
        </form>
    </div>
@endsection


@section('js')

<script type="text/javascript">

    document.addEventListener("DOMContentLoaded", function() {

        document.getElementById('lfm').addEventListener('click', (event) => {
            event.preventDefault();

            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });

// set file link
    function fmSetLink($url) {
    document.getElementById('thumbnail').value = $url;
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
