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
}
