<?php
/* 引用全局定义 */
require __DIR__ . '/common_global.php';

//获取URL访问的ROOT地址 网站的相对路径
define('BASE_SITE_ROOT', str_replace('/index.php', '', \think\Request::instance()->root()));
define('PLUGINS_SITE_ROOT', BASE_SITE_ROOT . '/static/plugins');
define('ADMIN_SITE_ROOT', BASE_SITE_ROOT . '/static/admin');
define('HOME_SITE_ROOT', BASE_SITE_ROOT . '/static/home');
define('MOBILE_SITE_ROOT', BASE_SITE_ROOT . '/static/mobile');
define('LINK_SITE_ROOT', BASE_SITE_ROOT . '/uploads/home/link');

define("REWRITE_MODEL", FALSE); // 设置伪静态
if (!REWRITE_MODEL) {
    define('BASE_SITE_URL', \think\Request::instance()->domain() . \think\Request::instance()->baseFile());
} else {
    // 系统开启伪静态
    if (empty(BASE_SITE_ROOT)) {
        define('BASE_SITE_URL', \think\Request::instance()->domain());
    } else {
        define('BASE_SITE_URL', \think\Request::instance()->domain() . \think\Request::instance()->root());
    }
}

//检测是否安装 DSCMS 系统
if(file_exists("install/") && !file_exists("install/install.lock")){
    header('Location: '.BASE_SITE_ROOT.'/install/install.php');
    exit();
}

define('HOME_SITE_URL', BASE_SITE_URL . '/home');
define('ADMIN_SITE_URL', BASE_SITE_URL . '/admin');
define('MOBILE_SITE_URL', BASE_SITE_URL . '/mobile');
define('WAP_SITE_URL', str_replace('/index.php', '', BASE_SITE_URL) . '/wap');
define('UPLOAD_SITE_URL', str_replace('/index.php', '', BASE_SITE_URL) . '/uploads');
define('EXAMPLES_SITE_URL', str_replace('/index.php', '', BASE_SITE_URL) . '/examples');
define('CHAT_SITE_URL', str_replace('/index.php', '', BASE_SITE_URL) . '/static/chat');
define('SESSION_EXPIRE', 3600);


define('PUBLIC_PATH', ROOT_PATH . 'public');
define('BASE_UPLOAD_PATH', PUBLIC_PATH . '/uploads');

define('TIMESTAMP', time());
define('DIR_HOME', 'home');
define('DIR_ADMIN', 'admin');
define('DIR_PUBLIC', 'public');
define('DIR_STATIC', 'static');

define('DIR_UPLOAD', 'public/uploads');

define('ATTACH_PATH', 'home');
define('ATTACH_COMMON', ATTACH_PATH . '/common');
define('ATTACH_CASES', ATTACH_PATH . '/cases');
define('ATTACH_PRODUCT', ATTACH_PATH . '/product');
define('ATTACH_NEWS', ATTACH_PATH . '/news');
define('ATTACH_LINK', ATTACH_PATH . '/link');
define('ATTACH_ADV', ATTACH_PATH . '/adv');
define('ATTACH_MEMBER', ATTACH_PATH . '/member');

define('DS_THEME_STYLE_URL', ROOT_PATH . DIR_PUBLIC .DS. DIR_STATIC . DS .DIR_HOME. DS);

define('ALLOW_IMG_EXT', 'jpg,png,gif,bmp,jpeg');#上传图片后缀

//栏目所属模块
define('COLUMN_NEWS', 1);   //新闻模块
define('COLUMN_PRODUCT', 2);//产品模块
define('COLUMN_CASES', 3);//案例模块
define('COLUMN_JOB', 4);//招聘模块
define('COLUMN_LINK', 5);//友情链接
define('COLUMN_MEMBER', 6);//会员中心

//文章状态
define('CHECK_OK', 1);//通过
define('CHECK_FAIL', 2);//失败

