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
            $result = $this->articles->save($data);
            if($result){
                $this->returnAjaxJson(true,'发表成功','',$this->url->get("/"));
            }
            $this->returnAjaxJson(false,'发表失败');
        }
        $this->tag->prependTitle("New Post - ");
    }
}
