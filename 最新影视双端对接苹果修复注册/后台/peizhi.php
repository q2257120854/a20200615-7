<?php       
require_once 'include/global.php';

$sql="select * from eruyi_peizhi where id=1";
$query=$db->query($sql);
$row=$db->fetch_array($query);

if($row){
      $udata = array(
            'HBbb'=>$row['banben'],
            'HBms'=>$row['charge'],
            'HBqq'=>$row['qq'],
            'HBkey'=>$row['qunkey'], 
            'HBxz'=>$row['dizhi'],
            'HBnr'=>$row['gxneirong'],
            'HBgg'=>$row['gonggao'],  
            'HBfl'=>$row['fldizhi'],
            'HBmr'=>$row['mrjiekou'],  
            'HBjk'=>$row['jiekou'],
            'HBjxpz'=>$row['qita'],   
            
            'HBzfb'=>$row['zfbhb'],   
            'HBrjjg'=>$row['rjjg'],
            'HBggms'=>$row['ggms'],
		    'HBxs'=>$row['xianshi'],
		   
			'HBweixinid'=>$row['weixinid'],
            'HBgao'=>$row['guanggao'],
			'HBgao2'=>$row['guanggao2'],  
			'HBgao3'=>$row['guanggao3'],  
			'HBgao4'=>$row['guanggao4'],  
			'HBgao5'=>$row['guanggao5'],  
			'HBgao6'=>$row['guanggao6'],
            'HBtcggid'=>$row['tcgonggaoid'],
			'HBtcgg'=>$row['tcgonggao'],
        	'HBtcggts'=>$row['tcgonggaots'],
       		'HBmzfid'=>$row['mzfid'],   
            'HBmzfkey'=>$row['mzfkey'],
		    'HBmzftoken'=>$row['mzftoken'],
        
            'HByzfid'=>$row['yzfid'],   
            'HByzfkey'=>$row['yzfkey'],
		    'HByzfurl'=>$row['yzfurl'],
         'HBkmgmdz'=>$row['kmgmdz'],
         'HBpaytype'=>$row['pay_type'],
        
        'HBupdateis'=>$row['updateis'],
        'HBupdatetype'=>$row['updatetype'],
        'HBapkurl'=>$row['apkurl'],
        
        'HBcode'=>$row['banben_code'],
        'HBcodeurl'=>$row['code_url'],
        'HBis_code_up'=>$row['is_code_up'],
        'iptime'=>$row['iptime'],
        'codetime'=>$row['codetime'],
            );
      $jdata = json_encode($udata);
      echo '{brC46jF'.base64_encode($jdata).'}';
}
?>
<li>
<?php 
 $sql="select * from shipin_fl";
 $query=$db->query($sql);
 while($rows=$db->fetch_array($query)){
	 echo $rows['fenlei']."|";
	 }
?>
</li>

<br/>
<br/>
<?php 
echo "HBbb:1.0#";
?>

