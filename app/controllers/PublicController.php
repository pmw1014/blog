<?php

class PublicController extends ControllerBase
{
    public function Initialize(){
        parent::Initialize();
    }

    public function show404Action(){
        $this->tag->prependTitle("404 - ");
    }

}