//新闻
define('NEWS_RECYCLE_OK', 0);//没有删除在回收站
define('NEWS_RECYCLE_FALL', 3);//回收站

//产品
define('PRODUCT_RECYCLE_OK', 0);//没有删除在回收站
define('PRODUCT_RECYCLE_FALL', 3);//回收站

/**
 * KV缓存 读
 *
 * @param string $key 缓存名称
 * @param boolean $callback 缓存读取失败时是否使用回调 true代表使用cache.model中预定义的缓存项 默认不使用回调
 * @param callable $callback 传递非boolean值时 通过is_callable进行判断 失败抛出异常 成功则将$key作为参数进行回调
 * @return mixed
 */
function rkcache($key, $callback = false)
{
    $value = cache($key);
    if (empty($value) && $callback !== false) {
        if ($callback === true) {
            $callback = array(model('cache'), 'call');
        }

        if (!is_callable($callback)) {
            exception('Invalid rkcache callback!');
        }
        $value = call_user_func($callback, $key);
        wkcache($key, $value);
    }
    return $value;
}

/**
 * KV缓存 写
 *
 * @param string $key 缓存名称
 * @param mixed $value 缓存数据 若设为否 则下次读取该缓存时会触发回调（如果有）
 * @param int $expire 缓存时间 单位秒 null代表不过期
 * @return boolean
 */
function wkcache($key, $value, $expire = 7200)
{
    return cache($key, $value, $expire);
}

/**
 * 消息提示，主要适用于普通页面AJAX提交的情况
 *
 * @param string $message 消息内容
 * @param string $url 提示完后的URL去向
 * @param stting $alert_type 提示类型 error/succ/notice 分别为错误/成功/警示
 * @param string $extrajs 扩展JS
 * @param int $time 停留时间
 */
function showDialog($message = '', $url = '', $alert_type = 'error', $extrajs = '', $time = 2)
{
    $message = str_replace("'", "\\'", strip_tags($message));

    $paramjs = null;
    if ($url == 'reload') {
        $paramjs = 'window.location.reload()';
    } elseif ($url != '') {
        $paramjs = 'window.location.href =\'' . $url . '\'';
    }
    if ($paramjs) {
        $paramjs = 'function (){' . $paramjs . '}';
    } else {
        $paramjs = 'null';
    }
    $modes = array('error' => 'alert', 'succ' => 'succ', 'notice' => 'notice', 'js' => 'js');
    $cover = $alert_type == 'error' ? 1 : 0;
    $extra = 'parent.showDialog(\'' . $message . '\', \'' . $modes[$alert_type] . '\', null, ' . ($paramjs ? $paramjs : 'null') . ', ' . $cover . ', null, null, null, null, ' . (is_numeric($time) ? $time : 'null') . ', null);';
    $extra = '<script type="text/javascript" reload="1">' . $extra . '</script>';
    if ($extrajs != '' && substr(trim($extrajs), 0, 7) != '<script') {
        $extrajs = '<script type="text/javascript" reload="1">' . $extrajs . '</script>';
    }
    $extra .= $extrajs;
    ob_end_clean();
    @header("Expires: -1");
    @header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
    @header("Pragma: no-cache");
    @header("Content-type: text/xml; charset=utf-8");

    $string = '<?xml version="1.0" encoding="utf-8"?>' . "\r\n";
    $string .= '<root><![CDATA[' . $message . $extra . ']]></root>';
    echo $string;
    exit;
}

/**
 * KV缓存 删
 *
 * @param string $key 缓存名称
 * @return boolean
 */
function dkcache($key)
{
    return cache($key, NULL);
}

/**
 * 格式化字节大小
 * @param  number $size 字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '')
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++)
        $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 取得随机数
 *
 * @param int $length 生成随机数的长度
 * @param int $numeric 是否只产生数字随机数 1是0否
 * @return string
 */
