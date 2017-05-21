{% extends "base.volt" %}

{% block content %}
<div class="ui container">
    <h2 class="ui center aligned header">{{ article.title }}</h2>
    <div>{{ body }}</div>
</div>
{% endblock %}

{% block footerjs %}{% endblock %}
