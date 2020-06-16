<?php
 require("include/global.php");
 include("include/option.php");
 $action = isset($_GET['action']) ? addslashes($_GET['action']) : '';

  //用户注册
 if($action == 'register'){
 	$name = isset($_POST['name']) ? addslashes($_POST['name']) : '';
	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
	$password = isset($_POST['password']) ? addslashes($_POST['password']) : '';
	$uuid = isset($_POST['uuid']) ? addslashes($_POST['uuid']) : '';
	$aqcode = isset($_POST['aqcode']) ? addslashes($_POST['aqcode']) : '';
	$superpass = isset($_POST['superpass']) ? addslashes($_POST['superpass']) : '';
	$inv = isset($_POST['inv']) ? addslashes($_POST['inv']) : '0';
	$regdate = time();
	$regip = getIp();
	$regcode = isset($_POST['regcode']) ? addslashes($_POST['regcode']) : '';
	if($username == '') exit("+101+");
	if($password == '') exit('+102+');
	//	if($aqcode == '') exit('+103+');
	//if($regcode == '') exit('+104+');
	$sql="select * from eruyi_user where username='$username'";
	$query=$db->query($sql);
	$have=$db->fetch_array($query);
	if($have) exit('+105+');
	if($iptime != 0){
        $regtime = $regdate-$iptime;
		$sql="select * from eruyi_user where regip='$regip' and `regdate`>'$regtime'";
		$query=$db->query($sql);
		$have=$db->fetch_array($query);
		if($have) exit('+106+');
	}
	if($codetime != 0){
        $regtime = $regdate-$codetime;
		$sql="select * from eruyi_user where uuid='$uuid' and `regdate`>'$regtime'";
		$query=$db->query($sql);
		$have=$db->fetch_array($query);
		if($have) exit('+107+');
	}
	$result = file_get_contents("https://api.uomg.com/api/rand.img1?format=json");
	$arr=json_decode($result,true);
	if ($arr['code']==1) {
	    //$pic= $arr['imgurl'];
      $pic='pic/tx.png';
	} else {
	    $pic='pic/tx.png';
	}
	if ($inv != 0){
		$sql="select * from eruyi_user where uid='$inv'";
		$query=$db->query($sql);
		$have=$db->fetch_array($query);
        //$regcode2=$have['uuid'];
        $number=$have['number'];
        if ($number + 1 ==$dqrenshu ){
            $zjtime=$zstime;
        }elseif ($number + 1==$dqrenshu2){
                $zjtime=$zstime2;
        }else {
                $zjtime=0;   
        }
       // if($uuid == $regcode2) exit('+109+');
		if ($have){
			if ($invvip != 0){
				if ($regdate > $have['vip']){
                     if ($have['vip'] !='999999999' && $have['vip'] !='888888888'){
					     $vip = $regdate + $invvip + $zjtime;
					     $sql = "UPDATE `eruyi_user` SET `vip`='$vip',`number`=`number`+ '1' WHERE uid='$inv'";
                     }else {
                           $sql = "UPDATE `eruyi_user` SET `number`=`number`+ '1' WHERE uid='$inv'";
                     } 
			    }else {
				       $sql = "UPDATE `eruyi_user` SET `vip`=`vip`+ $invvip + $zjtime,`number`=`number`+ '1' WHERE uid='$inv'";
			    }
		    	$query=$db->query($sql);
			  }
		 }else {
		    exit('+108+');
		 }           
	   }
	
	$pass = md5($password);
	if ($regvip == 0){
		$vip = 0;
	}else {
//          $sql="select * from eruyi_user where uuid='$uuid'";
//	      $query=$db->query($sql);
//	      $have=$db->fetch_array($query);
//	      if($have){
  //                  $vip = 0; 不然注册不送时间
 //         }else {
			  //if ($inv != 0){
     //                  $sql1="select * from eruyi_user where uid='$inv'";
		   //            $query1=$db->query($sql1);
		   //            $have1=$db->fetch_array($query1);
		   //            $regcode3=$have1['uuid'];
		   //            if($regcode == $regcode3) exit('+109+');
		   //            if ($have1){
     //                      $vip = $regdate + $invvip + $regvip;
     //                  }else {
     //                      $vip = 0; 
     //                  }
 //               }else {
	             $vip = $regdate + $regvip;
			   //  }
  //         }      
	}
	$sql="INSERT INTO `eruyi_user`(`name`,`username`, `password`, `inv`,`number`, `vip`, `superpass`, `money`, `regdate`, `regip`, `regcode`,`lock`,`uuid`,`aqcode`,`pic`) VALUES ('$name','$username','$pass','$inv','0','$vip','$superpass','0','$regdate','$regip','$regcode','n','$uuid','$aqcode','$pic')";
	$query=$db->query($sql);
	if($query){
		exit('+200+');
	}
 }
 
 //用户登陆
 if($action == 'login'){
	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
	$password = isset($_POST['password']) ? addslashes($_POST['password']) : '';
	$logcode = isset($_POST['logcode']) ? addslashes($_POST['logcode']) : '';
	if($username == '') exit('+101+');
	if($password == '') exit('+102+');
	//if($logcode == '') exit('+104+');
	$pass = md5($password);
	$sql="select * from eruyi_user where username='$username' and `password`='$pass'";
	$query=$db->query($sql);
	$have=$db->fetch_array($query);
	if($have){
		//if($have['regcode']!=$logcode) exit('+108+');
		if($have['lock']=='y') exit('+112+');
		$token = md5(getcode());
		$sql="UPDATE `eruyi_user` SET `online`='$token' WHERE username='$username'";
		$query=$db->query($sql);
		if($query){
			$udata = array(
				'uid'=>$have['uid'],
				'pic'=>$have['pic'],
				'name'=>$have['name'],
				'vip'=>$have['vip'],
				'token'=>$token
			);
			$jdata = json_encode($udata);
			echo $jdata;
			exit;
		}
	}else{
		exit('+110+');
	}
 }
 
 //修改机器码
 if($action == 'editcode'){
	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
	$superpass = isset($_POST['superpass']) ? addslashes($_POST['superpass']) : '';
	$newcode = isset($_POST['newcode']) ? addslashes($_POST['newcode']) : '';
	if($username == '') exit('+101+');
	if($superpass == '') exit('+103+');
	//if($newcode == '') exit('+104+');
	$sql="select * from eruyi_user where username='$username' and `superpass`='$superpass'";
	$query=$db->query($sql);
	$have=$db->fetch_array($query);
	if(!$have) exit('+123+');
	$now = time();
	if($have['codetime']+24*3600 > $now) exit('+124+');
	$sql="UPDATE `eruyi_user` SET `regcode`='$newcode',`codetime`='$now' WHERE username='$username'";
	$query=$db->query($sql);
	if($query){
		exit('+200+');
	}
 }
 
 //提交邀请码
 if($action == 'invitecode'){
	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
	$inv = isset($_POST['inv']) ? addslashes($_POST['inv']) : '';
        if($username == '') exit('+101+');
	if($inv == '') exit('+102+');
        $regdate = time();
        $sql="select * from eruyi_user where uid='$inv'";
        $query=$db->query($sql);
        $have=$db->fetch_array($query);
        $ip1=$have['regcode'];
        $number=$have['number'];
               if ($number + 1 ==$dqrenshu){
                           $zjtime=$zstime;
                   }elseif ($number + 1 ==$dqrenshu2){
                              $zjtime=$zstime2;
                       }else {
                            $zjtime=0;   
                           }
        if(!$have) exit('+103+');
        if ($have){
            $sql="select * from eruyi_user where username='$username'";
	    $query=$db->query($sql);
	    $have=$db->fetch_array($query);  
            $ip2=$have['regcode'];
            if ($ip1 == $ip2) exit('+107+');
            //if(!$have) exit('+104+');
            if($have['inv']=='0'){
                       if (time() > $have['vip']){
                             if ($have['vip'] !='999999999' && $have['vip'] !='888888888' ){
                                            $sql="UPDATE `eruyi_user` SET `inv`='$inv',`vip`= $invvip WHERE username='$username'"; 
                                        }else {
                                            $sql="UPDATE `eruyi_user` SET `inv`='$inv'WHERE username='$username'"; 
                                              }
                                 }else {
                                        $sql="UPDATE `eruyi_user` SET `inv`='$inv',`vip`=`vip`+ $invvip WHERE username='$username'";
                                        } 
	                   $query=$db->query($sql);
                           if(!$query) exit('+106+');
	                   if($query){
                              if ($invvip != 0){
			            if (time() > $have['vip']){
                                           if ($have['vip'] !='999999999' && $have['vip'] !='888888888' ){
					            $vip = $regdate + $invvip;
					            $sql = "UPDATE `eruyi_user` SET `vip`='$vip' + $zjtime,`number`=`number`+ '1' WHERE uid='$inv'";
                                               }else {
                                                     $sql = "UPDATE `eruyi_user` SET `number`=`number`+ '1' WHERE uid='$inv'";
                                                      } 
			              }else {
				           $sql = "UPDATE `eruyi_user` SET `vip`=`vip`+ $invvip +$zjtime ,`number`=`number`+ '1' WHERE uid='$inv'";
				           }
				$query=$db->query($sql);
			      }
		             exit('+200+');
	                          }        
                           }
                           exit('+105+');
                    }	
 }

 //找回密码
 if($action == 'findpass'){
	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
	$newpass = isset($_POST['newpass']) ? addslashes($_POST['newpass']) : '';
	$superpass = isset($_POST['superpass']) ? addslashes($_POST['superpass']) : '';
	if($username == '') exit('+101+');
	if($superpass == '') exit('+103+');
	if($newpass == '') exit('+102+');
	$sql="select * from eruyi_user where username='$username' and `superpass`='$superpass'";
	$query=$db->query($sql);
	$have=$db->fetch_array($query);
	if(!$have) exit('+123+');
	$pass = md5($newpass);
	$sql="UPDATE `eruyi_user` SET `password`='$pass' WHERE username='$username'";
	$query=$db->query($sql);
	if($query){
		exit('+200+');
	}
 }
 


 //卡密升级
 if($action == 'checkkami'){
	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
	$kami = isset($_POST['kami']) ? addslashes($_POST['kami']) : '';
	if($username == '') exit('+101+');
	if($kami == '') exit('+130+');
	$sql="select * from eruyi_kami where kami='$kami'";
	$query=$db->query($sql);
	$khave=$db->fetch_array($query);
	if(!$khave) exit('+131+');
	if($khave['new']!='y') exit('+132+');
	$sql="select * from eruyi_user where username='$username'";
	$query=$db->query($sql);
	$uhave=$db->fetch_array($query);
	if(!$uhave) exit('+133+');
                if($khave['type'] =='YJKK' | $khave['type'] =='YJK' ){
                     if($uhave['vip'] == '888888888' && $khave['type'] =='YJKK'){
                            exit('+140+');
                     }elseif($uhave['vip'] == '888888888' && $khave['type'] =='YJK'){
                            exit('+140+');
                     }elseif($uhave['vip'] == '999999999' && $khave['type'] =='YJK'){
                            exit('+134+');
                     }
                }else{
                     if($uhave['vip'] == '888888888'){
                            exit('+140+');
                     }elseif($uhave['vip'] == '999999999' ){
                            exit('+134+');
                     }
                }
	$KMtime = array(
		'TK'=>24*3600,
		'ZK'=>7*24*3600,
		'YK'=>30*24*3600,
		'BNK'=>180*24*3600,
		'NK'=>365*24*3600
	);
	$KMtype = $khave['type'];
	if($uhave['vip']>time()){
		if($KMtype == 'YJK'){
			$sql="UPDATE `eruyi_user` SET `vip`='999999999' WHERE username='$username'";
                                }elseif($KMtype == 'YJKK'){
                                                $sql="UPDATE `eruyi_user` SET `vip`='888888888' WHERE username='$username'";
		}else{
			$sql="UPDATE `eruyi_user` SET `vip`=`vip`+$KMtime[$KMtype] WHERE username='$username'";
		}
	}else{
		if($KMtype == 'YJK'){
			$vip = '999999999';
                                }elseif($KMtype == 'YJKK'){
                                                $vip = '888888888';
		}else{
			$vip = time()+$KMtime[$KMtype];
		}
		$sql="UPDATE `eruyi_user` SET `vip`='$vip' WHERE username='$username'";
	}
	$query=$db->query($sql);
	if($query){
		$date = time();
		$sql="UPDATE `eruyi_kami` SET `new`='n',`username`='$username',`date`='$date' WHERE kami='$kami'";
		$query=$db->query($sql);
		if($query) exit('+200+');
	}else{
		exit('+135+');
	}
 }
 
 //在线充值  json_decode组   json_encode值
 if($action == 'checkzaixian'){
	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';	
	$tianshu = isset($_POST['tianshu']) ? addslashes($_POST['tianshu']) : '';	
	$ddh = isset($_POST['ddh']) ? addslashes($_POST['ddh']) : '';	
	if($username == '') exit('+101+');	
	if($tianshu == '') exit('+130+');
        $sql="select * from eruyi_user where yzfddh='$ddh' ";
	$query=$db->query($sql);
	while($rows=$db->fetch_array($query)){
		 $udata = array(
            'yzfddh'=>$rows['yzfddh'],
            );
	}
	 if(!empty($udata)){
		 $jdata1 = json_encode($udata);
		$jdata=	 json_decode($jdata1);
		 $dd = $jdata->yzfddh;
           
	 }
	 
	 if(  $dd== ''){
	 $sql="UPDATE `eruyi_user` SET `yzfddh`=$ddh WHERE username='$username'";
		$query=$db->query($sql);
	 $url=$yzfurl.'/api.php?act=order&pid='.$yzfid.'&key='.$yzfkey.'&out_trade_no='.$ddh;
 $obj = json_decode( file_get_contents($url));
  $msg = $obj->status;
  
                if ($msg == "1") {
	            $sql="select * from eruyi_user where username='$username'";
	            $query=$db->query($sql);
	            $uhave=$db->fetch_array($query);
	            if(!$uhave) exit('+133+');
                            if($tianshu =='888888888' | $tianshu =='999999999' ){
                                    if($uhave['vip'] == '888888888' && $tianshu =='888888888'){
                                         exit('+140+');
                                    }elseif($uhave['vip'] == '888888888' && $tianshu =='999999999'){
                                         exit('+140+');
                                    }elseif($uhave['vip'] == '999999999' && $tianshu =='999999999'){
                                         exit('+134+');
                                    }
                            }else{
                                    if($uhave['vip'] == '888888888'){
                                         exit('+140+');
                                    }elseif($uhave['vip'] == '999999999'){
                                         exit('+134+');
                                    }
                              }
                            if($uhave['vip']>time()){
                                     if($tianshu == '999999999' | $tianshu == '888888888' ){
			$sql="UPDATE `eruyi_user` SET `vip`=$tianshu WHERE username='$username'";
	                     }else{
			$sql="UPDATE `eruyi_user` SET `vip`=`vip`+ $tianshu WHERE username='$username'";
		      }

                            }else{
                                     if($tianshu == '999999999' | $tianshu == '888888888' ){
			$vip = $tianshu;
                                     }else{
			$vip = time()+$tianshu;
                                    }
	                     $sql="UPDATE `eruyi_user` SET `vip`='$vip' WHERE username='$username'";
                            }
                            $query=$db->query($sql);
	            if($query){
	                    if($query) exit('+200+');
	            }else{
	                    exit('+135+');
	            }
                }else{
	      exit('+136+');
                      exit(getcode());
                }  
		}else{
		

}
	 
 }

 //获取信息
 if($action == 'getinfo'){
	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
	$token = isset($_POST['token']) ? addslashes($_POST['token']) : '';
	if($username == '') exit('+101+');
	if($token == '') exit('+150+');
	$sql="select * from eruyi_user where username='$username' and `online`='$token'";
	$query=$db->query($sql);
	$have=$db->fetch_array($query);
	if($have){
		$udata = array(
			'uid'=>$have['uid'],
			'pic'=>$have['pic'],
			'name'=>$have['name'],
			'vip'=>$have['vip'],
			'money'=>$have['money'],
			'regdate'=>$have['regdate'],
			'regip'=>$have['regip'],
			'regcode'=>$have['regcode'],
			'lock'=>$have['lock'],
			'online'=>$have['online'],
            'inv'=>$have['inv'],
           'is_admin'=>$have['is_admin'],
			'number'=>$have['number']
		);
		$jdata = json_encode($udata);
		echo $jdata;
		exit;
	}else{
		exit('+151+');
	}
 }
 
  //修改名称
 if($action == 'altername'){
  	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
	$token = isset($_POST['token']) ? addslashes($_POST['token']) : '';
	$name = isset($_POST['name']) ? addslashes($_POST['name']) : '';
	if($username == '') exit('+101+');
	if($token == '') exit('+150+');
	if($name == '') exit('+130+');
	$sql="select * from eruyi_user where username='$username' and `online`='$token'";
	$query=$db->query($sql);
	$have=$db->fetch_array($query);
	if($have){
		$sql="UPDATE `eruyi_user` SET `name` = '$name' WHERE `eruyi_user`.`username` = '$username' and `online`='$token'";
		$query=$db->query($sql);
		if($query) exit('+200+');
	}else {
	    exit('+151+');
	}
  }
 

   //上传头像
 if($action == 'alterpic'){
 	$type = isset($_GET['type']) ? addslashes($_GET['type']) : '';
	$token = isset($_GET['token']) ? addslashes($_GET['token']) : '';
	if($type == '') exit('160');
	if($token == '') exit('150');
	$sql="select * from eruyi_user where online ='$token'";
	$query=$db->query($sql);
	$have=$db->fetch_array($query);
	if($have){
		$user = $have['uid'];
	}else{
		exit('151');
	}
	$local_path  = "./pic/";
	if (!file_exists($local_path)) mkdir($local_path);
		if ($type == 'e4a'){
			$target_path = $local_path.$user.".png";
			$result = move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
			$pic = substr( $target_path,1);
		}elseif ($type == 'bbp'){
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    			foreach ( $_FILES as $name=>$file ) {
        			$fn=$file['name'];
					$ft=strrpos($fn,'.',0);
        			$fe=substr($fn,$ft);
        			$fp='pic/'.$user.$fe;
        			$result = move_uploaded_file($file['tmp_name'],$fp);
					$pic = "/" . $fp;
    			}
			}else{
    			exit('161');
		}
	}else{
		exit('162');
	}
	if($result) {
		$sql= "UPDATE `eruyi_user` SET `pic` = '$pic' WHERE `eruyi_user`.`online`='$token'";
		$query=$db->query($sql);
		if($query){
			exit('200');
		} else {
			exit('163');
		}
    } else{
        exit('162');
    }
  }
   
   
    
  //修改密码
 if($action == 'modify'){
	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
	$aqcode = isset($_POST['aqcode']) ? addslashes($_POST['aqcode']) : '';
	$newpass = isset($_POST['newpass']) ? addslashes($_POST['newpass']) : '';
	if($username == '') exit('+101+');
	if($aqcode == '') exit('+102+');
	if($newpass == '') exit('+141+');

	$sql="select * from eruyi_user where username='$username' and `aqcode`='$aqcode'";
	$query=$db->query($sql);
	$have=$db->fetch_array($query);
	if($have){
		$npass = md5($newpass);
		$sql="UPDATE `eruyi_user` SET `password`='$npass',`aqcode`='$aqcode' WHERE username='$username'";
		$query=$db->query($sql);
		if($query){
			exit('+200+');
		}
	}else{
		exit('+110+');
	}
 }



   //生成卡密
 if($action == 'generate'){
 	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
	$token = isset($_POST['token']) ? addslashes($_POST['token']) : '';
                $num = isset($_POST['num']) ? addslashes($_POST['num']) : '';
	$type = isset($_POST['type']) ? addslashes($_POST['type']) : '';
	if($username == '') exit('+101+');
	if($token == '') exit('+102+');
                if($num == '') exit('+103+');
	//if($type == '') exit('+104+');
                $sql="select * from eruyi_user where username='$username'";
	$query=$db->query($sql);
	$have=$db->fetch_array($query);
                if(!$have) exit('+105+');
	if($have['vip'] == '888888888'){
                                $str = '';
		for($i=1;$i<=$num;$i++){
		    $key=getcode();
		    $sql="INSERT INTO `eruyi_kami`(`kami`, `type`, `generate`) VALUES ('$key','$type','$username')";
		    $query=$db->query($sql);
		    $str .= $key . "-";
	                }
                           exit("+$str+");
	}else {
	    exit('+151+');
	}
  }

                
                
                
                
     
   
   
   
  //获取单个后台视频
 if($action == 'shipin'){
	$name = isset($_GET['name']) ? addslashes($_GET['name']) : '';
 	$shipfl = isset($_GET['shipfl']) ? addslashes($_GET['shipfl']) : '';
	$page=isset($_GET['page']) ? addslashes($_GET['page']) : 1;
    $enums=30;  //每页显示的条目数 
    $av_url = $_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"]);
    $bnums=($page-1)*$enums;
	if($name != ''){
         $sql="select * from shipin_data where name like '%$name%' order by id desc limit $bnums,$enums";
    }else{
         $sql="select * from shipin_data where shipfl='$shipfl' order by id desc limit $bnums,$enums";
    }
    
	$query=$db->query($sql);
	while($rows=$db->fetch_array($query)){
		 $udata = array(
            'name'=>$rows['name'],
            'src'=>$rows['src'],
            'href'=>$rows['href'],
            'txt'=>$rows['txt'],  
			'time'=>$rows['time'],
            'shipfl'=>$rows['shipfl']
            );
	  $contents[] = $udata;
	}
	 if(!empty($contents)){
		 $jdata1 = json_encode($contents);
	                $jdata = 'number="'.count($contents).'"'.$jdata1;
                                echo 'brC46jF'.base64_encode($jdata);
	 }
	 
  }

  

   //获取后台视频
 if($action == 'qbsp'){
 	$shipfl = isset($_GET['shipfl']) ? addslashes($_GET['shipfl']) : '';
    $av_url = $_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"]);
   
    if($shipfl != ''){
        $sql="select * from shipin_data where shipfl='$shipfl' ";
        }else{
    $sql="select * from shipin_data ";
       }
       
//	if($name != ''){
       //  $sql="select * from shipin_data where name like '%$name%' order by id desc limit $bnums,$enums";
 //   }else{
           //  $sql="select * from shipin_data ";    }
   
	$query=$db->query($sql);
	while($rows=$db->fetch_array($query)){
		 $udata = array(
            'name'=>$rows['name'],
            'src'=>$rows['src'],
            'href'=>$rows['href'],
            'txt'=>$rows['txt'],  
			'time'=>$rows['time'],
            'shipfl'=>$rows['shipfl']
            );
	  $contents[] = $udata;
	}
	 if(!empty($contents)){
		 $jdata1 = json_encode($contents);
	                $jdata = 'number="'.count($contents).'"'.$jdata1;
	           //    echo $jdata;
                       echo 'brC46jF'.base64_encode($jdata);
	 }
	 
  }

   //在线留言 
 if($action == 'message'){
 	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
 	$txt = isset($_POST['txt']) ? addslashes($_POST['txt']) : '';
 	$token = isset($_POST['token']) ? addslashes($_POST['token']) : '';
	if($username == '') exit('+101+');
	if($txt == '') exit('+102+');
	if($token == '') exit('+103+');
	$time=time();
                $sql="select * from eruyi_user where username='$username' and online='$token'";
	$query=$db->query($sql);
	$have=$db->fetch_array($query);
                if($have){
                      $sql="select * from cl_message where username='$username'";
	      $query=$db->query($sql);
	      $have=$db->fetch_array($query);
                      if($have){
                               $sql="UPDATE `cl_message` SET `txt`='$txt',`time`='$time',`hftxt`='' WHERE username='$username'";
	      }else {
	               $sql="INSERT INTO `cl_message`(`username`, `txt`, `time`) VALUES ('$username','$txt','$time')";
	      }
	      $query=$db->query($sql);
	      if($query){
		exit('+200+');
	      }
	}//else { exit('+104+'); }
  }
 if($action == 'admin'){
   $username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
   $token = isset($_POST['token']) ? addslashes($_POST['token']) : '';
   if($username == '') exit('101');
   if($token == '') exit('103');
   $charge = isset($_POST['charge']) ? addslashes($_POST['charge']) : '';
   $banben = isset($_POST['banben']) ? addslashes($_POST['banben']) : '';
   $qq = isset($_POST['qq']) ? addslashes($_POST['qq']) : '';
   $qunkey = isset($_POST['qunkey']) ? addslashes($_POST['qunkey']) : '';
   $dizhi = isset($_POST['dizhi']) ? addslashes($_POST['dizhi']) : '';
   $tcgonggaoid = isset($_POST['tcgonggaoid']) ? addslashes($_POST['tcgonggaoid']) : '';
   $tcgonggao = isset($_POST['tcgonggao']) ? addslashes($_POST['tcgonggao']) : '';
   $tcgonggaots = isset($_POST['tcgonggaots']) ? addslashes($_POST['tcgonggaots']) : '';
   $gonggao = isset($_POST['gonggao']) ? addslashes($_POST['gonggao']) : '';
    $sql="UPDATE `eruyi_peizhi` SET `charge`='$charge',`banben`='$banben',`qq`='$qq',`tcgonggao`='$tcgonggao',`qunkey`='$qunkey',`dizhi`='$dizhi',`tcgonggaots`='$tcgonggaots',`gonggao`='$gonggao',`tcgonggaoid`='$tcgonggaoid' WHERE id='1'";
    $query=$db->query($sql);
   if($query){
   		exit('200');
   }else{
   		exit('400');
   }
 }
   //查询留言 
 if($action == 'cxmessage'){
 	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
 	$token = isset($_POST['token']) ? addslashes($_POST['token']) : '';
	if($username == '') exit('+101+');
	if($token == '') exit('+102+');
                $sql="select * from eruyi_user where username='$username' and online='$token'";
	$query=$db->query($sql);
	$have=$db->fetch_array($query);
                if($have){
                                $sql="select * from cl_message where username='$username'";
	                $query=$db->query($sql);
	                $have=$db->fetch_array($query);
                                if($have){
		       $udata = array(
			'results'=>'ok',
			'title'=>$have['txt'],
			'time'=>gmdate("Y-m-d",$have['time']+8*3600),
			'content'=>$have['hftxt'],
			'hftime'=>gmdate("Y-m-d",$have['hftime']+8*3600),
		       );
		$jdata = json_encode($udata);
		echo $jdata;
		exit;
	                }
	}//else { exit('+104+'); }
  }

  //做任务增加余额
   if($action == 'addbalance'){
  	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
	$token = isset($_POST['token']) ? addslashes($_POST['token']) : '';
	if($username == '') exit('+101+');
	if($token == '') exit('+150+');
	$sql="select * from eruyi_user where username='$username' and `online`='$token'";
	$query=$db->query($sql);
	$have=$db->fetch_array($query);
	if($have){
		$uptime = $have['addyuetime'];
		$yue = $have['money'];
		$uptime = $uptime + 86400;
		$time = time();
		if($uptime > $time){
			exit('+已增加余额+');//此前已添加余额
		}else{
			$sql="select * from eruyi_peizhi where id=1";
	        $query=$db->query($sql);
	        $have1=$db->fetch_array($query);
			$add2 = $have1['addyue'];
			$yue = $yue + $add2;
			$sql="UPDATE `eruyi_user` SET `money` = '$yue',`addyuetime` = '$time' WHERE `username` = '$username'";
		    $query=$db->query($sql);
		    if($query) exit('+200+');//成功添加余额
		}
	}else {
	    exit('+151+');
	}
  }
  
  
  //余额充值会员 10余额 = 24 小时 即 时间戳 加 86400
   if($action == 'yuevip'){
  	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
	$token = isset($_POST['token']) ? addslashes($_POST['token']) : '';
	$tian = isset($_POST['tian']) ? addslashes($_POST['tian']) : '';//充值天数
	if($username == '') exit('+101+');
	if($token == '') exit('+150+');
	if($tian == '') exit('+150+');
	$sql="select * from eruyi_user where username='$username' and `online`='$token'";
	$query=$db->query($sql);
	$have=$db->fetch_array($query);
	if($have){
		$yue = $have['money'];
		$vip = $have['vip'];
		$tianj = $tian * 10;
		if($yue < $tianj){
			exit('+余额不足+');//此前已添加余额
		}else{
			if($vip < time()){
			   $vip = time();
			}
			$viptime = $tian * 86400;
			$vip = $vip + $viptime;
			$yue = $yue - $tianj;
			$sql="UPDATE `eruyi_user` SET `money` = '$yue',`vip` = '$vip' WHERE `username` = '$username'";
		    $query=$db->query($sql);
		    if($query) exit('+200+');//成功充值vip
		}
	}else {
	    exit('+151+');
	}
  }
  
  //用户自定义参数接口  参数 name = 参数名 content = 参数值
  
  if($action == 'usercustom'){
  	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
	$token = isset($_POST['token']) ? addslashes($_POST['token']) : '';
	$name = isset($_POST['name']) ? addslashes($_POST['name']) : '';
	$content = isset($_POST['content']) ? addslashes($_POST['content']) : '';
	if($username == '') exit('+101+');
	if($token == '') exit('+150+');
	if($name == '') exit('+101+');
	if($content == '') exit('+150+');
	$sql="select * from eruyi_user where username='$username' and `online`='$token'";
	$query=$db->query($sql);
	$have=$db->fetch_array($query);
	if($have){
			$sql="UPDATE `eruyi_user` SET `".$name."`='$content' WHERE `username` = '$username'";
		    $query=$db->query($sql);
		    if($query) exit('+200+');//成功添加余额
	}else {
	    exit('+151+');
	}
  }
  
  //社区发帖
   
   
  if($action == 'userbbstzpost'){
	  
	 
  	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
	$token = isset($_POST['token']) ? addslashes($_POST['token']) : '';
	$title = isset($_POST['title']) ? addslashes($_POST['title']) : '';
	$content = isset($_POST['content']) ? addslashes($_POST['content']) : '';
	$num = isset($_POST['num']) ? addslashes($_POST['num']) : '';
	if($username == '')  exit("[1]{账号空}");
	if($token == '')  exit("[1]{秘钥空}");
	
	if($title == '')  exit("[1]{标题空}");
	if($content == '')  exit("[1]{内容空}");
	$imgurl = "";
	$path = "upload/";
	if (!file_exists($path)) {
        mkdir($path,0700);
    }
	
    switch ($num)
	{
	case "1":
	    if ($_FILES["img1"]["size"] > 1048577){
	        exit("[1]{对不起,请上传小于1M的图片}");
	    }
	    $sha = sha1_file($_FILES['img1']['tmp_name']);
        $path= $path.$sha.".png";
	    if(move_uploaded_file($_FILES['img1']['tmp_name'],$path)) { 
	        
		} else {
		    exit("[1]{上传失败}");
	    }
        $imgurl = "@".$path."|";
		
 		break;  	
	case "2":
	    
	    if ($_FILES["img1"]["size"] > 1048577){
	        exit("[1]{对不起,请上传小于1M的图片}");
	    }
	    if ($_FILES["img2"]["size"] > 1048577){
	        exit("[1]{对不起,请上传小于1M的图片}");
	    }
		
	    $path = "upload/";
	    $sha = sha1_file($_FILES['img1']['tmp_name']);
        $path= $path.$sha.".png";
	    if(file_exists($path)){
		
	    }else{
	        if(move_uploaded_file($_FILES['img1']['tmp_name'],$path)) { 
	        
			} else {
		         exit("[1]{上传失败}");
	        }
	    }
		 $imgurl = "@".$path."|";
		 
	    $path = "upload/";
	    $sha = sha1_file($_FILES['img2']['tmp_name']);
        $path= $path.$sha.".png";
	    if(file_exists($path)){
		
	    }else{
	        if(move_uploaded_file($_FILES['img2']['tmp_name'],$path)) { 
	        
			} else {
		         exit("[1]{上传失败}");
	        }
	    }
        $imgurl = $imgurl."@".$path."|";
 	    break;  
	case "3":
	    
	    if ($_FILES["img1"]["size"] > 1048577){
	        exit("[1]{对不起,请上传小于1M的图片}");
	    }
	    if ($_FILES["img2"]["size"] > 1048577){
	        exit("[1]{对不起,请上传小于1M的图片}");
	    }
	    if ($_FILES["img3"]["size"] > 1048577){
	        exit("[1]{对不起,请上传小于1M的图片}");
	    }
		
		
	    $path = "upload/";
	    $sha = sha1_file($_FILES['img1']['tmp_name']);
        $path= $path.$sha.".png";
	    if(file_exists($path)){
		
	    }else{
	        if(move_uploaded_file($_FILES['img1']['tmp_name'],$path)) { 
	        
			} else {
		         exit("[1]{上传失败}");
	        }
	    }
		 $imgurl = "@".$path."|";
		 
	    $path = "upload/";
	    $sha = sha1_file($_FILES['img2']['tmp_name']);
        $path= $path.$sha.".png";
	    if(file_exists($path)){
		
	    }else{
	        if(move_uploaded_file($_FILES['img2']['tmp_name'],$path)) { 
	        
			} else {
		         exit("[1]{上传失败}");
	        }
	    }
        $imgurl = $imgurl."@".$path."|";
	
	    $path = "upload/";
	    $sha = sha1_file($_FILES['img3']['tmp_name']);
        $path= $path.$sha.".png";
	    if(file_exists($path)){
		
	    }else{
	        if(move_uploaded_file($_FILES['img3']['tmp_name'],$path)) { 
	        
			} else {
		         exit("[1]{上传失败}");
	        }
	    }
        $imgurl = $imgurl."@".$path."|";
		
        break;  
		
	}	
	
	$sql="select * from eruyi_user where username='$username' and `online`='$token'";
	$query=$db->query($sql);
	$have=$db->fetch_array($query);
	if($have){
		    $time = time();
			$sql="INSERT INTO `bbspost`(`userid`, `time`, `title`, `content`, `img`) VALUES ('$username','$time','$title','$content','$imgurl')";
		    $query=$db->query($sql);
		    if($query)  exit("[0]{}");;//成功发布帖子
	}else {
	    exit("[1]{登录验证失败}");//登录验证失败
	}
  }
  
  //发布评论
   if($action == 'userbbsplpost'){
  	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
	$token = isset($_POST['token']) ? addslashes($_POST['token']) : '';
	$id = isset($_POST['id']) ? addslashes($_POST['id']) : '';
	$content = isset($_POST['content']) ? addslashes($_POST['content']) : '';
	if($username == '') exit('+101+');
	if($token == '') exit('+150+');
	if($content == '') exit('+102+');
	//if($id == '') exit('+104+');
	$sql="select * from eruyi_user where username='$username' and `online`='$token'";
	$query=$db->query($sql);
	$have=$db->fetch_array($query);
	if($have){
		    $time = time();
			$sql="INSERT INTO `bbscomment`(`userid`, `time`, `bbsid`, `content`) VALUES ('$username','$time','$id','$content')";
		    $query=$db->query($sql);
			
		    if($query) echo("[0]{}");//成功评论帖子
			   $sql = "select `comnum` from bbspost where id = '$id' limit 1";
	           $query=$db->query($sql);
	           $py = $db->fetch_array($query);
	           $comnum = $py['comnum'];
			   $comnum = $comnum + 1;
			   $sql="UPDATE `bbspost` SET `comnum`='$comnum' WHERE id= '$id'";
			   $query=$db->query($sql);
			
	}else {
	    exit("[1]{登录验证失败}");//登录验证失败
	}
  }
  
  
   //帖子列表展示 输出 json对象数组 //用户无需登录 每次输出20条
  
  if($action == 'usergetbbslist'){
	//i + 20;
	$new = isset($_POST['new']) ? addslashes($_POST['new']) : '';
	$type = isset($_POST['type']) ? addslashes($_POST['type']) : '';
	if($type == "2"){
		 $sql = "select `id`,`userid`,`time`,`title`,`content`,`img`,`del` from bbspost order by time desc limit " . $new . ",20";
	}else{
		 $sql = "select `id`,`userid`,`time`,`title`,`content`,`img`,`del` from bbspost order by comnum desc limit " . $new . ",20";
	}
	
	$query=$db->query($sql);
	$res=array("content"=>array());
	
	
	
	while ($py = mysql_fetch_array($query)) {
	      $sql= "select * from eruyi_user where username = '".$py['userid']."' limit 1";
	      $query1=$db->query($sql);
	      $have1=$db->fetch_array($query1);
	      $img = $have1['pic'];
		  $name = $have1['name'];
		  $time = $py['time'];
		  $title = $py['title'];
		  $content = $py['content'];
		  $postimg = $py['img'];
		  $id = $py['id'];
	      $info = array("id"=>$id,"img"=>$img,"name"=>$name,"time"=>$time,"title"=>$title,"content"=>$content,"postimg"=>$postimg);
          array_push($res['content'],$info);	
	}
	echo json_encode($res);
  }
  
 //获取评论列表 
