mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 标题栏1 = new 标题栏("标题栏1",null,null,标题栏1_左侧图标被单击);
var 渐渐下载列表框1 = new 渐渐下载列表框("渐渐下载列表框1",渐渐下载列表框1_项目被单击);
var 网络操作1 = new 网络操作("网络操作1",网络操作1_发送完毕);
var 下载器1 = new 下载器("下载器1",下载器1_下载进度改变,下载器1_下载完毕);
var 仔仔1 = new 仔仔("仔仔1",null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
var 左右滑动面板1 = new 左右滑动面板("左右滑动面板1",null,null);
var 对话框1 = new 对话框("对话框1",null,对话框1_询问框被单击,null);
if(mui.os.plus){
    mui.plusReady(function() {
        spxiazai_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        spxiazai_创建完毕();
        
    }
}
var mui_back = mui.back;
mui.back = function() {
    if (spxiazai_按下返回键()!=true) {
        mui_back();
    }
};

var 背景颜色 = 读写设置.读取设置("背景颜色");
var 默认颜色 = 读写设置.读取设置("默认颜色");
var 激活颜色 = 读写设置.读取设置("激活颜色");
var 搜索颜色 = 读写设置.读取设置("搜索颜色");
var 地址 = new Array();
var 标题 = new Array();
var i= 0;
var xiazai= false;
var 程序集_任务对象;
document.getElementById("标题栏1").style.background = 背景颜色;
document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色;
document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>"+读写设置.读取设置("下载标题")+"</h1>";

function spxiazai_创建完毕(){
	网络操作1.发送网络请求(读写设置.读取设置("下载地址"),"get","txt","",12000);
	主题信息();
}
function spxiazai_按下返回键(){
	if(xiazai ==true ){
		对话框1.询问框("提示：","还有视频还未下载完成,是否现在退出？","退出","再等等");
	}else{
		plus.webview.close("spxiazai.html","slide-out-right");
		return;
	}
}
function 主题信息(){
	document.getElementById("标题栏1").style.background = 背景颜色;
	document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色;
	document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'></h1>";
}
function 标题栏1_左侧图标被单击(){
	if(xiazai ==true ){
		对话框1.询问框("提示：","还有视频还未下载完成,是否现在退出？","退出","再等等");
	}else{
		plus.webview.close("spxiazai.html","slide-out-right");
		return;
	}
}
function 网络操作1_发送完毕(发送结果,返回信息){
	if(发送结果 == true ){
		返回信息 = 文本操作.删全部空(返回信息);
		var 文本 = 文本操作.取指定文本(返回信息,"<spanclass=\"suf\">迅雷下载</span></h3><ul>","</ul>");
		var 截取 = 文本操作.取指定文本(文本[0],"<li>","</li>");
			var index = 0;
			while(index != 数组操作.取成员数(截取)){
				var URL  = 公用模块.取中间文本(截取[index],"value=\"","\"");
				var BT  = 读写设置.读取设置("下载标题")+ "："+公用模块.取中间文本(截取[index],"/>","$");
				数组操作.加入尾成员(地址,URL);
				数组操作.加入尾成员(标题,URL);
				渐渐下载列表框1.添加项目("","5px",BT,"#000000","0","100","0M/未知M","","#000000",URL);
				index = index + 1;
		}
	}
}

function 渐渐下载列表框1_项目被单击(表项索引){
	if(xiazai ==false ){
		i  = 表项索引;
		渐渐下载列表框1.置标题颜色(表项索引 ,"#0088FF");
		渐渐下载列表框1.置标签颜色(表项索引 ,"#0077FF");
		程序集_任务对象 = 下载器1.创建任务(地址[i]);
		渐渐下载列表框1.置项目标签1(i,"正在解析下载地址...");
	}else{
		mui.toast("只能创建一个任务");
	}
}

function 下载器1_下载进度改变(任务对象){
	xiazai = true;
	var 总大小= 下载器1.取文件总大小(任务对象);
	总大小 =  数学操作.取整数(总大小/1048576);
	var 下载= 下载器1.取已下载大小(任务对象);
	下载 =  数学操作.四舍五入(下载/1048576,2);
	渐渐下载列表框1.置项目最大进度(i,总大小);
	if(渐渐下载列表框1.取进度条位置(i) < 101 ){
		渐渐下载列表框1.置项目进度(i,下载);
		渐渐下载列表框1.置项目标签1(i,"已下载：" +  下载 + "M,总大小：" + 总大小+"M");
	}


}
function 下载器1_下载完毕(下载结果,任务对象){
	if(下载结果 == true ){
		xiazai = false;
		渐渐下载列表框1.置项目标签1(i,"下载完成："+下载器1.取本地路径2(任务对象));
	}else{
		mui.toast("下载失败");
	}
}


function 对话框1_询问框被单击(按钮索引){
	switch(按钮索引){
		case 0 :
			下载器1.取消任务(程序集_任务对象);
			plus.webview.close("spxiazai.html","slide-out-right");
			return;
		break;
	}
}