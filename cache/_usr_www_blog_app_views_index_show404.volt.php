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
            
<p>Ops!</p>

        </div>
        <?= $this->assets->outputJs('footerJs') ?>

        
    </body>
</html>
