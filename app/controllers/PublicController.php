<?php
use App\Library\Utils\Errorcode;

class PublicController extends ControllerBase
{
    public function Initialize(){
        parent::Initialize();
    }

    public function loginAction()
    {
        if (isset($this->sessionUser->id)) {
            return $this->response->redirect('/');
        }
        $this->tag->prependTitle("登录 - ");
    }

    public function registerAction()
    {
        if (isset($this->sessionUser->id)) {
            return $this->response->redirect('/');
        }
        $this->tag->prependTitle("注册 - ");
    }

    public function show404Action()
    {
        $this->tag->prependTitle("404 - ");
    }

    public function ajaxshow404Action()
    {
        $code = $this->dispatcher->getParam("code",'int');
        $label = isset(Errorcode::$codes[$code]['label']) ? Errorcode::$codes[$code]['label'] : '';
        $this->tag->prependTitle("404 - ");

        $this->view->label = $label;
    }

}
