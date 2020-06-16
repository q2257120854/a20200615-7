mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 标题栏1 = new 标题栏("标题栏1",null,null,标题栏1_左侧图标被单击);
var 下拉框1 = new 下拉框("下拉框1",下拉框1_表项被单击);
var 下拉框2 = new 下拉框("下拉框2",下拉框2_表项被单击);
var 按钮组1 = new 按钮组("按钮组1",按钮组1_被单击);
var 标签1 = new 标签("标签1",标签1_被单击);
var 网络操作1 = new 网络操作("网络操作1",网络操作1_发送完毕);
var 标签2 = new 标签("标签2",null);
var 高级列表框1 = new 高级列表框("高级列表框1",false,true,false,高级列表框1_表项被单击);
var 剪贴板1 = new 剪贴板("剪贴板1");
var 正则1 = new 正则("正则1");
if(mui.os.plus){
    mui.plusReady(function() {
        chaxundaili_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        chaxundaili_创建完毕();
        
    }
}
var mui_back = mui.back;
mui.back = function() {
    if (chaxundaili_按下返回键()!=true) {
        mui_back();
    }
};

var 背景颜色 = 读写设置.读取设置("背景颜色");
var 默认颜色 = 读写设置.读取设置("默认颜色");
var 激活颜色 = 读写设置.读取设置("激活颜色");
var 搜索颜色 = 读写设置.读取设置("搜索颜色");
document.getElementById("标题栏1").style.background = 背景颜色;
document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色;
document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>代理后台</h1>";
	var i= 0;
	var a= 0;
	var 广告图片;
var 广告标题;
var 广告地址;
function chaxundaili_创建完毕(){
	高级列表框1.置图片尺寸("0px","0px");
	下拉框1.添加项目("全部卡密","");
	下拉框1.添加项目("可用卡密","y");
	下拉框1.添加项目("已用卡密","n ");
	下拉框1.置现行选中项(i);
	下拉框2.添加项目("全部卡密","");
	下拉框2.添加项目("天卡","TK");
	下拉框2.添加项目("周卡","ZK");
	下拉框2.添加项目("月卡","YK");
	下拉框2.添加项目("半年卡","BNK");
	下拉框2.添加项目("年卡","NK");
	下拉框2.添加项目("终身卡","YJK");
	下拉框2.置现行选中项(a);
	按钮组1.置样式("mui-btn");
	按钮组1.置标题(0,"查询");
	按钮组1.置标题(1,"生成");
	初始化广告();
	网络操作1.发送网络请求(公用模块.AdminGuanLi() + "/cxkm.php","post","txt","&username=" + 读写设置.读取设置("用户帐号")+ "&token=" + 读写设置.读取设置("用户token")+"&kalei="+下拉框2.取项目标记(a)+"&zhuangtai="+下拉框1.取项目标记(i),5000);

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
	if(返回信息 == null ){
		高级列表框1.清空项目();
		高级列表框1.添加项目("","暂未生成卡密","","");
	}else{
		高级列表框1.清空项目();
		var km = 文本操作.取指定文本(返回信息,"km-","</td>");
		var zt = 文本操作.取指定文本(返回信息,"zt-","</td>");
		var lx = 文本操作.取指定文本(返回信息,"lx-","</td>");
		var index = 0;
		while(index != 数组操作.取成员数(km)){
			高级列表框1.添加项目("",lx[index]+"/"+zt[index],km[index],"");
			index = index+1;
		}
	}


}

function 下拉框1_表项被单击(项目索引,项目标题,项目标记){
	i = 项目索引;
}

function 下拉框2_表项被单击(项目索引,项目标题,项目标记){
	a = 项目索引;
}
function 按钮组1_被单击(按钮索引){
	switch(按钮索引){
		case 0 :
			网络操作1.发送网络请求(公用模块.AdminGuanLi() + "/cxkm.php","post","txt","&username=" + 读写设置.读取设置("用户帐号")+ "&token=" + 读写设置.读取设置("用户token")+"&kalei="+下拉框2.取项目标记(a)+"&zhuangtai="+下拉框1.取项目标记(i),5000);
		break;
		case 1 :
			窗口操作.预加载窗口("shengchengkami.html");
			窗口操作.取指定窗口("shengchengkami.html").show("slide-in-right", 300);
		break;
	}
}
function chaxundaili_按下返回键(){
	plus.webview.close("chaxundaili.html","slide-out-right");
	return;
}

function 标题栏1_左侧图标被单击(){
	plus.webview.close("chaxundaili.html","slide-out-right");
}
function 高级列表框1_表项被单击(项目索引,项目图片,项目标题,项目信息,项目标记){
	剪贴板1.置剪贴板内容(项目信息);
	mui.toast("复制成功");
}
function 标签1_被单击(){
	if (文本操作.寻找文本(广告地址,"http",0) != -1){
		窗口操作.打开指定网址(广告地址,2);
	}else{
		读写设置.保存设置("视频图片",广告图片);
		读写设置.保存设置("视频来源","资源站"),公用模块.影视播放(广告标题,广告地址);
	}
}