mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 标题栏1 = new 标题栏("标题栏1",null,null,标题栏1_左侧图标被单击);
var 轮播图1 = new 轮播图("轮播图1",轮播图1_项目被单击);
var 列表哥AUI搜索框1 = new 列表哥AUI搜索框("列表哥AUI搜索框1",列表哥AUI搜索框1_搜索按钮被单击);
var 网络操作1 = new 网络操作("网络操作1",网络操作1_发送完毕);
var 高级列表框1 = new 高级列表框("高级列表框1",true,true,false,高级列表框1_表项被单击);
var 正则1 = new 正则("正则1");
if(mui.os.plus){
    mui.plusReady(function() {
        Sousuo_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        Sousuo_创建完毕();
        
    }
}
var mui_back = mui.back;
mui.back = function() {
    if (Sousuo_按下返回键()!=true) {
        mui_back();
    }
};

var 背景颜色 = 读写设置.读取设置("背景颜色");
var 默认颜色 = 读写设置.读取设置("默认颜色");
var 激活颜色 = 读写设置.读取设置("激活颜色");
窗口操作.引入css文件("files/yi9sousuo.css");
窗口操作.引入css文件("files/minirefresh.css");
窗口操作.引入js文件("files/minirefresh.js");
document.getElementById("标题栏1").style.background = 背景颜色;
document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色;
document.querySelectorAll("#标题栏1 a")[1].style.color = 背景颜色;
document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + "; margin:6px 0px 0px 0px;'>搜索</h1>";
var 广告图片 = new Array();
var 广告标题 = new Array();
var 广告地址 = new Array();
function Sousuo_创建完毕(){
	高级列表框1.置图片尺寸("0px","0px");
	窗口操作.置组件圆角("轮播图1","10px");
	初始化广告();
}
function 初始化广告(){
	var 截取= 读写设置.读取设置("轮播广告2");

	var index = 0;
	正则1.创建正则(截取,"<a>img=\"(.*?)\"title=\"(.*?)\"href=\"(.*?)\"</a>");
	while(index != 5){
		数组操作.加入尾成员(广告图片,正则1.取子匹配文本(index,1));
		数组操作.加入尾成员(广告标题,正则1.取子匹配文本(index,2));
		数组操作.加入尾成员(广告地址,正则1.取子匹配文本(index,3));
		轮播图1.添加项目_普通(正则1.取子匹配文本(index,1));
		index = index + 1;
	}
	轮播图1.置轮播周期(3000);
		轮播图1.置轮播区尺寸(窗口操作.取窗口宽度()+"px","150px");
		轮播图1.添加完毕_普通(2);
}

function 列表哥AUI搜索框1_搜索按钮被单击(搜索内容){
	读写设置.保存设置("搜索内容",搜索内容);
	网络操作1.发送网络请求(公用模块.CMSAPI() + "/api.php/provide/vod/?ac=list&wd=" + 搜索内容,"get","txt","",12000);
}

function 网络操作1_发送完毕(发送结果,返回信息){
	var json = 转换操作.文本转json(返回信息);
	高级列表框1.清空项目();
	if (发送结果 == true){
		mui.each(json.list,function(索引,成员){
			高级列表框1.添加项目("",成员.vod_name,成员.type_name,成员.vod_id);
		})
		if(高级列表框1.取项目总数() == 0 ){
			mui.toast("抱歉,没有相关视频内容");
		}
	}else{
			网络操作1.发送网络请求(公用模块.api() + "/api.php/provide/vod/?ac=list&wd=" + 搜索内容,"get","txt","",12000);
	}
}

function 高级列表框1_表项被单击(项目索引,项目图片,项目标题,项目信息,项目标记){
	读写设置.保存设置("视频来源","资源站");
	读写设置.保存设置("视频图片",项目图片);
	公用模块.影视播放(项目标题,项目标记);
}

function 标题栏1_左侧图标被单击(){
	plus.webview.close("sousuo.html","slide-out-right");
}

function Sousuo_按下返回键(){
	plus.webview.close("sousuo.html","slide-out-right");
	return true;
}

function 轮播图1_项目被单击(项目索引){
	if (文本操作.寻找文本(广告地址[项目索引],"http",0) != -1){
		窗口操作.打开指定网址(广告地址[项目索引],2);
	}else{
		读写设置.保存设置("视频图片",广告图片[项目索引]);
		读写设置.保存设置("视频来源","资源站"),公用模块.影视播放(广告标题[项目索引],广告地址[项目索引]);
	}
}