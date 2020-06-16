mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 标题栏1 = new 标题栏("标题栏1",null,null,标题栏1_左侧图标被单击);
var CYS原生视频播放器1 = new CYS原生视频播放器("CYS原生视频播放器1",null,null,CYS原生视频播放器1_视频结束,null,null,null,null);
var 网络操作1 = new 网络操作("网络操作1",网络操作1_发送完毕);
var 正则1 = new 正则("正则1");
var sqlite数据库1 = new sqlite数据库("sqlite数据库1",sqlite数据库1_创建数据表完毕,sqlite数据库1_添加数据完毕,null,null,sqlite数据库1_查询数据完毕,null);
var sqlite数据库2 = new sqlite数据库("sqlite数据库2",sqlite数据库2_创建数据表完毕,sqlite数据库2_添加数据完毕,null,null,sqlite数据库2_查询数据完毕,null);
var 菜单1 = new 菜单("菜单1",null);
var 网络操作2 = new 网络操作("网络操作2",网络操作2_发送完毕);
var 标签1 = new 标签("标签1",null);
var 标签2 = new 标签("标签2",null);
var CYS导航栏1 = new CYS导航栏("CYS导航栏1",CYS导航栏1_项目被单击);
var 标签4 = new 标签("标签4",null);
var 伸缩简介框1 = new 伸缩简介框("伸缩简介框1",null);
var 标签3 = new 标签("标签3",标签3_被单击);
var 标签5 = new 标签("标签5",null);
var CYS悬浮文字导航1 = new CYS悬浮文字导航("CYS悬浮文字导航1",CYS悬浮文字导航1_项目被单击,null);
var CYS动画弹出式导航1 = new CYS动画弹出式导航("CYS动画弹出式导航1",CYS动画弹出式导航1_项目被单击);
var 仔仔1 = new 仔仔("仔仔1",null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
var 标签7 = new 标签("标签7",null);
var 标签6 = new 标签("标签6",标签6_被单击);
var 高级列表框1 = new 高级列表框("高级列表框1",true,true,false,高级列表框1_表项被单击);
var 网络操作3 = new 网络操作("网络操作3",null);
if(mui.os.plus){
    mui.plusReady(function() {
        Play_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        Play_创建完毕();
        
    }
}
var mui_back = mui.back;
mui.back = function() {
    if (Play_按下返回键()!=true) {
        mui_back();
    }
};

var 剧集标题;
var 剧集地址;
var 播放地址;
var 标记= 0;
var 背景颜色 = 读写设置.读取设置("背景颜色");
var 默认颜色 = 读写设置.读取设置("默认颜色");
var 激活颜色 = 读写设置.读取设置("激活颜色");
var name;
var img;
var msg;
var type;
var info;
var playlist;
var type_id;
var remarks;
var 轮播地址;
document.getElementById("CYS导航栏1").style.position = "relative";
	document.getElementById("CYS导航栏1").style.boxShadow = "none";
document.getElementById("标题栏1").style.background = 背景颜色;
document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色;

function Play_创建完毕(){
	CYS悬浮文字导航1.置选中认文本颜色("#000000");
	CYS悬浮文字导航1.置默认文本颜色("#909095");
	CYS悬浮文字导航1.置分割线颜色("#ffffff");
	CYS悬浮文字导航1.置滑块颜色("#ffffff");
	CYS悬浮文字导航1.置现行选中项(标记);

	CYS导航栏1.添加项目("下载","images/play/ic_common_download.png");
	CYS导航栏1.添加项目("收藏","images/play/ic_common_collect_gray_normal.png");
	CYS导航栏1.添加项目("帮助","images/play/ic_common_reply.png");
	CYS导航栏1.添加项目("分享","images/play/ic_common_share.png");
	CYS导航栏1.添加完毕();





if (sqlite数据库1.打开数据库("mydatabase1",1024*1024) == true){
	if (读写设置.读取设置("数据表") != "已创建" ){
		sqlite数据库1.创建数据表("mytable1","liebiao text,leixing text,biaoti text,tupian text,dizhi text,shijian integer")}
	console.log("打开数据库成功");
	}else{
	console.log("打开数据库失败");
	}
if (sqlite数据库2.打开数据库("mydatabase22",1024*1024) == true){
	if (读写设置.读取设置("数据表2") != "已创建" ){
		sqlite数据库2.创建数据表("mytable22","liebiao text,leixing text,biaoti text,tupian text,dizhi text,shijian integer");
	}
	console.log("打开数据库2成功");
}else{
	console.log("打开数据库2失败");
	}

	if (读写设置.读取设置("视频来源") == "资源站" || 读写设置.读取设置("视频来源") == "视频收藏" || 读写设置.读取设置("视频来源") == "视频记录"){网络操作1.发送网络请求(公用模块.CMSAPI() + "/api.php/provide/vod/?ac=detail&ids=" + 读写设置.读取设置("视频ID"),"get","txt","",12000)}
	if (读写设置.读取设置("视频来源") == "直播"){开始播放(读写设置.读取设置("视频ID"),读写设置.读取设置("视频标题"))}
	if(读写设置.读取设置("视频来源") == "直播" ){
		标签1.置标题("剧名："+读写设置.读取设置("视频标题"));
		伸缩简介框1.置内容("直播："+读写设置.读取设置("视频标题"));
		CYS悬浮文字导航1.添加项目("直播",读写设置.读取设置("视频ID"));
		CYS动画弹出式导航1.添加项目(读写设置.读取设置("视频标题"),"images/ic_player_center_start.png",读写设置.读取设置("视频ID"),true);
	}
	高级列表框1.置图片尺寸("70px","90px");
	初始化广告();

}
function 初始化广告(){
	var 截取= 读写设置.读取设置("轮播广告4");

	var index = 0;
	正则1.创建正则(截取,"<a>img=\"(.*?)\"title=\"(.*?)\"href=\"(.*?)\"</a>");
	while(index != 5){
		标签6.置标题("<img src=" + 正则1.取子匹配文本(index,1) + " style='width: 100%;height:80px;margin: 0px 0px 0px 0px;' />");
		轮播地址 = 正则1.取子匹配文本(index,3);
		index = index + 1;
	}
	}
function 网络操作1_发送完毕(发送结果,返回信息){
	var json = 转换操作.文本转json(返回信息);
	console.log(json);

	if (发送结果 == true){
		mui.each(json.list,function(索引,成员){
			name = 成员.vod_name;
			img = 成员.vod_pic;
			msg = 成员.vod_remarks;
			type = 成员.vod_class;
			info = 成员.vod_content;
			type_id = 成员.type_id;
			playlist = 成员.vod_play_url;
			remarks = 成员.vod_remarks;
			if(info== ""){
				info="暂无简介.";
			}
		})
		标签1.置标题("剧名："+name);
		标签2.置标题(type+"/"+msg);
		伸缩简介框1.置内容(info);
		伸缩简介框1.置字体颜色("#808080");
		读写设置.保存设置("视频标题",name);
		读写设置.保存设置("视频图片",img);
		读写设置.保存设置("视频来源","资源站");
		标签3.置标题("<div id=标签3 style='width: 100%;;margin:20px 0px 0px 0px;'><div id=标签3 style='float: left;color:#808080; width: 20%;z-index: 999;'>剧集：</div><div id=content style='float: right;color:#808080; z-index: 999;'><div id=注册 >"+remarks+"></div></div><br>");

		标题栏1.置标题("<h1 style='font-size: 15px;margin:15px 200px 0px 0px;color:" + 激活颜色 + ";'>"+name+"</h1>");

		var i = 0;
		if(文本操作.寻找文本(playlist,"$",0)==-1 ){
			数组操作.加入尾成员(剧集地址,playlist);
		}else{
			正则1.创建正则(playlist,"(.*?)\\$(.*?).m3u8");
			while(i != 正则1.取匹配数量()){
				数组操作.加入尾成员(剧集标题,文本操作.子文本替换(正则1.取子匹配文本(i,1),"#",""));
				数组操作.加入尾成员(剧集地址,正则1.取子匹配文本(i,2) + ".m3u8");
				CYS悬浮文字导航1.添加项目(文本操作.子文本替换(正则1.取子匹配文本(i,1),"#",""),正则1.取子匹配文本(i,2) + ".m3u8");
				CYS动画弹出式导航1.添加项目(文本操作.子文本替换(正则1.取子匹配文本(i,1),"#",""),img,正则1.取子匹配文本(i,2),true);
				i = i + 1;
			}
		}
		网络操作2.发送网络请求(公用模块.CMSAPI() + "/api.php/provide/vod/?ac=detail&t="+type_id,"get","txt","",12000);
		开始播放(CYS悬浮文字导航1.取项目标记(标记),"");
	}else{
		网络操作1.发送网络请求(公用模块.api()+"/api.php/provide/vod/?ac=detail&ids="+读写设置.读取设置("标记"),"get","txt","",5000);
	}
}

function 标签3_被单击(){
	CYS动画弹出式导航1.弹出();
}

function CYS悬浮文字导航1_项目被单击(项目索引){
	标记 = 项目索引;
	CYS原生视频播放器1.销毁播放器();
	开始播放(CYS悬浮文字导航1.取项目标记(标记),"");
}
function CYS动画弹出式导航1_项目被单击(项目索引){
	标记 = 项目索引;
	CYS悬浮文字导航1.置现行选中项(项目索引);
	CYS原生视频播放器1.销毁播放器();
	开始播放(CYS悬浮文字导航1.取项目标记(标记),"");
	CYS动画弹出式导航1.关闭();
}

function CYS原生视频播放器1_视频结束(){
	标记 = 标记+1;
	CYS悬浮文字导航1.置现行选中项(标记);
	CYS原生视频播放器1.销毁播放器();
	开始播放(CYS悬浮文字导航1.取项目标记(标记),"");
}
function 开始播放(地址,标题){
	播放地址 = 地址;
	sqlite数据库2.查询数据("mytable22","biaoti='" + 读写设置.读取设置("视频标题")+ "'");
	CYS原生视频播放器1.销毁播放器();

	if (读写设置.读取设置("视频来源") == "直播"){
		CYS原生视频播放器1.初始化(地址,"","contain",0,true,false,false,true,true,true,true,true,true,0,true,true,0,"13.22rem");
	}else{
		if (读写设置.读取设置("自动播放") == "真"){
		    CYS原生视频播放器1.初始化(地址,"","contain",0,true,false,false,true,true,true,true,true,true,-90,true,true,0,"13.22rem");
	    }else{
		    CYS原生视频播放器1.初始化(地址,"","contain",0,false,false,false,true,true,true,true,true,true,-90,false,false,0,"13.22rem");
	    }
	}

}

function Play_按下返回键(){
	plus.webview.close("play.html","slide-out-right");
}
function sqlite数据库2_创建数据表完毕(结果){
if (结果 == true){读写设置.保存设置("数据表2","已创建"),console.log("创建数据表2成功")}else{读写设置.保存设置("数据表2","未创建"),console.log("创建数据表2失败")}
}
function sqlite数据库2_查询数据完毕(结果,数量,数据){
sqlite数据库2.删除数据("mytable22","biaoti='" + 读写设置.读取设置("视频标题") + "'");
sqlite数据库2.添加数据("mytable22",["liebiao",读写设置.读取设置("视频来源"),读写设置.读取设置("视频标题"),读写设置.读取设置("视频图片"),读写设置.读取设置("视频ID"),标记+1]);
	return;
}
function sqlite数据库1_查询数据完毕(结果,数量,数据){
sqlite数据库1.删除数据("mytable1","biaoti='" + 读写设置.读取设置("视频标题") + "'");
sqlite数据库1.添加数据("mytable1",["liebiao",读写设置.读取设置("视频来源"),读写设置.读取设置("视频标题"),读写设置.读取设置("视频图片"),读写设置.读取设置("视频ID"),标记+1]);
	return;
}
function sqlite数据库2_添加数据完毕(结果){
if( 结果 == true){console.log("添加播放记录成功")}else{console.log("添加播放记录失败")}
}
function sqlite数据库1_创建数据表完毕(结果){
if (结果 == true){读写设置.保存设置("数据表","已创建"),console.log("创建数据表成功")}else{读写设置.保存设置("数据表","未创建"),console.log("创建数据表失败")}
}
function sqlite数据库1_添加数据完毕(结果){
if( 结果 == true){mui.toast("收藏成功")}else{mui.toast("收藏失败")}
}

function CYS导航栏1_项目被单击(项目索引){
	switch(项目索引){
		case 0 :
			CYS原生视频播放器1.暂停();
			窗口操作.预加载窗口("xiazai.html"),窗口操作.取指定窗口("xiazai.html").show("slide-in-right", 300);
		break;
		case 1 :
			sqlite数据库1.查询数据("mytable1","biaoti='" + 读写设置.读取设置("视频标题") + "'");
		break;
		case 2 :
			窗口操作.打开指定网址(播放地址,2);

		break;
		case 3 :
			仔仔1.命令_调用系统分享("我正在观看："+读写设置.读取设置("视频标题"),"下载地址："+读写设置.读取设置("下载地址"));
		break;
	}
}
function 网络操作2_发送完毕(发送结果,返回信息){
	if (发送结果 == true){
	var index = 0;
	var json = 转换操作.文本转json(返回信息);

	var 视频列表标题= new Array();
	var 视频列表图片= new Array();
	var 视频列表地址= new Array();
	var 视频列表评分= new Array();
	var 视频列表msg= new Array();

	mui.each(json.list,function(索引,成员){
	数组操作.加入尾成员(视频列表标题,成员.vod_name);
	数组操作.加入尾成员(视频列表图片,成员.vod_pic);
	数组操作.加入尾成员(视频列表地址,成员.vod_id);
	if (成员.vod_remarks == ""){成员.vod_remarks = "暂无详情"}
	数组操作.加入尾成员(视频列表msg,成员.vod_remarks)});

	while(index < 4){
		高级列表框1.添加项目(视频列表图片[index],视频列表标题[index],视频列表msg[index],视频列表地址[index]);
		index = index + 1;
	}
	}
}

function 高级列表框1_表项被单击(项目索引,项目图片,项目标题,项目信息,项目标记){
	高级列表框1.清空项目();
	CYS悬浮文字导航1.清空项目();
	CYS动画弹出式导航1.清空();
	网络操作1.发送网络请求(公用模块.CMSAPI() + "/api.php/provide/vod/?ac=detail&ids=" + 项目标记,"get","txt","",12000);
	窗口操作.滚动到顶部();

}

function 标签6_被单击(){
	if (文本操作.寻找文本(轮播地址,"http",0) != -1){
		窗口操作.打开指定网址(轮播地址,2);
	}else{
		高级列表框1.清空项目();
		CYS悬浮文字导航1.清空项目();
		CYS动画弹出式导航1.清空();
		网络操作1.发送网络请求(公用模块.CMSAPI() + "/api.php/provide/vod/?ac=detail&ids=" + 轮播地址,"get","txt","",12000);
		窗口操作.滚动到顶部();
	}
}

function 标题栏1_左侧图标被单击(){
	plus.webview.close("play.html","slide-out-right");
}