<style>
.grid-link {
    float:left;
    display:block;
    border-right:1px solid #000;
    border-bottom:1px solid #000;
}
</style>

<div class="row">
    <div class="col-12 col-lg-6">
        <h6>Inhoud</h6>
        <div class="form-group">
            <textarea class="form-control" id="content" rows="3" name="content" required>@if($mode == 'edit'){{$item->text}}@endif</textarea>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <h6>Afbeelding</h6>
        <img src="" id="img" class="img-preview" alt="">
        @if(isset($item->image_src) and $item->image_src != '')
        <div class="position-relative" id="imgholder">

            <img src="{{asset($item->image_src)}}" id="current_img" class="img-fluid img-thumbnail">
        </div>
        @endif
        <div class="input-group mt-3">
            <input id="imageInput" class="form-control" type="text"
                   value="@if(isset($item->image_src)){{$item->image_src}}@endif" name="imageUpload">

            <span class="input-group-btn">
             <a id="imageBtn" data-input="thumbnail" data-preview="holder" class="btn btn-search rounded-right">
               <i class="far fa-image"></i> Bladeren
             </a>
            </span>
        </div>
        <img id="holder" >

        <div class="form-group">
            <input class="form-control" type="hidden" id="focuspoint" value="@if($mode == 'edit'){{$item->focuspoint}}@else 50%,50% @endif" name="focuspoint">
            <label class="font-weight-bold" for="imgCaption">Bijschrift</label>
            <input class="form-control" type="text" id="imgCaption" name="imgCaption"
                   @if($mode == 'edit')value="{{$item->image_caption}}"@endif>
        </div>
    </div>



</div>

<script>
    function Dragged(el){
        let left = ($(el).position().left  / $('#dotholder').width()) * 100;
        let top = ($(el).position().top  / $('#dotholder').height()) * 100;

        //this makes the most right be at 100%, but you miss range ≈50-56
        // left = Math.round(left > 50 ? left +=(30  / $('#dotholder').width()) * 100 : left);
        // top = Math.round(top > 50 ? top +=(30  / $('#dotholder').height()) * 100 : top);

        $('#focuspoint').val(left + '% ' + top + '%');
    }

    $(document).ready(function(){
        let imgWidth = $('#current_img').outerWidth();
        let imgHeight = $('#current_img').outerHeight();
        let mode = "{{$mode}}";
        let left;
        let top;

        if (mode == 'edit') {
            let percentage = "@if($mode=='edit'){{$item->focuspoint}} @endif";
            var re = new RegExp('%', 'g');
            percentage = percentage.replace(re,'').split(' ');
            left = (imgWidth / 100)  * percentage[0];
            top = (imgHeight / 100)  * percentage[1];
        }
        else{
            left = 50;
            top = 50;
        }

        $("#imgholder").append('<div id="dotholder" style="position:absolute;top:0;height:'+imgHeight+'px;width:'+imgWidth+'px"></div>');

        $('#dotholder').append('<div id="drag-dot" ondrag="Dragged(this)" class="rounded-circle bg-site-color" style="width:25px;height:25px;position:relative;top:'+Math.round(top)+'px;left:'+Math.round(left)+'px;"></div>');

        $( "#drag-dot" ).draggable({ containment: "parent" });
    });
</script>
