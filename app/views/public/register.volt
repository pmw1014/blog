{{ get_doctype() }}
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{ tag.getTitle() }}
        {{ assets.outputCss('loginCss') }}
        <style type="text/css">
            body {
              background-color: #DADADA;
            }
            body > .grid {
              height: 100%;
            }
            .image {
              margin-top: -100px;
            }
            .column {
              max-width: 450px;
            }
        </style>
    </head>
    <body>
        <div class="ui middle aligned center aligned grid">
          <div class="column">
            <form class="ui large form">
                <input type="hidden" id="f_token" name="<?php echo $this->security->getTokenKey() ?>"
        value="<?php echo $this->security->getToken() ?>"/>
              <div class="ui stacked segment">
                <h4 class="ui dividing header">注册账户</h4>
                <div class="field">
                  <div class="ui left icon input">
                    <i class="user icon"></i>
                    <input type="text" name="email" placeholder="请输入有效的邮箱地址">
                  </div>
                </div>
                <div class="field">
                  <div class="ui left icon input">
                    <i class="lock icon"></i>
                    <input type="password" name="password" placeholder="请输入8~30字符">
                  </div>
                </div>
                <div class="ui fluid large teal submit button">注册</div>
              </div>

              <div class="ui error message"></div>

            </form>
          </div>
        </div>
        {{ assets.outputJs("loginJs") }}
        <script>
        $.fn.api.settings.api = {
          'create user' : '/user/reg',
        };

          $(document)
            .ready(function() {
              $('.ui.form')
                .form({
                    on: 'blur',
                  fields: {
                    email: {
                      identifier  : 'email',
                      rules: [
                        {
                          type   : 'empty',
                          prompt : '请输入邮箱地址作为您的登录名'
                        },
                        {
                          type   : 'email',
                          prompt : '请输入合法的邮箱地址'
                        }
                      ]
                    },
                    password: {
                      identifier  : 'password',
                      rules: [
                        {
                          type   : 'empty',
                          prompt : '请输入您的密码'
                        },
                        {
                          type   : 'minLength[6]',
                          prompt : '密码必须在6~30位之间'
                        },
                        {
                          type   : 'maxLength[30]',
                          prompt : '密码必须在6~30位之间'
                        }
                      ]
                    }
                  },
                  onSuccess: function(){
                      $('form .submit.button').api({
                          action: 'create user',
                          method: 'POST',
                          serializeForm: true,
                          onSuccess: function(response) {
                              $(".ui.error.message").html('');
                            if(response.state == false){
                                $(".ui.error.message").html(response.msg);
                                $(".ui.error.message").show();
                                $('#f_token').attr('name',response.data.tokenKey);
                                $('#f_token').val(response.data.token);
                            }
                            if(response.link){
                                window.location.href = response.link;
                            }
                          }
                      });
                      return false;
                  }
              })
              ;
            })
          ;
        </script>
    </body>
</html>
