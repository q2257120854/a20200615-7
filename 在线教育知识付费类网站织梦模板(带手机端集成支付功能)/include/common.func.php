<?php



/**



 * 系统核心函数存放文件



 * @version        $Id: common.func.php 4 16:39 2010年7月6日Z tianya $



 * @package        DedeCMS.Libraries



 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.



 * @license        http://help.dedecms.com/usersguide/license.html



 * @link           http://www.yunziyuan.com.cn



 */



if(!defined('DEDEINC')) exit('dedecms');







if (version_compare(PHP_VERSION, '7.0.0', '>='))



{



    if (!function_exists('mysql_connect') AND function_exists('mysqli_connect')) {



        function mysql_connect($server, $username, $password)



        {



            return mysqli_connect($server, $username, $password);



        }



    }







    if (!function_exists('mysql_query') AND function_exists('mysqli_query')) {



        function mysql_query($query, $link)



        {



            return mysqli_query($link, $query);



        }



    }







    if (!function_exists('mysql_select_db') AND function_exists('mysqli_select_db')) {



        function mysql_select_db($database_name, $link)



        {



            return mysqli_select_db($link, $database_name);



        }



    }







    if (!function_exists('mysql_fetch_array') AND function_exists('mysqli_fetch_array')) {



        function mysql_fetch_array($result)



        {



            return mysqli_fetch_array($result);



        }



    }







    if (!function_exists('mysql_close') AND function_exists('mysqli_close')) {



        function mysql_close($link)



        {



            return mysqli_close($result);



        }



    }



    if (!function_exists('split')) {



        function split($pattern, $string){



            return explode($pattern, $string);



        }



    }



}











/**



 *  载入小助手,系统默认载入小助手



 *  在/data/helper.inc.php中进行默认小助手初始化的设置



 *  使用示例:



 *      在开发中,首先需要创建一个小助手函数,目录在\include\helpers中



 *  例如,我们创建一个示例为test.helper.php,文件基本内容如下:



 *  <code>



 *  if ( ! function_exists('HelloDede'))



 *  {



 *      function HelloDede()



 *      {



 *          echo "Hello! Dede...";



 *      }



 *  }



 *  </code>



 *  则我们在开发中使用这个小助手的时候直接使用函数helper('test');初始化它



 *  然后在文件中就可以直接使用:HelloDede();来进行调用.



 *



 * @access    public



 * @param     mix   $helpers  小助手名称,可以是数组,可以是单个字符串



 * @return    void



 */



$_helpers = array();



function helper($helpers)



{



    //如果是数组,则进行递归操作



    if (is_array($helpers))



    {



        foreach($helpers as $dede)



        {



            helper($dede);



        }



        return;



    }







    if (isset($_helpers[$helpers]))



    {



        return;



    }



    if (file_exists(DEDEINC.'/helpers/'.$helpers.'.helper.php'))



    {



        include_once(DEDEINC.'/helpers/'.$helpers.'.helper.php');



        $_helpers[$helpers] = TRUE;



    }



    // 无法载入小助手



    if ( ! isset($_helpers[$helpers]))



    {



        exit('Unable to load the requested file: helpers/'.$helpers.'.helper.php');



    }



}







function dede_htmlspecialchars($str) {



    global $cfg_soft_lang;



    if (version_compare(PHP_VERSION, '5.4.0', '<')) return htmlspecialchars($str);



    if ($cfg_soft_lang=='gb2312') return htmlspecialchars($str,ENT_COMPAT,'ISO-8859-1');



    else return htmlspecialchars($str);



}







/**



 *  控制器调用函数



 *



 * @access    public



 * @param     string  $ct    控制器



 * @param     string  $ac    操作事件



 * @param     string  $path  指定控制器所在目录



 * @return    string



 */



function RunApp($ct, $ac = '',$directory = '')



{







    $ct = preg_replace("/[^0-9a-z_]/i", '', $ct);



    $ac = preg_replace("/[^0-9a-z_]/i", '', $ac);







    $ac = empty ( $ac ) ? $ac = 'index' : $ac;



	if(!empty($directory)) $path = DEDECONTROL.'/'.$directory. '/' . $ct . '.php';



	else $path = DEDECONTROL . '/' . $ct . '.php';







	if (file_exists ( $path ))



	{



		require $path;



	} else {



		 if (DEBUG_LEVEL === TRUE)



        {



            trigger_error("Load Controller false!");



        }



        //生产环境中，找不到控制器的情况不需要记录日志



        else



        {



            header ( "location:/404.html" );



            die ();



        }



	}



	$action = 'ac_'.$ac;



    $loaderr = FALSE;



    $instance = new $ct ( );



    if (method_exists ( $instance, $action ) === TRUE)



    {



        $instance->$action();



        unset($instance);



    } else $loaderr = TRUE;







    if ($loaderr)



    {



        if (DEBUG_LEVEL === TRUE)



        {



            trigger_error("Load Method false!");



        }



        //生产环境中，找不到控制器的情况不需要记录日志



        else



        {



            header ( "location:/404.html" );



            die ();



        }



    }



}







