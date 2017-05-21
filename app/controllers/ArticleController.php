<?php
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class ArticleController extends ControllerBase
{
    public function Initialize(){
        parent::Initialize();
    }

    public function indexAction(){
        $currentPage = $this->request->getQuery('page','int');

        $map['columns'] = 'id,title,description,cover,viewed,update_at';
        $map['conditions'] = 'state = ?1';
        $map['bind'] = [1=>1];
        $articles = Articles::find($map);
        $paginator = new PaginatorModel(
            [
                "data"  => $articles,
                "limit" => 10,
                "page"  => $currentPage,
                'order'  => 'id desc'
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

        $this->tag->prependTitle("Home - ");

        $this->view->page = $page;
    }

    public function detailAction(){

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

}
