<?php
header("Content-type:text/html; Charset='utf-8'");
require_once(dirname(__FILE__)."/../include/common.inc.php");
$safe = new dedesafe();
$msg = array();
$step = isset($step) ? intval($step) : 1;
$state='正在检查中';
switch ($step){
    case 1:
        $state='检查静态资源目录里是否有上传php文件';
        $msg['fatal'] = $safe->checkStaticDir();
        break;
    case 2:
        $state='检查install目录是否删除';
        $msg['fatal'] = $safe->checkNeedDelete();
        break;
    case 3:
        $state='检查危险目录是否改名';
        $msg['fatal'] = $safe->checkNeedRename();
        break;
    case 4:
        $state='检查网站栏目文件夹里是否有上传php文件';
        $msg['fatal'] = $safe->checkHtmlDir();
        break;
    case 5:
        $state='默认管理员，默认密码是否改名';
        $msg['warn'] = $safe->checkDefaultAdmin();
        break;
    case 6:
        $state='检查静态资源目录是否有执行权限';
        $msg['warn'] = $safe->checkPermission();
        break;
    case 7:
        $state='可疑文件扫描';
        $msg['warn'] = $safe->scanFile();
        break;
    case 8:
        $state='扫描其他注意事项';
        $msg['suggest'] = $safe->suggest();
        break;
}
function handleFilePath($file)
{
    $file = str_replace('///','/',$file);
    $file = str_replace('//','/',$file);
    return $file;
}

//生成的文件夹里是否有php文件
$score = $score ? intval($score) : 100;
$fatalCount = count($msg['fatal']);
if($fatalCount>0){
    $score = 60;
    $scoreNew = $score-$fatalCount*5;
    $score = $scoreNew>0 ? $scoreNew : 0;
}
$warnCount = count($msg['warn']);
if($warnCount>0){
    $score = $score>80 ? 80 : $score;
    $scoreNew = $score-$warnCount*2;
    $score = $scoreNew>0 ? $scoreNew : 0;
}
$data['grade'] = $score < 60 ? 'F' : 'A';
$data['score'] = $score;
$data['msg'] = $msg;
$data['state'] = $state;
$data['step'] = $step;
$data['is_end'] = $step>=8 ? true : false;
echo json_encode($data);exit();
//主页篡改提醒
//文件篡改提醒
//非法上传提醒
//文件指纹采集

class dedesafe
{
    public $ver=1.0;
    public $dirname;
    private $dsql;
    private $domain;
    private $server;
    public static $fatalCount = 0;
    public static $warnCount = 0;
    public static $suggestCount = 0;

