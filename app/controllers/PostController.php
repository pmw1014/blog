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
            $body['body'] = $this->request->getPost('body');
            $data['cover'] = $this->takenCover($body['body']);
            $data['description'] = strip_tags(my_mbsubstr($body['body']));
            $body['body'] = htmlspecialchars($body['body']);
            $data['state'] = 1;
            $data['tags_id'] = 1;

            $articles->assign($data);
            $articleBody->articles = $articles;

            if ($articleBody->create($body) === false) {
                $messages = $articleBody->getMessages();
                $error = '';
                foreach ($messages as $message) {
                    $error .= $message;
                }
                $this->returnAjaxJson(false,'发表失败：'.$error);
            }else{
                $this->returnAjaxJson(true,'发表成功','',$this->url->get("/"));
            }
        }
        $this->tag->prependTitle("New Post - ");
    }

    private function takenCover($body){
        if(preg_match_all('/<img.*?src="(.*?)".*?>/is', $body, $matches)){
            return $matches[1][0];
        }else{
            return '';
        }
    }
}
