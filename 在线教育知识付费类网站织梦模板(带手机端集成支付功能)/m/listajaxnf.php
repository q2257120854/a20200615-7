<?php

$tid = $_REQUEST['tid'];

$PageNo = $_REQUEST['PageNo'];

//echo $tid;

//echo $PageNo;

$fh= file_get_contents('http://m.test.com/r.php?tid='.$tid.'&PageNo='.$PageNo);

$fh=substr($fh,0,-1);

//echo $fh;

$su=strlen($fh);

//echo $su;*/

if ($su < 20){$status = ERR;} else{$status = OK;}

//echo $status;

echo '{"status":"'.$status.'","data":{"cooklist":['.$fh.']}}';

?>