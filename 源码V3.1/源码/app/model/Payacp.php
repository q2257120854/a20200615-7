<?php
namespace BL\app\model;

use BL\app\libs\Controller;

class Payacp extends Controller
{
    public function get($acpcode)
    {
        $banklist = $this->model('email,userid,userkey')->select()->from('acp')->where(array('fields' => 'code=?', 'values' => array($acpcode)))->fetchRow();
        return $banklist;
    }
}
?>