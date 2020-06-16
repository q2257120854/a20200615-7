<?php
require_once(dirname(__FILE__)."/../config.php");
//var_dump($_POST);
if($a == 'getorder'){
    
    //购买课程
	if(substr($ddh,0,3) == 'KE-'){
		$arr = $dsql->GetOne("select state from #@__shops_orders where `oid` = '".$ddh."'");		
		if($arr['state'] == '1'){
			$ret =1;
		} 	
	}else{
    $arr = $dsql->GetOne("select sta,oldinfo from #@__member_operation where `buyid` = '".$ddh."'");		
	if($arr['sta'] == '2'){
		$ret =1;
	} 
        
    }
    
	echo $ret;
	exit();
}

?>