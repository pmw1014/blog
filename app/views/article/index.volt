{% extends "base.volt" %}

{% block content %}
<div class="ui items">
    <?php foreach ($page->items as $item) { ?>
    <div class="item">
        <div class="content">
            <a class="header">{{ item.title }}</a>
            <div class="description">{{ item.description }}</div>

            <?php if(!empty($item['cover'])){ ?>
            <div class="image">
              <img src="{{ item.cover }}">
            </div>
            <?php } ?>
            <div class="extra"><i class="black unhide icon"></i> {{ item.viewed }} Votes </div>
        </div>
    </div>
    <?php } ?>
    <div class="ui large buttons center">
        <a class="ui button" href="?page=<?php echo $page->before; ?>">&larr;</a>
        <div class="or"></div>
        <a class="ui button" href="?page=<?php echo $page->next; ?>">&rarr;</a>
    </div>
</div>
{% endblock %}

{% block footerjs %}{% endblock %}
