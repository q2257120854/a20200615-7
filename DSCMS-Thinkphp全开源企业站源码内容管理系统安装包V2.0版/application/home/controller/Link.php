<?php

namespace app\home\controller;
use think\Lang;
class Link extends BaseMall
{
    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/link.lang.php');
    }

    public function search()
    {
        return $this->fetch($this->template_dir.'search');
    }
}