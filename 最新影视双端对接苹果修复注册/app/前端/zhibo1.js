mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var CYS悬浮文字导航1 = new CYS悬浮文字导航("CYS悬浮文字导航1",CYS悬浮文字导航1_项目被单击,null);
var 正则1 = new 正则("正则1");
var 网络操作1 = new 网络操作("网络操作1",网络操作1_发送完毕);
var 网络操作2 = new 网络操作("网络操作2",网络操作2_发送完毕);
var 网络操作3 = new 网络操作("网络操作3",网络操作3_发送完毕);
var 时钟1 = new 时钟("时钟1",时钟1_周期事件);
if(mui.os.plus){
    mui.plusReady(function() {
        TVzhibo_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        TVzhibo_创建完毕();
        
    }
}

var 全部数据数组 = new Array();
var 是否初始化 = true;
var 顶部项目索引 = 0;
var 二级项目索引 = 0;
var 判断分类 = 0;
var 虎牙分类 = ["全部","网游","单机","娱乐","手游"];
var 战旗分类 = ["全部"];
var 电视分类 = ["全部"];
var 电视标题 = new Array();
var 电视地址 = new Array();
var 电视图片 = new Array();
var 小导航分类 = 0;
var 背景颜色 = 读写设置.读取设置("背景颜色");
var 默认颜色 = 读写设置.读取设置("默认颜色");
var 激活颜色 = 读写设置.读取设置("激活颜色");
var indexx = 0;
窗口操作.引入css文件("files/fuli.css");
窗口操作.引入css文件("files/yi9zhibolist.css");
窗口操作.引入css文件("files/minirefresh.css");
窗口操作.引入js文件("files/minirefresh.js");
var div=document.createElement("div");
	div.innerHTML ="<div id='yi9自定义导航' style='padding:5px 0px 0px 0px; margin:0px 0px 0px 0px;position:fixed;top:0px;left:0px;z-index:9999;width: 100%;height: 40px;background-color: " + 背景颜色 + ";overflow: hidden;margin-bottom: 0px;'>"+

	"<div id='nv0' index='0' style='float: left;width: 33.33%;height: 60px;padding-bottom:5px;display:table-cell;vertical-align: middle;text-align: center;'><span class='p3' style='color:" + 激活颜色 + " ;height: 100%;font-weight: bold; font-size: 18px;line-height: 35px;text-align: center;'>电视TV</span></div>"+
	"<div id='nv2' index='2' style='float: left;width: 33.33%;height: 60px;padding-bottom:5px;display:table-cell;vertical-align: middle;text-align: center;'><span class='p3' style='color:" + 默认颜色 + " ;height: 100%;font-size: 16px;font-weight: normal;line-height: 35px;text-align: center'>虎牙TV</span></div>"+
	"<div id='nv1' index='1' style='float: left;width: 33.33%;height: 60px;padding-bottom:5px;display:table-cell;vertical-align: middle;text-align: center;'><span class='p3' style='color:" + 默认颜色 + " ;height: 100%;font-size: 16px;font-weight: normal;line-height: 35px;text-align: center'>聚盒直播</span></div>";

	document.body.appendChild(div);
	document.body.querySelectorAll("div")[0].insertBefore(div, document.body.nextSibling);
	mui("#yi9自定义导航").on("tap", "div", function() {顶部导航被单击(Number(this.getAttribute("index")));});
var div=document.createElement("div");
	div.innerHTML ="<div><div id='视频列表框' class='shipinliebiao' style=''></div></div>";
	div.id = "minirefresh";
	div.class = "minirefresh-wrap";
	div.style = "margin:38px 0px 0px 0px";
	document.body.appendChild(div);
	document.body.querySelectorAll("div")[0].insertBefore(div, document.body.nextSibling);
function TVzhibo_创建完毕(){
	初始化CYS导航();
	初始化二级分类();
	时钟1.开始执行(300,false);
}

function 初始化CYS导航(){
	CYS悬浮文字导航1.置背景颜色(背景颜色);
	CYS悬浮文字导航1.置默认文本颜色(默认颜色);
	CYS悬浮文字导航1.置选中认文本颜色(激活颜色);
	CYS悬浮文字导航1.置滑块颜色(激活颜色);
	CYS悬浮文字导航1.置悬浮("38px");
	CYS悬浮文字导航1.置分割线颜色(背景颜色);
}

function 初始化二级分类(){
	CYS悬浮文字导航1.清空项目();
	if (判断分类 == 0){
		判断分类 = 电视分类;
	}
	if (判断分类 == 1){
		判断分类 = 战旗分类;
	}
	if (判断分类 == 2){
		判断分类 = 虎牙分类;
	}
	mui.each(判断分类,function(索引,成员){
		CYS悬浮文字导航1.添加项目(成员);
		document.querySelectorAll("#CYS悬浮文字导航1 div div")[0].querySelectorAll("a")[索引].style.borderBottom = "0";
	})

	document.querySelectorAll("#CYS悬浮文字导航1 div div")[0].style.textAlign = "-webkit-left";
	document.querySelectorAll("#CYS悬浮文字导航1 div div div div")[0].style.left =  "0px";
	公用模块.点击改变("CYS悬浮文字导航1",0);

}

function 下拉(){
	document.getElementById("视频列表框").innerHTML = "";
if (顶部项目索引 == 0){
		if (二级项目索引 == "0"){
			网络操作3.发送网络请求("http://app.1xui.com/admin/ds.txt","get","txt","",12000);
			return;
		}
	}
	if (顶部项目索引 == 1){
	    网络操作2.发送网络请求("http://api.hclyz.com:81/mf/json.txt","get","txt","",12000);

		return;
	}
	if (顶部项目索引 == 2){
		if (二级项目索引 == "0"){
			网络操作1.发送网络请求("https://www.huya.com/g","get","txt","",12000);
			return;
		}
		if (二级项目索引 == "1"){
			网络操作1.发送网络请求("https://www.huya.com/g_ol","get","txt","",12000);
			return;
		}
		if (二级项目索引 == "2"){
			网络操作1.发送网络请求("https://www.huya.com/g_pc","get","txt","",12000);
			return;
		}
		if (二级项目索引 == "3"){
			网络操作1.发送网络请求("https://www.huya.com/g_yl","get","txt","",12000);
			return;
		}
		if (二级项目索引 == "4"){
			网络操作1.发送网络请求("https://www.huya.com/g_sy","get","txt","",12000);
			return;
		}
	}
}

function 上啦(){
	miniRefresh._lockUpLoading(true);
}

function 网络操作1_发送完毕(发送结果,返回信息){
	数组操作.清空数组(全部数据数组);
	if (发送结果 == true){
		返回信息 = 文本操作.删全部空(返回信息);
		var 返回文本;
		var 截取= 公用模块.取中间文本(返回信息,"<ul","</ul>");
		var 地址;
		var 图片;
		var 标题;
		var i = 0;
		var index = 0;
		正则1.创建正则(截取,"<li(.*?)</li>");
		while(index != 正则1.取匹配数量()){
			var 全部数组 = 正则1.取子匹配文本(index,1);
			数组操作.加入尾成员(全部数据数组,全部数组);
			index = index + 1;
		}

		var css = "<ul id='壹九列表框1'class='mui-table-view mui-grid-view ul'>";
		var index = 0;

		while(i != 数组操作.取成员数(全部数据数组)){
			地址 = 公用模块.取中间文本(全部数据数组[i],"href=\"","\"");
			图片 = "http://" + 公用模块.取中间文本(全部数据数组[i],"imgsrc=\"","\"onerror=");
			标题 = 公用模块.取中间文本(全部数据数组[i],"game_name\">","</span>");
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
	}else{

	}
}
function 列表项目被单击(title, 项目地址){
	读写设置.保存设置("直播类型","虎牙");
	读写设置.保存设置("主播列表",项目地址);
	读写设置.保存设置("主播标题",title);
	窗口操作.预加载窗口("zhubo.html");
	窗口操作.取指定窗口("zhubo.html").show("slide-in-right", 300);
}


function 顶部导航被单击(i){
	console.log(i);
	indexx = i;
	判断分类 = i;
	顶部项目索引 = i;
	二级项目索引 = 0;
	if( i == "0" ){
		document.getElementById("nv0").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ;height: 100%;font-weight: bold; font-size: 18px;line-height: 35px;text-align: center;";
		document.getElementById("nv1").getElementsByTagName("span")[0].style = "color:" + 默认颜色 + " ;height: 100%;font-size: 16px;font-weight: normal;line-height: 35px;text-align: center";
		document.getElementById("nv2").getElementsByTagName("span")[0].style = "color:" + 默认颜色 + " ;height: 100%;font-size: 16px;font-weight: normal;line-height: 35px;text-align: center";

		初始化二级分类();
		miniRefresh.triggerDownLoading();
	}
	if( i == "1" ){
		document.getElementById("nv0").getElementsByTagName("span")[0].style = "color:" + 默认颜色 + " ;height: 100%;font-size: 16px;font-weight: normal;line-height: 35px;text-align: center";
		document.getElementById("nv1").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ;height: 100%;font-weight: bold; font-size: 18px;line-height: 35px;text-align: center;";
		document.getElementById("nv2").getElementsByTagName("span")[0].style = "color:" + 默认颜色 + " ;height: 100%;font-size: 16px;font-weight: normal;line-height: 35px;text-align: center";

		初始化二级分类();
		miniRefresh.triggerDownLoading();
	}
	if( i == "2" || i == 2){
		document.getElementById("nv0").getElementsByTagName("span")[0].style = "color:" + 默认颜色 + " ;height: 100%;font-size: 16px;font-weight: normal;line-height: 35px;text-align: center";
		document.getElementById("nv1").getElementsByTagName("span")[0].style = "color:" + 默认颜色 + " ;height: 100%;font-size: 16px;font-weight: normal;line-height: 35px;text-align: center";
		document.getElementById("nv2").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ;height: 100%;font-weight: bold; font-size: 18px;line-height: 35px;text-align: center;";
		初始化二级分类();

		miniRefresh.triggerDownLoading();
	}
	if( i == 3){
		mui.toast("等待更新");
		return;
	}

}



function 时钟1_周期事件(){
	窗口操作.引入js文件("files/chushhua.js");
}

function CYS悬浮文字导航1_项目被单击(项目索引){
	二级项目索引 = 项目索引;
	if (小导航分类 != 项目索引){
		公用模块.点击改变("CYS悬浮文字导航1",项目索引);
		小导航分类 = 项目索引;
	}

	miniRefresh.triggerDownLoading();
}

function 网络操作2_发送完毕(发送结果,返回信息){
	数组操作.清空数组(全部数据数组);
	if (发送结果 == true){
		var json = 转换操作.文本转json(返回信息);
		var css = "<ul id='壹九列表框1'class='mui-table-view mui-grid-view ul'>";
		mui.each(json.pingtai,function(索引,成员){
			var 图片 = 成员.xinimg;
			var 标题 = 成员.title;
			var 地址 = 成员.address;
			var 人数 = 成员.Number;
			css += "<li class='mui-table-view-cell mui-media li' tag='" + 地址 + "'>"+
				"<div class='imgdiv'><img src=" + 图片 + " alt='test' onerror=\"this.src='images/404.jpg'\" class='listimg'/><div>"+
				"<span><i class='iconfont icon-Play_big_x'></i></span>"+

				"</div></div>"+
				"<div class='lidb'><p>" + 标题 + 人数 + "</p><div>"+

				"<i class='iconfont icon-caidan'></i>"+
				"</div></div>";
		})
		var newNodeBottom = document.createElement("div");
		   newNodeBottom.innerHTML = css;
		document.getElementById("视频列表框").appendChild(newNodeBottom);

		miniRefresh.endDownLoading(true);

		mui("#壹九列表框1").on("tap", "li", function() {
		var title = this.querySelectorAll("div p")[0].innerHTML;
		var tag = this.getAttribute("tag");
		列表项目被单击2(title,tag);
		});
	}else{

	}
}
function 列表项目被单击2(title, 项目地址){
	读写设置.保存设置("直播类型","聚合");
	读写设置.保存设置("主播列表",项目地址);
	读写设置.保存设置("主播标题",title);
	窗口操作.预加载窗口("zhubo.html");
	窗口操作.取指定窗口("zhubo.html").show("slide-in-right", 300);
}

function 网络操作3_发送完毕(发送结果,返回信息){
	数组操作.清空数组(电视标题);
	数组操作.清空数组(电视地址);
	数组操作.清空数组(电视图片);

	var html = "<ul class='mui-table-view' style='padding: 0;margin-top:0rem' id=CMS>";
	var 名称=文本操作.取指定文本(返回信息,"@bt","@dz");
	var 地址=文本操作.取指定文本(返回信息,"@dz","@tp");
	var 图片=文本操作.取指定文本(返回信息,"@tp","丨");
	var index= 0;
	while(index < 数组操作.取成员数(名称)){
		数组操作.加入尾成员(电视标题,名称[index]);
		数组操作.加入尾成员(电视地址,地址[index]);
		数组操作.加入尾成员(电视图片,图片[index]);



		html += " <li class='mui-table-view-cell'  data-index='" + index + "'><img src=" + 图片[index] + " style='width: 80px; border-radius: 3px;' /><div class='listdiv'><span class='listspan1'>" + 名称[index] + "</span>"+
		"<p class='listp'>" + 名称[index] + "</p><div class='listdiv1'></div>"+
		"</div></li>";
		index = index + 1;
	}
	var newNodeBottom = document.createElement("div");
		   newNodeBottom.innerHTML = html;
		document.getElementById("视频列表框").appendChild(newNodeBottom);
		miniRefresh.endDownLoading(true);
		mui("#CMS").on("tap", "li", function() {列表项目被单击3(this.getAttribute("data-index"));});
		mui("#壹九列表框1").on("tap", "li", function() { 列表项目被单击3(this.getAttribute("tag"));});




}
function 列表项目被单击3(i){

	公用模块.直播播放(电视标题[i],电视地址[i]);
}

function 刷新主题颜色(){
背景颜色 = 读写设置.读取设置("背景颜色");
默认颜色 = 读写设置.读取设置("默认颜色");
激活颜色 = 读写设置.读取设置("激活颜色");
document.getElementById("yi9自定义导航").style = "padding:5px 0px 0px 0px; margin:0px 0px 0px 0px;position:fixed;top:0px;left:0px;z-index:9999;width: 100%;height: 40px;background-color: " + 背景颜色 + ";overflow: hidden;margin-bottom: 0px;";
if (顶部项目索引 == "0"){
	document.getElementById("nv0").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ;height: 100%;font-weight: bold; font-size: 18px;line-height: 35px;text-align: center;";
	document.getElementById("nv1").getElementsByTagName("span")[0].style = "color:" + 默认颜色 + " ;height: 100%;font-size: 16px;font-weight: normal;line-height: 35px;text-align: center";
	document.getElementById("nv2").getElementsByTagName("span")[0].style = "color:" + 默认颜色 + " ;height: 100%;font-size: 16px;font-weight: normal;line-height: 35px;text-align: center"}
if (顶部项目索引 == "1"){
	document.getElementById("nv0").getElementsByTagName("span")[0].style = "color:" + 默认颜色 + " ;height: 100%;font-size: 16px;font-weight: normal;line-height: 35px;text-align: center";
	document.getElementById("nv1").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ;height: 100%;font-weight: bold; font-size: 18px;line-height: 35px;text-align: center;";
	document.getElementById("nv2").getElementsByTagName("span")[0].style = "color:" + 默认颜色 + " ;height: 100%;font-size: 16px;font-weight: normal;line-height: 35px;text-align: center"}
if (顶部项目索引 == "2"){
	document.getElementById("nv0").getElementsByTagName("span")[0].style = "color:" + 默认颜色 + " ;height: 100%;font-size: 16px;font-weight: normal;line-height: 35px;text-align: center";
	document.getElementById("nv1").getElementsByTagName("span")[0].style = "color:" + 默认颜色 + " ;height: 100%;font-size: 16px;font-weight: normal;line-height: 35px;text-align: center";
	document.getElementById("nv2").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ;height: 100%;font-weight: bold; font-size: 18px;line-height: 35px;text-align: center;"}
	CYS悬浮文字导航1.置背景颜色(背景颜色);
	CYS悬浮文字导航1.置默认文本颜色(默认颜色);
	CYS悬浮文字导航1.置选中认文本颜色(激活颜色);
	CYS悬浮文字导航1.置滑块颜色(激活颜色);
	CYS悬浮文字导航1.置分割线颜色(背景颜色);
}