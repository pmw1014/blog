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
        if($this->request->isGet()){
            $this->tag->prependTitle("New Post - ");

            //TODO: 获取tag
            $tags = $this->modelsManager->createBuilder()
                ->columns(['id','title','color'])
                ->from('RefTags')
                ->where('state = :state:',["state"=>1])
                ->orderBy('id desc')
                ->getQuery()
                ->execute()
                ->toArray();
            $this->view->tags = $tags;

            //TODO: 获取栏目
            $catalogs = $this->modelsManager->createBuilder()
                ->columns(['id','title'])
                ->from('Catalogs')
                ->where('state = :state: AND parent_id != :parent_id:',["state"=>1,'parent_id'=>0])
                ->orderBy('id desc')
                ->getQuery()
                ->execute()
                ->toArray();
            $this->view->catalogs = $catalogs;

        }else if($this->request->isPost()){
            $articles = new Articles();
            $articleBody = new ArticleBody();

            $now = time();
            $data['title'] = $this->request->getPost('title',['trim','striptags']);
            $body['body'] = $this->request->getPost('body');
            $data['cover'] = $this->takenCover($body['body']);
            $data['description'] = strip_tags(my_mbsubstr($body['body']));
            $body['body'] = htmlspecialchars($body['body']);
            $data['tag_id'] = $this->request->getPost('tag_id','int');
            $data['catalog_id'] = $this->request->getPost('catalog_id','int');
            $data['state'] = 1;

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
    }

    private function takenCover($body){
        if(preg_match_all('/<img.*?src="(.*?)".*?>/is', $body, $matches)){
            return $matches[1][0];
        }else{
            return '';
        }
    }
}
