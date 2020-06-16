mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 标题栏1 = new 标题栏("标题栏1",null,null,标题栏1_左侧图标被单击);
var 标签1 = new 标签("标签1",null);
var 列表框1 = new 列表框("列表框1",true,列表框1_表项被单击,null);
var 标签2 = new 标签("标签2",null);
var 列表框2 = new 列表框("列表框2",true,列表框2_表项被单击,null);
var 对话框1 = new 对话框("对话框1",null,null,null);
var 网络操作1 = new 网络操作("网络操作1",网络操作1_发送完毕);
if(mui.os.plus){
    mui.plusReady(function() {
        shezhi_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        shezhi_创建完毕();
        
    }
}
var mui_back = mui.back;
mui.back = function() {
    if (shezhi_按下返回键()!=true) {
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
document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>软件设置</h1>";

function shezhi_创建完毕(){
	列表框1.添加项目("个人信息","","","");
	列表框1.添加项目("账号绑定","","","");
	列表框1.添加项目("联系我们","","","");
	列表框1.添加项目("实 验 室","","","");


	列表框2.添加项目("使用协议","","","");
	列表框2.添加项目("关于我们","","","");
	列表框2.添加项目("新手指南","","","");
	列表框2.添加项目("常见问题","","","");
	网络操作1.发送网络请求(公用模块.AdminGuanLi()+"xieyi.php","get","txt","",12000);
}


function shezhi_按下返回键(){
	plus.webview.close("shezhi.html","slide-out-right");
	return;
}

function 标题栏1_左侧图标被单击(){
	plus.webview.close("shezhi.html","slide-out-right");
}

function 主题信息(){
	document.getElementById("标题栏1").style.background = 背景颜色;
	document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色;
	document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'></h1>";
}


function 列表框1_表项被单击(项目索引,项目标题,项目标记){
	switch(项目索引){
		case 0 :
			if (读写设置.读取设置("用户帐号") != "" && 读写设置.读取设置("用户密码") != null && 读写设置.读取设置("用户时间") != null){
				窗口操作.预加载窗口("gerenxinxi.html"),窗口操作.取指定窗口("gerenxinxi.html").show("slide-in-right", 300);
			}else{
				窗口操作.预加载窗口("login.html"),窗口操作.取指定窗口("login.html").show("slide-in-right", 300);
			}
		break;
		case 1 :
			mui.toast("暂未开放");
		break;
		case 2 :
			窗口操作.预加载窗口("kefu.html"),窗口操作.取指定窗口("kefu.html").show("slide-in-right", 300);
		break;
		case 3 :
			窗口操作.预加载窗口("shiyanshi.html"),窗口操作.取指定窗口("shiyanshi.html").show("slide-in-right", 300);
		break;
	}
}

function 列表框2_表项被单击(项目索引,项目标题,项目标记){
	switch(项目索引){
		case 0 :
			对话框1.信息框("",读写设置.读取设置("协议"));
		break;
		case 1 :
			窗口操作.预加载窗口("guanyu.html"),窗口操作.取指定窗口("guanyu.html").show("slide-in-right", 300);
		break;
		case 2 :
			mui.toast("暂未开启");
		break;
		case 3 :
			mui.toast("暂未开启");
		break;
	}
}

function 网络操作1_发送完毕(发送结果,返回信息){
	读写设置.保存设置("协议",返回信息);
}