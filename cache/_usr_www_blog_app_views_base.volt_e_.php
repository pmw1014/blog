a:9:{i:0;s:319:"<?= $this->tag->getDoctype() ?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $this->tag->getTitle() ?>
        <?= $this->assets->outputCss('headerCss') ?>
        ";s:7:"headcss";N;i:1;s:32:"
    </head>
    <body>
        ";s:8:"headmenu";a:1:{i:0;a:4:{s:4:"type";i:357;s:5:"value";s:1024:"
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
        ";s:4:"file";s:33:"/usr/www/blog/app/views/base.volt";s:4:"line";i:38;}}i:2;s:81:"

        <div class="ui raised very padded text container segment">
            ";s:7:"content";a:1:{i:0;a:4:{s:4:"type";i:357;s:5:"value";s:16:"<p>main page</p>";s:4:"file";s:33:"/usr/www/blog/app/views/base.volt";s:4:"line";i:41;}}i:3;s:76:"
        </div>
        <?= $this->assets->outputJs('footerJs') ?>

        ";s:8:"footerjs";N;i:4;s:21:"
    </body>
</html>
";}