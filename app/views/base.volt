{{ get_doctype() }}
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{ tag.getTitle() }}
        {{ assets.outputCss('headerCss') }}
        {% block headcss %}{% endblock %}
    </head>
    <body>
        {% block headmenu %}
        <div class="ui attached menu">
            <a class="item" href="JavaScript:;" data-ajax='get' data-ajax-url='{{ url("/article/list") }}'>
                <i class="home icon"></i> Home
            </a>
            <a class="item" href="JavaScript:;" data-ajax='get' data-ajax-url='{{ url("/post/new") }}'>
                <i class="add to calendar icon"></i> New Post
            </a>
            <a class="sidebar item menu" href="javascript:;">
                <i class="grid layout icon"></i> Menu
            </a>
        </div>
        {% endblock %}
        <div class="article">
            <div class="ui inverted labeled icon left inline vertical sidebar menu">
                <div class="item">
                  <div class="header">PHP</div>
                  <div class="menu">

                      <a class="item" href="/introduction/integrations.html">PHP框架 </a>

                      <a class="item" href="/introduction/build-tools.html">PHP技术 </a>

                  </div>
                </div>
            </div>
            <div class="pusher">
                <div class="ui container">
                    <div id="content-wrapper">
                        {% block content %}<p>main page</p>{% endblock %}
                    </div>
                </div>
            </div>
            <div class="ui divider"></div>
            <br/>
            <br/>
        </div>
        {{ assets.outputJs("footerJs") }}
        <script>
            $('.ui.sidebar')
            .sidebar({
            context: $('.article')
            })
            .sidebar('attach events', '.menu .item.menu')
            ;

            $('body').on('click','a[data-ajax]',function(){
                var _this = $(this),
                    method = _this.data('ajax'),
                    url   = _this.data('ajax-url');
                    Pace.track(function(){
                        $.ajax({
                            url: url,
                            type: method,
                            success: function( result ) {
                                $("#content-wrapper").html(result);
                            }
                        });
                    });
            });
        </script>
        {% block footerjs %}{% endblock %}
    </body>
</html>
