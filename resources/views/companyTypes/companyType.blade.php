@extends('layouts.backend.app-backend')

@section('content')
	{{-- SHOW FLASH MESSAGE --}}
	@foreach (['danger', 'warning', 'success', 'info'] as $msg)
	    @if(Session::has('alert-' . $msg))
	        <p class="avant-alert alert alert-{{ $msg }}" id="message">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
	    @endif
	@endforeach

    <div class="bg-grey py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <h1 class="text-color">Bedrijven</h1>
                </div>
                @can('create news')
                <div class="col-6">
                    <a href="/adm/bedrijfstypes/create" class="btn btn-add bg-color float-right mr-2">Type toevoegen</a>
                </div>
                @endcan
            </div>
        </div>
    </div>

    <div class="container-fluid pt-4 pb-4">
        <div class="row">
            <div class="col-12">
                <table id="overview" class="table table-sm table-striped table-hover table-bordered">
                    <thead>
                        <th width="200" class="text-left">Type</th>
                        <th width="200" class="text-right">Opties&nbsp;&nbsp;</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@section('js')
<script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function()
    {
        Table();

        var table = $('#overview').DataTable();

        table.on( 'draw', function ()
        {
            var body = $( table.table().body() );
            body.unhighlight();

            if ( table.rows( { filter: 'applied' } ).data().length )
            {
                body.highlight( table.search() );
            }
        });

        $('body').tooltip({
            selector: '[data-toggle=tooltip]'
        });
    });

    $('#type').change( function()
    {
        var table = $('#overview').DataTable();
        table.destroy();
        Table();
    });

    function Table()
    {
        ColorFilters();

        var typeFilter = $('#type').val();


        $('#overview').DataTable({
            "pageLength": 25,
            "order" : [[0, "asc"]],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Dutch.json",
            },

            "columnDefs": [
                { "orderable": false, "targets": 1 }
            ],
            "processing": true,
            "serverSide": true,
            "ajax":
            {
                "url": "{{ url('adm/companyTypeJson') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}", type : typeFilter}
            },
            "columns":
            [
                { "data": "name" },
                { "data": "options"}
            ]
        });
    }

    function Delete(id,el)
    {
        Swal.fire({
            text: "Weet u zeker dat u dit bedrijfstype wilt verwijderen?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ja, verwijderen!',
            cancelButtonText: 'Annuleren'
        }).then((result) => {
            if (result.value) {
                var token = $(el).data('token');
                $.ajax({
                    url:'/adm/bedrijfstypes/' + id,
                    type: 'delete',
                    data: {_method: 'delete', _token :token}
                })
                location.reload();
            }
        })
    }

    function ColorFilters()
    {
        $('#filters select').each(function(){
            $(this)[0].selectedIndex == 0 ?
            $(this).css("background-color", "#ddd") :
            $(this).css("background-color", "");
        });
    }
</script>
@endsection