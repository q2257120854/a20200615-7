mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 仔仔1 = new 仔仔("仔仔1",null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
var 网络操作1 = new 网络操作("网络操作1",网络操作1_发送完毕);
var 网络操作2 = new 网络操作("网络操作2",网络操作2_发送完毕);
var 微信分享1 = new 微信分享("微信分享1",null,null);
if(mui.os.plus){
    mui.plusReady(function() {
        Caidan_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        Caidan_创建完毕();
        
    }
}
window.addEventListener("customEvent",function(event){Caidan_切换完毕(event.detail.param);});

var 安装包版本号 = 公用模块.当前版本();
var 登录状态 = false;
var 机器码;
var 时间;
var 图标;
var 背景颜色 = 读写设置.读取设置("背景颜色");
var 默认颜色 = 读写设置.读取设置("背景颜色");
var 激活颜色 = 读写设置.读取设置("激活颜色");
var 菜单消息 = 读写设置.读取设置("菜单消息");
var 菜单收藏 = 读写设置.读取设置("菜单收藏");
var 菜单记录 = 读写设置.读取设置("菜单记录");
var 菜单代理 = 读写设置.读取设置("菜单代理");
var 列表框图片1;
var 列表框图片2;
var 列表框图片3;
var 列表框图片4;
var 列表框图片5;
var 列表框图片6;
function Caidan_创建完毕(){
	微信分享1.获取分享服务列表();
获取主题颜色(),插入推荐div();
if (窗口操作.是否在安卓内运行() == false){机器码 = 仔仔1.命令_获取UUID()}else{机器码 = 仔仔1.命令_获取IMEI()}
if (读写设置.读取设置("用户帐号") != "" && 读写设置.读取设置("用户密码") != null){获取登录数据()}else{刷新登录数据()}
}
function 获取登录数据(){
网络操作1.发送网络请求(公用模块.AdminGuanLi() + "/api.php?action=login","post","txt","&username=" + 读写设置.读取设置("用户帐号") + "&password=" + 读写设置.读取设置("用户密码") + "&logcode=" + 机器码,12000);
}
function 网络操作1_发送完毕(发送结果,返回信息){
var json = 转换操作.文本转json(文本操作.子文本替换(返回信息,"\\\+",""));
var 返回信息 = 数学操作.到数值(转换操作.json转文本(json));
if (返回信息 == 101){mui.toast("账号为空")}
if (返回信息 == 102){mui.toast("密码为空")}
if (返回信息 == 104){mui.toast("机器码为空")}
if (返回信息 == 110){mui.toast("账号密码有误")}
if (返回信息 == 108){mui.toast("机器码不匹配")}
if (返回信息 == 108){mui.toast("禁止登录")}
if (json.token != "" || json.token != null || json.token != null){网络操作2.发送网络请求(公用模块.AdminGuanLi() + "/api.php?action=getinfo","post","txt","&username=" + 读写设置.读取设置("用户帐号") + "&token=" + json.token,5000)}
}
function 网络操作2_发送完毕(发送结果,返回信息){
var json = 转换操作.文本转json(文本操作.子文本替换(返回信息,"\\\+",""));
读写设置.保存设置("用户名字",json.name),读写设置.保存设置("用户头像",json.pic),读写设置.保存设置("已邀请人数",json.number),读写设置.保存设置("用户token",json.online),读写设置.保存设置("用户时间",json.vip),读写设置.保存设置("用户余额",json.money),读写设置.保存设置("用户上级",json.inv),读写设置.保存设置("邀请码",json.uid);
if (读写设置.读取设置("用户时间") == "0" || 读写设置.读取设置("用户时间") == 0){读写设置.保存设置("用户时间",json.regdate)}
	if (json.lock == "n"){
	if (json.vip == "999999999"){
	读写设置.保存设置("用户时间","4102415999");
	刷新登录数据();
	return;
	}else if (json.vip == "888888888"){
		读写设置.保存设置("用户时间","4102415999");

		刷新登录数据();
		return}
	刷新登录数据()}else{mui.toast("您的账号已被锁定"),读写设置.删除设置("用户帐号"),读写设置.删除设置("用户密码")}
}
function 刷新登录数据(){
	console.log("开始刷新");
	if (读写设置.读取设置("用户帐号") != "" && 读写设置.读取设置("用户密码") != null && 读写设置.读取设置("用户时间") != null){
		document.getElementById("用户名").innerHTML =  读写设置.读取设置("用户名字") + "  <br><a style='color: " + 激活颜色 + ";font-family: SimHei;font-size: 10px;'> 邀请码:" + 读写设置.读取设置("邀请码") + "</a>";
		document.getElementById("touxiang").src = 公用模块.AdminGuanLi() + "/" + 读写设置.读取设置("用户头像");
		if (读写设置.读取设置("用户时间") == "4102415999"){
			document.getElementById("用户时间").innerHTML = "<br>永久会员";
		}else{
		document.getElementById("用户时间").innerHTML = "<br>"+仔仔1.时间_时间戳转时间(读写设置.读取设置("用户时间"));
		}
	}else {
		document.getElementById("touxiang").src = "images/Home_logo.png",document.getElementById("用户名").innerHTML = "登录/注册",document.getElementById("用户时间").innerHTML = "登录发现更多精彩"}
}
function 登录(){
if (取登陆状态() == false){
if (登录状态 == true ){登录状态 = false }else {}console.log("开始登录"),窗口操作.预加载窗口("login.html"),窗口操作.取指定窗口("login.html").show("slide-in-right")}else{窗口操作.预加载窗口("gerenxinxi.html"),窗口操作.取指定窗口("gerenxinxi.html").show("slide-in-right", 300)}
}
function 取登陆状态(){
	刷新主题颜色();
if (document.getElementById("用户名").innerHTML == "登录/注册"){return false}else {return true }
}
function 插入推荐div(){
var div = document.createElement("div");
	div.innerHTML = "<div style='height: 120px;background: " + 背景颜色 + ";' id=登录 >"+
	"<img id=touxiang src=images/Home_logo.png style='width: 60px;position: absolute;top: 30px;left: 10%;border-radius: 100px;' onerror=加载失败(this)/>"+
	"<p style='margin:40px 0px 0px 36%;position: absolute;color: " + 激活颜色 + ";font-family: SimHei;font-size: 16px;' id=用户名 >登录/注册</p>"+
	"<p style='margin:60px 0px 0px 36%; position: absolute; font-size: 12px; color: " + 激活颜色 + ";font-family: SimHei;' id=用户时间 >登录发现更多精彩</p></div>";
	div.id = "minirefresh",div.style.cssText = "overflow: hidden;height: 120px;position: relative;";
	document.body.appendChild(div),document.body.querySelectorAll("div")[0].insertBefore(div, document.body.nextSibling);
	document.getElementById("登录").addEventListener("tap", function() { 登录();}, false);



var div = document.createElement("div");
	div.innerHTML = "<ul id=横排列表框 style='margin:15px 0px 15px 0px; padding: 0px 0px 0px 0px;' style='width: 100%;white-space: nowrap;overflow: hidden;overflow-x: scroll;' >"+
	"<li style='padding: 0;width: 25%;height: auto;background-color: rgba(255,255,255,.1);display: inline-table;text-align: -webkit-center;margin: 0;' data-index='0'><img style='width:28px;' src=images/yi9caidan/xx/" + 菜单消息 + " /><p style='color: " + 默认颜色 +";font-size: 13px;margin: 0;'>我的消息</p></li>"+
	"<li style='padding: 0;width: 25%;height: auto;background-color: rgba(255,255,255,.1);display: inline-table;text-align: -webkit-center;margin: 0;' data-index='1'><img style='width:28px;' src=images/yi9caidan/sc/" + 菜单收藏 + " /><p style='color: " + 默认颜色 +";font-size: 13px;margin: 0;'>我的收藏</p></li>"+
	"<li style='padding: 0;width: 25%;height: auto;background-color: rgba(255,255,255,.1);display: inline-table;text-align: -webkit-center;margin: 0;' data-index='2'><img style='width:28px;' src=images/yi9caidan/jl/" + 菜单记录 + " /><p style='color: " + 默认颜色 +";font-size: 13px;margin: 0;'>播放记录</p></li>"+
	"<li style='padding: 0;width: 25%;height: auto;background-color: rgba(255,255,255,.1);display: inline-table;text-align: -webkit-center;margin: 0;' data-index='3'><img style='width:28px;' src=images/yi9caidan/dl/" + 菜单代理 + " /><p style='color: " + 默认颜色 +";font-size: 13px;margin: 0;'>代理中心</p></li></ul>";
	document.body.appendChild(div),document.body.querySelectorAll("div")[0].insertBefore(div, document.body.nextSibling);
	mui("#横排列表框").on("tap", "li", function() { 横排列表项目被单击(this.getAttribute("data-index"));});




var div = document.createElement("div");
	div.innerHTML = "<ul id='高级列表框1' class='mui-table-view' style='width: 100%;'>"+
	"<li class='mui-table-view-cell mui-media mui-media-icon' tag='0'><a class='mui-navigate-right'><img class='mui-media-object mui-pull-left' style='margin: 5px 0px 0px 10px; height:20px; width:20px;' src='images/yi9caidan2/cz/" + 列表框图片1 + "'><div class='' style='margin: 4px 0px 0px 50px; color: " + 默认颜色 +";' >会员中心</div></a></li>"+
	"<li class='mui-table-view-cell mui-media mui-media-icon' tag='1'><a class='mui-navigate-right'><img class='mui-media-object mui-pull-left' style='margin: 5px 0px 0px 10px; height:20px; width:20px;' src='images/yi9caidan2/fx/" + 列表框图片2 + "'><div class='' style='margin: 4px 0px 0px 50px; color: " + 默认颜色 +";' >送会员</div></a></li>"+
	"<li class='mui-table-view-cell mui-media mui-media-icon' tag='2'><a class='mui-navigate-right'><img class='mui-media-object mui-pull-left' style='margin: 5px 0px 0px 10px; height:20px; width:20px;' src='images/yi9caidan2/fk/" + 列表框图片3 + "'><div class='' style='margin: 4px 0px 0px 50px; color: " + 默认颜色 +";' >意见反馈</div></a></li>"+
	"<li class='mui-table-view-cell mui-media mui-media-icon' tag='3'><a class='mui-navigate-right'><img class='mui-media-object mui-pull-left' style='margin: 5px 0px 0px 10px; height:20px; width:20px;' src='images/yi9caidan2/gy/" + 列表框图片5 + "'><div class='' style='margin: 4px 0px 0px 50px; color: " + 默认颜色 +";' >体验计划</div></a></li>"+
	"<li class='mui-table-view-cell mui-media mui-media-icon' tag='4'><a class='mui-navigate-right'><img class='mui-media-object mui-pull-left' style='margin: 5px 0px 0px 10px; height:20px; width:20px;' src='images/yi9caidan2/sz/" + 列表框图片4 + "'><div class='' style='margin: 4px 0px 0px 50px; color: " + 默认颜色 +";' >主题风格</div></a></li>"+
	"<li class='mui-table-view-cell mui-media mui-media-icon' tag='5'><a class='mui-navigate-right'><img class='mui-media-object mui-pull-left' style='margin: 5px 0px 0px 10px; height:20px; width:20px;' src='images/yi9caidan2/tc/" + 列表框图片6 + "'><div class='' style='margin: 4px 0px 0px 50px; color: " + 默认颜色 +";' >设置</div></a></li></ul>";
	document.body.appendChild(div),document.body.querySelectorAll("div")[0].insertBefore(div, document.body.nextSibling);
	mui("#高级列表框1").on("tap", "li", function() { 竖排列表项目被单击(this.getAttribute("tag"));});
}
function 登录被单击(i){
	if (i == 1){窗口操作.预加载窗口("shoucang.html"),窗口操作.取指定窗口("shoucang.html").show("slide-in-right", 300)}
}

function 横排列表项目被单击(i){
	if (i == 0){mui.toast("暂未开启")}
	if (i == 1){窗口操作.预加载窗口("shoucang.html"),窗口操作.取指定窗口("shoucang.html").show("slide-in-right", 300)}
	if (i == 2){窗口操作.预加载窗口("jilu.html"),窗口操作.取指定窗口("jilu.html").show("slide-in-right", 300)}
	if (i == 3){
		if (读写设置.读取设置("用户帐号") != "" && 读写设置.读取设置("用户密码") != null && 读写设置.读取设置("用户时间") != null){
			窗口操作.预加载窗口("chaxundaili.html"),窗口操作.取指定窗口("chaxundaili.html").show("slide-in-right", 300);
		}else{
			窗口操作.预加载窗口("login.html"),窗口操作.取指定窗口("login.html").show("slide-in-right");
		}
	}
}
function 竖排列表项目被单击(i){
	if (i == 0){
		if (读写设置.读取设置("用户帐号") != "" && 读写设置.读取设置("用户密码") != null && 读写设置.读取设置("用户时间") != null){
			窗口操作.预加载窗口("pay.html"),窗口操作.取指定窗口("pay.html").show("slide-in-right", 300);
		}else{
			窗口操作.预加载窗口("login.html"),窗口操作.取指定窗口("login.html").show("slide-in-right");
			}
	}else if (i == 1){
		if (读写设置.读取设置("用户帐号") != "" && 读写设置.读取设置("用户密码") != null && 读写设置.读取设置("用户时间") != null){
			微信分享1.分享到QQ好友(读写设置.读取设置("下载地址"),"【"+读写设置.读取设置("分享标题")+"】邀请码："+读写设置.读取设置("邀请码"),读写设置.读取设置("分享内容"),读写设置.读取设置("分享图片"),"");
		}else{
			微信分享1.分享到QQ好友(读写设置.读取设置("下载地址"),读写设置.读取设置("分享标题"),读写设置.读取设置("分享内容"),读写设置.读取设置("分享图片"),"");
			}
	}else if (i == 2){
		if (读写设置.读取设置("用户帐号") != "" && 读写设置.读取设置("用户密码") != null && 读写设置.读取设置("用户时间") != null){
			窗口操作.预加载窗口("liuyan.html"),窗口操作.取指定窗口("liuyan.html").show("slide-in-right", 300);
		}else{
			窗口操作.预加载窗口("login.html"),窗口操作.取指定窗口("login.html").show("slide-in-right", 300);
			}
	}else if (i == 3){
		窗口操作.预加载窗口("shiyanshi.html"),窗口操作.取指定窗口("shiyanshi.html").show("slide-in-right", 300);
	}else if (i == 4){
		窗口操作.预加载窗口("setting.html"),窗口操作.取指定窗口("setting.html").show("slide-in-right", 300);
	}else if (i == 5){
		窗口操作.预加载窗口("shezhi.html"),窗口操作.取指定窗口("shezhi.html").show("slide-in-right", 300);
		}
}


function Caidan_切换完毕(附加参数){
	刷新主题颜色();
	刷新登录数据();
}
function 刷新主题颜色(){
获取主题颜色();
背景颜色 = 读写设置.读取设置("背景颜色"),默认颜色 = 读写设置.读取设置("默认颜色"),激活颜色 = 读写设置.读取设置("激活颜色"),菜单消息 = 读写设置.读取设置("菜单消息"),菜单收藏 = 读写设置.读取设置("菜单收藏"),菜单记录 = 读写设置.读取设置("菜单记录"),菜单代理 = 读写设置.读取设置("菜单代理");
document.getElementById("登录").style = "height: 120px;background: " + 背景颜色 + ";";
document.getElementById("横排列表框").getElementsByTagName("img")[0].src = "images/yi9caidan/xx/" + 菜单消息;
document.getElementById("横排列表框").getElementsByTagName("img")[1].src = "images/yi9caidan/sc/" + 菜单收藏;
document.getElementById("横排列表框").getElementsByTagName("img")[2].src = "images/yi9caidan/jl/" + 菜单记录;
document.getElementById("横排列表框").getElementsByTagName("img")[3].src = "images/yi9caidan/dl/" + 菜单代理;
document.getElementById("横排列表框").getElementsByTagName("p")[0].style.color = 背景颜色;
document.getElementById("横排列表框").getElementsByTagName("p")[1].style.color = 背景颜色;
document.getElementById("横排列表框").getElementsByTagName("p")[2].style.color = 背景颜色;
document.getElementById("横排列表框").getElementsByTagName("p")[3].style.color = 背景颜色;
document.getElementById("高级列表框1").getElementsByTagName("div")[0].style.color = 背景颜色;
document.getElementById("高级列表框1").getElementsByTagName("div")[1].style.color = 背景颜色;
document.getElementById("高级列表框1").getElementsByTagName("div")[2].style.color = 背景颜色;
document.getElementById("高级列表框1").getElementsByTagName("div")[3].style.color = 背景颜色;
document.getElementById("高级列表框1").getElementsByTagName("div")[4].style.color = 背景颜色;
document.getElementById("高级列表框1").getElementsByTagName("div")[5].style.color = 背景颜色;
document.getElementById("高级列表框1").getElementsByTagName("img")[0].src = "images/yi9caidan2/cz/" + 列表框图片1;
document.getElementById("高级列表框1").getElementsByTagName("img")[1].src = "images/yi9caidan2/fx/" + 列表框图片2;
document.getElementById("高级列表框1").getElementsByTagName("img")[2].src = "images/yi9caidan2/fk/" + 列表框图片3;
document.getElementById("高级列表框1").getElementsByTagName("img")[3].src = "images/yi9caidan2/gy/" + 列表框图片5;
document.getElementById("高级列表框1").getElementsByTagName("img")[4].src = "images/yi9caidan2/sz/" + 列表框图片4;
document.getElementById("高级列表框1").getElementsByTagName("img")[5].src = "images/yi9caidan2/tc/" + 列表框图片6;
}
function 获取主题颜色(){
if (读写设置.读取设置("主题颜色") == "蓝白"){列表框图片1 = "cz1.png",列表框图片2 = "fx1.png",列表框图片3 = "fk1.png",列表框图片4 = "sz1.png",列表框图片5 = "gy1.png",列表框图片6 = "tc1.png"}
if (读写设置.读取设置("主题颜色") == "黑金"){列表框图片1 = "cz2.png",列表框图片2 = "fx2.png",列表框图片3 = "fk2.png",列表框图片4 = "sz2.png",列表框图片5 = "gy2.png",列表框图片6 = "tc2.png"}
if (读写设置.读取设置("主题颜色") == "酷安绿"){列表框图片1 = "cz3.png",列表框图片2 = "fx3.png",列表框图片3 = "fk3.png",列表框图片4 = "sz3.png",列表框图片5 = "gy3.png",列表框图片6 = "tc3.png"}
if (读写设置.读取设置("主题颜色") == "网易红"){列表框图片1 = "cz4.png",列表框图片2 = "fx4.png",列表框图片3 = "fk4.png",列表框图片4 = "sz4.png",列表框图片5 = "gy4.png",列表框图片6 = "tc4.png"}
if (读写设置.读取设置("主题颜色") == "哔哩粉"){列表框图片1 = "cz5.png",列表框图片2 = "fx5.png",列表框图片3 = "fk5.png",列表框图片4 = "sz5.png",列表框图片5 = "gy5.png",列表框图片6 = "tc5.png"}
if (读写设置.读取设置("主题颜色") == "咖啡棕"){列表框图片1 = "cz6.png",列表框图片2 = "fx6.png",列表框图片3 = "fk6.png",列表框图片4 = "sz6.png",列表框图片5 = "gy6.png",列表框图片6 = "tc6.png"}
if (读写设置.读取设置("主题颜色") == "柠檬橙"){列表框图片1 = "cz7.png",列表框图片2 = "fx7.png",列表框图片3 = "fk7.png",列表框图片4 = "sz7.png",列表框图片5 = "gy7.png",列表框图片6 = "tc7.png"}
if (读写设置.读取设置("主题颜色") == "星空灰"){列表框图片1 = "cz8.png",列表框图片2 = "fx8.png",列表框图片3 = "fk8.png",列表框图片4 = "sz8.png",列表框图片5 = "gy8.png",列表框图片6 = "tc8.png"}
}