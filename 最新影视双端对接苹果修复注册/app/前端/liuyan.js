mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}
,pullRefresh:{container: "#pullRefreshContainer",down:{callback:下拉刷新1_下拉刷新开始},up:{callback:null}}});

var 标题栏1 = new 标题栏("标题栏1",null,null,标题栏1_左侧图标被单击);
var 下拉刷新1 = new 下拉刷新("下拉刷新1");
var 网络操作1 = new 网络操作("网络操作1",网络操作1_发送完毕);
var 网络操作2 = new 网络操作("网络操作2",网络操作2_发送完毕);
var 编辑框1 = new 编辑框("编辑框1",null,null,null,null,null);
var 标签1 = new 标签("标签1",标签1_被单击);
var 高级列表框1 = new 高级列表框("高级列表框1",false,true,false,null);
if(mui.os.plus){
    mui.plusReady(function() {
        Liuyan_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        Liuyan_创建完毕();
        
    }
}
var mui_back = mui.back;
mui.back = function() {
    if (Liuyan_按下返回键()!=true) {
        mui_back();
    }
};

var 页码 = 1;
var 背景颜色 = 读写设置.读取设置("背景颜色");
var 默认颜色 = 读写设置.读取设置("默认颜色");
var 激活颜色 = 读写设置.读取设置("激活颜色");
var 搜索颜色 = 读写设置.读取设置("搜索颜色");
document.getElementById("标题栏1").style.background = 背景颜色;
document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色;
document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>留言反馈</h1>";
function Liuyan_创建完毕(){
	高级列表框1.置图片尺寸("0px","0px");
	网络操作2.发送网络请求(公用模块.AdminGuanLi() + "/api.php?action=cxmessage","post","txt","&username=" + 读写设置.读取设置("用户帐号")+ "&token=" + 读写设置.读取设置("用户token"),5000);
	标签1.置标题("<button id=登录 class='btn' style='width: 95%;height: 35px;border-radius: 2px;background: "+背景颜色+";color: #FFF;font-size: 15px;font-family: 黑体;color:#fff;font-size:14px;margin:20px 0px 0px 0px;padding:0px;text-align:center'>提交</button>");
}
function 下拉刷新1_下拉刷新开始(){
	网络操作2.发送网络请求(公用模块.AdminGuanLi() + "/api.php?action=cxmessage","post","txt","&username=" + 读写设置.读取设置("用户帐号")+ "&token=" + 读写设置.读取设置("用户token"),5000);
}
function 标签1_被单击(){
	开始提交(编辑框1.取内容(),读写设置.读取设置("用户token"));
}
function 开始提交(index1,index2){
	console.log(index1,index2);
	if (index1 != "" && index1 != null){
	网络操作1.发送网络请求(公用模块.AdminGuanLi() + "/api.php?action=message","post","txt","&username=" + 读写设置.读取设置("用户帐号")+ "&token=" + index2+"&txt="+index1,5000);
	}else{
		mui.toast("请填写完整");
	}
}

function 网络操作1_发送完毕(发送结果,返回信息){
	if(文本操作.寻找文本(返回信息,"200",0)!=-1 ){
		高级列表框1.清空项目();
		高级列表框1.添加项目(公用模块.AdminGuanLi() + 读写设置.读取设置("pic"),"我："+编辑框1.取内容(),"","");
		对话框1.弹出提示("留言成功");
	}
}

function 网络操作2_发送完毕(发送结果,返回信息){
	var json = 转换操作.文本转json("["+返回信息+"]");
	console.log(json);
	高级列表框1.清空项目();
	if (发送结果 == true){
		mui.each(json,function(索引,成员){
			var 反馈 = 成员.title;
			var 回复  = 成员.content;
			if(回复=="" ){
				回复 ="暂未回话~";

			}
			高级列表框1.添加项目("","我："+反馈,"客服："+回复,"");
		})
		编辑框1.置内容(null);
		下拉刷新1.停止下拉刷新();
	}else{

	}
}

function 标题栏1_左侧图标被单击(){
var self = plus.webview.currentWebview();
	plus.webview.close(self,"slide-out-right");
}

function Liuyan_按下返回键(){
var self = plus.webview.currentWebview();
	plus.webview.close(self,"slide-out-right");
}