mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var CYS悬浮文字导航1 = new CYS悬浮文字导航("CYS悬浮文字导航1",CYS悬浮文字导航1_项目被单击,null);
var 仔仔弹出通知1 = new 仔仔弹出通知("仔仔弹出通知1");
var 网络操作1 = new 网络操作("网络操作1",网络操作1_发送完毕);
var 网络操作2 = new 网络操作("网络操作2",网络操作2_发送完毕);
if(mui.os.plus){
    mui.plusReady(function() {
        Shipin1_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        Shipin1_创建完毕();
        
    }
}
var mui_back = mui.back;
mui.back = function() {
    if (Shipin1_按下返回键()!=true) {
        mui_back();
    }
};

var 大分类索引 = 0;
var 全部数据数组 = new Array();
var 是否初始化 = true;
var 顶部项目索引 = 0;
var 电影分类 = ["动作","恐怖","喜剧","科幻","剧情","战争"];
var 电影分类id = ["6","10","7","9","11","12"];
var 电影年代 = ["2019","2018","2017","2016","2015","2014","2013","2012","2011","2010"];
var 电影地区 = ["全部","大陆","香港","台湾","美国","法国","英国","日本","韩国","德国","泰国","印度","意大利","西班牙","加拿大","其他"];
var 电视分类 = ["综艺","动漫","国产","港剧","台剧","美剧","韩剧","日剧","泰剧"];
var 电视分类id = ["3","4","13","14","15","16","21","20","22"];

var 资源分类 = ["高清","偷拍自拍","三级","无码","有码","欧美","另类","卡通","中文字幕","巨乳","制服","乱伦","国产","人妻","学生 ","日韩","HEYZO","Hey动画","DMM独家","美少女","口交","潮吹"];
var 资源分类id = ["24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45"];

var 资源分类1 = ["日韩无码","欧美精品","巨乳系列","国产精品","人妻系列","3P合辑","SM重味","自慰系列","自拍偷拍","制服诱惑","日韩精品","伦理影","动漫精品","中文字幕","有码视频","口交视频","颜射系列","教师学生","大秀视频","强奸乱伦"];
var 资源分类1id = ["61","63","78","64","65","66","67","68","69","70","71","72","73","74","75","76","77","78","79","80","62"];

var 综艺分类id = "3";
var 动漫分类id = "4";
var 页码 = 1;
var 全部视频图片 = new Array();
var 全部视频标题 = new Array();
var 全部视频地址 = new Array();
var 全部详情地址 = new Array();
var 大导航分类 = 0;
var 大导航分类1 = 0;
var 小导航分类 = 0;
var 小导航分类1 = 0;
var 背景颜色 = 读写设置.读取设置("背景颜色");
var 默认颜色 = 读写设置.读取设置("默认颜色");
var 激活颜色 = 读写设置.读取设置("激活颜色");
窗口操作.引入css文件("files/minirefresh.css");
窗口操作.引入js文件("files/minirefresh.js");

	var div=document.createElement("div");
	div.innerHTML = "<canvas id='canvas' style='z-index: 1;height: 70px;width: 100%;transform: scale(1,-1);-ms-transform: scale(1,-1);-moz-transform: scale(1,-1);-webkit-transform: scale(1,-1);-o-transform: scale(1,-1);position: absolute;bottom: 0;height:100%;'></canvas>";
	div.id = "minirefresh111";
	div.style.cssText = "height: 150px;position: absolute;z-index: -1;width: 100%;top: 73px;";
	document.body.appendChild(div);

	document.body.querySelectorAll("div")[0].insertBefore(div, document.body.nextSibling);

	var div = document.createElement("div");
	div.innerHTML ="<div id='yi9自定义导航' class='DaoHang' style='padding:5px 0px 0px 0px; margin:0px 0px 0px 0px;position:fixed;top:0px;left:0px;z-index:9999;width: 100%;height: 40px;background-color: " + 背景颜色 + ";overflow: hidden;margin-bottom: 0px;'>"+
	"<div id='nv0' class='nav0' index='0' style='float: left;width: 25%;height: 35px;padding-bottom：0px;display:table-cell;vertical-align: middle;text-align: center;'><span class='p3' style='color:" + 激活颜色 + " ; font-weight: bold;height: 100%;font-size: 18px;line-height: 35px;text-align: center;'>电影</span></div>"+
	"<div id='nv1' class='nav1' index='1' style='float: left;width: 25%;height: 35px;padding-bottom：0px;display:table-cell;vertical-align: middle;text-align: center;'><span class='p3' style='height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;'>电视</span></div>"+
	"<div id='nv2' class='nav2' index='2' style='float: left;width: 25%;height: 35px;padding-bottom：0px;display:table-cell;vertical-align: middle;text-align: center;'><span class='p3' style='height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;'>大地</span></div>"+
	"<div id='nv3' class='nav3' index='3' style='float: left;width: 25%;height: 35px;padding-bottom：0px;display:table-cell;vertical-align: middle;text-align: center;'><span class='p3' style='height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;'>800</span></div></div>";
	document.body.appendChild(div);
	document.body.querySelectorAll("div")[0].insertBefore(div, document.body.nextSibling);
	mui("#yi9自定义导航").on("tap", "div", function() {yi9自定义导航(Number(this.getAttribute("index")));});
	var div=document.createElement("div");
	div.innerHTML ="<div><div id='视频列表框' class='shipinliebiao' style=''></div></div>";
	div.id = "minirefresh";
	div.class = "minirefresh-wrap";
	div.style = "margin:38px 0px 0px 0px";
	document.body.appendChild(div);
	document.body.querySelectorAll("div")[0].insertBefore(div, document.body.nextSibling);
	初始化二级分类();

	初始化CYS导航();

function Shipin1_创建完毕(){
	窗口操作.引入js文件("files/chushhua.js");
}

function 初始化CYS导航(){
	CYS悬浮文字导航1.置背景颜色(背景颜色);
	CYS悬浮文字导航1.置默认文本颜色(默认颜色);
	CYS悬浮文字导航1.置选中认文本颜色(激活颜色);
	CYS悬浮文字导航1.置滑块颜色(背景颜色);
	CYS悬浮文字导航1.置悬浮("38px");
	CYS悬浮文字导航1.置分割线颜色(背景颜色);
}

function 初始化二级分类(){
	CYS悬浮文字导航1.清空项目();
	mui.each(电影分类,function(索引,成员){
		CYS悬浮文字导航1.添加项目(成员);
		document.querySelectorAll("#CYS悬浮文字导航1 div div")[0].querySelectorAll("a")[索引].style.borderBottom = "0";
	})


	document.querySelectorAll("#CYS悬浮文字导航1 div div")[0].style.textAlign = "-webkit-left";
	document.querySelectorAll("#CYS悬浮文字导航1 div div div div")[0].style.left =  "0px";
	公用模块.点击改变("CYS悬浮文字导航1",0);
}

function 初始化三级分类(){
	CYS悬浮文字导航2.清空项目();
	mui.each(电影年代,function(索引,成员){
		CYS悬浮文字导航2.添加项目(成员);
		document.querySelectorAll("#CYS悬浮文字导航2 div div")[0].querySelectorAll("a")[索引].style.borderBottom = "0";
	})


	document.querySelectorAll("#CYS悬浮文字导航2 div div")[0].style.textAlign = "-webkit-left";
	document.querySelectorAll("#CYS悬浮文字导航2 div div div div")[0].style.left =  "0px";
	公用模块.点击改变("CYS悬浮文字导航2",0);
}

function yi9自定义导航(i){
	顶部项目索引 = i;
	大分类索引 = 0;

	if( i == "0" ){
		读写设置.保存设置("侧滑菜单开关","false");
		document.getElementById("nv0").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ; font-weight: bold;height: 100%;font-size: 18px;line-height: 35px;text-align: center;"
;
		document.getElementById("nv1").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
		document.getElementById("nv2").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
		document.getElementById("nv3").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
		CYS悬浮文字导航1.清空项目();
		mui.each(电影分类,function(索引,成员){
			CYS悬浮文字导航1.添加项目(成员);
			document.querySelectorAll("#CYS悬浮文字导航1 div div")[0].querySelectorAll("a")[索引].style.borderBottom = "0";
		})
		miniRefresh.triggerDownLoading();
	}
	if( i == "1" ){
		读写设置.保存设置("侧滑菜单开关","false");
		document.getElementById("nv0").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
		document.getElementById("nv1").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ; font-weight: bold;height: 100%;font-size: 18px;line-height: 35px;text-align: center;";
		document.getElementById("nv2").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
		document.getElementById("nv3").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
		CYS悬浮文字导航1.清空项目();
		mui.each(电视分类,function(索引,成员){
			CYS悬浮文字导航1.添加项目(成员);
			document.querySelectorAll("#CYS悬浮文字导航1 div div")[0].querySelectorAll("a")[索引].style.borderBottom = "0";
		})
		miniRefresh.triggerDownLoading();
	}
	if( i == "2" ){








		读写设置.保存设置("侧滑菜单开关","false");
		document.getElementById("nv0").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
		document.getElementById("nv1").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
		document.getElementById("nv2").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
		document.getElementById("nv3").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ; font-weight: bold;height: 100%;font-size: 18px;line-height: 35px;text-align: center;";
		CYS悬浮文字导航1.清空项目();
		mui.each(资源分类1,function(索引,成员){
			CYS悬浮文字导航1.添加项目(成员);
			document.querySelectorAll("#CYS悬浮文字导航1 div div")[0].querySelectorAll("a")[索引].style.borderBottom = "0";
		})
		miniRefresh.triggerDownLoading();
	}
	if( i == "3" ){
		读写设置.保存设置("侧滑菜单开关","false");
		document.getElementById("nv0").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
		document.getElementById("nv1").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
		document.getElementById("nv2").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
		document.getElementById("nv3").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ; font-weight: bold;height: 100%;font-size: 18px;line-height: 35px;text-align: center;";
		CYS悬浮文字导航1.清空项目();
		mui.each(资源分类,function(索引,成员){
			CYS悬浮文字导航1.添加项目(成员);
			document.querySelectorAll("#CYS悬浮文字导航1 div div")[0].querySelectorAll("a")[索引].style.borderBottom = "0";
		})
		miniRefresh.triggerDownLoading();
	}
	CYS悬浮文字导航1.置现行选中项(0);
	document.querySelectorAll("#CYS悬浮文字导航1 div div div div")[0].style.width = "21px";
	document.querySelectorAll("#CYS悬浮文字导航1 div div div div")[0].style.left = "23.1px";
}

function 下拉(){
	document.getElementById("视频列表框").innerHTML = "";
	if (顶部项目索引 == 0){

		网络操作1.发送网络请求(公用模块.CMSAPI() + "/api.php/provide/vod/?ac=detail&t=" + 电影分类id[大分类索引] + "&year=" + 电影年代[大导航分类1],"get","txt","",12000);

		return;
	}
	if (顶部项目索引 == 1){
		网络操作1.发送网络请求(公用模块.CMSAPI() + "/api.php/provide/vod/?ac=detail&t=" + 电视分类id[大分类索引],"get","txt","",12000);

		return;
	}
	if (顶部项目索引 == 2){

		网络操作1.发送网络请求(公用模块.CMSAPI() + "/api.php/provide/vod/?ac=detail&t=" + 资源分类1id[大分类索引],"get","txt","",12000);
		return;
	}
	if (顶部项目索引 == 3){
		网络操作1.发送网络请求(公用模块.CMSAPI() + "/api.php/provide/vod/?ac=detail&t=" + 资源分类id[大分类索引],"get","txt","",12000);
		return;
	}
}

function 上啦(){

	miniRefresh._lockUpLoading(true);
	页码 = 页码 + 1;
	if (顶部项目索引 == 0){
		网络操作2.发送网络请求(公用模块.CMSAPI() + "/api.php/provide/vod/?ac=detail&t=" + 电影分类id[大分类索引] + "&pg=" + 页码,"get","txt","",12000);
		return;
	}
	if (顶部项目索引 == 1){
		网络操作2.发送网络请求(公用模块.CMSAPI() + "/api.php/provide/vod/?ac=detail&t=" + 电视分类id[大分类索引] + "&pg=" + 页码,"get","txt","",12000);
		return;
	}
	if (顶部项目索引 == 2){

		网络操作2.发送网络请求(公用模块.CMSAPI() + "/api.php/provide/vod/?ac=detail&t=" + 资源分类1id[大分类索引] + "&pg=" + 页码,"get","txt","",12000);
		return;
	}
	if (顶部项目索引 == 3){
		网络操作2.发送网络请求(公用模块.CMSAPI() + "/api.php/provide/vod/?ac=detail&t=" + 资源分类id[大分类索引] + "&pg=" + 页码,"get","txt","",12000);
		return;
	}

}

function 网络操作1_发送完毕(发送结果,返回信息){
	if (发送结果 == true){
		数组操作.清空数组(全部视频图片);
		数组操作.清空数组(全部视频标题);
		数组操作.清空数组(全部视频地址);
		数组操作.清空数组(全部详情地址);
		var json = 转换操作.文本转json(返回信息);
		var index = 0;

		var css = "<ul id=壹九列表框1 style='margin:43px 3px 0px 3px;padding: 0px 0px 0px 0px;text-align:center;background-color: transparent;'>";

		mui.each(json.list,function(索引,成员){
			数组操作.加入尾成员(全部视频标题,成员.vod_name);
			数组操作.加入尾成员(全部视频图片,成员.vod_pic);
			数组操作.加入尾成员(全部视频地址,成员.vod_id);
			if (成员.vod_actor == ""){
				成员.vod_actor = "暂无详情";
			}
			数组操作.加入尾成员(全部详情地址,成员.vod_actor);
		})
		while(index < 18){
			css += "<li style='float:left;display:inline; padding: 0px 3px 0px 3px; width: 33.33%; margin-bottom: 10px;' data-index='" + index + "'>"+
			"<div style='position: relative;'>"+
			"<span style='position: absolute;left: 0; right: 0;bottom: 3%;content: ;height: .4rem;z-index: 1;background-repeat: repeat-x;height: 33%;'></span>"+
			"<img id=列表图片 class='mui-media-object;' style='height:130px; width:100%;border-radius:13px 13px 13px 13px;' alt='test' onerror=\"this.src='images/404.jpg'\" src='" + 全部视频图片[index] + "'/></div>"+
			"<div style='margin-top: -4px;text-align: -webkit-left;padding-left: 6px;'>"+
			"<p id =列表标题 style='color: #333;font: 14px/1.5 ; overflow: hidden;text-overflow: ellipsis;display: block;white-space: nowrap;'>" + 全部视频标题[index] + "</p>"+
			"<span id=列表详情 style='margin:-10px 0px 0px 0px; font-size: 12px;color: #999;overflow: hidden;text-overflow: ellipsis;display: block;white-space: nowrap;'>" + 全部详情地址[index] + "</span>"+
			"</div></li>";
			index = index + 1;
		}

		css = css + "</ul>";
		var newNodeBottom = document.createElement("div");
		   newNodeBottom.innerHTML = css;
		document.getElementById("视频列表框").appendChild(newNodeBottom);

		miniRefresh.endDownLoading(true);
		mui("#壹九列表框1").on("tap", "li", function() {更多被单击(this.getAttribute("data-index"));});
		return;
	}else{
		下拉();
	}
}

function CYS悬浮文字导航1_项目被单击(项目索引){
	大分类索引 = 项目索引;
	if (小导航分类 != 项目索引){
		公用模块.点击改变("CYS悬浮文字导航1",项目索引);
		小导航分类 = 项目索引;
	}

	miniRefresh.triggerDownLoading();
}

function 列表项目被单击(title,video,index){
	读写设置.保存设置("视频来源","资源站");
	读写设置.保存设置("视频图片",document.getElementById("壹九列表框1").getElementsByTagName("li")[index].getElementsByTagName("img")[0].src);
	公用模块.影视播放(title,video);
}

function 标题栏1_左侧图标被单击(){
	plus.webview.close("shipin1.html","slide-out-right");
}

function 标题栏1_右侧图标被单击(){
	窗口操作.预加载窗口("sousuo.html");
	窗口操作.取指定窗口("sousuo.html").show("slide-in-right", 300);
}

function Shipin1_按下返回键(){
	plus.webview.close("shipin1.html","slide-out-right");
	return true;
}

function 网络操作2_发送完毕(发送结果,返回信息){
	var json = 转换操作.文本转json(返回信息);
	var index = 0;
	var index1 = 数学操作.到数值(数组操作.取成员数(全部视频图片));

	mui.each(json.list,function(索引,成员){
		数组操作.加入尾成员(全部视频标题,成员.vod_name);
		数组操作.加入尾成员(全部视频图片,成员.vod_pic);
		数组操作.加入尾成员(全部视频地址,成员.vod_id);
		if (成员.vod_actor == ""){
				成员.vod_actor = "暂无详情";
			}
			数组操作.加入尾成员(全部详情地址,成员.vod_actor);
	})
	var css = "";
	while(index < 18){
		css += "<li style='float:left;display:inline; padding: 0px 3px 0px 3px; width: 33.33%; margin-bottom: 10px;' data-index='" + index1 + "'>"+
			"<div style='position: relative;'>"+
			"<span style='position: absolute;left: 0; right: 0;bottom: 3%;content: ;height: .4rem;z-index: 1;background-repeat: repeat-x;height: 33%;'></span>"+
			"<img id=列表图片 class='mui-media-object;' style='height:130px; width:100%;border-radius:13px 13px 13px 13px;' alt='test' onerror=\"this.src='images/404.jpg'\" src='" + 全部视频图片[index1] + "'/></div>"+
			"<div style='margin-top: -4px;text-align: -webkit-left;padding-left: 6px;'>"+
			"<p id =列表标题 style='color: #333;font: 14px/1.5 ; overflow: hidden;text-overflow: ellipsis;display: block;white-space: nowrap;'>" + 全部视频标题[index1] + "</p>"+
			"<span id=列表详情 style='margin:-10px 0px 0px 0px; font-size: 12px;color: #999;overflow: hidden;text-overflow: ellipsis;display: block;white-space: nowrap;'>" + 全部详情地址[index1] + "</span>"+
			"</div></li>";

			index = index + 1;
			index1 = index1 +1;
			miniRefresh._lockUpLoading(false);
			miniRefresh.endUpLoading(false);
		}
		document.getElementById("壹九列表框1").innerHTML += css;





	return;
}

function 更多被单击(i){



	var photo = document.getElementById("壹九列表框1").querySelectorAll("div img")[i].src;
	var title = document.getElementById("壹九列表框1").querySelectorAll("div p")[i].innerText;
	var video = 全部视频地址[i];
	读写设置.保存设置("视频来源","资源站");
	读写设置.保存设置("视频图片",photo);
	公用模块.影视播放(title,video);

}

function CYS悬浮文字导航2_项目被单击(项目索引){
	大分类索引1 = 项目索引;
	if (小导航分类1 != 项目索引){
		公用模块.点击改变("CYS悬浮文字导航2",项目索引);
		小导航分类1 = 项目索引;
	}

	miniRefresh.triggerDownLoading();
}

function 刷新主题颜色(){
背景颜色 = 读写设置.读取设置("背景颜色");
默认颜色 = 读写设置.读取设置("默认颜色");
激活颜色 = 读写设置.读取设置("激活颜色");
document.getElementById("yi9自定义导航").style = "padding:5px 0px 0px 0px; margin:0px 0px 0px 0px;position:fixed;top:0px;left:0px;z-index:9999;width: 100%;height: 40px;background-color: " + 背景颜色 + ";overflow: hidden;margin-bottom: 0px;";
if (顶部项目索引 == "0"){
	document.getElementById("nv0").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ; font-weight: bold;height: 100%;font-size: 18px;line-height: 35px;text-align: center;";
	document.getElementById("nv1").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv2").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv3").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;"}
if (顶部项目索引 == "1"){
	document.getElementById("nv0").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv1").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ; font-weight: bold;height: 100%;font-size: 18px;line-height: 35px;text-align: center;";
	document.getElementById("nv2").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv3").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;"}
if (顶部项目索引 == "2"){
	document.getElementById("nv0").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv1").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv2").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ; font-weight: bold;height: 100%;font-size: 18px;line-height: 35px;text-align: center;";
	document.getElementById("nv3").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;"}
if (顶部项目索引 == "3"){
	document.getElementById("nv0").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv1").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv2").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv3").getElementsByTagName("span")[0].style = "color:" + 激活颜色 + " ; font-weight: bold;height: 100%;font-size: 18px;line-height: 35px;text-align: center;"}
if (顶部项目索引 == "4"){
	document.getElementById("nv0").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv1").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv2").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;";
	document.getElementById("nv3").getElementsByTagName("span")[0].style = "height: 100%;font-size: 14px;font-weight: normal;line-height: 35px;color: " + 默认颜色 + ";text-align: center;"}
	CYS悬浮文字导航1.置背景颜色(背景颜色);
	CYS悬浮文字导航1.置默认文本颜色(默认颜色);
	CYS悬浮文字导航1.置选中认文本颜色(激活颜色);
	CYS悬浮文字导航1.置滑块颜色(激活颜色);
	CYS悬浮文字导航1.置分割线颜色(背景颜色);
}