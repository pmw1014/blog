<?php
use App\Library\Utils\Errorcode;

class PostController extends ControllerBase
{
    private static $ActiveResource = 'Post';
    private $articles = '';
    private $articleBody = '';

    public function Initialize(){
        $this->articles = new Articles();
        $this->articleBody = new ArticleBody();
        parent::Initialize();
    }


    public function editAction(){

        // 验证权限
        if (!$this->checkAccess($this->access,self::$ActiveResource,'edit')) {
            $this->view->disable();
            return $this->response->redirect('/ajaxshow404/'.Errorcode::$codes[401]['code']);
        }

        if($this->request->isGet()){
            $id = $this->dispatcher->getParam("id",'int');

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

            $article = Articles::findFirst([
                'state = ?1 and id = ?2',
                'bind' => [
                    1 => 1,
                    2 => $id
                ]
            ]);
            $articleWithBody = $article->articleBody;
            $this->tag->prependTitle('Edit '.$article->title." - ");

            if (isset($this->sessionUser->id) && $this->sessionUser->id > 0 && $article->user_id == $this->sessionUser->id) {
                $this->view->edit = 1;
            }else{
                $this->view->edit = 0;
            }

            $this->view->article = $article;
            $this->view->tag = ['id'=>$article->RefTags->id];
            $this->view->catalog = ['id'=>$article->Catalogs->id];
            $this->view->body = htmlspecialchars_decode($articleWithBody->body);
            $this->view->action_link = $this->url->get(
                [
                    "for" => "save"
                ]
            );
            $this->view->pick("post/new");
        }else if($this->request->isPost()){

            $id = $this->request->getPost('id',['int']);
            $body = $this->request->getPost('body');
            $article = Articles::findFirst($id);

            $article->title = $this->request->getPost('title',['trim','striptags']);
            $article->cover = $this->takenCover($body);
            $article->description = strip_tags(my_mbsubstr($body));
            $article->tag_id = $this->request->getPost('tag_id','int');
            $article->catalog_id = $this->request->getPost('catalog_id','int');

            $articleBody = $article->getArticleBody();
            $articleBody->body = htmlspecialchars($body);

            if ($articleBody->update() === false) {
                $messages = $articles->getMessages();
                $error = '';
                foreach ($messages as $message) {
                    $error .= $message;
                }
                $this->returnAjaxJson(false,'保存失败：'.$error);
            }else{
                $article->update();
                $this->returnAjaxJson(true,'保存成功','',$this->url->get("/"));
            }
        }

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

            $this->view->action_link = $this->url->get(
                [
                    'for' => 'add'
                ]
            );

        }else if($this->request->isPost()){
            $articles = new Articles();
            $articleBody = new ArticleBody();
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
