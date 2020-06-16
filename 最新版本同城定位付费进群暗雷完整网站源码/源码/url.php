<?php 
$url=isset($_GET['url'])?$_GET['url']:'';
 ?>
<html>
<head>
<meta http-equiv="refresh" content="1;url='<?=$url?>';">
<meta name="viewport" content="initial-scale=1.0, width=device-width, user-scalable=no" />
<link rel="stylesheet" type="text/css" href="css/wxzf.css">
<script src="https://lib.baomitu.com/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div class="wenx_xx">
  <p><img src="images/succ.png" alt="" class="succ_img"></p>
  <p>&nbsp;</p>
  <p>&nbsp;  </p>
  <p class="succ_tit f24">正在载入页面</p>
  <p class="succ_tit">&nbsp;</p>
  <p class="succ_tit">&nbsp;</p>
  <a href=<?=$url?> class="all_w ljzf_but"><strong>立即进入</strong></a>
</div>
</body>
</html>