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
    <body class="pushable">
        {% block headmenu %}
        <div class="ui top attached demo menu">
            <a class="item" href="/">
                <i class="home icon"></i> Home
            </a>
            <a class="item" href='/Post/new'>
                <i class="add to calendar icon"></i> New Post
            </a>
            <a class="item" href="javascript:;">
                <i class="grid layout icon"></i> Menu
            </a>
            <!-- <a class="item">
              <i class="mail icon"></i> Messages
            </a>
            <div class="ui simple dropdown item">
              More
              <i class="dropdown icon"></i>
              <div class="menu">
                <a class="item"><i class="edit icon"></i> Edit Profile</a>
                <a class="item"><i class="globe icon"></i> Choose Language</a>
                <a class="item"><i class="settings icon"></i> Account Settings</a>
              </div>
            </div> -->
            <!-- <div class="right item">
              <div class="ui input"><input type="text" placeholder="Search..."></div>
            </div> -->
        </div>
        {% endblock %}
        <div class="pusher">
            <div class="ui inverted labeled icon left inline vertical sidebar menu">
                <div class="item">
                  <div class="header">PHP</div>
                  <div class="menu">

                      <a class="item" href="/introduction/integrations.html">PHP框架 </a>

                      <a class="item" href="/introduction/build-tools.html">PHP技术 </a>

                  </div>
                </div>
            </div>
            <div class="article">
                <div class="ui container">
                    <div class="ui basic segment">
                        {% block content %}<p>main page</p>{% endblock %}
                    </div>
                </div>
            </div>
        </div>

        {{ assets.outputJs("footerJs") }}
        <script>
            // using context
            $('.ui.sidebar')
            .sidebar({
            context: $('.article')
            })
            .sidebar('attach events', '.menu .item')
            ;
        </script>
        {% block footerjs %}{% endblock %}
    </body>
</html>
