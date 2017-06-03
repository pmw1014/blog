<?php
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class CatalogController extends ControllerBase
{
    public function Initialize()
    {
        parent::Initialize();
    }

    public function listAction()
    {
        if($this->request->isGet()){
            $currentPage = $this->request->get('page','int');
            $id = $this->dispatcher->getParam('id','int');

            $articles = $this->modelsManager->createBuilder()
                ->columns(['a.id','a.title','a.description','a.cover','a.viewed','a.update_at','t.title as tag_name','t.color as tag_color'])
                ->from(['a' => 'Articles'])
                ->join('RefTags','t.id = a.tag_id AND t.state = 1','t')
                ->where('a.state = :state: AND a.catalog_id = :catalog_id:',["state"=>1,'catalog_id'=>$id])
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

}
