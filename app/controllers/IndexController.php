<?php
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class IndexController extends ControllerBase
{
    public function Initialize(){
        parent::Initialize();
    }

    public function indexAction(){
        $currentPage = $this->request->getQuery('page','int');

        $articles = Articles::find();
        $paginator = new PaginatorModel(
            [
                "data"  => $articles,
                "limit" => 10,
                "page"  => $currentPage,
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
