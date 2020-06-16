<?php

/**

 * @version        $Id: ajax_loginsta.php 1 8:38 2010年7月9日Z tianya $

 * @package        DedeCMS.Member

 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.

 * @license        http://help.dedecms.com/usersguide/license.html

 * @link           http://www.yunziyuan.com.cn

 */

require_once(dirname(__FILE__)."/config.php");

require_once DEDEINC.'/shopcar.class.php';

AjaxHead();

if($myurl == '') exit('');



$uid  = $cfg_ml->M_LoginID;

  $pms = $dsql->GetOne("SELECT COUNT(*) AS nums FROM #@__member_pms WHERE toid='{$cfg_ml->M_ID}' AND `hasview`=0 AND folder = 'inbox'");

  echo "document.write('".$pms['nums']."');\r\n";

exit();

?>