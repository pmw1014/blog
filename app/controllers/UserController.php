<?php

class UserController extends ControllerBase
{

    public function Initialize()
    {
        parent::Initialize();
    }

    public function loginAction()
    {
        if($this->request->isPost()){

            if (!$this->security->checkToken()) {
                $this->returnAjaxJson(false,'当前页面已过期','',$this->url->get("/login"));
            }

            $USER = new Users();
            $USER->login = $this->request->getPost('email',['email','trim']);
            $USER->password =  $this->request->getPost('password',['email','trim']);
            $login = $USER->login();
            if($login){

                //session
                $this->sessionUser->id = $login['id'];
                $this->sessionUser->login = $login['login'];
                $this->sessionUser->access = 'Admins';

                $this->returnAjaxJson(true,'登录成功','',$this->url->get('/'));
            }else{
                $messages = $USER->getMessages();
                $error = '<ul class=\'list\'>';
                foreach ($messages as $message) {
                    $error .= '<li>'.$message.'</li>';
                }
                $error .= '</ul>';
                $e_data['tokenKey'] = $this->security->getTokenKey();
                $e_data['token'] = $this->security->getToken();
                $this->returnAjaxJson(false,$error,$e_data);
            }
        }
    }

    public function regAction()
    {
        if($this->request->isPost()){

            if (!$this->security->checkToken()) {
                $this->returnAjaxJson(false,'当前页面已过期','',$this->url->get("/register"));
            }

            $data['login'] = $this->request->getPost('email',['email','trim']);
            $data['password'] = $this->request->getPost('password',['email','trim']);

            $USER = new Users();

            if ($USER->create($data) === false) {
                $messages = $USER->getMessages();
                $error = '<ul class=\'list\'>';
                foreach ($messages as $message) {
                    $error .= '<li>'.$message.'</li>';
                }
                $error .= '</ul>';
                $e_data['tokenKey'] = $this->security->getTokenKey();
                $e_data['token'] = $this->security->getToken();
                $this->returnAjaxJson(false,$error,$e_data);
            }else{
                $this->returnAjaxJson(true,'注册成功','',$this->url->get(
                    [
                        'for' => 'login'
                    ]
                ));
            }
        }
    }

}
