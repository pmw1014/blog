<?php foreach ($page->items as $item) { ?>
<div class="item ui segment">
    <div class="content">
        <h2 class="ui dividing header"><a class="get-detail" href="JavaScript:;" data-id="{{ item.id }}">{{ item.title }}</a></h2>
        <div class="description">
            <p>{{ item.description }}</p>
        </div>
        <?php if(!empty($item['cover'])){ ?>
        <div class="image">
          <img src="{{ item.cover }}">
        </div>
        <?php } ?>
        <div class="extra"><i class="black unhide icon"></i> {{ item.viewed }} Votes </div>
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
<script>
$(".get-detail").click(function(){
    var _this = $(this),
        id    = _this.data('id');
    Pace.track(function(){
        $.ajax({
            url: "/article/description",
            type: "get",
            data: {'id':id},
            success: function( result ) {
                $("#content-wrapper").html(result);
            }
        });
    });
});
</script>
