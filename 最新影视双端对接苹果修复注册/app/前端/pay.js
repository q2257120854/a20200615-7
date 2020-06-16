mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 标题栏1 = new 标题栏("标题栏1",null,标题栏1_右侧图标被单击,标题栏1_左侧图标被单击);
var 网络操作1 = new 网络操作("网络操作1",网络操作1_发送完毕);
var 网络操作2 = new 网络操作("网络操作2",网络操作2_发送完毕);
var 网络操作3 = new 网络操作("网络操作3",网络操作3_发送完毕);
var 网络操作4 = new 网络操作("网络操作4",网络操作4_发送完毕);
var 时钟1 = new 时钟("时钟1",时钟1_周期事件);
var 仔仔1 = new 仔仔("仔仔1",null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
if(mui.os.plus){
    mui.plusReady(function() {
        Pay_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        Pay_创建完毕();
        
    }
}
var mui_back = mui.back;
mui.back = function() {
    if (Pay_按下返回键()!=true) {
        mui_back();
    }
};

var 支付金额json = 转换操作.文本转json(读写设置.读取设置("软件价格"));
var 充值开关 = false;
var 支付软件标题;
var 充值时间;
var 支付金额;
var 支付图片;
var 订单号;
var 背景颜色;
var 默认字体颜色;
var 现行字体颜色;
var 默认分类图标;
var 默认搜索图标;
var 背景颜色 = 读写设置.读取设置("背景颜色");
var 默认颜色 = 读写设置.读取设置("默认颜色");
var 激活颜色 = 读写设置.读取设置("激活颜色");
var 搜索颜色 = 读写设置.读取设置("搜索颜色");
document.getElementById("标题栏1").style.background = 背景颜色;
document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色;
document.querySelectorAll("#标题栏1 a")[1].style.color = 背景颜色;
document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>返回</h1>";
document.querySelectorAll("#标题栏1 a")[1].innerHTML = "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + "'>点此在线充值</h1>";

function Pay_创建完毕(){
var div=document.createElement("div");
	div.innerHTML = "<div class='minirefresh-scroll'><div id=推荐 style='list-style: none;'></div><div id=其他 style='list-style: none;display: none;'></div></div>";
	div.id = "minirefresh";
	div.class = "minirefresh-wrap";
	div.style.overflow = "inherit";
	document.body.appendChild(div);
	document.body.querySelectorAll("div")[0].insertBefore(div, document.body.nextSibling);

var div=document.createElement("div");
	div.innerHTML = "<ul id=其他列表 class='mui-table-view mui-grid-view' style='padding: 0;'></ul>";
	document.body.appendChild(div);
	document.getElementById("其他").appendChild(div);
	html = "<ul id='图标' style='width:100%;color:#000000;font-size:14px;margin:0px 0px 0px 0px;padding:0px;text-align:center'>"+
	"<img src="+公用模块.AdminGuanLi() + "/" + 读写设置.读取设置("用户头像")+" style='margin-top: 60px;width: 80px;' />"+
	"</ul>"+
	"<ul id='列表框1' style='width:100%;color:#000000;font-size:14px;margin:0px 0px 0px 0px;padding:0px;text-align:center'>"+
	"<input id=卡密 type='text' style='margin-top: 30px; width: 85%;border-radius:5px;' type=text placeholder='请输入卡密兑换码'></input>"+
	"<button id=兑换 class='btn' style='width: 85%;height: 35px;border-radius: 15px;background: " + 背景颜色 + "; color: " + 激活颜色 + ";font-size: 17px;font-family: 黑体;'>卡密兑换充值</button>"+
	"</ul>";
	顶部插入div(html);
	document.getElementById("兑换").addEventListener("click", function() { 开始兑换卡密(document.getElementById("卡密").value);}, false);
var div = document.createElement("div");
	div.innerHTML = "<ul id='高级列表框1' class='mui-table-view' style='width: 100%;margin:20px 0px 0px 0px;display:none'>"+
	"<li class='mui-table-view-cell mui-media mui-media-icon' tag='0'>"+
	"<img class='mui-media-object mui-pull-left' style='margin: 0px 0px 0px 18px; height:28px; width:28px;' src='images/pay/0.png'>"+
	"<div class='' style='margin: 4px 0px 0px 80px;color:#0088FF' >充值<a style='color:#FF0000'> 7天 </a>会员"+
	"<span style='background: #FFF6EA;color: #FB6122;font-size: 14px;font-family: 黑体;padding: 5px 5px 5px 5px;border-radius: 30px;box-shadow: #FFF6EA 0px 1px 10px; margin:0px 0px 0px 20px;'>"+支付金额json.周卡价+"￥</span>"+
	"</div></a></li>"+

	"<li class='mui-table-view-cell mui-media mui-media-icon' tag='1'>"+
	"<img class='mui-media-object mui-pull-left' style='margin: 0px 0px 0px 18px; height:28px; width:28px;' src='images/pay/0.png'>"+
	"<div class='' style='margin: 4px 0px 0px 80px;color:#0088FF' >充值<a style='color:#FF0000'> 一个月 </a>会员"+
	"<span style='background: #FFF6EA;color: #FB6122;font-size: 14px;font-family: 黑体;padding: 5px 5px 5px 5px;border-radius: 30px;box-shadow: #FFF6EA 0px 1px 10px; margin:0px 0px 0px 20px;'>"+支付金额json.月卡价+"￥</span>"+
	"</div></a></li>"+

	"<li class='mui-table-view-cell mui-media mui-media-icon' tag='2'>"+
	"<img class='mui-media-object mui-pull-left' style='margin: 0px 0px 0px 18px; height:28px; width:28px;' src='images/pay/0.png'>"+
	"<div class='' style='margin: 4px 0px 0px 80px;color:#0088FF' >充值<a style='color:#FF0000'> 3个月 </a>会员"+
	"<span style='background: #FFF6EA;color: #FB6122;font-size: 14px;font-family: 黑体;padding: 5px 5px 5px 5px;border-radius: 30px;box-shadow: #FFF6EA 0px 1px 10px; margin:0px 0px 0px 20px;'>"+支付金额json.季度价+"￥</span>"+
	"</div></a></li>"+

	"<li class='mui-table-view-cell mui-media mui-media-icon' tag='3'>"+
	"<img class='mui-media-object mui-pull-left' style='margin: 0px 0px 0px 18px; height:28px; width:28px;' src='images/pay/0.png'>"+
	"<div class='' style='margin: 4px 0px 0px 80px;color:#0088FF' >充值<a style='color:#FF0000'> 12个月 </a>会员"+
	"<span style='background: #FFF6EA;color: #FB6122;font-size: 14px;font-family: 黑体;padding: 5px 5px 5px 5px;border-radius: 30px;box-shadow: #FFF6EA 0px 1px 10px; margin:0px 0px 0px 20px;'>"+支付金额json.年卡价+"￥</span>"+
	"</div></a></li>"+

	"<li class='mui-table-view-cell mui-media mui-media-icon' tag='3'>"+
	"<img class='mui-media-object mui-pull-left' style='margin: 0px 0px 0px 18px; height:28px; width:28px;' src='images/pay/0.png'>"+
	"<div class='' style='margin: 4px 0px 0px 80px;color:#0088FF' >充值<a style='color:#FF0000'> 代理 </a>永久"+
	"<span style='background: #FFF6EA;color: #FB6122;font-size: 14px;font-family: 黑体;padding: 5px 5px 5px 5px;border-radius: 30px;box-shadow: #FFF6EA 0px 1px 10px; margin:0px 0px 0px 20px;'>"+支付金额json.代理价+"￥</span>"+
	"</div></a></li>"+

	"</ul>";
	div.id = "vip";
	div.style.cssText = "position: relative;z-index: 1;";
	document.body.appendChild(div);
	document.body.querySelectorAll("div")[0].insertBefore(div, document.body.nextSibling);
	mui("#高级列表框1").on("tap", "li", function() { 在线充值(this.getAttribute("tag"));});
var div = document.createElement("div");
	div.innerHTML = "<ul id=横排列表框 style='margin:15px 0px 15px 0px; padding: 0px 0px 0px 0px;display:none' >"+
	"<li style='padding: 0;width: 33%;height: auto;background-color: rgba(255,255,255,.1);display: inline-table;text-align: -webkit-center;margin: 0;' data-index='0'><img style='width:28px;' src=images/pay/alipay.png /><p style='color: #000;font-size: 13px;margin: 0;'>支付宝支付</p></li>"+
	"<li style='padding: 0;width: 33%;height: auto;background-color: rgba(255,255,255,.1);display: inline-table;text-align: -webkit-center;margin: 0;' data-index='1'><img style='width:28px;' src=images/pay/wepay.png /><p style='color: #000;font-size: 13px;margin: 0;'>微信支付</p></li>"+
	"<li style='padding: 0;width: 33%;height: auto;background-color: rgba(255,255,255,.1);display: inline-table;text-align: -webkit-center;margin: 0;' data-index='2'><img style='width:28px;' src=images/pay/qqpay.png /><p style='color: #000;font-size: 13px;margin: 0;'>QQ支付</p></li>"+
	"</ul>";
	document.body.appendChild(div);
	document.body.querySelectorAll("div")[0].insertBefore(div, document.body.nextSibling);
	mui("#横排列表框").on("tap", "li", function() { 支付方式(this.getAttribute("data-index"));});
var div = document.createElement("div");
	div.innerHTML = "<div id='支付图片框' style='display:block'></div>";
	document.body.appendChild(div);
}
function 顶部插入div(html){
	var newNodeBottom = document.createElement("div");
    newNodeBottom.innerHTML = html;
	document.getElementById("推荐").appendChild(newNodeBottom);
}
function 标题栏1_左侧图标被单击(){
var self = plus.webview.currentWebview();
	plus.webview.close(self,"slide-out-right");
}
function Pay_按下返回键(){
var self = plus.webview.currentWebview();
	plus.webview.close(self,"slide-out-right");
}
function 开始兑换卡密(kami){
	网络操作1.发送网络请求(公用模块.AdminGuanLi() + "/api.php?action=checkkami","post","txt","&username=" + 读写设置.读取设置("用户帐号") + "&kami=" + kami,12000);
}
function 网络操作1_发送完毕(发送结果,返回信息){
var json = 转换操作.文本转json(文本操作.子文本替换(返回信息,"\\\+",""));
var 返回信息 = 数学操作.到数值(转换操作.json转文本(json));
	console.log(返回信息);
if (返回信息 == 101){mui.toast("失败：当前激活的账号为空")}
if (返回信息 == 130){mui.toast("失败：当前激活码为空")}
if (返回信息 == 131){mui.toast("失败：当前激活码有误")}
if (返回信息 == 132){mui.toast("失败：当前激活码已被使用")}
if (返回信息 == 133){mui.toast("失败：当前激活的账号不存在")}
if (返回信息 == 134){mui.toast("失败：当前激活的账号已是永久会员")}
if (返回信息 == 135){mui.toast("失败：请稍后重新尝试")}
if (返回信息 == 140){mui.toast("失败：请登录后重试")}
if (返回信息 == 200){mui.toast("成功：马上体验！"),窗口操作.执行代码("caidan.html","获取登录数据()")}
}

function 在线充值(index){

	mui.toast("请选择支付方式");
	if (index == "0"){
		充值时间 = 仔仔1.时间_当前时间戳()+604800;
		支付金额 = 支付金额json.周卡价;
		document.getElementById("横排列表框").style.display = "block";
		return;
	}
	if (index == "1"){
		充值时间 = 仔仔1.时间_当前时间戳()+2592000;
		支付金额 = 支付金额json.月卡价;
		document.getElementById("横排列表框").style.display = "block";
		return;
	}
	if (index == "2"){
		充值时间 = 仔仔1.时间_当前时间戳()+7776000;
		支付金额 = 支付金额json.季度价;
		document.getElementById("横排列表框").style.display = "block";
		return;
	}
	if (index == "3"){
		充值时间 = 仔仔1.时间_当前时间戳()+31536000;
		支付金额 = 支付金额json.年卡价;
		document.getElementById("横排列表框").style.display = "block";
		return;
	}
	if (index == "4"){
		窗口操作.打开指定网址(读写设置.读取设置("卡密购买地址"),2);
		return;
	}
}

function 标题栏1_右侧图标被单击(){
	document.getElementById("支付图片框").style.display = "none";
	document.getElementById("横排列表框").style.display = "none";
	if (充值开关 == false){
		document.getElementById("高级列表框1").style.display = "block";
		充值开关 = true;
	}else{
		document.getElementById("高级列表框1").style.display = "none";
		充值开关 = false;
	}
}

function 支付方式(index){

	if (index == "0"){
		支付类型 = "1";
		支付软件标题 = "支付宝";
		网络操作2.发送网络请求("http://codepay.fateqq.com:52888/creat_order/?id=" + 读写设置.读取设置("码支付ID") + "&token=" + 读写设置.读取设置("码支付TOKEN") + "&price=" + 支付金额 + "&pay_id=" + 读写设置.读取设置("用户帐号") + "&type=" + 支付类型 + "&page=4","get","txt","",12000);
		return;
	}
	if (index == "1"){
		支付类型 = "3";
		支付软件标题 = "微信";
		网络操作2.发送网络请求("http://codepay.fateqq.com:52888/creat_order/?id=" + 读写设置.读取设置("码支付ID") + "&token=" + 读写设置.读取设置("码支付TOKEN") + "&price=" + 支付金额 + "&pay_id=" + 读写设置.读取设置("用户帐号") + "&type=" + 支付类型 + "&page=4","get","txt","",12000);
		return;
	}
	if (index == "2"){
		支付类型 = "2";
		支付软件标题 = "QQ";
		网络操作2.发送网络请求("http://codepay.fateqq.com:52888/creat_order/?id=" + 读写设置.读取设置("码支付ID") + "&token=" + 读写设置.读取设置("码支付TOKEN") + "&price=" + 支付金额 + "&pay_id=" + 读写设置.读取设置("用户帐号") + "&type=" + 支付类型 + "&page=4","get","txt","",12000);
		return;
	}
}

function 网络操作2_发送完毕(发送结果,返回信息){
	document.getElementById("高级列表框1").style.display = "none";
	document.getElementById("横排列表框").style.display = "none";
	充值开关 = false;
	var json = 转换操作.文本转json(返回信息);
	订单号 = json.order_id;
	支付图片 = json.qrcode;
	var html = "<div style='text-align: center; margin:30px 0px 0px 0px'>"+
				"<img src=" + 支付图片 + " style='width: 200px;height:200px;' />"+
				"<p style='color:#0088FF;'>请打开 " + "<a style='color:#FF0000'>" + 支付软件标题 + "</a>" + " 扫一扫上方二维码支付</p>"+
				"<p>支付金额：" + "<a style='color:#FF0000'>" + 支付金额 + "</a>" + "</p>" +
				"<p>支付成功后请稍等几秒加载时间...</p>" +
				"</div>";
		document.getElementById("支付图片框").innerHTML = html;
		document.getElementById("支付图片框").style.display = "block";
		时钟1.开始执行(1000,false);
}

function 时钟1_周期事件(){
	网络操作3.发送网络请求("http://codepay.fateqq.com:52888/ispay?id=" + 读写设置.读取设置("码支付ID") + "&order_id=" + 订单号 + "&token=" + 读写设置.读取设置("码支付TOKEN") + "&call=callback","get","txt","",12000);
}

function 网络操作3_发送完毕(发送结果,返回信息){
	返回信息 = 公用模块.取中间文本(返回信息,"callback(",")");
	var json = 转换操作.文本转json(返回信息);
	if (json.status == 0){
		时钟1.开始执行(1000,false);
	}
	if (json.status == 1){
		网络操作4.发送网络请求(公用模块.AdminGuanLi() + "/api.php?action=usercustom","post","txt","username=" + 读写设置.读取设置("用户帐号") + "&token=" + 读写设置.读取设置("用户token") + "&name=vip&content=" + 充值时间,12000);
		return;
	}
	if (json.status == 2){
		网络操作4.发送网络请求(公用模块.AdminGuanLi() + "/api.php?action=usercustom","post","txt","username=" + 读写设置.读取设置("用户帐号") + "&token=" + 读写设置.读取设置("用户token") + "&name=vip&content=" + 充值时间,12000);
		return;
	}
}

function 网络操作4_发送完毕(发送结果,返回信息){
	var 返回信息 = 文本操作.子文本替换(返回信息,"\\\+","");
	时钟1.停止执行();
	if (返回信息 == 200){
		mui.toast("VIP充值成功");
		窗口操作.执行代码("caidan.html","获取登录数据()");
		plus.webview.close("pay.html","slide-out-right");
		return;
	}
	if (返回信息 == "200"){
		mui.toast("VIP充值成功");
		窗口操作.执行代码("caidan.html","获取登录数据()");
		plus.webview.close("pay.html","slide-out-right");
		return;
	}
}