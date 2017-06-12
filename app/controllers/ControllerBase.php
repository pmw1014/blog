<?php

use Phalcon\Mvc\Controller;
use Phalcon\Tag;
use Phalcon\Session\Bag as SessionBag;

class ControllerBase extends Controller
{
    public $sessionUser = null;
    public function initialize()
    {
        $this->tag->setDoctype(Tag::HTML5);

        $this->tag->setTitle("BLOG");

        $this->sessionUser = new SessionBag('user');

        // 添加本地CSS资源
        $this->assets->collection("headerCss")
            ->addCss("css/semantic.min.css")
            ->addCss("css/index.css")
            ->addCss("plugin/pace/dataurl.css");

        // 添加本地JavaScript资源
        $this->assets->collection("footerJs")
            ->addJs("js/jquery-3.1.1.min.js")
            ->addJs("js/semantic.min.js")
            ->addJs("plugin/pace/pace.min.js");


        // 添加本地CSS资源
        $this->assets->collection("loginCss")
            ->addCss("/css/login/reset.css")
            ->addCss("/css/login/site.css")
            ->addCss("/css/login/container.css")
            ->addCss("/css/login/grid.css")
            ->addCss("/css/login/header.css")
            ->addCss("/css/login/image.css")
            ->addCss("/css/login/menu.css")
            ->addCss("/css/login/divider.css")
            ->addCss("/css/login/segment.css")
            ->addCss("/css/login/form.css")
            ->addCss("/css/login/input.css")
            ->addCss("/css/login/button.css")
            ->addCss("/css/login/list.css")
            ->addCss("/css/login/message.css")
            ->addCss("/css/login/icon.css")
            ->addCss("plugin/pace/dataurl.css");

        // 添加本地JavaScript资源
        $this->assets->collection("loginJs")
            ->addJs("js/jquery-3.1.1.min.js")
            ->addJs("js/jquery.serialize-object.min.js")
            ->addJs("js/semantic.min.js")
            ->addJs("js/login/form.js")
            ->addJs("js/login/transition.js")
            ->addJs("plugin/pace/pace.min.js");

        $this->view->catalogs = $this->getCatalogs();
    }


    public function getCatalogs(){
        $catalogs = $this->modelsManager->createBuilder()
            ->columns(['id','title'])
            ->from('Catalogs')
            ->where('state = :state: AND parent_id = :parent_id:',["state"=>1,'parent_id'=>0])
            ->orderBy('id desc')
            ->getQuery()
            ->execute();
        $catalogs_arr = $catalogs->toArray();
        $subclass_name = 'subclass';
        if(array_filter($catalogs_arr)){
            $c_id = $temp_arr = [];
            foreach ($catalogs_arr as $catalog) {
                $c_id[] = $catalog['id'];
                $temp_arr[$catalog['id']] = $catalog;
                $temp_arr[$catalog['id']][$subclass_name] = [];
            }
            $catalogs_arr = $temp_arr;
            unset($temp_arr);
            if(array_filter($c_id)){
                $subclass = $this->modelsManager->createBuilder()
                    ->columns(['id','title','parent_id'])
                    ->from('Catalogs')
                    ->where('state = :state:',["state"=>1])
                    ->inWhere('parent_id',$c_id)
                    ->orderBy('id desc')
                    ->getQuery()
                    ->execute();
                $subclass_arr = $subclass->toArray();
                if(array_filter($subclass_arr)){
                    foreach ($subclass_arr as &$sc) {
                        $catalogs_arr[$sc['parent_id']][$subclass_name][$sc['id']] = $sc;
                        $catalogs_arr[$sc['parent_id']][$subclass_name][$sc['id']]['url_link'] = $this->url->get(
                            [
                                'for' => 'catalog',
                                'id' => $sc['id']
                            ]
                        );
                    }
                }
            }
        }
        return $catalogs_arr;
    }

    /**
     * 返回json格式数据
     * @param  boolean $state [状态]
     * @param  string  $msg   [消息]
     * @param  string  $data  [数据]
     * @param  string  $link  [连接]
     * @return [json]         [打印json格式数据]
     */
    public function returnAjaxJson($state = false, $msg = '', $data = '', $link = ''){
        $res = [
            'state' => isset($state) ? (bool)$state : false,
            'msg' => isset($msg) ? (string)$msg : '',
            'data' => isset($data) ? (array)$data : [],
        ];
        if(!empty($link)){
            $res['link'] = $link;
        }
        returnAjaxJson($res);
    }
}
