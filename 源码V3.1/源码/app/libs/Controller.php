<?php
namespace BL\app\libs;

use BL\app\blapp;
use BL\app\libs\Router;
use BL\app\libs\Req;
use BL\app\libs\Res;
use BL\app\libs\Page;
use BL\app\libs\Session;
use BL\app\controller\chkcode;
use BL\app\libs\Model;
use BL\app\Config;
use BL\app\model\Verifyuser;

class Controller
{
    public $data;
    public $tpl = 'view/default/';
    function __construct()
    {
        $this->router = new Router();
        $this->req = new Req();
        $this->res = new Res();
        $this->page = new Page();
        $this->session = new Session();
        $this->chkcode = new chkcode();
        $this->config = $this->model()->select()->from('config')->fetchRow();
        $this->links = $this->model()->select()->from('links')->where(array('fields' => 'is_state=?', 'values' => array('1')))->fetchAll();

		$this->action = $this->router->put();
        $this->setConfig = new Config();
        $this->verifyUser = new Verifyuser();
        $this->urlbase =  strcasecmp($_SERVER['HTTPS'],"ON")==0?"https://":"http://";
    }
    public function model()
    {
        return new Model();
    }
    public function put($file, $data = array())
    {
        if ($data) {
            extract($data);
        }
        if (!file_exists($this->tpl . $file)) {
            $file = 'blapp.php';
        }
        require_once $this->tpl . $file;
        $content = ob_get_contents();
        ob_get_clean();
        echo $content;
        if (ob_get_level()) {
            ob_end_flush();
        }
    }
    /**获取所有数组
     * @return array
     */
    public function getReqdata($mod)
    {
        $data = array();
        if (isset($mod)) {
            foreach ($mod as $key => $val) {
                $data[$key] = $this->req->request($key);
            }
        }
        return $data;
    }
}
?>