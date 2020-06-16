(function (){ 
window["公用模块"] = {}
function APP标题(){
	return "爱看视频";
}

function 当前版本(){  // 跟后台设置一致，http://ikmovie.xyz/
	return "3.1.6";
}

function CMSAPI(){//苹果cms网站地址
	return "http://v.ikmovie.xyz/";
}
function AdminGuanLi(){//后台搭建地址     不知道怎么替换可以把这两个网址访问一遍，看看分别对应什么后台，其它自己看着修改
	return "http://b.ikmovie.xyz";
}

function 推荐分类(){
	return "23";
}
function 电影分类(){
	return "9";
}
function 电视分类(){
	return "13";
}
function 综艺分类(){
	return "3";
}
function 动漫分类(){
	return "4";
}


function 跳转QQ群(QQ群号码){
    窗口操作.打开指定网址("mqqapi://card/show_pslcard?src_type=internal&version=1&uin=" + QQ群号码 + "&card_type=group&source=qrcode");
}
function 跳转QQ(QQ号){
	窗口操作.打开指定网址("mqqwpa://im/chat?chat_type=wpa&uin=" + QQ号 + "&version=1&src_type=web&web_src=oicqzone.com");
}
function 聚合直播播放(title,video){
	if (数学操作.到数值(读写设置.读取设置("运营模式")) == 0){

		读写设置.保存设置("视频来源","直播");
		读写设置.保存设置("视频标题",title);
		读写设置.保存设置("视频ID",video);
		if (读写设置.读取设置("用户帐号") != "" && 读写设置.读取设置("用户密码") != null && 读写设置.读取设置("用户时间") != null){
			窗口操作.预加载窗口("play.html");
			窗口操作.取指定窗口("play.html").show("slide-in-right", 300);
	    }else{
			mui.toast("请先登录后使用");
			窗口操作.预加载窗口("login.html");
			窗口操作.取指定窗口("login.html").show("slide-in-right", 300);
		}
	}

	if (数学操作.到数值(读写设置.读取设置("运营模式")) == 2){

		读写设置.保存设置("视频来源","直播");
		读写设置.保存设置("视频标题",title);
		读写设置.保存设置("视频ID",video);
		窗口操作.预加载窗口("play.html");
		窗口操作.取指定窗口("play.html").show("slide-in-right");
	}

	if (数学操作.到数值(读写设置.读取设置("运营模式")) == 1){
		读写设置.保存设置("视频来源","直播");
		读写设置.保存设置("视频标题",title);
		读写设置.保存设置("视频ID",video);
		if (读写设置.读取设置("用户帐号") != "" && 读写设置.读取设置("用户密码") != null && 读写设置.读取设置("用户时间") != null){
		    if (数学操作.取整数(读写设置.读取设置("用户时间")) + "000" <  时间操作.取时间戳(时间操作.取现行日期() + " " + 时间操作.取现行时间())){
				mui.alert("您的VIP账户已到期","温馨提示");
			}else{
				窗口操作.预加载窗口("play.html");
				窗口操作.取指定窗口("play.html").show("slide-in-right", 300);
			}
	    }else{
			mui.toast("请先登录后使用");
			窗口操作.预加载窗口("login.html");
			窗口操作.取指定窗口("login.html").show("slide-in-right", 300);
		}
	}
}
function 直播播放(title,video){
	if (数学操作.到数值(读写设置.读取设置("运营模式")) == 0){

		读写设置.保存设置("视频来源","直播");
		读写设置.保存设置("视频标题",title);
		读写设置.保存设置("视频ID",video);
		if (读写设置.读取设置("用户帐号") != "" && 读写设置.读取设置("用户密码") != null && 读写设置.读取设置("用户时间") != null){
			窗口操作.预加载窗口("play.html");
			窗口操作.取指定窗口("play.html").show("slide-in-right", 300);
	    }else{
			mui.toast("请先登录后使用");
			窗口操作.预加载窗口("login.html");
			窗口操作.取指定窗口("login.html").show("slide-in-right", 300);
		}
	}

	if (数学操作.到数值(读写设置.读取设置("运营模式")) == 2){

		读写设置.保存设置("视频来源","直播");
		读写设置.保存设置("视频标题",title);
		读写设置.保存设置("视频ID",video);
		窗口操作.预加载窗口("play.html");
		窗口操作.取指定窗口("play.html").show("slide-in-right");
	}

	if (数学操作.到数值(读写设置.读取设置("运营模式")) == 1){
		读写设置.保存设置("视频来源","直播");
		读写设置.保存设置("视频标题",title);
		读写设置.保存设置("视频ID",video);
		if (读写设置.读取设置("用户帐号") != "" && 读写设置.读取设置("用户密码") != null && 读写设置.读取设置("用户时间") != null){
		    if (数学操作.取整数(读写设置.读取设置("用户时间")) + "000" <  时间操作.取时间戳(时间操作.取现行日期() + " " + 时间操作.取现行时间())){
				mui.alert("您的VIP账户已到期","温馨提示");
			}else{
				窗口操作.预加载窗口("play.html");
				窗口操作.取指定窗口("play.html").show("slide-in-right", 300);
			}
	    }else{
			mui.toast("请先登录后使用");
			窗口操作.预加载窗口("login.html");
			窗口操作.取指定窗口("login.html").show("slide-in-right", 300);
		}
	}
}

function 影视播放(title,video){
	if (数学操作.到数值(读写设置.读取设置("运营模式")) == 0){

		读写设置.保存设置("视频标题",title);
		读写设置.保存设置("视频ID",video);
		if (读写设置.读取设置("用户帐号") != "" && 读写设置.读取设置("用户密码") != null && 读写设置.读取设置("用户时间") != null){
			窗口操作.预加载窗口("play.html");
			窗口操作.取指定窗口("play.html").show("slide-in-right", 300);
	    }else{
			mui.toast("请先登录后使用");
			窗口操作.预加载窗口("login.html");
			窗口操作.取指定窗口("login.html").show("slide-in-right", 300);
		}
	}

	if (数学操作.到数值(读写设置.读取设置("运营模式")) == 2){

		读写设置.保存设置("视频标题",title);
		读写设置.保存设置("视频ID",video);
		窗口操作.预加载窗口("play.html");
		窗口操作.取指定窗口("play.html").show("slide-in-right", 300);
	}

	if (数学操作.到数值(读写设置.读取设置("运营模式")) == 1){
		读写设置.保存设置("视频标题",title);
		读写设置.保存设置("视频ID",video);
		if (读写设置.读取设置("用户帐号") != "" && 读写设置.读取设置("用户密码") != null && 读写设置.读取设置("用户时间") != null){
		    if (数学操作.取整数(读写设置.读取设置("用户时间")) + "000" <  时间操作.取时间戳(时间操作.取现行日期() + " " + 时间操作.取现行时间())){
				mui.alert("您的VIP账户已到期","温馨提示");
			}else{
				窗口操作.预加载窗口("play.html");
				窗口操作.取指定窗口("play.html").show("slide-in-right", 300);
			}
	    }else{
			mui.toast("请先登录后使用");
			窗口操作.预加载窗口("login.html");
			窗口操作.取指定窗口("login.html").show("slide-in-right", 300);
		}
	}
}

function 运营模式标题(){
	if (数学操作.到数值(读写设置.读取设置("运营模式")) == 0){
		return "免费模式";
	}
	if (数学操作.到数值(读写设置.读取设置("运营模式")) == 2){
		return "免登录模式";
	}
	if (数学操作.到数值(读写设置.读取设置("运营模式")) == 1){
		return "收费模式";
	}
}
function xiazai(){
	return "http://www.zuidazy1.net";
}
function 取中间文本(完整内容,左边文本,右边文本){
	var 左边;
	var 右边;
	var 结果;
	左边 = 文本操作.寻找文本(完整内容,左边文本,0) + 文本操作.取文本长度 (左边文本);
	if( 左边 == -1 ){
	    结果="";

	    return 结果;
	}
	右边 = 文本操作.寻找文本 (完整内容,右边文本,左边);
	if( 右边 == -1 || 左边 > 右边 ) {
	    结果 = "";

	    return 结果;
	}
	结果 = 文本操作.取文本中间(完整内容,左边,右边 - 左边);
	return 结果;
}

function 点击改变(ton,i){
	document.querySelectorAll("#" + ton + " div div div div")[0].style.width = (取容器宽度(ton,i) * 0.3) + "px";
	document.querySelectorAll("#" + ton + " div div div div")[0].style.left =  转换操作.到数值(取滑块位置(ton)) +  取容器宽度(ton,i) * 0.33 + "px";
}

function 取滑块位置(ton){
	return 文本操作.子文本替换(document.querySelectorAll("#" + ton + " div div div div")[0].style.left,"px","");
}

function 取容器宽度(ton,i){
	return document.querySelectorAll("#" + ton + " div div a")[i].offsetWidth;
}
window["公用模块"]["APP标题"]=APP标题;
window["公用模块"]["当前版本"]=当前版本;
window["公用模块"]["CMSAPI"]=CMSAPI;
window["公用模块"]["AdminGuanLi"]=AdminGuanLi;
window["公用模块"]["推荐分类"]=推荐分类;
window["公用模块"]["电影分类"]=电影分类;
window["公用模块"]["电视分类"]=电视分类;
window["公用模块"]["综艺分类"]=综艺分类;
window["公用模块"]["动漫分类"]=动漫分类;
window["公用模块"]["跳转QQ群"]=跳转QQ群;
window["公用模块"]["跳转QQ"]=跳转QQ;
window["公用模块"]["聚合直播播放"]=聚合直播播放;
window["公用模块"]["直播播放"]=直播播放;
window["公用模块"]["影视播放"]=影视播放;
window["公用模块"]["运营模式标题"]=运营模式标题;
window["公用模块"]["xiazai"]=xiazai;
window["公用模块"]["取中间文本"]=取中间文本;
window["公用模块"]["点击改变"]=点击改变;
window["公用模块"]["取滑块位置"]=取滑块位置;
window["公用模块"]["取容器宽度"]=取容器宽度;
})();