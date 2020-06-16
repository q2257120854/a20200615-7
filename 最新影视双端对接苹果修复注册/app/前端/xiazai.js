mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 标题栏1 = new 标题栏("标题栏1",null,null,标题栏1_左侧图标被单击);
var 网络操作1 = new 网络操作("网络操作1",网络操作1_发送完毕);
var 列表框1 = new 列表框("列表框1",true,列表框1_表项被单击,null);
var 正则1 = new 正则("正则1");
if(mui.os.plus){
    mui.plusReady(function() {
        xiazai_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        xiazai_创建完毕();
        
    }
}
var mui_back = mui.back;
mui.back = function() {
    if (xiazai_按下返回键()!=true) {
        mui_back();
    }
};

var 背景颜色 = 读写设置.读取设置("背景颜色");
var 默认颜色 = 读写设置.读取设置("默认颜色");
var 激活颜色 = 读写设置.读取设置("激活颜色");
var 搜索颜色 = 读写设置.读取设置("搜索颜色");
var i= 0;
document.getElementById("标题栏1").style.background = 背景颜色;
document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色;
document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>搜索到以可下载的相关资源</h1>";

function xiazai_创建完毕(){
	网络操作1.发送网络请求(公用模块.xiazai()+"/index.php?m=vod-search-pg-1-wd-"+读写设置.读取设置("视频标题")+".html","get","txt","", 12000);
}


function xiazai_按下返回键(){
	plus.webview.close("xiazai.html","slide-out-right");
	return;
}

function 标题栏1_左侧图标被单击(){
	plus.webview.close("xiazai.html","slide-out-right");
}

function 主题信息(){
	document.getElementById("标题栏1").style.background = 背景颜色;
	document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色;
	document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'></h1>";
}

function 网络操作1_发送完毕(发送结果,返回信息){
	if(发送结果 == true ){
		var 截取 = 文本操作.取指定文本(返回信息," <li><span class=\"tt\">","</li>");
			var index = 0;
			while(index != 数组操作.取成员数(截取)){
				var URL  = 公用模块.取中间文本(截取[index],"href=\"","\"");
				var BT  = 公用模块.取中间文本(截取[index],"target=\"_blank\">","<");
				列表框1.添加项目(BT,公用模块.xiazai() +URL,"","");
				index = index + 1;
		}
		if(列表框1.取项目总数() == 0 ){
			列表框1.添加项目("抱歉,暂无可下载资源","","","");
		}
	}
}

function 列表框1_表项被单击(项目索引,项目标题,项目标记){
	读写设置.保存设置("下载地址",项目标记);
	读写设置.保存设置("下载标题",项目标题);
	窗口操作.预加载窗口("spxiazai.html"),窗口操作.取指定窗口("spxiazai.html").show("slide-in-right", 300);
}