<?= $this->tag->getDoctype() ?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $this->tag->getTitle() ?>
        <?= $this->assets->outputCss('headerCss') ?>
        
    </head>
    <body>
        
        <div class="ui attached stackable menu">
          <div class="ui container">
            <a class="item" href="/">
              <i class="home icon"></i> Home
            </a>
            <a class="item" href='/Post/new'>
              <i class="grid layout icon"></i> New Post
            </a>
            <a class="item">
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
            </div>
            <div class="right item">
              <div class="ui input"><input type="text" placeholder="Search..."></div>
            </div>
          </div>
        </div>
        

        <div class="ui raised very padded text container segment">
            
<h2>
    New Post
</h2>

<div class="ui form">
<form id="postForm">
    <div class="field">
        <label for="title"><i class="quote left icon"></i></label>
        <?= $this->tag->textfield(['title', 'placeholder' => '请输入标题', 'id' => 'title']) ?>
    </div>
    <div class="ui divider"></div>
    <div class="field">
        <label for="body"><i class="quote right icon"></i></label>
        <textarea placeholder="可以编辑里面的内容" name="body" id="body"></textarea>
    </div>
    <div class="ui divider"></div>
    <p>
        <?= $this->tag->linkTo(['JavaScript:;', '新增', 'class' => 'ui primary button', 'id' => 'new']) ?>
    </p>
</form>
</div>

        </div>
        <?= $this->assets->outputJs('footerJs') ?>

        
<script>
$("#new").click(function(){
    $.ajax({
        url: "/Post/new",
        type: "post",
        data: $("#postForm").serialize(),
        success: function( result ) {
            alert(result);
        }
    });
});
</script>

    </body>
</html>
