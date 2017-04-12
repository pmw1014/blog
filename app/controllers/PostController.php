<?php

class PostController extends ControllerBase
{

    private $articles = '';

    public function Initialize(){
        $this->articles = new Articles();
        parent::Initialize();
    }

    public function newAction(){
        if($this->request->isAjax()){
            $now = time();
            $data['title'] = $this->request->getPost('title',['trim','striptags']);
            $data['body'] = $this->request->getPost('body',['trim']);
            $data['body'] = htmlspecialchars($data['body']);
            $data['state'] = 1;
            $data['create_at'] = date('Y-m-d H:i:s',$now);
            $data['update_at'] = date('Y-m-d H:i:s',$now);
            $res = $this->articles->save($data);
            echo '<pre>';var_dump($res);exit;
        }
        $this->tag->prependTitle("New Post - ");
    }
}
