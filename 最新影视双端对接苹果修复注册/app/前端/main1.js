mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 网络操作1 = new 网络操作("网络操作1",网络操作1_发送完毕);
var 网络操作2 = new 网络操作("网络操作2",网络操作2_发送完毕);
var 网络操作3 = new 网络操作("网络操作3",网络操作3_发送完毕);
var 仔仔1 = new 仔仔("仔仔1",null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
if(mui.os.plus){
    mui.plusReady(function() {
        Main1_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        Main1_创建完毕();
        
    }
}
window.addEventListener("customEvent",function(event){Main1_切换完毕(event.detail.param);});

窗口操作.引入css文件("files/minirefresh.css"),窗口操作.引入js文件("files/minirefresh.js"),窗口操作.引入css文件("files/swiper.min.css"),窗口操作.引入css文件("files/yi9lunboQuanping.css"),窗口操作.引入js文件("files/swiper.min.js");
var 背景颜色 = 读写设置.读取设置("背景颜色");
var 默认颜色 = 读写设置.读取设置("默认颜色");
var 激活颜色 = 读写设置.读取设置("激活颜色");
var 搜索颜色 = 读写设置.读取设置("搜索颜色");
var 背景图片 = 读写设置.读取设置("背景图片");
var 第一行列表id = "25";
var 第二行列表id = "13";
var 视频列表图片 = new Array();
var 视频列表标题 = new Array();
var 视频列表地址 = new Array();
var 视频详情地址 = new Array();
var 视频列表图片2 = new Array();
var 视频列表标题2 = new Array();
var 视频列表地址2 = new Array();
var 视频详情地址2 = new Array();
var 初始化切换 = false;
var 初始化分类;
var IMG = new Array();
var BT = new Array();
var URL = new Array();


IMG = 文本操作.取指定文本(读写设置.读取设置("首页广告"),"img=\"","\"");
BT = 文本操作.取指定文本(读写设置.读取设置("首页广告"),"title=\"","\"");
URL= 文本操作.取指定文本(读写设置.读取设置("首页广告"),"href=\"","\"");

var div = document.createElement("div");
	div.innerHTML = "<img id=back src=images/yi9setting/" + 背景图片 + " style='width:100%;height:100px;'></img>";
	div.style = "position:absolute;width:100%;";
	document.body.appendChild(div);
	document.body.querySelectorAll("div")[0].insertBefore(div, document.body.nextSibling);


var css1 = "<div style='margin:0px 0px 0px 0px; padding: 0px '><div class='swiper-container'><div class='swiper-wrapper' id=yi9lunbo >";
var index = 0;
	css1 += "<div class='swiper-slide' onclick=yi9自定义轮播(0)><img src='" + IMG[0] + "' /></a><h3 class='trfocustt'>" + BT[0] + "</h3><span class='trnowclass'></span> </div>";
	css1 += "<div class='swiper-slide' onclick=yi9自定义轮播(1)><img src='" + IMG[1] + "' /></a><h3 class='trfocustt'>" + BT[1] + "</h3><span class='trnowclass'></span> </div>";
	css1 += "<div class='swiper-slide' onclick=yi9自定义轮播(2)><img src='" + IMG[2] + "' /></a><h3 class='trfocustt'>" + BT[2] + "</h3><span class='trnowclass'></span> </div>";
	css1 += "<div class='swiper-slide' onclick=yi9自定义轮播(3)><img src='" + IMG[3] + "' /></a><h3 class='trfocustt'>" + BT[3] + "</h3><span class='trnowclass'></span> </div>";
	css1 += "<div class='swiper-slide' onclick=yi9自定义轮播(4)><img src='" + IMG[4] + "' /></a><h3 class='trfocustt'>" + BT[4] + "</h3><span class='trnowclass'></span> </div>";
	css1 += "</div></div></div>";
var guanggaohtml = "<marquee behavior='scroll' direction='left' style='width: 70%; height:15px;padding:0px 0px 0px 0px;'>" + IMG[0] + "</marquee>";



var css2  = "<div id='更多分类1' style='height:30px;margin: 0px 10px 0px 10px;'>"+
	"<span style='background: #FFF6EA;color: #FB6122;font-size: 14px;font-family: 黑体;padding: 5px 8px 5px 5px;border-radius: 30px;box-shadow: #FFF6EA 0px 1px 10px;'>公告</span>"+
	"<span style='font-size: 13px;margin-left: 10px;border-left: 1px solid #DEDEDE;padding-left: 10px;color: #626262;width: 50%;'>" + guanggaohtml + "</span>"+
	"<span class='mui-icon mui-icon-arrowright' style='float: right;color: #9A9A9A;font-size: 20px;'></span></div>";


var div = document.createElement("div");
	div.innerHTML ="<div>" + css1 + "<div id='更多分类1' style='margin: 0px 5px 0px 5px;'><div id=更多分类标题 style='height:40px;padding:5px 10px 0px 10px;'><p style='color:#000;font-weight:bold;font-size:20px;font-family:黑体;'>推荐电影</p><span class='mui-icon mui-icon-arrowright' style='float: right;margin:-30px 0px 0px 0px;color: #9A9A9A;font-size: 20px;'></span></div><div id='视频列表框' style='margin:0px 0px 0px 0px;'></div></div>";
	div.id = "minirefresh";
	div.class = "minirefresh-wrap";
	div.style = "margin:0px 0px 0px 0px";
	document.body.appendChild(div);
	document.body.querySelectorAll("div")[0].insertBefore(div, document.body.nextSibling);
	mui("#更多分类1").on("tap", "span", function() { 更多列表被单击();});
function Main1_创建完毕(){
	窗口操作.引入js文件("files/chushhua.js");
	var mySwiper = new Swiper (".swiper-container", {direction: "horizontal",loop: true,autoplay: true,slidesPerView: "auto",centeredSlides:true,});

}

function 底部插入div(html){
	var newNodeBottom = document.createElement("div");
	newNodeBottom.innerHTML = html;
	document.getElementById("视频列表框").appendChild(newNodeBottom)}
function 下拉(){
	document.getElementsByClassName("downwrap-content")[0].style.display = "block";
	document.getElementById("视频列表框").innerHTML = "";

if (初始化切换 == false){
	网络操作1.发送网络请求(公用模块.CMSAPI()+ "/api.php/provide/vod/?ac=detail&t=0","get","txt","",12000);
}else{
	网络操作3.发送网络请求(公用模块.CMSAPI() + "/api.php/provide/vod/?ac=detail&t=" + 初始化分类,"get","txt","",12000)}}
function 更多列表被单击(){

	窗口操作.执行代码("index1.html","切换分类()")}
function  刷新主题颜色(){
	背景图片=读写设置.读取设置("背景图片"),document.getElementById("back").src = "images/yi9setting/" + 背景图片;
}
function 更多被单击(i){
	var photo = document.getElementById("壹九列表框1").querySelectorAll("div img")[i].src;
	var title = document.getElementById("壹九列表框1").querySelectorAll("div p")[i].innerText;
	var video = 视频列表地址[i];
	读写设置.保存设置("视频来源","资源站");
	读写设置.保存设置("视频图片",photo);
	公用模块.影视播放(title,video)}
function 更多被单击2(i){
	var photo = document.getElementById("壹九列表框2").querySelectorAll("div img")[i].src;
	var title = document.getElementById("壹九列表框2").querySelectorAll("div p")[i].innerText;
	var video = 视频列表地址2[i];
	读写设置.保存设置("视频来源","资源站");
	读写设置.保存设置("视频图片",photo);
	公用模块.影视播放(title,video)}
function 网络操作1_发送完毕(发送结果,返回信息){
	数组操作.清空数组(视频列表标题);
	数组操作.清空数组(视频列表图片);
	数组操作.清空数组(视频列表地址);
	数组操作.清空数组(视频详情地址);
	var css = "<ul id=壹九列表框1 style='margin:-8px 3px 0px 3px;padding: 0px 0px 0px 0px;text-align:center;background-color: transparent;'>";
	if (发送结果 == true){
	var index = 0;
	var json = 转换操作.文本转json(返回信息);
	mui.each(json.list,function(索引,成员){
	数组操作.加入尾成员(视频列表标题,成员.vod_name);
	数组操作.加入尾成员(视频列表图片,成员.vod_pic);
	数组操作.加入尾成员(视频列表地址,成员.vod_id);
	if (成员.vod_actor == ""){成员.vod_actor = "暂无详情"}
		数组操作.加入尾成员(视频详情地址,成员.vod_actor)});
	while(index < 6){
	css += "<li style='float:left;display:inline; padding: 0px 5px 0px 5px; width: 33.33%; margin-bottom: 10px;' data-index='" + index + "'>"+
	"<div style='position: relative;'>"+
	"<span style='position: absolute;left: 0; right: 0;bottom: 3%;content: ;height: .4rem;z-index: 1;background-repeat: repeat-x;height: 33%;'></span>"+
	"<img id=列表图片 class='mui-media-object;' style='height:130px; width:100%;border-radius:13px 13px 13px 13px;' alt='test' onerror=\"this.src='images/404.jpg'\" src='" + 视频列表图片[index] + "'/></div>"+
	"<div style='margin-top: 4px;text-align: -webkit-left;padding-left: 6px;'>"+
	"<p id =列表标题 style='color: #333;font: 14px/1.5 ; overflow: hidden;text-overflow: ellipsis;display: block;white-space: nowrap;'>" + 视频列表标题[index] + "</p>"+
	"<span id=列表详情 style='margin:-10px 0px 0px 0px; font-size: 12px;color: #999;overflow: hidden;text-overflow: ellipsis;display: block;white-space: nowrap;'>" + 视频详情地址[index] + "</span>"+
	"</div></li>";
	index = index + 1;
	}
	css = css + "</ul>",底部插入div(css);
	mui("#壹九列表框1").on("tap", "li", function() {更多被单击(this.getAttribute("data-index"));});
	var 发现2 = "<div id='更多分类2' style='margin: 10px 10px 20px 10px;'><div id=更多分类标题2 style='padding:5px 0px 0px 0px;'><p style='color:#000;font-weight:bold;font-size:20px;font-family:黑体;'>推荐番剧</p><span class='mui-icon mui-icon-arrowright' style='float: right;margin:-30px 0px 0px 0px;color: #9A9A9A;font-size: 20px;'></span></div></div>";
	底部插入div(发现2);
	网络操作2.发送网络请求(公用模块.CMSAPI() + "/api.php/provide/vod/?ac=detail&t=" + 第二行列表id,"get","txt","",12000)}
}
function 网络操作2_发送完毕(发送结果,返回信息){
	数组操作.清空数组(视频列表标题2);
	数组操作.清空数组(视频列表图片2);
	数组操作.清空数组(视频列表地址2);
	数组操作.清空数组(视频详情地址2);
	var css = "<ul id=壹九列表框2 style='padding: 0px 3px 0px 3px;text-align:center;background-color: transparent;'>";
	if (发送结果 == true){
	var index = 0;
	var json = 转换操作.文本转json(返回信息);
	mui.each(json.list,function(索引,成员){
	数组操作.加入尾成员(视频列表标题2,成员.vod_name);
	数组操作.加入尾成员(视频列表图片2,成员.vod_pic);
	数组操作.加入尾成员(视频列表地址2,成员.vod_id);
		if (成员.vod_actor == ""){成员.vod_actor = "暂无详情"}
			数组操作.加入尾成员(视频详情地址2,成员.vod_actor)});
		while(index < 6){
			css += "<li style='float:left;display:inline; padding: 0px 5px 0px 5px; width: 33.33%; margin-bottom: 10px;' data-index='" + index + "'>"+

			"<div style='position: relative;'>"+
			"<span style='position: absolute;left: 0; right: 0;bottom: 3%;content: ;height: .4rem;z-index: 1;background-repeat: repeat-x;height: 33%;'></span>"+
			"<img id=列表图片 class='mui-media-object;' style='height:130px; width:100%;border-radius:13px 13px 13px 13px;' alt='test' onerror=\"this.src='images/404.jpg'\" src='" + 视频列表图片2[index] + "'/></div>"+

			"<div class='hengtudiv' style='margin-top:4px;margin-top: 4px;text-align: -webkit-left;padding-left: 10px;'>"+
			"<p id =列表标题 style='color: #333;font: 14px/1.5 ; overflow: hidden;text-overflow: ellipsis;display: block;white-space: nowrap;'>" + 视频列表标题2[index] + "</p>"+
			"<span id=列表详情 style='margin:-10px 0px 0px 0px; font-size: 12px;color: #999;overflow: hidden;text-overflow: ellipsis;display: block;white-space: nowrap;'>" + 视频详情地址2[index] + "</span>"+
			"</div></li>";
			index = index + 1;
		}
		底部插入div(css);
		mui("#壹九列表框2").on("tap", "li", function() {更多被单击2(this.getAttribute("data-index"));});

		miniRefresh.endDownLoading(true);
		document.getElementsByClassName("downwrap-content")[0].style.display = "none";
		miniRefresh._lockUpLoading(true);
		document.getElementsByClassName("minirefresh-upwrap minirefresh-hardware-speedup status-default")[0].style.display= "none";
	}
}

function 切换列表(i){
	if (i == "0"){
		初始化切换 = false;
		初始化分类 = 公用模块.推荐分类();
		miniRefresh.triggerDownLoading()}
	if (i == "1"){
		初始化切换 = true;
		初始化分类 = 公用模块.电影分类();
		miniRefresh.triggerDownLoading()}
	if (i == "2"){
		初始化切换 = true;
		初始化分类 = 公用模块.电视分类();
		miniRefresh.triggerDownLoading()}
	if (i == "3"){
		初始化切换 = true;
		初始化分类 = 公用模块.综艺分类();
		miniRefresh.triggerDownLoading()}
	if (i == "4"){
		初始化切换 = true;
		初始化分类 = 公用模块.动漫分类();
		miniRefresh.triggerDownLoading()}
}

function 网络操作3_发送完毕(发送结果,返回信息){
	数组操作.清空数组(视频列表标题);
	数组操作.清空数组(视频列表图片);
	数组操作.清空数组(视频列表地址);
	数组操作.清空数组(视频详情地址);

	var css = "<ul id=壹九列表框1 class='mui-table-view mui-grid-view' style='padding: 5px 2px 0px 0px;text-align:center;background-color: transparent;'>";
	if (发送结果 == true){
		var index = 0;
		var json = 转换操作.文本转json(返回信息);
		console.log(json);
		mui.each(json.list,function(索引,成员){
			数组操作.加入尾成员(视频列表标题,成员.vod_name);
			数组操作.加入尾成员(视频列表图片,成员.vod_pic);
			数组操作.加入尾成员(视频列表地址,成员.vod_id);
			if (成员.vod_actor == ""){
				成员.vod_actor = "暂无详情";
			}
			数组操作.加入尾成员(视频详情地址,成员.vod_actor);
		});
		while(index < 18){
			css += "<li style='float:left;display:inline; padding: 0px 5px 0px 5px; width: 33.33%; margin-bottom: 10px;' data-index='" + index + "'>"+

			"<div style='position: relative;'>"+
			"<span style='position: absolute;left: 0; right: 0;bottom: 3%;content: ;height: .4rem;z-index: 1;background-repeat: repeat-x;height: 33%;'></span>"+
			"<img id=列表图片 class='mui-media-object;' style='height:130px; width:100%;border-radius:13px 13px 13px 13px;' alt='test' onerror=\"this.src='images/404.jpg'\" src='" + 视频列表图片[index] + "'/></div>"+

			"<div class='hengtudiv' style='margin-top:4px;margin-top: 4px;text-align: -webkit-left;padding-left: 10px;'>"+
			"<p id =列表标题 style='color: #333;font: 14px/1.5 ; overflow: hidden;text-overflow: ellipsis;display: block;white-space: nowrap;'>" + 视频列表标题[index] + "</p>"+
			"<span id=列表详情 style='margin:-10px 0px 0px 0px; font-size: 12px;color: #999;overflow: hidden;text-overflow: ellipsis;display: block;white-space: nowrap;'>" + 视频详情地址[index] + "</span>"+
			"</div></li>";
			index = index + 1;
		}
		css = css + "</ul>";
		底部插入div(css);
		mui("#壹九列表框1").on("tap", "li", function() {更多被单击(this.getAttribute("data-index"));});
		miniRefresh.endDownLoading(true);
		miniRefresh._lockUpLoading(true);
		document.getElementsByClassName("minirefresh-upwrap minirefresh-hardware-speedup status-default")[0].style.display= "none";
	}
}

function yi9自定义轮播(i){
console.log(i);
console.log(URL[i]);
if (文本操作.寻找文本(URL[i],"http",0) != -1){
	窗口操作.打开指定网址(URL[i],2);
}else{
	读写设置.保存设置("视频图片",IMG[i] );
	读写设置.保存设置("视频来源","资源站"),公用模块.影视播放(IMG[i],URL[i])}
}

function Main1_切换完毕(附加参数){

}