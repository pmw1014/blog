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

            $articles->assign($data);
            // $articles->setTitle = $data['title'];
            // $articles->setDescription = $data['description'];
            // $articles->setState = $data['state'];
            // $articles->setTags_id = $data['tags_id'];
            // $articles->setCreate_at = $data['create_at'];
            // $articles->setUpdate_at = $data['update_at'];
            //
            $articleBody->articles = $articles;
            // $articleBody->body = $body['body'];

            // $result = $articleBody->save($body);
            if ($articleBody->save($body) === false) {
                $messages = $articleBody->getMessages();

                foreach ($messages as $message) {
                    echo "Message: ", $message->getMessage();
                    echo "Field: ", $message->getField();
                    echo "Type: ", $message->getType();
                }
            }else{
                $this->returnAjaxJson(true,'发表成功','',$this->url->get("/"));
            }
            $this->returnAjaxJson(false,'发表失败');
        }
        $this->tag->prependTitle("New Post - ");
    }
}
