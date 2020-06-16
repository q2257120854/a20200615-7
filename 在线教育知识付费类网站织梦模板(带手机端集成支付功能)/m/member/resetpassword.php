<?php

/**

 * 密码重设

 * 

 * @version        $Id: resetpassword.php 1 8:38 2010年7月9日Z tianya $

 * @package        DedeCMS.Member

 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.

 * @license        http://help.dedecms.com/usersguide/license.html

 * @link           http://www.yunziyuan.com.cn

 */

require_once(dirname(__FILE__)."/config.php");

require_once("inc/inc_pwd_functions.php");

if(empty($dopost)) $dopost = "";

$id = isset($id)? intval($id) : 0;

if($cfg_ml->IsLogin())

{

    ShowMsg('你已经登陆系统', 'index.php');

    exit();

}

if($dopost == "")

{

    include(dirname(__FILE__)."/templets/resetpassword.htm");

}

elseif($dopost == "getpwd")

{



    /*/验证验证码

    if(!isset($vdcode)) $vdcode = '';



    $svali = GetCkVdValue();

    if(strtolower($vdcode) != $svali || $svali=='')

    {

        ResetVdValue();

        ShowMsg("对不起，验证码输入错误！","-1");

        exit();

    }*/

		//互亿无线代码 www.ihuyi.com start

         if(strlen($mobilecode) < 1 && $is_reg == "Y")

        {

            ShowMsg('手机验证码不能为空', '-1');

            exit();

        } 

		

         if($mobilecode != $_COOKIE['mobile_codec']  && $is_reg == "Y")

        {

            ShowMsg('手机验证码不正确', '-1');

            exit();

        }   

      //   ShowMsg($mobilecode.'手机验证码OK'.$_COOKIE['mobile_codec'] , '-1');

        //    exit();		

	    //互亿无线代码 www.ihuyi.com end

		



    //验证邮箱，用户名

    if(empty($userid))

    {

        showmsg('对不起，请输入手机号', '-1');

        exit;

    }else if (CheckUserID($userid, '', false) != 'ok')

    {

        ShowMsg("你输入的用户名 {$userid} 不合法！","-1");

        exit();

    }

    $member = member($mail, $userid);



    //以邮件方式取回密码；

    if($type == 1)

    {

        //判断系统邮件服务是否开启

        if($cfg_sendmail_bysmtp == "Y")

        {

            sn($member['mid'],$userid,$member['email']);

        }else

        {

            showmsg('对不起邮件服务暂未开启，请联系管理员', 'login.php');

            exit();

        }



        //以安全问题取回密码；

    } else if ($type == 2)

    {

        if($member['safequestion'] == 0)

        {

            showmsg('对不起您尚未设置安全密码，请通过邮件方式重设密码', 'login.php');

            exit;

        }

        require_once(dirname(__FILE__)."/templets/resetpassword3.htm");

    }

    exit();

}

else if($dopost == "safequestion")

{

    $mid = preg_replace("#[^0-9]#", "", $id);

    $sql = "SELECT safequestion,safeanswer,userid,email FROM #@__member WHERE mid = '$mid'";

    $row = $db->GetOne($sql);

    if(empty($safequestion)) $safequestion = '';



    if(empty($safeanswer)) $safeanswer = '';



    if($row['safequestion'] == $safequestion && $row['safeanswer'] == $safeanswer)

    {

        sn($mid, $row['userid'], $row['email'], 'N');

        exit();

    }

    else

    {

        ShowMsg("对不起，您的安全问题或答案回答错误","-1");

        exit();

    }



}

else if($dopost == "getpasswd")

{

		



    //验证邮箱，用户名

    if(empty($userid))

    {

        showmsg('对不起，请输入手机号', '-1');

        exit;

    }

	else if (CheckUserID($userid, '', false) != 'ok')

    {

        ShowMsg("你输入的用户名 {$userid} 不合法！","-1");

        exit();

    }

    /*/修改密码

    if(empty($id))

    {

        ShowMsg("对不起，请不要非法提交","login.php");

        exit();

    }*/

   // $mid = preg_replace("#[^0-9]#", "", $id);

    $row = $db->GetOne("SELECT * FROM #@__member WHERE userid = '$userid'");

    if(empty($row))

    {

        ShowMsg("对不起，请不要非法提交","-1");

        exit();

    }

    if(empty($setp))

    {//互亿无线代码 www.ihuyi.com start

         if(strlen($mobilecode) < 1 && $is_reg == "Y")

        {

            ShowMsg('手机验证码不能为空', '-1');

            exit();

        } 

		

         if($mobilecode != $_COOKIE['mobile_codec']  && $is_reg == "Y")

        {

            ShowMsg('手机验证码不正确', '-1');

            exit();

        }   

      //   ShowMsg($mobilecode.'手机验证码OK'.$_COOKIE['mobile_codec'] , '-1');

        //    exit();		

	    //互亿无线代码 www.ihuyi.com end

       /* $tptim= (60*60*24*3);

        $dtime = time();

        if($dtime - $tptim > $row['mailtime'])

        {

            $db->executenonequery("DELETE FROM `#@__pwd_tmp` WHERE `md` = '$id';");

            ShowMsg("对不起，临时密码修改期限已过期","login.php");

            exit();

        }*/

        require_once(dirname(__FILE__)."/templets/resetpassword2.htm");

    }

    elseif($setp == 2)

    {

        if(isset($key)) $pwdtmp = $key;



        $sn = md5(trim($pwdtmp));

 if(strlen($mobilecode) < 1 && $is_reg == "Y")

        {

            ShowMsg('手机验证码不能为空', '-1');

            exit();

        } 

		

         if($mobilecode != $_COOKIE['mobile_codec']  && $is_reg == "Y")

        {

            ShowMsg('手机验证码不正确', '-1');

            exit();

        }   

            if($pwd != "")

            {

                if($pwd == $pwd)

                {

                    $pwd = md5($pwd);

                    $sql = "UPDATE `#@__member` SET `pwd` = '$pwd' WHERE `userid` = '$userid';";

                    if($db->executenonequery($sql))

                    {

                        showmsg('密码设置成功', 'login.php');

                        exit;

                    }

                }

            }

            showmsg('对不起，新密码为空或填写不一致', '-1');

            exit;

    

    }

}