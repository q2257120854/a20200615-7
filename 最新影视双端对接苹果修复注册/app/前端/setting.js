mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 标题栏1 = new 标题栏("标题栏1",null,null,标题栏1_左侧图标被单击);
if(mui.os.plus){
    mui.plusReady(function() {
        Setting_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        Setting_创建完毕();
        
    }
}
var mui_back = mui.back;
mui.back = function() {
    if (Setting_按下返回键()!=true) {
        mui_back();
    }
};

var 背景颜色 = 读写设置.读取设置("背景颜色");
var 默认颜色 = 读写设置.读取设置("默认颜色");
var 激活颜色 = 读写设置.读取设置("激活颜色");
var 搜索颜色 = 读写设置.读取设置("搜索颜色");
var 背景颜色 = 读写设置.读取设置("背景颜色");
document.getElementById("标题栏1").style.background = 背景颜色;
document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色;
document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>皮肤设置</h1>";
function Setting_创建完毕(){
	插入推荐div();
	读取主题信息();
}

function 读取主题信息(){
	if (读写设置.读取设置("主题颜色") == "蓝白"){
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByClassName("mui-badge")[0].innerText = "使用中";
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByTagName("img")[0].src = "images/yi9zhuti/lanbai1.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByTagName("img")[0].src = "images/yi9zhuti/heijin.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByTagName("img")[0].src = "images/yi9zhuti/kuanlv.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByTagName("img")[0].src = "images/yi9zhuti/wangyihong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByTagName("img")[0].src = "images/yi9zhuti/tengluozi.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByTagName("img")[0].src = "images/yi9zhuti/kafeizong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByTagName("img")[0].src = "images/yi9zhuti/nimengcheng.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByTagName("img")[0].src = "images/yi9zhuti/xingkonghui.png";
	}
	if (读写设置.读取设置("主题颜色") == "黑金"){
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByTagName("img")[0].src = "images/yi9zhuti/lanbai.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByClassName("mui-badge")[0].innerText = "使用中";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByTagName("img")[0].src = "images/yi9zhuti/heijin1.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByTagName("img")[0].src = "images/yi9zhuti/kuanlv.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByTagName("img")[0].src = "images/yi9zhuti/wangyihong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByTagName("img")[0].src = "images/yi9zhuti/tengluozi.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByTagName("img")[0].src = "images/yi9zhuti/kafeizong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByTagName("img")[0].src = "images/yi9zhuti/nimengcheng.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByTagName("img")[0].src = "images/yi9zhuti/xingkonghui.png";
	}
	if (读写设置.读取设置("主题颜色") == "酷安绿"){
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByTagName("img")[0].src = "images/yi9zhuti/lanbai.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByTagName("img")[0].src = "images/yi9zhuti/heijin.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByClassName("mui-badge")[0].innerText = "使用中";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByTagName("img")[0].src = "images/yi9zhuti/kuanlv1.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByTagName("img")[0].src = "images/yi9zhuti/wangyihong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByTagName("img")[0].src = "images/yi9zhuti/tengluozi.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByTagName("img")[0].src = "images/yi9zhuti/kafeizong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByTagName("img")[0].src = "images/yi9zhuti/nimengcheng.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByTagName("img")[0].src = "images/yi9zhuti/xingkonghui.png";
	}
	if (读写设置.读取设置("主题颜色") == "网易红"){
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByTagName("img")[0].src = "images/yi9zhuti/lanbai.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByTagName("img")[0].src = "images/yi9zhuti/heijin.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByTagName("img")[0].src = "images/yi9zhuti/kuanlv.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByClassName("mui-badge")[0].innerText = "使用中";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByTagName("img")[0].src = "images/yi9zhuti/wangyihong1.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByTagName("img")[0].src = "images/yi9zhuti/tengluozi.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByTagName("img")[0].src = "images/yi9zhuti/kafeizong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByTagName("img")[0].src = "images/yi9zhuti/nimengcheng.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByTagName("img")[0].src = "images/yi9zhuti/xingkonghui.png";
	}
	if (读写设置.读取设置("主题颜色") == "哔哩粉"){
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByTagName("img")[0].src = "images/yi9zhuti/lanbai.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByTagName("img")[0].src = "images/yi9zhuti/heijin.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByTagName("img")[0].src = "images/yi9zhuti/kuanlv.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByTagName("img")[0].src = "images/yi9zhuti/wangyihong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByClassName("mui-badge")[0].innerText = "使用中";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByTagName("img")[0].src = "images/yi9zhuti/tengluozi1.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByTagName("img")[0].src = "images/yi9zhuti/kafeizong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByTagName("img")[0].src = "images/yi9zhuti/nimengcheng.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByTagName("img")[0].src = "images/yi9zhuti/xingkonghui.png";
	}
	if (读写设置.读取设置("主题颜色") == "咖啡棕"){
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByTagName("img")[0].src = "images/yi9zhuti/lanbai.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByTagName("img")[0].src = "images/yi9zhuti/heijin.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByTagName("img")[0].src = "images/yi9zhuti/kuanlv.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByTagName("img")[0].src = "images/yi9zhuti/wangyihong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByTagName("img")[0].src = "images/yi9zhuti/tengluozi.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByClassName("mui-badge")[0].innerText = "使用中";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByTagName("img")[0].src = "images/yi9zhuti/kafeizong1.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByTagName("img")[0].src = "images/yi9zhuti/nimengcheng.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByTagName("img")[0].src = "images/yi9zhuti/xingkonghui.png";
	}
	if (读写设置.读取设置("主题颜色") == "柠檬橙"){
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByTagName("img")[0].src = "images/yi9zhuti/lanbai.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByTagName("img")[0].src = "images/yi9zhuti/heijin.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByTagName("img")[0].src = "images/yi9zhuti/kuanlv.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByTagName("img")[0].src = "images/yi9zhuti/wangyihong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByTagName("img")[0].src = "images/yi9zhuti/tengluozi.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByTagName("img")[0].src = "images/yi9zhuti/kafeizong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByClassName("mui-badge")[0].innerText = "使用中";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByTagName("img")[0].src = "images/yi9zhuti/nimengcheng1.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByTagName("img")[0].src = "images/yi9zhuti/xingkonghui.png";
	}
	if (读写设置.读取设置("主题颜色") == "星空灰"){
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByTagName("img")[0].src = "images/yi9zhuti/lanbai.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByTagName("img")[0].src = "images/yi9zhuti/heijin.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByTagName("img")[0].src = "images/yi9zhuti/kuanlv.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByTagName("img")[0].src = "images/yi9zhuti/wangyihong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByTagName("img")[0].src = "images/yi9zhuti/tengluozi.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByTagName("img")[0].src = "images/yi9zhuti/kafeizong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByTagName("img")[0].src = "images/yi9zhuti/nimengcheng.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByClassName("mui-badge")[0].innerText = "使用中";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByTagName("img")[0].src = "images/yi9zhuti/xingkonghui1.png";
	}
	document.querySelectorAll("#标题栏1 a")[0].innerHTML = "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>皮肤设置</h1>";
}

function 主题被切换(i){

	if (i == "0"){
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByClassName("mui-badge")[0].innerText = "使用中";
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByTagName("img")[0].src = "images/yi9zhuti/lanbai1.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByTagName("img")[0].src = "images/yi9zhuti/heijin.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByTagName("img")[0].src = "images/yi9zhuti/kuanlv.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByTagName("img")[0].src = "images/yi9zhuti/wangyihong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByTagName("img")[0].src = "images/yi9zhuti/tengluozi.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByTagName("img")[0].src = "images/yi9zhuti/kafeizong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByTagName("img")[0].src = "images/yi9zhuti/nimengcheng.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByTagName("img")[0].src = "images/yi9zhuti/xingkonghui.png";
		读写设置.保存设置("主题颜色","蓝白");
		检测主题颜色();
		document.querySelectorAll("#标题栏1 a")[0].innerHTML = "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>皮肤设置</h1>";
		全局主题();
		return;
	}
	if (i == "1"){
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByTagName("img")[0].src = "images/yi9zhuti/lanbai.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByClassName("mui-badge")[0].innerText = "使用中";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByTagName("img")[0].src = "images/yi9zhuti/heijin1.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByTagName("img")[0].src = "images/yi9zhuti/kuanlv.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByTagName("img")[0].src = "images/yi9zhuti/wangyihong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByTagName("img")[0].src = "images/yi9zhuti/tengluozi.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByTagName("img")[0].src = "images/yi9zhuti/kafeizong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByTagName("img")[0].src = "images/yi9zhuti/nimengcheng.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByTagName("img")[0].src = "images/yi9zhuti/xingkonghui.png";
		读写设置.保存设置("主题颜色","黑金");
		检测主题颜色();
		document.querySelectorAll("#标题栏1 a")[0].innerHTML = "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>皮肤设置</h1>";
		全局主题();
		return;
	}
	if (i == "2"){
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByTagName("img")[0].src = "images/yi9zhuti/lanbai.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByTagName("img")[0].src = "images/yi9zhuti/heijin.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByClassName("mui-badge")[0].innerText = "使用中";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByTagName("img")[0].src = "images/yi9zhuti/kuanlv1.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByTagName("img")[0].src = "images/yi9zhuti/wangyihong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByTagName("img")[0].src = "images/yi9zhuti/tengluozi.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByTagName("img")[0].src = "images/yi9zhuti/kafeizong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByTagName("img")[0].src = "images/yi9zhuti/nimengcheng.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByTagName("img")[0].src = "images/yi9zhuti/xingkonghui.png";
		读写设置.保存设置("主题颜色","酷安绿");
		检测主题颜色();
		document.querySelectorAll("#标题栏1 a")[0].innerHTML = "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>皮肤设置</h1>";
		全局主题();
		return;
	}
	if (i == "3"){
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByTagName("img")[0].src = "images/yi9zhuti/lanbai.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByTagName("img")[0].src = "images/yi9zhuti/heijin.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByTagName("img")[0].src = "images/yi9zhuti/kuanlv.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByClassName("mui-badge")[0].innerText = "使用中";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByTagName("img")[0].src = "images/yi9zhuti/wangyihong1.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByTagName("img")[0].src = "images/yi9zhuti/tengluozi.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByTagName("img")[0].src = "images/yi9zhuti/kafeizong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByTagName("img")[0].src = "images/yi9zhuti/nimengcheng.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByTagName("img")[0].src = "images/yi9zhuti/xingkonghui.png";
		读写设置.保存设置("主题颜色","网易红");
		检测主题颜色();
		document.querySelectorAll("#标题栏1 a")[0].innerHTML = "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>皮肤设置</h1>";
		全局主题();
		return;
	}
	if (i == "4"){
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByTagName("img")[0].src = "images/yi9zhuti/lanbai.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByTagName("img")[0].src = "images/yi9zhuti/heijin.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByTagName("img")[0].src = "images/yi9zhuti/kuanlv.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByTagName("img")[0].src = "images/yi9zhuti/wangyihong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByClassName("mui-badge")[0].innerText = "使用中";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByTagName("img")[0].src = "images/yi9zhuti/tengluozi1.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByTagName("img")[0].src = "images/yi9zhuti/kafeizong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByTagName("img")[0].src = "images/yi9zhuti/nimengcheng.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByTagName("img")[0].src = "images/yi9zhuti/xingkonghui.png";
		读写设置.保存设置("主题颜色","哔哩粉");
		检测主题颜色();
		document.querySelectorAll("#标题栏1 a")[0].innerHTML = "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>皮肤设置</h1>";
		全局主题();
		return;
	}
	if (i == "5"){
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByTagName("img")[0].src = "images/yi9zhuti/lanbai.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByTagName("img")[0].src = "images/yi9zhuti/heijin.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByTagName("img")[0].src = "images/yi9zhuti/kuanlv.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByTagName("img")[0].src = "images/yi9zhuti/wangyihong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByTagName("img")[0].src = "images/yi9zhuti/tengluozi.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByClassName("mui-badge")[0].innerText = "使用中";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByTagName("img")[0].src = "images/yi9zhuti/kafeizong1.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByTagName("img")[0].src = "images/yi9zhuti/nimengcheng.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByTagName("img")[0].src = "images/yi9zhuti/xingkonghui.png";
		读写设置.保存设置("主题颜色","咖啡棕");
		检测主题颜色();
		document.querySelectorAll("#标题栏1 a")[0].innerHTML = "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>皮肤设置</h1>";
		全局主题();
		return;
	}
	if (i == "6"){
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByTagName("img")[0].src = "images/yi9zhuti/lanbai.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByTagName("img")[0].src = "images/yi9zhuti/heijin.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByTagName("img")[0].src = "images/yi9zhuti/kuanlv.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByTagName("img")[0].src = "images/yi9zhuti/wangyihong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByTagName("img")[0].src = "images/yi9zhuti/tengluozi.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByTagName("img")[0].src = "images/yi9zhuti/kafeizong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByClassName("mui-badge")[0].innerText = "使用中";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByTagName("img")[0].src = "images/yi9zhuti/nimengcheng1.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByTagName("img")[0].src = "images/yi9zhuti/xingkonghui.png";
		读写设置.保存设置("主题颜色","柠檬橙");
		检测主题颜色();
		document.querySelectorAll("#标题栏1 a")[0].innerHTML = "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>皮肤设置</h1>";
		全局主题();
		return;
	}
	if (i == "7"){
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[0].getElementsByTagName("img")[0].src = "images/yi9zhuti/lanbai.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[1].getElementsByTagName("img")[0].src = "images/yi9zhuti/heijin.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[2].getElementsByTagName("img")[0].src = "images/yi9zhuti/kuanlv.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[3].getElementsByTagName("img")[0].src = "images/yi9zhuti/wangyihong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[4].getElementsByTagName("img")[0].src = "images/yi9zhuti/tengluozi.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[5].getElementsByTagName("img")[0].src = "images/yi9zhuti/kafeizong.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByClassName("mui-badge")[0].innerText = "使用";
		document.getElementById("高级列表框1").getElementsByTagName("li")[6].getElementsByTagName("img")[0].src = "images/yi9zhuti/nimengcheng.png";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByClassName("mui-badge")[0].innerText = "使用中";
		document.getElementById("高级列表框1").getElementsByTagName("li")[7].getElementsByTagName("img")[0].src = "images/yi9zhuti/xingkonghui1.png";
		读写设置.保存设置("主题颜色","星空灰");
		检测主题颜色();
		document.querySelectorAll("#标题栏1 a")[0].innerHTML = "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>皮肤设置</h1>";
		全局主题();
		return;
	}
}

function 标题栏1_左侧图标被单击(){
	var self = plus.webview.currentWebview();
	    plus.webview.close(self,"slide-out-right");
}

function Setting_按下返回键(){
	var self = plus.webview.currentWebview();
	    plus.webview.close(self,"slide-out-right");
		return;
}

function 全局主题(){
	窗口操作.设置状态栏颜色(背景颜色);
	窗口操作.执行代码("index1.html","刷新主题颜色()");
	窗口操作.执行代码("main.html","刷新主题颜色()");
	窗口操作.执行代码("main1.html","刷新主题颜色()");
	窗口操作.执行代码("shipin1.html","刷新主题颜色()");
	窗口操作.执行代码("zhibo1.html","刷新主题颜色()");
	窗口操作.执行代码("caidan.html","刷新主题颜色()");



}

function 插入推荐div(){

	var div = document.createElement("div");
	div.innerHTML = "<ul id='高级列表框1' class='mui-table-view'>"+
					"<li class='mui-table-view-cell mui-media mui-media-icon' tag='0'>"+
					"<img class='mui-pull-left' style='width:30px;height:30px;margin-right:10px' src='images/yi9zhuti/lanbai.png'><div class='mui-media-body' style='margin:5px 0px 0px 0px;font-family: 黑体;'>知乎蓝</div>"+
					"<span class='mui-badge mui-badge-danger'>使用</span></li>"+
					"<li class='mui-table-view-cell mui-media mui-media-icon' tag='1'>"+
					"<img class='mui-media-object mui-pull-left' style='width:30px;height:30px;margin-right:10px' src='images/yi9zhuti/heijin.png'><div class='mui-media-body' style='margin:5px 0px 0px 0px;font-family: 黑体;'>炫金黑</div>"+
					"<span class='mui-badge mui-badge-danger'>使用</span></li>"+
					"<li class='mui-table-view-cell mui-media mui-media-icon' tag='2'>"+
					"<img class='mui-pull-left' style='width:30px;height:30px;margin-right:10px' src='images/yi9zhuti/kuanlv.png'><div class='mui-media-body' style='margin:5px 0px 0px 0px;font-family: 黑体;'>酷安绿</div>"+
					"<span class='mui-badge mui-badge-danger'>使用</span></li>"+
					"<li class='mui-table-view-cell mui-media mui-media-icon' tag='3'>"+
					"<img class='mui-pull-left' style='width:30px;height:30px;margin-right:10px' src='images/yi9zhuti/wangyihong.png'><div class='mui-media-body' style='margin:5px 0px 0px 0px;font-family: 黑体;'>网易红</div>"+
					"<span class='mui-badge mui-badge-danger'>使用</span></li>"+
					"<li class='mui-table-view-cell mui-media mui-media-icon' tag='4'>"+
					"<img class='mui-pull-left' style='width:30px;height:30px;margin-right:10px' src='images/yi9zhuti/tengluozi.png'><div class='mui-media-body' style='margin:5px 0px 0px 0px;font-family: 黑体;'>丁香紫</div>"+
					"<span class='mui-badge mui-badge-danger'>使用</span></li>"+
					"<li class='mui-table-view-cell mui-media mui-media-icon' tag='5'>"+
					"<img class='mui-pull-left' style='width:30px;height:30px;margin-right:10px' src='images/yi9zhuti/kafeizong.png'><div class='mui-media-body' style='margin:5px 0px 0px 0px;font-family: 黑体;'>咖啡棕</div>"+
					"<span class='mui-badge mui-badge-danger'>使用</span></li>"+
					"<li class='mui-table-view-cell mui-media mui-media-icon' tag='6'>"+
					"<img class='mui-pull-left' style='width:30px;height:30px;margin-right:10px' src='images/yi9zhuti/nimengcheng.png'><div class='mui-media-body' style='margin:5px 0px 0px 0px;font-family: 黑体;'>柠檬橙</div>"+
					"<span class='mui-badge mui-badge-danger'>使用</span></li>"+
					"<li class='mui-table-view-cell mui-media mui-media-icon' tag='7'>"+
					"<img class='mui-pull-left' style='width:30px;height:30px;margin-right:10px' src='images/yi9zhuti/xingkonghui.png'><div class='mui-media-body' style='margin:5px 0px 0px 0px;font-family: 黑体;'>星空灰</div>"+
					"<span class='mui-badge mui-badge-danger'>使用</span></li>"+
					"</ul>";
	document.body.appendChild(div);
	document.body.querySelectorAll("div")[0].insertBefore(div, document.body.nextSibling);
	mui("#高级列表框1").on("tap", "li", function() { 主题被切换(this.getAttribute("tag"));});
					"<li class='mui-table-view-cell mui-media mui-media-icon' tag='#59B7C3'>"+
					"<img class='mui-pull-left' style='width:30px;height:30px;margin-right:10px' src='images/yi9zhuti/bihailan.png'><div class='mui-media-body'>碧海蓝</div>"+
					"<span class='mui-badge mui-badge-danger'>使用</span></li>"+

					"<li class='mui-table-view-cell mui-media mui-media-icon' tag='#89C348'>"+
					"<img class='mui-pull-left' style='width:30px;height:30px;margin-right:10px' src='images/yi9zhuti/yingcaolv.png'><div class='mui-media-body'>樱草绿</div>"+
					"<span class='mui-badge mui-badge-danger'>使用</span></li>"+

					"<li class='mui-table-view-cell mui-media mui-media-icon' tag='#75655A'>"+
					"<img class='mui-pull-left' style='width:30px;height:30px;margin-right:10px' src='images/yi9zhuti/kafeizong.png'><div class='mui-media-body'>咖啡棕</div>"+
					"<span class='mui-badge mui-badge-danger'>使用</span></li>"+

					"<li class='mui-table-view-cell mui-media mui-media-icon' tag='#D88100'>"+
					"<img class='mui-pull-left' style='width:30px;height:30px;margin-right:10px' src='images/yi9zhuti/nimengcheng.png'><div class='mui-media-body'>柠檬橙</div>"+
					"<span class='mui-badge mui-badge-danger'>使用</span></li>"+

					"<li class='mui-table-view-cell mui-media mui-media-icon' tag='#364F59'>"+
					"<img class='mui-pull-left' style='width:30px;height:30px;margin-right:10px' src='images/yi9zhuti/xingkonghui.png'><div class='mui-media-body'>星空灰</div>"+
					"<span class='mui-badge mui-badge-danger'>使用</span></li>"+

					"<li class='mui-table-view-cell mui-media mui-media-icon' tag='#3A3A3A'>"+
					"<img class='mui-pull-left' style='width:30px;height:30px;margin-right:10px' src='images/yi9zhuti/yejianmoshi.png'><div class='mui-media-body'>夜间模式</div>"+
					"<span class='mui-badge mui-badge-danger'>使用</span></li>";
}

function 检测主题颜色(){

if (读写设置.读取设置("主题颜色") == "" || 读写设置.读取设置("主题颜色") == null || 读写设置.读取设置("主题颜色") == null) {
	读写设置.保存设置("主题颜色","网易红");
	背景颜色 = "#D33A2F";
	默认颜色 = "#f0f0f0";
	激活颜色 = "#FFFFFF";
	搜索颜色 = "#CC3D50";
	读写设置.保存设置("菜单消息","xx4.png");
	读写设置.保存设置("菜单收藏","sc4.png");
	读写设置.保存设置("菜单记录","jl4.png");
	读写设置.保存设置("菜单代理","dl4.png");
	读写设置.保存设置("首页图标1","sy0.png");
	读写设置.保存设置("发现图标1","fx0.png");
	读写设置.保存设置("直播图标1","zb0.png");
	读写设置.保存设置("我的图标1","wd0.png");
	读写设置.保存设置("背景图片","4.png")}
if (读写设置.读取设置("主题颜色") == "蓝白"){
	背景颜色 = "#0088FF";
	默认颜色 = "#f0f0f0";
	激活颜色 = "#FFFFFF";
	搜索颜色 = "#0078FF";
	读写设置.保存设置("菜单消息","xx1.png");
	读写设置.保存设置("菜单收藏","sc1.png");
	读写设置.保存设置("菜单记录","jl1.png");
	读写设置.保存设置("菜单代理","dl1.png");
	读写设置.保存设置("首页图标1","sy1.png");
	读写设置.保存设置("发现图标1","fx1.png");
	读写设置.保存设置("直播图标1","zb1.png");
	读写设置.保存设置("我的图标1","wd1.png");
	读写设置.保存设置("背景图片","1.png")}
if (读写设置.读取设置("主题颜色") == "黑金"){
	背景颜色 = "#000000";
	默认颜色 = "#f0f0f0";
	激活颜色 = "#FFE28A";
	搜索颜色 = "#3F3F3F";
	读写设置.保存设置("菜单消息","xx2.png");
	读写设置.保存设置("菜单收藏","sc2.png");
	读写设置.保存设置("菜单记录","jl2.png");
	读写设置.保存设置("菜单代理","dl2.png");
	读写设置.保存设置("首页图标1","sy2.png");
	读写设置.保存设置("发现图标1","fx2.png");
	读写设置.保存设置("直播图标1","zb2.png");
	读写设置.保存设置("我的图标1","wd2.png");
	读写设置.保存设置("背景图片","2.png")}
if (读写设置.读取设置("主题颜色") == "酷安绿"){
	背景颜色 = "#4BAF4E";
	默认颜色 = "#f0f0f0";
	激活颜色 = "#FFFFFF";
	搜索颜色 = "#44a444";
	读写设置.保存设置("菜单消息","xx3.png");
	读写设置.保存设置("菜单收藏","sc3.png");
	读写设置.保存设置("菜单记录","jl3.png");
	读写设置.保存设置("菜单代理","dl3.png");
	读写设置.保存设置("首页图标1","sy3.png");
	读写设置.保存设置("发现图标1","fx3.png");
	读写设置.保存设置("直播图标1","zb3.png");
	读写设置.保存设置("我的图标1","wd3.png");
	读写设置.保存设置("背景图片","3.png")}
if (读写设置.读取设置("主题颜色") == "网易红"){
	背景颜色 = "#D33A2F";
	默认颜色 = "#f0f0f0";
	激活颜色 = "#FFFFFF";
	搜索颜色 = "#CC3D50";
	读写设置.保存设置("菜单消息","xx4.png");
	读写设置.保存设置("菜单收藏","sc4.png");
	读写设置.保存设置("菜单记录","jl4.png");
	读写设置.保存设置("菜单代理","dl4.png");
	读写设置.保存设置("首页图标1","sy4.png");
	读写设置.保存设置("发现图标1","fx4.png");
	读写设置.保存设置("直播图标1","zb4.png");
	读写设置.保存设置("我的图标1","wd4.png");
	读写设置.保存设置("背景图片","4.png")}
if (读写设置.读取设置("主题颜色") == "哔哩粉"){
	背景颜色 = "#B47DB4";
	默认颜色 = "#f0f0f0";
	激活颜色 = "#FFFFFF";
	搜索颜色 = "#b06eb0";
	读写设置.保存设置("菜单消息","xx5.png");
	读写设置.保存设置("菜单收藏","sc5.png");
	读写设置.保存设置("菜单记录","jl5.png");
	读写设置.保存设置("菜单代理","dl5.png");
	读写设置.保存设置("首页图标1","sy5.png");
	读写设置.保存设置("发现图标1","fx5.png");
	读写设置.保存设置("直播图标1","zb5.png");
	读写设置.保存设置("我的图标1","wd5.png");
	读写设置.保存设置("背景图片","5.png")}
if (读写设置.读取设置("主题颜色") == "咖啡棕"){
	背景颜色 = "#75655A";
	默认颜色 = "#f0f0f0";
	激活颜色 = "#FFFFFF";
	搜索颜色 = "#685a50";
	读写设置.保存设置("菜单消息","xx6.png");
	读写设置.保存设置("菜单收藏","sc6.png");
	读写设置.保存设置("菜单记录","jl6.png");
	读写设置.保存设置("菜单代理","dl6.png");
	读写设置.保存设置("首页图标1","sy6.png");
	读写设置.保存设置("发现图标1","fx6.png");
	读写设置.保存设置("直播图标1","zb6.png");
	读写设置.保存设置("我的图标1","wd6.png");
	读写设置.保存设置("背景图片","6.png")}
if (读写设置.读取设置("主题颜色") == "柠檬橙"){
	背景颜色 = "#D88100";
	默认颜色 = "#f0f0f0";
	激活颜色 = "#FFFFFF";
	搜索颜色 = "#cd7b02";
	读写设置.保存设置("菜单消息","xx7.png");
	读写设置.保存设置("菜单收藏","sc7.png");
	读写设置.保存设置("菜单记录","jl7.png");
	读写设置.保存设置("菜单代理","dl7.png");
	读写设置.保存设置("首页图标1","sy7.png");
	读写设置.保存设置("发现图标1","fx7.png");
	读写设置.保存设置("直播图标1","zb7.png");
	读写设置.保存设置("我的图标1","wd7.png");
	读写设置.保存设置("背景图片","7.png")}
if (读写设置.读取设置("主题颜色") == "星空灰"){
	背景颜色 = "#364F59";
	默认颜色 = "#f0f0f0";
	激活颜色 = "#FFFFFF";
	搜索颜色 = "#314750";
	读写设置.保存设置("菜单消息","xx8.png");
	读写设置.保存设置("菜单收藏","sc8.png");
	读写设置.保存设置("菜单记录","jl8.png");
	读写设置.保存设置("菜单代理","dl8.png");
	读写设置.保存设置("首页图标1","sy0.png");
	读写设置.保存设置("发现图标1","fx0.png");
	读写设置.保存设置("直播图标1","zb0.png");
	读写设置.保存设置("我的图标1","wd0.png");
	读写设置.保存设置("背景图片","8.png")}
读写设置.保存设置("背景颜色",背景颜色);
读写设置.保存设置("默认颜色",默认颜色);
读写设置.保存设置("激活颜色",激活颜色);
读写设置.保存设置("搜索颜色",搜索颜色);

document.getElementById("标题栏1").style.background = 背景颜色;
document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色;
document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>皮肤设置</h1>";
}