if($action == 'usergetpllist'){
	//i + 20;
	$new = isset($_POST['new']) ? addslashes($_POST['new']) : '';
	$id = isset($_POST['id']) ? addslashes($_POST['id']) : '';
	
    $sql = "select `userid`,`time`,`content`,`del` from bbscomment where bbsid = '$id' order by time desc limit " . $new . ",20";
	$query=$db->query($sql);
	$res=array("content"=>array());
	while ($py = mysql_fetch_array($query)) {
	    if($py['del'] !== "0"){
	      $sql= "select * from eruyi_user where username = '".$py['userid']."' limit 1";
	      $query1=$db->query($sql);
	      $have1=$db->fetch_array($query1);
	      $img = $have1['pic'];
		  $name = $have1['name'];
		  $time = $py['time'];
		  $content = $py['content'];
	      $info = array("img"=>$img,"name"=>$name,"time"=>$time,"content"=>$content);
          array_push($res['content'],$info);	
	    }
	}
	echo json_encode($res);
  }
  
   //获取帖子详情 
if($action == 'usergettz'){
	$id = isset($_POST['id']) ? addslashes($_POST['id']) : '';
    $sql = "select `userid`,`time`,`title`,`content`,`img`,`del` from bbspost where id = '$id' limit 1";
	$query=$db->query($sql);
	$py = $db->fetch_array($query);
	if($py['del'] !== "0"){
	      $sql= "select * from eruyi_user where username = '".$py['userid']."' limit 1";
	      $query=$db->query($sql);
	      $have1=$db->fetch_array($query);
	      $img = $have1['pic'];
		  $name = $have1['name'];
		  $time = $py['time'];
		  $title = $py['title'];
		  $content = $py['content'];
		  $postimg = $py['img'];
		  $info = array("img"=>$img,"name"=>$name,"time"=>$time,"title"=>$title,"content"=>$content,"postimg"=>$postimg);
		  echo json_encode($info);
	}
  }
  
  
  
  
  

