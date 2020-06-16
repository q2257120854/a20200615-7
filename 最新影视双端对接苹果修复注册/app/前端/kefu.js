mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 标题栏1 = new 标题栏("标题栏1",null,null,标题栏1_左侧图标被单击);
var 标签1 = new 标签("标签1",null);
var 高级列表框1 = new 高级列表框("高级列表框1",true,true,false,高级列表框1_表项被单击);
var 标签2 = new 标签("标签2",null);
var 高级列表框2 = new 高级列表框("高级列表框2",true,true,false,高级列表框2_表项被单击);
if(mui.os.plus){
    mui.plusReady(function() {
        kefu_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        kefu_创建完毕();
        
    }
}
var mui_back = mui.back;
mui.back = function() {
    if (kefu_按下返回键()!=true) {
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
document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>联系方式</h1>";

function kefu_创建完毕(){
	高级列表框1.添加项目("http://q.qlogo.cn/headimg_dl?dst_uin="+读写设置.读取设置("联系方式")+"&spec=640","小僧法号无缘",读写设置.读取设置("联系方式"),读写设置.读取设置("联系方式"));

	高级列表框2.添加项目("images/qq.png",公用模块.APP标题() + "反馈交流群",读写设置.读取设置("QQ群聊"),读写设置.读取设置("QQ群聊"));
}


function kefu_按下返回键(){
	plus.webview.close("kefu.html","slide-out-right");
	return;
}

function 标题栏1_左侧图标被单击(){
	plus.webview.close("kefu.html","slide-out-right");
}

function 主题信息(){
	document.getElementById("标题栏1").style.background = 背景颜色;
	document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色;
	document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'></h1>";
}

function 高级列表框1_表项被单击(项目索引,项目图片,项目标题,项目信息,项目标记){
	公用模块.跳转QQ(项目标记);
}

function 高级列表框2_表项被单击(项目索引,项目图片,项目标题,项目信息,项目标记){
	公用模块.跳转QQ群(项目标记);
}