<a data-toggle="collapse" href="#collapseSeo" aria-expanded="false" class="no-underline" aria-controls="collapseSeo">
    <h6 id="collapseToggleSeo">SEO <i class="fas fa-angle-right pull-right"></i></h6>
</a>
<div class="collapse" id="collapseSeo">
        {{-- @if($mode == 'create') show @endif --}}
    <div class="form-group">
        <label class="font-weight-bold" for="meta_title">Meta Title</label>
        <input class="form-control" type="text" id="meta_title" name="meta_title"
               @if($mode == 'edit')value="{{$item->meta_title}}"@endif>
    </div>

    <div class="form-group">
        <label class="font-weight-bold" for="meta_description">Meta Description</label>
        <textarea maxlength="190" class="form-control" type="text" id="meta_description"
                  name="meta_description">@if($mode == 'edit'){{$item->meta_description}}@endif</textarea>
    </div>

<!--<div class="form-group">
        <label class="font-weight-bold" for="permalink">Slug</label>
        <input class="form-control" type="text" id="permalink" name="permalink"
               @if($mode == 'edit')value="{{$item->slug}}"@endif>
    </div>-->
</div>

@section('js')
    <script>
        //limit meta_description paste characters
        var meta_title = document.getElementById("meta_title");

        meta_title.onpaste = function (event) {
            var max = meta_title.getAttribute("maxlength");
            event.clipboardData.getData('text/plain').slice(0, max);
        }

        $('#collapseToggleSeo').click(function() {
            $(this).find("svg").toggleClass("fa-rotate-90");
        });
    </script>
@stop