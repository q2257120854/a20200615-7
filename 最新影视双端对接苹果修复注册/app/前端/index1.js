mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

if(mui.os.plus){
    mui.plusReady(function() {
        index1_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        index1_创建完毕();
        
    }
}
var mui_back = mui.back;
mui.back = function() {
    if (index1_按下返回键()!=true) {
        mui_back();
    }
};

var 启动时间;
var 按下次数= 0;
var indexx = 2;
var 背景颜色 = 读写设置.读取设置("背景颜色");
var 背景默认颜色 = 读写设置.读取设置("默认颜色");
var 默认颜色 = "#A7A7A7";
var 激活颜色 = 读写设置.读取设置("激活颜色");
var 搜索颜色 = 读写设置.读取设置("搜索颜色");

var 首页图标 = "sy.png";
var 发现图标 = "fx.png";
var 直播图标 = "zb.png";
var 我的图标 = "wd.png";

var 首页图标1 = 读写设置.读取设置("首页图标1");
var 发现图标1 = 读写设置.读取设置("发现图标1");
var 直播图标1 = 读写设置.读取设置("直播图标1");
var 我的图标1 = 读写设置.读取设置("我的图标1");
var 当前激活项目 = 0;
var 启动时间;
var 按下次数= 0;
var div = document.createElement("div");
	div.innerHTML = "<ul id=壹九底部导航 style='position:fixed;bottom:0px;height:50px;margin:0px 0px 0px 0px;padding: 0px 0px 0px 0px;background-color:#FFF;width: 100%;z-index:999999;' >"+
	"<li style='padding: 5px 0px 0px 0px;width: 25%;height: auto;background-color: rgba(255,255,255,255);display: inline-table;text-align: -webkit-center;margin: 0;' data-index='0'>"+
	"<img id=img0 style='width:20px;' src=images/yi9bottom/sy/" + 首页图标1 + " /><p id=p0 style='color: " + 背景颜色 +";font-size: 10px;margin: 0;'>Hello</p></li>"+
	"<li style='padding: 5px 0px 0px 0px;width: 25%;height: auto;background-color: rgba(255,255,255,255);display: inline-table;text-align: -webkit-center;margin: 0;' data-index='1'>"+
	"<img id=img1 style='width:20px;' src=images/yi9bottom/fx/" + 发现图标 + " /><p id=p1 style='color: " + 默认颜色 +";font-size: 10px;margin: 0;'>全部</p></li>"+
	"<li style='padding: 5px 0px 0px 0px;width: 25%;height: auto;background-color: rgba(255,255,255,255);display: inline-table;text-align: -webkit-center;margin: 0;' data-index='2'>"+
	"<img id=img2 style='width:20px;' src=images/yi9bottom/zb/" + 直播图标 + " /><p id=p2 style='color: " + 默认颜色 +";font-size: 10px;margin: 0;'>直播</p></li>"+
	"<li style='padding: 5px 0px 0px 0px;width: 25%;height: auto;background-color: rgba(255,255,255,255);display: inline-table;text-align: -webkit-center;margin: 0;' data-index='3'>"+
	"<img id=img3 style='width:20px;' src=images/yi9bottom/wd/" + 我的图标 + " /><p id=p3 style='color: " + 默认颜色 +";font-size: 10px;margin: 0;'>我的</p></li>"+
	"</ul>";
	document.body.appendChild(div);
	document.body.querySelectorAll("div")[0].insertBefore(div, document.body.nextSibling);
	mui("#壹九底部导航").on("tap", "li", function() { 壹九底部导航被单击(this.getAttribute("data-index"));});
function index1_创建完毕(){
	启动时间 = 时间操作.取当前日期时间();
var obj1 = plus.webview.getWebviewById("index1.html");
var style = {top:"0px",bottom:"50px",hardwareAccelerated:true};
var obj2 = plus.webview.create("main.html", "main.html", style);
	obj1.append(obj2);
	plus.webview.show(obj2);
var obj2 = plus.webview.create("shipin1.html", "shipin1.html", style);
	obj1.append(obj2);
	plus.webview.hide(obj2);
var obj2 = plus.webview.create("zhibo1.html", "zhibo1.html", style);
	obj1.append(obj2);
	plus.webview.hide(obj2);
var obj2 = plus.webview.create("caidan.html", "caidan.html", style);
	obj1.append(obj2);
	plus.webview.hide(obj2);
	plus.navigator.setStatusBarStyle("UIStatusBarStyleBlackOpaque");
}
function 壹九底部导航被单击(i){
	当前激活项目 = i;
if (i == 0){
	document.getElementById("p0").style.color = 背景颜色;
	document.getElementById("p1").style.color = 默认颜色;
	document.getElementById("p2").style.color = 默认颜色;
	document.getElementById("p3").style.color = 默认颜色;
	document.getElementById("img0").src = "images/yi9bottom/sy/" + 首页图标1;
	document.getElementById("img1").src = "images/yi9bottom/fx/" + 发现图标;
	document.getElementById("img2").src = "images/yi9bottom/zb/" + 直播图标;
	document.getElementById("img3").src = "images/yi9bottom/wd/" + 我的图标;
	窗口操作.取指定窗口("main.html").show("none", 0)}
if (i == 1){
	document.getElementById("p0").style.color = 默认颜色;
	document.getElementById("p1").style.color = 背景颜色;
	document.getElementById("p2").style.color = 默认颜色;
	document.getElementById("p3").style.color = 默认颜色;
	document.getElementById("img0").src = "images/yi9bottom/sy/" + 首页图标;
	document.getElementById("img1").src = "images/yi9bottom/fx/" + 发现图标1;
	document.getElementById("img2").src = "images/yi9bottom/zb/" + 直播图标;
	document.getElementById("img3").src = "images/yi9bottom/wd/" + 我的图标;
	窗口操作.取指定窗口("shipin1.html").show("none", 0)}
if (i == 2){
	document.getElementById("p0").style.color = 默认颜色;
	document.getElementById("p1").style.color = 默认颜色;
	document.getElementById("p2").style.color = 背景颜色;
	document.getElementById("p3").style.color = 默认颜色;
	document.getElementById("img0").src = "images/yi9bottom/sy/" + 首页图标;
	document.getElementById("img1").src = "images/yi9bottom/fx/" + 发现图标;
	document.getElementById("img2").src = "images/yi9bottom/zb/" + 直播图标1;
	document.getElementById("img3").src = "images/yi9bottom/wd/" + 我的图标;
	窗口操作.取指定窗口("zhibo1.html").show("none", 0)}
if (i == 3){
	document.getElementById("p0").style.color = 默认颜色;
	document.getElementById("p1").style.color = 默认颜色;
	document.getElementById("p2").style.color = 默认颜色;
	document.getElementById("p3").style.color = 背景颜色;
	document.getElementById("img0").src = "images/yi9bottom/sy/" + 首页图标;
	document.getElementById("img1").src = "images/yi9bottom/fx/" + 发现图标;
	document.getElementById("img2").src = "images/yi9bottom/zb/" + 直播图标;
	document.getElementById("img3").src = "images/yi9bottom/wd/" + 我的图标1;
	窗口操作.取指定窗口("caidan.html").show("none", 0)}
}

function 切换分类(){
首页图标1 = 读写设置.读取设置("首页图标1"),发现图标1 = 读写设置.读取设置("发现图标1"),直播图标1 = 读写设置.读取设置("直播图标1"),我的图标1 = 读写设置.读取设置("我的图标1"),document.getElementById("p0").style.color = 默认颜色,document.getElementById("p1").style.color = 背景颜色,document.getElementById("p2").style.color = 默认颜色,document.getElementById("p3").style.color = 默认颜色;
document.getElementById("img0").src = "images/yi9bottom/sy/sy.png";
document.getElementById("img1").src = "images/yi9bottom/fx/" + 发现图标1;
document.getElementById("img2").src = "images/yi9bottom/zb/zb.png";
document.getElementById("img3").src = "images/yi9bottom/wd/wd.png";
窗口操作.取指定窗口("shipin1.html").show("none", 0);
}

function 刷新主题颜色(){
首页图标1 = 读写设置.读取设置("首页图标1");
发现图标1 = 读写设置.读取设置("发现图标1");
直播图标1 = 读写设置.读取设置("直播图标1");
我的图标1 = 读写设置.读取设置("我的图标1");

if (读写设置.读取设置("主题颜色") == "" || 读写设置.读取设置("主题颜色") == null || 读写设置.读取设置("主题颜色") == null) {
	读写设置.保存设置("主题颜色","网易红");
	背景颜色 = "#364F59";
	默认颜色 = "#f0f0f0";
	激活颜色 = "#FFFFFF"}
if (读写设置.读取设置("主题颜色") == "蓝白"){
	背景颜色 = "#0088FF";
	默认颜色 = "#f0f0f0";
	激活颜色 = "#FFFFFF"}
if (读写设置.读取设置("主题颜色") == "黑金"){
	背景颜色 = "#000000";
	默认颜色 = "#f0f0f0";
	激活颜色 = "#FFE28A"}
if (读写设置.读取设置("主题颜色") == "酷安绿"){
	背景颜色 = "#4BAF4E";
	默认颜色 = "#f0f0f0";
	激活颜色 = "#FFFFFF"}
if (读写设置.读取设置("主题颜色") == "网易红"){
	背景颜色 = "#D33A2F";
	默认颜色 = "#f0f0f0";
	激活颜色 = "#FFFFFF"}
if (读写设置.读取设置("主题颜色") == "哔哩粉"){
	背景颜色 = "#B47DB4";
	默认颜色 = "#f0f0f0";
	激活颜色 = "#FFFFFF"}
if (读写设置.读取设置("主题颜色") == "咖啡棕"){
	背景颜色 = "#75655A";
	默认颜色 = "#f0f0f0";
	激活颜色 = "#FFFFFF"}
if (读写设置.读取设置("主题颜色") == "柠檬橙"){
	背景颜色 = "#D88100";
	默认颜色 = "#f0f0f0";
	激活颜色 = "#FFFFFF"}
if (读写设置.读取设置("主题颜色") == "星空灰"){
	背景颜色 = "#364F59";
	默认颜色 = "#f0f0f0";
	激活颜色 = "#FFFFFF"}
	默认颜色 = "#A7A7A7";
if (当前激活项目 == 0){
	document.getElementById("p0").style.color = 背景颜色;
	document.getElementById("p1").style.color = 默认颜色;
	document.getElementById("p2").style.color = 默认颜色;
	document.getElementById("p3").style.color = 默认颜色;
	document.getElementById("img0").src = "images/yi9bottom/sy/" + 首页图标1;
	document.getElementById("img1").src = "images/yi9bottom/fx/" + 发现图标;
	document.getElementById("img2").src = "images/yi9bottom/zb/" + 直播图标;
	document.getElementById("img3").src = "images/yi9bottom/wd/" + 我的图标}
if (当前激活项目 == 1){
	document.getElementById("p0").style.color = 默认颜色;
	document.getElementById("p1").style.color = 背景颜色;
	document.getElementById("p2").style.color = 默认颜色;
	document.getElementById("p3").style.color = 默认颜色;
	document.getElementById("img0").src = "images/yi9bottom/sy/" + 首页图标;
	document.getElementById("img1").src = "images/yi9bottom/fx/" + 发现图标1;
	document.getElementById("img2").src = "images/yi9bottom/zb/" + 直播图标;
	document.getElementById("img3").src = "images/yi9bottom/wd/" + 我的图标}
if (当前激活项目 == 2){
	document.getElementById("p0").style.color = 默认颜色;
	document.getElementById("p1").style.color = 默认颜色;
	document.getElementById("p2").style.color = 背景颜色;
	document.getElementById("p3").style.color = 默认颜色;
	document.getElementById("img0").src = "images/yi9bottom/sy/" + 首页图标;
	document.getElementById("img1").src = "images/yi9bottom/fx/" + 发现图标;
	document.getElementById("img2").src = "images/yi9bottom/zb/" + 直播图标1;
	document.getElementById("img3").src = "images/yi9bottom/wd/" + 我的图标}
if (当前激活项目 == 3){
	document.getElementById("p0").style.color = 默认颜色;
	document.getElementById("p1").style.color = 默认颜色;
	document.getElementById("p2").style.color = 默认颜色;
	document.getElementById("p3").style.color = 背景颜色;
	document.getElementById("img0").src = "images/yi9bottom/sy/" + 首页图标;
	document.getElementById("img1").src = "images/yi9bottom/fx/" + 发现图标;
	document.getElementById("img2").src = "images/yi9bottom/zb/" + 直播图标;
	document.getElementById("img3").src = "images/yi9bottom/wd/" + 我的图标1}
}
function index1_按下返回键(){
	按下次数 = 按下次数 + 1;
	if(时间操作.取时间间隔(时间操作.取当前日期时间(),启动时间) >2000 ){
		mui.toast("再按一次退出程序");
		启动时间 = 时间操作.取当前日期时间();
	}else{
		if(按下次数> 1 ){
			应用操作.结束程序();
		}
	}
	return true;
}