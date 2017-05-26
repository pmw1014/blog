<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="/plugin/froalaEditor/css/froala_editor.css">
<link rel="stylesheet" href="/plugin/froalaEditor/css/froala_style.css">
<link rel="stylesheet" href="/plugin/froalaEditor/css/plugins/code_view.css">
<link rel="stylesheet" href="/plugin/froalaEditor/css/plugins/image_manager.css">
<link rel="stylesheet" href="/plugin/froalaEditor/css/plugins/image.css">
<link rel="stylesheet" href="/plugin/froalaEditor/css/plugins/table.css">
<link rel="stylesheet" href="/plugin/froalaEditor/css/plugins/video.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">

<h2>
    New Post
</h2>

<div class="ui form">
<form id="postForm">
    <div class="field">
        <label for="title"><i class="quote left icon"></i></label>
        {{ textField(['title','placeholder':'请输入标题','id':'title']) }}
    </div>
    <div class="ui divider"></div>
    <div class="field">
        <label for="body"><i class="quote right icon"></i></label>
        <textarea id="body" name="body"></textarea>
        </div>
    </div>
    <div class="ui divider"></div>
    <p>
        {{ tag.linkTo(['JavaScript:;','发布','class':'ui primary button','id':'new']) }}
    </p>
</form>
<div class="ui divider"></div>
<div id="preview" class="fr-view"></div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
<script type="text/javascript" src="/plugin/froalaEditor/js/froala_editor.min.js"></script>
<script type="text/javascript" src="/plugin/froalaEditor/js/plugins/align.min.js"></script>
<script type="text/javascript" src="/plugin/froalaEditor/js/plugins/code_beautifier.min.js"></script>
<script type="text/javascript" src="/plugin/froalaEditor/js/plugins/code_view.min.js"></script>
<script type="text/javascript" src="/plugin/froalaEditor/js/plugins/draggable.min.js"></script>
<script type="text/javascript" src="/plugin/froalaEditor/js/plugins/image.min.js"></script>
<script type="text/javascript" src="/plugin/froalaEditor/js/plugins/image_manager.min.js"></script>
<script type="text/javascript" src="/plugin/froalaEditor/js/plugins/link.min.js"></script>
<script type="text/javascript" src="/plugin/froalaEditor/js/plugins/lists.min.js"></script>
<script type="text/javascript" src="/plugin/froalaEditor/js/plugins/paragraph_format.min.js"></script>
<script type="text/javascript" src="/plugin/froalaEditor/js/plugins/paragraph_style.min.js"></script>
<script type="text/javascript" src="/plugin/froalaEditor/js/plugins/table.min.js"></script>
<script type="text/javascript" src="/plugin/froalaEditor/js/plugins/video.min.js"></script>
<script type="text/javascript" src="/plugin/froalaEditor/js/plugins/url.min.js"></script>
<script type="text/javascript" src="/plugin/froalaEditor/js/plugins/entities.min.js"></script>
<script type="text/javascript" src="/plugin/froalaEditor/js/languages/zh_cn.js"></script>

<script>
    $(function(){
        $('#body').on('froalaEditor.contentChanged froalaEditor.initialized', function (e, editor) {
            $('#preview').html(editor.html.get());
        }).froalaEditor({
          language: 'zh_cn',
          height:'200px',
        });
    });
    $("#new").click(function(){
        Pace.track(function(){
            $.ajax({
                url: "/Post/new",
                type: "post",
                data: $("#postForm").serialize(),
                beforeSend: function() {
                },
                success: function( result ) {
                    if(result.state){
                        window.location.href = result.link;
                    }else{
                        alert(result.msg);
                    }
                },
                complete: function( result ){
                }
            });
        });
    });
</script>
