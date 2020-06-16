<? include('system/inc.php'); 
  include('checkpc.php');?>
     <?php                                                                                
                   
 						$result = mysql_query(' select count(*) as sl from '.flag.'usershipin where uid = '.$_REQUEST['uid'].'  ');
						while($row = mysql_fetch_array($result)){
							if ($row['sl']!='') 
 {$totalpage=$row['sl']/20;}
 else
 {$totalpage=1;}
							}
						?>
<!DOCTYPE html>
<html>
<head>
<title>รางวัลเมฆแท้</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0"/>
<script type="text/javascript" src="/ckplayer/ckplayer.js" charset="UTF-8"></script>
<script type="text/javascript" src="/newstatic/static/admin/js/jquery.min.js?v=2.1.4"></script>
<script src="/newstatic/static/admin/js/plugins/layer/laydate/laydate.js"></script>
<script src="/newstatic/static/admin/js/laypage/laypage.js"></script>
<script src="/newstatic/static/admin/js/laytpl/laytpl.js"></script>
<link href="/newstatic/static/index/css/style.css" rel="stylesheet">
<link href="/newstatic/static/index/weui.min.css" rel="stylesheet">
<link href="/newstatic/static/admin/css/style.min.css" rel="stylesheet">
</head>
<body style='max-width:460px; margin:0 auto;'>
<div style="
height: 42px;
    width: 100%;
    background-color: #f24e9d;
    float: left;
    display: block;
    opacity: 0.8;
    line-height: 42px;
    font-size: 22px;
    text-align: center;
    color: #FFF;margin-bottom: 8px;
"><span >รางวัลเมฆแท้</span></div>
<div style="padding: 0px 15px 15px;">



<div id="gdt_area" >
<div style="padding-top:10px;font-size:16px;">

<div>
<div>


<section id="container">
    <div class="h_playlist_box" id="article_list">
    </div>
</section>

<div style="clear: both">
</div>
<div id="AjaxPage" style=" text-align: right;"></div>
                    <div id="allpage" style=" text-align: right; background: #fff"></div>
</div>
<script id="arlist" type="text/html">
	 {{# for(var i=0;i<d.length;i++){  }}
	
     <dl style="width: 100%;" onclick='location.href="{{d[i].dwz}}"'><dt style="height: 88.3365px;"><em></em><img src="{{d[i].photo}}" style="height: 88.3365px; display: inline;" onerror="this.src='/public/moren.jpg'"></dt><dd>
<span style="min-height: 58.3365px;">{{d[i].name}}</span>
<p><i><a href="{{d[i].dwz}}">点击播放</a></i></p> 
</dd></dl>

	  {{# } }}
</script>
 
</div>
</div>
</div>

<style type="text/css">
    .spiner-example{height:200px;padding-top:70px}

</style>

<div class="spiner-example">
    <div class="sk-spinner sk-spinner-three-bounce">
        <div class="sk-bounce1"></div>
        <div class="sk-bounce2"></div>
        <div class="sk-bounce3"></div>
    </div>
</div>


<script type="text/javascript">
function run () {
var index = Math.floor(Math.random()*10);
pmd(index);
};
var times = document.getElementsByClassName('fuckyou').length;
//setInterval('run()',times*200);
function pmd (id) {
var colors = new Array('#FF5151','#ffaad5','#ffa6ff','#d3a4ff','#2828FF','#00FFFF','#1AFD9C','#FF8000','#81C0C0','#B766AD');
var color = colors[id];
var tmp = document.getElementsByClassName('fuckyou');
for (var i = 0; i < tmp.length; i++) {
var id = tmp[i];
var moren = id.style.color;
setTimeout(function(id){
id.style.color = color;
},i*200,id);
setTimeout(function(id,moren){
id.style.color = moren;
},i*200+180,id,moren);
};
}


function Ajaxpage(curr){

        var userid='10011';
        var ddh='w9P9QMraqk';
        $.getJSON('ajaxs.php?uid=<?=$_GET['uid']?>', {
            page: curr || 1,userid:userid,ddh:ddh
        }, function(data){      //data是后台返回过来的JSON数据

           $(".spiner-example").css('display','none');
            if(data==''){
               
            }else{
                article_list(data); //模板赋值
                laypage({
                    cont: $('#AjaxPage'),//容器。值支持id名、原生dom对象，jquery对象,
                    pages:'<?=$totalpage?>',//总页数
                    skip: true,//是否开启跳页
                    skin: '#1AB5B7',//分页组件颜色
                    curr: curr || 1,
                    groups: 3,//连续显示分页数
                    jump: function(obj, first){

                        if(!first){
                            Ajaxpage(obj.curr)
                        }
                        $('#allpage').html('第'+ obj.curr +'页，共'+ obj.pages +'页');
                    }
                });
            }
        });
    }

    Ajaxpage();


 function article_list(list){

    var tpl = document.getElementById('arlist').innerHTML;
    laytpl(tpl).render(list, function(html){
        document.getElementById('article_list').innerHTML = html;
    });
}

</script>



</body>
</html>