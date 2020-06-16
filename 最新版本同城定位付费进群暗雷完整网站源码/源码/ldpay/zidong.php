<?php require_once(dirname(__FILE__).'/config.php');

$id=trim(htmlspecialchars($_REQUEST['id']));
$row = $dosql->GetOne("SELECT * FROM `#@__ewmddh` WHERE `id`='$id'");
$statu=$row['dingdanok'];
if ($statu==1){
ob_clean();
$json_arr = array("status"=>"200");
$json_obj = json_encode($json_arr);
echo $json_obj;
}
?>