if($action == 'userlnbbstzpost'){
	  
	 
  	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
	$token = isset($_POST['token']) ? addslashes($_POST['token']) : '';
	$title = isset($_POST['title']) ? addslashes($_POST['title']) : '';
	$content = isset($_POST['content']) ? addslashes($_POST['content']) : '';
	if($username == '')  exit("[1]{账号空}");
	if($token == '')  exit("[1]{秘钥空}");
	
	if($title == '')  exit("[1]{标题空}");
	if($content == '')  exit("[1]{内容空}");
	$imgurl = "";
	$path = "upload/";
	if (!file_exists($path)) {
        mkdir($path,0700);
    }
	
	$imgurl = "";
	$path = "upload/";
	if(mb_strlen($_POST['img1'],"UTF-8") > 1){
		$imageName = "img1".md5($username).time().'.png';
        $img = $_POST['img1'];		
		$base64_string= explode(',', $img);
		$base64_string[1] = str_replace(' ','+',$base64_string[1]);
		$r = file_put_contents($path.$imageName, base64_decode($base64_string[1]));
		if(!$r) 
            {
			    exit("[1]{上传失败}");
			}
		$imgurl = $imgurl."@".$path.$imageName."|";
	}
	
	if(mb_strlen($_POST['img2'],"UTF-8") > 1){
		$imageName = "img2".md5($username).time().'.png';
        $img = $_POST['img2'];		
		$base64_string= explode(',', $img);
		$base64_string[1] = str_replace(' ','+',$base64_string[1]);
		$r = file_put_contents($path.$imageName, base64_decode($base64_string[1]));
		if(!$r) 
            {
			    exit("[1]{上传失败}");
			}
		$imgurl = $imgurl."@".$path.$imageName."|";
	}
	
	
	if(mb_strlen($_POST['img3'],"UTF-8") > 1){
		$imageName = "img3".md5($username).time().'.png';
        $img = $_POST['img3'];		
		$base64_string= explode(',', $img);
		$base64_string[1] = str_replace(' ','+',$base64_string[1]);
		$r = file_put_contents($path.$imageName, base64_decode($base64_string[1]));
		if(!$r) 
            {
			    exit("[1]{上传失败}");
			}
		$imgurl = $imgurl."@".$path.$imageName."|";
	}
	
	$sql="select * from eruyi_user where username='$username' and `online`='$token'";
	$query=$db->query($sql);
	$have=$db->fetch_array($query);
	if($have){
		    $time = time();
			$sql="INSERT INTO `bbspost`(`userid`, `time`, `title`, `content`, `img`) VALUES ('$username','$time','$title','$content','$imgurl')";
		    $query=$db->query($sql);
		    if($query)  exit("[0]{}");;//成功发布帖子
	}else {
	    exit("[1]{登录验证失败}");//登录验证失败
	}
	
	
  }
  
  
   //获取帖子置顶列表 
