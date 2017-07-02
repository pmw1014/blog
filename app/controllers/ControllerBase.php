<?php

use Phalcon\Mvc\Controller;
use Phalcon\Tag;
use Phalcon\Session\Bag as SessionBag;
use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Resource;

class ControllerBase extends Controller
{
    private $acl = '';

    public $sessionUser = null;
    public $access = null;
    public function initialize()
    {
        $this->tag->setDoctype(Tag::HTML5);

        $this->tag->setTitle("BLOG");

        $this->sessionUser = new SessionBag('user');
        $this->access = isset($this->sessionUser->access) ? $this->sessionUser->access : 'Guests';

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
        $this->view->menu = $this->getMenu();
        $this->_AclRule();
    }


    /**
     * 加载用户组权限
     * @return [type] [description]
     */
    private function _AclRule()
    {
        $this->acl = new AclList();

        // 设置默认访问级别为拒绝
        $this->acl->setDefaultAction(
            Acl::DENY
        );

        // 创建角色
        $roleAdmins = new Role("Admins");
        $roleGuests = new Role("Guests");

        // 添加 "Guests" 角色到ACL
        $this->acl->addRole($roleGuests);
        // 添加 "Admins" 角色到ACL
        $this->acl->addRole($roleAdmins,$roleGuests);


        // 定义 "Article" 资源
        $Article = new Resource("Article");
        // 定义 "Post" 资源
        $Post = new Resource("Post");

        $this->acl->addResource(
            $Article,
            [
                'watch',
                'create',
                'edit',
            ]
        );
        $this->acl->addResource(
            $Post,
            [
                'watch',
                'create',
                'edit',
            ]
        );

        // 设置角色对资源的访问级别
        $this->acl->allow($roleGuests, $Article, ['watch']);
        $this->acl->allow($roleAdmins, $Article, ['watch','create','edit']);
        $this->acl->allow($roleGuests, $Post, ['watch']);
        $this->acl->allow($roleAdmins, $Post, ['watch','create','edit']);
    }

    /**
     * [判断用户组权限]
     * @param  string $activeRole   [角色]
     * @param  string $Resource     [资源]
     * @param  string $activeAccess [权限]
     * @return [bool]               [description]
     */
    public function checkAccess($activeRole = 'Guests', $Resource, $activeAccess)
    {
        if (empty((string)$activeRole) || empty((string)$Resource) || empty((string)$activeAccess)) {
            return false;
        }
        if ($this->acl->isAllowed(new Role($activeRole), new Resource($Resource), $activeAccess)) {
            return true;
        }
        return false;
    }

    public function getMenu()
    {
        $menu = [
            [
                'title' => '首页',
                'path'  => $this->url->get([
                    'for' => 'list'
                ]),
                'icon'  => 'home'
            ]
        ];
        if (isset($this->sessionUser->id)) {
            $menu[] = [
                'title' => '纸笔',
                'path'  => $this->url->get([
                    'for' => 'add'
                ]),
                'icon'  => 'add to calendar'
            ];
        }
        return $menu;
    }


    public function getCatalogs(){
        $where_str = 'state = :state: AND parent_id = :parent_id:';
        $where_fields = ['state'=>1,'parent_id'=>0];
        if (isset($this->sessionUser->id)) {
            $where_str .= ' AND user_id = :user_id:';
            $where_fields['user_id'] = $this->sessionUser->id;
        }
        $catalogs = $this->modelsManager->createBuilder()
            ->columns(['id','title'])
            ->from('Catalogs')
            ->where($where_str,$where_fields)
            ->orderBy('id desc')
            ->getQuery()
            ->execute();
        $catalogs_arr = $catalogs->toArray();
        unset($where_str,$where_fields);
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
                $where_str = 'state = :state:';
                $where_fields = ['state'=>1];
                if (isset($this->sessionUser->id)) {
                    $where_str .= ' AND user_id = :user_id:';
                    $where_fields['user_id'] = $this->sessionUser->id;
                }
                $subclass = $this->modelsManager->createBuilder()
                    ->columns(['id','title','parent_id'])
                    ->from('Catalogs')
                    ->where($where_str,$where_fields)
                    ->inWhere('parent_id',$c_id)
                    ->orderBy('id desc')
                    ->getQuery()
                    ->execute();
                $subclass_arr = $subclass->toArray();
                unset($where_str,$where_fields);
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
