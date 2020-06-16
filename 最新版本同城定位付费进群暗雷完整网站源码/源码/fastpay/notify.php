<?php
require_once('../system/incs.php');


//加载fastpay支付插件

if (!function_exists('get_openid')) {
    require $_SERVER['DOCUMENT_ROOT'].'/fastpay/Fast_Cofig.php';
}

$sign=$_POST['sign_notify'];//获取签名2.07版,2.07以下请使用$sign=$_POST['sign'];
$check_sign=notify_sign($_POST);
if ($sign!=$check_sign) {
    exit("签名失效");
    //签名计算请查看怎么计算签名,或者下载我们的SDK查看
}

$uid         = $_POST['uid'];//支付用户
$total_fee   = $_POST['total_fee'];//支付金额
$pay_title   = $_POST['pay_title'];//标题
$sign        = $_POST['sign'];//签名
$order_no    = $_POST['order_no'];//订单号
$me_pri      = $_POST['me_pri'];//我们网站生成的金额,参与签名的,跟实际金额有差异

$me_param      = $_POST['me_param'];

$time=date("Y-m-d H:i:s");

$me_param = explode("|", $me_param);

$uid=$me_param[0];
$vid=$me_param[1];


$user=get_user_id($uid);
$qje=$user['rmb'];
$je=$me_pri;
$hje=bcadd($qje, $je, 2);
$remark="用户打赏|金额{$je}|资源ID{$vid}";


/*
mysql_query("UPDATE ".flag."order  SET payprice='{$total_fee}',zt='1',pdate='{$time}' WHERE dingdanhao='{$order_no}'");


mysql_query("INSERT INTO ".flag."rmbjl (type, uid, qje,je,hje,remark,date)
VALUES ('1', '{$uid}', '{$qje}' , '{$je}' , '{$hje}' , '{$remark}' , '{$time}'   )");

mysql_query("UPDATE ".flag."user  SET rmb='{$hje}' WHERE ID='{$uid}'");


echo "success";

*/


function get_user_id($id)
{
    $call=array();
    $sqltext  = "select * from ".flag."user  where ID='".$id."' ";
    $res       =  mysql_query($sqltext);
    while (!!$rs1=mysql_fetch_array($res)) {
        $call[]=$rs1;
    }
    $call=(empty($sql)) ? $call[0] : $call;
    return $call;
}


$dingdan=$order_no;
$money     =   floatval($je);//订单金额  能用到
$dingdan		=	$order_no; //自己网站上订单的订单号  能用到

$out_trade_no = $_POST['order_no'];
$trade_no = $_POST['trade_no'];


