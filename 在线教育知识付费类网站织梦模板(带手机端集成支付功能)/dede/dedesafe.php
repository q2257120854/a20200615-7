<?php
/**
 * 织梦安全卫士
 * Created by PhpStorm.
 * User: dedemao
 * Date: 2017年12月10日
 * Time: 16:20:45
 */
$ver='1.4';
session_cache_limiter('private,must-revalidate');
require_once(dirname(__FILE__)."/config.php");
if(empty($dopost)) $dopost = "";
$configfile = DEDEDATA.'/config.cache.inc.php';
if(isset($action) && $action=='setrank' && isset($rank)){
    $tData = getConfig();
    $tData['rank'] = $rank;
    $tData['time'] = date('Y-m-d');
    $txt = DEDEDATA.'/module/dedesafe.txt';
    $fp = fopen($txt,'w');
    fwrite($fp,serialize($tData));
    fclose($fp);
    exit();
}
if(isset($action) && $action=='update'){
    //检查更新
}
if(isset($action) && $action=='editdata'){
    header("Location:dedesafe_rename.php?name=data");
}
if(isset($action) && $action=='closePermission'){
    if(!$folder) die('未指定目录');
    if(isRewriteMod()){
        //支持.htaccess
        $config = getConfig();
        $result = curlGet("https://api.dedemao.com/Dedesafe/getContent/webid/".$config['id']);
        $result = json_decode($result,true);
        if($result['code']==0){
            ShowMsg("正在跳转至购买页面",$result['data']);
            exit();
        }else{
            $content = $result['data'];
            file_put_contents($folder.'/.htaccess',$content) or die('没有写入权限，无法完成');
            ShowMsg("已关闭{$folder}目录的可执行权限！","-1");
            exit();
        }
    }else{
        //不支持
        ShowMsg("apache未开启mod_rewrite模块！","-1");
        exit();
    }
}
if(isset($action) && $action=='editdede'){
    if($newname){
        header("Location:dedesafe_rename.php?name=dede&newname=".$newname);
    }else{
        echo "<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
<title>文件夹改名</title>
<link rel=\"stylesheet\" type=\"text/css\" href=\"/plus/img/base.css\">
</head>
<body background='/plus/img/allbg.gif' leftmargin=\"8\" topmargin='8'>
<table width=\"98%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#DFF9AA\">  
  <tr> 
    <td width=\"100%\" height=\"80\" style=\"padding-top:5px\" bgcolor='#ffffff'>
<form name='myform' method='POST' action=''>

<table width='100%'  border='0' cellpadding='3' cellspacing='1' bgcolor='#DADADA'>
<tr bgcolor='#DADADA'>
<td colspan='2' background='/plus/img/wbg.gif' height='26'><font color='#666600'><b>更改文件名，当前路径：</b></font></td>
</tr>
<tr bgcolor='#FFFFFF'>
<td width='25%'>旧名称：</td>
<td width='75%'><input name='oldfilename' type='input' class='alltxt' id='oldfilename' size='40' value='dede'></td>
</tr>
<tr bgcolor='#FFFFFF'>
<td width='25%'>新名称：</td>
<td width='75%'><input name='newname' type='input' class='alltxt' size='40' id='newname'></td>
</tr>
<tr>
<td colspan='2' bgcolor='#F9FCEF'>
<table width='270' border='0' cellpadding='0' cellspacing='0'>
<tr align='center' height='28'>
<td width='90'><input name='imageField1' type='image' class='np' src='/plus/img/button_ok.gif' width='60' height='22' border='0' /></td>
<td width='90'><a href='#'><img class='np' src='/plus/img/button_reset.gif' width='60' height='22' border='0' onClick='this.form.reset();return false;' /></a></td>
<td><a href='#'><img src='/plus/img/button_back.gif' width='60' height='22' border='0' onClick='history.go(-1);' /></a></td>
</tr>
</table>
</td>
</tr></table></form>
    </td>
  </tr>
</table>
<p align=\"center\">
<br>
<br>
</p>
</body>
</html>";exit();
    }

}
if(isset($action) && $action=='deldir'){
    if(!$dir){
        ShowMsg("没有指定删除目录！","-1");
        exit();
    }
    $indir = $cfg_basedir."/$dir";
    if(!is_dir($indir)){
        ShowMsg("不存在该目录！","-1");
        exit();
    }
    RmDirFiles($indir);
    ShowMsg("删除成功！","-1");
    exit();
}
function isRewriteMod()
{
	return true;
    if (function_exists('apache_get_modules'))
    {
        $aMods = apache_get_modules();
        $bIsRewrite = in_array('mod_rewrite', $aMods);
    }
    else
    {
        $bIsRewrite = (strtolower(getenv('HTTP_MOD_REWRITE')) == 'on');
    }
    return $bIsRewrite;
}
function setCache()
{
    global $cfg_version,$ver;
    $first_use = false;
    $use_time = date('Y-m-d');
    $txt = DEDEDATA.'/module/dedesafe.txt';
    if(!file_exists($txt))
    {
        $first_use = true;
        $id = createCache();
    }else{
        $fp = fopen($txt,'r');
        $content = fread($fp, filesize($txt));
        fclose($fp);
        $content = unserialize($content);
        $id = $content['id'];
        $use_time = $content['time'];
        $tData = $content;
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
                    hm.src = "//www.dedemao.com/api/stat.php?id='.$id.'&v='.$cfg_version.'-'.$ver.'&subject=dedesafe";
                    var s = document.getElementsByTagName("script")[0];
                    s.parentNode.insertBefore(hm, s);
                })();
            </script>';
    }
}
function createCache()
{
    global $ver;
    $use_time = date('Y-m-d');
    $txt = DEDEDATA.'/module/dedesafe.txt';
    $id = getRandString();
    $fp = fopen($txt,'w');
    $tData['id'] = $id;
    $tData['time'] = $use_time;
    $tData['ver'] = $ver;
    fwrite($fp,serialize($tData));
    fclose($fp);
    return $id;
}
function getConfig()
{
    $txt = DEDEDATA.'/module/dedesafe.txt';
    $content = array();
    if(file_exists($txt))
    {
        $fp = fopen($txt,'r');
        $content = fread($fp, filesize($txt));
        fclose($fp);
        $content = unserialize($content);
    }
    return $content;
}
function getRandString()
{
    $str = strtoupper(md5(uniqid(md5(microtime(true)),true)));
    return substr($str,0,8).'-'.substr($str,8,4).'-'.substr($str,12,4).'-'.substr($str,16,4).'-'.substr($str,20);
}