    public function __construct()
    {
        global $dsql;
        $this->dirname = DEDEROOT;
        $this->dsql = $dsql;
        $this->domain = $this->getHttpProtocol().'://'.$_SERVER['HTTP_HOST'];
        $this->server = $this->getServerName();
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

    public function checkStaticDir()
    {
        $phpDirs = array('uploads','a','templets','skin','html','images','js');
        $msg = array();
        foreach ($phpDirs as $phpDir){
            $folder = $this->dirname.'/'.$phpDir;

            if(!is_dir($folder)) continue;
            $obj = new UnsetBom(array('php'));
            $obj->process($folder);
            foreach ($obj->files as $file){
                $file = handleFilePath($file);
                $dir = str_replace($this->dirname,'',dirname($file));
                $filename = basename($file);
                $msg[] = "<p>{$phpDir}目录出现php文件：{$file}  <a class='btn btn-link' target='_blank' href='file_manage_view.php?fmdo=edit&filename={$filename}&activepath={$dir}'>查看文件</a></p>";
            }
        }
        return $msg;
    }

    public function checkNeedDelete()
    {
        $msg = array();
        if(is_dir($this->dirname.'/install')){
            $msg[] = "<p>install文件夹未删除  <a class='btn btn-link text-danger' target='_blank' href='dedesafe.php?action=deldir&dir=install'>删除该文件夹</a></p>";
        }
        return $msg;
    }


    public function checkNeedRename()
    {
        $dirs = array('data','dede');
        $msg = array();
        foreach ($dirs as $dir){
            if($dir=='data'){
                if(substr(DEDEDATA,-4)=='data'){
                    if(strstr(DEDEDATA,'../data')===false){
                        $msg[] = "<p>data目录未改名！ <a class='btn btn-link' target='_blank' href='dedesafe.php?action=editdata'>【帮我改】</a></p>";
                    }
                }
            }else{
                if(is_dir($this->dirname.'/'.$dir)){
                    $msg[] = '<p>默认管理目录为dede，需要立即改名！ <a class=\'btn btn-link\' target=\'_blank\' href=\'dedesafe.php?action=editdede\'>【帮我改】</a></p>';
                }
            }
        }
        return $msg;
    }

    public function checkHtmlDir()
    {
        global $cfg_cmspath;
        $msg = array();
        $this->dsql->SetQuery("SELECT typedir FROM `#@__arctype`");
        $this->dsql->Execute();
        $makeDirs = array();
        while($arr = $this->dsql->GetArray())
        {
            if(strstr($arr['typedir'],'/a/')!==false){
                continue;
            }
            $dir = str_replace('{cmspath}','',$arr['typedir']);
            $dir = (dirname($dir)=='\\') ? $dir : dirname($dir);
            $makeDirs[] = $cfg_cmspath.$dir;
        }
        $makeDirs = array_unique($makeDirs);
        foreach ($makeDirs as $phpDir){
            if($phpDir=='/') continue;
            $folder = $this->dirname.'/'.$phpDir;
            if(!is_dir($folder)) continue;
            $obj = new UnsetBom(array('php'));
            $obj->process($folder);
            foreach ($obj->files as $file){
                $file = handleFilePath($file);
                $dir = str_replace($this->dirname,'',dirname($file));
                $filename = basename($file);
                $msg[] = "<p>{$phpDir}目录出现php文件：{$file}  <a class='btn btn-link' target='_blank' href='file_manage_view.php?fmdo=edit&filename={$filename}&activepath={$dir}'>查看文件</a></p>";
            }
        }
        return $msg;
    }

    public function checkDefaultAdmin()
    {
        $msg = array();
        $row = $this->dsql->GetOne("SELECT * FROM `#@__admin` WHERE userid='admin'");
        if(is_array($row)){
            $msg[] = '<p>默认管理员账号为admin，<a href="sys_admin_user.php">请更改</a>。</p>';
        }
        return $msg;
    }

    public function checkPermission()
    {
        $phpDirs = array('include','uploads','a','templets','skin','html','images','js');
        $msg = array();		
        foreach ($phpDirs as $phpDir){
            $folder = $this->dirname.'/'.$phpDir;
			
            if(!is_dir($folder)) continue;
			
            if(!file_exists($folder.'/check.php')){
                $result = file_put_contents($folder.'/check.php','<?php echo 1;?>');				
                if($result!==false){
                    $header=get_headers($this->domain.'/'.$phpDir.'/check.php');
                    if(strstr($header[0],'200')!==false){
                        $msg[] = "<p>{$folder}目录有执行脚本的权限。".$this->getSolveButton($folder)."</p>";
                    }
                }
				
                unlink($folder.'/check.php');
            }else{
                unlink($folder.'/check.php');
            }
        }
        return $msg;
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

    private function getSolveButton($folder)
    {
        switch ($this->server){
            case 'apache':
                if($this->isRewriteMod()){
                    return "【<a target='_blank' href='dedesafe.php?action=closePermission&folder={$folder}'>帮我关掉</a>】";
                }else{
                    return '【apache未开启mod_rewrite模块】';
                }
                break;
            case 'nginx':
                return '【<a href=\'http://www.jb51.net/article/46153.htm\'>查看关闭方法</a>】';
                break;
            case 'iis':
                return '【<a href=\'http://www.pc811.com/6/1/26080.html\'>查看关闭方法</a>】';
                break;
        }

    }

    public function scanFile()
    {
        $msg = array();
        $obj = new UnsetBom(array('php'));
        $obj->process($this->dirname);
		$i=0;
        foreach ($obj->files as $file){
			$i++;
            $file = handleFilePath($file);
            if(is_file($file)){
                $content = file_get_contents($file);
				if(strstr($content,'<?php')===false){
					 continue;
				}
                if(strstr($content,'g'.'zinflate')!==false){
                    $dir = str_replace($this->dirname,'',dirname($file));
                    $filename = basename($file);
                    $msg[] = "<p>发现可疑文件：{$file} <a class='btn btn-link' target='_blank' href='file_manage_view.php?fmdo=edit&filename={$filename}&activepath={$dir}'>查看文件</a></p>";
                    continue;
                }
				/*
                if($this->getCountOfStr($content)>100){
                    $dir = str_replace($this->dirname,'',dirname($file));
                    $filename = basename($file);
                    $msg[] = "<p>发现可疑文件：{$file} <a class='btn btn-link' target='_blank' href='file_manage_view.php?fmdo=edit&filename={$filename}&activepath={$dir}'>查看文件</a></p>";
                    continue;
                }
				*/

                if(strstr($content,'c'.'reate_function')!==false){
                    $dir = str_replace($this->dirname,'',dirname($file));
                    $filename = basename($file);
                    $msg[] = "<p>发现可疑文件：{$file} <a class='btn btn-link' target='_blank' href='file_manage_view.php?fmdo=edit&filename={$filename}&activepath={$dir}'>查看文件</a></p>";
                    continue;
                }

				$line = count(file($file));
				if($line<=5 && filesize($file)>1500){
                        $dir = str_replace($this->dirname,'',dirname($file));
                        $filename = basename($file);
						$msg[] = "<p>发现可疑文件：{$file} <a class='btn btn-link' target='_blank' href='file_manage_view.php?fmdo=edit&filename={$filename}&activepath={$dir}'>查看文件</a></p>";
						continue;
				}
				if($line<=10 && filesize($file)>10000){
                        $dir = str_replace($this->dirname,'',dirname($file));
                        $filename = basename($file);
						$msg[] = "<p>发现可疑文件：{$file} <a class='btn btn-link' target='_blank' href='file_manage_view.php?fmdo=edit&filename={$filename}&activepath={$dir}'>查看文件</a></p>";
						continue;
				}

                $pattern = '/[a-zA-Z\d\n\r\/]{200,}/isU';
                $result = preg_match_all($pattern,$content,$matches);
                if($result>0){
                    $dir = str_replace($this->dirname,'',dirname($file));
                    $filename = basename($file);
                    $msg[] = "<p>发现可疑文件：{$file} <a class='btn btn-link' target='_blank' href='file_manage_view.php?fmdo=edit&filename={$filename}&activepath={$dir}'>查看文件</a></p>";
                    continue;
                }


                $pattern = '/\$[a-zA-Z0-9\_]+\(/U';
                $content = str_replace('->$','=',$content);
                $content = str_replace('\$','=',$content);
                $content = str_replace('new $','new ',$content);
                $content = str_replace('$func','',$content);
                $content = str_replace('$bucket','',$content);
                $content = str_replace('func(','=',$content);
                $content = str_replace('$k({$v}','',$content);
                $content = str_replace('$typename(','',$content);
                $result = preg_match_all($pattern,$content,$matches);
                if($result>0){
                    $dir = str_replace($this->dirname,'',dirname($file));
                    $filename = basename($file);
                    $msg[] = "<p>发现可疑文件：{$file} <a class='btn btn-link' target='_blank' href='file_manage_view.php?fmdo=edit&filename={$filename}&activepath={$dir}'>查看文件</a></p>";
                    continue;
                }
                if(stristr($file,'cache')===false){
                    $line = count(file($file));
                    if($line<=2 && strstr($content,'GET')!==false){
                        $dir = str_replace($this->dirname,'',dirname($file));
                        $filename = basename($file);
                        $msg[] = "<p>发现可疑文件：{$file} <a class='btn btn-link' target='_blank' href='file_manage_view.php?fmdo=edit&filename={$filename}&activepath={$dir}'>查看文件</a></p>";
                        continue;
                    }
                }

//                $size = filesize($file);
//                $size = $this->getsize($size,'kb');
//                if($size>50){
//                    $msg[] = "<p>发现可疑文件,体积大于50KB：{$file}</p>";
//                    continue;
//                }
            }
        }
        return $msg;
    }

    function getCountOfStr($text,$isdebug=0)
    {
        $words = array();
        $text = str_replace("\r\n","",$text);
        $text = str_replace("\n\r","",$text);
        $text = str_replace(" ","",$text);
        $text = str_replace("*","",$text);
        //按特殊符号进行分句
        $string = preg_replace('/([\x{4e00}-\x{9fa5}\w\-]|-)+/iu', '-', $text);
        $string = trim($string,'-');
        $segList = explode('-',$string);
        foreach($segList as $v){
            $words[strlen($v)] = $v;
        }
        ksort($words);
        $str = array_pop($words);
        return strlen($str);
    }

    public function suggest()
    {
        $content = file_get_contents($this->domain);
        $msg = array();
        if(!$this->isHttps()){
            $msg[] = "<p>建议使用HTTPS协议，将更加安全。</p>";
        }
        if(stristr($content,'dedecms')!==false){
            $msg[] = "<p>首页出现织梦特征：dedecms，建议删除</p>";
        }

        $header=get_headers($this->domain.'/member/');
        if(strstr($header[0],'200')!==false){
            $msg[] = "<p>如果没有用到会员部分，建议删除member文件夹</p>";
        }
        $header=get_headers($this->domain.'/special/');
        if(strstr($header[0],'200')!==false){
            $msg[] = "<p>如果没有用到专题，建议删除special文件夹</p>";
        }
        $header=get_headers($this->domain.'/plus/guestbook.php');
        if(strstr($header[0],'200')!==false){
            $msg[] = "<p>强烈建议删除/plus/guestbook.php文件及/plus/guestbook文件夹</p>";
        }
        $header=get_headers($this->domain.'/plus/advancedsearch.php');
        if(strstr($header[0],'200')!==false){
            $msg[] = "<p>/plus/advancedsearch.php（高级搜索），建议删除</p>";
        }
        $header=get_headers($this->domain.'/plus/arcmulti.php');
        if(strstr($header[0],'200')!==false){
            $msg[] = "<p>/plus/arcmulti.php（异步方式调用指定的tag列表），建议删除</p>";
        }
        $header=get_headers($this->domain.'/plus/bookfeedback.php');
        if(strstr($header[0],'200')!==false){
            $msg[] = "<p>/plus/bookfeedback.php（图书评论），建议删除</p>";
        }
        $header=get_headers($this->domain.'/plus/bookfeedback_js.php');
        if(strstr($header[0],'200')!==false){
            $msg[] = "<p>/plus/bookfeedback_js.php（图书评论调用文件），建议删除</p>";
        }
        $header=get_headers($this->domain.'/plus/flink.php');
        if(strstr($header[0],'200')!==false){
            $msg[] = "<p>/plus/flink.php（友情链接），建议删除</p>";
        }
        $header=get_headers($this->domain.'/plus/flink_add.php');
        if(strstr($header[0],'200')!==false){
            $msg[] = "<p>/plus/flink_add.php（友情链接），建议删除</p>";
        }
        $header=get_headers($this->domain.'/plus/heightsearch.php');
        if(strstr($header[0],'200')!==false){
            $msg[] = "<p>/plus/heightsearch.php（高级搜索），建议删除</p>";
        }
        $header=get_headers($this->domain.'/plus/recommend.php');
        if(strstr($header[0],'200')!==false){
            $msg[] = "<p>/plus/recommend.php（信息推荐），建议删除</p>";
        }
        $header=get_headers($this->domain.'/plus/showphoto.php');
        if(strstr($header[0],'200')!==false){
            $msg[] = "<p>/plus/showphoto.php（显示图片），建议删除</p>";
        }
        $header=get_headers($this->domain.'/plus/stow.php');
        if(strstr($header[0],'200')!==false){
            $msg[] = "<p>/plus/showphoto.php（收藏文章），建议删除</p>";
        }
        $header=get_headers($this->domain.'/plus/task.php');
        if(strstr($header[0],'200')!==false){
            $msg[] = "<p>/plus/task.php（计划任务），建议删除</p>";
        }
        $header=get_headers($this->domain.'/plus/vote.php');
        if(strstr($header[0],'200')!==false){
            $msg[] = "<p>/plus/vote.php（投票），建议删除</p>";
        }
        $header=get_headers($this->domain.'/plus/erraddsave.php');
        if(strstr($header[0],'200')!==false){
            $msg[] = "<p>/plus/erraddsave.php（文章找错），建议删除</p>";
        }

        return $msg;
    }

    /*
    * 检测链接是否是SSL连接
    * @return bool
    */
    private function isHttps(){
        if(!isset($_SERVER['HTTPS']))
            return FALSE;
        if($_SERVER['HTTPS'] === 1){  //Apache
            return TRUE;
        }elseif($_SERVER['HTTPS'] === 'on'){ //IIS
            return TRUE;
        }elseif($_SERVER['SERVER_PORT'] == 443){ //其他
            return TRUE;
        }
        return FALSE;
    }

    private function getsize($size, $format = 'kb') {
        $p = 0;
        if ($format == 'kb') {
            $p = 1;
        } elseif ($format == 'mb') {
            $p = 2;
        } elseif ($format == 'gb') {
            $p = 3;
        }
        $size /= pow(1024, $p);
        return number_format($size, 3);
    }

    function setLastRank($rank)
    {
        $txt = DEDEDATA.'/module/dedesafe.txt';
        if(!file_exists($txt))
        {
            $fp = fopen($txt,'w');
            $tData['rank'] = $rank;
            $tData['time'] = date('Y-m-d H:i:s');
            fwrite($fp,serialize($tData));
            fclose($fp);
        }else{
            $tData['rank'] = $rank;
            $tData['time'] = date('Y-m-d H:i:s');
            $fp = fopen($txt,'w');
            fwrite($fp,serialize($tData));
            fclose($fp);
        }
    }
}
class FindFile
{

    public $files = array();    // 存储遍历的文件
    protected $maxdepth;        // 搜寻深度,0表示没有限制


    /*  遍历文件及文件夹
    *   @param String $spath     文件夹路径
    *   @param int    $maxdepth  搜寻深度,默认搜寻全部
    */
    public function process($spath, $maxdepth=0){
        if(isset($maxdepth) && is_numeric($maxdepth) && $maxdepth>0){
            $this->maxdepth = $maxdepth;
        }else{
            $this->maxdepth = 0;
        }
        $this->files = array();
        $this->traversing($spath); // 遍历
    }


    /*  遍历文件及文件夹
    *   @param String $spath 文件夹路径
    *   @param int    $depth 当前文件夹深度
    */
    private function traversing($spath, $depth=1){
        if($handle = opendir($spath)){
            while(($file=readdir($handle))!==false){
                if($file!='.' && $file!='..'){
                    $curfile = $spath.'/'.$file;
                    $curfile = str_replace('\\','/',$curfile);
                    if(is_dir($curfile)){ // dir
                        if($this->maxdepth==0 || $depth<$this->maxdepth){ // 判断深度
                            $this->traversing($curfile, $depth+1);
                        }
                    }else{  // file
                        $this->handle($curfile);
                    }

                }
            }
            closedir($handle);
        }
    }


    /** 处理文件方法
     *  @param String $file 文件路径
     */
    protected function handle($file){
        array_push($this->files, $file);
    }

} // class end
class UnsetBom extends FindFile{ // class start

    private $filetype = array(); // 需要处理的文件类型


    // 初始化
    public function __construct($filetype=array()){
        if($filetype){
            $this->filetype = $filetype;
        }
    }


    /** 重写FindFile handle方法
     *   @param  String $file 文件路径
     */
    protected function handle($file){
        if($this->check_ext($file)){
            if($this->check_utf8bom($file)) $this->clear_utf8bom($file);        // clear
            array_push($this->files, $file);    // save log
        }
    }


    /** 检查文件是否utf8+bom
     *   @param  String $file 文件路径
     *   @return boolean
     */
    private function check_utf8bom($file){
        $content = file_get_contents($file);
        return ord(substr($content,0,1))===0xEF && ord(substr($content,1,1))===0xBB && ord(substr($content,2,1))===0xBF;
    }


    /** 清除utf8+bom
     *   @param String $file 文件路径
     */
    private function clear_utf8bom($file){
        $content = file_get_contents($file);
        file_put_contents($file, substr($content,3), true); // 去掉头三个字节
    }


    /** 检查文件类型
     *   @param  String $file 文件路径
     *   @return boolean
     */
    private function check_ext($file){
        $arr = explode('.',basename($file));
        $ext = array_pop($arr);
        $file_ext = strtolower($ext);
        if(in_array($file_ext, $this->filetype)){
            return true;
        }else{
            return false;
        }
    }

} // class end