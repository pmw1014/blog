<?php
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class ArticleController extends ControllerBase
{
    public function Initialize()
    {
        parent::Initialize();
    }

    public function indexAction()
    {
        $this->tag->prependTitle("Home - ");
    }

    public function detailAction()
    {

        $id = $this->dispatcher->getParam("id",'int');

        $article = Articles::findFirst([
            'state = ?1 and id = ?2',
            'bind' => [
                1 => 1,
                2 => $id
            ]
        ]);

        if(!$article){

            $this->view->disable();
            return $this->response->redirect('/show404/'.Errorcode::$code[404]['code']);
        }else{
            //TODO: 增加浏览数
            $article->viewed += 1;
            $article->save();


            $articleWithBody = $article->articleBody;

            $this->tag->prependTitle($article->title." - ");
            $this->view->article = $article;
            $this->view->body = htmlspecialchars_decode($articleWithBody->body);
        }
    }

    public function listAction()
    {
        if($this->request->isGet()){
            $currentPage = $this->request->get('page','int');

            $articles = $this->modelsManager->createBuilder()
                ->columns(['a.id','a.title','a.description','a.cover','a.viewed','a.update_at','t.title as tag_name','t.color as tag_color'])
                ->from(['a' => 'Articles'])
                ->join('RefTags','t.id = a.tag_id AND t.state = 1','t')
                ->where('a.state = :state:',["state"=>1])
                ->orderBy('a.id desc')
                ->getQuery()
                ->execute();
            $paginator = new PaginatorModel(
                [
                    "data"  => $articles,
                    "limit" => 10,
                    "page"  => $currentPage
                ]
            );

            $page = $paginator->getPaginate();
            if(!empty($page->items)){
                foreach ($page->items as &$item) {
                    $item->link = $this->url->get(
                        [
                            'for' => 'detail',
                            'id' => $item->id
                        ]
                    );
                }
            }
            $this->view->page = $page;
        }
    }

    public function descriptionAction()
    {
        if($this->request->isGet()){
            $id = $this->request->get("id",'int');

            $article = Articles::findFirst([
                'state = ?1 and id = ?2',
                'bind' => [
                    1 => 1,
                    2 => $id
                ]
            ]);

            if(!$article){

                $this->view->disable();
                return $this->response->redirect('/show404/'.Errorcode::$code[404]['code']);
            }else{
                //TODO: 增加浏览数
                $article->viewed += 1;
                $article->save();


                $articleWithBody = $article->articleBody;

                $this->tag->prependTitle($article->title." - ");
                $this->view->article = $article;
                $this->view->body = htmlspecialchars_decode($articleWithBody->body);
            }
        }
    }

}
