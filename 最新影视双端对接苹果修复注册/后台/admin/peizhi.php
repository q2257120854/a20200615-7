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
             'HBURL'=>$row['yzfurl'],   
                 'HBID'=>$row['yzfid'],
		    'HBKEY'=>$row['yzfkey'],
            'HBzfb'=>$row['zfbhb'],   
            'HBrjjg'=>$row['rjjg'],
            'HBggms'=>$row['ggms'],
		    'HBxs'=>$row['xianshi'],
		     'HBID'=>$row['yzfid'],
		    'HBKEY'=>$row['yzfkey'],
			'HBweixinid'=>$row['weixinid'],
            'HBgao'=>$row['guanggao'],
			'HBgao2'=>$row['guanggao2'],  
			'HBgao3'=>$row['guanggao3'],  
			'HBgao4'=>$row['guanggao4'],  
			'HBgao5'=>$row['guanggao5'],  
			'HBgao6'=>$row['guanggao6']
      
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

