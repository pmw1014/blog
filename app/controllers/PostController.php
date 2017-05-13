<?php

class PostController extends ControllerBase
{

    private $articles = '';
    private $articleBody = '';

    public function Initialize(){
        $this->articles = new Articles();
        $this->articleBody = new ArticleBody();
        parent::Initialize();
    }

    public function newAction(){
        if($this->request->isAjax()){
            $articles = new Articles();
            $articleBody = new ArticleBody();

            $now = time();
            $data['title'] = $this->request->getPost('title',['trim','striptags']);
            $body['body'] = $this->request->getPost('body',['trim']);
            $data['description'] = strip_tags(my_mbsubstr($body['body']));
            $body['body'] = htmlspecialchars($body['body']);
            $data['state'] = 1;
            $data['tags_id'] = 1;
            $data['create_at'] = date('Y-m-d H:i:s',$now);
            $data['update_at'] = date('Y-m-d H:i:s',$now);

            $articles->title = $data['title'];
            $articles->description = $data['description'];
            $articles->state = $data['state'];
            $articles->tags_id = $data['tags_id'];
            $articles->create_at = $data['create_at'];
            $articles->update_at = $data['update_at'];

            $articleBody->articles = $articles;
            $articleBody->body = $body['body'];

            $result = $articleBody->save();

            if($result){
                $this->returnAjaxJson(true,'发表成功','',$this->url->get("/"));
            }
            $this->returnAjaxJson(false,'发表失败');
        }
        $this->tag->prependTitle("New Post - ");
    }
}
