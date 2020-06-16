mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 标题栏1 = new 标题栏("标题栏1",null,标题栏1_右侧图标被单击,标题栏1_左侧图标被单击);
var sqlite数据库2 = new sqlite数据库("sqlite数据库2",sqlite数据库2_创建数据表完毕,sqlite数据库2_添加数据完毕,null,null,sqlite数据库2_查询数据完毕,null);
var 标签1 = new 标签("标签1",null);
if(mui.os.plus){
    mui.plusReady(function() {
        Jilu_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        Jilu_创建完毕();
        
    }
}
var mui_back = mui.back;
mui.back = function() {
    if (Jilu_按下返回键()!=true) {
        mui_back();
    }
};

窗口操作.引入css文件("files/yi9shoucang.css");
var 视频来源 = new Array();
var 视频标题 = new Array();
var 视频图片 = new Array();
var 视频地址 = new Array();
var 视频总时间 = new Array();
var 是否开启 = false;
var 背景颜色 = 读写设置.读取设置("背景颜色");
var 默认颜色 = 读写设置.读取设置("默认颜色");
var 激活颜色 = 读写设置.读取设置("激活颜色");
document.getElementById("标题栏1").style.background = 背景颜色;
document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色;
document.querySelectorAll("#标题栏1 a")[1].style.color = 背景颜色;
document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>播放记录</h1>";
document.querySelectorAll("#标题栏1 a")[1].innerHTML = "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + "'>编辑</h1>";
function Jilu_创建完毕(){
	if (sqlite数据库2.打开数据库("mydatabase22",1024*1024) == true){
		if (读写设置.读取设置("数据表2") != "已创建" ){
			sqlite数据库2.创建数据表("mytable22","liebiao text, laiyuan text, biaoti text, tupian text, dizhi text, shijian integer");
		}
		console.log("打开数据库2成功");
	}else{
		console.log("打开数据库2失败");
	}
	sqlite数据库2.查询数据("mytable22","liebiao='liebiao'");

	var div = document.createElement("div");
			div.innerHTML = "<div style='position: fixed;bottom: 10px;width: 100%;'><ul id=横排列表框 style='margin:0px 0px 0px 0px; padding: 0px 0px 0px 0px;display:none' >"+
			"<li style='padding: 0;width: 50%;height: auto;background-color: rgba(255,255,255,.1);display: inline-table;text-align: -webkit-center;margin: 0;' data-index='0'><p style='background:#0088FF; color: #FFF; height:40px; font-size: 13px;padding: 10px 0 0 0; margin: 0 5px 0 15px;'>点击选项删除</p></li>"+
			"<li style='padding: 0;width: 50%;height: auto;background-color: rgba(255,255,255,.1);display: inline-table;text-align: -webkit-center;margin: 0;' data-index='1'><p style='background:#FF0000; color: #FFF; height:40px; font-size: 13px;padding: 10px 0 0 0; margin: 0 15px 0 5px;'>全部删除</p></li>"+
			"</ul></div>";
		document.body.appendChild(div);
		document.body.querySelectorAll("div")[0].insertBefore(div, document.body.nextSibling);
		mui("#横排列表框").on("tap", "li", function() { 开始删除(this.getAttribute("data-index"));});

}


function sqlite数据库2_创建数据表完毕(结果){
	if (结果 == true){
		读写设置.保存设置("数据表2","已创建");
		console.log("创建数据表成功");
	}else{
		读写设置.保存设置("数据表2","未创建");
		console.log("创建数据表失败");
	}
}

function sqlite数据库2_查询数据完毕(结果,数量,数据){
	数组操作.清空数组(视频来源);
	数组操作.清空数组(视频标题);
	数组操作.清空数组(视频图片);
	数组操作.清空数组(视频地址);
	数组操作.清空数组(视频总时间);
	var html = "<ul class='mui-table-view' style='padding: 0;margin-top:0rem' id=播放记录框>";
	if(结果 == true ){
		var index= 0;
		while(index < 数量){
			数组操作.加入尾成员(视频来源,数据[index].laiyuan);
			数组操作.加入尾成员(视频标题,数据[index].biaoti);
			数组操作.加入尾成员(视频图片,数据[index].tupian);
			数组操作.加入尾成员(视频地址,数据[index].dizhi);
			数组操作.加入尾成员(视频总时间,数据[index].shijian);
			html += " <li class='mui-table-view-cell'  data-index='" + index + "'><img src=" + 视频图片[index] + " style='width: 80px;height: 100px; border-radius: 3px;' />"+
						"<div class='listdiv'><span class='listspan1'>" + 视频标题[index] + "</span>"+
						"<p class='listp'>观看至" + 视频总时间[index] + " 集</p><div class='listdiv1'></div>"+
						"</div></li>";
			 index = index + 1;
		}
		html += "</ul>";
		标签1.置标题(html);
		mui("#播放记录框").on("tap", "li", function() {跳转播放(this.getAttribute("data-index"));});
		console.log("查询数据成功");
	}else{
		console.log("查询数据失败");
	}

}

function 跳转播放(index){
	if (是否开启 == false){
		读写设置.保存设置("视频来源","视频记录");
		读写设置.保存设置("视频图片",视频图片[index]);
		公用模块.影视播放(视频标题[index],视频地址[index]);
	}
	if (是否开启 == true){
		sqlite数据库2.删除数据("mytable22","biaoti='" + 视频标题[index] + "'");
		sqlite数据库2.查询数据("mytable22","liebiao='liebiao'");
	}
}

function 标题栏1_左侧图标被单击(){
	var self = plus.webview.currentWebview();
	    plus.webview.close(self,"slide-out-right");
}

function Jilu_按下返回键(){
	var self = plus.webview.currentWebview();
	    plus.webview.close(self,"slide-out-right");
		return;
}

function sqlite数据库2_添加数据完毕(结果){
	if(结果 == true ){
		console.log("添加数据成功");
	}else{
		console.log("添加数据失败");
	}
}

function 标题栏1_右侧图标被单击(){
	if (是否开启 == false){

		document.getElementById("横排列表框").style.display = "block";
		document.querySelectorAll("#标题栏1 a")[1].innerHTML = "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + "'>取消</h1>";
		是否开启 = true;
	}else{
		document.getElementById("横排列表框").style.display = "none";
		document.querySelectorAll("#标题栏1 a")[1].innerHTML = "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + "'>编辑</h1>";
		是否开启 = false;
	}
}

function 开始删除(i){
	if (i == 0){
		mui.toast("直接点击选项删除");
	}
	if (i == 1){
		sqlite数据库2.删除数据("mytable22","liebiao='liebiao'");
		sqlite数据库2.查询数据("mytable22","liebiao='liebiao'");
	}
}