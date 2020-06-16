<?php
require_once __DIR__.'/../app/init.php';
use BL\app\blapp;
use BL\app\controller\PayBase;

blapp::getInstance();

$payDao = new PayBase();