function userkouliangsl($uid, $zt)
{
    //$zt = 0未扣量  1 已扣量
    $result = mysql_query('select  count(*) as sl  from '.flag.'order where uid = '.$uid.'  and  zt = 1  and kouliang  = '.$zt.' ');
    if (!!($row = mysql_fetch_array($result))) {
        if ($row['sl']!='') {
            return $row['sl'];
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}





 function kouliangorder($uid)
 {
     $result = mysql_query('select  count(*) as sl  from '.flag.'kouliangorder where uid = '.$uid.'   ');
     if (!!($row = mysql_fetch_array($result))) {
         if ($row['sl']!='') {
             return $row['sl'];
         } else {
             return 0;
         }
     } else {
         return 0;
     }
 }



   $results = mysql_query('select * from '.flag.'order where  dingdanhao="'.$dingdan.'"  ');
$rows = mysql_fetch_array($results);
{

  //查询是否有扣量条件

  if (empty($rows['uid'])) {
      $sql = 'update '.flag.'order set jiaoyihao=  "'.$trade_no.'",zt=1,payprice='.$money.',pdate="'.date('Y-m-d H:i:s').'"   where dingdanhao="'.$out_trade_no.'"  ';
      mysql_query($sql);
      echo "success";
      exit();
  }


$shangjiid=get_user('shangji', $rows['uid']);
if (empty($shangjiid)) {
    $sql = 'update '.flag.'order set jiaoyihao=  "'.$trade_no.'",zt=1,payprice='.$money.',pdate="'.date('Y-m-d H:i:s').'"   where dingdanhao="'.$out_trade_no.'"  ';
    mysql_query($sql);

mysql_query("INSERT INTO ".flag."rmbjl (type, uid, qje,je,hje,remark,date)
VALUES ('1', '{$uid}', '{$qje}' , '{$je}' , '{$hje}' , '{$remark}' , '{$time}'   )");
mysql_query("UPDATE ".flag."user  SET rmb='{$hje}' WHERE ID='{$uid}'");


    echo "success";
    exit();
}
 //查询是否有扣量条件
     $checkkl = mysql_query('select * from '.flag.'kouliang where  uid='.$rows['uid'].'  ');
if ($ckrow = mysql_fetch_array($checkkl)) {
    $ifkouliang=1;
//die('有扣量');
} else {
    $ifkouliang=0;
    //die($row['uid'].'没有扣量');
}
 //用户上级
   $shangjiid=get_user('shangji', $rows['uid']);
 //上级提成
   $shangjitc=(get_user('ticheng', $shangjiid)/100);
   //上级提成金额
   $shangjiticheng=$money*$shangjitc;


   //用户扣量条件值
  $kouliangnum=get_kouliang('num', $rows['uid']);
   //用户扣量值
  $kouliangnums=get_kouliang('nums', $rows['uid']);
  //条件达到这个数开始执行
  $shijizhi=$kouliangnum-$kouliangnums;
 //获取未扣量过的订单数量
 $weikouliangnum=userkouliangsl($rows['uid'], 0);
 //获取已扣量过的订单数量
 $yikouliangnum=userkouliangsl($rows['uid'], 1);

 //获取扣量订单表里的数量
  $kordersl=kouliangorder($rows['uid']);

 if ($shangjiid>0) {
     $shijidashangje=$money-$shangjiticheng;
 } else {
     $shijidashangje=$money;
 }


   if ($kordersl==$kouliangnums) {
       $kouchu=0;
       $dksql = 'delete from '.flag.'kouliangorder   where uid = '.$rows['uid'].' ';
       mysql_query($dksql);

       if ($shangjiid>0) {
           $_sjrmbdata['uid'] = $shangjiid;
           $_sjrmbdata['type'] = 1;// 0扣除1增加;
           $_sjrmbdata['qje'] = get_user('rmb', $shangjiid);
           $_sjrmbdata['je'] = $shangjiticheng;
           $_sjrmbdata['hje'] = get_user('rmb', $shangjiid)+$shangjiticheng;
           $_sjrmbdata['remark'] = '下级打赏提成|金额:'.$shangjiticheng.'';
           $_sjrmbdata['date'] =date('Y-m-d H:i:s');
           $sjrmbstr = arrtoinsert($_sjrmbdata);
           $sjrmbsql = 'insert into '.flag.'rmbjl ('.$sjrmbstr[0].') values ('.$sjrmbstr[1].')';
           mysql_query($sjrmbsql);
           $sjusersql = 'update '.flag.'user set rmb= rmb+'.$shangjiticheng.'   where ID='.$shangjiid.'  ';
           mysql_query($sjusersql);
       }



       $_rmbdata['uid'] = $rows['uid'];
       $_rmbdata['type'] = 1;// 0扣除1增加;
       $_rmbdata['qje'] = get_user('rmb', $rows['uid']);
       $_rmbdata['je'] = $shijidashangje;
       $_rmbdata['hje'] = get_user('rmb', $rows['uid'])+$shijidashangje;
       $_rmbdata['remark'] = '用户打赏|金额:'.$shijidashangje.'|资源ID:'.$rows['vid'].'';
       $_rmbdata['date'] =date('Y-m-d H:i:s');
       $rmbstr = arrtoinsert($_rmbdata);
       $rmbsql = 'insert into '.flag.'rmbjl ('.$rmbstr[0].') values ('.$rmbstr[1].')';
       mysql_query($rmbsql);
       $usersql = 'update '.flag.'user set rmb= rmb+'.$shijidashangje.'   where ID='.$rows['uid'].'  ';
       mysql_query($usersql);
   } else {
       $kouchu=1;
   }

  //是否需要继续扣掉
  if ($kordersl==0) {
      $jixukou=0;
  }  // 不需要继续扣
  else {
      $jixukou=1;
  }//需要继续扣}


if ($jixukou==1 && $kouchu==1 && $ifkouliang==1) {
    //继续扣掉这笔订单
    $kouliang=1;
    $kouliangsql = 'update '.flag.'order set kouliang=1 where uid = '.$rows['uid'].' ';
    mysql_query($kouliangsql);

    $klsql = 'update '.flag.'order set kl=1 where dingdanhao = "'.$rows['dingdanhao'].'" ';
    mysql_query($klsql);

    $_kldata['uid'] =$rows['uid'];
    $_kldata['dingdanhao'] =$rows['dingdanhao'];
    $_kldata['laiyuan'] ='继续扣掉';
    $klstr = arrtoinsert($_kldata);
    $ksql = 'insert into '.flag.'kouliangorder ('.$klstr[0].') values ('.$klstr[1].')';
    mysql_query($ksql);
}



  //满足扣量条件
 if ($weikouliangnum==$shijizhi && $ifkouliang==1) {
     //扣掉这笔订单
     $kouliang=1;
     $kouliangsql = 'update '.flag.'order set kouliang=1 where uid = '.$rows['uid'].' ';
     mysql_query($kouliangsql);

     $klsql = 'update '.flag.'order set kl=1 where dingdanhao = "'.$rows['dingdanhao'].'" ';
     mysql_query($klsql);

     $_kldata['uid'] =$rows['uid'];
     $_kldata['dingdanhao'] =$rows['dingdanhao'];
     $_kldata['laiyuan'] ='满足条件扣';
     $klstr = arrtoinsert($_kldata);
     $ksql = 'insert into '.flag.'kouliangorder ('.$klstr[0].') values ('.$klstr[1].')';
     mysql_query($ksql);
 } else {
     $kouliang=0;
 }


   if ($kouliang==0 && $jixukou==0) {
       if ($shangjiid>0) {
           $_sjrmbdata['uid'] = $shangjiid;
           $_sjrmbdata['type'] = 1;// 0扣除1增加;
           $_sjrmbdata['qje'] = get_user('rmb', $shangjiid);
           $_sjrmbdata['je'] = $shangjiticheng;
           $_sjrmbdata['hje'] = get_user('rmb', $shangjiid)+$shangjiticheng;
           $_sjrmbdata['remark'] = '下级打赏提成|金额:'.$shangjiticheng.'';
           $_sjrmbdata['date'] =date('Y-m-d H:i:s');
           $sjrmbstr = arrtoinsert($_sjrmbdata);
           $sjrmbsql = 'insert into '.flag.'rmbjl ('.$sjrmbstr[0].') values ('.$sjrmbstr[1].')';
           mysql_query($sjrmbsql);
           $sjusersql = 'update '.flag.'user set rmb= rmb+'.$shangjiticheng.'   where ID='.$shangjiid.'  ';
           mysql_query($sjusersql);
       }



       $_rmbdata['uid'] = $rows['uid'];
       $_rmbdata['type'] = 1;// 0扣除1增加;
       $_rmbdata['qje'] = get_user('rmb', $rows['uid']);
       $_rmbdata['je'] = $shijidashangje;
       $_rmbdata['hje'] = get_user('rmb', $rows['uid'])+$shijidashangje;
       $_rmbdata['remark'] = '用户打赏|金额:'.$shijidashangje.'|资源ID:'.$rows['vid'].'';
       $_rmbdata['date'] =date('Y-m-d H:i:s');
       $rmbstr = arrtoinsert($_rmbdata);
       $rmbsql = 'insert into '.flag.'rmbjl ('.$rmbstr[0].') values ('.$rmbstr[1].')';
       mysql_query($rmbsql);
       $usersql = 'update '.flag.'user set rmb= rmb+'.$shijidashangje.'   where ID='.$rows['uid'].'  ';
       mysql_query($usersql);
   }

}

$sql = 'update '.flag.'order set jiaoyihao=  "'.$ddh.'",zt=1,payprice='.$shijidashangje.',pdate="'.date('Y-m-d H:i:s').'"   where dingdanhao="'.$dingdan.'"  ';
 mysql_query($sql);

echo "success";//返回成功
