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
        </div>
        

        <div class="ui raised very padded text container segment">
            
<div class="ui items">
    <?php foreach ($page->items as $item) { ?>
    <div class="item">
        <div class="content">
            <a class="header"><?php echo $item->title; ?></a>
            <div class="description">
            <?php echo htmlspecialchars_decode($item->body); ?>
            </div>
            <div class="extra"><i class="black unhide icon"></i> 121 Votes </div>
        </div>
    </div>
    <?php } ?>
    <div class="ui large buttons center">
        <a class="ui button" href="?page=<?php echo $page->before; ?>">&larr;</a>
        <div class="or"></div>
        <a class="ui button" href="?page=<?php echo $page->next; ?>">&rarr;</a>
    </div>
</div>

        </div>
        <?= $this->assets->outputJs('footerJs') ?>

        
    </body>
</html>
