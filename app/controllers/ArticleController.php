<?php
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class ArticleController extends ControllerBase
{
    public function Initialize(){
        parent::Initialize();
    }

    public function indexAction(){
        $currentPage = $this->request->getQuery('page','int');

        $map['columns'] = 'title,description,cover,viewed,update_at';
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

        $this->tag->prependTitle("Home - ");

        $this->view->page = $page;
    }

    public function show404Action(){
        $this->tag->prependTitle("404 - ");
    }

}
