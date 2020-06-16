mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 标题栏1 = new 标题栏("标题栏1",null,null,标题栏1_左侧图标被单击);
var 正则1 = new 正则("正则1");
var 网络操作1 = new 网络操作("网络操作1",网络操作1_发送完毕);
var 网络操作2 = new 网络操作("网络操作2",网络操作2_发送完毕);
var 网络操作3 = new 网络操作("网络操作3",网络操作3_发送完毕);
var 时钟1 = new 时钟("时钟1",时钟1_周期事件);
var baby直播1 = new baby直播("baby直播1");
if(mui.os.plus){
    mui.plusReady(function() {
        TVzhubo_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        TVzhubo_创建完毕();
        
    }
}
var mui_back = mui.back;
mui.back = function() {
    if (TVzhubo_按下返回键()!=true) {
        mui_back();
    }
};

var 全部数据数组 = new Array();
var 页码 = 1;
var 标题;
var 背景颜色 = 读写设置.读取设置("背景颜色");
var 默认颜色 = 读写设置.读取设置("默认颜色");
var 激活颜色 = 读写设置.读取设置("激活颜色");
document.getElementById("标题栏1").style.background = 背景颜色;
document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色;

document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + "; margin:6px 0px 0px 0px;'>" + 读写设置.读取设置("主播标题") + "</h1>";
窗口操作.引入css文件("files/yi9zhibolist2.css");
窗口操作.引入css文件("files/minirefresh.css");
窗口操作.引入js文件("files/minirefresh.js");
var div=document.createElement("div");
	div.innerHTML ="<div><div id='视频列表框' class='shipinliebiao' style=''></div></div>";
	div.id = "minirefresh";
	div.class = "minirefresh-wrap";
	div.style = "margin:0px 0px 0px 0px";
	document.body.appendChild(div);
	document.body.querySelectorAll("div")[0].insertBefore(div, document.body.nextSibling);
function TVzhubo_创建完毕(){
	窗口操作.引入js文件("files/chushhua.js");
}

function 下拉(){
	document.getElementById("视频列表框").innerHTML = "";
	if (读写设置.读取设置("直播类型") == "虎牙"){
		网络操作1.发送网络请求(读写设置.读取设置("主播列表"),"get","txt","",12000);
	}
	if (读写设置.读取设置("直播类型") == "聚合"){
		网络操作3.发送网络请求("http://api.hclyz.com:81/mf/" + 读写设置.读取设置("主播列表"),"get","txt","",12000);

	}
}

function 网络操作1_发送完毕(发送结果,返回信息){
	数组操作.清空数组(全部数据数组);
	返回信息 = 文本操作.删全部空(返回信息);
	var 地址;
	var 图片;
	var 标题;
	var 人数;
	var 主播;
	var i = 0;
	var index = 0;
	正则1.创建正则(返回信息,"<aclass=\"clickstatg-link\"(.*?)</div></div></div></a>");
	while(index != 正则1.取匹配数量()){
		var 全部数组 = 正则1.取子匹配文本(index,1);
		数组操作.加入尾成员(全部数据数组,全部数组);
		index = index + 1;
	}

	var css = "<ul id='壹九列表框1'class='mui-table-view mui-grid-view ul'>";
	var index = 0;
	while(i != 数组操作.取成员数(全部数据数组)){
		地址 = 公用模块.取中间文本(全部数据数组[i],"href=\"","\"data-uid=");
		图片 = 公用模块.取中间文本(全部数据数组[i],"<imgclass=\"pic-con\"src=\"","\"/></div>");
		if (文本操作.寻找文本(图片,"original=",0) != -1){
			图片 = 公用模块.取中间文本(图片,"original=\"","\"src=");
		}
		if (文本操作.寻找文本(图片,"http",0) != -1){

		}else{
			图片 = "http:" + 图片;
		}
		标题 = 公用模块.取中间文本(全部数据数组[i],"title\">","</p>");
		人数 = 公用模块.取中间文本(全部数据数组[i],"viewer-count\">","</span>");
		主播 = 公用模块.取中间文本(全部数据数组[i],"nick\">","</span>");
		css += "<li class='mui-table-view-cell mui-media li' tag='" + 地址 + "'>"+
				"<div class='imgdiv'><img src=" + 图片 + " /><div>"+
				"<span><i class='iconfont icon-Play_big_x'></i></span>"+
				"</div></div>"+
				"<div class='lidb'><p>" + 标题 + "</p><div>"+
				"<i class='iconfont icon-caidan'></i>"+
				"</div></div>";
		i = i + 1;
	}
	var newNodeBottom = document.createElement("div");
		   newNodeBottom.innerHTML = css;
		document.getElementById("视频列表框").appendChild(newNodeBottom);

		miniRefresh.endDownLoading(true);

		mui("#壹九列表框1").on("tap", "li", function() {
		var title = this.querySelectorAll("div p")[0].innerHTML;
		var tag = this.getAttribute("tag");
		列表项目被单击(title,tag);
		});
}

function 列表项目被单击(title, 项目地址){
	mui.toast("正在读取播放地址");
	读写设置.保存设置("视频标题",title);
	标题 = title;
	网络操作2.发送网络请求(项目地址,"get","txt","",12000);
}

function 列表项目被单击2(title,video){
	公用模块.聚合直播播放(title,video);


}

function 网络操作2_发送完毕(发送结果,返回信息){
	返回信息 = 文本操作.删全部空(返回信息);
	var videourl = "http:" + 公用模块.取中间文本(返回信息,"html5player-video\"src=\"","\"data-setup=");

	公用模块.直播播放(标题,videourl);
}

function TVzhubo_按下返回键(){
	plus.webview.close("zhubo.html","slide-out-right");
	return;
}

function 标题栏1_左侧图标被单击(){
	plus.webview.close("zhubo.html","slide-out-right");
}

function 时钟1_周期事件(){
	窗口操作.引入js文件("files/chushhua.js");
	时钟1.停止执行();
}

function 网络操作3_发送完毕(发送结果,返回信息){
	var json = 转换操作.文本转json(返回信息);
	console.log(json);
	var css = "<ul id='壹九列表框1'class='mui-table-view mui-grid-view ul'>";
	mui.each(json.zhubo,function(索引,成员){
		var 标题 = 成员.title;
		var 图片 = 成员.img;
		var 地址 = 成员.address;
		css += "<li class='mui-table-view-cell mui-media li' tag='" + 地址 + "'>"+
				"<div class='imgdiv'><img src=" + 图片 + " /><div>"+
				"<span><i class='iconfont icon-Play_big_x'></i></span>"+
				"</div></div>"+
				"<div class='lidb'><p>" + 标题 + "</p><div>"+
				"<i class='iconfont icon-caidan'></i>"+
				"</div></div>";
	})
		css += "</ul>";
	var newNodeBottom = document.createElement("div");
		   newNodeBottom.innerHTML = css;
		document.getElementById("视频列表框").appendChild(newNodeBottom);

		miniRefresh.endDownLoading(true);

		mui("#壹九列表框1").on("tap", "li", function() {
		var title = this.querySelectorAll("div p")[0].innerHTML;
		var tag = this.getAttribute("tag");
		列表项目被单击2(title,tag);
		});
}