/**



 *  载入小助手,这里用户可能载入用helps载入多个小助手



 *



 * @access    public



 * @param     string



 * @return    string



 */



function helpers($helpers)



{



    helper($helpers);



}



//兼容php4的file_put_contents



if(!function_exists('file_put_contents'))



{



    function file_put_contents($n, $d)



    {



        $f=@fopen($n, "w");



        if (!$f)



        {



            return FALSE;



        }



        else



        {



            fwrite($f, $d);



            fclose($f);



            return TRUE;



        }



    }



}



/**

 *  显示更新信息

 *

 * @return    void

 */

function UpdateStat()

{

    include_once(DEDEINC."/inc/inc_stat.php");

    return SpUpdateStat();

}



$arrs1 = array(0x63,0x66,0x67,0x5f,0x70,0x6f,0x77,0x65,0x72,0x62,0x79);

$arrs2 = array(0x20,0x3c,0x61,0x20,0x68,0x72,0x65,0x66,0x3d,0x68,0x74,0x74,0x70,0x3a,0x2f,0x2f,

0x77,0x77,0x77,0x2e,0x64,0x65,0x64,0x65,0x63,0x6d,0x73,0x2e,0x63,0x6f,0x6d,0x20,0x74,0x61,0x72,

0x67,0x65,0x74,0x3d,0x27,0x5f,0x62,0x6c,0x61,0x6e,0x6b,0x27,0x3e,0x50,0x6f,0x77,0x65,0x72,0x20,

0x62,0x79,0x20,0x44,0x65,0x64,0x65,0x43,0x6d,0x73,0x3c,0x2f,0x61,0x3e);



/**

 *  短消息函数,可以在某个动作处理后友好的提示信息

 *

 * @param     string  $msg      消息提示信息

 * @param     string  $gourl    跳转地址

 * @param     int     $onlymsg  仅显示信息

 * @param     int     $limittime  限制时间

 * @return    void

 */



function ShowMsg($msg, $gourl, $onlymsg=0, $limittime=0)

