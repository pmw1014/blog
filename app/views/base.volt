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
        <div class="ui top attached menu">
            <a class="item" href="/">
                <i class="home icon"></i> Home
            </a>
            <a class="item" href='{{ url("/post/new") }}'>
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
                    <div class="ui basic segment">
                        {% block content %}<p>main page</p>{% endblock %}
                    </div>
                </div>
            </div>
        </div>

        {{ assets.outputJs("footerJs") }}
        <script>
            $('.ui.sidebar')
            .sidebar({
            context: $('.article')
            })
            .sidebar('attach events', '.menu .item.menu')
            ;
        </script>
        {% block footerjs %}{% endblock %}
    </body>
</html>
