{% extends "base.volt" %}

{% block content %}
<div class="item ui segment">
    <div class="content">
        <h2 class="ui dividing header"><a href="JavaScript:;">xxxxxxxxxxx</a></h2>
        <div class="description">
            <p><img src="/img/short-paragraph.png" alt=""></p>
        </div>
        <div class="image">
          <img src="/img/image.png">
        </div>
        <div class="extra"><i class="black unhide icon"></i> 0 Votes </div>
    </div>
    <div class="ui divider"></div>
</div>
<div class="item ui segment">
    <div class="content">
        <h2 class="ui dividing header"><a href="JavaScript:;">xxxxxxxxxxx</a></h2>
        <div class="description">
            <p><img src="/img/short-paragraph.png" alt=""></p>
        </div>
        <div class="image">
          <img src="/img/image.png">
        </div>
        <div class="extra"><i class="black unhide icon"></i> 0 Votes </div>
    </div>
    <div class="ui divider"></div>
</div>
{% endblock %}

{% block footerjs %}
<script>
Pace.track(function(){
    $.ajax({
        url: "/article/list",
        type: "get",
        data: $("#postForm").serialize(),
        success: function( result ) {
            $("#content-wrapper").html(result);
        }
    });
});
</script>
{% endblock %}
