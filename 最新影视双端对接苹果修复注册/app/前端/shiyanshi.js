mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 标题栏1 = new 标题栏("标题栏1",null,null,标题栏1_左侧图标被单击);
var 开关列表框1 = new 开关列表框("开关列表框1",开关列表框1_开关状态改变);
if(mui.os.plus){
    mui.plusReady(function() {
        shiyanshi_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        shiyanshi_创建完毕();
        
    }
}
var mui_back = mui.back;
mui.back = function() {
    if (shiyanshi_按下返回键()!=true) {
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
document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>实验室</h1>";

function shiyanshi_创建完毕(){

	if(读写设置.读取设置("检测beta更新") == "真" ){
		开关列表框1.添加项目("检测beta更新",2,2,true,"");
	}else{
		开关列表框1.添加项目("检测beta更新",2,2,false,"");
	}

	if(读写设置.读取设置("自动播放") == "真" ){
		开关列表框1.添加项目("自动播放",2,2,true,"");
	}else{
		开关列表框1.添加项目("自动播放",2,2,false,"");
	}

	开关列表框1.添加完毕();
}


function shiyanshi_按下返回键(){
	plus.webview.close("shiyanshi.html","slide-out-right");
	return;
}

function 标题栏1_左侧图标被单击(){
	plus.webview.close("shiyanshi.html","slide-out-right");
}

function 主题信息(){
	document.getElementById("标题栏1").style.background = 背景颜色;
	document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色;
	document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'></h1>";
}

function 开关列表框1_开关状态改变(项目索引,开关状态){
	switch(项目索引){
		case 0 :
			if(开关状态 == true ){
				读写设置.保存设置("检测beta更新","真");
			}else{
				读写设置.删除设置("检测beta更新");
			}
		break;
		case 1 :
			if(开关状态 == true ){
				读写设置.保存设置("自动播放","真");
			}else{
				读写设置.保存设置("自动播放","假");
			}
		break;
	}
}