<?php

define('DEDEMOB', 'Y');
require_once(dirname(__FILE__)."/../include/common.inc.php");
if($a == 'GetPage'){
	echo JJGetTypeList($page,$pagesize);
}

?>