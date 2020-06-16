<?php
/**
 * 织梦缓存助手
 * User: dedemao
 * 发布时间: 2019年4月18日20:42:27
 */
$ver='1.0';
session_cache_limiter('private,must-revalidate');
require_once(dirname(__FILE__)."/config.php");
helper('caches');
if(empty($dopost)) $dopost = "";

//缓存命中率 = hits/(hits+miss)
//$info = getRedisInfo();
//var_dump($info);die;
$configfile = DEDEDATA.'/config.cache.inc.php';
//更新配置函数
function ReWriteConfig()
{
    global $dsql,$configfile;
    if(!is_writeable($configfile))
    {
        echo "配置文件'{$configfile}'不支持写入，无法修改系统配置参数！";
        exit();
    }
    $fp = fopen($configfile,'w');
    flock($fp,3);
    fwrite($fp,"<"."?php\r\n");
    $dsql->SetQuery("SELECT `varname`,`type`,`value`,`groupid` FROM `#@__sysconfig` ORDER BY aid ASC ");
    $dsql->Execute();
    while($row = $dsql->GetArray())
    {
        if($row['type']=='number')
        {
            if($row['value']=='') $row['value'] = 0;
            fwrite($fp,"\${$row['varname']} = ".$row['value'].";\r\n");
        }
        else
        {
            fwrite($fp,"\${$row['varname']} = '".str_replace("'",'',$row['value'])."';\r\n");
        }
    }
    fwrite($fp,"?".">");
    fclose($fp);
}

function getRandString()
{
    $str = strtoupper(md5(uniqid(md5(microtime(true)),true)));
    return substr($str,0,8).'-'.substr($str,8,4).'-'.substr($str,12,4).'-'.substr($str,16,4).'-'.substr($str,20);
}
function setCache()
{
    global $cfg_version,$ver;
    $first_use = false;
    $use_time = date('Y-m-d');
    $txt = DEDEDATA.'/module/caches.txt';
    if(!file_exists($txt))
    {
        $id = getRandString();
        $first_use = true;
        $fp = fopen($txt,'w');
        $tData['id'] = $id;
        $tData['time'] = $use_time;
        $tData['ver'] = $ver;
        fwrite($fp,serialize($tData));
        fclose($fp);
    }else{
        $fp = fopen($txt,'r');
        $content = fread($fp, filesize($txt));
        fclose($fp);
        $content = unserialize($content);
        $id = $content['id'];
        $use_time = $content['time'];
        $tData['id'] = $id;
        $tData['time'] = date('Y-m-d');
        $tData['ver'] = $ver;
        $fp = fopen($txt,'w');
        fwrite($fp,serialize($tData));
        fclose($fp);
    }
    if($first_use || $use_time!=date('Y-m-d')){
        echo '<script>
                var _hmt = _hmt || [];
                (function() {
                    var hm = document.createElement("script");
                    hm.src = "//www.dedemao.com/api/stat.php?id='.$id.'&v='.$cfg_version.'&subject=caches";
                    var s = document.getElementsByTagName("script")[0];
                    s.parentNode.insertBefore(hm, s);
                })();
            </script>';
    }
}
function editModuleMain(){
    $path = dirname(__FILE__);
    $module_main_content = file_get_contents($path.'/module_main.php');
    if(strstr($module_main_content,'//$modules_remote')===false){
        $module_main_content = str_replace('$modules_remote =','//$modules_remote =',$module_main_content);
        $module_main_content = str_replace('$modules = array_merge','//$modules = array_merge',$module_main_content);

        $fp = fopen($path.'/module_main.php','w');
        flock($fp,3);
        fwrite($fp,$module_main_content);
        fclose($fp);
    }
}
function shutdown_function()
{
    $e = error_get_last();
    if($e['type']==1){
        $data['code'] = 1;
        if(strstr($e['message'],'not support')){
            $data['msg'] = '当前PHP环境未安装Redis扩展';
        }
        if(strstr($e['message'],'went away')){
            $data['msg'] = 'Redis服务连接失败';
        }
        echo json_encode($data);exit();
    }
}

if($dopost=="clear"){
    delAllCache();
    ShowMsg("已清除所有缓存！", "caches.php");
    exit();
}
if($dopost=="testRedis"){
    global $cache_expire;
    $data['code'] = 1;
    error_reporting(0);
    register_shutdown_function('shutdown_function');
    require_once(DEDEINC."/redis.class.php");
    if(!isset($cache_expire)) $cache_expire = 60;       //默认缓存60分钟
    $expire = $cache_expire ? $cache_expire*60 : 0;  //缓存过期时间
    $redisConfig = array(
        'host'=>$host,
        'port'=>$port,
        'password'=>$password,
        'select'=>0,
        'expire'=>$expire,
        'prefix'=>'dede_',
    );
    $redis = new RedisHelper($redisConfig);
    $a = $redis->set('test','123456');
    if($redis->get('test')=='123456'){
        $data['code'] = 0;
    }
    echo json_encode($data);exit();

}
//保存配置的改动
if($dopost=="save")
{
    $info = $_POST['info'];
    $data = $_POST['basic'];

    foreach($data as $k=>$v)
    {
        $row = $dsql->GetOne("SELECT varname FROM `#@__sysconfig` WHERE varname LIKE '$k' ");
        if(is_array($row))
        {
            //存在就更新
            $dsql->ExecuteNoneQuery("UPDATE `#@__sysconfig` SET `value`='$v' WHERE varname='$k' ");
        }else{
            $row = $dsql->GetOne("SELECT aid FROM `#@__sysconfig` ORDER BY aid DESC ");
            $aid = $row['aid'] + 1;
            $inquery = "INSERT INTO `#@__sysconfig`(`aid`,`varname`,`info`,`value`,`type`,`groupid`)
VALUES ('$aid','$k','{$info[$k]}','$v','string','8')";
            $rs = $dsql->ExecuteNoneQuery($inquery);
            if(!$rs)
            {
                ShowMsg("有非法字符！");
                exit();
            }
            if(!is_writeable($configfile))
            {
                ShowMsg("成功保存，但由于 $configfile 无法写入，因此不能更新配置文件！");
                exit();
            }
        }

    }
    ReWriteConfig();
    //在模板中增加标记
    ShowMsg("成功更改配置！", "caches.php");
    exit();
}

$dsql->SetQuery("Select * From `#@__sysconfig` where groupid = 8 order by aid asc");
$dsql->Execute();
$i = 1;
$data = array();
while($row = $dsql->GetArray()) {
    $data[$row['varname']] = $row['value'];
    $i++;
}
editModuleMain();

include DedeInclude('templets/caches.htm');
setCache();
