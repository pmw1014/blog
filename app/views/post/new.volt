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
    {% if article is defined %}
    Edit -- {{ article.title }}
    {% else %}
    New Post
    {% endif %}
</h2>

<div class="ui form">
<form id="postForm">
    <div class="ui sub header">选择标签</div>
    <div class="ui search selection dropdown">
        <input type="hidden" name="tag_id" value="{% if tag is defined %}{{ tag['id'] }}{% endif %}">
        <i class="dropdown icon"></i>
        <div class="default text">选择标签</div>
        <div class="menu">
            {% for tag in tags %}
            <div class="item" data-value="{{ tag['id'] }}"><i class="ui {{ tag['color']}} empty circular label"></i>{{ tag['title'] }}</div>
            {% endfor %}
        </div>
    </div>
    <div class="ui sub header">选择栏目</div>
    <div class="ui search selection dropdown">
        <input type="hidden" name="catalog_id" value="{% if catalog is defined %}{{ catalog['id'] }}{% endif %}">
        <i class="dropdown icon"></i>
        <div class="default text">选择栏目</div>
        <div class="menu">
            {% for catalog in catalogs %}
            <div class="item" data-value="{{ catalog['id'] }}">{{ catalog['title'] }}</div>
            {% endfor %}
        </div>
    </div>
    <div class="ui divider"></div>
    <div class="field">
        <label for="title"><i class="quote left icon"></i></label>
        {% if article is defined %}
            {{ textField(['title','placeholder':'请输入标题','id':'title','value':article.title]) }}
        {% else %}
            {{ textField(['title','placeholder':'请输入标题','id':'title']) }}
        {% endif %}
    </div>
    <div class="ui divider"></div>
    <div class="field">
        <label for="body"><i class="quote right icon"></i></label>
        <textarea id="body" name="body">
        {% if body is defined %}{{ body }}{% endif %}</textarea>
    </div>
    <p>
        {% if article is defined %}
        <input type="hidden" name="id" value="{{ article.id }}">
        <a class="ui primary button" id="new" href="JavaScript:;" ajax-url="{{ action_link }}">保存</a>
        {% else %}
        <a class="ui primary button" id="new" href="JavaScript:;" ajax-url="{{ action_link }}">发布</a>
        {% endif %}
    </p>
</form>
<div class="ui divider"></div>
<div id="preview" class="fr-view"></div>
</div>
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
    $('body').on("click","#new",function(){
        var _this = $(this),
            url   = _this.attr('ajax-url');
        Pace.track(function(){
            $.ajax({
                url: url,
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
    $('.ui.selection.dropdown').dropdown();
</script>
