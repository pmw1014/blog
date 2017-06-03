
<div class="ui segment">
    <a class="ui green right corner label" data-ajax="get" data-ajax-url="{{ edit_link }}"><i class="write icon"></i></a>
    <h2 class="ui center aligned header">{{ article.title }}</h2>
    <div>{{ body }}</div>
    <p class="ui right aligned header">
        {% if tag is defined %}
        <a class="ui {{ tag['color'] }} tag label">{{ tag['title'] }}</a>
        {% endif %}
        {% if catalog is defined %}
        <a class="ui mini label">{{ catalog['title'] }}</a>
        {% endif %}
        <a class="ui basic disabled button label"><i class="black calendar icon"></i> {{article.update_at}}</a>
        <a class="ui basic disabled button label"><i class="black unhide icon"></i> {{article.viewed}}</a>
    </p>
    <div class="ui divider"></div>
</div>
