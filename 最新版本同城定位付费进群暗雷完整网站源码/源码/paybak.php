<? include('system/inc.php'); 
  include('checkpc.php'); 

$tousu=check_tousu(xiaoyewl_ip());
 
 if ($tousu==1)
 {alert_url('/err.php');}
 
//alert_url('/zf.php?id='.$_GET['id'].'');
 
 $result = mysql_query('select * from '.flag.'usershipin where uid = '.get_usershipin('uid',$_GET['id']).'   order by rand()');
$row = mysql_fetch_array($result);
{
	$title=$row['name'];
	$image=$row['image'];
	$id=$row['ID'];
	$price=$row['price'];
	
	
}


 $result = mysql_query('select * from '.flag.'usershipin where uid = '.get_usershipin('uid',$_GET['id']).'   order by rand()');
$row = mysql_fetch_array($result);
{
	$titles=$row['name'];
	$images=$row['image'];
	$ids=$row['ID'];
	$prices=$row['price'];
	
	
}

$biaoti=get_usershipin('name',$_GET['id']);
$tupian=get_usershipin('image',$_GET['id']);
$jiage=get_usershipin('price',$_GET['id']);
  if ($site_suiji==1) {$dashangsl=rand(1000,9999);} else {$dashangsl=get_ordersl($_GET['id']);}  
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
    
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/play.css" /><link rel="stylesheet" type="text/css" href="/css/style.css" />
    
<title>รางวัลเมฆแท้</title>
</head>
<body style="">
    <form method="post" action="" id="form1">
 


        <div id="pl_nobuy">
	
           
            <div style="width: 100%;padding-top:5px; text-align: center">
            </div>
            
            <div style="position: relative;">
                <center>
            <div style="left:0;top:0;height:240px;width: 100%;background:url('<?=$tupian?>')no-repeat 4px 4px;background-size:100%,100%; -webkit-filter: blur(8px); filter: blur(8px); ">
                        
            </div>         
            <div style="width:100%;position:absolute;left:0;top:0;height:300px; top: 20px; ">
               
                    <span style="color:#f53838;font-size:20px;font-weight:bold;line-height:30px;">打赏￥<?=$jiage?>观看完整视频</span><br>
                    <span style="color:#f53838;font-size:14px;color:#808080;line-height:30px;">已有<?=$dashangsl?>人打赏观看过此视频</span><br>
                    <div id="a_ysfwx" style="display:none">
                        <a href="zf.php?id=<?=$_GET['id']?>" style="font-size:16px; height:40px;line-height:40px;text-align:center;border-radius:10px;margin-top:10px;background:#fae2b2; border-radius: 10px; color: #d35b4d; display: inline-block; width: 120px; height: 40px; font-weight: bold; margin-left: 1px">微信打赏</a><br>
 
                        <a href="tousu.php?userid=<?=get_usershipin('uid',$_GET['id'])?>&amp;sid=<?=$_GET['id']?>" style="font-size:16px; height:40px;line-height:40px;text-align:center;border-radius:10px;margin-top:10px;background:#fae2b2; border-radius: 10px; color: #d35b4d; display: inline-block; width: 120px; height: 40px; font-weight: bold; margin-left: 1px">投诉举报</a>

                    </div>
                    <div id="a_wx" style="display: block;">
                        <div style="display:none"><a href="zf.php?id=<?=$_GET['id']?>" target="_blank" style="font-size:16px; height:40px;line-height:40px;text-align:center;border-radius:10px;margin-top:10px;background:#fae2b2; border-radius: 10px; color: #d35b4d; display: inline-block; width: 120px; height: 40px; font-weight: bold; margin-left: 1px">微信打赏</a><br></div>
                        <a href="zf.php?id=<?=$_GET['id']?>" target="_blank" style="font-size:20px; height:50px;line-height:50px;text-align:center;border-radius:10px;margin-top:10px;background:#fae2b2; border-radius: 10px; color: #d35b4d; display: inline-block; width: 140px; height: 50px; font-weight: bold; margin-left: 1px">微信打赏</a><br>
                         
                          <a href="tousu.php?userid=<?=get_usershipin('uid',$_GET['id'])?>&amp;sid=<?=$_GET['id']?>" style="font-size:16px; height:40px;line-height:40px;text-align:center;border-radius:10px;margin-top:10px;background:#fae2b2; border-radius: 10px; color: #d35b4d; display: inline-block; width: 120px; height: 40px; font-weight: bold; margin-left: 1px">投诉举报</a>
                    </div>
            </div>
            </center>
            </div>
        
