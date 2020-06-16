mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 网络操作1 = new 网络操作("网络操作1",null);
if(mui.os.plus){
    mui.plusReady(function() {
        Main_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        Main_创建完毕();
        
    }
}

窗口操作.引入css文件("files/minirefresh.css");
窗口操作.引入css文件("files/swiper.min.css");
窗口操作.引入css文件("files/lunbo.css");
窗口操作.引入js文件("files/swiper.min.js");
窗口操作.引入js文件("files/minirefresh.js");
var 背景颜色 = 读写设置.读取设置("背景颜色");
var 默认颜色 = 读写设置.读取设置("默认颜色");
var 激活颜色 = 读写设置.读取设置("激活颜色");
var 搜索颜色 = 读写设置.读取设置("搜索颜色");
var 当前激活项目 = 0;
var videourl;
var div = "<header id='19自定义logo' class='mui-bar mui-bar-nav' style='height:45px; box-shadow: rgb(32, 32, 32) 0px 0px 0px; background: " + 背景颜色 + "'>"+
	"<a class='mui-action-back1   mui-pull-left' style='color: rgb(0, 136, 255);'><img src='images/mainlogo.png' style='width: 80%;height:80%;'></a>"+
	"<h1 class='mui-title' style='color:#FFE28A;'></h1>"+
	"<a class='  mui-pull-right' style='color: rgb(255, 255, 255);'></a>"+
	"</header>";


var div = document.createElement("div");
	div.innerHTML ="<div id='yi9自定义导航' class='DaoHang' style='padding:5px 0px 0px 0px; margin:0px 0px 0px 0px;position:fixed;top:0px;left:0px;z-index:9999;width: 100%;height: 40px;background-color: " + 背景颜色 + ";overflow: hidden;margin-bottom: 0px;'>"+
	"<div id='nv0' class='nav0' index='0' style='float: left;width: 20%;height: 35px;padding-bottom：0px;display:table-cell;vertical-align: middle;text-align: center;'><span class='p3' style='color:" + 激活颜色 + " ; font-weight: bold;height: 100%;font-size: 18px;line-height: 35px;text-align: center;'>推荐</span></div>"+
	"<div id='nv1' class='nav1' index='1' style='float: left;width: 20%;height: 35px;padding-bottom：0px;display:table-cell;vertical-align: middle;text-align: center;'><span class='p3' style='height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;'>电影</span></div>"+
	"<div id='nv2' class='nav2' index='2' style='float: left;width: 20%;height: 35px;padding-bottom：0px;display:table-cell;vertical-align: middle;text-align: center;'><span class='p3' style='height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;'>电视</span></div>"+
	"<div id='nv3' class='nav3' index='3' style='float: left;width: 20%;height: 35px;padding-bottom：0px;display:table-cell;vertical-align: middle;text-align: center;'><span class='p3' style='height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;'>综艺</span></div>"+
	"<div id='nv4' class='nav4' index='4' style='float: left;width: 20%;height: 35px;padding-bottom：0px;display:table-cell;vertical-align: middle;text-align: center;'><span class='p3' style='height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;'>动漫</span></div></div>"+
	"<div id=大搜索列表框 style='width:100%; margin: 38px 0px 0px 0px; display: -webkit-flex; z-index:999999; background: " + 背景颜色 + "'><label style='width: 78%; color: rgb(0, 0, 0); font-size: 14px; margin: 0px; padding: 11px 0px; text-align: left;'>"+
	"<div id=yi9自定义搜索框 style='height: 25px;border-radius: 30px;margin: 5px 15px;overflow: hidden;background-color: " + 搜索颜色 + "; '><div style='height:50px;overflow:hidden;text-align: -webkit-left;font-family: SimHei;color:#e69da7;padding: 3px 18px 0px 20px;'><div>"+
	"<div style='font-size: 12px;font-weight: normal; color: " + 默认颜色 + "';>快输入搜索内容~</div></div></div></div></label>"+
	"<label id=yi9自定义记录 style='width: 10%; color: rgb(0, 0, 0); font-size: 14px; margin: 0px 0px 0px 0px; padding: 11px 0px; text-align: center;'><img src='images/yi9main/yi9main_jl.png' style='width: 20px;height:20px;margin: 6px 0px 0px 0px; '></label>"+
	"<label id=yi9自定义更多 style='width: 10%; color: rgb(0, 0, 0); font-size: 14px; margin: 0px 0px 0px 0px; padding: 11px 0px; text-align: center;'><img src='images/yi9main/yi9main_gd.png' style='width: 20px;height:20px;margin: 7px 0px 0px 0px; '></label></div>";
	document.body.appendChild(div);
	document.body.querySelectorAll("div")[0].insertBefore(div, document.body.nextSibling);
	mui("#yi9自定义导航").on("tap", "div", function() {yi9自定义导航(Number(this.getAttribute("index")));});
	document.getElementById("yi9自定义搜索框").addEventListener("click", function() { yi9自定义搜索框(0);}, false);
	document.getElementById("yi9自定义记录").addEventListener("click", function() { yi9自定义搜索框(1);}, false);
	document.getElementById("yi9自定义更多").addEventListener("click", function() { yi9自定义搜索框(2);}, false);

function Main_创建完毕(){

	var obj1 = plus.webview.getWebviewById("main.html");
	var style = {top:"91px",bottom:"0px",hardwareAccelerated:true};
	var obj2 = plus.webview.create("main1.html", "main1.html", style);
	obj1.append(obj2);
	plus.webview.show(obj2);
}
function yi9自定义搜索框(i){
if (i == "0"){
	窗口操作.预加载窗口("sousuo.html");
	窗口操作.取指定窗口("sousuo.html").show("slide-in-right", 300)}
if (i == "1"){
	窗口操作.预加载窗口("jilu.html");
	窗口操作.取指定窗口("jilu.html").show("slide-in-right", 300)}
if (i == "2"){
	窗口操作.执行代码("index1.html","切换分类()")}
}

function yi9自定义导航(i){
	console.log(i);
	当前激活项目 = i;
if (i == "0"){
	document.getElementById("nv0").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ; font-weight: bold;height: 100%;font-size: 18px;line-height: 35px;text-align: center;";
	document.getElementById("nv1").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv2").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv3").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv4").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	窗口操作.执行代码("main1.html","切换列表(0)")}
if (i == "1"){
	document.getElementById("nv0").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv1").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ; font-weight: bold;height: 100%;font-size: 18px;line-height: 35px;text-align: center;";
	document.getElementById("nv2").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv3").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv4").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	窗口操作.执行代码("main1.html","切换列表(1)")}
if (i == "2"){
	document.getElementById("nv0").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv1").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv2").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ; font-weight: bold;height: 100%;font-size: 18px;line-height: 35px;text-align: center;";
	document.getElementById("nv3").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv4").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	窗口操作.执行代码("main1.html","切换列表(2)")}
if (i == "3"){
	document.getElementById("nv0").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv1").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv2").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv3").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ; font-weight: bold;height: 100%;font-size: 18px;line-height: 35px;text-align: center;";
	document.getElementById("nv4").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	窗口操作.执行代码("main1.html","切换列表(3)")}
