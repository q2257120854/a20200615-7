<?php
namespace BL\app\model;

use BL\app\libs\Model;
use BL\app\libs\Session;
use BL\app\libs\Req;
use BL\app\libs\Res;

class Verifyuser
{
    function __construct()
    {
        $this->model = new Model();
        $this->session = new Session();
        $this->req = new Req();
        $this->res = new Res();
    }
   
}