<?php

namespace app\admin\controller;

use think\Lang;
use think\Cache;

class Index extends AdminControl
{

    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/index.lang.php');
    }

    public function index()
    {
        $this->assign('admin_info', $this->getAdminInfo());
        return $this->fetch();
    }

    /**
     * 修改密码
     */
    public function modifypw()
    {
        if (request()->isPost()) {
            $new_pw = trim(input('post.new_pw'));
            $new_pw2 = trim(input('post.new_pw2'));
            $old_pw = trim(input('post.old_pw'));
            if ($new_pw !== $new_pw2) {
                $this->error(lang('index_modifypw_repeat_error'));
            }
            $admininfo = $this->getAdminInfo();
            //查询管理员信息
            $admin_model = model('admin');
            $admininfo = $admin_model->getOneAdmin(array('admin_id' => $admininfo['admin_id']));
            if (!is_array($admininfo) || count($admininfo) <= 0) {
                $this->error(lang('index_modifypw_admin_error'));
            }
            //旧密码是否正确
            if ($admininfo['admin_password'] != md5($old_pw)) {
                $this->error(lang('index_modifypw_oldpw_error'));
            }
            $new_pw = md5($new_pw);
            $result = $admin_model->editAdmin(array('admin_id' => $admininfo['admin_id']), array('admin_password' => $new_pw));
            if ($result) {
                session(null);
                dsLayerOpenSuccess(lang('index_modifypw_succ'));
            } else {
                $this->error(lang('index_modifypw_fail'));
            }
        } else {
            $this->setAdminCurItem('modifypw');
            return $this->fetch();
        }
    }

    /**
     * 首页
     * @return mixed
     */
    public function welcome()
    {
        $setup_date = config('setup_date');
        $statistics['os'] = PHP_OS;
        $statistics['web_server'] = $_SERVER['SERVER_SOFTWARE'];
        $statistics['php_version'] = PHP_VERSION;
        $statistics['sql_version'] = $this->_mysql_version();
        $statistics['setup_date'] = substr($setup_date, 0, 10);

        $statistics['domain'] = $_SERVER['HTTP_HOST'];
        $statistics['ip'] = GetHostByName($_SERVER['SERVER_NAME']);
        $statistics['zlib'] = function_exists('gzclose') ? 'YES' : 'NO'; //zlib
        $statistics['safe_mode'] = (boolean)ini_get('safe_mode') ? 'YES' : 'NO'; //safe_mode = Off
        $statistics['timezone'] = function_exists("date_default_timezone_get") ? date_default_timezone_get() : "no_timezone";
        $statistics['curl'] = function_exists('curl_init') ? 'YES' : 'NO';
        $statistics['fileupload'] = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'unknown';
        $statistics['max_ex_time'] = @ini_get("max_execution_time") . 's'; //脚本最大执行时间
        $statistics['set_time_limit'] = function_exists("set_time_limit") ? true : false;
        $statistics['memory_limit'] = ini_get('memory_limit');
        $statistics['version'] = file_get_contents(APP_PATH . 'version.php');
        if (function_exists("gd_info")) {
            $gd = gd_info();
            $statistics['gdinfo'] = $gd['GD Version'];
        } else {
            $statistics['gdinfo'] = lang('Unknown');
        }

        $this->assign('statistics', $statistics);
        return $this->fetch('welcome');
    }

    private function _mysql_version()
    {
        $version = db()->query("select version() as ver");
        return $version[0]['ver'];
    }

    /**
     * 修改当前语言
     */
    public function setLanguageCookie()
    {
        $language = input('param.language');
        if ($language == config('default_lang')) {
            ds_json_encode(10001, lang('ds_language_repetition'));
        }
        setcookie("ds_admin_lang", $language, 0, '/');
        ds_json_encode(10000, lang('ds_language_switching'));
    }

    /**
     * 删除缓存
     */
    function clear()
    {
        $this->delCacheFile('temp');
        $this->delCacheFile('cache');
        Cache::clear();
        ds_json_encode(10000, lang('eliminate_succ'));
        exit();
    }

    /**
     * 删除缓存目录下的文件或子目录文件
     * @author csdeshang
     * @param string $dir 目录名或文件名
     * @return boolean
     */
    function delCacheFile($dir)
    {
        //防止删除cache以外的文件
        if (strpos($dir, '..') !== false)
            return false;
        $path = RUNTIME_PATH . '/' . $dir;
        if (is_dir($path)) {
            $file_list = array();
            read_file_list($path, $file_list);
            if (!empty($file_list)) {
                foreach ($file_list as $v) {
                    if (basename($v) != 'index.html')
                        @unlink($v);
                }
            }
        } else {
            if (basename($path) != 'index.html')
                @unlink($path);
        }
        return true;
    }


}
