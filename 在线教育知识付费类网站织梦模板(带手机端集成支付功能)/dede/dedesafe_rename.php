<?php
header("Content-type:text/html; Charset=utf-8");
define('DEDEPATH', str_replace("\\", '/', dirname(__FILE__) ) );

if($_GET['name']=='data'){
    checkWrite();

    $newname = 'data_'.uniqid();
    $result = rename('../data','../'.$newname);
    if($result){
        $content = readFileContent(DEDEPATH.'/../include/common.inc.php');
        $content = str_replace("DEDEROOT.'/data'","DEDEROOT.'/{$newname}'",$content);
        writeFileContent(DEDEPATH.'/../include/common.inc.php',$content);
        $content = readFileContent(DEDEPATH.'/../index.php');
        if($content){
            $content = str_replace("/data/","/{$newname}/",$content);
            writeFileContent(DEDEPATH.'/../index.php',$content);
        }
        $content = readFileContent(DEDEPATH.'/../m/index.php');
        if($content) {
            $content = str_replace("/data/","/{$newname}/",$content);
            writeFileContent(DEDEPATH.'/../m/index.php',$content);
        }
        $content = readFileContent(DEDEPATH.'/../include/arc.rssview.class.php');
        if($content) {
            $content = str_replace("/data/","/{$newname}/",$content);
            writeFileContent(DEDEPATH.'/../include/arc.rssview.class.php',$content);
        }
        $content = readFileContent(DEDEPATH.'/makehtml_js_action.php');
        if($content) {
            $content = str_replace("/data/","/{$newname}/",$content);
            writeFileContent(DEDEPATH.'/makehtml_js_action.php',$content);
        }
        require_once(DEDEPATH."/../include/common.inc.php");
        editTplCache($newname);
        echo '修改data名成功！';exit();
    }
    echo '修改data名失败！';
}else{
    if(!$_GET['newname']){
        echo '未指定新的名称！';exit();
    }
    $newname = $_GET['newname'];
    $result = rename('../dede','../'.$newname);
    if($result){
        echo '<h2>修改dede名成功！请牢记新后台地址：<a href="http://'.$_SERVER['HTTP_HOST'].'/'.$newname.'">http://'.$_SERVER['HTTP_HOST'].'/'.$newname.'</a></h2>';exit();
    }
    echo '修改dede名失败！';
}


function editTplCache($newname)
{
    global $dsql;
    $dsql->ExecuteNoneQuery("update `#@__sysconfig` set `value` = '/{$newname}/tplcache' where varname = 'cfg_tplcache_dir'");
    ReWriteConfig();
}
function readFileContent($filePath)
{
    $txt = $filePath;
    if(!file_exists($txt))
    {
        $fp = fopen($txt,'w');
    }else {
        $fp = fopen($txt, 'r');
    }
    $content = fread($fp, filesize($txt));
    fclose($fp);
    return $content;
}
function writeFileContent($filePath,$content)
{
    if(!is_writeable($filePath))
    {
        echo "文件{$filePath}不支持写入，无法修改！";
        exit();
    }
    $txt = $filePath;
    $fp = fopen($txt,'w');
    fwrite($fp,$content);
    fclose($fp);
    return true;
}
function checkWrite()
{
    if(!is_writeable(DEDEPATH.'/../include/common.inc.php'))
    {
        echo "/include/common.inc.php'不支持写入，无法重命名！";
        exit();
    }
}
function ReWriteConfig()
{
    require_once(DEDEPATH."/../include/common.inc.php");
    global $dsql;
    $configfile = DEDEDATA.'/config.cache.inc.php';
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
