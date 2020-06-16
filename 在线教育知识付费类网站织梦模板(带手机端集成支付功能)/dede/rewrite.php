<?php
/**
 * 织梦伪静态助手
 * User: dedemao
 * 发布时间: 2019年2月14日20:42:27
 */
$ver='1.6';
session_cache_limiter('private,must-revalidate');
require_once(dirname(__FILE__)."/config.php");
helper('rewrite');
if(empty($dopost)) $dopost = "";

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
    $txt = DEDEDATA.'/module/rewrite.txt';
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
                    hm.src = "//www.dedemao.com/api/stat.php?id='.$id.'&v='.$cfg_version.'&subject=rewrite";
                    var s = document.getElementsByTagName("script")[0];
                    s.parentNode.insertBefore(hm, s);
                })();
            </script>';
    }
}
function editSystemFile()
{
    $content1 = file_get_contents(DEDEINC.'/arc.archives.class.php');
    if(strstr($content1,'display($ismake=0)')===false){
        $content1 = str_replace('function display()','function display($ismake=0)',$content1);
        $content1 = str_replace('($pageCount,0)','($pageCount,$ismake)',$content1);
        $fp = fopen(DEDEINC.'/arc.archives.class.php','w');
        flock($fp,3);
        fwrite($fp,$content1);
        fclose($fp);
    }
    $content2 = file_get_contents(DEDEINC.'/arc.listview.class.php');
    if(strstr($content2,'Display($ismake=0)')===false){
        $content2 = str_replace('function Display()','function Display($ismake=0)',$content2);
        $content2 = str_replace('($this->PageNo,0)','($this->PageNo,$ismake)',$content2);
        $content2 = str_replace('CreateDir(MfTypedir($this->Fields[\'typedir\']))','if(!$GLOBALS[\'rewrite_open\'] || $GLOBALS[\'rewrite_open\']==2) CreateDir(MfTypedir($this->Fields[\'typedir\']))',$content2);
        $fp = fopen(DEDEINC.'/arc.listview.class.php','w');
        flock($fp,3);
        fwrite($fp,$content2);
        fclose($fp);
    }
    $content3 = file_get_contents(DEDEINC.'/helpers/channelunit.helper.php');
    if(strstr($content3,'rewrite_open')===false){
        $content3 = str_replace('CreateDir($okdir)','if(!$GLOBALS[\'rewrite_open\'] || $GLOBALS[\'rewrite_open\']==2) CreateDir($okdir)',$content3);
        $fp = fopen(DEDEINC.'/helpers/channelunit.helper.php','w');
        flock($fp,3);
        fwrite($fp,$content3);
        fclose($fp);
    }
    $content4 = file_get_contents(DEDEINC.'/dedetag.class.php');
    if(strstr($content4,'rewrite_open')===false){
        $content4 = str_replace('$fp = @fopen($filename,"w")','if($GLOBALS[\'rewrite_open\']==1) return;$fp = @fopen($filename,"w")',$content4);
        $fp = fopen(DEDEINC.'/dedetag.class.php','w');
        flock($fp,3);
        fwrite($fp,$content4);
        fclose($fp);
    }

    $path = dirname(__FILE__);
    $content = file_get_contents($path.'/catalog_add.php');
    if(strstr($content,'rewrite_open')===false){
        $content = str_replace('!CreateDir($true_typedir)','(!$GLOBALS[\'rewrite_open\'] || $GLOBALS[\'rewrite_open\']==2) && !CreateDir($true_typedir)',$content);
        $fp = fopen($path.'/catalog_add.php','w');
        flock($fp,3);
        fwrite($fp,$content);
        fclose($fp);
    }

    $content = file_get_contents(DEDEINC.'/taglib/tag.lib.php');
    if(strstr($content,'rewrite_open')===false){
        $content = str_replace('$cfg_cmsurl."/tags.php?/".urlencode($row[\'keyword\'])."/";','$GLOBALS[\'rewrite_open\']==1 ? $cfg_cmsurl."/tags/".urlencode($row[\'keyword\']).".html" : $cfg_cmsurl."/tags.php?/".urlencode($row[\'keyword\'])."/";',$content);
        $fp = fopen(DEDEINC.'/taglib/tag.lib.php','w');
        flock($fp,3);
        fwrite($fp,$content);
        fclose($fp);
    }

    $content = file_get_contents(DEDEINC.'/arc.taglist.class.php');
    if(strstr($content,'rewrite_open')===false){
        $content = str_replace('$purl .= "?/".urlencode($this->Tag);','$purl .= "?/".urlencode($this->Tag);
		if($GLOBALS[\'rewrite_open\']==1){
			$purl = $this->GetCurUrl();
			$purl = str_replace($this->PageNo.\'.html\',\'\',$purl);
			$purl = str_replace(\'.html\',\'\',$purl);
			$purl = rtrim($purl,\'/\');
		}',$content);
        $content = str_replace('"<li><a href=\'".$purl."/$prepagenum/\'>上一页</a></li>\r\n";','$GLOBALS[\'rewrite_open\']==1 ? "<li><a href=\'".$purl."/$prepagenum.html\'>上一页</a></li>\r\n" : "<li><a href=\'".$purl."/$prepagenum/\'>上一页</a></li>\r\n";',$content);
        $content = str_replace('"<li><a href=\'".$purl."/1/\'>首页</a></li>\r\n";','$GLOBALS[\'rewrite_open\']==1 ? "<li><a href=\'".$purl."/1.html\'>首页</a></li>\r\n" : "<li><a href=\'".$purl."/1/\'>首页</a></li>\r\n";',$content);
        $content = str_replace('"<li><a href=\'".$purl."/$nextpagenum/\'>下一页</a></li>\r\n";','$GLOBALS[\'rewrite_open\']==1 ? "<li><a href=\'".$purl."/$nextpagenum.html\'>下一页</a></li>\r\n" : "<li><a href=\'".$purl."/$nextpagenum/\'>下一页</a></li>\r\n";',$content);
        $content = str_replace('"<li><a href=\'".$purl."/$totalpage/\'>末页</a></li>\r\n";','$GLOBALS[\'rewrite_open\']==1 ? "<li><a href=\'".$purl."/$totalpage.html\'>末页</a></li>\r\n" : "<li><a href=\'".$purl."/$totalpage/\'>末页</a></li>\r\n";',$content);
        $content = str_replace('"<li><a href=\'".$purl."/$j/\'>".$j."</a></li>\r\n";','$GLOBALS[\'rewrite_open\']==1 ? "<li><a href=\'".$purl."/$j.html\'>".$j."</a></li>\r\n" : "<li><a href=\'".$purl."/$j/\'>".$j."</a></li>\r\n";',$content);
        $fp = fopen(DEDEINC.'/arc.taglist.class.php','w');
        flock($fp,3);
        fwrite($fp,$content);
        fclose($fp);
    }

    $content = file_get_contents(DEDEINC.'/arc.searchview.class.php');
    if(strstr($content,'rewrite_open')===false){
        $content = str_replace('$purl .= "?".$geturl;','$purl .= "?".$geturl;
        if($GLOBALS[\'rewrite_open\']==1){
            $purl = $this->GetCurUrl();
            $purl = str_replace($this->PageNo.\'.html\',\'\',$purl);
            $purl = str_replace(\'.html\',\'\',$purl);
            $purl = rtrim($purl,\'/\');
        }',$content);
        $content = str_replace('"<td width=\'50\'><a href=\'".$purl."PageNo=$prepagenum\'>上一页</a></td>\r\n";','$GLOBALS[\'rewrite_open\']==1 ? "<td width=\'50\'><a href=\'".$purl."/$prepagenum.html\'>上一页</a></td>\r\n" : "<td width=\'50\'><a href=\'".$purl."PageNo=$prepagenum\'>上一页</a></td>\r\n";',$content);
        $content = str_replace('"<td width=\'30\'><a href=\'".$purl."PageNo=1\'>首页</a></td>\r\n";','$GLOBALS[\'rewrite_open\']==1 ? "<td width=\'30\'><a href=\'".$purl."/1.html\'>首页</a></td>\r\n" : "<td width=\'30\'><a href=\'".$purl."PageNo=1\'>首页</a></td>\r\n";',$content);
        $content = str_replace('"<td width=\'50\'><a href=\'".$purl."PageNo=$nextpagenum\'>下一页</a></td>\r\n";','$GLOBALS[\'rewrite_open\']==1 ? "<td width=\'50\'><a href=\'".$purl."/$nextpagenum.html\'>下一页</a></td>\r\n" : "<td width=\'50\'><a href=\'".$purl."PageNo=$nextpagenum\'>下一页</a></td>\r\n";',$content);
        $content = str_replace('"<td width=\'30\'><a href=\'".$purl."PageNo=$totalpage\'>末页</a></td>\r\n";','$GLOBALS[\'rewrite_open\']==1 ? "<td width=\'30\'><a href=\'".$purl."/$totalpage.html\'>末页</a></td>\r\n" : "<td width=\'30\'><a href=\'".$purl."PageNo=$totalpage\'>末页</a></td>\r\n";',$content);
        $content = str_replace('"<td><a href=\'".$purl."PageNo=$j\'>[".$j."]</a>&nbsp;</td>\r\n";','$GLOBALS[\'rewrite_open\']==1 ? "<td><a href=\'".$purl."/$j.html\'>".$j."</a>&nbsp;</td>\r\n" : "<td><a href=\'".$purl."PageNo=$j\'>[".$j."]</a>&nbsp;</td>\r\n";',$content);
        $fp = fopen(DEDEINC.'/arc.searchview.class.php','w');
        flock($fp,3);
        fwrite($fp,$content);
        fclose($fp);
    }

    $path = dirname(__FILE__);
    $content = file_get_contents($path.'/makehtml_homepage.php');
    if(strstr($content,'rewrite_open')===false){
        $content = str_replace('$templet = str_replace("{style}", $cfg_df_style, $templet);','$GLOBALS[\'rewrite_open\'] = 0;
        $templet = str_replace("{style}", $cfg_df_style, $templet);',$content);
        $fp = fopen($path.'/makehtml_homepage.php','w');
        flock($fp,3);
        fwrite($fp,$content);
        fclose($fp);
    }

    $path = dirname(__FILE__);
    $content = file_get_contents($path.'/makehtml_list_action.php');
    if(strstr($content,'rewrite_open')===false){
        $content = str_replace('$lv->CountRecord();','$lv->CountRecord();
    $GLOBALS[\'rewrite_open\'] = 0;',$content);
        $fp = fopen($path.'/makehtml_list_action.php','w');
        flock($fp,3);
        fwrite($fp,$content);
        fclose($fp);
    }

    $path = dirname(__FILE__);
    $content = file_get_contents($path.'/makehtml_list_action.php');
    if(strstr($content,'rewrite_open')===false){
        $content = str_replace('$lv->CountRecord();','$lv->CountRecord();
    $GLOBALS[\'rewrite_open\'] = 0;',$content);
        $fp = fopen($path.'/makehtml_list_action.php','w');
        flock($fp,3);
        fwrite($fp,$content);
        fclose($fp);
    }

    $path = dirname(__FILE__);
    $content = file_get_contents($path.'/makehtml_archives_action.php');
    if(strstr($content,'rewrite_open')===false){
        $content = str_replace('while($row=$dsql->GetObject(\'out\'))','$GLOBALS[\'rewrite_open\'] = 0;
while($row=$dsql->GetObject(\'out\'))',$content);
        $fp = fopen($path.'/makehtml_archives_action.php','w');
        flock($fp,3);
        fwrite($fp,$content);
        fclose($fp);
    }

    $path = dirname(__FILE__);
    $content = file_get_contents($path.'/article_add.php');
    if(strstr($content,'rewrite_cache')===false){
        $content = str_replace('ClearMyAddon($arcID, $title);','ClearMyAddon($arcID, $title);
    if($GLOBALS[\'rewrite_cache\']==\'on\'){
        helper(\'caches\');
        delWriteCache(\'article\',$arcID);
        delWriteCache(\'article_m\',$arcID);
        if($GLOBALS[\'cache_pub\']>=1){
            delWriteCache(\'list\',$typeid);
            delWriteCache(\'list_m\',$typeid);
        }
        if($GLOBALS[\'cache_pub\']==2){
            delWriteCache(\'index\',\'\',\'\');
            delWriteCache(\'index_m\',\'\',\'\');
        }
    }',$content);
        $fp = fopen($path.'/article_add.php','w');
        flock($fp,3);
        fwrite($fp,$content);
        fclose($fp);
    }

    $path = dirname(__FILE__);
    $content = file_get_contents($path.'/article_edit.php');
    if(strstr($content,'rewrite_cache')===false){
        $content = str_replace('ClearMyAddon($id, $title);','ClearMyAddon($id, $title);
    if($GLOBALS[\'rewrite_cache\']==\'on\'){
        helper(\'caches\');
        delWriteCache(\'article\',$id);
        delWriteCache(\'article_m\',$id);
        if($GLOBALS[\'cache_pub\']>=1){
            delWriteCache(\'list\',$typeid);
            delWriteCache(\'list_m\',$typeid);
        }
        if($GLOBALS[\'cache_pub\']==2){
            delWriteCache(\'index\',\'\',\'\');
            delWriteCache(\'index_m\',\'\',\'\');
        }
    }',$content);
        $fp = fopen($path.'/article_edit.php','w');
        flock($fp,3);
        fwrite($fp,$content);
        fclose($fp);
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
function makeHtaccess()
{
    $path = dirname(__FILE__);
    if($GLOBALS['rewrite_open']==1){
        $pathinfo = pathinfo($path);
        $adminPathName = $pathinfo['basename'];
        $content = file_get_contents($path.'/../.htaccess');
        if(!$content){
            $str = '#dedecms电脑端目录结构apache伪静态
RewriteEngine On
RewriteBase /

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ /plus/rewrite.php?s=$1 [L]

RewriteRule ^$ /plus/rewrite.php?s=$1 [L]';
            $fp = fopen($path.'/../.htaccess','w');
            flock($fp,3);
            fwrite($fp,$str);
            fclose($fp);
        }
        $mobilePath  = $GLOBALS['dedemao_path'] ? rtrim($GLOBALS['dedemao_path'],'/'): '/m';
        $content = file_get_contents($path.'/..'.$mobilePath.'/.htaccess');
        $mobileBase = $GLOBALS['dedemao_visit']=='top' ? '/' : $mobilePath;
        $plusPath = $GLOBALS['dedemao_visit']=='top' ? '' : '/plus/';
        $rewriteBase = 'RewriteBase '.$mobilePath;
        $flag = $GLOBALS['dedemao_visit']=='top' ? true : false;
        if(!$content){
            $str = '#dedecms手机目录结构apache伪静态
RewriteEngine On
RewriteBase '.$mobileBase.'
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ '.$plusPath.'rewrite.php?s=$1&mobile=1 [L]
RewriteRule ^$ '.$plusPath.'rewrite.php?s=$1&mobile=1 [L]';
            $fp = fopen($path.'/..'.$mobilePath.'/.htaccess','w');
            flock($fp,3);
            fwrite($fp,$str);
            fclose($fp);
        }
    }


}
function getMobileTemplete()
{
    global $cfg_df_style;
    $templatePath = DEDETEMPLATE.'/'.$cfg_df_style;
    $dh = dir($templatePath) or die("没找到模板目录：({$templatePath})！");
    $arr = array();
    while($filename = $dh->read()) {
        if($filename=='.' || $filename=='..'){
            continue;
        }
        if(substr($filename,-6)!='_m.htm') continue;
        $arr[] = $templatePath.'/'.$filename;
    }
    return $arr;
}
function updateMobileTemplete($templateArr)
{
    foreach ($templateArr as $t){
        $fp = @fopen($t,'r');
        if($fp===false) continue;
        $content = fread($fp, filesize($t));
        fclose($fp);
        $fp = @fopen($t,'w');
        $content = str_replace('view.php?aid=[field:id/]','[field:arcurl/]',$content);
        $content = str_replace('list.php?tid=[field:id/]','[field:typeurl/]',$content);
        $content = str_replace('view.php?aid=[field:id','[field:arcurl',$content);
        $content = str_replace('list.php?tid=[field:id','[field:typeurl',$content);
        $content = str_replace('list.php?tid={dede:field name=\'id\'/}','{dede:field name=\'typeurl\'/}',$content);
        $content = str_replace('list.php?tid={dede:field name=\'id\'','{dede:field name=\'typeurl\'',$content);
        $content = str_replace('list.php?tid=~id~','~typelink~',$content);
        $content = str_replace('"index.php"','"{dede:global.cfg_cmsurl/}/index.html"',$content);
        $content = str_replace("'index.php'","'{dede:global.cfg_cmsurl/}/index.html'",$content);
        $content = str_replace('"/index.php"','"{dede:global.cfg_cmsurl/}/index.html"',$content);
        $content = str_replace("'/index.php'","'{dede:global.cfg_cmsurl/}/index.html'",$content);
        $content = str_replace('"/"','"{dede:global.cfg_cmsurl/}/index.html"',$content);
        $content = str_replace("'/'","'{dede:global.cfg_cmsurl/}/index.html'",$content);
        fwrite($fp,$content);
        fclose($fp);
    }
}
function checkCmsPath()
{
    global $dsql;
    $dsql->ExecuteNoneQuery("update `#@__arctype` set typedir = CONCAT('{cmspath}',typedir) where typedir not like '{cmspath}%'");
}
function updateTypeLink()
{
    $t = DEDEINC.'/typelink.class.php';
    $fp = @fopen($t,'r');
    if($fp===false) return;
    $content = fread($fp, filesize($t));
    fclose($fp);
    if(strstr($content,"defined('DEDEMOB') && false")===false){
        $t_bak = DEDEINC.'/typelink.class.php.bak';
        @copy($t,$t_bak);
        $fp = @fopen($t,'w');
        $content = str_replace("defined('DEDEMOB')","defined('DEDEMOB') && false",$content);
        fwrite($fp,$content);
        fclose($fp);
    }
    if(strstr($content,"GLOBALS['dedemao_visit']")===false){
        $fp = @fopen($t,'w');
        $content = str_replace('$GLOBALS[\'cfg_basehost\']','$GLOBALS[\'dedemao_visit\']==\'top\' ? \'/\' : $GLOBALS[\'cfg_basehost\']',$content);
        fwrite($fp,$content);
        fclose($fp);
    }
}
function updatePreNextLink()
{
    $t = DEDEINC.'/arc.archives.class.php';
    $fp = @fopen($t,'r');
    if($fp===false) return;
    $content = fread($fp, filesize($t));
    fclose($fp);
    if(strstr($content,"defined('DEDEMOB') && false")===false){
        $t_bak = DEDEINC.'/arc.archives.class.php.bak';
        @copy($t,$t_bak);
        $fp = @fopen($t,'w');
        $str1_s = '                if ( defined(\'DEDEMOB\') )';
        $str1_t = '                if ( defined(\'DEDEMOB\') && false)';
        if(strstr($content,$str1_s)!==false){
            $content = str_replace($str1_s,$str1_t,$content);
        }
        fwrite($fp,$content);
        fclose($fp);
    }
}
function copyDefaultImg()
{
    if(!is_dir(DEDEINC.'/../m/images')){
        @mkdir(DEDEINC.'/../m/images',0777,true);
    }
    @copy(DEDEINC.'/../images/defaultpic.gif',DEDEINC.'/../m/images/defaultpic.gif');
}
function editChannelunit()
{
    $t = DEDEINC.'/helpers/channelunit.helper.php';
    $fp = @fopen($t,'r');
    if($fp===false) return;
    $content = fread($fp, filesize($t));
    fclose($fp);
    if(strstr($content,'$GLOBALS[\'dedemao_visit\']')===false){
        $t_bak = DEDEINC.'/helpers/channelunit.helper.php.bak';
        @copy($t,$t_bak);
        $fp = @fopen($t,'w');
        $str1 = 'if(defined(\'DEDEMOB\') && $GLOBALS[\'dedemao_visit\']==\'top\'){
                if(substr($articleUrl,0,strlen($GLOBALS[\'dedemao_path\'])+1)==$GLOBALS[\'dedemao_path\'].\'/\'){
                    $articleUrl = substr($articleUrl,strlen($GLOBALS[\'dedemao_path\']));
                }
            }
            return $articleUrl;';
        $str2 = 'if(defined(\'DEDEMOB\') && $GLOBALS[\'dedemao_visit\']==\'top\'){
            if(substr($reurl,0,strlen($GLOBALS[\'dedemao_path\'])+1)==$GLOBALS[\'dedemao_path\'].\'/\'){
                $reurl = substr($reurl,strlen($GLOBALS[\'dedemao_path\']));
            }
        }
        return $reurl;';
        $str3 = 'if(defined(\'DEDEMOB\') && $GLOBALS[\'dedemao_visit\']==\'top\'){
            $articlename = $GLOBALS[\'dedemao_path\'].$articlename;
        }        
        if(defined(\'DEDEMOB\') && $GLOBALS[\'dedemao_visit\']==\'child\'){
            $articlename = strstr($articlename,$GLOBALS[\'dedemao_path\'])===false ? $GLOBALS[\'dedemao_path\'].$articlename : $articlename;
        }
        if(preg_match("/\?/", $articlename))';
        $content = str_replace('return $articleUrl;',$str1,$content);
        $content = str_replace('return $reurl;',$str2,$content);
        $content = str_replace('if(preg_match("/\?/", $articlename))',$str3,$content);
        fwrite($fp,$content);
        fclose($fp);
    }
}
function editImgUrl($dedemao_visit)
{
    global $dsql;
    if($dedemao_visit=='top'){
        $t = DEDEINC.'/dialog/select_images_post.php';
        $fp = @fopen($t,'r');
        if($fp===false) return;
        $content = fread($fp, filesize($t));
        fclose($fp);
        if(strstr($content,'$GLOBALS[\'cfg_basehost\']')===false){
            $t_bak = DEDEINC.'/dialog/select_images_post.php.bak';
            @copy($t,$t_bak);
            $fp = @fopen($t,'w');
            $str_s = '$fileurl = $activepath.\'/\'.$filename;';
            $str_t = '$fileurl = $GLOBALS[\'cfg_basehost\'].$activepath.\'/\'.$filename;';
            $content = str_replace($str_s,$str_t,$content);
            fwrite($fp,$content);
            fclose($fp);
            $domain = rtrim($GLOBALS['cfg_basehost'],'/');
            $dsql->ExecuteNoneQuery("update `#@__addonarticle` set body = REPLACE(body,'=\"/uploads','=\"{$domain}/uploads')");
            $dsql->ExecuteNoneQuery("update `#@__addonarticle` set body = REPLACE(body,'=\'/uploads','=\'{$domain}/uploads')");
            $dsql->ExecuteNoneQuery("update `#@__addonarticle` set body = REPLACE(body,'=/uploads','={$domain}/uploads')");
        }
    }
}
function checkMobileVisit()
{
    $path = dirname(__FILE__);
    $plusPath = $path.'/../plus';
    $mPath  = $GLOBALS['dedemao_path'] ? rtrim($GLOBALS['dedemao_path'],'/'): '/m';
    $mobilePath = $path.'/..'.$mPath;
    if($GLOBALS['dedemao_visit']=='top'){
        if(!file_exists($mobilePath.'/rewrite.php')){
            @copy($plusPath.'/rewrite.php',$mobilePath.'/rewrite.php');
        }
        if(!file_exists($mobilePath.'/rewrite.php')){
            return false;
        }
    }else{
        if(file_exists($mobilePath.'/rewrite.php')){
            @unlink($mobilePath.'/rewrite.php');
        }
    }
    return true;
}
function curlGet($url = '', $options = array()){
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
    curl_close($ch);
    return $data;
}
function getServerName()
{
    $server = strtolower($_SERVER["SERVER_SOFTWARE"]);
    if(strstr($server,'apache')!==false){
        return 'apache';
    }
    if(strstr($server,'iis')!==false){
        return 'iis';
    }
    if(strstr($server,'nginx')!==false){
        return 'nginx';
    }
    return 'unknown';
}

function getDomainName()
{
	$scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 'https://' : 'http://';
	return $scheme.$_SERVER['HTTP_HOST'];
}

function getHttpProtocol() {
    $protocol = 'http';
    if ( !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
        $protocol='https';
    } elseif ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
        $protocol='https';
    } elseif ( !empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
        $protocol='https';
    }
    return $protocol;
}
if($dopost=='copyCode'){
    $path = dirname(__FILE__);
    $pathinfo = pathinfo($path);
    $adminPathName = $pathinfo['basename'];
    $serverName = getServerName();
    $mobilePath  = $GLOBALS['dedemao_path'] ? rtrim($GLOBALS['dedemao_path'],'/'): '/m';
    $mobileBase = $GLOBALS['dedemao_visit']=='top' ? '/' : $mobilePath;
    $plusPath = $GLOBALS['dedemao_visit']=='top' ? '' : '/plus/';
    $domain = getDomainName();
	$data = curlGet('https://api.dedemao.com/code/rewrite.php?domain='.urlencode($domain).'&server='.$serverName.'&adminpath='.$adminPathName.'&mobilepath='.$mobilePath.'&mobilebase='.$mobileBase.'&pluspath='.$plusPath);
    $data = json_decode($data,true);
    include DedeInclude('templets/rewrite_code.htm');
    exit();
}
//保存配置的改动
if($dopost=="save")
{
    $info = $_POST['info'];
    $data = $_POST['basic'];
    $replace_link = intval($data['replace_link']);
    $rewrite_index= $data['rewrite_index'];
    if($replace_link==1){
        $templateArr = getMobileTemplete();
        updateMobileTemplete($templateArr);
    }
    if($rewrite_index=='on'){
        $dsql->ExecuteNoneQuery("UPDATE `#@__homepageset` SET `showmod`='0'");
    }else{
        $dsql->ExecuteNoneQuery("UPDATE `#@__homepageset` SET `showmod`='1'");
    }
    checkCmsPath();
    updateTypeLink();
    updatePreNextLink();
    copyDefaultImg();
    editChannelunit();
    editImgUrl($dedemao_visit);
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
    ShowMsg("成功更改配置！", "rewrite.php");
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
$data['rewrite_open'] = $data['rewrite_open'] ? $data['rewrite_open'] : 0;
editSystemFile();
editModuleMain();
makeHtaccess();
$configResult = checkMobileVisit();
$serverName = getServerName();
$httpHost = getHttpProtocol().'://'.$_SERVER['HTTP_HOST'];
$httpHostM = getHttpProtocol().'://m.'.str_replace('www.','',$_SERVER['HTTP_HOST']);
include DedeInclude('templets/rewrite.htm');
setCache();
