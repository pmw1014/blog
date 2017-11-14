
<?php foreach ($page->items as $item) { ?>
<div class="item ui segment">
    <div class="content">
        <h2 class="ui dividing header"><a class="get-detail" href="JavaScript:;" data-ajax="get" data-ajax-url="/description/{{ item.id }}">{{ item.title }}</a></h2>
        <div class="description">
            <p>{{ item.description }}</p>
        </div>
        <?php if(!empty($item['cover'])){ ?>
        <div class="image">
          <img src="{{ item.cover }}">
        </div>
        <?php } ?>
        <a class="ui {{ item.tag_color }} left ribbon label" href="javascript:;">{{ item.tag_name }}</a>
    </div>
</div>
<?php } ?>
<?php if($page->total_pages > 1){ ?>
<div class="ui large buttons center">
    <a class="ui button" href="JavaScript:;" data-ajax="get" data-ajax-url="/article/list?page=<?php echo $page->before; ?>">&larr;</a>
    <div class="or"></div>
    <a class="ui button" data-ajax="get" data-ajax-url="/article/list?page=<?php echo $page->next; ?>">&rarr;</a>
</div>
<?php } ?>
