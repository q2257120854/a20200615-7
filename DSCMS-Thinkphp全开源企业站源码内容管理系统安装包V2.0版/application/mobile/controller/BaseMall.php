<?php

namespace app\mobile\controller;

class BaseMall extends BaseHome
{
    public function _initialize()
    {
        parent::_initialize();
        $this->template_dir = $this->template_name.'/mall/'.strtolower(request()->controller()).'/';
    }
}