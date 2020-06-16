mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 标题栏1 = new 标题栏("标题栏1",null,null,标题栏1_左侧图标被单击);
var 下拉框1 = new 下拉框("下拉框1",下拉框1_表项被单击);
var 按钮组1 = new 按钮组("按钮组1",按钮组1_被单击);
var 标签1 = new 标签("标签1",标签1_被单击);
var 网络操作1 = new 网络操作("网络操作1",网络操作1_发送完毕);
var 标签2 = new 标签("标签2",null);
var 高级列表框1 = new 高级列表框("高级列表框1",false,true,false,高级列表框1_表项被单击);
var 对话框1 = new 对话框("对话框1",null,null,对话框1_输入框被单击);
var 剪贴板1 = new 剪贴板("剪贴板1");
var 正则1 = new 正则("正则1");
if(mui.os.plus){
    mui.plusReady(function() {
        shengchengkami_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        shengchengkami_创建完毕();
        
    }
}
var mui_back = mui.back;
mui.back = function() {
    if (shengchengkami_按下返回键()!=true) {
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
document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>代理后台</h1>";
var 广告图片;
var 广告标题;
var 广告地址;
function shengchengkami_创建完毕(){
	高级列表框1.置图片尺寸("0px","0px");
	下拉框1.添加项目("天卡","TK");
	下拉框1.添加项目("周卡","ZK");
	下拉框1.添加项目("月卡","YK");
	下拉框1.添加项目("半年卡","BNK");
	下拉框1.添加项目("年卡","NK");
	下拉框1.添加项目("终身卡","YJK");
	下拉框1.置现行选中项(i);
	按钮组1.置样式("mui-btn");
	按钮组1.置标题(0,"生成");
	按钮组1.置标题(1,"查询");
	初始化广告();
}
function 初始化广告(){
	var 截取= 读写设置.读取设置("轮播广告4");

	var index = 0;
	正则1.创建正则(截取,"<a>img=\"(.*?)\"title=\"(.*?)\"href=\"(.*?)\"</a>");
	while(index != 5){
		标签1.置标题("<img src=" + 正则1.取子匹配文本(index,1) + " style='width: 100%;height:80px;margin: 0px 0px 0px 0px;' />");
		广告地址 = 正则1.取子匹配文本(index,3);
		广告图片 = 正则1.取子匹配文本(index,1);
		广告标题 = 正则1.取子匹配文本(index,2);
		index = index + 1;
	}
	}
function 网络操作1_发送完毕(发送结果,返回信息){
	返回信息 = 公用模块.取中间文本(返回信息,"+","+");
	switch(返回信息){
		case "101" :
			mui.toast("请登录");
		break;
		case "102" :
			mui.toast("请登录");
		break;
		case "103" :
			mui.toast("请选择生成数量");
		break;
		case "104" :
			mui.toast("请选择卡密类型");
		break;
		case "105" :
			mui.toast("账号不存在");
		break;
		case "151" :
			mui.toast("请联系客服开通代理");
		break;
		case "" :
			ok弹出提示1.弹出("生成卡密失败",1,2);
		break;
		case 否则 :
			var 卡密组 = 文本操作.分割文本(返回信息,"-");
			高级列表框1.清空项目();
			var index = 0;
			while(index != 数组操作.取成员数(卡密组)){
				高级列表框1.添加项目("",下拉框1.取项目标题(i),卡密组[index],"");
				console.log(卡密组[index]);
				index = index+1;
			}

		break;
	}
}

function 下拉框1_表项被单击(项目索引,项目标题,项目标记){
	i = 项目索引;
}
function 按钮组1_被单击(按钮索引){
	对话框1.输入框("生成的数量","","确定","取消");
}

function 对话框1_输入框被单击(按钮索引,输入内容){
	switch(按钮索引){
		case 0 :
			网络操作1.发送网络请求(公用模块.AdminGuanLi() + "/api.php?action=generate","post","txt","&username=" + 读写设置.读取设置("用户帐号")+ "&token=" + 读写设置.读取设置("用户token")+"&num="+输入内容+"&type="+下拉框1.取项目标记(i),5000);
		break;
		case 1 :
			plus.webview.close("shengchengkami.html","slide-out-right");
			return;
		break;
	}
}
function shengchengkami_按下返回键(){
	plus.webview.close("shengchengkami.html","slide-out-right");
	return;
}

function 标题栏1_左侧图标被单击(){
	plus.webview.close("shengchengkami.html","slide-out-right");
}

function 高级列表框1_表项被单击(项目索引,项目图片,项目标题,项目信息,项目标记){
	剪贴板1.置剪贴板内容(项目信息);
	mui.toast("复制成功");
}
function 轮播图1_项目被单击(项目索引){

}

function 标签1_被单击(){
	if (文本操作.寻找文本(广告地址,"http",0) != -1){
		窗口操作.打开指定网址(广告地址,2);
	}else{
		读写设置.保存设置("视频图片",广告图片);
		读写设置.保存设置("视频来源","资源站"),公用模块.影视播放(广告标题,广告地址);
	}
}