{

	//echo GetCookie("DedeUserID");

	//echo $_COOKIE["DedeUserID"];

	//die();

	

    if(empty($GLOBALS['cfg_plus_dir'])) $GLOBALS['cfg_plus_dir'] = '..';

$htmlhead  = "<!DOCTYPE html>\r\n<html>\r\n<head>\r\n<title>信息提示</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\">\r\n<meta name=\"renderer\" content=\"webkit\">

<style type=\"text/css\">

*{padding:0;margin:0;}

body{font-size:14px;font-weight:normal;color:#333;background:#fff;}

ul,li{list-style:none;}

img{border:none;}

a{color:#333;text-decoration:none;}

a:active{color:#ffcc00;}

a:focus{outline:0;}

a:hover{text-decoration:none;color:#35B558;}

#status{overflow:hidden;max-width:320px;margin:0 auto;}

#preloader{margin:50px auto;padding:15px;}

#preloader .center-yxw-img{margin:0 auto;display:block;}

.center-text{color:#666;line-height:26px;font-size:16px;padding-top:20px;text-align:center;overflow:hidden;}

.likx{width:48%;display:block;line-height:40px;background:#D4310C;float:left;text-align:center;color:#fff;margin:20px 0;border-radius:20px;font-size:14px;}

.likx2{width:48%;display:block;line-height:40px;background:#1FBD46;float:right;text-align:center;color:#fff;border-radius:20px;margin:20px 0;font-size:14px;}

.center-text a:hover{color:#fff;}

</style>\r\n";



    $htmlhead .= "</head>\r\n<body>".(isset($GLOBALS['ucsynlogin']) ? $GLOBALS['ucsynlogin'] : '')."\r\n<script>\r\n";



    $htmlfoot  = "</body>\r\n</html>\r\n";







    $litime = ($limittime==0 ? 1000 : $limittime);



    $func = '';







    if($gourl=='-1')



    {



        if($limittime==0) $litime = 1000;



        $gourl = "javascript:history.go(-1);";



    }







    if($gourl=='' || $onlymsg==1)



    {



        $msg = "<script>alert(\"".str_replace("\"","“",$msg)."\");</script>";



    }



    else



    {



        //当网址为:close::objname 时, 关闭父框架的id=objname元素



        if(preg_match('/close::/',$gourl))



        {



            $tgobj = trim(preg_replace('/close::/', '', $gourl));



            $gourl = 'javascript:;';



            $func .= "window.parent.document.getElementById('{$tgobj}').style.display='none';\r\n";



        }

		

		

		

		if(strpos($_SERVER['HTTP_USER_AGENT'],'APICloud') !== false){

		

        $event = '';

		if(strpos($gourl,'member') !== false  || strpos($msg,'意见反馈成功') !== false){ 

               $event = 'api.execScript({name: "root",script: "set_userid('.$_COOKIE["DedeUserID"].')"}); api.sendEvent({name : "reg_login",extra : "member"})'; 

         }

		if(strpos($gourl,'loginback=2') !== false){ 

               $event = 'api.sendEvent({name : "reg_login",extra : 2})'; 

         }

		 if(strpos($gourl,'loginback=5') !== false){ 

               $event = 'api.sendEvent({name : "reg_login",extra : 5})'; 

         }

		  if(strpos($gourl,'loginback=3') !== false){ 

               $event = 'api.sendEvent({name : "reg_login",extra : 3})'; 

         }

		 

		 

           $func .= " 

	   var pgo=0;

      function JumpUrl(){

        if(pgo==0){ location='$gourl'; pgo=1; }

      }\r\n

	  

	  apiready = function(){

		  

	  $event  

	  setTimeout('JumpUrl()',$litime);

	  

	  };

	  

	  

	  \r\n</script>\r\n";



	                  $rmsg .= "";

        

		}else{

		

        $func .= "      var pgo=0;



      function JumpUrl(){



        if(pgo==0){ location='$gourl'; pgo=1; }



      }\r\nsetTimeout('JumpUrl()',$litime);\r\n</script>\r\n";



	                  $rmsg .= "";



     }



        $rmsg = $func;



        /*$rmsg .= "document.write(\"<br /><div style='width:450px;padding:0px;border:1px solid #DADADA;'>";



        $rmsg .= "<div style='padding:6px;font-size:12px;border-bottom:1px solid #DADADA;background:#DBEEBD url({$GLOBALS['cfg_plus_dir']}/img/wbg.gif)';'><b>融儿信息科技提示！</b></div>\");\r\n";



        $rmsg .= "document.write(\"<div style='height:130px;font-size:10pt;background:#ffffff'><br />\");\r\n";



        $rmsg .= "document.write(\"".str_replace("\"","“",$msg)."\");\r\n";



        $rmsg .= "document.write(\"";*/



              //暂时注释 by hainabaike.com $rmsg .= "document.write(\"<div id='preloader' style='    position: fixed;



$rmsg .= "<div id='preloader'>

<div id='status'>

<img src='http://www.test.com/images/loading.jpg' class='center-yxw-img'>

<p class='center-text'>".str_replace("\"","“",$msg)."";

          if($onlymsg==0)



        {



            if( $gourl != 'javascript:;' && $gourl != '')



            {



           $rmsg .= " ";



          $rmsg .= "</p>



    </div>

    </div>\r\n";



            }



            else



            {



          $rmsg .= "</p>



    </div>

    </div>\r\n";



            }



        }



        else



        {



          $rmsg .= "</p>



    </div>

    </div>\r\n";



        }







        $msg  = $htmlhead.$rmsg.$htmlfoot;



    }



    echo $msg;



}







/**



 *  获取验证码的session值



 *



 * @return    string



 */



function GetCkVdValue()



{



	@session_id($_COOKIE['PHPSESSID']);



    @session_start();



    return isset($_SESSION['securimage_code_value']) ? $_SESSION['securimage_code_value'] : '';



}







/**



 *  PHP某些版本有Bug，不能在同一作用域中同时读session并改注销它，因此调用后需执行本函数



 *



 * @return    void



 */



function ResetVdValue()



{



    @session_start();



    $_SESSION['securimage_code_value'] = '';



}











// 自定义函数接口



// 这里主要兼容早期的用户扩展,v5.7之后我们建议使用小助手helper进行扩展



if( file_exists(DEDEINC.'/extend.func.php') )



{



    require_once(DEDEINC.'/extend.func.php');



}



//获取顶级栏目名 



function GetTopTypename($id) 



{ 



global $dsql; 



$row = $dsql->GetOne("SELECT typename,topid FROM dede_arctype WHERE id= $id"); 



if ($row['topid'] == '0') 



{ 



return $row['typename']; 



} 



else 



{ 



$row1 = $dsql->GetOne("SELECT typename FROM dede_arctype WHERE id= $row[topid]"); 



return $row1['typename']; 



} 



} 











//获取顶级栏目SEOTITLE 



function GetTopseotitle($id) 



{ 



global $dsql; 



$row = $dsql->GetOne("SELECT seotitle,topid FROM dede_arctype WHERE id= $id"); 



if ($row['topid'] == '0') 



{ 



return $row['seotitle']; 



} 



else 



{ 



$row1 = $dsql->GetOne("SELECT seotitle FROM dede_arctype WHERE id= $row[topid]"); 



return $row1['seotitle']; 



} 



} 







function pasterTempletDiy($path)



{



  require_once(DEDEINC."/arc.partview.class.php");



  global $cfg_basedir,$cfg_templets_dir;



  $tmpfile = $cfg_basedir.$cfg_templets_dir."/".$path;//模版文件的路径



  $dtp = new PartView();



  $dtp->SetTemplet($tmpfile);



  $dtp->Display();



}









//获取课程文章数

function GetTotalArc($tid){

    global $dsql;

    $arr = $dsql->GetOne("select count(id) as dd  from #@__arctiny where typeid = '$tid' and arcrank > -2");

    if(empty($arr['dd'])){$arr['dd'] = "O";}

    return $arr['dd'];

}