if($action == 'usergettztoplist'){
    $sql = "select * from bbstop order by time desc";
	$query=$db->query($sql);
	$res=array("content"=>array());
	while ($py = mysql_fetch_array($query)) {
	      $sql= "select * from bbspost where id = '".$py['objid']."' limit 1";
	      $query1=$db->query($sql);
	      $have1=$db->fetch_array($query1);
	      $title = $have1['title'];
		  $objid = $py['objid'];
		  $img = $have1['img'];
	      $info = array("title"=>$title,"name"=>$objid,"img"=>$img);
          array_push($res['content'],$info);	
	    }
		echo json_encode($res);
	}
	
  
  
   // 查看用户帖子
if($action == 'userbbspostadmin'){
	  
	$new = isset($_POST['new']) ? addslashes($_POST['new']) : '';
	$userid = isset($_POST['userid']) ? addslashes($_POST['userid']) : '';
	$sql = "select `id`,`userid`,`time`,`title`,`content`,`img`,`del` from bbspost where userid = '$userid' order by time desc limit " . $new . ",20";
	$query=$db->query($sql);
	$res=array("content"=>array());
	while ($py = mysql_fetch_array($query)) {
	      $sql= "select * from eruyi_user where username = '".$py['userid']."' limit 1";
	      $query1=$db->query($sql);
	      $have1=$db->fetch_array($query1);
	      $img = $have1['pic'];
		  $name = $have1['name'];
		  $time = $py['time'];
		  $title = $py['title'];
		  $content = $py['content'];
		  $postimg = $py['img'];
		  $id = $py['id'];
	      $info = array("id"=>$id,"img"=>$img,"name"=>$name,"time"=>$time,"title"=>$title,"content"=>$content,"postimg"=>$postimg);
          array_push($res['content'],$info);	
	}
	echo json_encode($res);
	
  }
  
  
  
  
  //社区网络图片发帖
   
   
  if($action == 'userbbstzpost2'){
	  
	 
  	$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
	$token = isset($_POST['token']) ? addslashes($_POST['token']) : '';
	$title = isset($_POST['title']) ? addslashes($_POST['title']) : '';
	$content = isset($_POST['content']) ? addslashes($_POST['content']) : '';
	$num = isset($_POST['num']) ? addslashes($_POST['num']) : '';
	
	$img1 = isset($_POST['img1']) ? addslashes($_POST['img1']) : '';
	$img2 = isset($_POST['img2']) ? addslashes($_POST['img2']) : '';
	$img3 = isset($_POST['img3']) ? addslashes($_POST['img3']) : '';
	
	if($username == '')  exit("[1]{账号空}");
	if($token == '')  exit("[1]{秘钥空}");
	
	if($title == '')  exit("[1]{标题空}");
	if($content == '')  exit("[1]{内容空}");
	$imgurl = "";
	
	if(mb_strlen($img1,"UTF-8") > 1){
		$imgurl = $imgurl."@".$img1."|";
	}
	
	if(mb_strlen($img2,"UTF-8") > 1){
		$imgurl = $imgurl."@".$img2."|";
	}
	
	if(mb_strlen($img3,"UTF-8") > 1){
		$imgurl = $imgurl."@".$img3."|";
	}
	
	$sql="select * from eruyi_user where username='$username' and `online`='$token'";
	$query=$db->query($sql);
	$have=$db->fetch_array($query);
	if($have){
		    $time = time();
			$sql="INSERT INTO `bbspost`(`userid`, `time`, `title`, `content`, `img`) VALUES ('$username','$time','$title','$content','$imgurl')";
		    $query=$db->query($sql);
		    if($query)  exit("[0]{}");;//成功发布帖子
	}else {
	    exit("[1]{登录验证失败}");//登录验证失败
	}
  }
  
  
  
  
function getIp() {
	$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
	if (!ip2long($ip)) {
		$ip = '';
	}
	return $ip;
}
function getcode(){ 
$str = null;  
	$strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";  
	$max = strlen($strPol)-1;  
	for($i=0;$i<32;$i++){
		$str.=$strPol[rand(0,$max)];
	}  
	return $str; 
}
function send_post($url, $post_data) {
	$postdata = http_build_query($post_data);
	$options = array(
	    'http' => array(
	    'method' => 'POST',
	    'header' => 'Content-type:application/x-www-form-urlencoded',
	    'content' => $postdata,
	    'timeout' => 15 * 60 // 超时时间（单位:s）
	    )
	);
	$context = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	return $result;
}













?>



