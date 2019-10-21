<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    var options =
    {
        filebrowserImageBrowseUrl: '/file-manager/ckeditor',
        toolbarGroups: [
		{ name: 'document', groups: [ 'document', 'mode', 'doctools' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles' ] },
		{ name: 'paragraph', groups: [ 'list' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'styles', groups: [ 'styles' ] },
        ],
        removeButtons: 'Templates,Save,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,NewPage,Preview,Print,Find,Replace,SelectAll,Scayt,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,RemoveFormat,Outdent,Indent,Blockquote,CreateDiv,Unlink,Anchor,Flash,Smiley,SpecialChar,PageBreak,Iframe,Youtube,Maximize,ShowBlocks,About,BGColor,BidiLtr,BidiRtl'
    };

    $(document).ready(function() {
        $('#save').click(function(){
            $('button[value="save"]').click();
        });
        $('#saveadd').click(function(){
            $('button[value="saveadd"]').click();
        });
        $('#saveclose').click(function(){
            $('button[value="saveclose"]').click();
        });

        $("h2").on("click", function(e) {
            e.preventDefault();
            $(this).find("svg").toggleClass("rotate1 rotate2");
        });

        var editorsToCheck = ["content","content2", "footer_1", "footer_2", "footer_3", "footer_4", "contact_1", "news_text","disclaimer_text"];

        for(var i = 0; i < editorsToCheck.length; i++ )
        {
            if($('#'+editorsToCheck[i]).length)
            {
                var editor = CKEDITOR.replace( editorsToCheck[i] , options);

                editor.on('required', function(evt) {
                    editor.showNotification('Dit veld is verplicht.', 'warning');
                    evt.cancel();
                });
            }
        }
    });
</script>