if (i == "4"){
	document.getElementById("nv0").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv1").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv2").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv3").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv4").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ; font-weight: bold;height: 100%;font-size: 18px;line-height: 35px;text-align: center;";
	窗口操作.执行代码("main1.html","切换列表(4)")}
}

function 刷新主题颜色(){
背景颜色 = 读写设置.读取设置("背景颜色");
默认颜色 = 读写设置.读取设置("默认颜色");
激活颜色 = 读写设置.读取设置("激活颜色");
搜索颜色 = 读写设置.读取设置("搜索颜色");
document.getElementById("大搜索列表框").style.background = 背景颜色;
document.getElementById("yi9自定义搜索框").style = "height: 25px;border-radius: 30px;margin: 5px 15px;overflow: hidden;background-color: " + 搜索颜色 + "; ";
document.getElementById("yi9自定义导航").style = "padding:5px 0px 0px 0px; margin:0px 0px 0px 0px;position:fixed;top:0px;left:0px;z-index:9999;width: 100%;height: 40px;background-color: " + 背景颜色 + ";overflow: hidden;margin-bottom: 0px;";
if (当前激活项目 == "0"){
	document.getElementById("nv0").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ; font-weight: bold;height: 100%;font-size: 18px;line-height: 35px;text-align: center;";
	document.getElementById("nv1").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv2").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv3").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv4").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;"}
if (当前激活项目 == "1"){
	document.getElementById("nv0").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv1").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ; font-weight: bold;height: 100%;font-size: 18px;line-height: 35px;text-align: center;";
	document.getElementById("nv2").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv3").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv4").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;"}
if (当前激活项目 == "2"){
	document.getElementById("nv0").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv1").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv2").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ; font-weight: bold;height: 100%;font-size: 18px;line-height: 35px;text-align: center;";
	document.getElementById("nv3").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv4").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;"}
if (当前激活项目 == "3"){
	document.getElementById("nv0").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv1").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv2").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv3").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ; font-weight: bold;height: 100%;font-size: 18px;line-height: 35px;text-align: center;";
	document.getElementById("nv4").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;"}
if (当前激活项目 == "4"){
	document.getElementById("nv0").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv1").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv2").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv3").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv4").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ; font-weight: bold;height: 100%;font-size: 18px;line-height: 35px;text-align: center;"}
}