function getLastRank()
{
    $txt = DEDEDATA.'/module/dedesafe.txt';
    if(!file_exists($txt))
    {
        $tData['rank'] = '未知';
        $tData['time'] = '';
    }else{
        $fp = fopen($txt,'r');
        $content = fread($fp, filesize($txt));
        fclose($fp);
        $content = unserialize($content);
        $tData['rank'] = str_replace("\\","",$content['rank']);
        $tData['time'] = $content['time'];
    }
    return $tData;
}
/**
 * 删除目录
 *
 * @param unknown_type $indir
 */
function RmDirFiles($indir)
{
    if(!is_dir($indir))
    {
        return ;
    }
    $dh = dir($indir);
    while($filename = $dh->read())
    {
        if($filename == "." || $filename == "..")
        {
            continue;
        }
        else if(is_file("$indir/$filename"))
        {
            @unlink("$indir/$filename");
        }
        else
        {
            RmDirFiles("$indir/$filename");
        }
    }
    $dh->close();
    @rmdir($indir);
}
function curlGet($url = '', $options = array())
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    if (!empty($options)) {
        curl_setopt_array($ch, $options);
    }
    //https请求 不验证证书和host
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $data = curl_exec($ch);
    if($data === false)
    {
        echo 'Curl error: ' . curl_error($ch);exit();
    }
    curl_close($ch);
    return $data;
}
function curlPost($url = '', $postData = '', $options = array())
{
    if (is_array($postData)) {
        $postData = http_build_query($postData);
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置cURL允许执行的最长秒数
    if (!empty($options)) {
        curl_setopt_array($ch, $options);
    }
    //https请求 不验证证书和host
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
$lastRank = getLastRank();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>织梦安全助手-安全监测</title>
    <link href="https://cdn.dedemao.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.dedemao.com/jquery/2.1.0/jquery.min.js"></script>
    <script src="https://cdn.dedemao.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <h2>
            织梦安全助手V<?php echo $ver?>
        </h2>
        <h3>
            安全测评
        </h3>
        <div class="progress">
            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;min-width: 2em;">
                <span>0%</span>
            </div>
        </div>
        <h3 id="state" style="display: none">正在检查中...</h3>
        <h4 id="result" style="display: none">本次发现：致命<b class="text-danger">0</b>处, 警告<b class="text-warning">0</b>处, 建议<b class="text-info">0</b>处</h4>
        <h2 id="lastRank">安全等级：<?php echo $lastRank['rank']?> <?php echo $lastRank['time'] ? '<small>（上一次检测时间：'.$lastRank['time'].'）</small>' : ''?></h2>
        <h2 style="display: none" id="curRank">安全等级：<span id="grade"><?php echo $lastRank['rank']?></span><small></small></h2>
        <button type="button" id="check" class="btn btn-primary btn-lg active">开始检测</button>
    </div>
    <div class="row" id="tips" style="margin-top: 30px;">
    </div>
</div>
<br>
<h5 class="text-center">Powered by <a href="https://www.yunziyuan.com.cn/"><span class="label label-primary">织梦58</span></a></h5>
<br>
<script>
    var t;
    var fatal_count=0;
    var warn_count=0;
    var suggest_count=0;
    $(function () {
        $("#check").click(function () {
            $("#state").show();
            var step = 1;
            t = window.setTimeout("gotoStep("+step+",100)",1000);
            $(this).hide();
            $("#lastRank").hide();
        });
    });
    function gotoStep(step)
    {
        var url = '/plus/dedesafe.php';
        $.getJSON(url,{step:step},function (data) {
            var grade = data.grade;
            var step = data.step;
            var msg = data.msg;
            var html ='';
            var fatal = msg.fatal ? msg.fatal : new Array();
            var warn = msg.warn ? msg.warn : new Array();
            var suggest = msg.suggest ? msg.suggest : new Array();
            for (var i=0;i<fatal.length;i++)
            {
                html+='<div class="alert alert-danger alert-dismissible" role="alert">\n' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n' +
                    '<strong>致命!</strong> '+fatal[i]+'\n' +
                    '</div>';
                fatal_count++;
            }
            for (var i=0;i<warn.length;i++)
            {
                html+='<div class="alert alert-warning alert-dismissible" role="alert">\n' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n' +
                    '<strong>警告!</strong> '+warn[i]+'\n' +
                    '</div>';
                warn_count++;
            }
            for (var i=0;i<suggest.length;i++)
            {
                html+='<div class="alert alert-info alert-dismissible" role="alert">\n' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n' +
                    '<strong>建议!</strong> '+suggest[i]+'\n' +
                    '</div>';
                suggest_count++;
            }
            $("#tips").append(html);
            if(data.is_end){
                window.clearTimeout(t);
                $("#grade").html(getRank());
                $("#curRank").show();
                $("#result").show();
                $("#result").html('本次发现：致命<b class="text-danger">'+fatal_count+'</b>处, 警告<b class="text-warning">'+warn_count+'</b>处, 建议<b class="text-info">'+suggest_count+'</b>处');
                $("#state").html('<span class="text-success"><i class="glyphicon glyphicon-ok"></i> 检测完成</span>');
                $(".progress-bar").css('width','100%');
                $(".progress-bar span").text('100%');
            }else{
                $("#state").html('<i class="glyphicon glyphicon-search"></i> '+data.state);
                $(".progress-bar").css('width',''+(parseInt(step)*10)+'%');
                $(".progress-bar span").text((parseInt(step)*10)+'%');
                t = window.setTimeout("gotoStep("+(parseInt(step)+1)+")",1000);
            }
        });
    }
    
    function getRank() {
        var rankTip = '';
        var rank = '<b class="text-danger">S</b>';
        if(fatal_count==0 && warn_count==0){
            rankTip='<b class="text-success">（大吉大利，高枕无忧）</b>';
            rank='<b class="text-success">'+rank+'</b>';
        }else{
            rank='<b class="text-info">A</b>';
        }
        if(fatal_count>0){
            rank='<b class="text-info">B</b>';
        }
        if(fatal_count>= 2 || warn_count>2){
            rank = '<b class="text-warning">C</b>';
        }
        if(fatal_count> 3){
            rank = '<b class="text-danger">F</b>';
        }
        if(warn_count>5){
            rank = '<b class="text-warning">D</b>';
        }
        if(warn_count>8){
            rank = '<b class="text-danger">E</b>';
        }
        if(warn_count>=10){
            rank = '<b class="text-danger">F</b>';
        }
        $.post("dedesafe.php",{'action':'setrank','rank':rank},function (data) {

        });
        $("#curRank small").html(rankTip);
        return rank;
    }
</script>
</body>
</html>
<?php
setCache();
?>
