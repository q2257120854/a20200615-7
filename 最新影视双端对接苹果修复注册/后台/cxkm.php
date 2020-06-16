<!doctype html>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
</head>
<body>
<?php

 require("include/global.php");
 include("include/option.php");
 $username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
 $token = isset($_POST['token']) ? addslashes($_POST['token']) : '';

 if($username == '') exit('+101+');
 if($token == '') exit('+102+');
 $id = isset($_POST['id']) ? $_POST['id'] : '';
 if($id){
	$ids = '';
	foreach ($id as $value) {
		$ids .= $value.",";
	}
	$ids = rtrim($ids, ",");
	$sql="DELETE FROM `eruyi_kami` WHERE `id` in ($ids)";
	$query=$db->query($sql);
	if($query){
		echo "<script>alert('OK');</script>";
	}
 }
 $KMtype = array(
	'TK'=>"天卡",
	'ZK'=>"周卡",
	'YK'=>"月卡",
	'BNK'=>"半年卡",
	'NK'=>"年卡",
	'YJK'=>"永久卡",
                'YJKK'=>"VIP代理卡",
 );
?>



<form  action="" method="post" name="form_log" id="form_log">
  <div class="am-scrollable-horizontal">
  <table width="100%" id="adm_log_list" class="am-table am-table-striped am-table-hover table-main  am-text-nowrap">
  <thead>
      <tr>
		<th class="table-check"><input type="checkbox" onclick="checkAll();" class="ids" id="all"/></th>
                                <th>ID</th>
		<th>卡密</th>
		<th>卡密类型</th>
		<th>使用状态</th>
		<th>使用者</th>
		<th>使用时间</th>
      </tr>
	</thead>
 	<tbody>
<?php
 $zhuangtai = isset($_POST['zhuangtai']) ? addslashes(trim($_POST['zhuangtai'])) : '';
 $kalei = isset($_POST['kalei']) ? addslashes(trim($_POST['kalei'])) : '';
 if($zhuangtai == "" && $kalei == ""){
	 $sql="select * from eruyi_kami where `generate`='$username'";
 }elseif($zhuangtai != "" && $kalei != ""){
	 $sql="select * from eruyi_kami where `generate`='$username' and `type`='$kalei' and `new`='$zhuangtai'";
 }elseif($zhuangtai != "" && $kalei == ""){
	 $sql="select * from eruyi_kami where `generate`='$username' and `new`='$zhuangtai'";
 }elseif($zhuangtai == "" && $kalei != ""){
	 $sql="select * from eruyi_kami where `generate`='$username' and `type`='$kalei'";
 }
 $query=$db->query($sql);
 if(!$query) exit('+103+');
 while($rows=$db->fetch_array($query)){
?>
      <tr>
                  <td>   <input type="checkbox" name="id[]" value="<?php echo $rows['id']; ?>" class="ids" /></td>
	  <td>id-<?php echo $rows['id']; ?></td>
                  <td>km-<?php echo $rows['kami']; ?></td>
                  <td>lx-<?php echo $KMtype[$rows['type']]; ?></td>
	  <td><?php if($rows['new']=='n'):?><font color=red>zt-已用<?php else: ?><font color=green>zt-可用<?php endif; ?></font></td>
	  <td>syz-<?php if($rows['new']=='n'): echo $rows['username']; endif; ?></td>
	  <td>sysj-<?php if($rows['new']=='n'): echo gmdate("Y年m月d日H时i分s秒",$rows['date']+8*3600); endif; ?></td>
      </tr>
<?php
 }
?>
	</tbody>
	</table>
	<div class="list_footer">
	选择项
:<a href="javascript:void(0);" onclick="delsubmit()" class="">删除
</a>
	</div>
    </div>
</form>



<script>
function checkAll() {
    var code_Values = document.getElementsByTagName("input");
	var all = document.getElementById("all");
    if (code_Values.length) {
        for (i = 0; i < code_Values.length; i++) {
            if (code_Values[i].type == "checkbox") {
                code_Values[i].checked = all.checked;
            }
        }
    } else {
        if (code_Values.type == "checkbox") {
            code_Values.checked = all.checked;
        }
    }
}
function delsubmit(){
	var delform = document.getElementById("form_log");
	delform.submit();
}
var div = document.getElementById('adm_kami'); 
div.setAttribute("class", "show"); 
</script>
</body>
</html>