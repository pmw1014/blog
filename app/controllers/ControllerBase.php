<?php

use Phalcon\Mvc\Controller;
use Phalcon\Tag;

class ControllerBase extends Controller
{
    public function initialize()
    {
        $this->tag->setDoctype(Tag::HTML5);

        $this->tag->setTitle("BLOG");

        // 添加本地CSS资源
        $headerCollection = $this->assets->collection("headerCss")
            ->setPrefix('/')
            ->addCss("css/semantic.min.css");

        // 添加本地JavaScript资源
        $footerConllection = $this->assets->collection("footerJs")
            ->setPrefix('/')
            ->addJs("js/jquery-3.1.1.min.js")
            ->addJs("js/semantic.min.js");
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
