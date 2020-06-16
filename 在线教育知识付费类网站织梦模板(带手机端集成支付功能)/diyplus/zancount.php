<?php 
/**
 * 寻梦资源网 http://www.xunmzy.com
 * 点赞插件
 * 点赞数量获取
 */
require_once(dirname(__FILE__)."/../include/common.inc.php");
global $dsql;
$row = $dsql->GetOne("Select id,zan From `#@__archives` where id=".$aid);
if($row['zan']==0){$row['zan']='赞';}
echo "document.write('".$row['zan']."');\r\n";
exit();