function random($length, $numeric = 0)
{
    $seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
    $seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
    $hash = '';
    $max = strlen($seed) - 1;
    for ($i = 0; $i < $length; $i++) {
        $hash .= $seed{mt_rand(0, $max)};
    }
    return $hash;
}

/**
 * 读取缓存信息
 *
 * @param string $key 要取得缓存键
 * @param string $prefix 键值前缀
 * @param string $fields 所需要的字段
 * @return array/bool
 */
function rcache($key = null, $prefix = '', $fields = '*')
{
    if ($key === null || !config('cache_open'))
        return array();
    if (!empty($prefix)) {
        $name = $prefix . $key;
    } else {
        $name = $key;
    }
    $name .= request()->module();
    $cache_info = cache($name);
    //如果name值不存在，则默认返回 false。
    return $cache_info;
}

/**
 * 写入缓存
 *
 * @param string $key 缓存键值
 * @param array $data 缓存数据
 * @param string $prefix 键值前缀
 * @param int $period 缓存周期  单位分，0为永久缓存
 * @return bool 返回值
 */
function wcache($key = null, $data = array(), $prefix, $period = 0)
{
    if ($key === null || !config('cache_open') || !is_array($data))
        return;

    if (!empty($prefix)) {
        $name = $prefix . $key;
    } else {
        $name = $key;
    }
    $name .= request()->module();
    $cache_info = cache($name, $data, 3600);
    //如果设置成功返回true，否则返回false。
    return $cache_info;
}

/**
 * 删除缓存
 * @param string $key 缓存键值
 * @param string $prefix 键值前缀
 * @return boolean
 */
function dcache($key = null, $prefix = '')
{
    if ($key === null || !config('cache_open'))
        return true;
    if (!empty($prefix)) {
        $name = $prefix . $key;
    } else {
        $name = $key;
    }
    return cache($name, NULL);
}

/**
 * 获取文件列表(所有子目录文件)
 *
 * @param string $path 目录
 * @param array $file_list 存放所有子文件的数组
 * @param array $ignore_dir 需要忽略的目录或文件
 * @return array 数据格式的返回结果
 */