</div>
         
        <div style="height: 10px;"></div>
        <script type="text/javascript">
         $(document).ready(function(){
             var url_cs = location.search;
             var tip = document.getElementById('a_wx');
             var tip2 = document.getElementById('a_ysfwx');
             var ua = navigator.userAgent.toLowerCase();
             if (ua.indexOf('micromessenger') > -1 && ua.indexOf('mqqbrowser') > -1) {
                 tip.style.display = 'none';
                 tip2.style.display = 'block';
             }
             else if (ua.match(/MicroMessenger/i) == "micromessenger" || ua.match(/WeiBo/i) == "weibo") {
                 tip.style.display = 'none';
                 tip2.style.display = 'block';
             }
             else {
                 tip.style.display = 'block';
                 tip2.style.display = 'none';
             }
            })
            function ts() {
                　//　window.location.href = "ts.aspx";
                　 　window.location.href = "/user.php?uid=<?=get_usershipin('uid',$_GET['id'])?>";
            }

    </script> 
        <script type="text/javascript" src="ckplayer/ckplayer.js"></script>
		<script type="text/javascript">
			var videoObject = {
				container: '#video', //容器的ID或className
				variable: 'player',//播放函数名称
                poster:'<?=$tupian?>',//封面图片
				video: [//视频地址列表形式
                    ['', 'video/mp4', '线路1', 10],
				]
			};
            var player = new ckplayer(videoObject);

           
		</script>
        <center>
    <div class="my-dd">
    	<div id="data" class="my-info">
            
                             <div class="my-k1" style="text-align:left;">
            	                <div style="height:5px;"></div>
                                <dl class="my-dl1" >
                                                    <? if ($site_suiji==1) {$dashangsls=rand(1000,9999);} else {$dashangsls=get_ordersl($id);} ?>


                	                <dt><a href="?id=<?=$id?>"><img src="<?=$image?>" style="height:85%;"></a>已有<?=$dashangsls?>人打赏观看过此视频</dt>
                                    <dd>
                    	                <p class="my-dp1" style="word-break: break-all;text-overflow: ellipsis;display: -webkit-box;-webkit-box-orient: vertical; -webkit-line-clamp: 3; overflow: hidden; "><a href="?id=<?=$id?>"><?=$title?></a></p>
                                    </dd>
                                    
                                    <div style="clear:both;"></div>
                                </dl>
                               
                                <div style="float:right;margin-top:-40px;"><button type="button" onclick="javascrtpt:window.location.href='zf.php?id=<?=$id?>';" class="button22 f-r" >打赏￥<?=$price?></button></div>
                            </div>
                            
                            
                            
                             <div class="my-k1" style="text-align:left;">
            	                <div style="height:5px;"></div>
                                <dl class="my-dl1" >
                                                    <? if ($site_suiji==1) {$dashangslss=rand(2000,8888);} else {$dashangslss=get_ordersl($ids);} ?>


                	                <dt><a href="?id=<?=$ids?>"><img src="<?=$images?>" style="height:85%;"></a>已有<?=$dashangslss?>人打赏观看过此视频</dt>
                                    <dd>
                    	                <p class="my-dp1" style="word-break: break-all;text-overflow: ellipsis;display: -webkit-box;-webkit-box-orient: vertical; -webkit-line-clamp: 3; overflow: hidden; "><a href="?id=<?=$ids?>"><?=$titles?></a></p>
                                    </dd>
                                    
                                    <div style="clear:both;"></div>
                                </dl>
                               
                                <div style="float:right;margin-top:-40px;"><button type="button" onclick="javascrtpt:window.location.href='zf.php?id=<?=$ids?>';" class="button22 f-r" >打赏￥<?=$prices?></button></div>
                            </div>
                            
                            
                            
                            
                        
        </div>
        <div style="height:15px"></div>
        <input id="more" type="button" class="drdd-btn2" style="display:block;height:40px;background-color:#4db41e" onclick="getmore();" value="更多精彩视频">
        <input id="nomore" type="button" class="drdd-btn2" style="display:none;height:40px;background-color:#4db41e" onclick="getmore();" value="已全部加载完">
        <div style="height:15px"></div>
        
    </div>
            </center>
    </form>
    <script type="text/javascript">
        
        var count = 1;
        function getmore() {

                       　 　window.location.href = "/user.php?uid=<?=get_usershipin('uid',$_GET['id'])?>";

        }
    </script>
   

<style type="text/css">
.footer{position:fixed;bottom:0;z-index:9999;width:100%;height:50px;background:;line-height:50px;text-align:center;}
.footer a{background:url(tousu.png) no-repeat 6px;; background-size:30px 20px;color:#fff;display:block;width:100px;margin:0 auto;}

 

</style>

    <div class="footer"  style="display:none"   ><a  style="color:#000" href="tousu.php?userid=<?=get_usershipin('uid',$_GET['id'])?>&amp;sid=<?=$_GET['id']?>">   &nbsp;&nbsp;&nbsp;投诉</a></div>

</body></html>