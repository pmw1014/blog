<?php

class IndexController extends ControllerBase
{
    public function Initialize(){
        parent::Initialize();
    }

    public function indexAction(){
        echo '<pre>';var_dump(Articles::find()->toArray());exit;
        $this->tag->prependTitle("Home - ");
    }

    public function show404Action(){
        $this->tag->prependTitle("404 - ");
    }

}