function read_file_list($path, &$file_list, $ignore_dir = array())
{
    $path = rtrim($path, '/');
    if (is_dir($path)) {
        $handle = @opendir($path);
        if ($handle) {
            while (false !== ($dir = readdir($handle))) {
                if ($dir != '.' && $dir != '..') {
                    if (!in_array($dir, $ignore_dir)) {
                        if (is_file($path . '/' . $dir)) {
                            $file_list[] = $path . '/' . $dir;
                        } elseif (is_dir($path . '/' . $dir)) {
                            read_file_list($path . '/' . $dir, $file_list, $ignore_dir);
                        }
                    }
                }
            }
            @closedir($handle);
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/**
 * 加密函数
 *
 * @param string $txt 需要加密的字符串
 * @param string $key 密钥
 * @return string 返回加密结果
 */
function ds_encrypt($txt, $key = '')
{
    if (empty($txt))
        return $txt;
    if (empty($key))
        $key = md5(MD5_KEY);
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
    $ikey = "-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
    $nh1 = rand(0, 64);
    $nh2 = rand(0, 64);
    $nh3 = rand(0, 64);
    $ch1 = $chars{$nh1};
    $ch2 = $chars{$nh2};
    $ch3 = $chars{$nh3};
    $nhnum = $nh1 + $nh2 + $nh3;
    $knum = 0;
    $i = 0;
    while (isset($key{$i}))
        $knum += ord($key{$i++});
    $mdKey = substr(md5(md5(md5($key . $ch1) . $ch2 . $ikey) . $ch3), $nhnum % 8, $knum % 8 + 16);
    $txt = base64_encode(TIMESTAMP . '_' . $txt);
    $txt = str_replace(array('+', '/', '='), array('-', '_', '.'), $txt);
    $tmp = '';
    $j = 0;
    $k = 0;
    $tlen = strlen($txt);
    $klen = strlen($mdKey);
    for ($i = 0; $i < $tlen; $i++) {
        $k = $k == $klen ? 0 : $k;
        $j = ($nhnum + strpos($chars, $txt{$i}) + ord($mdKey{$k++})) % 64;
        $tmp .= $chars{$j};
    }
    $tmplen = strlen($tmp);
    $tmp = substr_replace($tmp, $ch3, $nh2 % ++$tmplen, 0);
    $tmp = substr_replace($tmp, $ch2, $nh1 % ++$tmplen, 0);
    $tmp = substr_replace($tmp, $ch1, $knum % ++$tmplen, 0);
    return $tmp;
}

/**
 * 解密函数
 *
 * @param string $txt 需要解密的字符串
 * @param string $key 密匙
 * @return string 字符串类型的返回结果
 */
function ds_decrypt($txt, $key = '', $ttl = 0)
{
    if (empty($txt))
        return $txt;
    if (empty($key))
        $key = md5(MD5_KEY);

    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
    $ikey = "-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
    $knum = 0;
    $i = 0;
    $tlen = @strlen($txt);
    while (isset($key{$i}))
        $knum += ord($key{$i++});
    $ch1 = @$txt{$knum % $tlen};
    $nh1 = strpos($chars, $ch1);
    $txt = @substr_replace($txt, '', $knum % $tlen--, 1);
    $ch2 = @$txt{$nh1 % $tlen};
    $nh2 = @strpos($chars, $ch2);
    $txt = @substr_replace($txt, '', $nh1 % $tlen--, 1);
    $ch3 = @$txt{$nh2 % $tlen};
    $nh3 = @strpos($chars, $ch3);
    $txt = @substr_replace($txt, '', $nh2 % $tlen--, 1);
    $nhnum = $nh1 + $nh2 + $nh3;
    $mdKey = substr(md5(md5(md5($key . $ch1) . $ch2 . $ikey) . $ch3), $nhnum % 8, $knum % 8 + 16);
    $tmp = '';
    $j = 0;
    $k = 0;
    $tlen = @strlen($txt);
    $klen = @strlen($mdKey);
    for ($i = 0; $i < $tlen; $i++) {
        $k = $k == $klen ? 0 : $k;
        $j = strpos($chars, $txt{$i}) - $nhnum - ord($mdKey{$k++});
        while ($j < 0)
            $j += 64;
        $tmp .= $chars{$j};
    }
    $tmp = str_replace(array('-', '_', '.'), array('+', '/', '='), $tmp);
    $tmp = trim(base64_decode($tmp));

    if (preg_match("/\d{10}_/s", substr($tmp, 0, 11))) {
        if ($ttl > 0 && (TIMESTAMP - substr($tmp, 0, 11) > $ttl)) {
            $tmp = null;
        } else {
            $tmp = substr($tmp, 11);
        }
    }
    return $tmp;
}

/**
 * 编辑器内容
 */

function build_editor($params = array())
{
    $name = isset($params['name']) ? $params['name'] : null;
    $theme = isset($params['theme']) ? $params['theme'] : 'normal';
    $content = isset($params['content']) ? $params['content'] : null;
    //http://fex.baidu.com/ueditor/#start-toolbar
    /* 指定使用哪种主题 */
    $themes = array(
        'normal' => "[   
           'fullscreen', 'source', '|', 'undo', 'redo', '|',   
           'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',   
           'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',   
           'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',   
           'directionalityltr', 'directionalityrtl', 'indent', '|',   
           'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',   
           'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',   
           'emotion',  'map', 'gmap',  'insertcode', 'template',  '|',   
           'horizontal', 'date', 'time', 'spechars', '|',   
           'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',   
           'searchreplace', 'help', 'drafts', 'charts'
       ]", 'simple' => " ['fullscreen', 'source', 'undo', 'redo', 'bold']",
    );
    switch ($theme) {
        case 'simple':
            $theme_config = $themes['simple'];
            break;
        case 'normal':
            $theme_config = $themes['normal'];
            break;
        default:
            $theme_config = $themes['normal'];
            break;
    }
    /* 配置界面语言 */
    switch (config('default_lang')) {
        case 'zh-cn':
            $lang = PLUGINS_SITE_ROOT . '/ueditor/lang/zh-cn/zh-cn.js';
            break;
        case 'en-us':
            $lang = PLUGINS_SITE_ROOT . '/ueditor/lang/en/en.js';
            break;
        default:
            $lang = PLUGINS_SITE_ROOT . '/ueditor/lang/zh-cn/zh-cn.js';
            break;
    }
    $include_js = '<script type="text/javascript" charset="utf-8" src="' . PLUGINS_SITE_ROOT . '/ueditor/ueditor.config.js"></script> <script type="text/javascript" charset="utf-8" src="' . PLUGINS_SITE_ROOT . '/ueditor/ueditor.all.min.js""> </script><script type="text/javascript" charset="utf-8" src="' . $lang . '"></script>';
	$content = json_encode($content);
    $str = <<<EOT
$include_js
<script type="text/javascript">
var ue = UE.getEditor('{$name}',{
    toolbars:[{$theme_config}],
        });
      ue.ready(function() {
       this.setContent($content);	
})
</script>
EOT;
    return $str;
}

/**
 * 取得用户头像图片
 *
 * @param string $member_avatar
 * @return string
 */
function get_member_avatar($member_avatar = '')
{
    if (empty($member_avatar) || !file_exists(BASE_UPLOAD_PATH . '/' . ATTACH_MEMBER . '/' . $member_avatar)) {
        return UPLOAD_SITE_URL . '/' . ATTACH_COMMON . '/default_member_image.jpg';
    }
    return UPLOAD_SITE_URL . '/' . ATTACH_MEMBER . '/' . str_replace('\\', '/', $member_avatar);
}
/**
 * 获取案例图
 */
function get_cases_img($image_name = '')
{
    if (empty($image_name) || !file_exists(BASE_UPLOAD_PATH . '/' . ATTACH_CASES . '/' . $image_name)) {
        return UPLOAD_SITE_URL . '/' . ATTACH_COMMON . '/default_cases_image.jpg';
    }
    return UPLOAD_SITE_URL . '/' . ATTACH_CASES . '/' . str_replace('\\', '/', $image_name);
}
/**
 * 获取产品图
 */
function get_product_img($image_name = '')
{
    if (empty($image_name) || !file_exists(BASE_UPLOAD_PATH . '/' . ATTACH_PRODUCT . '/' . $image_name)) {
        return UPLOAD_SITE_URL . '/' . ATTACH_COMMON . '/default_product_image.jpg';
    }
    return UPLOAD_SITE_URL . '/' . ATTACH_PRODUCT . '/' . str_replace('\\', '/', $image_name);
}
/**
 * 获取新闻图
 */
function get_news_img($image_name = '')
{
    if (empty($image_name) || !file_exists(BASE_UPLOAD_PATH . '/' . ATTACH_NEWS . '/' . $image_name)) {
        return UPLOAD_SITE_URL . '/' . ATTACH_COMMON . '/default_news_image.jpg';
    }
    return UPLOAD_SITE_URL . '/' . ATTACH_NEWS . '/' . str_replace('\\', '/', $image_name);
}
/**
 * 获取友链LOGO图
 */
function get_link_img($image_name = '')
{
    if (empty($image_name) || !file_exists(BASE_UPLOAD_PATH . '/' . ATTACH_LINK . '/' . $image_name)) {
        return UPLOAD_SITE_URL . '/' . ATTACH_COMMON . '/default_type_image.jpg';
    }
    return UPLOAD_SITE_URL . '/' . ATTACH_LINK . '/' . str_replace('\\', '/', $image_name);
}
/**
 * 获取广告LOGO图
 */
function get_adv_img($image_name = '')
{
    if (empty($image_name) || !file_exists(BASE_UPLOAD_PATH . '/' . ATTACH_ADV . '/' . $image_name)) {
        return UPLOAD_SITE_URL . '/' . ATTACH_COMMON . '/default_adv_image.jpg';
    }
    return UPLOAD_SITE_URL . '/' . ATTACH_ADV . '/' . str_replace('\\', '/', $image_name);
}
/**
 * 针对批量删除进行处理  '1,2,3' 转换为数组批量删除
 * @param type $ids
 * @return boolean
 */
function ds_delete_param($ids)
{
    //转换为数组
    $ids_array = explode(',', $ids);
    //数组值转为整数型
    $ids_array = array_map("intval", $ids_array);
    if (empty($ids_array) || in_array(0, $ids_array)) {
        return FALSE;
    } else {
        return $ids_array;
    }
}

/**
 *    模板列表
 *
 * @author    Garbin
 * @param     strong $who
 * @return    array
 */
function list_template($who, $type = '')
{
    $theme_dir = APP_PATH . DIR_HOME . ($type == 'mobile' ? '/mobile' : '') .DS. $who;
    $dir = dir($theme_dir);
    $array = array();
    while (($item = $dir->read()) !== false) {
        if (in_array($item, array('.', '..')) || $item{0} == '.' || $item{0} == '$') {
            continue;
        }
        $theme_path = $theme_dir . '/' . $item;
        if (is_dir($theme_path)) {
            if (is_file($theme_path . '/theme.info.php')) {
                $array[] = $item;
            }
        }
    }
    return $array;
}

/**
 *    列表风格
 *
 * @author    Garbin
 * @param     string $who
 * @return    array
 */
function list_style($who, $template = 'mall', $type = '')
{
    $style_dir = DS_THEME_STYLE_URL . ($type == 'mobile' ? '/mobile' : '') . $who . '/styles';
    $dir = dir($style_dir);
    $array = array();
    while (($item = $dir->read()) !== false) {
        if (in_array($item, array('.', '..')) || $item{0} == '.' || $item{0} == '$') {
            continue;
        }
        $style_path = $style_dir . '/' . $item;
        if (is_dir($style_path)) {
            if (is_file($style_path . '/style.info.php')) {
                $array[] = $item;
            }
        }
    }
    return $array;
}

/**
 * 
 * @param type $code   100000表示为正确,其他为错误代码
 * @param type $message  提示消息
 * @param type $result  返回数据
 */
function ds_json_encode($code, $message, $result = '')
{
    echo json_encode(array('code' => $code, 'message' => $message, 'result' => $result));
    exit;
}

/**
 * Layer 提交成功返回函数
 * @param type $message
 */
function dsLayerOpenSuccess($msg = '',$url='') {
//    echo "<script>var index = parent.layer.getFrameIndex(window.name);parent.layer.close(index);parent.location.reload();</script>";
    $url_js = empty($url)?"parent.location.reload();":"parent.location.href='".$url."';";
            
    $str = "<script>";
    $str .= "parent.layer.alert('".$msg."',{yes:function(index, layero){".$url_js."},cancel:function(index, layero){".$url_js."}});";
    $str .= "</script>";
    echo $str;
    exit;
}

/**
 * 截取指定长度的字符
 * @param type $string  内容
 * @param type $start 开始
 * @param type $length 长度
 * @return type
 */
function ds_substing($string, $start=0,$length=80) {
    $string = strip_tags($string);
    $string = preg_replace('/\s/', '', $string);
    return mb_substr($string, $start, $length);
}


/*手机端翻页显示*/

function page_mobile($page){
    
}